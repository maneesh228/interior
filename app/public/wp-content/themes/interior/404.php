<?php
/**
 * The template for displaying 404 pages.
 *
 * Generated from Maneesh/error-page.html.
 *
 * @package Interior
 */

get_header();
?>
<div id="antra-smooth-wrapper">
        <div id="antra-smooth-content">

        <section class="error-section pt-150 pb-130">
            <div class="container container-2">
                <div class="error-content text-center">
                    <div class="error-img mb-50"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/images/error-img-1.png' ); ?>" alt="error"></div>
                    <div class="section-heading text-center align-items-center mb-0">
                        <h2 class="section-title"><span>Oops!</span> Page Not Found!</h2>
                        <p>We searched everywhere but couldn't find what your'e looking for. <br>Let's find a better place for you to go.</p>
                        <div class="error-btn mt-30">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tl-primary-btn">Back to Home<span class="icon"><i class="fa-regular fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        
<?php
get_footer();

