<?php
/**
 * Notice Controller class.
 *
 * @package RT_TPG
 */

namespace RT\ThePostGrid\Controllers\Admin;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Notice Controller class.
 */
class NoticeController {

	/**
	 * List of notice classes to load
	 *
	 * @var array
	 */
	protected $notice_classes = [
		Notice\BlackFriday::class,
		Notice\Review::class,
		Notice\SummerSale::class,
		Notice\LoadResourceType::class,
		//Notice\EidSpecial::class, // Uncomment when needed
	];

	/**
	 * Class Constructor
	 */
	public function __construct() {
		$this->load_notices();
	}

	/**
	 * Instantiate all notices using a factory approach
	 *
	 * @return void
	 */
	protected function load_notices() {
		foreach ( $this->notice_classes as $class ) {
			if ( class_exists( $class ) ) {
				new $class();
			}
		}
	}
}