<?php
/**
 * Template Name: Media
 *
 * @package Interior
 */

get_header();

$media_page = get_page_by_path( 'media' );
$media_id   = $media_page ? $media_page->ID : get_the_ID();

$banner_title    = get_post_meta( $media_id, '_media_banner_title', true );
$banner_text     = get_post_meta( $media_id, '_media_banner_text', true );
$banner_image_id = (int) get_post_meta( $media_id, '_media_banner_image_id', true );
$banner_image    = $banner_image_id ? wp_get_attachment_image_url( $banner_image_id, 'full' ) : '';
$banner_image    = $banner_image ? $banner_image : get_template_directory_uri() . '/assets/img/bg-img/page-header-bg.png';
$banner_title    = $banner_title ? $banner_title : esc_html__( 'Gallery', 'interior' );

$gallery_meta_exists = metadata_exists( 'post', $media_id, '_media_gallery_ids' );
$gallery_ids         = get_post_meta( $media_id, '_media_gallery_ids', true );
$gallery_ids         = is_array( $gallery_ids ) ? $gallery_ids : array_filter( array_map( 'intval', explode( ',', (string) $gallery_ids ) ) );

$default_gallery_images = array(
	get_template_directory_uri() . '/assets/img/project/gallary-img-1.png',
	get_template_directory_uri() . '/assets/img/project/gallary-img-2.png',
	get_template_directory_uri() . '/assets/img/project/gallary-img-3.png',
	get_template_directory_uri() . '/assets/img/project/gallary-img-4.png',
	get_template_directory_uri() . '/assets/img/project/gallary-img-5.png',
);
$default_gallery_titles = array(
	esc_html__( 'Bathroom Bliss', 'interior' ),
	esc_html__( 'Living Room Stories', 'interior' ),
	esc_html__( 'Office Room', 'interior' ),
	esc_html__( 'Elegant Dining Spaces', 'interior' ),
	esc_html__( 'Serene Bedrooms', 'interior' ),
);

$video_urls_raw = get_post_meta( $media_id, '_media_video_urls', true );
$video_urls     = array_filter( array_map( 'trim', preg_split( '/\r?\n/', (string) $video_urls_raw ) ) );

if ( ! function_exists( 'interior_media_get_embed_url' ) ) {
	function interior_media_get_embed_url( $url ) {
		if ( preg_match( '#https?://(?:www\.)?youtu\.be/([\w-]+)#i', $url, $matches ) ) {
			return 'https://www.youtube.com/embed/' . $matches[1];
		}

		if ( preg_match( '#https?://(?:www\.)?youtube\.com/watch\?v=([\w-]+)#i', $url, $matches ) ) {
			return 'https://www.youtube.com/embed/' . $matches[1];
		}

		if ( preg_match( '#https?://(?:www\.)?vimeo\.com/([0-9]+)#i', $url, $matches ) ) {
			return 'https://player.vimeo.com/video/' . $matches[1];
		}

		return $url;
	}
}
?>
<div id="antra-smooth-wrapper">
	<div id="antra-smooth-content">

		<section class="page-header">
			<div class="bg-img" data-background="<?php echo esc_url( $banner_image ); ?>"></div>
			<div class="overlay"></div>
			<div class="container">
				<div class="page-header-content">
					<h1 class="title"><?php echo esc_html( $banner_title ); ?></h1>
					<h4 class="sub-title"><a class="home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'interior' ); ?> </a><span class="icon">-</span><a class="inner-page" href="<?php echo esc_url( get_permalink() ); ?>"> <?php echo esc_html( $banner_title ); ?></a></h4>
					<?php if ( $banner_text ) : ?>
						<p><?php echo esc_html( $banner_text ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<section class="gallery-inner pt-130 pb-130">
			<div class="container container-2">
				<div class="row section-heading-wrap ml-0 mw-100">
					<div class="shape"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/section-heading.png' ); ?>" alt="shape"></div>
					<div class="col-lg-4 col-md-12">
						<div class="section-heading mb-0">
							<h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php esc_html_e( 'our gallery', 'interior' ); ?></h4>
						</div>
					</div>
					<div class="col-lg-8 col-md-12">
						<div class="section-heading section-heading-2 mb-0 pl-0">
							<h2 class="section-title title-2"><?php esc_html_e( 'Gallery', 'interior' ); ?> <span><?php esc_html_e( 'of inspiring', 'interior' ); ?> <br><?php esc_html_e( 'interior', 'interior' ); ?></span> <?php esc_html_e( 'designs', 'interior' ); ?></h2>
							<?php if ( $banner_text ) : ?>
								<p><?php echo esc_html( $banner_text ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<?php if ( ! empty( $gallery_ids ) || ! $gallery_meta_exists ) : ?>
					<div class="gallary-item-wrap-inner">
						<?php if ( ! empty( $gallery_ids ) ) : ?>
							<?php foreach ( $gallery_ids as $index => $image_id ) : ?>
								<?php
								$image_url = wp_get_attachment_image_url( (int) $image_id, 'large' );
								$full_url  = wp_get_attachment_image_url( (int) $image_id, 'full' );
								?>
								<?php if ( $image_url ) : ?>
									<div class="gallary-item-inner">
										<a href="<?php echo esc_url( $full_url ? $full_url : $image_url ); ?>" class="media-lightbox-trigger" data-full="<?php echo esc_url( $full_url ? $full_url : $image_url ); ?>"><img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( sprintf( 'Media image %d', $index + 1 ) ); ?>"></a>
										<h4 class="title"><?php echo esc_html( get_the_title( $image_id ) ? get_the_title( $image_id ) : sprintf( 'Media Image %d', $index + 1 ) ); ?></h4>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php else : ?>
							<?php foreach ( $default_gallery_images as $index => $image_url ) : ?>
								<div class="gallary-item-inner">
									<a href="<?php echo esc_url( $image_url ); ?>" class="media-lightbox-trigger" data-full="<?php echo esc_url( $image_url ); ?>"><img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $default_gallery_titles[ $index ] ); ?>"></a>
									<h4 class="title"><?php echo esc_html( $default_gallery_titles[ $index ] ); ?></h4>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $video_urls ) ) : ?>
					<div class="row gy-4 mt-60">
						<div class="col-12">
							<div class="section-heading text-center align-items-center mb-30">
								<h4 class="sub-heading"><?php esc_html_e( 'Videos', 'interior' ); ?></h4>
								<h2 class="section-title title-2"><?php esc_html_e( 'Featured', 'interior' ); ?> <span><?php esc_html_e( 'media', 'interior' ); ?></span></h2>
							</div>
						</div>
						<?php foreach ( $video_urls as $url ) : ?>
							<?php $embed_url = interior_media_get_embed_url( $url ); ?>
							<div class="col-lg-6">
								<div class="media-video-embed">
									<iframe src="<?php echo esc_url( $embed_url ); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( empty( $gallery_ids ) && $gallery_meta_exists && empty( $video_urls ) ) : ?>
					<div class="row justify-content-center">
						<div class="col-lg-6 text-center">
							<p><?php esc_html_e( 'No media items have been added yet.', 'interior' ); ?></p>
							<?php if ( current_user_can( 'edit_pages' ) && $media_id ) : ?>
								<a href="<?php echo esc_url( get_edit_post_link( $media_id ) ); ?>" class="tl-primary-btn"><?php esc_html_e( 'Edit Media Page', 'interior' ); ?> <span class="icon"><i class="fa-regular fa-arrow-right"></i></span></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</section>

		<style>
			.media-video-embed { position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:16px; background:#000; }
			.media-video-embed iframe { position:absolute; top:0; left:0; width:100%; height:100%; }
			.media-lightbox-overlay { position:fixed; inset:0; background:rgba(0,0,0,.86); display:none; align-items:center; justify-content:center; z-index:9999; }
			.media-lightbox-overlay.active { display:flex; }
			.media-lightbox-content { max-width:90%; max-height:90%; position:relative; }
			.media-lightbox-content img { max-width:100%; max-height:90vh; border-radius:8px; box-shadow:0 20px 40px rgba(0,0,0,.45); }
			.media-lightbox-close, .media-lightbox-nav { background:#fff; color:#000; cursor:pointer; position:absolute; text-align:center; user-select:none; }
			.media-lightbox-close { border-radius:50%; font-size:20px; height:32px; line-height:32px; right:-15px; top:-15px; width:32px; }
			.media-lightbox-nav { align-items:center; border-radius:50%; display:flex; font-size:20px; height:42px; justify-content:center; top:50%; transform:translateY(-50%); width:42px; }
			.media-lightbox-prev { left:-60px; }
			.media-lightbox-next { right:-60px; }
			@media (max-width: 767px) {
				.media-lightbox-prev { left:10px; }
				.media-lightbox-next { right:10px; }
			}
		</style>

		<div class="media-lightbox-overlay" id="media-lightbox">
			<div class="media-lightbox-content">
				<span class="media-lightbox-close" id="media-lightbox-close">&times;</span>
				<span class="media-lightbox-nav media-lightbox-prev" id="media-lightbox-prev">&#10094;</span>
				<span class="media-lightbox-nav media-lightbox-next" id="media-lightbox-next">&#10095;</span>
				<img id="media-lightbox-image" src="" alt="Media image">
			</div>
		</div>

		<script>
			(function() {
				var overlay = document.getElementById('media-lightbox');
				var overlayImg = document.getElementById('media-lightbox-image');
				var closeBtn = document.getElementById('media-lightbox-close');
				var prevBtn = document.getElementById('media-lightbox-prev');
				var nextBtn = document.getElementById('media-lightbox-next');
				if (!overlay || !overlayImg || !closeBtn) return;

				var triggers = Array.prototype.slice.call(document.querySelectorAll('.media-lightbox-trigger'));
				var currentIndex = -1;

				function closeLightbox() {
					overlay.classList.remove('active');
					overlayImg.src = '';
				}

				function openLightboxByIndex(index) {
					if (!triggers.length) return;
					if (index < 0) index = triggers.length - 1;
					if (index >= triggers.length) index = 0;
					currentIndex = index;
					overlayImg.src = triggers[currentIndex].getAttribute('data-full');
					overlay.classList.add('active');
				}

				triggers.forEach(function(el, index) {
					el.addEventListener('click', function(e) {
						e.preventDefault();
						openLightboxByIndex(index);
					});
				});

				closeBtn.addEventListener('click', closeLightbox);
				overlay.addEventListener('click', function(e) {
					if (e.target === overlay) closeLightbox();
				});
				prevBtn.addEventListener('click', function(e) {
					e.preventDefault();
					openLightboxByIndex(currentIndex - 1);
				});
				nextBtn.addEventListener('click', function(e) {
					e.preventDefault();
					openLightboxByIndex(currentIndex + 1);
				});
				document.addEventListener('keydown', function(e) {
					if (e.key === 'Escape') closeLightbox();
					if (e.key === 'ArrowLeft' && currentIndex !== -1) openLightboxByIndex(currentIndex - 1);
					if (e.key === 'ArrowRight' && currentIndex !== -1) openLightboxByIndex(currentIndex + 1);
				});
			})();
		</script>

<?php
get_footer();
