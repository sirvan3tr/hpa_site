<?php
/*
 * Plugin Name: Staff
 * Plugin URI: http://www.wplook.com
 * Description: This is a widget to display Staff members
 * Author: Victor Tihai
 * Version: 1.0
 * Author URI: http://www.wplook.com
*/

add_action('widgets_init', create_function('', 'return register_widget("wplook_staff_widget");'));
class wplook_staff_widget extends WP_Widget {


	/*-----------------------------------------------------------------------------------*/
	/*	Widget actual processes
	/*-----------------------------------------------------------------------------------*/
	
	public function __construct() {
		parent::__construct(
	 		'wplook_staff_widget',
			'WPlook Staff',
			array( 'description' => __( 'A widget for displaying staff', 'wplook' ), )
		);
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Outputs the options form on admin
	/*-----------------------------------------------------------------------------------*/

	public function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
		}
		else {
			$title = __( 'Staff', 'wplook' );
		}

		if ( $instance ) {
			$categories = esc_attr( $instance[ 'categories' ] );
		}
		else {
			$categories = __( 'All', 'wplook' );
		}

		if ( $instance ) {
			$nr_posts = esc_attr( $instance[ 'nr_posts' ] );
		}
		else {
			$nr_posts = __( '4', 'wplook' );
		}

		if ( $instance ) {
			$display_type = esc_attr( $instance[ 'display_type' ] );
		}
		else {
			$display_type = __( 'random', 'wplook' );
		}

		if ( $instance ) {
			$read_more_link = esc_attr( $instance[ 'read_more_link' ] );
		}
		else {
			$read_more_link = __( '', 'wplook' );
		}

		if ( $instance ) {
			$clear_after = esc_attr( $instance[ 'clear_after' ] );
		}
		else {
			$clear_after = __( '1', 'wplook' );
		}

		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title:', 'wplook'); ?> </label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('categories'); ?>">
					<?php _e('Category:', 'wplook'); ?>
					<br />
				</label>
				
				<?php wp_dropdown_categories(
					array( 
						'name'	=> $this->get_field_name("categories"),
						'show_option_all'    => __('All', 'wplook'),
						'show_count'	=> 1,
						'selected' => $categories,
						'taxonomy'  => 'wpl_staff_category' 
					) 
				); ?>
				
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('nr_posts'); ?>"> <?php _e('Number of Candidates:', 'wplook'); ?> </label>
				<input class="widefat" id="<?php echo $this->get_field_id('nr_posts'); ?>" name="<?php echo $this->get_field_name('nr_posts'); ?>" type="text" value="<?php echo $nr_posts; ?>" />
				<p style="font-size: 10px; color: #999; margin: -10px 0 0 0px; padding: 0px;"> <?php _e('Number of Candidates you want to display', 'wplook'); ?></p>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('display_type'); ?>"><?php _e('Order by:', 'wplook'); ?> <br /> </label>
				<select id="<?php echo $this->get_field_id('display_type'); ?>" name="<?php echo $this->get_field_name('display_type'); ?>">
					<option value="random" <?php selected( 'random', $display_type ); ?>><?php _e('Random', 'wplook'); ?></option>
					<option value="Latest" <?php selected( 'Latest', $display_type ); ?>><?php _e('Latest', 'wplook'); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('read_more_link'); ?>"> <?php _e('URL to all Candidates:', 'wplook'); ?> </label>
				<input class="widefat" id="<?php echo $this->get_field_id('read_more_link'); ?>" name="<?php echo $this->get_field_name('read_more_link'); ?>" type="text" value="<?php echo $read_more_link; ?>" />
				<p style="font-size: 10px; color: #999; margin: -10px 0 0 0px; padding: 0px;"> <?php _e('View all candidates URL', 'wplook'); ?></p>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('size'); ?>">
					<?php _e('Clear after?', 'wplook'); ?>
					<br />
				</label>
				<select id="<?php echo $this->get_field_id('clear_after'); ?>" name="<?php echo $this->get_field_name('clear_after'); ?>">
					<option value="0" <?php selected( '0', $clear_after ); ?>><?php _e('Yes', 'wplook'); ?></option>
					<option value="1" <?php selected( '1', $clear_after ); ?>><?php _e('No', 'wplook'); ?></option>
				</select>
				<p style="font-size: 10px; color: #999; margin: -10px 0 0 0px; padding: 0px;"> <?php _e('Clear after if you want to add one more widged after this widget', 'wplook'); ?></p>
			</p>

		<?php 
	}
	

	/*-----------------------------------------------------------------------------------*/
	/*	Processes widget options to be saved
	/*-----------------------------------------------------------------------------------*/
	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['categories'] = sanitize_text_field($new_instance['categories']);
		$instance['nr_posts'] = sanitize_text_field($new_instance['nr_posts']);
		$instance['display_type'] = sanitize_text_field($new_instance['display_type']);
		$instance['clear_after'] = sanitize_text_field($new_instance['clear_after']);
		$instance['read_more_link'] = sanitize_text_field($new_instance['read_more_link']);
		return $instance;
	}


	/*-----------------------------------------------------------------------------------*/
	/*	Outputs the content of the widget
	/*-----------------------------------------------------------------------------------*/

	public function widget( $args, $instance ) {
		global $post;
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$categories = apply_filters( 'widget_categories', $instance['categories'] );
		$nr_posts = apply_filters( 'widget', $instance['nr_posts'] );
		$display_type = apply_filters( 'widget', $instance['display_type'] );
		$clear_after = apply_filters('widget_clear_after', $instance['clear_after']);
		$read_more_link = apply_filters( 'widget', $instance['read_more_link'] );
		?>
		
		<?php
			if ( $categories < '1' ) {
				if ( $display_type == 'random') {
					$args = array(
						'post_type' => 'post_staff',
						'post_status' => 'publish',
						'posts_per_page' => $nr_posts,
						'orderby' => 'rand'
					);
				} else {
					$args = array(
						'post_type' => 'post_staff',
						'post_status' => 'publish',
						'posts_per_page' => $nr_posts
					);
				}
			} else {
				if ( $display_type == 'random') {
					$args = array(
						'post_type' => 'post_staff',
						'post_status' => 'publish',
						'posts_per_page' => $nr_posts,
						'orderby' => 'rand',
						'tax_query' => array(
							array(
								'taxonomy' => 'wpl_staff_category',
								'field' => 'id',
								'terms' => $categories
							)
						)
					);
				} else {
					$args = array(
						'post_type' => 'post_staff',
						'post_status' => 'publish',
						'posts_per_page' => $nr_posts,
						'tax_query' => array(
							array(
								'taxonomy' => 'wpl_staff_category',
								'field' => 'id',
								'terms' => $categories
							)
						)
					);
				}
			}

			$staff = null;
			$staff = new WP_Query( $args );
		?>
		
			<?php if( $staff->have_posts() ) : ?>
				
				<aside class="widget WPlookStaff" >	
					<div class="widget-title">
						<h3><?php echo $title ?></h3>
						<?php if ( $read_more_link != "") { ?>
							<div class="viewall fright"><a href="<?php echo $read_more_link; ?>" class="radius" title="<?php _e('View all candidates', 'wplook'); ?>"><?php _e('view all', 'wplook'); ?></a></div>
						<?php } ?>
						<div class="clear"></div>
					</div>
					
					<div class="staff-body js-masonry">
						<?php while( $staff->have_posts() ) : $staff->the_post(); ?>
						<?php $candidate_position = get_post_meta(get_the_ID(), 'wpl_candidate_position', true); ?>
							<div class="candidate grid_4">
								<div class="candidate-margins">
									<a href="<?php the_permalink(); ?>">


										<?php if ( has_post_thumbnail() ) {?>
												<?php the_post_thumbnail('candidate-thumb'); ?>
										<?php } ?>


										<div class="name"><?php the_title(); ?></div>
										<div class="position"><?php echo $candidate_position; ?></div>
									</a>
								</div>
							</div>

						<?php endwhile; wp_reset_postdata(); ?>
					<div class="clear"></div>
					</div>
				</aside>
				<?php if ( $clear_after =="0" ) { ?>
					<div class="clear-widget"></div>
				<?php } ?>
			<?php endif; ?>
		<?php
	}
}
?>