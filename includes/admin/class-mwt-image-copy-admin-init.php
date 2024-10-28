<?php
/**
 * Admin class for MWT Image Copy
 *
 * @package mwtic
 * @author mywptrek
 */
class MWT_Image_Copy_Admin_Init {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'mwtic_admin_menu_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'mwtic_enqueue_menu_page_scripts' ) );

		add_action( 'admin_init', array( $this, 'mwtic_register_settings' ) );
	}
	/**
	 * Register mwtic Settings
	 */
	public function mwtic_register_settings() {
		register_setting( 'mwt-mwtic-settings-general-group', 'mwtic_general_settings' );
	}
	/**
	 * Enqueue scripts for menu page.
	 *
	 * @param string $hook Hook Suffix.
	 */
	public function mwtic_enqueue_menu_page_scripts( $hook ) {
		global $mwtic;
		if ( 'toplevel_page_mwtic' === $hook ) {
			global $mwtic;
			wp_enqueue_script(
				'mwtic-slick-script',
				$mwtic->plugin_url . '/assets/slick/slick.min.js',
				array( 'jquery' ),
				$mwtic->version,
				true
			);
			wp_enqueue_script(
				'mwtic-admin-page',
				$mwtic->plugin_url . '/assets/admin/mwtic-admin-page.js',
				array( 'jquery', 'mwtic-slick-script' ),
				$mwtic->version,
				true
			);
			wp_enqueue_style(
				'mwtic-admin-page',
				$mwtic->plugin_url . '/assets/admin/mwtic-admin-page.css',
				array(),
				$mwtic->version
			);
		}
		wp_enqueue_style( 'mwtic-boxicons-style', $mwtic->mwtic_assets . 'boxicons/css/boxicons.min.css', array(), $mwtic->version );
		wp_enqueue_style( 'mwtic-settings-style', $mwtic->mwtic_assets . 'css/mwtic-settings-style.css', array(), $mwtic->version );
		wp_enqueue_script( 'mwtic-settings-script', $mwtic->mwtic_assets . 'js/mwtic-settings-script.js', array( 'jquery' ), $mwtic->version, true );
		$params = array(
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce( 'mwtic_settings_ajax_nonce' ),
			'dark_mode'  => esc_html__( 'Dark Mode', 'mwtic' ),
			'light_mode' => esc_html__( 'Light Mode', 'mwtic' ),
		);
		wp_localize_script( 'mwtic-settings-script', 'mwtic_settings', $params );
	}
	/**
	 * Init Slider admin menu.
	 */
	public function mwtic_admin_menu_init() {
		add_menu_page(
			esc_html__( 'EventGlide', 'mwtic' ),
			esc_html__( 'EventGlide', 'mwtic' ),
			'manage_options',
			'mwtic',
			array( $this, 'mwtic_admin_menu_page' ),
			// Encode the SVG content before embedding it in an HTML document.
			// phpcs:ignore
			'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
			<!-- Background Circle -->
			<circle cx="17" cy="17" r="15" stroke="transparent" stroke-width="2" />
			<!-- Letter "E" -->
			<text x="5" y="23" font-family="Arial" font-size="18" font-weight="bold" fill="transparent">E</text>
			<!-- Letter "G" -->
			<text x="15" y="23" font-family="Arial" font-size="18" font-weight="bold" fill="transparent">G</text>
			<circle cx="12" cy="26" r="1" fill="transparent" />
			<circle cx="17" cy="26" r="1" fill="transparent" />
			<circle cx="22" cy="26" r="1" fill="transparent" />
			</svg>'
			),
			6
		);
	}
	/**
	 * Adds Slider admin page
	 */
	public function mwtic_admin_menu_page() {
		wp_enqueue_style( 'mwtic-boxicons-style' );
		wp_enqueue_style( 'mwtic-settings-style' );
		wp_enqueue_script( 'mwtic-settings-script' );

		require_once 'pages/page-mwtic-admin-settings.php';
	}
}
