<?php

namespace RT\ThePostGrid\Factory;

class DiviFactory {

	/**
	 * Base namespace for all Settings.
	 */
	const BASE_NAMESPACE = 'RT\\ThePostGrid\\Divi\\Fields\\';

	/**
	 * List of component class names (without namespace).
	 *
	 * @var array
	 */

	public static function get_classes() {
		return apply_filters( 'rttpg_divi_settings_sections', [
			'ContentLayout',
			'ContentQuery',
			'ContentFilter',
			'ContentPagination',
			'ContentLink',
			'SettingsFieldSelection',
			'SettingsSectionTitle',
			'SettingsPostTitle',
			'SettingsThumbnail',
			'SettingsExcerpt',
			'SettingsMetaData',
			'SettingsACF',
			'SettingsReadMore',
			'StyleSectionTitle',
			'StylePostTitle',
			'StyleThumbnail',
			'StyleExcerpt',
			'StyleMetaData',
			'StyleSocialShare',
			'StyleReadMore',
			'StyleFilter',
			'StylePagination',
			'StyleACF',
			'StyleCard',
		] );
	}

	/**
	 * Render All Divi Fields
	 *
	 * @return array
	 */
	public static function get_divi_fields( $prefix ) {
		$fields = [];

		$classes = self::get_classes();

		if ( 'slider' === $prefix ) {
			$classes[] = 'SettingsSlider';
			$classes[] = 'StyleSlider';
		}

		foreach ( $classes as $class ) {
			$component = self::BASE_NAMESPACE . $class;

			if ( class_exists( $component ) && method_exists( $component, 'get_fields' ) ) {
				$fields = array_merge( $fields, $component::get_fields( $prefix ) );
			}
		}

		return $fields;
	}

	public static function get_divi_advanced_fields( $prefix ) {
		$component = self::BASE_NAMESPACE . 'AdvancedFields';
		if ( class_exists( $component ) && method_exists( $component, 'get_fields' ) ) {
			return $component::get_fields( $prefix );
		}
	}

}