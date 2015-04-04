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
 * In this file mentally replase the word 'logo' for 'background' and vise versa
 */
function samplechildtheme_add_thematic_styledependency() {
	return array( 'thematic-main' );  
}
add_action( 'thematic_childtheme_style_dependencies', 'samplechildtheme_add_thematic_styledependency' );

function addTopNav() {
	wp_nav_menu( array( 'theme_location' => 'top-menu', 'container_class' => 'top_menu' ) );
}
add_action('thematic_aboveheader', 'addTopNav');

/**
 * Define theme setup
 */
function samplechildtheme_setup() {
	// Add any additional functionality for your theme here
}
add_action( 'after_setup_theme', 'samplechildtheme_setup' );

/*
 * Shows 12 products per page
 */
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );
/*
 * Remove billing form
 */
/*add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
 
function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_first_name']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_phone']);
    unset($fields['order']['order_comments']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_email']);
    unset($fields['billing']['billing_city']);
    return $fields;
}*/

/*
 * Custom theme  modifications
 */


 //-------------- Defines New Menu
 // register two additional custom menus
function childtheme_register_menus() {
    if (function_exists( 'register_nav_menu' )) {
        echo '';
    }
}
add_action('thematic_child_init', 'childtheme_register_menus');


function add_fonts() { ?>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
<?php }
add_action('wp_head', 'add_fonts');


function modify_header() {
	echo '<div id="header"><nav id="header-nav" class="clearfix">';
	/*if (is_page('Shop')) {
		echo '<h';	
	} else {
		echo '<div id="header"><nav id="header-nav" class="clearfix">';
	}*/
}



function modify_header_bottom() {
	echo '</nav></div>';
}


/* Remove the 'showing xx results' on the category page */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

// ---------- "Child Theme Options" menu STARTS HERE

add_action('admin_menu' , 'childtheme_add_admin');
function childtheme_add_admin() {
	add_submenu_page('themes.php', 'Avargadi Theme Options', 'Avargadi Theme Options', 'edit_themes', basename(__FILE__), 'childtheme_admin');
}

function childtheme_admin() {
	
	$child_theme_image       = get_option('child_theme_image'); //Background Image
    $child_theme_header_logo = get_option('child_theme_header_logo'); //Logo Image
    $child_theme_footer_1    = get_option('child_theme_footer_1');
    $child_theme_footer_2    = get_option('child_theme_footer_2');
    $child_theme_footer_3    = get_option('child_theme_footer_3');
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
			<h1>Child Theme Options</h1>
			<form name="theform" method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);?>">
				<table class="form-table">
                    <tr><h2>Background Image</h2></tr>
					<!--<tr>
						<td width="200">Check this box to display background image:</td>
						<td><input type="checkbox" name="enabled" value="1" <?php echo $checked; ?>/></td>
					</tr>-->
					<tr>
						<td>Background image:</td>
						<td><img style="width:256px;height:auto" src="<?php echo $child_theme_image; ?>" /></td>
					</tr>
					<tr>
						<td>Background image to use (gif/jpeg/png):</td>
						<td><input type="file" name="logo_image"><br />(you must have writing permissions for your uploads directory)</td>
					</tr>
				</table>
                <table class="form-table">
                    <tr><h2>Logo</h2></tr>
					<tr>
						<td>Logo Image:</td>
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
						<td><p>Enter text for area 1 <br /></p><textarea name="footer_1" ><?php echo $child_theme_footer_1; ?></textarea></td>
					</tr>
					<tr>
						<td>Area 2:</td>
						<td><p>Enter text for area 2 <br /></p><textarea name="footer_2"><?php echo $child_theme_footer_2; ?></textarea></td>
					</tr>
                    <tr>
						<td>Area 3:</td>
						<td><p>Enter text for area 3 <br /></p><textarea name="footer_3"><?php echo $child_theme_footer_3; ?></textarea></td>
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


// ---------- "Child Theme Options" menu ENDS HERE

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
            <div class="col-4">
            '.get_option('child_theme_footer_1').'
            </div>
            <div class="col-4">
            '.get_option('child_theme_footer_2').'
            </div>
            <div class="col-4 last">
            '.get_option('child_theme_footer_3').'
            </div>
          </div>
          <div class="copyright-info">
            '.get_option('child_theme_copyright').'
          </div>
            ';
}

/*function childtheme_copyright_info(){
    echo '<div class="footer-inner">
            Copyright Info
          </div>';
}
add_action('thematic_belowfooter', 'childtheme_copyright_info', 4);*/


/*function modify_homepage_content() {
	echo '<h1>Haaaa</h1>';
}

add_filter('thematic_opencontainer', 'modify_homepage_content');*/

//Display product category descriptions under category image/title on woocommerce shop page */

function my_add_cat_description ($category) {
	$cat_id=$category->term_id;
	$prod_term=get_term($cat_id,'product_cat');
	$description=$prod_term->description;
	echo '<div class="shop-cat-desc">'.$description.'</div>';
}


add_action( 'woocommerce_after_subcategory_title', 'my_add_cat_description', 12);


add_filter('thematic_close_header','modify_header_bottom');
