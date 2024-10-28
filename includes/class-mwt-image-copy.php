<?php

class MWT_Image_Copy {

	/**
	 * Instance of the class
	 *
	 * @var MWT_Image_Copy
	 */
	private static $instance = null;

	/**
	 * Constructor
	 */
	private function __construct() {
		// Enqueue scripts and styles.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Modify images on the frontend to add copy functionality.
		add_filter( 'the_content', array( $this, 'add_copy_button_to_images' ) );
	}

	/**
	 * Get the instance (singleton pattern)
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Enqueue necessary scripts and styles
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			'mwt-clipboard-js',
			plugin_dir_url( __FILE__ ) . '../assets/js/clipboard.min.js',
			array(),
			'2.0.8',
			true
		);

		wp_enqueue_script(
			'mwt-main-js',
			plugin_dir_url( __FILE__ ) . '../assets/js/mwt-main.js',
			array( 'mwt-clipboard-js' ),
			'1.0.0',
			true
		);

		wp_enqueue_style(
			'mwt-image-copy-css',
			plugin_dir_url( __FILE__ ) . '../assets/css/mwt-style.css',
			array(),
			'1.0.0'
		);
	}

	/**
	 * Add the copy button to images in the content
	 *
	 * @param string $content Content.
	 */
	public function add_copy_button_to_images( $content ) {
		if ( is_single() ) {
			$content = preg_replace_callback(
				'/<img(.*?)src=["\'](.*?)["\'](.*?)>/i',
				function ($matches) {
					return '<div class="mwt-copy-container">'
						. '<img' . $matches[1] . 'src="' . $matches[2] . '"' . $matches[3] . '>'
						. '<button class="mwt-copy-btn" data-clipboard-target="img[src=\'' . $matches[2] . '\']">Copy</button>'
						. '</div>';
				},
				$content
			);
		}
		return $content;
	}
}
