<?php
/**
 * Get Help Page
 *
 * @package RT_TPG
 */

// Do not allow directly accessing this file.
use RT\ThePostGrid\Helpers\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Get Help
 */
$heading_title = 'Our Plugins';
require_once trailingslashit( RT_THE_POST_GRID_PLUGIN_PATH ) . 'resources/parts/settings-header.php';
?>

<div class="rttpg-our-plugins-wrapper settings-container">
	<?php
	$plugins = [
		[
			'slug'    => 'classified-listing',
			'image'   => 'images/our-plugins/classified-listing.gif',
			'title'   => 'Classified Listing',
			'excerpt' => 'Classified Listing classified ads Business Directory plugin comes with all the features necessary for building a classified listing website.',
			'docs'    => 'https://www.radiustheme.com/docs/classified-listing/',
		],
		[
			'slug'    => 'shopbuilder',
			'image'   => 'images/our-plugins/shopbuilder.png',
			'title'   => 'ShopBuilder',
			'excerpt' => 'ShopBuilder is a powerful WooCommerce Builder for Elementor that lets you easily create custom WooCommerce pages with a drag and drop interface.',
			'docs'    => 'https://shopbuilderwp.com/docs/',
		],
		[
			'slug'    => 'tlp-food-menu',
			'image'   => 'images/our-plugins/food-menu.gif',
			'title'   => 'Food Menu',
			'excerpt' => 'Food Menu is a simple WordPress restaurant menu plugin that can use to display food menu of a restaurant or can use for online order using Woocommerce.',
			'docs'    => 'https://www.radiustheme.com/docs/food-menu/',
		],
		[
			'slug'    => 'woo-product-variation-swatches',
			'image'   => 'images/our-plugins/variation-swatches.png',
			'title'   => 'Variation Swatches',
			'excerpt' => 'Woocommerce variation swatches plugin converts the product variation select fields into radio, images, colors, and labels.',
			'docs'    => 'https://www.radiustheme.com/docs/variation-swatches/',
		],
		[
			'slug'    => 'woo-product-variation-gallery',
			'image'   => 'images/our-plugins/variation-gallery.gif',
			'title'   => 'Variation Images Gallery',
			'excerpt' => 'Variation Images Gallery for WooCommerce plugin allows to add UNLIMITED additional images for each variation of product.',
			'docs'    => 'https://www.radiustheme.com/docs/variation-gallery/',
		],
		[
			'slug'    => 'testimonial-slider-and-showcase',
			'image'   => 'images/our-plugins/testimonials.gif',
			'title'   => 'Testimonial Slider',
			'excerpt' => 'Testimonial Slider and Showcase plugin for WordPress website. It is a developer and user-friendly testimonial plugin that facilitates easy management of customer testimonials.',
			'docs'    => 'https://www.radiustheme.com/docs/testimonial-slider/',
		],
		[
			'slug'    => 'tlp-team',
			'image'   => 'images/our-plugins/team.gif',
			'title'   => 'Team Members Showcase',
			'excerpt' => 'Team is the WordPress team plugin that facilitates the display of your team members on your site. It is fully responsive and mobile friendly, which guarantees the views across all devices.',
			'docs'    => 'https://www.radiustheme.com/docs/team/',
		],
		[
			'slug'    => 'tlp-portfolio',
			'image'   => 'images/our-plugins/portfolio.gif',
			'title'   => 'Portfolio',
			'excerpt' => 'Best WordPress Portfolio Plugin for WordPress to display your portfolio work in grid, filterable portfolio and slider view.',
			'docs'    => 'https://www.radiustheme.com/docs/portfolio/',
		],
		[
			'slug'    => 'review-schema',
			'image'   => 'images/our-plugins/review-schema.gif',
			'title'   => 'Review Schema',
			'excerpt' => 'WordPress Review Plugin with JSON-LD based Structure Data Schema solution for your website. Add Schema.org Structured Data to enhance your website in Google Search Results.',
			'docs'    => 'https://www.radiustheme.com/docs/review-schema/',
		],
	];

    $plugins = [
		[
			'slug'    => 'classified-listing',
			'image'   => 'images/our-plugins/classified-listing.gif',
			'title'   => 'Classified Listing',
			'excerpt' => 'AI-Powered Classiifed Listing and Business Directory plugin to create classified listing, real estate directory, Job board, local business directory, and more.',
			'docs'    => 'https://www.radiustheme.com/docs/classified-listing/',
		],
		[
			'slug'    => 'shopbuilder',
			'image'   => 'images/our-plugins/shopbuilder.png',
			'title'   => 'ShopBuilder',
			'excerpt' => 'The Ultimate All-in-One Solution for Elementor & WooCommerce. Including 28 powerful modules, 120+ creative widgets, and 40+ pre-built templates.' ,
			'docs'    => 'https://shopbuilderwp.com/docs/',
		],
		[
			'slug'    => 'tlp-food-menu',
			'image'   => 'images/our-plugins/food-menu.gif',
			'title'   => 'Food Menu',
			'excerpt' => 'Food & Restaurant Menu Display Plugin for Restaurant, Cafes, Fast Food, Coffee House with WooCommerce Online Ordering.',
			'docs'    => 'https://www.radiustheme.com/docs/food-menu/',
		],
		[
			'slug'    => 'woo-product-variation-swatches',
			'image'   => 'images/our-plugins/variation-swatches.png',
			'title'   => 'Variation Swatches',
			'excerpt' => 'Woocommerce variation swatches plugin converts the product variation select fields into radio, images, colors, and labels.',
			'docs'    => 'https://www.radiustheme.com/docs/variation-swatches/',
		],
		[
			'slug'    => 'woo-product-variation-gallery',
			'image'   => 'images/our-plugins/variation-gallery.gif',
			'title'   => 'Variation Images Gallery',
			'excerpt' => 'Variation Images Gallery for WooCommerce plugin allows to add UNLIMITED additional images for each variation of product.',
			'docs'    => 'https://www.radiustheme.com/docs/variation-gallery/',
		],
		[
			'slug'    => 'testimonial-slider-and-showcase',
			'image'   => 'images/our-plugins/testimonials.gif',
			'title'   => 'Testimonial Slider',
			'excerpt' => 'Testimonial Slider and Showcase plugin the ultimate WordPress plugin for displaying customer testimonials, reviews, and social proof.',
			'docs'    => 'https://www.radiustheme.com/docs/testimonial-slider/',
		],
		[
			'slug'    => 'tlp-team',
			'image'   => 'images/our-plugins/team.gif',
			'title'   => 'Team Members Showcase',
			'excerpt' => 'Team Member plugin is the ultimate, solution for displaying your team members, staff, and associates in a way that builds trust your brand.',
			'docs'    => 'https://www.radiustheme.com/docs/team/',
		],
		[
			'slug'    => 'tlp-portfolio',
			'image'   => 'images/our-plugins/portfolio.gif',
			'title'   => 'Portfolio',
			'excerpt' => 'Portfolio is the ultimate WordPress portfolio plugin to create and display a beautiful, responsive, and filterable portfolio',
			'docs'    => 'https://www.radiustheme.com/docs/portfolio/',
		],
		[
			'slug'    => 'review-schema',
			'image'   => 'images/our-plugins/review-schema.gif',
			'title'   => 'Review Schema',
			'excerpt' => 'A powerful Review & Schema Plugin featuring JSON-LD–based Structured Data integration for your WordPress website.',
			'docs'    => 'https://www.radiustheme.com/docs/review-schema/',
		],
	];
	?>

    <div class="rttpg-plugins-row">
		<?php foreach ( $plugins as $plugin ) : ?>
            <div class="card rt-plugin-item">
                <header>
                    <img src="<?php echo esc_url( rtTPG()->get_assets_uri( $plugin['image'] ) ); ?>" alt="<?php echo esc_attr( $plugin['title'] ); ?>">
                    <h3 class="rt-plugin-title"><?php echo esc_html( $plugin['title'] ); ?></h3>
                </header>
                <div class="rt-plugin-excerpt"><?php echo esc_html( $plugin['excerpt'] ); ?></div>
                <footer>
					<?php Fns::get_plugin_install_button( $plugin['slug'] ); ?>
                    <a target="_blank" href="<?php echo esc_url( $plugin['docs'] ); ?>" class="rt-admin-btn documentation">Documentation</a>
                </footer>
            </div>
		<?php endforeach; ?>
    </div>

</div>
