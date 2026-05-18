<?php
/**
 * Template Name: Project Details
 *
 * @package Interior
 */

$project_id = isset( $_GET['project_id'] ) ? absint( $_GET['project_id'] ) : 0;
$project    = $project_id ? get_post( $project_id ) : null;

if ( ! $project || 'interior_project' !== $project->post_type || 'publish' !== $project->post_status ) {
	$first_project = interior_get_ordered_items( 'interior_project' );
	if ( $first_project->have_posts() ) {
		$first_project->the_post();
		$project = get_post( get_the_ID() );
		wp_reset_postdata();
	}
}

$projects        = interior_get_ordered_items( 'interior_project' );
$detail_page_url = interior_get_template_page_url( 'page-projectDetails.php' );

get_header();
?>
<div id="antra-smooth-wrapper">
	<div id="antra-smooth-content">

		<section class="page-header">
			<div class="bg-img" data-background="<?php echo esc_url( get_template_directory_uri() . '/assets/img/bg-img/page-header-bg.png' ); ?>"></div>
			<div class="overlay"></div>
			<div class="container">
				<div class="page-header-content">
					<h1 class="title"><?php echo $project ? esc_html( get_the_title( $project ) ) : esc_html__( 'Project Details', 'interior' ); ?></h1>
					<h4 class="sub-title"><a class="home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'interior' ); ?> </a><span class="icon">-</span><a class="inner-page" href="<?php echo esc_url( get_permalink() ); ?>"> <?php esc_html_e( 'Project Details', 'interior' ); ?></a></h4>
				</div>
			</div>
		</section>

		<section class="service-details pt-130 pb-130">
			<div class="container container-2">
				<?php if ( $project ) : ?>
					<div class="row pin-inner">
						<div class="col-lg-4 col-md-12">
							<div class="service-details-left-content pin-box">
								<div class="service-category-list">
									<h3 class="list-title"><?php esc_html_e( 'Other Projects', 'interior' ); ?></h3>
									<ul>
										<?php if ( $projects->have_posts() ) : ?>
											<?php
											while ( $projects->have_posts() ) :
												$projects->the_post();
												$item_url = add_query_arg( 'project_id', get_the_ID(), $detail_page_url );
												?>
												<li class="<?php echo esc_attr( get_the_ID() === $project->ID ? 'active' : '' ); ?>"><a href="<?php echo esc_url( $item_url ); ?>"><?php the_title(); ?></a></li>
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
									<img src="<?php echo esc_url( interior_get_item_image_url( $project->ID, 'large' ) ); ?>" alt="<?php echo esc_attr( get_the_title( $project ) ); ?>">
								</div>
								<h1 class="details-title"><?php echo esc_html( get_the_title( $project ) ); ?></h1>
								<?php echo apply_filters( 'the_content', $project->post_content ); ?>
							</div>
						</div>
					</div>
				<?php else : ?>
					<p><?php esc_html_e( 'No project details are available yet.', 'interior' ); ?></p>
				<?php endif; ?>
			</div>
		</section>

<?php
get_footer();
