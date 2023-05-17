<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

class EntityGallery extends ElggObject {
    const SUBTYPE = "entity_gallery";
    
    protected $meta_defaults = array(
        "title"             => NULL,
        "description"       => NULL,
        "cover_guid"        => NULL,
        "tags"              => NULL,
        "comments_on"       => NULL,
    );    

    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes["subtype"] = self::SUBTYPE;
    }    
    
    /**
     * Set default gallery title
     * 
     * @param type $container
     * @return string
     */
    public static function setGalleryTitle($container) {
        return elgg_echo('egallery:add:value', [$container->title]);
    }
    
    /**
     * Get the images of this gallery
     * 
     * @return type
     */
    public function getGalleryImages($limit = 0) {
        $images = elgg_get_entities([
            'type' => 'object',
            'subtype' => GalleryItem::SUBTYPE,
            'container_guid' => $this->guid,
            'limit' => $limit,
        ]);
        
        return $images;
    }
    
    /**
     * Retreive the cover image of this gallery
     * If has not been set, return the latest image
     * 
     * @return GalleryItem or false
     */
    public function getGalleryCoverImage() {
        $cover_image = get_entity($this->cover_guid);
        
        // if (elgg_instanceof($cover_image, 'object', GalleryItem::SUBTYPE)) {
        if ($cover_image instanceof \GalleryItem) {
            return $cover_image;
        }
        
        // else
        $images = $this->getGalleryImages(1);
        if ($images) {
            return $images[0];
        }
        
        return false;
    }    
    
    /**
     * Check if given container has already at least one gallery
     * 
     * @param ElggEntity $container User or Group of Object
     * @return True on success or false 
     */
    Public Static function hasGallery($container = null) {
        if (!$container instanceof ElggEntity) {
            return false;
        }
        
        $count = elgg_get_entities([
            'type' => 'object',
            'subtype' => self::SUBTYPE,
            'container_guid' => $container->getGUID(),
            'count' => true,
        ]);
        
        if ($count > 0) {
            return true;
        }
                
        return false;
    } 

    /**
     * Get the galleries of given container entity
     * 
     * @param ElggEntity $container User or group
     * @param type object $container
     * @param type int $limit
     * @return object | boolean
     */
    Public Static function getGallery($container = null, $limit = 1) {
        if (!$container instanceof ElggEntity) {
            return false;
        }
        
        $galleries = elgg_get_entities([
            'type' => 'object',
            'subtype' => self::SUBTYPE,
            'container_guid' => $container->getGUID(),
            'order_by' => 'e.time_created ASC', // get the first one
            'limit' => $limit,
        ]);
        
        return (empty($galleries)) ? false : $galleries[0];
    }

    /**
     * Delete the entity and all items copies
     * 
     * @return boolean
     */
    public function delete($follow_symlinks = true) {
        if (!$this->canDelete()) {
			return false;
		}

        $images = $this->getGalleryImages();
        if ($images && is_array($images)) {
            foreach ($images as $im) {
                $im->delete();
            }
        }

        // finally delete the gallery
        if (!parent::delete()) {
            return false;
        } 
        
        return true;
    }
    
    // /**
    //  * Creates portfolio gallery for the given container
    //  * 
    //  * @param ElggEntity $container
    //  * @return boolean|\PortfolioGallery
    //  */
    // public static function createPortfolioGallery($container) {
    //     if (!$container instanceof ElggEntity) {
    //         return false;
    //     }
        
    //     if (!elgg_is_logged_in()) {
    //         return false;
    //     }

    //     try {
    //         $access_level = get_default_access();
    //         if ($container instanceof \ElggGroup) {
    //             $access_level = $container->group_acl;
    //         }
            
    //         $p_gallery = new PortfolioGallery();
    //         $p_gallery->title = self::setPortfolioGalleryTitle($container);
    //         $p_gallery->access_id = $access_level;
    //         $p_gallery->owner_guid = elgg_get_logged_in_user_entity()->getGUID();
    //         $p_gallery->container_guid = $container->guid;
    //         $p_gallery->comments_on = On; // by default set comments off

    //         $ia = elgg_set_ignore_access(true);
    //         $p_gallery->save();
    //         elgg_set_ignore_access($ia);

    //         elgg_log("Created portfolio gallery for $container->name [$container->guid]", 'NOTICE');
    //     } 
    //     catch (Exception $ex) {
    //         elgg_log($ex->getMessage(), 'ERROR');
    //     }

    //     return $p_gallery;
    // }
   
}
