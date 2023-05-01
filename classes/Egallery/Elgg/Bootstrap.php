<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

namespace Egallery\Elgg;

use Elgg\DefaultPluginBootstrap;

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

		// extend css
		elgg_extend_view('css/elgg', 'egallery/egallery.css');

		
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