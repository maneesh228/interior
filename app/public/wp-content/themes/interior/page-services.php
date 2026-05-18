<?php
/**
 * Template Name: Services
 *
 * @package Interior
 */

get_header();

$services        = interior_get_ordered_items( 'interior_service' );
$detail_page_url = interior_get_template_page_url( 'page-serviceDetails.php' );
?>
<div id="antra-smooth-wrapper">
	<div id="antra-smooth-content">

		<section class="page-header">
			<div class="bg-img" data-background="<?php echo esc_url( get_template_directory_uri() . '/assets/img/bg-img/page-header-bg.png' ); ?>"></div>
			<div class="overlay"></div>
			<div class="container">
				<div class="page-header-content">
					<h1 class="title"><?php esc_html_e( 'Services', 'interior' ); ?></h1>
					<h4 class="sub-title"><a class="home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'interior' ); ?> </a><span class="icon">-</span><a class="inner-page" href="<?php echo esc_url( get_permalink() ); ?>"> <?php esc_html_e( 'Services', 'interior' ); ?></a></h4>
				</div>
			</div>
		</section>

		<section class="service-inner pt-130 pb-130">
			<div class="container container-2">
				<div class="row gy-5">
					<?php if ( $services->have_posts() ) : ?>
						<?php
						while ( $services->have_posts() ) :
							$services->the_post();
							$order      = (int) get_post_meta( get_the_ID(), '_interior_order_number', true );
							$image_url  = interior_get_item_image_url( get_the_ID(), 'large' );
							$detail_url = add_query_arg( 'service_id', get_the_ID(), $detail_page_url );
							?>
							<div class="col-lg-4 col-md-6">
								<div class="service-item-3 antra-hover-view">
									<div class="service-thumb">
										<a href="<?php echo esc_url( $detail_url ); ?>"><img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title_attribute(); ?>"></a>
										<span class="number"><?php echo esc_html( str_pad( $order ? $order : $services->current_post + 1, 2, '0', STR_PAD_LEFT ) ); ?></span>
									</div>
									<div class="service-content">
										<h5 class="title"><a href="<?php echo esc_url( $detail_url ); ?>"><?php the_title(); ?></a></h5>
										<p><?php echo esc_html( interior_get_item_summary( get_the_ID() ) ); ?></p>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					<?php else : ?>
						<div class="col-12">
							<p><?php esc_html_e( 'No services have been added yet.', 'interior' ); ?></p>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<section class="newsletter-section bg-white pt-130 pb-130 overflow-hidden">
			<div class="bg-shape"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/newsletter-shape.png' ); ?>" alt="shape"></div>
			<div class="container">
				<div class="newsletter-wrap">
					<div class="section-heading text-center">
						<h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03">Subscribe to the newsletter</h4>
						<h2 class="section-title">Join <span>our newsletter <br> stay</span> up to date</h2>
						<p>Join our newsletter. Learn something new, gain access to exclusive content, <br> and stay informed with the latest updates in the industry.</p>
					</div>
					<div class="newsletter-form">
						<input type="text" id="email" name="email" class="form-control" placeholder="Email address..">
						<button type="submit"><i class="fa-regular fa-arrow-right-long"></i></button>
					</div>
				</div>
			</div>
		</section>

<?php
get_footer();
