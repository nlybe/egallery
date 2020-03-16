<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

elgg_require_js('egallery/photos_upload'); 

if (elgg_is_active_plugin('dropzonejs_api')) {
    $container_guid = elgg_extract('container_guid', $vars);
    $subtype = elgg_extract('subtype', $vars);

    echo elgg_view('input/dropzonejs', array(
        'name' => 'upload_guids',
        'accept' => "image/*",
        'max' => 25,
        'multiple' => true,
        // 'container_guid' => $container_guid, 
        'subtype' => $subtype, 
    ));
    
    echo elgg_view('input/hidden', array(
        'id' => 'container_guid',
        'name' => 'container_guid',
        'value' => $container_guid, 
    ));
    
    // the input below is used for triggering after successful uploads
    echo elgg_view('input/hidden', array(
        'name' => 'dropzone_upload_trigger',
        'value' => '', 
        'class' => 'dropzone_upload_trigger',
    ));
}

