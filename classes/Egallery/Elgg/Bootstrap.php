<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

namespace Egallery\Elgg;

use Elgg\DefaultPluginBootstrap;
use Egallery\EgalleryOptions;

class Bootstrap extends DefaultPluginBootstrap {
	
	const HANDLERS = [];
	
	/**
	 * {@inheritdoc}
	 */
	public function init() {
		$this->initViews();
	}

	/**
	 * Init views
	 *
	 * @return void
	 */
	protected function initViews() {

		// add a site navigation item
		if (EgalleryOptions::addGallerySiteMenuItem()) {			
			elgg_register_menu_item('site', [
				'name' => 'elgg-galleries',
				'icon' => 'images',
				'text' => elgg_echo('entity_gallery:menu'),
				'href' => elgg_generate_url('collection:object:entity_gallery:all'),
			]); 
		}
		
		if (EgalleryOptions::isEntityTypeGalleryEnabled('group')) {
			// add group option
			elgg()->group_tools->register('entity_gallery'); 
		}

		// set cover sizes
		elgg_set_config('gallery_item_sizes', [
			'tiny' => ['w' => 40, 'h' => 40, 'square' => true, 'upscale' => false],
			'small' => ['w' => 100, 'h' => 100, 'square' => true, 'upscale' => false],
			'medium' => ['w' => 200, 'h' => 200, 'square' => true, 'upscale' => false],
			'large' => ['w' => 600, 'h' => 600, 'square' => false, 'upscale' => false],
			'master' => ['w' => 1300, 'h' => 1300, 'square' => false, 'upscale' => false],
			'original' => ['w' => 2048, 'h' => 2048, 'square' => false, 'upscale' => false],
		]); 
	}
}