<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\EgalleryOptions;
use Elgg\Exceptions\Http\EntityNotFoundException;

$username = elgg_extract('username', $vars);
$user = elgg_get_user_by_username($username);
if (!$user) {
	throw new EntityNotFoundException();
}

elgg_push_collection_breadcrumbs('object', 'entity_gallery', $user);

if (elgg_is_logged_in() && EgalleryOptions::isEntityTypeGalleryEnabled('user') && $user->guid == elgg_get_logged_in_user_guid()) {
	elgg_register_menu_item('title', [
		'name' => 'add',
		'icon' => 'plus',
		'href' => elgg_generate_url('edit:object:entity_gallery', ['guid' => elgg_get_logged_in_user_guid()]),
		'text' => elgg_echo('add'),
		'link_class' => 'elgg-button elgg-button-action elgg-lightbox',
	]);
}

$vars['entity'] = $user;
$title = $user->guid == elgg_get_logged_in_user_guid() ? elgg_echo('collection:object:entity_gallery:mine') : elgg_echo('collection:object:entity_gallery:owner', [$user->name]);
echo elgg_view_page($title, [
	'filter_value' => $user->guid == elgg_get_logged_in_user_guid() ? 'mine' : 'none',
	'content' => elgg_view('egallery/gallery_owner', $vars),
	'sidebar' => elgg_view('egallery/sidebar', [
		'page' => 'owner',
		'entity' => $user,
	]),
]);
