<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\EgalleryOptions;

if (!EgalleryOptions::isImportFromTidypicsEnabled()) {
    system_message(elgg_echo('egallery:import:tidypics:egallery:invalid'));
    forward(REFERRER);
}

// Get variables
$guid = (int) get_input('guid');
$album_guids = get_input('album_guid');

$entity = get_entity($guid);
if ( !$entity instanceof \EntityGallery ) { 
    elgg_error_response(elgg_echo('egallery:import:tidypics:egallery:invalid'));
    forward(REFERRER);
}
if ( !$entity->canEdit() ) { 
    elgg_error_response(elgg_echo('egallery:invalid_access'));
    forward(REFERRER);
}

$album_id = is_array($album_guids)?$album_guids[0]:$album_guids;
$album = get_entity($album_id);
if ( !$album instanceof \TidypicsAlbum ) { 
    elgg_error_response(elgg_echo('egallery:import:tidypics:album:invalid'));
    forward(REFERRER);
}
if ( !$album->canEdit() ) { 
    elgg_error_response(elgg_echo('egallery:import:tidypics:album:invalid_access'));
    forward(REFERRER);
}

$images = elgg_get_entities([
    'type' => 'object',
    'subtype' => TidypicsImage::SUBTYPE,
    'container_guid' => $album->guid,
    'limit' => 0,
]);

$i = 0;
if (is_array($images) && sizeof($images) > 0) {
    foreach ($images as $image) {
        $i++;
        $pieces = explode("/", $image->getFilename());

        $file = new GalleryItem;
        $file->title = $image->title;
        $file->description = $image->description;
        $file->tags = $image->tags;
        $file->container_guid = $entity->guid;
        $file->time_updated = $image->time_updated;
        $file->time_created = $image->time_created;
        $file->access_id = $entity->access_id; 
        $file->originalfilename = $pieces[2];
        
        $prefix = 'gallery_item';
        $pieces = explode("/", $image->getFilename());
        $filename = elgg_strtolower("$prefix/{$pieces[2]}");
        $file->setFilename($filename);
        $file->filestore_prefix = $prefix;
        $filestorename = $file->getFilenameOnFilestore();
        $file->open('write');
		$file->close();
		copy($image->getFilenameOnFilestore(), $file->getFilenameOnFilestore());
        
        if ($file->save()) {                
            $icon_sizes = elgg_get_config('gallery_item_sizes'); 
            foreach ($icon_sizes as $name => $size_info) {   
                try {
                    $file->setFilename("gallery_item/".$file->getGUID()."_".$name.".jpg");
                    // touch file location in order to create the file
                    $file->open('write');
                    $file->close();

                    $resized = elgg_save_resized_image($filestorename, $file->getFilenameOnFilestore(), [
                        'w' => $size_info['w'], 
                        'h' => $size_info['h'], 
                        'square' => $size_info['square'], 
                        'upscale' => $size_info['upscale']
                    ]);
                } catch (Exception $e) {
                    if ($file->exists()) {
                        $file->delete();
                    }
                }        
            }
        }

    }
    return elgg_ok_response('', elgg_echo('egallery:import:tidypics:success', [$i]), $entity->getURL());
}
else {
    return elgg_error_response(elgg_echo('egallery:import:tidypics:fail'));
}

