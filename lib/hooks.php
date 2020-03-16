<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

 /**
 * Add gallery option on entities, if enabled on settings
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 * @return type
 */ 
function egallery_entity_menu_setup($hook, $type, $return, $params) {
    $entity = $params['entity'];
    if (!$entity instanceof ElggEntity) {
        return false;
    }
    
    $sub = ($entity instanceof ElggEntity)?$entity->getSubtype():'';
    if (EgalleryOptions::isEntityTypeGalleryEnabled($sub) && $entity->canEdit()) {
        $options = [
            'name' => "egallery_{$sub}",
            'icon' => 'images',
            'text' => elgg_echo("egallery:menu:label"),
            'title' => elgg_echo("egallery:menu:title", [$entity->title]),
            'priority' => 60,
        ];

        $gallery = EntityGallery::getGallery($entity);
        if ($gallery) {
            $options['href'] = elgg_normalize_url("egallery/view/{$gallery->getGUID()}");
        }
        else {
            $options['href'] = elgg_normalize_url("egallery/edit/{$entity->getGUID()}");
            $options['class'] = 'elgg-lightbox';
        }
        
        $return[] = ElggMenuItem::factory($options);
    }
        
    return $return;
}

/**
 * Format and return the URL for entity gallery objects
 *
 * @param string $hook
 * @param string $type
 * @param string $url
 * @param array  $params
 * @return string URL of lecture
 */
function egallery_object_set_url($hook, $type, $url, $params) {
    $entity = $params['entity'];
    $friendly_title = elgg_get_friendly_title($entity->title);

    if (elgg_instanceof($entity, 'object', EntityGallery::SUBTYPE)) {
        return "egallery/view/{$entity->guid}/$friendly_title";
    }
    
    // if (elgg_instanceof($entity, 'object', GalleryItem::SUBTYPE)) {
    //     return "egallery/gallery/item/view/{$entity->guid}/$friendly_title";
    // }    
}

/**
 * Create Gallery Items from items uploaded
 * 
 * @param type $hook
 * @param type $entity_type
 * @param type $returnvalue
 * @param type $params
 * @return type
 */
function egallery_item_upload($hook, $entity_type, $returnvalue, $params) {
    elgg_gatekeeper();
    
    $file = $params['upload']->file;

    $ia = elgg_set_ignore_access(true);
    $fh = get_entity($file->getGUID());
    $container = $fh->getContainerentity();   
    
    $pieces = explode(".", $fh->getFilename());
    $prefix = $pieces[0];
    $fh->file_prefix = $prefix;
    $fh->access_id = $container->access_id;    
    $fh->save();
    $source = $fh->getFilenameOnFilestore();
        
    $icon_sizes = elgg_get_config('gallery_item_sizes'); 
    foreach ($icon_sizes as $name => $size_info) {   
        try {
            $fh->setFilename("gallery_item/".$file->getGUID()."_".$name.".jpg");
            // touch file location in order to create the file
            $fh->open('write');
            $fh->close();

            $resized = elgg_save_resized_image($source, $fh->getFilenameOnFilestore(), [
                'w' => $size_info['w'], 
                'h' => $size_info['h'], 
                'square' => $size_info['square'], 
                'upscale' => $size_info['upscale']
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            
            if ($fh->exists()) {
                $fh->delete();
            }
        }        
    }
    elgg_set_ignore_access($ia);
    
    return $returnvalue;
}

/**
 * Appends connected entities to entity's full view
 *
 * @param string $hook   "view_vars"
 * @param string $type   "object/elements/full"
 * @param array  $return View vars
 * @param array  $params Hook params
 * @return array
 */
function egallery_filter_full_view_vars($hook, $type, $return, $params) {

    $entity = elgg_extract('entity', $return);
    if (!$entity) {
        return;
    }

    $attached = elgg_view('object/elements/egallery/full', [
        'entity' => $entity,
    ]);

    if (!$attached) {
        return;
    }

    $body = elgg_extract('body', $return, '');
    if (!$body) {
        $body = $attached;
    } 
    else {
        $body .= '<br />' . $attached;
    }
    $return['body'] = $body;

    return $return;
}