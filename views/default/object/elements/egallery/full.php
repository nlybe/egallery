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
    $title = $gallery->title?$gallery->title:elgg_echo('egallery:photos:view:title');
    if ($gallery) {
        $vars['gallery'] = $gallery;
        $vars['show_icons'] = false;
        $vars['show_url'] = true;
        $vars['thumb_size'] = 'medium';
        // echo elgg_view_module('aside', elgg_echo('egallery:photos:view:title'), elgg_view('egallery/gallery_images', $vars), [
        echo elgg_view_module('aside', $title, elgg_view('egallery/gallery_images', $vars), [
            'class' => 'egallery-module',
        ]);
    }
}
