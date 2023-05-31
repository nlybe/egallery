<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

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
    elgg_error_response(elgg_echo('egallery:onject:disabled', [$sub]));
    forward(REFERRER);
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

$owner = $entity->getOwnerEntity();
elgg_push_collection_breadcrumbs('object', 'entity_gallery', $owner);
elgg_push_breadcrumb($entity->getDisplayName());

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

