<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

elgg_require_js('egallery/gallery');

$full = elgg_extract('full_view', $vars, FALSE);
$entity = elgg_extract('entity', $vars, FALSE);

if (!$entity) { 
    return;
}

$owner = $entity->getOwnerEntity();

$owner_icon = elgg_view_entity_icon($owner, 'small');

// $vars['owner_url'] = "egallery/owner/$owner->username";
$author_text = elgg_view('page/elements/by_line', $vars);

if ($full && !elgg_in_context('gallery')) {
    $body .= elgg_format_element('div', ['class' => 'elgg-image-block clearfix'], elgg_view('egallery/gallery_item', [
        'p_gallery_item' => $entity,
        'show_icons' => false,
        'thumb_size' => 'master',
        'caption_view' => elgg_extract('caption_view', $vars, false),
    ]));

    $params = [
        'icon' => $owner_icon,
        'show_summary' => true,
        'body' => $body, 
        'show_navigation' => true,
        'title' => false,
        'imprint' => $imprint,
    ];
    $params = $params + $vars;

    echo elgg_view('object/elements/full', $params);
} 
else {
    $display_text = $url;
   
    $content .= '<ul class="elgg-gallery elgg-egallery-gallery elgg-showcase-screenshots">';
    $content .= elgg_format_element('li', ['id' => 'pgi_'.$entity->getGUID()], 
        elgg_view('egallery/gallery_item', [
            'p_gallery_item' => $entity,
            'show_icons' => false,
        ])
    );    
    $content .= '</ul>';
    
    $params = [
        'entity' => $entity,
        'metadata' => $metadata,
        'content' => $content,
    ];
    $params = $params + $vars;
    $body = elgg_view('object/elements/summary', $params);

    echo elgg_view_image_block($owner_icon, $body);
    
}
