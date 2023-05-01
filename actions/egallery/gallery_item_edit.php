<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

// Get variables
$title = get_input("title");
$description = nl2br(get_input('description'));
$url = get_input("url");
$tags = get_input("tags");
$access_id = (int) get_input("access_id");
$guid = (int) get_input('guid');
$container_guid = get_input('container_guid', elgg_get_logged_in_user_guid());

elgg_make_sticky_form('egallery_item');

if (!$title) {
    return elgg_error_response(elgg_echo('egallery:item:save:missing_title'));
}

if ($url && !filter_var($url, FILTER_VALIDATE_URL)) {
	return elgg_error_response(elgg_echo('egallery:item:save:url_error'));
}

// check whether this is a new object or an edit
$new_entity = true;
if ($guid > 0) {
    $new_entity = false;
}

if ($guid == 0) {
    $entity = new GalleryItem;
    $entity->container_guid = $container_guid;
} else {
    $entity = get_entity($guid);
    if (!$entity->canEdit()) {
        return elgg_error_response(elgg_echo('egallery:invalid_access'));
    }
    
    if (!$title) {
        // user blanked title, but we need one
        $title = $entity->title;
    }    
}

$tagarray = string_to_tag_array($tags);

$entity->title = $title;
$entity->description = $description;
$entity->url = $url;
$entity->tags = $tagarray;
$entity->container_guid = $container_guid;
$entity->access_id = $access_id;

if ($entity->save()) {
    elgg_clear_sticky_form('egallery_item');
    return elgg_ok_response('', elgg_echo('egallery:item:save:success'), REFERER);
} 
else {
    return elgg_error_response(elgg_echo('egallery:item:save:failed'));
}


