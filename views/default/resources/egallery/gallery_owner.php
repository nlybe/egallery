<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Elgg\Exceptions\Http\EntityNotFoundException;

$username = elgg_extract('username', $vars);

$user = get_user_by_username($username);
if (!$user) {
	throw new EntityNotFoundException();
}

elgg_push_collection_breadcrumbs('object', 'entity_gallery', $user);

$vars['entity'] = $user;
$title = $user->guid == elgg_get_logged_in_user_guid() ? elgg_echo('collection:object:entity_gallery:mine') : elgg_echo('collection:object:entity_gallery:owner', [$user->name]);
echo elgg_view_page($title, [
	// 'filter_value' => $user->guid == elgg_get_logged_in_user_guid() ? 'mine' : 'none',
	'filter' => '',
	'content' => elgg_view('egallery/gallery_owner', $vars),
]);
