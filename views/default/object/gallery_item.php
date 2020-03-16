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
    $body = '<div class="elgg-image-block clearfix">';
    
    $category_label .= elgg_format_element('span', ['class' => ''], elgg_echo('portfolio:gallery:add:category'));
    $body .= elgg_format_element('p', ['class' => ''], $category_label.': '.$entity->category);
    
    $body .= '<ul class="elgg-gallery elgg-egallery-gallery elgg-showcase-screenshots">';
    $body .= elgg_format_element('li', ['id' => 'pgi_'.$entity->getGUID()], 
        elgg_view('egallery/gallery_item', array(
            'p_gallery_item' => $entity,
            'show_icons' => false,
            'thumb_size' => 'large',
        ))
    );    
    $body .= '</ul>';    
    
    $body .= '</div>';    

    echo elgg_view('object/elements/full', array(
        'entity' => $entity,
        'icon' => $owner_icon,
        'summary' => $summary,
        'body' => $body,
    ));
} 
else {
    $display_text = $url;
   
    $content .= '<ul class="elgg-gallery elgg-egallery-gallery elgg-showcase-screenshots">';
    $content .= elgg_format_element('li', ['id' => 'pgi_'.$entity->getGUID()], 
        elgg_view('egallery/gallery_item', array(
            'p_gallery_item' => $entity,
            'show_icons' => false,
        ))
    );    
    $content .= '</ul>';
    
    $params = array(
        'entity' => $entity,
        'metadata' => $metadata,
        'content' => $content,
    );
    $params = $params + $vars;
    $body = elgg_view('object/elements/summary', $params);

    echo elgg_view_image_block($owner_icon, $body);
    
}


?>


