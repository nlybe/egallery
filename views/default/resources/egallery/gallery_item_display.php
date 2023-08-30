<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Elgg\Exceptions\Http\EntityNotFoundException;
use Egallery\EgalleryOptions;

// get entity
$guid = elgg_extract('guid', $vars, '');
elgg_entity_gatekeeper($guid, 'object', 'gallery_item');

$entity = get_entity($guid);
if (!$entity instanceof \GalleryItem) {
    throw new EntityNotFoundException();
}

$container = $entity->getContainerEntity();
$container_container = $container->getContainerEntity();
if ($container_container instanceof \ElggGroup) {
    elgg_push_breadcrumb(elgg_echo('groups'), 'groups');
    elgg_push_entity_breadcrumbs($container, true);
}
else {
	elgg_push_collection_breadcrumbs('object', 'entity_gallery');
	elgg_push_entity_breadcrumbs($entity, true);
}




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

