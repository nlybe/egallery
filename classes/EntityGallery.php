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

	/**
	 * Can a user comment on the gallery?
	 *
	 * @see ElggObject::canComment()
	 *
	 * @param int  $user_guid User guid (default is logged in user)
	 * @param bool $default   Default permission
	 *
	 * @return bool
	 */
	public function canComment($user_guid = 0, $default = null) {
		$result = parent::canComment($user_guid, $default);
		if (!$result) {
			return $result;
		}

		if ($this->comments_on === 'Off') {
			return false;
		}
		
		return true;
	}
   
}
