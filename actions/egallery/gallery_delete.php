<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$guid = (int) get_input('guid');
$entity = get_entity($guid);
if (!$entity instanceof \EntityGallery) {
    return elgg_error_response(elgg_echo('egallery:delete:failed'));
}

if (!$entity->canDelete()) {
    return elgg_error_response(elgg_echo('egallery:delete:failed'), $entity->getURL());
}

$container = $entity->getContainerentity();
if ($entity->delete()) {
    system_message(elgg_echo("egallery:delete:success"));
    forward($container->getURL());
} else {
    return elgg_error_response(elgg_echo('egallery:delete:failed'));    
}

forward(REFERER);