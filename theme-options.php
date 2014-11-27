<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'sculp_options', 'sculp_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Avargadi theme Options', 'sculptheme' ), __( 'Avargadi theme Options', 'sculptheme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options', 'sculptheme' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'sculptheme' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'sculp_options' ); ?>
			<?php $options = get_option( 'sculp_theme_options' ); ?>

			<table class="form-table">

				<?php
				/**
				 * A Enter complete url including http:// option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Contact No.', 'sculptheme' ); ?></th>
					<td>
						<input id="sculp_theme_options[contactno]" class="regular-text" type="text" name="sculp_theme_options[contactno]" value="<?php esc_attr_e( $options['contactno'] ); ?>" />
						<label class="description" for="sculp_theme_options[contactno]"><?php _e( 'Number at the top', 'sculptheme' ); ?></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Your E-mail', 'sculptheme' ); ?></th>
					<td>
						<input id="sculp_theme_options[youremail]" class="regular-text" type="text" name="sculp_theme_options[youremail]" value="<?php esc_attr_e( $options['youremail'] ); ?>" />
						<label class="description" for="sculp_theme_options[youremail]"><?php _e( 'E-mail at the top', 'sculptheme' ); ?></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Linked in', 'sculptheme' ); ?></th>
					<td>
						<input id="sculp_theme_options[linkedin]" class="regular-text" type="text" name="sculp_theme_options[linkedin]" value="<?php esc_attr_e( $options['linkedin'] ); ?>" />
						<label class="description" for="sculp_theme_options[linkedin]"><?php _e( 'Enter complete url including http://', 'sculptheme' ); ?></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Facebook', 'sculptheme' ); ?></th>
					<td>
						<input id="sculp_theme_options[facebook]" class="regular-text" type="text" name="sculp_theme_options[facebook]" value="<?php esc_attr_e( $options['facebook'] ); ?>" />
						<label class="description" for="sculp_theme_options[facebook]"><?php _e( 'Enter complete url including http://', 'sculptheme' ); ?></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Twitter', 'sculptheme' ); ?></th>
					<td>
						<input id="sculp_theme_options[twitter]" class="regular-text" type="text" name="sculp_theme_options[twitter]" value="<?php esc_attr_e( $options['twitter'] ); ?>" />
						<label class="description" for="sculp_theme_options[twitter]"><?php _e( 'Enter complete url including http://', 'sculptheme' ); ?></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Dots', 'sculptheme' ); ?></th>
					<td>
						<input id="sculp_theme_options[dots]" class="regular-text" type="text" name="sculp_theme_options[dots]" value="<?php esc_attr_e( $options['dots'] ); ?>" />
						<label class="description" for="sculp_theme_options[dots]"><?php _e( 'Enter complete url including http://', 'sculptheme' ); ?></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Youtube', 'sculptheme' ); ?></th>
					<td>
						<input id="sculp_theme_options[youtube]" class="regular-text" type="text" name="sculp_theme_options[youtube]" value="<?php esc_attr_e( $options['youtube'] ); ?>" />
						<label class="description" for="sculp_theme_options[youtube]"><?php _e( 'Enter complete url including http://', 'sculptheme' ); ?></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Thumbnail Heading', 'sculptheme' ); ?></th>
					<td>
						<input id="sculp_theme_options[recent]" class="regular-text" type="text" name="sculp_theme_options[recent]" value="<?php esc_attr_e( $options['recent'] ); ?>" />
						<label class="description" for="sculp_theme_options[recent]"><?php _e( 'Default : Recent Works, Should not be a long line', 'sculptheme' ); ?></label>
					</td>
				</tr>

				<?php
				/**
				 * A sculp textarea option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'A textbox', 'sculptheme' ); ?></th>
					<td>
						<textarea id="sculp_theme_options[facebookarea]" class="large-text" cols="50" rows="10" name="sculp_theme_options[facebookarea]"><?php echo esc_textarea( $options['facebookarea'] ); ?></textarea>
						<label class="description" for="sculp_theme_options[facebookarea]"><?php _e( 'sculp text box', 'sculptheme' ); ?></label>
					</td>
				</tr>
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'sculptheme' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	global $select_options, $radio_options;

	// Say our text option must be safe text with no HTML tags
	$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );

	// Say our textarea option must be safe text with the allowed tags for posts
	$input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );

	return $input;
}