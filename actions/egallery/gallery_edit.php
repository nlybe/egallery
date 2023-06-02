<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

// Get variables
$title = get_input("title");
$description = nl2br(get_input('description'));
$tags = get_input("tags");
$guid = (int) get_input('guid');
$container_guid = get_input('container_guid', elgg_get_logged_in_user_guid());
$comments_on = get_input("comments_on");

// get the container entity
$container = get_entity($container_guid);

// get access id or assign according site default access and container
$access_level = get_default_access();
if ($container instanceof \ElggGroup) {
    $access_level = $container->group_acl;
}
$access_id = (int) get_input("access_id", $access_level);
            
elgg_make_sticky_form('entity_gallery');

if (!$title) {
    return elgg_error_response(elgg_echo('egallery:save:missing_title'));
}

$new_entity = false;
if ($guid == 0) {
    $entity = new EntityGallery;
    $entity->container_guid = $container_guid;
    
    // if no title on new upload, grab filename
    if (empty($title)) {
        $container = get_entity($container_guid);
        $title = EntityGallery::setGalleryTitle($container);
    }
    $new_entity = true;
} else {
    $entity = get_entity($guid);
    if (!$entity->canEdit()) {
        system_message(elgg_echo('egallery:invalid_access'));
        forward(REFERRER);
    }
    
    if (!$title) {
        // user blanked title, but we need one
        $title = $entity->title;
    }    
}

$entity->title = $title;
$entity->description = $description;
$entity->tags = elgg_string_to_array($tags);
$entity->container_guid = $container_guid;
$entity->comments_on = $comments_on;
$entity->access_id = $access_id;

if ($entity->save()) {
    elgg_clear_sticky_form('entity_gallery');

    //add to river only if new
    if ($new_entity) {
        elgg_create_river_item([
            'view' => 'river/object/entity_gallery/create',
            'action_type' => 'create',
            'object_guid' => $entity->guid,
        ]);
    }
    return elgg_ok_response('', elgg_echo('egallery:save:success'), $entity->getURL());
} 
else {
    return elgg_error_response(elgg_echo('egallery:save:failed'));
}


