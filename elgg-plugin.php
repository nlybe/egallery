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
            'capabilities' => [
				'commentable' => true,
				'searchable' => true,
				'likable' => true,
			],
        ],
        [
            'type' => 'object',
            'subtype' => 'gallery_item',
            'class' => 'GalleryItem',
            'searchable' => false,
            // 'capabilities' => [
			// 	'commentable' => true,
			// 	'searchable' => true,
			// 	'likable' => true,
			// ],
        ]
    ],
	'actions' => [
        'egallery/gallery_edit' => [],
        'egallery/gallery_delete' => [],
		'egallery/gallery_item_delete' => [],
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
		'collection:object:entity_gallery:owner' => [
			'path' => '/egallery/owner/{username}',
			'resource' => 'egallery/gallery_owner',
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
			'menu:owner_block' => [
				'egallery_gallery_user_menu' => [],
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
		'prepare' => [
			'menu:title:object:entity_gallery' => [
				'egallery_title_menu_setup' => [],
			],
		],
	],
    'settings' => [
        'show_description' => false,
        'show_url' => true,
		'gallery_url_include_title' => 'yes',
	],
	'widgets' => [
		'egallery' => [
			'context' => ['profile'],
		],
	],
];

