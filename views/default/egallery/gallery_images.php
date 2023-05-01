<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\EgalleryOptions;

elgg_require_js('egallery/gallery');

$egallery = elgg_extract('gallery', $vars, '');
// if (!elgg_instanceof($egallery, 'object', EntityGallery::SUBTYPE)) {
if (!$egallery instanceof \EntityGallery) {
    return;
}

$images = $egallery->getGalleryImages();
$cover = $egallery->getGalleryCoverImage();

// if (isset($vars['gallery_view']) && $vars['gallery_view'] = 'all') {
    $output = '<ul id="'.EgalleryOptions::DEFAULT_CAT.'" class="elgg-gallery elgg-egallery elgg-showcase-screenshots">';
    foreach ($images as $file) {
        $li_options = ['id' => 'pgi_'.$file->getGUID()];
        if ($file->guid == $cover->guid) {
            $li_options['class'] = "elgg-showcase-screenshot-cover";
        }        
        $vars['p_gallery_item'] = $file;
        $output .= elgg_format_element('li', $li_options, elgg_view('egallery/gallery_item', $vars));    
    }
    $output .= '</ul>';
    echo $output;
// }
// else {
//     $categories = [];
//     $categories_files = [];
//     $categories_files[EgalleryOptions::DEFAULT_CAT] = [];
//     foreach ($images as $file) {
//         if ($file->category ) {
//             $cat = trim($file->category);
//             if (!in_array($cat, $categories)) {
//                 array_push($categories, $cat);
//                 $categories_files[$cat] = [];
//             }        

//             array_push($categories_files[$cat], $file);
//         }
//         else {
//             array_push($categories_files[EgalleryOptions::DEFAULT_CAT], $file);
//         }    
//     }
//     // finally add uncategorized photos
//     array_push($categories, EgalleryOptions::DEFAULT_CAT);

//     // sort company array alphabetically
//     sort($categories);

//     foreach($categories as $cat) {
//         $accordion .= elgg_format_element('h3', [], elgg_echo($cat));

//         $accordion .= '<div>';
//         $accordion .= '<ul id="'.$cat.'" class="elgg-gallery elgg-egallery elgg-showcase-screenshots">';
//         foreach($categories_files[$cat] as $file) {
//             $accordion .= elgg_format_element('li', ['id' => 'pgi_'.$file->getGUID()], 
//                 elgg_view('egallery/gallery_item', array('p_gallery_item' => $file))
//             );
//         }
//         $accordion .= '</ul>';
//         $accordion .= '</div>';
//     }
//     //echo elgg_format_element('div', ['id' => 'p_gallery_accordion', 'style' => 'height: auto;'], $accordion);
//     echo elgg_format_element('div', ['style' => 'height: auto;'], $accordion);
// }
