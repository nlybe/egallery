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
        if ($plugin->$param_name_entity === 'yes') {
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
        if ($show_description === 'yes') {
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
        if ($show_url === 'yes') {
            return true;
        } 

        return false;
    }  
    
    /**
     * Check if include title on news item url
     * 
     * @return boolean
     */
    Public Static function includeTitleOnGalleryPhotosUrl() {
        $include_title = self::getParams('gallery_url_include_title');
        if ($include_title === 'yes') {
            return true;
        } 

        return false;
    }
    
    /**
     * Check if add galleries menu item to site menu
     * 
     * @return boolean
     */
    Public Static function addGallerySiteMenuItem() {
        $include_title = self::getParams('gallery_site_menu_item');
        if ($include_title === 'yes') {
            return true;
        } 

        return false;
    }
    
    /**
     * Check if import from tidypics is enabled
     * 
     * @return boolean
     */
    Public Static function isImportFromTidypicsEnabled() {
        if (!elgg_is_active_plugin("tidypics")) {
            return false;
        } 

        $import = self::getParams('enable_tidypics_import');
        if ($import !== 'yes') {
            return false;
        } 

        $admin_only = self::getParams('tidypics_import_admin_only');
        if ($admin_only === 'yes' && !elgg_is_admin_logged_in()) {
            return false;
        }
        
        return true;
    } 
       
}
