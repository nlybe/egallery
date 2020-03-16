<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$guid = (int) get_input('guid');

$entity = get_entity($guid);
if (!elgg_instanceof($entity, 'object', GalleryItem::SUBTYPE)) {
    return elgg_error_response(elgg_echo('egallery:item:delete:failed'));
}

if (!$entity->canEdit()) {
    return elgg_error_response(elgg_echo('egallery:item:delete:failed'), $entity->getURL());
}

$icon_sizes = elgg_get_config('gallery_item_sizes'); 
foreach ($icon_sizes as $name => $size_info) {
    $file = new ElggFile();
    $file->owner_guid = $entity->owner_guid;
    $file->setFilename("gallery_item/".$entity->getGUID()."_".$name.".jpg");
    $filepath = $file->getFilenameOnFilestore();
    
    if (!$file->delete()) {
        elgg_log("Gallery item remove failed. Remove $filepath manually, please.", 'WARNING');
    }
}

// finally delete the original file
$file = get_entity($guid);
$file->owner_guid = $entity->owner_guid;
$file->setFilename(elgg_strtolower("$file->filestore_prefix/{$file->upload_time}{$file->originalfilename}"));

// finally delete the original file
if (!$file->delete()) {
    return elgg_error_response(elgg_echo('egallery:item:delete:failed'));
} else {
    system_message(elgg_echo("egallery:item:delete:success"));
}

forward(REFERER);
