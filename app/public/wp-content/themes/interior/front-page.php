<?php
/**
 * Template Name: Front Page
 *
 * Static front page generated from Maneesh index.html.
 *
 * @package Interior
 */

get_header();
?>
<div id="antra-smooth-wrapper">
        <div id="antra-smooth-content">

        <?php interior_render_home_slider_section(); ?>
                
        <?php if ( $interior_section = interior_get_home_section_override( 'services' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php $interior_services = interior_get_home_services_data(); ?>
        <section class="service-section pt-150 pb-110 overflow-hidden tl-bg-color fade-wrapper">
            <div class="bg-shape" data-background="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/service-bg-shape-1.png' ); ?>"></div>
            <div class="container">
                <div class="row section-heading-wrap fade-top">  
                    <div class="shape"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/section-heading.png' ); ?>" alt="shape"></div>
                    <div class="col-lg-4 col-md-12">
                        <div class="section-heading mb-0">
                            <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_services['subtitle'] ); ?></h4>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="section-heading section-heading-2 mb-0">
                            <h2 class="section-title cursor-effect"><?php echo wp_kses_post( $interior_services['title'] ); ?></h2>
                            <p class="mb-0"><?php echo wp_kses_post( $interior_services['description'] ); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row gy-xl-0 gy-4">
                    <?php foreach ( $interior_services['items'] as $interior_service ) : ?>
                        <?php
                        $interior_service_icon = ! empty( $interior_service['icon_id'] ) ? wp_get_attachment_image_url( (int) $interior_service['icon_id'], 'thumbnail' ) : '';
                        $interior_service_icon = $interior_service_icon ? $interior_service_icon : $interior_service['icon_url'];
                        ?>
                    <div class="col-xl-3 col-lg-6 col-md-12">
                        <div class="service-item slide-anim" data-delay="0.3" data-offset="100" data-direction="<?php echo esc_attr( $interior_service['direction'] ); ?>">
                            <div class="service-top">
                                <h3 class="title"><a href="<?php echo esc_url( $interior_service['url'] ); ?>"><?php echo wp_kses_post( $interior_service['title'] ); ?></a></h3>
                                <div class="icon">
                                    <img src="<?php echo esc_url( $interior_service_icon ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $interior_service['title'] ) ); ?>">
                                </div>
                            </div>
                            <p><?php echo wp_kses_post( $interior_service['description'] ); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- ./ service-section -->
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_home_section_override( 'about' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php
        $interior_about       = interior_get_home_about_data();
        $interior_about_image = ! empty( $interior_about['image_id'] ) ? wp_get_attachment_image_url( (int) $interior_about['image_id'], 'large' ) : '';
        $interior_about_image = $interior_about_image ? $interior_about_image : $interior_about['image_url'];
        ?>
        <section class="about-section overflow-hidden">
            <div class="about-bg" data-background="<?php echo esc_url( get_template_directory_uri() . '/assets/img/bg-img/about-bg.png' ); ?>"></div>
            <div class="about-text"><span><?php echo esc_html( $interior_about['background_text'] ); ?></span></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about-content white-content slide-anim" data-delay="0.3" data-offset="100" data-direction="left">
                            <div class="section-heading white-content mb-30">
                                <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_about['subtitle'] ); ?></h4>
                                <h2 class="section-title cursor-effect"><?php echo wp_kses_post( $interior_about['title'] ); ?></h2>
                            </div>
                            <ul class="about-list">
                                <?php foreach ( $interior_about['items'] as $interior_about_item ) : ?>
                                <li><img src="<?php echo esc_url( $interior_about['icon_url'] ); ?>" alt="about"><?php echo esc_html( $interior_about_item ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <p><?php echo wp_kses_post( $interior_about['description'] ); ?></p>
                            <?php if ( ! empty( $interior_about['button_text'] ) ) : ?>
                                <div class="about-btn">
                                    <a href="<?php echo esc_url( $interior_about['button_url'] ); ?>" class="tl-primary-btn white-btn"><?php echo esc_html( $interior_about['button_text'] ); ?> <span class="icon"><i class="fa-regular fa-arrow-right"></i></span></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-img slide-anim" data-delay="0.3" data-offset="100" data-direction="right">
                            <img src="<?php echo esc_url( $interior_about_image ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $interior_about['title'] ) ); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ./ about-section -->
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_home_section_override( 'features' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php
        $interior_features        = interior_get_home_features_data();
        $interior_feature_services = interior_get_latest_services( 5 );
        $interior_detail_page_url = interior_get_template_page_url( 'page-serviceDetails.php' );
        $interior_first_feature   = array(
            'image' => get_template_directory_uri() . '/assets/img/service/feature-img-1.png',
            'text'  => '',
        );
        ?>
        <section class="feature-section pt-150 pb-110 overflow-hidden tl-bg-color fade-wrapper">
            <div class="container container-2">
                <div class="row section-heading-wrap fade-top feature-top">  
                    <div class="shape"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/section-heading.png' ); ?>" alt="shape"></div>
                    <div class="col-lg-4 col-md-12">
                        <div class="section-heading mb-0">
                            <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_features['subtitle'] ); ?></h4>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="section-heading section-heading-2 mb-0">
                            <h2 class="section-title cursor-effect title-2"><?php echo wp_kses_post( $interior_features['title'] ); ?></h2>
                            <p class="mb-0"><?php echo wp_kses_post( $interior_features['description'] ); ?></p>
                        </div>
                    </div>
                </div>
                <?php if ( $interior_feature_services->have_posts() ) : ?>
                    <?php
                    $interior_first_service_id       = $interior_feature_services->posts[0]->ID;
                    $interior_first_feature['image'] = interior_get_item_image_url( $interior_first_service_id, 'large' );
                    $interior_first_feature['text']  = interior_get_item_summary( $interior_first_service_id );
                    ?>
                <div class="row fade-top">
                    <div class="col-lg-6">
                        <div class="feature-item-imgs">
                            <div class="feature-img">
                                <img src="<?php echo esc_url( $interior_first_feature['image'] ); ?>" alt="feature">
                                <div class="img-content">
                                    <p><?php echo esc_html( $interior_first_feature['text'] ); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="feature-item-list feature-item-list-1">
                            <?php
                            while ( $interior_feature_services->have_posts() ) :
                                $interior_feature_services->the_post();
                                $interior_service_image = interior_get_item_image_url( get_the_ID(), 'large' );
                                $interior_service_text  = interior_get_item_summary( get_the_ID() );
                                $interior_service_url   = add_query_arg( 'service_id', get_the_ID(), $interior_detail_page_url );
                                ?>
                            <div class="feature-item" data-img="<?php echo esc_url( $interior_service_image ); ?>" data-text="<?php echo esc_attr( $interior_service_text ); ?>">
                                <span class="number"><?php echo esc_html( str_pad( $interior_feature_services->current_post + 1, 2, '0', STR_PAD_LEFT ) ); ?></span>
                                <h3 class="title"><a href="<?php echo esc_url( $interior_service_url ); ?>"><?php the_title(); ?></a></h3>
                                <a href="<?php echo esc_url( $interior_service_url ); ?>" class="arrow"><i class="fa-regular fa-arrow-right"></i></a>
                            </div>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                </div>
                <?php else : ?>
                <div class="row fade-top">
                    <div class="col-12">
                        <p><?php esc_html_e( 'No services have been added yet.', 'interior' ); ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <!-- ./ feature-section -->
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_home_section_override( 'counter' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php
        $interior_counter       = interior_get_home_counter_data();
        $interior_counter_image = ! empty( $interior_counter['image_id'] ) ? wp_get_attachment_image_url( (int) $interior_counter['image_id'], 'large' ) : '';
        $interior_counter_image = $interior_counter_image ? $interior_counter_image : $interior_counter['image_url'];
        ?>
        <section class="counter-section counter-1">
            <div class="counter-text"><span><?php echo esc_html( $interior_counter['background_text'] ); ?></span></div>
            <div class="counter-element scroll-area"><img class="scroll-img" src="<?php echo esc_url( $interior_counter_image ); ?>" alt="counter"></div>
            <div class="container container-2">
                <div class="row gy-5 fade-wrapper">
                    <?php foreach ( $interior_counter['items'] as $interior_counter_item ) : ?>
                    <div class="col-lg-3 col-md-6 fade-top">
                        <div class="counter-item">
                            <h3 class="title"><span class="odometer" data-count="<?php echo esc_attr( $interior_counter_item['number'] ); ?>">0</span><span class="icon"><?php echo esc_html( $interior_counter_item['suffix'] ); ?></span></h3>
                            <h4 class="sub-title"><?php echo esc_html( $interior_counter_item['title'] ); ?></h4>
                            <p><?php echo wp_kses_post( $interior_counter_item['description'] ); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- ./ counter-section -->
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_home_section_override( 'process' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <?php $interior_process = interior_get_home_process_data(); ?>
        <section class="process-section overflow-hidden fade-wrapper">
            <div class="bg-shape" data-background="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/process-shape-1.png' ); ?>"></div>
            <div class="container container-2">
                <div class="heading-space align-items-end">
                    <div class="section-heading mb-0">
                        <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_process['subtitle'] ); ?></h4>
                        <h2 class="section-title cursor-effect title-2"><?php echo wp_kses_post( $interior_process['title'] ); ?></h2>
                    </div>
                    <div class="process-desc">
                        <p class="mb-0"><?php echo wp_kses_post( $interior_process['description'] ); ?></p>
                    </div>
                </div>
                <div class="row gy-xl-0 gy-4 process-wrap fade-wrapper">
                    <?php foreach ( $interior_process['items'] as $interior_process_index => $interior_process_item ) : ?>
                        <?php
                        $interior_process_number = str_pad( $interior_process_index + 1, 2, '0', STR_PAD_LEFT );
                        $interior_process_image  = ! empty( $interior_process_item['image_id'] ) ? wp_get_attachment_image_url( (int) $interior_process_item['image_id'], 'large' ) : '';
                        $interior_process_image  = $interior_process_image ? $interior_process_image : $interior_process_item['image_url'];
                        ?>
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <div class="process-item fade-top">
                            <div class="process-thumb">
                                <img src="<?php echo esc_url( $interior_process_image ); ?>" alt="<?php echo esc_attr( $interior_process_item['title'] ); ?>">
                            </div>
                            <div class="process-content">
                                <h3 class="title"><span><?php echo esc_html( $interior_process_number ); ?></span>. <?php echo esc_html( $interior_process_item['title'] ); ?></h3>
                                <p><?php echo wp_kses_post( $interior_process_item['description'] ); ?></p>
                            </div>
                            <span class="number"><?php echo esc_html( $interior_process_number ); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="process-text">
                    <h5 class="bottom-text"><?php echo esc_html( $interior_process['bottom_text'] ); ?> <a href="<?php echo esc_url( $interior_process['link_url'] ); ?>"><?php echo esc_html( $interior_process['link_text'] ); ?></a></h5>
                </div>
            </div>
        </section>
        <!-- ./ process-section -->
        <?php endif; ?>

        <?php
        $interior_projects          = interior_get_home_projects_data();
        $interior_latest_projects   = interior_get_latest_projects( 3 );
        $interior_project_page_url  = interior_get_template_page_url( 'page-projectDetails.php' );
        ?>
        <section class="project-section pt-130 tl-bg-color fade-wrapper">
            <div class="bg-shape" data-background="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/project-shape-1.png' ); ?>"></div>
            <div class="project-text"><span><?php echo esc_html( $interior_projects['background_text'] ); ?></span></div>
            <div class="container container-2">
                <div class="row section-heading-wrap fade-top">  
                    <div class="shape"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/section-heading.png' ); ?>" alt="shape"></div>
                    <div class="col-lg-4 col-md-12">
                        <div class="section-heading mb-0">
                            <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_projects['subtitle'] ); ?></h4>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="section-heading section-heading-2 mb-0">
                            <h2 class="section-title cursor-effect title-2"><?php echo wp_kses_post( $interior_projects['title'] ); ?></h2>
                            <p class="mb-0"><?php echo wp_kses_post( $interior_projects['description'] ); ?></p>
                        </div>
                    </div>
                </div>
                <?php if ( $interior_latest_projects->have_posts() ) : ?>
                    <div class="project-carousel swiper fade-top">
                        <div class="swiper-wrapper">
                            <?php
                            while ( $interior_latest_projects->have_posts() ) :
                                $interior_latest_projects->the_post();
                                $interior_project_url     = add_query_arg( 'project_id', get_the_ID(), $interior_project_page_url );
                                $interior_project_summary = interior_get_item_summary( get_the_ID() );
                                ?>
                                <div class="swiper-slide">
                                    <div class="project-item">
                                        <div class="project-img">
                                            <a href="<?php echo esc_url( $interior_project_url ); ?>"><img src="<?php echo esc_url( interior_get_item_image_url( get_the_ID(), 'large' ) ); ?>" alt="<?php the_title_attribute(); ?>"></a>
                                        </div>
                                        <div class="project-content">
                                            <h3 class="title"><a href="<?php echo esc_url( $interior_project_url ); ?>"><?php the_title(); ?></a></h3>
                                            <?php if ( $interior_project_summary ) : ?>
                                                <span><?php echo esc_html( $interior_project_summary ); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="row fade-top">
                        <div class="col-12">
                            <p><?php esc_html_e( 'No projects have been added yet.', 'interior' ); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="project-house-img">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/images/project-house.png' ); ?>" alt="img">
            </div>
        </section>
        <!-- ./ project-section -->

        <?php
        $interior_testimonial              = interior_get_home_testimonial_data();
        $interior_testimonial_image        = ! empty( $interior_testimonial['image_id'] ) ? wp_get_attachment_image_url( (int) $interior_testimonial['image_id'], 'large' ) : '';
        $interior_testimonial_image        = $interior_testimonial_image ? $interior_testimonial_image : $interior_testimonial['image_url'];
        $interior_testimonial_author_image = ! empty( $interior_testimonial['author_image_id'] ) ? wp_get_attachment_image_url( (int) $interior_testimonial['author_image_id'], 'thumbnail' ) : '';
        $interior_testimonial_author_image = $interior_testimonial_author_image ? $interior_testimonial_author_image : $interior_testimonial['author_image_url'];
        ?>
        <section class="testimonial-section pt-150 fade-wrapper">
            <div class="container container-2">
                <div class="row section-heading-wrap fade-top">  
                    <div class="shape"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/section-heading.png' ); ?>" alt="shape"></div>
                    <div class="col-lg-4 col-md-12">
                        <div class="section-heading mb-0">
                            <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_testimonial['subtitle'] ); ?></h4>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="section-heading section-heading-2 mb-0">
                            <h2 class="section-title cursor-effect title-2"><?php echo wp_kses_post( $interior_testimonial['title'] ); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="testi-img slide-anim" data-delay="0.3" data-offset="100" data-direction="left">
                            <img src="<?php echo esc_url( $interior_testimonial_image ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $interior_testimonial['title'] ) ); ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="testi-carousel-wrap slide-anim" data-delay="0.3" data-offset="100" data-direction="right">
                            <div class="testi-top-content">
                                <div class="left-content">
                                    <h3 class="rating"><?php echo esc_html( $interior_testimonial['rating'] ); ?></h3>
                                    <div class="rating-list">
                                        <ul>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                        </ul>
                                        <span><?php echo esc_html( $interior_testimonial['reviews'] ); ?></span>
                                    </div>
                                </div>
                                <div class="right-content">
                                    <p><?php echo wp_kses_post( $interior_testimonial['intro'] ); ?></p>
                                </div>
                            </div>
                            <div class="testi-carousel swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="testi-item">
                                            <p><?php echo wp_kses_post( $interior_testimonial['quote'] ); ?></p>
                                            <div class="testi-author">
                                                <div class="author-img">
                                                    <img src="<?php echo esc_url( $interior_testimonial_author_image ); ?>" alt="<?php echo esc_attr( $interior_testimonial['author_name'] ); ?>">
                                                </div>
                                                <h4 class="name"><?php echo esc_html( $interior_testimonial['author_name'] ); ?> <span><?php echo esc_html( $interior_testimonial['author_position'] ); ?></span></h4>
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

        <?php $interior_video = interior_get_home_video_data(); ?>
        <section class="video-section pt-130 pb-130 tl-bg-color fade-wrapper">
            <div class="container container-2">
                <div class="section-heading text-center align-items-center fade-top">
                    <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03"><?php echo esc_html( $interior_video['subtitle'] ); ?></h4>
                    <h2 class="section-title cursor-effect title-2"><?php echo wp_kses_post( $interior_video['title'] ); ?></h2>
                </div>
                <div class="row gy-4 fade-top">
                    <?php foreach ( $interior_video['items'] as $interior_video_index => $interior_video_item ) : ?>
                        <?php
                        $interior_video_image = ! empty( $interior_video_item['image_id'] ) ? wp_get_attachment_image_url( (int) $interior_video_item['image_id'], 'large' ) : '';
                        $interior_video_image = $interior_video_image ? $interior_video_image : $interior_video_item['image_url'];
                        ?>
                        <?php if ( $interior_video_image ) : ?>
                            <div class="col-lg-6">
                                <div class="video-img">
                                    <img src="<?php echo esc_url( $interior_video_image ); ?>" alt="<?php echo esc_attr( sprintf( 'Video section image %d', $interior_video_index + 1 ) ); ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- ./ video-section -->


        <?php if ( $interior_section = interior_get_home_section_override( 'gallery' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <div class="gallary-section overflow-hidden">
            <div class="gallary-text"><span>gallery</span></div>
            <div class="gallary-wrap wrap-1">
                <div class="gallery-scroll-wrap">
                    <div class="gallary-scroll-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-6.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-6.png' ); ?>" alt="img"></a>
                    </div>
                    <div class="gallary-scroll-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-7.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-7.png' ); ?>" alt="img"></a>
                    </div>
                    <div class="gallary-scroll-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-8.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-8.png' ); ?>" alt="img"></a>
                    </div>
                    <div class="gallary-scroll-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-9.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-9.png' ); ?>" alt="img"></a>
                    </div>
                </div>
            </div>
            <div class="gallary-wrap gallery-scroll-direction-ltr">
                <div class="gallery-scroll-wrap align-items-start">
                    <div class="gallary-scroll-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-10.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-10.png' ); ?>" alt="img"></a>
                    </div>
                    <div class="gallary-scroll-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-11.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-11.png' ); ?>" alt="img"></a>
                    </div>
                    <div class="gallary-scroll-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-12.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-12.png' ); ?>" alt="img"></a>
                    </div>
                    <div class="gallary-scroll-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-13.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/project-img-13.png' ); ?>" alt="img"></a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ( $interior_section = interior_get_home_section_override( 'newsletter' ) ) : ?>
            <?php echo $interior_section; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
        <section class="newsletter-section pb-130 overflow-hidden tl-bg-color fade-wrapper">
            <div class="bg-shape"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/shapes/newsletter-shape.png' ); ?>" alt="shape"></div>
            <div class="container">
                <div class="newsletter-wrap">
                    <div class="section-heading text-center fade-top">
                        <h4 class="sub-heading" data-text-animation="fade-in-right" data-split="char" data-duration="0.9" data-stagger="0.03">Subscribe to the newsletter</h4>
                        <h2 class="section-title cursor-effect">Join <span>our newsletter <br> stay</span> up to date</h2>
                        <p class="fade-top">Join our newsletter. Learn something new, gain access to exclusive content, <br> andÂ stayÂ informed with the latest updates in the industry.</p>
                    </div>
                    <div class="newsletter-form fade-top">
                        <input type="text" id="email" name="email" class="form-control" placeholder="Email address..">
                        <button type="submit"><i class="fa-regular fa-arrow-right-long"></i></button>
                    </div>
                </div>
            </div>
        </section>
        <!-- ./ newsletter-section -->
        <?php endif; ?>

        
<?php
get_footer();
