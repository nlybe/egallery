<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\EgalleryOptions;
use Elgg\Exceptions\Http\EntityNotFoundException;

$guid = elgg_extract('guid', $vars);
$group = get_entity($guid);
if (!$group) {
	throw new EntityNotFoundException();
}

elgg_push_breadcrumb(elgg_echo('groups'), 'groups');
elgg_push_collection_breadcrumbs('object', 'entity_gallery', $group);

if (EgalleryOptions::isEntityTypeGalleryEnabled('group')) {
	elgg_register_menu_item('title', [
		'name' => 'add',
		'icon' => 'plus',
		'href' => elgg_generate_url('edit:object:entity_gallery', ['guid' => $group->guid]),
		'text' => elgg_echo('add'),
		'link_class' => 'elgg-button elgg-button-action elgg-lightbox',
	]);
}

$vars['container'] = $group;
$title = elgg_echo('collection:object:entity_gallery:owner', [$group->name]);
echo elgg_view_page($title, [
	'filter' => '',
	'content' => elgg_view('egallery/gallery_group', $vars),
	'sidebar' => elgg_view('egallery/sidebar', [
		'page' => 'owner',
		'entity' => $group,
	]),
]);
