<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

 use Egallery\EgalleryOptions;

 elgg_push_collection_breadcrumbs('object', 'entity_gallery');

 if (elgg_is_logged_in() && EgalleryOptions::isEntityTypeGalleryEnabled('user')) {
	elgg_register_menu_item('title', [
		'name' => 'add',
		'icon' => 'plus',
		'href' => elgg_generate_url('edit:object:entity_gallery', ['guid' => elgg_get_logged_in_user_guid()]),
		'text' => elgg_echo('add'),
		'link_class' => 'elgg-button elgg-button-action elgg-lightbox',
	]);
 }

 $title = elgg_echo('collection:object:entity_gallery:all');
 $content = elgg_view('egallery/gallery_all', []);
 echo elgg_view_page($title, [
	 'content' => $content,
	 'sidebar' => elgg_view('egallery/sidebar', ['page' => 'all']),
	 'filter_value' => 'all',
 ]);
