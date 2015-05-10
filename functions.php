<?php

/**
 * Custom Child Theme Functions
 *
 * This file's parent directory can be moved to the wp-content/themes directory 
 * to allow this Child theme to be activated in the Appearance - Themes section of the WP-Admin.
 *
 * Included is a basic theme setup that will add the reponsive stylesheet that comes with Thematic. 
 *
 * More ideas can be found in the community documentation for Thematic
 * @link http://docs.thematictheme.com
 *
 * @package ThematicSampleChildTheme
 * @subpackage ThemeInit
 */


/**
 * Use the parent stylesheet
 * 
 * This will enqueue Thematic's responsive stylesheet before the child theme's style.css.
 * Any style declarations written in style.css will override the parent styles.
 */

/**
 * In this file mentally replace the word 'logo' for 'background' and vise versa
 */


// Default function included with thematic
function samplechildtheme_add_thematic_styledependency() {
	return array( 'thematic-main' );  
}
add_action( 'thematic_childtheme_style_dependencies', 'samplechildtheme_add_thematic_styledependency' );

// Adds top navigation
function addTopNav() {
	wp_nav_menu( array( 'theme_location' => 'top-menu', 'container_class' => 'top_menu' ) );
}
add_action('thematic_aboveheader', 'addTopNav');


/**
 * Use WC 2.0 variable price format, now include sale price strikeout
 *
 * @param  string $price
 * @param  object $product
 * @return string
 */
function wc_wc20_variation_price_format( $price, $product ) {
	// Main Price
	$prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
	$price = $prices[0] !== $prices[1] ? sprintf( __( '%1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

	// Sale Price
	$prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
	sort( $prices );
	$saleprice = $prices[0] !== $prices[1] ? sprintf( __( '%1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

	if ( $price !== $saleprice ) {
		$price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
	}

	return $price;
}
add_filter( 'woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2 );

// Removes sorting on the shop page
function init() {
	if(is_shop()) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	}
}
add_action( 'wp', 'init' );

// Shows 12 products per page
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

// Defines custom menu
function childtheme_register_menus() {
	if (function_exists( 'register_nav_menu' )) {
		echo '';
	}
}
add_action('thematic_child_init', 'childtheme_register_menus');

// Adds custom fonts and script and favicons
function add_fonts() {
	?>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/avargadi/favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/avargadi/favicons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/avargadi/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/avargadi/favicons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/avargadi/favicons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/avargadi/favicons/apple-touch-icon-120x120.png">
	<link rel="icon" type="image/png" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/avargadi/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/avargadi/favicons/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/avargadi/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/avargadi/favicons/manifest.json">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="<?php bloginfo('wpurl'); ?>/wp-content/themes/avargadi/js/app.js"></script>
<?php
}
add_action('wp_head', 'add_fonts');

// Adds proper classes and markup to the header
function modify_header() {
	echo '<div id="header"><nav id="header-nav" class="clearfix">';
}

// Adds proper closing markup to the header
function modify_header_bottom() {
	echo '</nav></div>';
}

// Remove the 'showing xx results' on the category page
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );


/*---- CHILD THEME OPTIONS starts here ----*/
// Adds menu to the child theme
function childtheme_add_admin() {
	add_submenu_page('themes.php', 'Wombat home Theme Options', 'Wombat home Theme Options', 'edit_themes', basename(__FILE__), 'childtheme_admin');
}
add_action('admin_menu' , 'childtheme_add_admin');


function childtheme_admin() {
	
	$child_theme_image       = get_option('child_theme_image'); //Background Image
    $child_theme_header_logo = get_option('child_theme_header_logo'); //Logo Image
    $child_theme_footer_1    = get_option('child_theme_footer_1');
    $child_theme_footer_2    = get_option('child_theme_footer_2');
    $child_theme_footer_3    = get_option('child_theme_footer_3');
    $child_theme_footer_4    = get_option('child_theme_footer_4');
		$child_theme_analytics   = get_option('child_theme_analytics'); // Analytics
		$child_theme_advertising = get_option('child_theme_advertising'); // Advertising
    $child_theme_copyright   = get_option('child_theme_copyright');
	$enabled = TRUE; /* get_option('child_theme_logo_enabled'); */
	
	if ($_POST['options-submit']){
		$enabled = htmlspecialchars($_POST['enabled']);
		update_option('child_theme_logo_enabled', $enabled);

		$file_name = $_FILES['logo_image']['name']; //Background Image
		$temp_file = $_FILES['logo_image']['tmp_name']; //Background Image
		$file_type = $_FILES['logo_image']['type']; //Background Image

        $file_name_logo = $_FILES['header_logo']['name']; //Logo Image
		$temp_file_logo = $_FILES['header_logo']['tmp_name']; //Logo Image
		$file_type_logo = $_FILES['header_logo']['type']; //Logo Image

        // Save footer Text
        $child_theme_footer_1 = $_POST['footer_1'];
            //echo '<div class="updated"><h4>Footer Area 1 Updated Successfully</h4></div>';
		    update_option('child_theme_footer_1', $child_theme_footer_1);
        
        $child_theme_footer_2 = $_POST['footer_2'];
            //echo '<div class="updated"><h4>Footer Area 2 Updated Successfully</h4></div>';
		    update_option('child_theme_footer_2', $child_theme_footer_2);
        
        $child_theme_footer_3 = $_POST['footer_3'];
            //echo '<div class="updated"><h4>Footer Area 3 Updated Successfully</h4></div>';
		    update_option('child_theme_footer_3', $child_theme_footer_3);

        $child_theme_footer_4 = $_POST['footer_4'];
            //echo '<div class="updated"><h4>Footer Area 4 Updated Successfully</h4></div>';
		    update_option('child_theme_footer_4', $child_theme_footer_4);
		
				$child_theme_analytics = $_POST['footer_5'];
            //echo '<div class="updated"><h4>Footer Area 5 Updated Successfully</h4></div>';
		    update_option('child_theme_analytics', $child_theme_analytics);
		
				$child_theme_advertising = $_POST['footer_6'];
            //echo '<div class="updated"><h4>Footer Area 5 Updated Successfully</h4></div>';
		    update_option('child_theme_advertising', $child_theme_advertising);

        $child_theme_copyright = $_POST['copyright_info'];
            //echo '<div class="updated"><h4>Copyright Information Updated Successfully</h4></div>';
		    update_option('child_theme_copyright', $child_theme_copyright);

        /*-- Background Image --*/
		if($file_type=="image/gif" || $file_type=="image/jpeg" || $file_type=="image/pjpeg" || $file_type=="image/png"){
			$length=filesize($temp_file);
			$fd = fopen($temp_file,'rb');
			$file_content=fread($fd, $length);
			fclose($fd);
			
			$wud = wp_upload_dir();
			
			if (file_exists($wud[path].'/'.strtolower($file_name))){
				unlink ($wud[path].'/'.strtolower($file_name));
			}
			
			$upload = wp_upload_bits( $file_name, '', $file_content);
		//	echo $upload['error'];

			$child_theme_image = $wud[url].'/'.strtolower($file_name);
			echo '<div class="updated"><h4>Path to file :</h4><p>'.get_option('child_theme_image').'</p></div>';
			update_option('child_theme_image', $child_theme_image);
		}
	    
        /*-- Logo Image --*/
        if($file_type_logo=="image/gif" || $file_type_logo=="image/jpeg" || $file_type_logo=="image/pjpeg" || $file_type_logo=="image/png"){
			$length=filesize($temp_file_logo);
			$fd = fopen($temp_file_logo,'rb');
			$file_content=fread($fd, $length);
			fclose($fd);
			
			$wud = wp_upload_dir();
			
			if (file_exists($wud[path].'/'.strtolower($file_name_logo))){
				unlink ($wud[path].'/'.strtolower($file_name_logo));
			}
			
			$upload = wp_upload_bits( $file_name_logo, '', $file_content);
		//	echo $upload['error'];

			$child_theme_header_logo = $wud[url].'/'.strtolower($file_name_logo);
			echo '<div class="updated"><h4>Path to file :</h4><p>'.get_option('child_theme_header_logo').'</p></div>';
			update_option('child_theme_header_logo', $child_theme_header_logo);
		}

		?>
			<div class="updated"><p>Your new options have been successfully saved.</p></div>
		<?php

	}
	
	/*if($enabled) $checked='checked="checked"';*/


	?>
		<div class="wrap">
			<div id="icon-themes" class="icon32"></div>
			<h1>Wombat home Theme Options</h1>
			<form name="theform" method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);?>">
				<table class="form-table">
                    <tr><h2>Background Image</h2></tr>
					<!--<tr>
						<td width="200">Check this box to display background image:</td>
						<td><input type="checkbox" name="enabled" value="1" <?php echo $checked; ?>/></td>
					</tr>-->
<!--					<tr>
						<td>Background image:</td>
						<td><img style="width:256px;height:auto" src="<?php echo $child_theme_image; ?>" /></td>
					</tr>-->
					<!--<tr>
						<td>Background image to use (gif/jpeg/png):</td>
						<td><input type="file" name="logo_image"><br />(you must have writing permissions for your uploads directory)</td>
					</tr>-->
				</table>
        <table class="form-table">
          <tr><h2>Logo</h2></tr>
					<tr>
						<td>Logo Image(minimun width should be 320px):</td>
						<td><img style="width:256px;height:auto" src="<?php echo $child_theme_header_logo; ?>" /></td>
					</tr>
					<tr>
						<td>Logo image to use (gif/jpeg/png):</td>
						<td><input type="file" name="header_logo"><br />(you must have writing permissions for your uploads directory)</td>
					</tr>
				</table>
                <table class="form-table">
                    <tr><h2>Footer</h2></tr>
					<tr>
						<td>Area 1:</td>
						<td><p>Enter text for area 1 <br /></p>
							<textarea name="footer_1" ><?php echo stripslashes($child_theme_footer_1); ?></textarea>
						</td>
					</tr>
					<tr>
						<td>Area 2:</td>
						<td><p>Enter text for area 2 <br /></p>
							<textarea name="footer_2"><?php echo stripslashes($child_theme_footer_2); ?></textarea>
						</td>
					</tr>
          <tr>
						<td>Area 3:</td>
						<td><p>Enter text for area 3 <br /></p>
							<textarea name="footer_3"><?php echo stripslashes($child_theme_footer_3); ?></textarea>
						</td>
					</tr>
          <tr>
						<td>Area 4:</td>
						<td><p>Enter text for area 4 <br /></p>
							<textarea name="footer_4"><?php echo stripslashes($child_theme_footer_4); ?></textarea>
						</td>
					</tr>
					<tr>
						<td>Analytics scripts</td>
						<td><p>Place all your analytics code here<br /></p>
							<textarea name="footer_5"><?php echo stripslashes($child_theme_analytics); ?></textarea>
						</td>
					</tr>
					<tr>
						<td>Advertising scripts</td>
						<td><p>Place all your advertising code here<br /></p>
							<textarea name="footer_6"><?php echo stripslashes($child_theme_advertising); ?></textarea>
						</td>
					</tr>
					<tr>
						<td>Copyright Information:</td>
						<td><input type="text" name="copyright_info" value="<?php echo $child_theme_copyright; ?>" /></td>
					</tr>

				</table>


				<input type="hidden" name="options-submit" value="1" />
				<p class="submit"><input type="submit" name="submit" value="Save Options" /></p>
			</form>
		</div>
	<?php
}

/*---- CHILD THEME OPTIONS ends here ----*/


if(TRUE) {
	
	function thematic_logo_image() {
		if(is_home() || is_page('Shop')) {
			echo '<div id="header" class="expanded" ><nav id="header-nav" class="clearfix">';
		} else {
			echo '<div id="header" ><nav id="header-nav" class="clearfix">';
		}
	}
	add_filter('thematic_open_header','thematic_logo_image');
} else {
	add_filter('thematic_open_header','modify_header');
}

/*---- Logo Options ----*/
function remove_thematic_blogtitle(){
    remove_action('thematic_header', 'thematic_blogtitle', 3);
}
add_action('init', 'remove_thematic_blogtitle');
function thematic_header_logo(){
    echo '<div id="blog-title"><a href="'.get_option('home').'"><img src="'.get_option('child_theme_header_logo').'"/></a></div>';
}
add_action('thematic_header', 'thematic_header_logo', 4);


/*---- Footer Options ----*/

function childtheme_override_siteinfoopen(){
    echo '';
}

function childtheme_override_siteinfoclose(){
    echo '';
}

function childtheme_override_siteinfo(){
	echo '<div class="footer-inner row">
				<div class="col-3">
				'.stripslashes(get_option('child_theme_footer_1')).'
				</div>
				<div class="col-3">
				'.stripslashes(get_option('child_theme_footer_2')).'
				</div>
				<div class="col-3">
				'.stripslashes(get_option('child_theme_footer_3')).'
				</div>
				<div class="col-3 last">
				'.stripslashes(get_option('child_theme_footer_4')).'
				</div>
			</div>
			<div class="copyright-info">
				'.stripslashes(get_option('child_theme_copyright')).'
			</div>
				';
}

// Adds description to category
function my_add_cat_description ($category) {
	$cat_id=$category->term_id;
	$prod_term=get_term($cat_id,'product_cat');
	$description=$prod_term->description;
	echo '<div class="shop-cat-desc">'.$description.'</div>';
}
add_action( 'woocommerce_after_subcategory_title', 'my_add_cat_description', 12);


add_filter('thematic_close_header','modify_header_bottom');

// Adds analytics and advertising scripts
function addAnalytics() {
	echo stripslashes(get_option('child_theme_analytics'));
	echo stripslashes(get_option('child_theme_advertising'));
}
add_action('thematic_belowfooter', 'addAnalytics');

/**
* Show all product attributes on the product page
*/
function isa_woocommerce_all_pa(){

	global $product;
	$attributes = $product->get_attributes();

	if ( ! $attributes ) {
		return;
	}

	$out = '';

	foreach ( $attributes as $attribute ) {

	// skip variations
	if ( $attribute['is_variation'] ) {
	continue;
	}

	if ( $attribute['is_taxonomy'] ) {

		$terms = wp_get_post_terms( $product->id, $attribute['name'], 'all' );

		// get the taxonomy
		$tax = $terms[0]->taxonomy;

		// get the tax object
		$tax_object = get_taxonomy($tax);

		// get tax label
		if ( isset ($tax_object->labels->name) ) {
			$tax_label = $tax_object->labels->name;
		} elseif ( isset( $tax_object->label ) ) {
			$tax_label = $tax_object->label;
		}

		foreach ( $terms as $term ) {

			$out .= $tax_label . ': ';
			$out .= $term->name . '<br />';

		}

		} else {
			$out .= $attribute['name'] . ': ';
			$out .= $attribute['value'] . '<br />';
			echo $out;
		}
	}
	echo $out;
}

add_action('woocommerce_single_product_summary', 'isa_woocommerce_all_pa', 25);

//Add Woocommerce body classes
add_filter('body_class','ttm_woocommerce_body_classes');
function ttm_woocommerce_body_classes($classes){
	global $post;
	$product = get_product( $post->ID );

	if(is_shop()) {
		$classes[] = 'shop';
	}
	return $classes;
}

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {
	unset( $tabs['additional_information'] );  	// Remove the additional information tab
	return $tabs;
}

// Remove trailing zeros on product prices
add_filter( 'woocommerce_price_trim_zeros', 'wc_hide_trailing_zeros', 10, 1 );
	function wc_hide_trailing_zeros( $trim ) {
	// set to false to show trailing zeros
	return true;
}
