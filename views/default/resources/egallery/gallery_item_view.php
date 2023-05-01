<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

// get entity
$guid = elgg_extract('guid', $vars, 0);

$img = get_entity($guid);
if (!$img instanceof \GalleryItem) {
    forward('','404');
}

$size = elgg_extract('size', $vars, 'medium');
if ($size == 'original') {
    $img->setFilename($img->file_prefix . '.jpg');
}
else {
    $img->setFilename("gallery_item/".$img->getGUID() .'_'. $size . '.jpg');
}

$filename = $img->getFilenameOnFilestore();

$filesize = @filesize($filename);
if ($filesize) {
    header("Content-type: image/jpeg");
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', strtotime("+6 months")), true);
    header("Pragma: public");
    header("Cache-Control: public");
    header("Content-Length: $filesize");
    readfile($filename);
    exit;
}



