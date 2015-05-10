<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

		<?php endif; ?>

		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
		
		<?php
			if(is_shop()) {
				
				/*
				 * Arranges shop page to display categories and their corresponding products
				 */
				$taxonomy     = 'product_cat';
				$orderby      = 'desc';  
				$show_count   = 0;      // 1 for yes, 0 for no
				$pad_counts   = 0;      // 1 for yes, 0 for no
				$hierarchical = 0;      // 1 for yes, 0 for no  
				$title        = '';  
				$empty        = 0;

				$args = array(
					'taxonomy'     => $taxonomy,
					'orderby'      => $orderby,
					'show_count'   => $show_count,
					'pad_counts'   => $pad_counts,
					'hierarchical' => $hierarchical,
					'title_li'     => $title,
					'hide_empty'   => $empty
				);

				$all_categories = get_categories( $args );
				
				// Show 'featured' category first
				foreach ($all_categories as $cat) {
					if($cat->name === 'Featured') {
						echo '<h2 class="category-title"><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a></h2>';
						$category_id = $cat->term_id;
						$term = get_term( $cat->term_id, 'product_cat' );
						$count = $term->count;
						$args = array( 'post_type' => 'product', 'posts_per_page' => 4, 'product_cat' => $cat->name );
						$loop = new WP_Query( $args );
						echo '<ul class="products">';
						if($count >= 1) {
							while ( $loop->have_posts() ) : $loop->the_post();
								global $product;
								woocommerce_get_template_part( 'content', 'product' );
							endwhile;
						}
						echo '</ul>';
						wp_reset_query();
					}
				}
				// Show all other categories excluding featured
				foreach ($all_categories as $cat) {
					if($cat->category_parent == 0 && $cat->name != 'Featured') {
						$category_id = $cat->term_id;
						$term = get_term( $cat->term_id, 'product_cat' );
						$count = $term->count;
						if($count >= 1) {
							echo '<h2 class="category-title"><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a></h2>';
						}
							$args = array( 'post_type' => 'product', 'posts_per_page' => 4, 'product_cat' => $cat->name );
							$loop = new WP_Query( $args );
							echo '<ul class="products">';
							if($count >= 1) {
								while ( $loop->have_posts() ) : $loop->the_post();
									global $product;
									woocommerce_get_template_part( 'content', 'product' );
								endwhile;
							}
							echo '</ul>';
							wp_reset_query();


					}
				}
				
			}
			?>

		
			<?php

				if(!is_shop()) {
					woocommerce_product_loop_start();

					woocommerce_product_subcategories();

					while ( have_posts() ) : the_post();

					wc_get_template_part( 'content', 'product' );

					endwhile; // end of the loop.

					woocommerce_product_loop_end();
				}
			?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>