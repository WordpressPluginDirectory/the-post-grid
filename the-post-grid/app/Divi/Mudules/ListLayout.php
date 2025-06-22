<?php

namespace RT\ThePostGrid\Divi\Mudules;

use RT\ThePostGrid\Abstracts\AbstractDivi;
use RT\ThePostGrid\Factory\DiviFactory;
use RT\ThePostGrid\Divi\Utils\DiviFrontEndCss;
use RT\ThePostGrid\Divi\Render\ListLayoutRender;
use RT\ThePostGrid\Helpers\DiviFns;

class ListLayout extends AbstractDivi {

	public $slug = 'tpg_list_layout';
	public static $prefix = 'list';

	protected function get_module_name() {
		return esc_html__( 'List Layout', 'the-post-grid' );
	}

	protected function get_icon_path() {
		return trailingslashit( RT_THE_POST_GRID_PLUGIN_PATH ) . "/assets/images/gutenberg/list-layout.svg";
	}

	public function get_fields() {
		$fields = DiviFactory::get_divi_fields( self::$prefix );

		$fields['__get_list_layout'] = [
			'type'                => 'computed',
			'computed_callback'   => [ ListLayout::class, 'get_layout_data' ],
			'computed_depends_on' => DiviFns::computed_depends_on( self::$prefix ),
		];

		return $fields;
	}

	public function get_advanced_fields_config() {
		return DiviFactory::get_divi_advanced_fields( self::$prefix );
	}

	public static function get_layout_data( $settings ) {
		$renderer = new ListLayoutRender( $settings, self::$prefix );
		return $renderer->render();
    }

	public function render( $unprocessed_props, $content, $render_slug ) {
		$settings = $this->props;

		$settings['prefix'] = self::$prefix;
		DiviFrontEndCss::render_css( $render_slug, $settings );

		return $this->get_layout_data( $settings );
	}

}