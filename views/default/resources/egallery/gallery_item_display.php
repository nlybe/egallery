<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\EgalleryOptions;

// get entity
$guid = elgg_extract('guid', $vars, '');
elgg_entity_gatekeeper($guid, 'object', 'gallery_item');

$entity = get_entity($guid);
if (!$entity instanceof \GalleryItem) {
    elgg_error_response(elgg_echo('egallery:invalid'));
    forward(REFERRER);
}

$container = $entity->getOwnerEntity();
elgg_push_collection_breadcrumbs('object', 'entity_gallery', $container);
elgg_push_entity_breadcrumbs($entity, false);

$vars['full_view'] = true;
$vars['caption_view'] = false;
$content = elgg_view_entity($entity, $vars);

echo elgg_view_page($entity->getDisplayName(), [
	'content' => $content,
	'filter_id' => '',
	'entity' => $entity,
	'sidebar' => '',
], 'default', [
	'entity' => $entity,
]);

