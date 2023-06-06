<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

class GalleryItem extends ElggFile {

    const SUBTYPE = "gallery_item";
    
    protected $meta_defaults = [
        "title"             => NULL,
        "description"       => NULL,
    ];

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

    /**
     * Delete the entity and item copies
     * 
     * @return boolean
     */
    public function delete(bool $recursive = true): bool {
        if (!$this->canDelete()) {
			return false;
		}

        $guid = $this->getGUID();
        $owner_guid = $this->owner_guid;
        $icon_sizes = elgg_get_config('gallery_item_sizes'); 
        foreach ($icon_sizes as $name => $size_info) {
            $file = new ElggFile();
            $file->owner_guid = $owner_guid;
            $file->setFilename("gallery_item/".$guid."_".$name.".jpg");
            $filepath = $file->getFilenameOnFilestore();
            
            if (!$file->delete()) {
                elgg_log("Gallery item remove failed. Remove $filepath manually, please.", 'WARNING');
            }
        }

        // finally delete the original file
        $this->setFilename(elgg_strtolower("$this->filestore_prefix/{$this->upload_time}{$this->originalfilename}"));
        if (!parent::delete()) {
            return false;
        } 
        
        return true;
    } 

}
