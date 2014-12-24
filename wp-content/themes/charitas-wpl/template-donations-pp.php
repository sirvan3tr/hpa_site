<?php
/**
 * Template Name: PayPal Returne Page
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
				
				
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; // end of the loop. ?>
					
				<?php

					include_once( get_template_directory() . '/inc/paypal/class/paypal.php' );
					include_once( get_template_directory() . '/inc/paypal/class/httprequest.php' );

					//Use this form for production server 
					$r = new PayPal(true);

					//Use this form for sandbox tests
					//$r = new PayPal();

					$final = $r->doPayment();

					if ($final['ACK'] == 'Success') {
						//echo 'Succeed!';
						$oToken   = $r->getCheckoutDetails($final['TOKEN']);
						$txnID    = $oToken['TOKEN'];
						$firstName   = $oToken['FIRSTNAME'];
						$lastName   = $oToken['LASTNAME'];
						$addressCountry = $oToken['COUNTRYCODE'];
						$payerEmail  = $oToken['EMAIL'];


						$bani = explode("|", $oToken['CUSTOM']);
						$payment_gross = $bani[0];
						$valuta= $bani[1];
						$donCause= $bani[2];

						$my_post = array(
							'post_title'    => $txnID,
							'post_status'   => 'publish',
							'post_author'   => 1,
							'comment_status' => 'closed',
							'ping_status' => 'closed',
							'post_type'      => 'post_pledges'
						);
						$post_id = wp_insert_post( $my_post );
						
						add_post_meta($post_id, "wpl_pledge_cause", $donCause);
						add_post_meta($post_id, "wpl_pledge_transaction_id", $txnID);
						add_post_meta($post_id, "wpl_pledge_first_name", $firstName);
						add_post_meta($post_id, "wpl_pledge_last_name", $lastName);
						add_post_meta($post_id, "wpl_pledge_country", $addressCountry);
						add_post_meta($post_id, "wpl_pledge_email", $payerEmail);
						add_post_meta($post_id, "wpl_pledge_donation_amount", $payment_gross);
						add_post_meta($post_id, "wpl_pledge_payment_source", 'paypal');
						add_post_meta($post_id, "wpl_pledge_payment_Status", 'Completed');	
							
					} else {
						//print_r($final);
					}
					?>

				</div>
	
			<?php get_sidebar('causes'); ?>
			<div class="clear"></div>
		</div>
	</div>
<?php get_footer(); ?>