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



/**
 * Define theme setup
 */
function samplechildtheme_setup() {
	// Add any additional functionality for your theme here
}
add_action( 'after_setup_theme', 'samplechildtheme_setup' );


/*
 * Custom theme  modifications
 */

function add_fonts() { ?>
	<link href='http://fonts.googleapis.com/css?family=Maven+Pro:500,400' rel='stylesheet' type='text/css'>
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

/* Remove breadcrumbs */
add_action( 'init', 'jk_remove_wc_breadcrumbs' );
function jk_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

// ---------- "Child Theme Options" menu STARTS HERE

add_action('admin_menu' , 'childtheme_add_admin');
function childtheme_add_admin() {
	add_submenu_page('themes.php', 'Avargadi Theme Options', 'Avargadi Theme Options', 'edit_themes', basename(__FILE__), 'childtheme_admin');
}

function childtheme_admin() {
	
	$child_theme_image       = get_option('child_theme_image');
    $child_theme_header_logo = get_option('child_theme_header_logo');
	$enabled = TRUE; /* get_option('child_theme_logo_enabled'); */
	
	if ($_POST['options-submit']){
		$enabled = htmlspecialchars($_POST['enabled']);
		update_option('child_theme_logo_enabled', $enabled);

		$file_name = $_FILES['logo_image']['name'];
		$temp_file = $_FILES['logo_image']['tmp_name'];
		$file_type = $_FILES['logo_image']['type'];

        $file_name_logo = $_FILES['header_logo']['name'];
		$temp_file_logo = $_FILES['header_logo']['tmp_name'];
		$file_type_logo = $_FILES['header_logo']['type'];
		
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
						<td>Logo image:</td>
						<td><img style="width:256px;height:auto" src="<?php echo $child_theme_header_logo; ?>" /></td>
					</tr>
					<tr>
						<td>Logo image to use (gif/jpeg/png):</td>
						<td><input type="file" name="header_logo"><br />(you must have writing permissions for your uploads directory)</td>
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
			echo '<div id="header" class="expanded" style=background-image:url("'.get_option('child_theme_image').'") ><nav id="header-nav" class="clearfix">';
		} else {
			echo '<div id="header" style=background-image:url("'.get_option('child_theme_image').'") ><nav id="header-nav" class="clearfix">';
		}
	}
	add_filter('thematic_open_header','thematic_logo_image');
} else {
	add_filter('thematic_open_header','modify_header');
}
function remove_thematic_blogtitle(){
    remove_action('thematic_header', 'thematic_blogtitle', 3);
}
add_action('init', 'remove_thematic_blogtitle');
function thematic_header_logo(){
    echo '<div id="blog-title"><a href="'.get_option('home').'"><img src="'.get_option('child_theme_header_logo').'"/></a></div>';
}
add_action('thematic_header', 'thematic_header_logo', 4);


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
