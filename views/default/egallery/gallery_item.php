<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\EgalleryOptions;

$file = elgg_extract('p_gallery_item', $vars, '');
$item_class = elgg_extract('item_class', $vars, '');
$show_icons = elgg_extract('show_icons', $vars, true);
$thumb_size = elgg_extract('thumb_size', $vars, 'small');
$show_url = elgg_extract('show_url', $vars, false);
$caption_view = elgg_extract('caption_view', $vars, false);

if (!$file instanceof \GalleryItem) {
    return;
}
    
$thumb_url = elgg_get_site_url() . "egallery/item/{$file->getGUID()}/{$thumb_size}/" . md5($file->time_created) . '.jpg';
$full_url = elgg_get_site_url() . "egallery/item/{$file->getGUID()}/master/" . md5($file->time_created) . '.jpg';
$original_url = elgg_get_site_url() . "egallery/item/{$file->getGUID()}/original/" . md5($file->time_created) . '.jpg';

$item .= elgg_view('output/url', [
    'class' => 'elgg-showcase-screenshot elgg-photo '.$item_class,
    'href' => $full_url,
    'rel' => 'showcase-gallery',
    'title' => $file->description?$file->getDescription():$file->title,
    'text' => elgg_view('output/img', [
        'src' => $thumb_url,
        'alt' => $file->title,
    ]),
]);

if ($caption_view) {
    $item .= elgg_view('output/url', [
        'href' => $file->getUrl(),
        'title' => $file->title,
        'text' => $file->title,
        'class' => 'ecaption'
    ]);
}

// Validate url
if ($show_url && EgalleryOptions::displayImageURL() && $file->hasValidURL()) {
    $item .= elgg_format_element('div', ['class' => 'ecaption'], elgg_view('output/url', [
        'href' => $file->url,
        'title' => elgg_echo('egallery:item:url'),
        'text' => elgg_echo('egallery:item:url'),
        'target' => '_blank'
    ]));
}

if ($show_icons) {
    $icons .= elgg_view('output/url', [
        'name' => 'view',
        'href' => $file->getUrl(),
        'title' => elgg_echo('egallery:item:comment'),
        'text' => elgg_view_icon('comment-dots'),
    ]);

    $icons .= elgg_view('output/url', [
        'name' => 'download',
        'href' => $original_url,
        'title' => elgg_echo('egallery:item:download'),
        'text' => elgg_view_icon('download'),
        'target' => '_blank'
    ]);

    if ($file->canEdit()) {
        $icons .= elgg_view('output/url', [
            'name' => 'set_cover',
            'href' => elgg_normalize_url("action/egallery/gallery_set_cover?item={$file->getGUID()}"),
            'title' => elgg_echo('egallery:item:set_cover'),
            'text' => elgg_view_icon('image'),
            'is_action' => true
        ]);
        $icons .= elgg_view('output/url', [
            'name' => 'edit',
            'href' => elgg_normalize_url("egallery/item/edit/{$file->getGUID()}"),
            'title' => elgg_echo('egallery:item:edit'),
            'text' => elgg_view_icon('edit'),
            'class' => 'elgg-lightbox',
        ]);
    }

    if ($file->canDelete()) {
        $icons .= elgg_view('output/url', [
            'name' => 'delete',
            'href' => "action/egallery/gallery_item_delete?guid={$file->getGUID()}",
            'title' => elgg_echo('delete:this'),
            'text' => elgg_view_icon('remove'),
            'confirm' => elgg_echo('deleteconfirm'),
        ]);    
    }

    $item .= elgg_format_element('div', ['class' => 'elgg-egallery-item-icons'], $icons);
}

echo $item;

