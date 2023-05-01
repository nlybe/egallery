<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$guid = elgg_extract('guid', $vars, '');
$container = get_entity($guid);

if (!$container instanceof ElggEntity) {
    echo elgg_format_element('div', ['class'=>'elgg-module elgg-module-error'], elgg_echo('egallery:invalid')); 
}
else {
    // elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
    $egallery = EntityGallery::getGallery($container);
    // if (elgg_instanceof($egallery, 'object', EntityGallery::SUBTYPE)) {
    if ($egallery instanceof \EntityGallery) {
        $vars = entity_gallery_prepare_form_vars($container, $egallery);
    }
    else {
        $vars = entity_gallery_prepare_form_vars($container);
    }
    // create form
    $form_vars = array('name' => 'entity_gallery', 'enctype' => 'multipart/form-data');
    echo elgg_view_form('egallery/gallery_edit', $form_vars, $vars);
}


