<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

elgg_require_js('egallery/gallery_popup');
$full = elgg_extract('full_view', $vars, false);
$entity = elgg_extract('entity', $vars, false);

if (!$entity) { 
    return;
}

$owner = $entity->getOwnerEntity();

// $owner_icon = elgg_view_entity_icon($owner, 'small');
if ($full) {
    $owner_icon = elgg_view_entity_icon($owner, 'small');
}
else {
    $cover_image = $entity->getGalleryCoverImage();
    if ($cover_image) {
        $cover_size = 'small';
        if ($full) {
            $cover_size = 'tiny';
        }
        $thumb_url = elgg_get_site_url() . "egallery/item/{$cover_image->getGUID()}/small/" . md5($cover_image->time_created) . '.jpg';
        $owner_icon .= elgg_view('output/url', [
            'class' => 'elgg-showcase-screenshot-cover elgg-photo',
            'href' => $entity->getURL(),
            'rel' => 'showcase-gallery',
            'title' => $entity->title,
            'text' => elgg_view('output/img', [
                'src' => $thumb_url,
                'alt' => $cover_image->title,
            ]),
        ]);    
    }
    else {
        $owner_icon = elgg_view_entity_icon($owner, 'medium');
        $owner_icon = elgg_format_element('div', ['class' => 'elgg-showcase-screenshot-cover'], $owner_icon);
    }
}
// $vars['owner_url'] = "egallery/owner/$owner->username";

if ($full && !elgg_in_context('gallery')) {
    if ($entity->description) {
        $body = elgg_format_element('div', ['class' => 'desc'], $entity->description); 
    }
    else {
        $body = elgg_format_element('div', ['class' => 'desc'], '&nbsp;'); 
    }

    $params = [
        'icon' => $owner_icon,
        'show_summary' => true,
        'body' => elgg_format_element('div', ['class' => 'elgg-image-block clearfix'], $body), 
        'show_navigation' => false,
    ];
    $params = $params + $vars;

    echo elgg_view('object/elements/full', $params);
    return;

    // echo elgg_view('object/elements/full', array(
    //     'entity' => $entity,
    //     'icon' => $owner_icon,
    //     'summary' => $summary,
    //     'body' => $body,
    // ));
} 
else {
    $params = [
        'content' => elgg_get_excerpt($entity->description),
        'icon' => false,
    ];
    $params = $params + $vars;
    $body = elgg_view('object/elements/summary', $params);
    
    echo elgg_view_image_block($owner_icon, $body);

}
