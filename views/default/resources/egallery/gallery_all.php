<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

 elgg_push_collection_breadcrumbs('object', 'entity_gallery');

 $title = elgg_echo('collection:object:entity_gallery:all');
 $content = elgg_view('egallery/gallery_all', []);
 echo elgg_view_page($title, [
	 'content' => $content,
	 'sidebar' => elgg_view('egallery/sidebar', ['page' => 'all']),
	 'filter_value' => 'all',
 ]);
