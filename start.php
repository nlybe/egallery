<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

require_once(dirname(__FILE__) . "/lib/hooks.php");
require_once(dirname(__FILE__) . "/lib/events.php");
require_once(dirname(__FILE__) . "/lib/widgets.php");

elgg_register_event_handler('init', 'system', 'egallery_init');
 
/**
 * egallery plugin initialization functions.
 */
function egallery_init() {  
	
    // extend css
    elgg_extend_view('css/elgg', 'egallery/egallery.css');

    // add option menu of entities
    elgg_register_plugin_hook_handler('register', 'menu:entity', 'egallery_entity_menu_setup', 400);

    // Register a URL handler for entity galleries
    elgg_register_plugin_hook_handler('entity:url', 'object', 'egallery_object_set_url');

    // create gallery items from items uploaded
    elgg_register_plugin_hook_handler('upload:after', 'dropzonejs_api', 'egallery_item_upload');

    // appends connected entities to entity's full view
    elgg_register_plugin_hook_handler('view_vars', 'object/elements/full', 'egallery_filter_full_view_vars');

    // set cover sizes
    elgg_set_config('gallery_item_sizes', [
        'tiny' => ['w' => 40, 'h' => 40, 'square' => true, 'upscale' => false],
        'small' => ['w' => 100, 'h' => 100, 'square' => true, 'upscale' => false],
        'medium' => ['w' => 200, 'h' => 200, 'square' => true, 'upscale' => false],
        'large' => ['w' => 600, 'h' => 600, 'square' => false, 'upscale' => false],
        'master' => ['w' => 1300, 'h' => 1300, 'square' => false, 'upscale' => false],
        'original' => ['w' => 2048, 'h' => 2048, 'square' => false, 'upscale' => false],
    ]); 
}

/**
 * Prepare gallery form inputs
 * 
 * @param type $egallery
 * @return type
 */
function entity_gallery_prepare_form_vars($container = null, $egallery = null) {
    // input names => defaults
    $values = array(
        'title' => '',
        'description' => '',
        'cover_guid' => '',
        'tags' => '',
        'access_id' => get_default_access(),
        'owner_guid' => elgg_get_page_owner_guid(),
        'container_guid' => $container?$container->guid:elgg_get_page_owner_guid(),
        'entity' => $egallery,
        'guid' => null,
        'comments_on' => NULL,
    ); 

    if ($egallery) {
        foreach (array_keys($values) as $field) {
            if (isset($egallery->$field)) {
                $values[$field] = $egallery->$field;
            }
        }
    }

    if (elgg_is_sticky_form('entity_gallery')) {
        $sticky_values = elgg_get_sticky_values('entity_gallery');
        foreach ($sticky_values as $key => $value) {
            $values[$key] = $value;
        }
    }

    elgg_clear_sticky_form('entity_gallery');

    return $values;
}

/**
 * Prepare gallery item form inputs
 * 
 * @param type $entity
 * @return type
 */

function entity_gallery_item_prepare_form_vars($entity = null) {
    // input names => defaults
    $values = array(
        'title' => '',
        'description' => '',
        'url' => '',
        // 'category' => '',
        'tags' => '',
        'access_id' => get_default_access(),
        'owner_guid' => elgg_get_page_owner_guid(),
        'container_guid' => elgg_get_page_owner_guid(),
        'entity' => $entity,
        'guid' => null,
    ); 

    if ($entity) {
        foreach (array_keys($values) as $field) {
            if (isset($entity->$field)) {
                $values[$field] = $entity->$field;
            }
        }
    }

    if (elgg_is_sticky_form('egallery_item')) {
        $sticky_values = elgg_get_sticky_values('egallery_item');
        foreach ($sticky_values as $key => $value) {
            $values[$key] = $value;
        }
    }

    elgg_clear_sticky_form('egallery_item');

    return $values;
}