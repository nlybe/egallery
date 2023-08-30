<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Elgg\Exceptions\Http\BadRequestException;
use Egallery\EgalleryOptions;

// get entity
$guid = elgg_extract('guid', $vars, '');
elgg_entity_gatekeeper($guid, 'object', 'entity_gallery');

$entity = get_entity($guid);
$vars['gallery_view'] = get_input('v');
$vars['gallery'] = $entity;

$container = $entity->getContainerEntity();
$sub = $container->getSubtype();
if (!EgalleryOptions::isEntityTypeGalleryEnabled($sub)) {
    throw new BadRequestException();
}

if ($entity->canEdit() && EgalleryOptions::isImportFromTidypicsEnabled()) {
	elgg_register_menu_item('title', [
		'name' => 'import',
		'icon' => 'file-import',
		'href' => elgg_generate_url('import:object:entity_gallery', ['guid' => $entity->guid]),
		'text' => elgg_echo('egallery:import:tidypics'),
		'link_class' => 'elgg-button elgg-button-action elgg-lightbox',
	]);
}

$page_owner = elgg_get_page_owner_entity();
if ($page_owner instanceof \ElggGroup) {
    elgg_push_breadcrumb(elgg_echo('groups'), 'groups');
    elgg_push_collection_breadcrumbs('object', 'entity_gallery', $page_owner);
	elgg_push_collection_breadcrumbs('object', 'entity_gallery', $entity);
}
else {
	elgg_push_collection_breadcrumbs('object', 'entity_gallery', $container);
	elgg_push_entity_breadcrumbs($entity, true);
}

$vars['full_view'] = true;
$vars['show_responses'] = false;
$content = elgg_view_entity($entity, $vars);

echo elgg_view_page($entity->getDisplayName(), [
	'content' => $content,
	'filter_id' => '',
	'entity' => $entity,
	'sidebar' => '',
], 'default', [
	'entity' => $entity,
]);

