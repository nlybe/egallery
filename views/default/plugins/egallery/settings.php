<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\EgalleryOptions;

$plugin = elgg_get_plugin_from_id(EgalleryOptions::PLUGIN_ID);
$entity = elgg_extract('entity', $vars);

echo elgg_format_element('h3', [], elgg_echo('egallery:settings:general:title'));

// set if add galleries menu item to site menu
echo elgg_view_field([
    'id' => 'gallery_site_menu_item',
    '#type' => 'checkbox',
    'name' => 'params[gallery_site_menu_item]',
    'switch' => true,
    'value' => 'yes',
    'checked' => ($plugin->gallery_site_menu_item === 'yes'), 
    '#label' => elgg_echo('egallery:settings:gallery_site_menu_item'),
    '#help' => elgg_echo('egallery:settings:gallery_site_menu_item:note'),
]);

// set if display short description for each photo
echo elgg_view_field([
    'id' => 'show_description',
    '#type' => 'checkbox',
    'name' => 'params[show_description]',
    'switch' => true,
    'value' => 'yes',
    'checked' => ($plugin->show_description === 'yes'), 
    '#label' => elgg_echo('egallery:settings:show_description'),
    '#help' => elgg_echo('egallery:settings:show_description:note'),
    'checked' => ($plugin->show_description || !isset($plugin->show_description) ? true : false),
]);

// set if display url for each photo
echo elgg_view_field([
    'id' => 'show_url',
    '#type' => 'checkbox',
    'name' => 'params[show_url]',
    'switch' => true,
    'value' => 'yes',
    'checked' => ($plugin->show_url === 'yes'), 
    '#label' => elgg_echo('egallery:settings:show_url'),
    '#help' => elgg_echo('egallery:settings:show_url:note'),
    'checked' => ($plugin->show_url || !isset($plugin->show_url) ? true : false),
]);

// set if include title on news item url
echo elgg_view_field([
    'id' => 'gallery_url_include_title',
    '#type' => 'checkbox',
    'name' => 'params[gallery_url_include_title]',
    'switch' => true,
    'value' => 'yes',
    'checked' => ($plugin->gallery_url_include_title === 'yes'), 
    '#label' => elgg_echo('egallery:settings:gallery_url_include_title'),
    '#help' => elgg_echo('egallery:settings:gallery_url_include_title:note'),
]);



$searchable = [];
$registered = get_registered_entity_types();
if ($registered) {
    foreach ($registered as $k => $v) {
        if (!is_array($v)) {
            continue;
        }

        foreach ($v as $kk => $vv) {
            if (count($v) == 1){
                $name = elgg_echo("collection:$k");
            }
            else {
                $name = elgg_echo("collection:$k:$vv");
            }
            $searchable[$vv] = $name;
        }
    }
}
asort($searchable);

ob_start();
foreach ($searchable as $name => $value) {
    $subtype = $name;
    $param_name_entity = 'egallery_' . $subtype;
    $param_name = 'params[' . $param_name_entity . ']';

    $tmp = elgg_view('input/checkbox', [
        'id' => $param_name_entity,
        'name' => $param_name, 
        'checked' => ($plugin->$param_name_entity ? true : false),
        'label' => $value.elgg_echo('egallery:settings:photos:subtype', [$subtype]),
    ]);
    echo elgg_format_element('div', ['class' => 'input_box'], $tmp);  
}
$inputs = ob_get_clean(); 

$form_output = elgg_view('elements/forms/field', [
    'input' => $inputs,
    'label' => elgg_echo('egallery:settings:photos:intro'),
]);

$title = elgg_format_element('h3', [], elgg_echo('egallery:settings:photos:title'));
echo elgg_view_module('inline', '', $form_output, ['header' => $title]);



if (!elgg_is_active_plugin("tidypics")) {
    $tidypics_output = elgg_format_element('div', ['style' => 'color:red;'], elgg_echo('egallery:settings:tidypics:inactive'));
}
// set if enable import from tidypics
$tidypics_output .= elgg_view_field([
    'id' => 'enable_tidypics_import',
    '#type' => 'checkbox',
    'name' => 'params[enable_tidypics_import]',
    'switch' => true,
    'value' => 'yes',
    'checked' => ($plugin->enable_tidypics_import === 'yes'), 
    '#label' => elgg_echo('egallery:settings:enable_tidypics_import'),
    '#help' => elgg_echo('egallery:settings:enable_tidypics_import:note'),
]);
// set if enable import from tidypics
$tidypics_output .= elgg_view_field([
    'id' => 'tidypics_import_admin_inly',
    '#type' => 'checkbox',
    'name' => 'params[tidypics_import_admin_inly]',
    'switch' => true,
    'value' => 'yes',
    'checked' => ($plugin->tidypics_import_admin_inly === 'yes'), 
    '#label' => elgg_echo('egallery:settings:tidypics_import_admin_inly'),
    '#help' => elgg_echo('egallery:settings:tidypics_import_admin_inly:note'),
]);
echo elgg_view_module('inline', '', $tidypics_output, ['header' => elgg_format_element('h3', [], elgg_echo('egallery:settings:tidypics:import'))]);
