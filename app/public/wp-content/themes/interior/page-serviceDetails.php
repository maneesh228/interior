<?php
/**
 * Template Name: Service Details
 *
 * @package Interior
 */

$service_id = isset( $_GET['service_id'] ) ? absint( $_GET['service_id'] ) : 0;
$service    = $service_id ? get_post( $service_id ) : null;

if ( ! $service || 'interior_service' !== $service->post_type || 'publish' !== $service->post_status ) {
	$first_service = interior_get_ordered_items( 'interior_service' );
	if ( $first_service->have_posts() ) {
		$first_service->the_post();
		$service = get_post( get_the_ID() );
		wp_reset_postdata();
	}
}

$services        = interior_get_ordered_items( 'interior_service' );
$detail_page_url = interior_get_template_page_url( 'page-serviceDetails.php' );

get_header();
?>
<div id="antra-smooth-wrapper">
	<div id="antra-smooth-content">

		<section class="page-header">
			<div class="bg-img" data-background="<?php echo esc_url( get_template_directory_uri() . '/assets/img/bg-img/page-header-bg.png' ); ?>"></div>
			<div class="overlay"></div>
			<div class="container">
				<div class="page-header-content">
					<h1 class="title"><?php echo $service ? esc_html( get_the_title( $service ) ) : esc_html__( 'Service Details', 'interior' ); ?></h1>
					<h4 class="sub-title"><a class="home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'interior' ); ?> </a><span class="icon">-</span><a class="inner-page" href="<?php echo esc_url( get_permalink() ); ?>"> <?php esc_html_e( 'Service Details', 'interior' ); ?></a></h4>
				</div>
			</div>
		</section>

		<section class="service-details pt-130 pb-130">
			<div class="container container-2">
				<?php if ( $service ) : ?>
					<div class="row pin-inner">
						<div class="col-lg-4 col-md-12">
							<div class="service-details-left-content pin-box">
								<div class="service-category-list">
									<h3 class="list-title"><?php esc_html_e( 'Other Services', 'interior' ); ?></h3>
									<ul>
										<?php if ( $services->have_posts() ) : ?>
											<?php
											while ( $services->have_posts() ) :
												$services->the_post();
												$item_url = add_query_arg( 'service_id', get_the_ID(), $detail_page_url );
												?>
												<li class="<?php echo esc_attr( get_the_ID() === $service->ID ? 'active' : '' ); ?>"><a href="<?php echo esc_url( $item_url ); ?>"><?php the_title(); ?></a></li>
											<?php endwhile; ?>
											<?php wp_reset_postdata(); ?>
										<?php endif; ?>
									</ul>
								</div>
								<div class="service-details-cta">
									<div class="cta-bg" data-background="<?php echo esc_url( get_template_directory_uri() . '/assets/img/bg-img/service-cta-bg-2.png' ); ?>"></div>
									<div class="icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/icon/service-details-cta.png' ); ?>" alt="icon"></div>
									<span><?php esc_html_e( 'Do You Need Help?', 'interior' ); ?></span>
									<a class="number" href="tel:+0844560789">+(084) 456-0789</a>
									<a class="mail" href="mailto:support@example.com">support@example.com</a>
									<div class="cta-btn">
										<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Get a call', 'interior' ); ?> <br> <?php esc_html_e( 'Back', 'interior' ); ?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-8 col-md-12">
							<div class="service-details-content scroll-content">
								<div class="service-details-img">
									<img src="<?php echo esc_url( interior_get_item_image_url( $service->ID, 'large' ) ); ?>" alt="<?php echo esc_attr( get_the_title( $service ) ); ?>">
								</div>
								<h1 class="details-title"><?php echo esc_html( get_the_title( $service ) ); ?></h1>
								<?php echo apply_filters( 'the_content', $service->post_content ); ?>
							</div>
						</div>
					</div>
				<?php else : ?>
					<p><?php esc_html_e( 'No service details are available yet.', 'interior' ); ?></p>
				<?php endif; ?>
			</div>
		</section>

<?php
get_footer();
