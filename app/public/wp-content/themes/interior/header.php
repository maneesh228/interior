<!doctype html>
<?php
$interior_header       = function_exists( 'interior_get_header_data' ) ? interior_get_header_data() : array();
$interior_header_logo  = ! empty( $interior_header['logo_dark_id'] ) ? wp_get_attachment_image_url( (int) $interior_header['logo_dark_id'], 'full' ) : ( isset( $interior_header['logo_dark_url'] ) ? $interior_header['logo_dark_url'] : get_template_directory_uri() . '/assets/img/logo/logo-2.png' );
$interior_header_light = ! empty( $interior_header['logo_light_id'] ) ? wp_get_attachment_image_url( (int) $interior_header['logo_light_id'], 'full' ) : ( isset( $interior_header['logo_light_url'] ) ? $interior_header['logo_light_url'] : get_template_directory_uri() . '/assets/img/logo/logo-1.png' );
?>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">

        <!-- Place favicon.ico in the root directory -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/favicon.png' ); ?>">

        <!-- CSS here -->
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/bootstrap.min.css' ); ?>">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/fontawesome.min.css' ); ?>">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/venobox.min.css' ); ?>">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/odometer.min.css' ); ?>">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/nice-select.css' ); ?>">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/carouselTicker.css' ); ?>">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/animation.css' ); ?>">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/twentytwenty.min.css' ); ?>">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/swiper.min.css' ); ?>">
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/main.css' ); ?>">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>

        <!-- preloader -->
        <div class="preloader overflow-hidden">
            <div class="site-name"><span><?php echo esc_html( $interior_header['preloader_text'] ); ?></span></div>
            <div class="preloader-gutters">
                <div class="bar">
                    <div class="inner-bar"></div>
                </div>
                <div class="bar">
                    <div class="inner-bar"></div>
                </div>
                <div class="bar">
                    <div class="inner-bar"></div>
                </div>
                <div class="bar">
                    <div class="inner-bar"></div>
                </div>
                <div class="bar">
                    <div class="inner-bar"></div>
                </div>
                <div class="bar">
                    <div class="inner-bar"></div>
                </div>
                <div class="bar">
                    <div class="inner-bar"></div>
                </div>
                <div class="bar">
                    <div class="inner-bar"></div>
                </div>
            </div>
        </div>
        <!-- /.preloader -->

        <!-- header-area-start -->
        <header class="header sticky-active">
            <div class="primary-header">
                <div class="container">
                    <div class="primary-header-inner">
                        <div class="header-left-wrap">
                            <div class="header-logo d-lg-block">
                                <a href="/">
                                    <img src="<?php echo esc_url( $interior_header_logo ); ?>" alt="logo">
                                </a>
                            </div>
                            <div class="header-menu-wrap">
                                <div class="mobile-menu-items">
                                    <ul>
                                        <?php if ( ! empty( $interior_header['nav_items'][0]['label'] ) ) : ?>
                                            <li><a href="<?php echo esc_url( $interior_header['nav_items'][0]['url'] ); ?>"><?php echo esc_html( $interior_header['nav_items'][0]['label'] ); ?></a></li>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $interior_header['nav_items'][1]['label'] ) ) : ?>
                                            <li><a href="<?php echo esc_url( $interior_header['nav_items'][1]['url'] ); ?>"><?php echo esc_html( $interior_header['nav_items'][1]['label'] ); ?></a></li>
                                        <?php endif; ?>
                                        <?php
                                        $header_services        = function_exists( 'interior_get_ordered_items' ) ? interior_get_ordered_items( 'interior_service' ) : null;
                                        $header_detail_page_url = function_exists( 'interior_get_template_page_url' ) ? interior_get_template_page_url( 'page-serviceDetails.php' ) : home_url( '/service-details/' );
                                        ?>
                                        <li class="menu-item-has-children">
                                            <a href="<?php echo esc_url( $interior_header['services_url'] ); ?>"><?php echo esc_html( $interior_header['services_label'] ); ?></a>
                                            <?php if ( $header_services && $header_services->have_posts() ) : ?>
                                                <ul>
                                                    <?php
                                                    while ( $header_services->have_posts() ) :
                                                        $header_services->the_post();
                                                        $header_service_url = add_query_arg( 'service_id', get_the_ID(), $header_detail_page_url );
                                                        ?>
                                                        <li><a href="<?php echo esc_url( $header_service_url ); ?>"><?php the_title(); ?></a></li>
                                                    <?php endwhile; ?>
                                                </ul>
                                                <?php wp_reset_postdata(); ?>
                                            <?php endif; ?>
                                        </li>
                                        <?php
                                        $header_projects        = function_exists( 'interior_get_ordered_items' ) ? interior_get_ordered_items( 'interior_project' ) : null;
                                        $header_project_page_url = function_exists( 'interior_get_template_page_url' ) ? interior_get_template_page_url( 'page-projectDetails.php' ) : home_url( '/project-details/' );
                                        ?>
                                        <li class="menu-item-has-children">
                                            <a href="<?php echo esc_url( $interior_header['projects_url'] ); ?>"><?php echo esc_html( $interior_header['projects_label'] ); ?></a>
                                            <?php if ( $header_projects && $header_projects->have_posts() ) : ?>
                                                <ul>
                                                    <?php
                                                    while ( $header_projects->have_posts() ) :
                                                        $header_projects->the_post();
                                                        $header_project_url = add_query_arg( 'project_id', get_the_ID(), $header_project_page_url );
                                                        ?>
                                                        <li><a href="<?php echo esc_url( $header_project_url ); ?>"><?php the_title(); ?></a></li>
                                                    <?php endwhile; ?>
                                                </ul>
                                                <?php wp_reset_postdata(); ?>
                                            <?php endif; ?>
                                        </li>
                                        <!-- <li class="menu-item-has-children">
                                            <a href="blog-grid.html">Blog</a>
                                            <ul>
                                                <li><a href="blog-grid.html">Blog Grid</a></li>
                                                <li><a href="blog-list.html">Blog List</a></li>
                                                <li><a href="blog-standard.html">Blog Standard</a></li>
                                                <li><a href="blog-single.html">Blog Single</a></li>
                                                <li><a href="blog-details.html">Blog Details</a></li>
                                            </ul>
                                        </li> -->
                                        <?php if ( ! empty( $interior_header['nav_items'][2]['label'] ) ) : ?>
                                            <li><a href="<?php echo esc_url( $interior_header['nav_items'][2]['url'] ); ?>"><?php echo esc_html( $interior_header['nav_items'][2]['label'] ); ?></a></li>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $interior_header['nav_items'][3]['label'] ) ) : ?>
                                            <li><a href="<?php echo esc_url( $interior_header['nav_items'][3]['url'] ); ?>"><?php echo esc_html( $interior_header['nav_items'][3]['label'] ); ?></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.header-menu-wrap -->
                        </div>
                        <div class="header-right-wrap">
                            <a href="<?php echo esc_url( $interior_header['phone_url'] ); ?>" class="header-contact">
                                <span class="icon"><i class="fa-regular fa-phone"></i></span>
                                <span class="content">
                                    <span class="call-text"><?php echo esc_html( $interior_header['phone_label'] ); ?></span>
                                    <span class="call-number"><?php echo esc_html( $interior_header['phone_number'] ); ?></span>
                                </span>
                            </a>
                            <div class="header-btn-wrap">
                                <a href="<?php echo esc_url( $interior_header['button_url'] ); ?>" class="tl-primary-btn header-btn"><?php echo esc_html( $interior_header['button_text'] ); ?></a>
                            </div>
                            <div class="search-icon dl-search-icon">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <div class="sidebar-icon">
                                <button class="sidebar-trigger open">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 2C11 0.89543 11.8954 0 13 0H14C15.1046 0 16 0.895431 16 2V3C16 4.10457 15.1046 5 14 5H13C11.8954 5 11 4.10457 11 3V2Z" fill="white"/>
                                        <path d="M0 2C0 0.89543 0.895431 0 2 0H3C4.10457 0 5 0.895431 5 2V3C5 4.10457 4.10457 5 3 5H2C0.89543 5 0 4.10457 0 3V2Z" fill="white"/>
                                        <path d="M0 13C0 11.8954 0.895431 11 2 11H3C4.10457 11 5 11.8954 5 13V14C5 15.1046 4.10457 16 3 16H2C0.89543 16 0 15.1046 0 14V13Z" fill="white"/>
                                        <path d="M11 13C11 11.8954 11.8954 11 13 11H14C15.1046 11 16 11.8954 16 13V14C16 15.1046 15.1046 16 14 16H13C11.8954 16 11 15.1046 11 14V13Z" fill="white"/>
                                    </svg>
                                </button>
                            </div>
                            <!-- /.header-right -->
                        </div>
                    </div>
                    <!-- /.primary-header-inner -->
                </div>
            </div>
        </header>
        <!-- /.Main Header -->

        <div id="popup-search-box">
            <div class="box-inner-wrap d-flex align-items-center">
                <form id="form" action="#" method="get" role="search">
                    <input id="popup-search" type="text" name="s" placeholder="<?php echo esc_attr( $interior_header['search_placeholder'] ); ?>">
                </form>
                <div class="search-close"><i class="fa-sharp fa-regular fa-xmark"></i></div>
            </div>
        </div>
        <!-- /#popup-search-box -->

        <div id="sidebar-area" class="sidebar-area">
            <button class="sidebar-trigger close">
                <svg
                    class="sidebar-close"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    width="16px"
                    height="12.7px"
                    viewBox="0 0 16 12.7"
                    style="enable-background: new 0 0 16 12.7"
                    xml:space="preserve">
                    <g>
                        <rect
                            x="0"
                            y="5.4"
                            transform="matrix(0.7071 -0.7071 0.7071 0.7071 -2.1569 7.5208)"
                            width="16"
                            height="2"
                        ></rect>
                        <rect
                            x="0"
                            y="5.4"
                            transform="matrix(0.7071 0.7071 -0.7071 0.7071 6.8431 -3.7929)"
                            width="16"
                            height="2"
                        ></rect>
                    </g>
                </svg>
            </button>
            <div class="side-menu-content">
                <div class="side-menu-logo">
                    <a class="dark-img" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $interior_header_logo ); ?>" alt="logo"></a>
                    <a class="light-img" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $interior_header_light ); ?>" alt="logo"></a>
                </div>
                <div class="side-menu-wrap"></div>
                <div class="side-menu-about">
                    <h4 class="title"><?php echo wp_kses_post( $interior_header['side_title'] ); ?></h4>
                </div>
                <div class="side-menu-gallary">
                    <?php foreach ( $interior_header['gallery_items'] as $interior_header_gallery_item ) : ?>
                        <?php $interior_header_gallery_image = ! empty( $interior_header_gallery_item['image_id'] ) ? wp_get_attachment_image_url( (int) $interior_header_gallery_item['image_id'], 'full' ) : $interior_header_gallery_item['image_url']; ?>
                        <?php if ( $interior_header_gallery_image ) : ?>
                            <div class="side-menu-gallary-item">
                                <a href="<?php echo esc_url( $interior_header_gallery_image ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( $interior_header_gallery_image ); ?>" alt="img"></a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="side-menu-contact">
                    <ul class="side-menu-list">
                        <li>
                            <?php echo wp_kses_post( nl2br( $interior_header['side_address'] ) ); ?>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( $interior_header['side_phone_url'] ); ?>"><?php echo esc_html( $interior_header['side_phone'] ); ?></a>
                        </li>
                        <li>
                            <a class="mail" href="<?php echo esc_url( $interior_header['side_email_url'] ); ?>"><?php echo esc_html( $interior_header['side_email'] ); ?></a>
                        </li>
                    </ul>
                </div>
                <ul class="side-menu-social">
                    <?php foreach ( $interior_header['social_items'] as $interior_header_social ) : ?>
                        <li><a href="<?php echo esc_url( $interior_header_social['url'] ); ?>" aria-label="<?php echo esc_attr( $interior_header_social['label'] ); ?>"><i class="<?php echo esc_attr( $interior_header_social['icon'] ); ?>"></i></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <!--/.sidebar-area-->
        <div id="sidebar-overlay"></div>

        <div class="mobile-side-menu">
            <div class="side-menu-content">
                <div class="side-menu-head">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $interior_header_logo ); ?>" alt="logo"></a>
                    <button class="mobile-side-menu-close"><i class="fa-regular fa-xmark"></i></button>
                </div>
                <div class="side-menu-wrap"></div>
                <div class="side-menu-contact">
                    <div class="side-menu-header">
                        <h3><?php echo esc_html( $interior_header['mobile_title'] ); ?></h3>
                    </div>
                    <ul class="side-menu-list">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <p><?php echo wp_kses_post( nl2br( $interior_header['mobile_address'] ) ); ?></p>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <a href="<?php echo esc_url( $interior_header['mobile_phone_url'] ); ?>"><?php echo esc_html( $interior_header['mobile_phone'] ); ?></a>
                        </li>
                        <li>
                            <i class="fas fa-envelope-open-text"></i>
                            <a href="<?php echo esc_url( $interior_header['mobile_email_url'] ); ?>"><?php echo esc_html( $interior_header['mobile_email'] ); ?></a>
                        </li>
                    </ul>
                </div>
                <ul class="side-menu-social">
                    <?php foreach ( $interior_header['social_items'] as $interior_header_social ) : ?>
                        <li><a href="<?php echo esc_url( $interior_header_social['url'] ); ?>" aria-label="<?php echo esc_attr( $interior_header_social['label'] ); ?>"><i class="<?php echo esc_attr( $interior_header_social['icon'] ); ?>"></i></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <!-- /.mobile-side-menu -->
        <div class="mobile-side-menu-overlay"></div>

    
