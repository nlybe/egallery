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

if (!elgg_instanceof($file, 'object', GalleryItem::SUBTYPE)) {
    $gallery = get_entity(get_input("container_guid"));

    if (elgg_instanceof($gallery, 'object', EntityGallery::SUBTYPE)) {
        $images = $gallery->getGalleryImages(1);
        $file = $images[0];
    }
}

if (elgg_instanceof($file, 'object', GalleryItem::SUBTYPE)) {
    $content = elgg_format_element('li', ['id' => 'pgi_'.$file->getGUID()], 
        elgg_view('egallery/gallery_item', array(
            'p_gallery_item' => $file,
            'item_class' => 'cboxElement'
        ))
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
