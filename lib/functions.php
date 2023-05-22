<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

/**
 * Prepare gallery form inputs
 * 
 * @param type $egallery
 * @return type
 */
function entity_gallery_prepare_form_vars($container = null, $egallery = null) {
    // input names => defaults
    $values = [
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
    ];

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
    $values = [
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
    ];

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