<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\EgalleryOptions;

elgg_require_js('egallery/gallery');

$egallery = elgg_extract('gallery', $vars, '');
if (!$egallery instanceof \EntityGallery) {
    return;
}

$images = elgg_extract('images', $vars, '');
if (!$images) {
    $images = $egallery->getGalleryImages();
}

if (!$images) {
    return;
}

$cover = $egallery->getGalleryCoverImage();
$thumb_size = elgg_extract('thumb_size', $vars, 'small');
$output = '<ul id="'.EgalleryOptions::DEFAULT_CAT.'" class="elgg-gallery elgg-egallery elgg-showcase-screenshots">';

foreach ($images as $file) {
    $li_options = ['id' => 'pgi_'.$file->getGUID()];
    $li_options['class'] = $thumb_size;
    if ($file->guid == $cover->guid) {
        $li_options['class'] = "elgg-showcase-screenshot-cover " . $thumb_size;
    }        
    $vars['p_gallery_item'] = $file;
    $output .= elgg_format_element('li', $li_options, elgg_view('egallery/gallery_item', $vars));    
}
$output .= '</ul>';
echo $output;

