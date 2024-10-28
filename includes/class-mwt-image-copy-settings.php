<?php
/**
 * 
 */
class MWT_Image_Copy_Settings {
	/**
	 * Initialize the class
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
	}

	/**
	 * Register settings
	 *
	 * @return void
	 */
	public function register_settings() {
		register_setting( 'mwt_options_group', 'mwt_copy_button_text' );
		add_option( 'mwt_copy_button_text', 'Copy Image' ); // Default value.
	}

	/**
	 * Add settings menu
	 *
	 * @return void
	 */
	public function add_admin_menu() {
		add_options_page(
			'Copy Button Settings',
			'Copy Button',
			'manage_options',
			'mwt_copy_button',
			array( $this, 'options_page' )
		);
	}

	/**
	 * Settings page callback function
	 *
	 * @return void
	 */
	public function options_page() {
		?>
		<div class="wrap">
			<h1>Copy Button Settings</h1>
			<form method="post" action="options.php">
				<?php settings_fields('mwt_options_group'); ?>
				<label for="mwt_copy_button_text">Button Text:</label>
				<input type="text" name="mwt_copy_button_text" value="<?php echo esc_attr(get_option('mwt_copy_button_text')); ?>" />
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}

// Initialize the settings class.
if ( is_admin() ) {
	$mwt_settings = new MWT_Image_Copy_Settings();
}
