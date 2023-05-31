<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

if (!elgg_is_xhr()) {
    register_error('Sorry, Ajax only!');
    forward(REFERRER);
}

$result = [];

$file = get_entity(get_input("file_guid"));

if (!$file instanceof \GalleryItem) {
    $gallery = get_entity(get_input("container_guid"));
    if ($gallery instanceof \EntityGallery) {
        $images = $gallery->getGalleryImages(1);
        $file = $images[0];
    }
}

if ($file instanceof \GalleryItem) {
    $content = elgg_format_element('li', ['id' => 'pgi_'.$file->getGUID()], 
        elgg_view('egallery/gallery_item', [
            'p_gallery_item' => $file,
            'item_class' => 'cboxElement',
            'thumb_size' => 'medium',
        ])
    );    

    $result['error'] = false;
    $result['content'] = $content;
    
}
else {
    $result['error'] = true;
    $result['msg'] = 'to boulo';    
}

echo json_encode($result);
exit;
