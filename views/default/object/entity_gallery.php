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
$container = $entity->getContainerEntity();

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


$imprint = [];
$imprint[] = [
    'icon_name' => 'arrow-up', 
    'content' => elgg_view('output/url', [
        'href' => $container->getURL(),
        'title' => elgg_echo('egallery:add:value', [$container->getDisplayName()]),
        'text' => $container->getDisplayName(),
    ])
];

if ($full && !elgg_in_context('gallery')) {
    $body = elgg_format_element('div', ['class' => 'desc'], $entity->description?$entity->description:'&nbsp;'); 
    $params = [
        'icon' => $owner_icon,
        'show_summary' => true,
        'body' => $body, 
        'show_navigation' => true,
        'title' => false,
        'imprint' => $imprint,
    ];
    $params = $params + $vars;
    
    // echo elgg_get_excerpt($entity->getDisplayName(), 100);
    echo elgg_view('object/elements/full', $params);
    echo elgg_view('egallery/gallery_images', $vars);

    if ($container->canWriteToContainer(0, 'object', EntityGallery::SUBTYPE)) {
        $form_vars = ['name' => 'photos_upload', 'enctype' => 'multipart/form-data', 'class' => 'dropzone'];
        echo elgg_view_form('egallery/photos_upload', $form_vars, [
            'container_guid' => $entity->getGUID(), 
            'subtype' => GalleryItem::SUBTYPE,
        ]);
    }

    // finally show the comments
    $params['show_responses'] = true;
    echo elgg_view('object/elements/full/responses', $params);
    
    return;
} 
else {
    $params = [
        'content' => elgg_get_excerpt($entity->description),
        'icon' => false,
        'imprint' => $imprint,
    ];
    $params = $params + $vars;
    $body = elgg_view('object/elements/summary', $params);
    
    echo elgg_view_image_block($owner_icon, $body);
}

