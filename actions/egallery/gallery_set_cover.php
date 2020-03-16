<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

// Get variables
$item_guid = get_input("item");

$item = get_entity($item_guid);
if (!elgg_instanceof($item, 'object', GalleryItem::SUBTYPE)) {
    return elgg_error_response(elgg_echo('egallery:invalid_item'));
}

$p_gallery = $item->getContainerEntity();
if (!elgg_instanceof($p_gallery, 'object', EntityGallery::SUBTYPE)) {
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

