<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class mortgage_calculator_Admin {

	/**
 	 * Option key, and option page slug
 	 * @var string
 	 */
	private $key = 'mortgage_calculator_options';

	/**
 	 * Options page metabox id
 	 * @var string
 	 */
	private $metabox_id = 'mortgage_calculator_option_metabox';

	/**
	 * Array of metaboxes/fields
	 * @var array
	 */
	protected $option_metabox = array();

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function __construct() {
		// Set our title
		$this->title = __( 'Mortgage Calculator', 'mortgage_calculator' );
	}

	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
	}


	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  0.1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2_options_page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			Get the quick start guide at <a href="http://www.thinklandingpages.com/mortgage-calculator">thinklandingpages.com</a>
			<p>
			Place a mortgage calculator on any post or page by placing the shortcode <code>[mortgage_calculator]</code> where you want it to appear.
			<?php //cmb2_metabox_form( $this->metabox_id, $this->key ); 
			?>
		</div>
		<?php
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 * @param  array $meta_boxes
	 * @return array $meta_boxes
	 */
	function add_options_page_metabox() {

		$cmb = new_cmb2_box( array(
			'id'      => $this->metabox_id,
			'hookup'  => false,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		// Set our CMB2 fields

		$cmb->add_field( array(
			'name' => __( 'Test Text', 'mortgage_calculator' ),
			'desc' => __( 'field description (optional)', 'mortgage_calculator' ),
			'id'   => 'test_text',
			'type' => 'text',
			'default' => 'Default Text',
		) );

		$cmb->add_field( array(
			'name'    => __( 'Test Color Picker', 'mortgage_calculator' ),
			'desc'    => __( 'field description (optional)', 'mortgage_calculator' ),
			'id'      => 'test_colorpicker',
			'type'    => 'colorpicker',
			'default' => '#bada55',
		) );

	}

	/**
	 * Defines the theme option metabox and field configuration
	 * @since  0.1.0
	 * @return array
	 */
	public function option_metabox() {
		return ;
	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'fields', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}

		throw new Exception( 'Invalid property: ' . $field );
	}

}

// Get it started
$GLOBALS['mortgage_calculator_Admin'] = new mortgage_calculator_Admin();
$GLOBALS['mortgage_calculator_Admin']->hooks();

/**
 * Helper function to get/return the mortgage_calculator_Admin object
 * @since  0.1.0
 * @return mortgage_calculator_Admin object
 */
function mortgage_calculator_Admin() {
	global $mortgage_calculator_Admin;
	return $mortgage_calculator_Admin;
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function mortgage_calculator_get_option( $key = '' ) {
	global $mortgage_calculator_Admin;
	return cmb2_get_option( $mortgage_calculator_Admin->key, $key );
	
}
