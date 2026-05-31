<?php
/**
 * Template Name: Downloads
 *
 * @package Interior
 */

get_header();

$interior_downloads_page = interior_get_downloads_page_data( get_queried_object_id() );
$interior_page_header    = $interior_downloads_page['page_header'];
$interior_download_files = interior_get_downloads_files( get_queried_object_id() );
$interior_header_bg      = ! empty( $interior_page_header['bg_image_id'] ) ? wp_get_attachment_image_url( (int) $interior_page_header['bg_image_id'], 'full' ) : '';
$interior_header_bg      = $interior_header_bg ? $interior_header_bg : $interior_page_header['bg_image_url'];
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

		<section class="downloads-section pt-150 pb-150">
			<div class="container">
				<div class="downloads-list">
					<?php if ( ! empty( $interior_download_files ) ) : ?>
						<?php foreach ( $interior_download_files as $file ) : ?>
							<div class="downloads-item">
								<div class="downloads-item-info">
									<span class="downloads-item-icon"><i class="fa-regular fa-file-arrow-down"></i></span>
									<div>
										<h3><?php echo esc_html( $file['title'] ); ?></h3>
										<?php if ( ! empty( $file['size'] ) || ! empty( $file['type'] ) ) : ?>
											<p>
												<?php if ( ! empty( $file['type'] ) ) : ?>
													<span><?php echo esc_html( $file['type'] ); ?></span>
												<?php endif; ?>
												<?php if ( ! empty( $file['size'] ) ) : ?>
													<span><?php echo esc_html( $file['size'] ); ?></span>
												<?php endif; ?>
											</p>
										<?php endif; ?>
									</div>
								</div>
								<a class="tl-primary-btn" href="<?php echo esc_url( $file['url'] ); ?>" download><?php esc_html_e( 'Download', 'interior' ); ?> <span class="icon"><i class="fa-regular fa-arrow-right"></i></span></a>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<p><?php esc_html_e( 'No downloads available.', 'interior' ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<style>
			.downloads-list { display:flex; flex-direction:column; gap:18px; }
			.downloads-item { align-items:center; border:1px solid rgba(15, 15, 15, 0.12); display:flex; gap:24px; justify-content:space-between; padding:24px; }
			.downloads-item-info { align-items:center; display:flex; gap:18px; min-width:0; }
			.downloads-item-icon { align-items:center; background:#f5f1ea; color:#1d1d1d; display:flex; flex:0 0 54px; height:54px; justify-content:center; width:54px; }
			.downloads-item-icon i { font-size:24px; }
			.downloads-item h3 { font-size:22px; margin:0 0 6px; overflow-wrap:anywhere; }
			.downloads-item p { color:#6d6d6d; display:flex; flex-wrap:wrap; gap:12px; margin:0; }
			@media (max-width: 767px) {
				.downloads-item { align-items:flex-start; flex-direction:column; }
			}
		</style>

<?php
get_footer();
