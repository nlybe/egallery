<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

class GalleryItem extends ElggFile {

    const SUBTYPE = "gallery_item";
    
    protected $meta_defaults = array(
        "title"             => NULL,
        "description"       => NULL,
    );    

    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes["subtype"] = self::SUBTYPE;
        $this->attributes['access_id'] = ACCESS_PRIVATE;
    }

    /**
     * Check if the gallery item has URL and it's valid
     * 
     * @return boolean
     */
    public function hasValidURL() {
        if ($this->url && filter_var($this->url, FILTER_VALIDATE_URL) !== false) {
            return true;
        }
        
        return false;
    }

    /**
     * Get image description
     * 
     * @return boolean
     */
    public function getDescription() {
        if ($this->description) {
            return str_replace('<br />','',$this->description);
        }
        
        return '';
    }     

}
