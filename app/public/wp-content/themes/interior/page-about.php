<?php
/**
 * Template Name: About
 *
 * Generated from Maneesh/about.html.
 *
 * @package Interior
 */

get_header();
$interior_about_page = interior_get_about_page_data( get_queried_object_id() );
?>
<div id="antra-smooth-wrapper">
        <div id="antra-smooth-content">

        <?php if ( $interior_section = interior_get_page_section_override( '_interior_about_sections', 'page_header' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php
        $interior_about_header    = $interior_about_page['page_header'];
        $interior_about_header_bg = ! empty( $interior_about_header['bg_image_id'] ) ? wp_get_attachment_image_url( (int) $interior_about_header['bg_image_id'], 'full' ) : $interior_about_header['bg_image_url'];
        ?>
        <section class="page-header">
            <div class="bg-img" data-background="<?php echo esc_url( $interior_about_header_bg ); ?>"></div>
            <div class="overlay"></div>
            <div class="container">
                <div class="page-header-content">
                    <h1 class="title"><?php echo esc_html( $interior_about_header['title'] ); ?></h1>
                    <h4 class="sub-title"><a class='home' href='<?php echo esc_url( $interior_about_header['breadcrumb_url'] ); ?>'><?php echo esc_html( $interior_about_header['breadcrumb_home'] ); ?> </a><span class="icon">-</span><a class='inner-page' href='<?php echo esc_url( get_permalink() ); ?>'> <?php echo esc_html( $interior_about_header['breadcrumb_text'] ); ?></a></h4>
                </div>
            </div>
        </section>
        <!-- ./ page-header -->
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_page_section_override( '_interior_about_sections', 'about_intro' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php
        $interior_about_intro         = $interior_about_page['about_intro'];
        $interior_about_counter_image = ! empty( $interior_about_intro['counter_image_id'] ) ? wp_get_attachment_image_url( (int) $interior_about_intro['counter_image_id'], 'full' ) : $interior_about_intro['counter_image_url'];
        $interior_about_main_image    = ! empty( $interior_about_intro['main_image_id'] ) ? wp_get_attachment_image_url( (int) $interior_about_intro['main_image_id'], 'full' ) : $interior_about_intro['main_image_url'];
        ?>
        <section class="about-section-2 pt-130 pb-130">
            <div class="shape-1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/about-shape-1.png' ); ?>" alt="shape"></div>
            <div class="container container-2">
                <div class="row about-wrap-2">
                    <div class="col-lg-8">
                        <div class="about-content-left">
                            <div class="section-heading">
                                <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_about_intro['subtitle'] ); ?></h4>
                                <h2 class="section-title title-2"><?php echo wp_kses_post( $interior_about_intro['title'] ); ?></h2>
                            </div>
                            <div class="about-counter-wrap">
                                <div class="counter-content">
                                    <h3 class="title"><span class="odometer" data-count="<?php echo esc_attr( $interior_about_intro['counter_number'] ); ?>">0</span></h3>
                                    <p><?php echo wp_kses_post( $interior_about_intro['counter_text'] ); ?></p>
                                </div>
                                <div class="counter-img">
                                    <img src="<?php echo esc_url( $interior_about_counter_image ); ?>" alt="counter">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="about-content-right">
                            <div class="about-img-1">
                                <img src="<?php echo esc_url( $interior_about_main_image ); ?>" alt="about">
                            </div>
                            <div class="about-desc">
                                <p><?php echo wp_kses_post( $interior_about_intro['description'] ); ?></p>
                                <div class="about-btn">
                                    <a href="<?php echo esc_url( $interior_about_intro['button_url'] ); ?>" class="tl-primary-btn"><?php echo esc_html( $interior_about_intro['button_text'] ); ?> <span class="icon"><i class="fa-regular fa-arrow-right"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ./ about-section -->
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_page_section_override( '_interior_about_sections', 'video' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php
        $interior_about_video    = $interior_about_page['video'];
        $interior_about_video_bg = ! empty( $interior_about_video['bg_image_id'] ) ? wp_get_attachment_image_url( (int) $interior_about_video['bg_image_id'], 'full' ) : $interior_about_video['bg_image_url'];
        ?>
        <div class="video-area-wrap">
            <div class="video-bg" data-background="<?php echo esc_url( $interior_about_video_bg ); ?>"></div>
            <div class="play-btn">
                <a
                    class="video-popup venobox"
                    data-autoplay="true"
                    data-vbtype="video"
                    href="<?php echo esc_url( $interior_about_video['video_url'] ); ?>">
                    <?php echo esc_html( $interior_about_video['button_text'] ); ?>
                </a>
            </div>
        </div>
        <!-- ./ video-section -->
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_page_section_override( '_interior_about_sections', 'history' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php
        $interior_about_history         = $interior_about_page['history'];
        $interior_about_history_element = ! empty( $interior_about_history['element_image_id'] ) ? wp_get_attachment_image_url( (int) $interior_about_history['element_image_id'], 'full' ) : $interior_about_history['element_image_url'];
        ?>
        <section class="history-section pt-130 pb-130">
            <div class="history-text"><span><?php echo esc_html( $interior_about_history['background_text'] ); ?></span></div>
            <div class="history-element"><img src="<?php echo esc_url( $interior_about_history_element ); ?>" alt="counter"></div>
            <div class="container container-2">
                <div class="row section-heading-wrap ml-0 mw-100">  
                    <div class="shape"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/section-heading.png' ); ?>" alt="shape"></div>
                    <div class="col-lg-4 col-md-12">
                        <div class="section-heading mb-0">
                            <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_about_history['subtitle'] ); ?></h4>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="section-heading section-heading-2 mb-0">
                            <h2 class="section-title title-2"><?php echo wp_kses_post( $interior_about_history['title'] ); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="history-carousel-wrap">
                    <div class="history-carousel swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ( $interior_about_history['items'] as $interior_history_item ) : ?>
                                <?php $interior_history_image = ! empty( $interior_history_item['image_id'] ) ? wp_get_attachment_image_url( (int) $interior_history_item['image_id'], 'full' ) : $interior_history_item['image_url']; ?>
                                <div class="swiper-slide">
                                <div class="history-item">
                                    <div class="history-img">
                                        <img src="<?php echo esc_url( $interior_history_image ); ?>" alt="history">
                                    </div>
                                    <div class="history-content">
                                        <div class="circle"></div>
                                        <h3 class="title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( $interior_history_item['year'] ); ?></a></h3>
                                        <p><?php echo wp_kses_post( $interior_history_item['description'] ); ?></p>
                                    </div>
                                </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ./ history-section -->
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_page_section_override( '_interior_about_sections', 'process' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php $interior_about_process = $interior_about_page['process']; ?>
        <section class="process-section overflow-hidden bg-white">
            <div class="bg-shape" data-background="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/process-shape-1.png' ); ?>"></div>
            <div class="container container-2">
                <div class="heading-space align-items-end">
                    <div class="section-heading mb-0">
                        <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_about_process['subtitle'] ); ?></h4>
                        <h2 class="section-title title-2"><?php echo wp_kses_post( $interior_about_process['title'] ); ?></h2>
                    </div>
                    <div class="process-desc">
                        <p class="mb-0"><?php echo wp_kses_post( $interior_about_process['description'] ); ?></p>
                    </div>
                </div>
                <div class="row gy-xl-0 gy-4 process-wrap">
                    <?php foreach ( $interior_about_process['items'] as $interior_process_index => $interior_process_item ) : ?>
                        <?php
                        $interior_process_number = str_pad( (string) ( $interior_process_index + 1 ), 2, '0', STR_PAD_LEFT );
                        $interior_process_image  = ! empty( $interior_process_item['image_id'] ) ? wp_get_attachment_image_url( (int) $interior_process_item['image_id'], 'full' ) : $interior_process_item['image_url'];
                        ?>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="process-item">
                                <div class="process-thumb">
                                    <img src="<?php echo esc_url( $interior_process_image ); ?>" alt="process">
                                </div>
                                <div class="process-content">
                                    <h3 class="title"><span><?php echo esc_html( $interior_process_number ); ?></span>. <?php echo wp_kses_post( $interior_process_item['title'] ); ?></h3>
                                    <p><?php echo wp_kses_post( $interior_process_item['description'] ); ?></p>
                                </div>
                                <span class="number"><?php echo esc_html( $interior_process_number ); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="process-text">
                    <h5 class="bottom-text"><?php echo wp_kses_post( $interior_about_process['bottom_text'] ); ?> <a href="<?php echo esc_url( $interior_about_process['link_url'] ); ?>"><?php echo esc_html( $interior_about_process['link_text'] ); ?></a></h5>
                </div>
            </div>
        </section>
        <!-- ./ process-section -->
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_page_section_override( '_interior_about_sections', 'awards' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php $interior_about_awards = $interior_about_page['awards']; ?>
        <section class="award-section bg-grey pt-130 pb-130">
            <div class="bg-shape"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/team-bg-shape-1.png' ); ?>" alt="shape"></div>
            <div class="container container-2">
                <div class="row section-heading-wrap">  
                    <div class="shape"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/section-heading.png' ); ?>" alt="shape"></div>
                    <div class="col-lg-4 col-md-12">
                        <div class="section-heading mb-0">
                            <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_about_awards['subtitle'] ); ?></h4>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="section-heading section-heading-2 mb-0">
                            <h2 class="section-title title-2"><?php echo wp_kses_post( $interior_about_awards['title'] ); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="row award-wrap">
                    <div class="col-lg-5">
                        <div class="award-img">
                            <?php $interior_first_award_image = ! empty( $interior_about_awards['items'][0]['image_id'] ) ? wp_get_attachment_image_url( (int) $interior_about_awards['items'][0]['image_id'], 'full' ) : $interior_about_awards['items'][0]['image_url']; ?>
                            <img src="<?php echo esc_url( $interior_first_award_image ); ?>" alt="img">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="award-item-list">
                            <?php foreach ( $interior_about_awards['items'] as $interior_award_item ) : ?>
                                <?php $interior_award_image = ! empty( $interior_award_item['image_id'] ) ? wp_get_attachment_image_url( (int) $interior_award_item['image_id'], 'full' ) : $interior_award_item['image_url']; ?>
                                <div class="award-item" data-img="<?php echo esc_url( $interior_award_image ); ?>">
                                    <div class="left-content">
                                        <span class="number"><?php echo esc_html( $interior_award_item['year'] ); ?></span>
                                        <h3 class="title"><?php echo esc_html( $interior_award_item['title'] ); ?></h3>
                                    </div>
                                    <div class="mid-content">
                                        <span><?php echo esc_html( $interior_award_item['category'] ); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ./ award-section -->
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_page_section_override( '_interior_about_sections', 'gallery' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php
        $interior_about_gallery    = $interior_about_page['gallery'];
        $interior_about_gallery_bg = ! empty( $interior_about_gallery['bg_image_id'] ) ? wp_get_attachment_image_url( (int) $interior_about_gallery['bg_image_id'], 'full' ) : $interior_about_gallery['bg_image_url'];
        $interior_about_gallery_items = interior_get_media_gallery_items();
        ?>
        <section class="gallary-section-2 pb-130 overflow-hidden">
            <div class="bg-img" data-background="<?php echo esc_url( $interior_about_gallery_bg ); ?>"></div>
            <div class="container container-2">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="gallary-left-content">
                            <div class="section-heading white-content mb-0">
                                <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_about_gallery['subtitle'] ); ?></h4>
                                <h2 class="section-title"><?php echo wp_kses_post( $interior_about_gallery['title'] ); ?></h2>
                                <p class="mb-0"><?php echo wp_kses_post( $interior_about_gallery['description'] ); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="gallary-carousel-wrap">
                            <div class="gallary-carousel swiper">
                                <div class="swiper-wrapper">
                                    <?php foreach ( $interior_about_gallery_items as $interior_gallery_item ) : ?>
                                        <div class="swiper-slide">
                                            <div class="gallary-inner-item">
                                                <a href="<?php echo esc_url( $interior_gallery_item['full'] ); ?>" class="venobox" data-gall="about-gallery"><img src="<?php echo esc_url( $interior_gallery_item['image'] ); ?>" alt="<?php echo esc_attr( $interior_gallery_item['title'] ? $interior_gallery_item['title'] : 'Gallery image' ); ?>"></a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php if ( ! empty( $interior_about_gallery_items ) ) : ?>
                                <div class="swiper-arrow">
                                    <div class="swiper-nav swiper-prev"><i class="fa-regular fa-arrow-left"></i></div>
                                    <div class="swiper-nav swiper-next"><i class="fa-regular fa-arrow-right"></i></div>
                                </div>
                            <?php elseif ( current_user_can( 'edit_pages' ) && interior_get_media_page_id() ) : ?>
                                <p><?php esc_html_e( 'Add images on the Media page to populate this gallery.', 'interior' ); ?></p>
                                <a href="<?php echo esc_url( get_edit_post_link( interior_get_media_page_id() ) ); ?>" class="tl-primary-btn"><?php esc_html_e( 'Edit Media Gallery', 'interior' ); ?> <span class="icon"><i class="fa-regular fa-arrow-right"></i></span></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ./ gallary-section -->
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_page_section_override( '_interior_about_sections', 'testimonial' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php
        $interior_about_testimonial        = interior_get_home_testimonial_data();
        $interior_about_testimonial_image  = ! empty( $interior_about_testimonial['image_id'] ) ? wp_get_attachment_image_url( (int) $interior_about_testimonial['image_id'], 'full' ) : $interior_about_testimonial['image_url'];
        $interior_about_testimonial_author = ! empty( $interior_about_testimonial['author_image_id'] ) ? wp_get_attachment_image_url( (int) $interior_about_testimonial['author_image_id'], 'full' ) : $interior_about_testimonial['author_image_url'];
        ?>
        <section class="testimonial-section bg-white pt-150">
            <div class="container container-2">
                <div class="row section-heading-wrap">  
                    <div class="shape"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/section-heading.png' ); ?>" alt="shape"></div>
                    <div class="col-lg-4 col-md-12">
                        <div class="section-heading mb-0">
                            <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_about_testimonial['subtitle'] ); ?></h4>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="section-heading section-heading-2 mb-0">
                            <h2 class="section-title title-2"><?php echo wp_kses_post( $interior_about_testimonial['title'] ); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="testi-img">
                            <img src="<?php echo esc_url( $interior_about_testimonial_image ); ?>" alt="testi">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="testi-carousel-wrap">
                            <div class="testi-top-content">
                                <div class="left-content">
                                    <h3 class="rating"><?php echo esc_html( $interior_about_testimonial['rating'] ); ?></h3>
                                    <div class="rating-list">
                                        <ul>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                        </ul>
                                        <span><?php echo esc_html( $interior_about_testimonial['reviews'] ); ?></span>
                                    </div>
                                </div>
                                <div class="right-content">
                                    <p><?php echo wp_kses_post( $interior_about_testimonial['intro'] ); ?></p>
                                </div>
                            </div>
                            <div class="testi-carousel swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="testi-item">
                                            <p><?php echo wp_kses_post( $interior_about_testimonial['quote'] ); ?></p>
                                            <div class="testi-author">
                                                <div class="author-img">
                                                    <img src="<?php echo esc_url( $interior_about_testimonial_author ); ?>" alt="author">
                                                </div>
                                                <h4 class="name"><?php echo esc_html( $interior_about_testimonial['author_name'] ); ?> <span><?php echo esc_html( $interior_about_testimonial['author_position'] ); ?></span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ./ testimonial-section -->
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_page_section_override( '_interior_about_sections', 'sponsors' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php $interior_about_sponsors = $interior_about_page['sponsors']; ?>
        <section class="sponsor-section bg-white pt-120 pb-130 overflow-hidden">
            <div class="container">
                <div class="sponsor-text-wrap sponsor-text-wrap-2">
                    <h5 class="sponsor-text"><?php echo esc_html( $interior_about_sponsors['heading_before'] ); ?> <span><?php echo esc_html( $interior_about_sponsors['heading_number'] ); ?></span><?php echo esc_html( $interior_about_sponsors['heading_after'] ); ?></h5>
                </div>
                <div class="sponsor-carousel swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ( $interior_about_sponsors['items'] as $interior_sponsor_item ) : ?>
                            <?php $interior_sponsor_image = ! empty( $interior_sponsor_item['image_id'] ) ? wp_get_attachment_image_url( (int) $interior_sponsor_item['image_id'], 'full' ) : $interior_sponsor_item['image_url']; ?>
                            <div class="swiper-slide">
                                <div class="sponsor-item">
                                    <a href="<?php echo esc_url( $interior_sponsor_item['link_url'] ); ?>"><img src="<?php echo esc_url( $interior_sponsor_image ); ?>" alt="sponsor"></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- ./ sponsor-section -->
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_page_section_override( '_interior_about_sections', 'newsletter' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php
        $interior_about_newsletter       = interior_get_home_newsletter_data();
        $interior_about_newsletter_shape = ! empty( $interior_about_newsletter['shape_image_id'] ) ? wp_get_attachment_image_url( (int) $interior_about_newsletter['shape_image_id'], 'full' ) : $interior_about_newsletter['shape_url'];
        ?>
        <section class="newsletter-section bg-white pb-130 overflow-hidden">
            <div class="bg-shape"><img src="<?php echo esc_url( $interior_about_newsletter_shape ); ?>" alt="shape"></div>
            <div class="container">
                <div class="newsletter-wrap">
                    <div class="section-heading text-center">
                        <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_about_newsletter['subtitle'] ); ?></h4>
                        <h2 class="section-title"><?php echo wp_kses_post( $interior_about_newsletter['title'] ); ?></h2>
                        <p><?php echo wp_kses_post( $interior_about_newsletter['description'] ); ?></p>
                    </div>
                    <form class="newsletter-form interior-newsletter-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
                        <input type="email" id="about-newsletter-email" name="email" class="form-control" placeholder="<?php echo esc_attr( $interior_about_newsletter['placeholder'] ); ?>" required>
                        <input type="hidden" name="action" value="interior_newsletter_subscribe">
                        <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'interior_newsletter_subscribe' ) ); ?>">
                        <button type="submit" aria-label="<?php esc_attr_e( 'Subscribe', 'interior' ); ?>"><i class="fa-regular fa-arrow-right-long"></i></button>
                        <p class="interior-newsletter-message" aria-live="polite"></p>
                    </form>
                </div>
            </div>
        </section>
        <!-- ./ newsletter-section -->
        <?php endif; ?>

        
<?php
get_footer();

