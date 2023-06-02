<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$guid = elgg_extract('guid', $vars, null);
$entity = get_entity($guid);

if ( !$entity instanceof \EntityGallery || !$entity->canEdit() ) {  
    return;
}

echo elgg_view_field([
    '#type' => 'objectpicker',
    'subtype' => TidypicsAlbum::SUBTYPE,
    'id' => 'album_guid',
    'name' => 'album_guid',
    'limit' => 1,
    '#label' => elgg_echo('egallery:import:tidypics:album'),
    '#help' => elgg_echo('egallery:import:tidypics:album:note', [$entity->title]),
    'required' => true,
]);

?>

<div class="elgg-foot">
<?php
    if ($guid) {
        echo elgg_view_field([
            '#type' => 'hidden',
            'name' => 'guid',
            'value' => $guid,
        ]);        
    }

    echo elgg_view_field([
        '#type' => 'submit',
        'value' => elgg_echo('submit')
    ]);   
?>
</div>
