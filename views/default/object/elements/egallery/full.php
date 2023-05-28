<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\EgalleryOptions;

if (elgg_in_context('activity')) {
    return;
}

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \ElggEntity) {
    return;
}

$sub = $entity->getSubtype();
if (EgalleryOptions::isEntityTypeGalleryEnabled($sub)) {
    $gallery = EntityGallery::getGallery($entity);
    if ($gallery) {
        $images = $gallery->getGalleryImages();

        if ($images) {  // display module only if images exist
            $title = $gallery->title?$gallery->title:elgg_echo('egallery:photos:view:title');
            $vars['gallery'] = $gallery;
            $vars['images'] = $images;
            $vars['show_icons'] = false;
            $vars['show_url'] = true;
            $vars['thumb_size'] = 'medium';
            echo elgg_view_module('aside', $title, elgg_view('egallery/gallery_images', $vars), [
                'class' => 'egallery-module',
            ]);
        }
    }
}
