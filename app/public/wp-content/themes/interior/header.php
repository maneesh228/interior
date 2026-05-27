<!doctype html>
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
            <div class="site-name"><span>ANTRA</span></div>
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
                                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo/logo-2.png' ); ?>" alt="logo">
                                </a>
                            </div>
                            <div class="header-menu-wrap">
                                <div class="mobile-menu-items">
                                    <ul>
                                        <li>
                                            <a href="/">Home</a>
                                        </li>
                                         <li>
                                            <a href="/about-us">About Us</a>
                                        </li>
                                        <?php
                                        $header_services        = function_exists( 'interior_get_ordered_items' ) ? interior_get_ordered_items( 'interior_service' ) : null;
                                        $header_detail_page_url = function_exists( 'interior_get_template_page_url' ) ? interior_get_template_page_url( 'page-serviceDetails.php' ) : home_url( '/service-details/' );
                                        ?>
                                        <li class="menu-item-has-children">
                                            <a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Services</a>
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
                                            <a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>">Projects</a>
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
                                         <li><a href="/media">Media</a></li>
                                        <li><a href="/contact">Contact</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.header-menu-wrap -->
                        </div>
                        <div class="header-right-wrap">
                            <a href="tel:+480123678900" class="header-contact">
                                <span class="icon"><i class="fa-regular fa-phone"></i></span>
                                <span class="content">
                                    <span class="call-text">Call Us Phone</span>
                                    <span class="call-number">(+480) 123 678 900</span>
                                </span>
                            </a>
                            <div class="header-btn-wrap">
                                <a href="/contact" class="tl-primary-btn header-btn">Get in Touch</a>
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
                    <input id="popup-search" type="text" name="s" placeholder="Type keywords here...">
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
                    <a class="dark-img" href="index.html"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo/logo-2.png' ); ?>" alt="logo"></a>
                    <a class="light-img" href="index.html"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo/logo-1.png' ); ?>" alt="logo"></a>
                </div>
                <div class="side-menu-wrap"></div>
                <div class="side-menu-about">
                    <h4 class="title">We Shape Interior Designs, Crafting Timeless and Inspiring Spaces</h4>
                </div>
                <div class="side-menu-gallary">
                    <div class="side-menu-gallary-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/sidebar-gallary-1.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/sidebar-gallary-1.png' ); ?>" alt="img"></a>
                    </div>
                    <div class="side-menu-gallary-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/sidebar-gallary-2.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/sidebar-gallary-2.png' ); ?>" alt="img"></a>
                    </div>
                    <div class="side-menu-gallary-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/sidebar-gallary-3.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/sidebar-gallary-3.png' ); ?>" alt="img"></a>
                    </div>
                    <div class="side-menu-gallary-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/sidebar-gallary-4.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/sidebar-gallary-4.png' ); ?>" alt="img"></a>
                    </div>
                    <div class="side-menu-gallary-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/sidebar-gallary-5.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/sidebar-gallary-5.png' ); ?>" alt="img"></a>
                    </div>
                    <div class="side-menu-gallary-item">
                        <a href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/sidebar-gallary-6.png' ); ?>" class="venobox" data-gall="gallary1"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/project/sidebar-gallary-6.png' ); ?>" alt="img"></a>
                    </div>
                </div>
                <div class="side-menu-contact">
                    <ul class="side-menu-list">
                        <li>
                            5609 E Sprague Ave, <br>Spokane Valley, WA 99212,<br> USA
                        </li>
                        <li>
                            <a href="tel:+0844560789">+(084) 456-0789</a>
                        </li>
                        <li>
                            <a class="mail" href="mailto:support@example.com">support@example.com</a>
                        </li>
                    </ul>
                </div>
                <ul class="side-menu-social">
                    <li class="facebook"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="instagram"><a href="#"><i class="fab fa-instagram"></i></a></li>
                    <li class="twitter"><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li class="g-plus"><a href="#"><i class="fab fa-fab fa-google-plus"></i></a></li>
                </ul>
            </div>
        </div>
        <!--/.sidebar-area-->
        <div id="sidebar-overlay"></div>

        <div class="mobile-side-menu">
            <div class="side-menu-content">
                <div class="side-menu-head">
                    <a href="index.html"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo/logo-2.png' ); ?>" alt="logo"></a>
                    <button class="mobile-side-menu-close"><i class="fa-regular fa-xmark"></i></button>
                </div>
                <div class="side-menu-wrap"></div>
                <div class="side-menu-contact">
                    <div class="side-menu-header">
                        <h3>Contact Us</h3>
                    </div>
                    <ul class="side-menu-list">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <p>Valentin, Street Road 24, New York, </p>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <a href="tel:+000123456789">+000 123 (456) 789</a>
                        </li>
                        <li>
                            <i class="fas fa-envelope-open-text"></i>
                            <a href="mailto:antra@gmail.com">antra@gmail.com</a>
                        </li>
                    </ul>
                </div>
                <ul class="side-menu-social">
                    <li class="facebook"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="instagram"><a href="#"><i class="fab fa-instagram"></i></a></li>
                    <li class="twitter"><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li class="g-plus"><a href="#"><i class="fab fa-fab fa-google-plus"></i></a></li>
                </ul>
            </div>
        </div>
        <!-- /.mobile-side-menu -->
        <div class="mobile-side-menu-overlay"></div>

    
