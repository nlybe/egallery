<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

namespace Egallery;

class EgalleryOptions {

    const PLUGIN_ID = 'egallery';    // current plugin ID
    const DEFAULT_CAT = 'egallery_default_cat';    // gallery default category

    /**
     * Get param value from settings
     * 
     * @return type
     */
    Public Static function getParams($setting_param = ''){
        if (!$setting_param) {
            return false;
        }
        
        return trim(elgg_get_plugin_setting($setting_param, self::PLUGIN_ID)); 
    }

    /**
     * Check if gallery option is enabled for given type/subtype
     * 
     * @param ElggEntity $entity
     * @param string $cat: connection category, e.g. users
     * @return boolean
     */
    Public Static function isEntityTypeGalleryEnabled($sub) {
        $plugin = elgg_get_plugin_from_id(self::PLUGIN_ID);
        $param_name_entity = "egallery_{$sub}";
        if ($plugin->$param_name_entity) {
            return true;
        }
        
        return false;
    }  

    /**
     * Check if display short description for each photo
     * 
     * @return boolean
     */
    Public Static function displayImageDescription() {
        $show_description = self::getParams('show_description');
        if ($show_description === 'on') {
            return true;
        } 

        return false;
    } 

    /**
     * Check if display url for each photo
     * 
     * @return boolean
     */
    Public Static function displayImageURL() {
        $show_url = self::getParams('show_url');
        if ($show_url === 'on') {
            return true;
        } 

        return false;
    }  
    
    /**
     * Check if include title on news item url
     * 
     * @return boolean
     */
    Public Static function includeTitleOnGalleryUrl() {
        $include_title = self::getParams('gallery_url_include_title');
        if ($include_title === 'yes') {
            return true;
        } 

        return false;
    }
    
	// /**
	//  * Make the correct folder structure for an owner
	//  *
	//  * @param int $owner_guid the owner to generate for
	//  * @return false|string
	//  */
	// public function getUploadPath($owner_guid) {		
	// 	if (empty($owner_guid)) {
	// 		$owner_guid = elgg_get_logged_in_user_guid();
	// 	}
		
	// 	if (empty($owner_guid)) {
	// 		return false;
	// 	}
		
	// 	return implode('/', [
	// 		elgg_get_site_entity()->guid,
	// 		$owner_guid,
	// 		'gallery_item',
	// 	]);
	// }    
       
}
