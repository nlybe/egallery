<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Elgg\Exceptions\Http\EntityNotFoundException;

$username = elgg_extract('username', $vars);
$user = elgg_get_user_by_username($username);
if (!$user) {
	throw new EntityNotFoundException();
}

elgg_push_collection_breadcrumbs('object', 'entity_gallery', $user, true);

$title = elgg_echo('collection:object:entity_gallery:friends');
$content = elgg_view('egallery/gallery_friends', [
	'entity' => $user,
	'created_after' => $lower,
	'created_before' => $upper,
]);

echo elgg_view_page($title, [
	'content' => $content,
	'sidebar' => elgg_view('egallery/sidebar', [
		'page' => 'friends',
		'entity' => $user,
	]),
	'filter_value' => $user->guid === elgg_get_logged_in_user_guid() ? 'friends' : 'none',
]);
