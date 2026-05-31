<?php
/**
 * Template Name: Contact
 *
 * Generated from Maneesh/contact.html.
 *
 * @package Interior
 */

get_header();

$interior_contact_page = interior_get_contact_page_data( get_queried_object_id() );
$interior_page_header  = $interior_contact_page['page_header'];
$interior_contact      = $interior_contact_page['contact'];
$interior_map          = $interior_contact_page['map'];

$interior_header_bg = ! empty( $interior_page_header['bg_image_id'] ) ? wp_get_attachment_image_url( (int) $interior_page_header['bg_image_id'], 'full' ) : '';
$interior_header_bg = $interior_header_bg ? $interior_header_bg : $interior_page_header['bg_image_url'];
$interior_contact_img = ! empty( $interior_contact['image_id'] ) ? wp_get_attachment_image_url( (int) $interior_contact['image_id'], 'large' ) : '';
$interior_contact_img = $interior_contact_img ? $interior_contact_img : $interior_contact['image_url'];
$interior_map_height  = ! empty( $interior_map['height'] ) ? absint( $interior_map['height'] ) : 620;
?>
<div id="antra-smooth-wrapper">
	<div id="antra-smooth-content">

		<section class="page-header">
			<div class="bg-img" data-background="<?php echo esc_url( $interior_header_bg ); ?>"></div>
			<div class="overlay"></div>
			<div class="container">
				<div class="page-header-content">
					<h1 class="title"><?php echo esc_html( $interior_page_header['title'] ); ?></h1>
					<h4 class="sub-title"><a class="home" href="<?php echo esc_url( $interior_page_header['breadcrumb_url'] ); ?>"><?php echo esc_html( $interior_page_header['breadcrumb_home'] ); ?> </a><span class="icon">-</span><a class="inner-page" href="<?php echo esc_url( get_permalink() ); ?>"> <?php echo esc_html( $interior_page_header['breadcrumb_text'] ); ?></a></h4>
				</div>
			</div>
		</section>
		<!-- ./ page-header -->

		<section class="contact-section pt-150 pb-150">
			<div class="container container-2">
				<div class="row section-heading-wrap w-100 ml-0">
					<div class="shape"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/section-heading.png' ); ?>" alt="shape"></div>
					<div class="col-lg-4 col-md-12">
						<div class="section-heading mb-0">
							<h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_contact['subtitle'] ); ?></h4>
						</div>
					</div>
					<div class="col-lg-8 col-md-12">
						<div class="section-heading section-heading-2 mb-0">
							<h2 class="section-title title-2"><?php echo wp_kses_post( $interior_contact['title'] ); ?></h2>
						</div>
					</div>
				</div>
				<div class="row request-wrap contact-page-area">
					<div class="col-lg-6">
						<div class="request-content">
							<div class="request-item-wrap">
								<div class="request-item white-content">
									<span><?php echo esc_html( $interior_contact['address_label'] ); ?></span>
									<p><?php echo wp_kses_post( $interior_contact['address_text'] ); ?></p>
								</div>
								<div class="request-item white-content">
									<span><?php echo esc_html( $interior_contact['support_label'] ); ?></span>
									<a href="<?php echo esc_url( $interior_contact['phone_url'] ); ?>"><?php echo esc_html( $interior_contact['phone'] ); ?></a>
									<a href="<?php echo esc_url( $interior_contact['email_url'] ); ?>"><?php echo esc_html( $interior_contact['email'] ); ?></a>
								</div>
							</div>
							<?php if ( $interior_contact_img ) : ?>
								<div class="contact-img">
									<img src="<?php echo esc_url( $interior_contact_img ); ?>" alt="img">
								</div>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="request-form-wrap">
							<?php if ( ! empty( $interior_contact['cf7_shortcode'] ) ) : ?>
								<?php echo do_shortcode( $interior_contact['cf7_shortcode'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php elseif ( current_user_can( 'edit_pages' ) ) : ?>
								<p><?php esc_html_e( 'Add a Contact Form 7 shortcode in Pages > Edit Contact > Contact Form tab.', 'interior' ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ./ contact-section -->

		<?php if ( ! empty( $interior_map['iframe_url'] ) ) : ?>
			<div class="map-wrapper pb-150">
				<div class="container">
					<iframe src="<?php echo esc_url( $interior_map['iframe_url'] ); ?>" width="100%" height="<?php echo esc_attr( $interior_map_height ); ?>" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
				</div>
			</div>
		<?php endif; ?>

<?php
get_footer();
