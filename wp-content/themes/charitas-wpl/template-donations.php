<?php
/**
 * Template Name: Make a donation
 *
 * @package WordPress
 * @subpackage Charitas
 * @since Charitas 1.1.0
 */
?>
<?php get_header(); ?>
<div class="item teaser-page-list">
		<div class="container_16">
			<aside class="grid_10">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</aside>
			<?php if ( ot_get_option('wpl_breadcrumbs') != "off") { ?>
				<div class="grid_6">
					<div id="rootline">
						<?php wplook_breadcrumbs(); ?>	
					</div>
				</div>
			<?php } ?>
			<div class="clear"></div>
		</div>
	</div>
	
	<div id="main" class="site-main container_16">
		<div class="inner">
			<div id="primary" class="grid_11 suffix_1">
				<div class="donation-box">
					<div class="donation-box-margins">
						<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
							<?php the_content(); ?>
						<?php endwhile; // end of the loop. ?>

						<form class="donatenow" action="<?php echo get_template_directory_uri() ?>/inc/paypal/buy.php" method="post">
							<label class="donate-box">
								<input name="amount" type="number" min="<?php echo ot_get_option('wpl_min_amount') ?>" placeholder="<?php _e('Custom Amount in', 'wplook'); ?> <?php echo ot_get_option('wpl_curency_code') ?>" title="<?php _e('Custom Amount', 'wplook'); ?>">
							</label>
							<label class="donate-boxselect">
								<select name="cause">
									<option value="0|#| <?php _e('General Donation', 'wplook'); ?>" <?php selected( '0' ); ?>><?php _e('General Donation', 'wplook'); ?></option>
										<?php $args = array( 'post_type' => 'post_causes','post_status' => 'publish', 'posts_per_page' => 1000, 'paged'=> $paged); ?>
										<?php $wp_query = null; ?>
										<?php $wp_query = new WP_Query( $args ); ?>
										<?php if ( $wp_query->have_posts() ) : 
										$id = get_the_ID();
										while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
											<option value="<?php echo $id; ?>|#| <?php the_title(); ?>" <?php selected( '<?php the_title(); ?>' ); ?>><?php the_title(); ?></option>
										<?php endwhile; wp_reset_postdata(); ?>
										<?php endif; ?>
								</select>
							</label>
							<label class="donate-box">
								<p>
									<input  class="buttons donate" value="<?php _e('Donate Now', 'wplook'); ?>" type="submit"></input >
									<input type="hidden" name="submitted" id="submitted" value="true" />
								</p>
							</label>
						</form>
					</div>
				</div>


			</div>
	
			<?php get_sidebar('causes'); ?>
			<div class="clear"></div>
		</div>
	</div>
<?php get_footer(); ?>