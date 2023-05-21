<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\EgalleryOptions;

// get entity
$guid = elgg_extract('guid', $vars, '');
elgg_entity_gatekeeper($guid, 'object', 'entity_gallery');

$entity = get_entity($guid);
$vars['gallery_view'] = get_input('v');
$vars['gallery'] = $entity;

$container = $entity->getContainerEntity();
$sub = $container->getSubtype();
if (!EgalleryOptions::isEntityTypeGalleryEnabled($sub)) {
    elgg_error_response(elgg_echo('egallery:onject:disabled'));
    forward(REFERRER);
}

$owner = $entity->getOwnerEntity();
// elgg_push_breadcrumb(elgg_echo('egallery:breadcrumb:label', [$container->title]), $container->getURL());
elgg_push_collection_breadcrumbs('object', 'entity_gallery', $owner);
elgg_push_breadcrumb($entity->getDisplayName());

$vars['full_view'] = true;
$vars['show_responses'] = false;
$content = elgg_view_entity($entity, $vars);

echo elgg_view_page($entity->getDisplayName(), [
	'content' => $content,
	'filter_id' => '',
	'entity' => $entity,
	'sidebar' => '',
], 'default', [
	'entity' => $entity,
]);



