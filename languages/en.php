<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

return [

    'egallery' => 'Attach photos on Elgg Entities',
    'entity_gallery' => 'Galleries',
    'collection:object:entity_gallery' => 'Galleries',
    'collection:object:gallery_item' => 'Gallery Photos',
    'collection:object:about' => 'About', // missing from Elgg
    'entity_gallery:none' => 'No galleries',
    'collection:object:entity_gallery:owner' => '%s\'s Galleries',
    'collection:object:entity_gallery:mine' => 'My galleries',
    'collection:object:entity_gallery:friends' => 'Friends\' galleries',
    'collection:object:entity_gallery:all' => 'Galleries',
    'entity_gallery:menu' => 'Galleries',

    // gallery form
    'egallery:add:requiredfields' => 'Fields with an asterisk (*) are required',
    'egallery:add:title' => "Title",
    'egallery:add:title:help' => "Set the title of gallery",
    'egallery:add:value' => "Gallery of '%s'",
    'egallery:add:description' => "Description",
    'egallery:add:description:help' => "Enter a description for this gallery.",
    'egallery:add:tags' => "Tags",
    'egallery:add:tags:help' => "Enter some tags",
    'egallery:add:submit' => "Submit",       
    'egallery:save:missing_title' => "Title is missing. Gallery cannot be saved.",
    'egallery:save:missing_excerpt' => "Summary is missing. Gallery cannot be saved.", 
    'egallery:save:success' => "Gallery was successfully saved", 
    'egallery:save:failed' => "Gallery cannot be saved", 
    'egallery:set_cover:success' => "Gallery cover was successfully set", 
    'egallery:set_cover:failed' => "Gallery cover couldn't be set", 
    'egallery:item:add:title' => "Title",
    'egallery:item:add:title:help' => "Set the title of image",
    'egallery:item:add:url' => "Image Source (url)",
    'egallery:item:add:url:help' => "Optionally set a url of image source",
    'egallery:item:add:description' => "Description",
    'egallery:item:add:description:help' => "Optionally set a description",
    'egallery:breadcrumb:label' => "Back to %s",
        
    'egallery:upload_photos:save:success' => "Photos were successfully added on this gallery", 
    'egallery:upload_photos:save:failed' => "Photos couldn't be uploaded",
    
    'egallery:form:groups_list:no_groups_plugin' => "Groups plugin is not enabled",

    // gallery item
    'egallery:item:download' => "Download this", 
    'egallery:item:default_title' => 'Edit Gallery Item',
    'egallery:item:edit' => 'Edit item information', 
    'egallery:item:set_cover' => 'Set as Gallery Cover', 
    'egallery:item:save:missing_title' => "Title is missing. This item cannot be saved.",
    'egallery:item:save:url_error' => "The URL is not valid. This item cannot be saved.",
    'egallery:item:url' => "Image Source", 

    // status messages
    'egallery:invalid' => 'Invalid entity or invalid permissions',
    'egallery:invalid_access' => "Invalid access to this action",
    'egallery:onject:disabled' => "Gallery is not enabled for this type of entities",     
    'egallery:item:delete:success' => "Gallery item was successfully deleted", 
    'egallery:item:delete:failed' => "Gallery item cannot be deleted",
    'egallery:item:save:success' => "Gallery item was successfully saved", 
    'egallery:item:save:failed' => "Gallery item cannot be saved", 
    'egallery:invalid_item' => "Invalid item entity",
    'egallery:invalid_gallery' => "Invalid gallery entity",
    'egallery:set_cover:success' => "Gallery cover was successfully set", 
    'egallery:set_cover:failed' => "Gallery cover couldn't be set", 
    'egallery:delete:success' => "Gallery was successfully deleted", 
    'egallery:delete:failed' => "Gallery cannot be deleted",

    // widgets
    'egallery:galleries:more' => 'More galleries',
    'egallery:numbertodisplay' => 'Number of galleries to display',
    
    // settings
    'egallery:settings:general:title' => 'General Settings',
    'egallery:settings:photos:title' => 'Attach photos to entities',
    'egallery:settings:photos:intro' => 'Select entities for attaching photos.',
    'egallery:settings:photos:subtype' => ' (%s)',
    'egallery:settings:show_description' => 'Include Image Description',
    'egallery:settings:show_description:note' => 'Check this if want to include a description for each photo',
    'egallery:settings:gallery_site_menu_item' => 'Add galleries menu item to site menu',
    'egallery:settings:gallery_site_menu_item:note' => 'Check this if want to add Galleries to site menu',
    'egallery:settings:show_url' => 'Include Image Source URL',
    'egallery:settings:show_url:note' => 'Check this if want to include a source url for each photo',
    'egallery:settings:gallery_url_include_title' => "Include title on gallery item URL",
    'egallery:settings:gallery_url_include_title:note' => "The function elgg_get_friendly_title doesn't work good with some languages, so it may raise an invalid URI path issue. In this case uncheck this option to exclude the title from gallery item url.",
    
    'egallery:menu:label' => 'Manage Gallery',
    'egallery:menu:title' => 'Edit %s photo gallery',
    'egallery:photos:view:title' => 'Photos',
    
];

