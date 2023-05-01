<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

// Get variables
$item_guid = get_input("item");

$item = get_entity($item_guid);
if (!$item instanceof \GalleryItem) {
    return elgg_error_response(elgg_echo('egallery:invalid_item'));
}

$p_gallery = $item->getContainerEntity();
if (!$p_gallery instanceof \EntityGallery) {
    return elgg_error_response(elgg_echo('egallery:invalid_gallery'));
}

if (!$p_gallery->canEdit()) {
    return elgg_error_response(elgg_echo('egallery:invalid_access'));
}

$p_gallery->cover_guid = $item->getGUID();

if ($p_gallery->save()) {
    return elgg_ok_response('', elgg_echo('egallery:set_cover:success'), REFERER);
} 
else {
    return elgg_error_response(elgg_echo('egallery:set_cover:failed'));
}

forward(REFERER);

