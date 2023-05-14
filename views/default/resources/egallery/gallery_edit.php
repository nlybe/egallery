<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$guid = elgg_extract('guid', $vars, '');
$entity = get_entity($guid);

if ( $entity instanceof \EntityGallery && $entity->canEdit() ) {    // guid is of EntityGallery object
    $egallery = $entity;
    $container = $egallery->getContainerentity();
}
else if ( $entity instanceof \ElggEntity && $entity->canEdit() ) {  // guid is of ElggEntity so get it's gallery (if exists) or create a new one
    $egallery = EntityGallery::getGallery($entity);
    $container = $entity;
}
else {
    echo elgg_format_element('div', ['class'=>'elgg-module elgg-module-error'], elgg_echo('egallery:invalid')); 
    return;
}


if ($egallery instanceof \EntityGallery) {
    $vars = entity_gallery_prepare_form_vars($container, $egallery);
}
else {
    $vars = entity_gallery_prepare_form_vars($container);
}

// create form
$form_vars = ['name' => 'entity_gallery', 'enctype' => 'multipart/form-data'];
echo elgg_view_form('egallery/gallery_edit', $form_vars, $vars);
