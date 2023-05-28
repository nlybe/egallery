<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$guid = elgg_extract('guid', $vars, '');
$entity = get_entity($guid);

if ( !$entity instanceof \EntityGallery || !$entity->canEdit() ) {
    echo elgg_format_element('div', ['class'=>'elgg-module elgg-module-error'], elgg_echo('egallery:invalid')); 
    return;
}

// create form
$form_vars = ['name' => 'entity_gallery_import', 'enctype' => 'multipart/form-data'];
echo elgg_view_form('egallery/gallery_import', $form_vars, $vars);
