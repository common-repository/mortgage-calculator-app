<?php


class MortgageCalculatorCustomPostType{

private $post_type = 'mortgagecalculator';
private $post_label = 'Mortgage Calculator';
private $prefix = '_mortgage_calculator_';
function __construct() {
	
	
	//add_action("init", array(&$this,"create_post_type"));
	add_action( 'init', array(&$this, 'mortgage_calculator_register_shortcodes'));
	add_action( 'wp_enqueue_scripts', array(&$this, 'register_scripts'));
	//add_action( 'wp_enqueue_scripts', array(&$this, 'enqueue_styles'));
	//add_action( 'wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
	
	//add_action( 'cmb2_init', array(&$this,'mortgagecalculator_register_metabox' ));
	
	//register_activation_hook( __FILE__, array(&$this,'activate' ));
}

function create_post_type(){
	register_post_type($this->post_type, array(
	         'label' => _x($this->post_label, $this->post_type.' label'), 
	         'singular_label' => _x('All '.$this->post_label, $this->post_type.' singular label'), 
	         'public' => true, // These will be public
	         'show_ui' => true, // Show the UI in admin panel
	         '_builtin' => false, // This is a custom post type, not a built in post type
	         '_edit_link' => 'post.php?post=%d',
	         'capability_type' => 'page',
	         'hierarchical' => false,
	         'rewrite' => array("slug" => $this->post_type), // This is for the permalinks
	         'query_var' => $this->post_type, // This goes to the WP_Query schema
	         //'supports' =>array('title', 'editor', 'custom-fields', 'revisions', 'excerpt'),
	         'supports' =>array('title', 'author'),
	         'add_new' => _x('Add New', 'Event')
	         ));
}

/**************************************************
**********************CMB2*************************
*/


/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */

function mortgagecalculator_register_metabox() {

	// Start with an underscore to hide fields from custom fields list
	//$prefix = '_mortgagecalculator_demo_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $this->prefix . 'metabox',
		'title'         => __( 'Test Metabox', 'cmb2' ),
		'object_types'  => array( $this->post_type, ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );

	$cmb_demo->add_field( array(
		'name'       => __( 'Test Text', 'cmb2' ),
		'desc'       => __( 'field description (optional)', 'cmb2' ),
		'id'         => $this->prefix . 'text',
		'type'       => 'text',
		'show_on_cb' => 'mortgagecalculator_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		'repeatable'      => true,
	) );

}

/************************************************
*******************End CMB2**********************
*/








function mortgage_calculator_shortcode($atts){
		extract( shortcode_atts( array(
			'id' => '',
		), $atts ) );
		$this->enqueue_scripts();
		ob_start();
		include $dir.'template/mortgageCalculatorTemplate.php';
		return ob_get_clean();
}



function mortgage_calculator_register_shortcodes(){
		add_shortcode( 'mortgage_calculator', array(&$this,'mortgage_calculator_shortcode' ));
	}


function activate() {
	// register taxonomies/post types here
	$this->create_post_type();
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function enqueue_styles(){
	wp_register_style( 'mortgage-calculator-css', plugin_dir_url(__FILE__).'css/mortgageCalculator.css' );
	wp_enqueue_style('mortgage-calculator-css');
}

function enqueue_scripts(){
	//wp_enqueue_script('accrue-js', plugin_dir_url(__FILE__).'js/accrue-js/jquery.accrue.min.js');
	//wp_enqueue_script('mortgage-calculator-js', plugin_dir_url(__FILE__).'js/mortgageCalculator.js');
	wp_enqueue_style('mortgage-calculator-css');
	wp_enqueue_script('accrue-js');
	wp_enqueue_script('mortgage-calculator-js');
}

function enqueue_calculator_script(){
	wp_enqueue_script('mortgage-calculator-js', plugin_dir_url(__FILE__).'js/mortgageCalculator.js');
}

function register_scripts() {
	wp_register_style( 'mortgage-calculator-css', plugin_dir_url(__FILE__).'css/mortgageCalculator.css' );
	wp_register_script( 'accrue-js', plugin_dir_url(__FILE__).'js/accrue-js/jquery.accrue.min.js' , array(), '1.0.0', true );
	wp_register_script( 'mortgage-calculator-js', plugin_dir_url(__FILE__).'js/mortgageCalculator.js', array(), '1.0.0', true );
}



}// end MortgageCalculatorCustomPostType class

new MortgageCalculatorCustomPostType();


?>