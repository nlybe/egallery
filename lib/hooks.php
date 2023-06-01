<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\EgalleryOptions;

 /**
 * Add gallery option on entities, if enabled on settings
 * 
 * @param \Elgg\Hook $hook
 */ 
function egallery_entity_menu_setup(\Elgg\Hook $hook) {
    $return = $hook->getValue();
    $entity = $hook->getEntityParam();
    if (!$entity instanceof \ElggEntity) {
        return false;
    }
    
    $sub = ($entity instanceof \ElggEntity)?$entity->getSubtype():'';
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
            $options['href'] = $gallery->getUrl();
        }
        else {
            $options['href'] = elgg_normalize_url("egallery/edit/{$entity->getGUID()}");
            $options['class'] = 'elgg-lightbox';
        }
        
        $return[] = ElggMenuItem::factory($options);
    }

    if ($entity instanceof \EntityGallery && $entity->canEdit()) {
        $return[] = ElggMenuItem::factory([
            'name' => 'delete',
            'icon' => 'delete',
            'text' => elgg_echo('delete'),
            'href' => elgg_generate_action_url('egallery/gallery_delete', [
                'guid' => $entity->guid,
            ]),
            'confirm' => true,
            'priority' => 900,
        ]);

        $return[] = ElggMenuItem::factory([
            'name' => 'edit',
            'icon' => 'edit',
            'text' => elgg_echo('edit'),
            'href' => elgg_generate_url('edit:object:entity_gallery', [
                'guid' => $entity->guid,
            ]),
            'priority' => 800,
            'class' => 'elgg-anchor elgg-menu-content elgg-lightbox',
        ]);         
    }

    if ($entity instanceof \GalleryItem && $entity->canEdit()) {
        $return[] = ElggMenuItem::factory([
            'name' => 'edit',
            'icon' => 'edit',
            'text' => elgg_echo('edit'),
            'href' => elgg_generate_url('view:object:gallery_item:edit', [
                'guid' => $entity->guid,
            ]),
            'priority' => 800,
            'class' => 'elgg-anchor elgg-menu-content elgg-lightbox',
        ]);         
    }
        
    return $return;
}

 /**
 * Register gallery item to user menu
 * 
 * @param \Elgg\Hook $hook
 */ 
function egallery_gallery_user_menu(\Elgg\Hook $hook) {
    $entity = $hook->getEntityParam();
    if (!$entity instanceof \ElggUser) {
        return;
    }
    
    $return = $hook->getValue();
    
    $return[] = \ElggMenuItem::factory([
        'name' => 'entity_galley',
        'text' => elgg_echo('collection:object:entity_gallery'),
        'href' => elgg_generate_url('collection:object:entity_gallery:owner', [
            'username' => $entity->username,
        ]),
    ]);
            
    return $return;
}

/**
 * Format and return the URL for entity gallery objects
 *
 * @param \Elgg\Hook $hook
 */
function egallery_object_set_url(\Elgg\Hook $hook) {
    $entity = $hook->getEntityParam();    
    if (!$entity instanceof \EntityGallery) {
		return;
	}

    $friendly_title = EgalleryOptions::includeTitleOnGalleryPhotosUrl()?elgg_get_friendly_title($entity->title):"";
    return "egallery/view/{$entity->guid}/$friendly_title";
}

/**
 * Format and return the URL for entity gallery item objects
 *
 * @param \Elgg\Hook $hook
 */
function egallery_item_object_set_url(\Elgg\Hook $hook) {
    $entity = $hook->getEntityParam();    
    if (!$entity instanceof \GalleryItem) {
		return;
	}

    $friendly_title = EgalleryOptions::includeTitleOnGalleryPhotosUrl()?elgg_get_friendly_title($entity->title):"";
    return "egallery/photo/{$entity->guid}/$friendly_title";
}

/**
 * Create Gallery Items from items uploaded
 * 
 * @param \Elgg\Hook $hook
 */
function egallery_item_upload(\Elgg\Hook $hook) {
    elgg_gatekeeper();
    $return = $hook->getValue();
    
    $file = $hook->getParam('upload')->file;
    return elgg_call(ELGG_IGNORE_ACCESS, function() use ($file) {
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
                if ($fh->exists()) {
                    $fh->delete();
                }
            }        
        }
    });        

    return $return;
}

/**
 * Appends gallery to entity's full view
 *
 * @param \Elgg\Hook $hook
 * @return array
 */
function egallery_filter_full_view_vars(\Elgg\Hook $hook) {

    $return = $hook->getValue();
    $entity = elgg_extract('entity', $return);
    if (!$entity instanceof \ElggEntity) {
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

 /**
 * Update gallery entity title menu
 * 
 * @param \Elgg\Hook $hook
 */ 
function egallery_title_menu_setup(\Elgg\Hook $hook) {
    $entity = $hook->getEntityParam();
    if (!$entity instanceof \EntityGallery) {
        return;
    }
    
    if (!$entity->canEdit()) {
        return;
    }
    
    $result = $hook->getValue();
    foreach ($result->all() as $section_key => $section) {
        foreach ($section->getItems() as $item_key => $item) {
            if ($item->getName() == 'edit') {
                $item->addLinkClass('elgg-lightbox');
            }
        }
    }

    return $return;
}
