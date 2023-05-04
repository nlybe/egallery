<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\Elgg\Bootstrap;

require_once(dirname(__FILE__) . '/lib/hooks.php');
require_once(dirname(__FILE__) . '/lib/functions.php');

return [
    'plugin' => [
        'name' => 'Entities Gallery',
		'version' => '4.3',
		'dependencies' => [
			'dropzonejs_api' => [
				'must_be_active' => true,
                'version' => '>4'
			]
		],
	],	
    'bootstrap' => Bootstrap::class,
	'entities' => [
        [
            'type' => 'object',
            'subtype' => 'entity_gallery',
            'class' => 'EntityGallery',
            'searchable' => true,
        ],
        [
            'type' => 'object',
            'subtype' => 'gallery_item',
            'class' => 'GalleryItem',
            'searchable' => false,
        ]
    ],
	'actions' => [
        'egallery/gallery_edit' => [],
        'egallery/gallery_item_del' => [],
        'egallery/get_latest_item' => [],
        'egallery/gallery_set_cover' => [],
        'egallery/gallery_item_edit' => [],
    ],
	'routes' => [
        'edit:object:entity_gallery' => [
			'path' => '/egallery/edit/{guid}',
			'resource' => 'egallery/gallery_edit',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
        ],
        'view:object:entity_gallery' => [
			'path' => '/egallery/view/{guid}/{title?}',
			'resource' => 'egallery/gallery_view',
		],
        'view:object:gallery_item:view' => [
			'path' => '/egallery/item/{guid}/{size?}/{file?}',
			'resource' => 'egallery/gallery_item_view',
		],
        'view:object:gallery_item:edit' => [
			'path' => '/egallery/item/edit/{guid}',
			'resource' => 'egallery/gallery_item_edit',
		],
    ],
	'hooks' => [
		'entity:url' => [
			'object' => [
				'egallery_object_set_url' => [ 'priority' => 400],
			],
		],
		'register' => [
			'menu:entity' => [
				'egallery_entity_menu_setup' => [],
			],
		],
		'upload:after' => [
			'dropzonejs_api' => [
				'egallery_item_upload' => [],
			],
		],
		'view_vars' => [
			'object/elements/full' => [
				'egallery_filter_full_view_vars' => [],
			],
		],
	],
    'settings' => [
        'show_description' => false,
        'show_url' => true,
		'gallery_url_include_title' => 'yes',
	],
];

