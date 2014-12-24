<?php
/**
 * The default template for displaying Projects archive
 *
 * @package WordPress
 * @subpackage Charitas
 * @since Charitas 1.0
 */
?>

<?php get_header(); ?>

<div class="item teaser-page-list">

	<div class="container_16">
		<aside class="grid_10">
			<h1 class="page-title"><?php single_cat_title(); ?></h1>
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
			
			<?php if ( have_posts() ) : while (have_posts() ) : the_post(); ?>
				<article class="list">
					<div class="short-content">

						<?php if ( has_post_thumbnail() ) {?> 
							<figure>
								<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail('small-thumb'); ?>
									<div class="mask radius">
										<div class="mask-square"><i class="icon-file"></i></div>
									</div>
								</a>
							</figure>
						<?php } ?>

						<h1 class="entry-header">
							<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h1>

						<div class="short-description">
							<p><?php echo wplook_short_excerpt(ot_get_option('wpl_events_excerpt_limit'));?></p>
						</div>

						<div class="entry-meta">
							<time class="dtstart" datetime="">
								<a class="buttons time fleft" href="<?php the_permalink(); ?>"><i class="icon-calendar"></i> <?php wplook_get_date(); ?></a>
							</time>

							<a class="buttons fright " href="<?php the_permalink(); ?>" title="<?php _e('Read more', 'wplook'); ?>"><?php _e('Read more', 'wplook'); ?></a>
						</div>

						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</article>
			
			<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<p><?php _e('Sorry, no projects matched your criteria.', 'wplook'); ?></p>
			<?php endif; ?>
			
			<?php wplook_content_navigation('postnav' ) ?>

		</div>

		<?php get_sidebar('projects'); ?>
		<div class="clear"></div>
	</div>
</div>

<?php get_footer(); ?>