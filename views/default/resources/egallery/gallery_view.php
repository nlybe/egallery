<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\EgalleryOptions;

// get entity
$guid = elgg_extract('guid', $vars, '');
$entity = get_entity($guid);

if (!$entity) {
    register_error(elgg_echo('egallery:invalid_access'));
    forward(REFERRER);
}

$vars['gallery_view'] = get_input('v');
$vars['gallery'] = $entity;

$container = $entity->getContainerEntity();
$sub = $container->getSubtype();
if (!EgalleryOptions::isEntityTypeGalleryEnabled($sub)) {
    elgg_error_response(elgg_echo('egallery:onject:disabled'));
    forward(REFERRER);
}

$title = $entity->title;
elgg_push_breadcrumb(elgg_echo('egallery:breadcrumb:label', [$container->title]), $container->getURL());
elgg_push_breadcrumb($title);

$content = elgg_view_entity($entity, [
    'full_view' => true,
    'show_responses' => false,
    ]);
$content .= elgg_view('egallery/gallery_images', $vars);

if ($container->canWriteToContainer(0, 'object', EntityGallery::SUBTYPE)) {
    $form_vars = array('name' => 'photos_upload', 'enctype' => 'multipart/form-data', 'class' => 'dropzone');
    $vars = array('container_guid' => $entity->getGUID(), 'subtype' => GalleryItem::SUBTYPE);
    $content .= elgg_view_form('egallery/photos_upload', $form_vars, $vars);
}

$body = elgg_view_layout('one_column', array(
    'content' => $content,
    'title' => $title,
    'filter' => '',
    'sidebar' => '',
));

echo elgg_view_page($title, $body);



