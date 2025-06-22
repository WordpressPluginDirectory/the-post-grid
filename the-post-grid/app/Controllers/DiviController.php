<?php
/**
 * Elementor Controller class.
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Controllers;

// Do not allow directly accessing this file.
use RT\ThePostGrid\Helpers\DiviFns;
use RT\ThePostGrid\Helpers\Fns;
use RT\ThePostGrid\Divi\Mudules\GridLayout;
use RT\ThePostGrid\Divi\Mudules\GridHoverLayout;
use RT\ThePostGrid\Divi\Mudules\ListLayout;
use RT\ThePostGrid\Divi\Utils\DiviEditorCss;
use RT\ThePostGrid\Divi\Utils\DiviFrontEndCss;

if (!defined('ABSPATH')) {
    exit('This script cannot be accessed directly.');
}

if (!class_exists('DiviController')) :
    /**
     * Elementor Controller class.
     */
    class DiviController
    {

        protected $settings = [];
        /**
         * Version
         *
         * @var string
         */
        private $version;

        /**
         * Class constructor
         */
        public function __construct()
        {
            $this->version = defined('WP_DEBUG') && WP_DEBUG ? time() : RT_THE_POST_GRID_VERSION;
            add_action('wp_enqueue_scripts', [$this, 'front_end_script'], 999999999);
            add_action('et_builder_ready', [$this, 'load_modules'], 20);
            add_action('wp_enqueue_scripts', [$this, 'tpg_et_builder_editor_enqueue'], 999999999);
            add_action('admin_head', [$this, 'tpg_et_builder_archive_enqueue'], 999999999);
            add_action('wp_head', [$this, 'css_prop_for_editor_front_end']);
        }

        public function load_modules()
        {
            if (!class_exists(\ET_Builder_Element::class)) {
                return;
            }

            $modules = [
                GridLayout::class,
                GridHoverLayout::class,
                ListLayout::class,
            ];

            if (defined('RT_TPG_PRO_VERSION') && version_compare(RT_TPG_PRO_VERSION, '7.8.0', '>')) {
                $modules = apply_filters('rttpg_divi_modules', $modules);
            }

            foreach ($modules as $module_class) {
                if (class_exists($module_class)) {
                    new $module_class();
                }
            }
        }

        public function front_end_script()
        {
            if (DiviFns::is_divi_builder_preview()) {
                wp_enqueue_script(
                    'rttpg-divi-modules',
                    rtTPG()->get_assets_uri('divi/divi-modules.js'),
                    [
                        'jquery',
                        'react-dom',
                        'react',
                        'et_pb_media_library',
                        'wp-element',
                        'wp-i18n',
                    ],
                    $this->version,
                    true
                );

                wp_enqueue_style('rt-fontawsome');
                wp_enqueue_style('rt-flaticon');
                wp_enqueue_style('rt-tpg-block');
                wp_enqueue_style('swiper');
                wp_enqueue_script('rt-tpg');
                wp_enqueue_script('rttpg-block-pro');

                do_action('rttpg_divi_frontend_scripts');
            }
        }

        /**
         * Front-end tab css modify
         *
         * @return array
         */
        public function tpg_et_builder_editor_enqueue()
        {
            if (wp_style_is('et-frontend-builder')) {
                $custom_css = DiviEditorCss::editor_css();
                wp_add_inline_style('et-frontend-builder', $custom_css);
            }
        }

        public function tpg_et_builder_archive_enqueue()
        {
            $custom_css = DiviEditorCss::editor_css();
            if (DiviFns::is_divi_builder_preview()) {
                echo "<style>{$custom_css}</style>";
            }
        }

        public function css_prop_for_editor_front_end()
        {
            if (DiviFns::is_divi_builder_preview()) {
                ?>
                <script>window.tpgDiviLayoutCSS =<?php echo wp_json_encode(DiviFrontEndCss::css_collection()); ?></script>
                <?php
            }
        }

    }
endif;
