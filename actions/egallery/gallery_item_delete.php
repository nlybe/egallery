<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$guid = (int) get_input('guid');

$entity = get_entity($guid);
if (!$entity instanceof \GalleryItem) {
    return elgg_error_response(elgg_echo('egallery:item:delete:failed'));
}

if (!$entity->canDelete()) {
    return elgg_error_response(elgg_echo('egallery:item:delete:failed'), $entity->getURL());
}

if ($entity->delete()) {
    return elgg_ok_response('', elgg_echo('egallery:item:delete:success'));
} 

return elgg_error_response(elgg_echo('egallery:item:delete:failed'));
