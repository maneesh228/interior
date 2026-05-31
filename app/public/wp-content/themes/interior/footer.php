<?php
$interior_footer      = function_exists( 'interior_get_footer_data' ) ? interior_get_footer_data() : array();
$interior_footer_bg   = ! empty( $interior_footer['bg_image_id'] ) ? wp_get_attachment_image_url( (int) $interior_footer['bg_image_id'], 'full' ) : ( isset( $interior_footer['bg_image_url'] ) ? $interior_footer['bg_image_url'] : get_template_directory_uri() . '/assets/img/bg-img/footer-bg.png' );
$interior_footer_logo = ! empty( $interior_footer['logo_id'] ) ? wp_get_attachment_image_url( (int) $interior_footer['logo_id'], 'full' ) : ( isset( $interior_footer['logo_url'] ) ? $interior_footer['logo_url'] : get_template_directory_uri() . '/assets/img/logo/logo-2.png' );
?>
<footer class="footer-section overflow-hidden">
            <div class="footer-bg" data-background="<?php echo esc_url( $interior_footer_bg ); ?>"></div>
            <div class="footer-shade"></div>
            <div class="container container-2">
                <div class="row footer-wrap">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <div class="widget-header">
                                <div class="footer-logo">
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $interior_footer_logo ); ?>" alt="logo"></a>
                                </div>
                            </div>
                            <p class="mb-10"><?php echo wp_kses_post( $interior_footer['description'] ); ?></p>
                            <p class="mb-0"><?php echo wp_kses_post( $interior_footer['address'] ); ?></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget footer-col-2">
                            <ul class="footer-list">
                                <?php foreach ( $interior_footer['link_columns'][0] as $interior_footer_link ) : ?>
                                    <?php if ( ! empty( $interior_footer_link['label'] ) ) : ?>
                                        <li><a href="<?php echo esc_url( isset( $interior_footer_link['url'] ) ? $interior_footer_link['url'] : '#' ); ?>"><?php echo esc_html( $interior_footer_link['label'] ); ?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget footer-col-2 pl-0">
                            <ul class="footer-list">
                                <?php foreach ( $interior_footer['link_columns'][1] as $interior_footer_link ) : ?>
                                    <?php if ( ! empty( $interior_footer_link['label'] ) ) : ?>
                                        <li><a href="<?php echo esc_url( isset( $interior_footer_link['url'] ) ? $interior_footer_link['url'] : '#' ); ?>"><?php echo esc_html( $interior_footer_link['label'] ); ?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <div class="footer-address">
                                <a class="number" href="<?php echo esc_url( $interior_footer['phone_url'] ); ?>"><?php echo esc_html( $interior_footer['phone'] ); ?></a>
                                <a class="mail" href="<?php echo esc_url( $interior_footer['email_url'] ); ?>"><?php echo esc_html( $interior_footer['email'] ); ?></a>
                                <ul class="social-list">
                                    <?php foreach ( $interior_footer['social_items'] as $interior_footer_social ) : ?>
                                        <?php if ( ! empty( $interior_footer_social['label'] ) ) : ?>
                                            <li><a href="<?php echo esc_url( $interior_footer_social['url'] ); ?>"><?php echo esc_html( $interior_footer_social['label'] ); ?></a></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-area">
                <div class="container">
                    <div class="copyright-content">
                        <p><?php echo esc_html( $interior_footer['copyright'] ); ?></p>
                    </div>
                </div>
            </div>
            <div class="footer-text"><span><?php echo esc_html( $interior_footer['big_text'] ); ?></span></div>
        </footer>
        <!-- ./ footer-section -->

        </div>
    </div>

        <div id="scroll-percentage"><span id="scroll-percentage-value"></span></div>
        <!--scrollup-->

        <!-- JS here -->
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/jquary-3.7.1.min.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/bootstrap-bundle.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/imagesloaded-pkgd.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/waypoints.min.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/venobox.min.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/odometer.min.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/meanmenu.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/jquery.isotope.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/swiper.min.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/split-type.min.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/gsap.min.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/scroll-trigger.min.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/scroll-smoother.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/jquery.carouselTicker.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/nice-select.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/three.min.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/panolens.min.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/jquery.event.move.min.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/vendor/jquery.twentytwenty.min.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/slider.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/banner-process.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/contact.js' ); ?>"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() . '/assets/js/main.js' ); ?>"></script>
            <?php wp_footer(); ?>
    </body>
</html>



