<?php
/**
 * Interior theme functions.
 *
 * @package Interior
 */

if ( ! defined( 'INTERIOR_VERSION' ) ) {
	define( 'INTERIOR_VERSION', '1.0.0' );
}        

/**
 * Set up theme defaults and WordPress feature support.
 */
function interior_setup() {
	load_theme_textdomain( 'interior', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'interior' ),
		)
	);
}
add_action( 'after_setup_theme', 'interior_setup' );

/**
 * Register the compiled stylesheet so WordPress recognizes the theme stylesheet.
 * The source template CSS is linked in header.php to preserve the original order.
 */
function interior_scripts() {
	wp_enqueue_style( 'interior-style', get_stylesheet_uri(), array(), INTERIOR_VERSION );
}
add_action( 'wp_enqueue_scripts', 'interior_scripts' );

/**
 * Register Services and Projects in wp-admin.
 */
function interior_register_custom_post_types() {
	$common_supports = array( 'title', 'editor', 'thumbnail', 'excerpt' );

	register_post_type(
		'interior_service',
		array(
			'labels'       => array(
				'name'          => esc_html__( 'Services', 'interior' ),
				'singular_name' => esc_html__( 'Service', 'interior' ),
				'add_new_item'  => esc_html__( 'Add New Service', 'interior' ),
				'edit_item'     => esc_html__( 'Edit Service', 'interior' ),
			),
			'public'       => true,
			'menu_icon'    => 'dashicons-hammer',
			'has_archive'  => false,
			'rewrite'      => array( 'slug' => 'services' ),
			'supports'     => $common_supports,
			'show_in_rest' => false,
		)
	);

	register_post_type(
		'interior_project',
		array(
			'labels'       => array(
				'name'          => esc_html__( 'Projects', 'interior' ),
				'singular_name' => esc_html__( 'Project', 'interior' ),
				'add_new_item'  => esc_html__( 'Add New Project', 'interior' ),
				'edit_item'     => esc_html__( 'Edit Project', 'interior' ),
			),
			'public'       => true,
			'menu_icon'    => 'dashicons-portfolio',
			'has_archive'  => false,
			'rewrite'      => array( 'slug' => 'projects' ),
			'supports'     => $common_supports,
			'show_in_rest' => false,
		)
	);
}
add_action( 'init', 'interior_register_custom_post_types' );

/**
 * Refresh permalinks when theme is activated.
 */
function interior_flush_rewrites_on_switch() {
	interior_register_custom_post_types();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'interior_flush_rewrites_on_switch' );

/**
 * Add order number and image fields for Services and Projects.
 */
function interior_add_item_meta_boxes() {
	foreach ( array( 'interior_service', 'interior_project' ) as $post_type ) {
		add_meta_box(
			'interior_item_options',
			esc_html__( 'Item Options', 'interior' ),
			'interior_render_item_options',
			$post_type,
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'interior_add_item_meta_boxes' );

/**
 * Render item options meta box.
 *
 * @param WP_Post $post Current post.
 */
function interior_render_item_options( $post ) {
	wp_nonce_field( 'interior_save_item_options', 'interior_item_options_nonce' );

	$order    = get_post_meta( $post->ID, '_interior_order_number', true );
	$image_id = (int) get_post_meta( $post->ID, '_interior_image_id', true );
	$image    = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';
	?>
	<p>
		<label for="interior_order_number"><strong><?php esc_html_e( 'Order Number', 'interior' ); ?></strong></label><br>
		<input type="number" id="interior_order_number" name="interior_order_number" value="<?php echo esc_attr( $order ); ?>" style="width:120px;">
	</p>
	<p>
		<label><strong><?php esc_html_e( 'Image', 'interior' ); ?></strong></label><br>
		<input type="hidden" id="interior_image_id" name="interior_image_id" value="<?php echo esc_attr( $image_id ); ?>">
		<img id="interior_image_preview" src="<?php echo esc_url( $image ); ?>" alt="" style="<?php echo $image ? '' : 'display:none;'; ?>max-width:220px;height:auto;margin:8px 0 10px;">
		<br>
		<button type="button" class="button" id="interior_upload_image"><?php esc_html_e( 'Choose Image', 'interior' ); ?></button>
		<button type="button" class="button" id="interior_remove_image"><?php esc_html_e( 'Remove Image', 'interior' ); ?></button>
	</p>
	<p><?php esc_html_e( 'Use the main WordPress editor for the title and TinyMCE description.', 'interior' ); ?></p>
	<?php
}

/**
 * Save item options.
 *
 * @param int $post_id Post ID.
 */
function interior_save_item_options( $post_id ) {
	if ( ! isset( $_POST['interior_item_options_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['interior_item_options_nonce'] ) ), 'interior_save_item_options' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$order    = isset( $_POST['interior_order_number'] ) ? absint( $_POST['interior_order_number'] ) : 0;
	$image_id = isset( $_POST['interior_image_id'] ) ? absint( $_POST['interior_image_id'] ) : 0;

	update_post_meta( $post_id, '_interior_order_number', $order );
	update_post_meta( $post_id, '_interior_image_id', $image_id );
}
add_action( 'save_post_interior_service', 'interior_save_item_options' );
add_action( 'save_post_interior_project', 'interior_save_item_options' );

/**
 * Enable the media picker in Services and Projects.
 *
 * @param string $hook Current admin page hook.
 */
function interior_admin_media_picker( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$screen = get_current_screen();
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
	$post    = $post_id ? get_post( $post_id ) : null;

	if ( ! $screen || ( ! in_array( $screen->post_type, array( 'interior_service', 'interior_project' ), true ) && ! interior_is_home_editor_page( $post ) ) ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_script( 'jquery' );
	wp_add_inline_script(
		'jquery',
		"jQuery(function($){
			var frame;
			$('#interior_upload_image').on('click', function(e){
				e.preventDefault();
				frame = wp.media({title:'Choose Image', button:{text:'Use Image'}, multiple:false});
				frame.on('select', function(){
					var attachment = frame.state().get('selection').first().toJSON();
					$('#interior_image_id').val(attachment.id);
					$('#interior_image_preview').attr('src', attachment.url).show();
				});
				frame.open();
			});
			$('#interior_remove_image').on('click', function(e){
				e.preventDefault();
				$('#interior_image_id').val('');
				$('#interior_image_preview').attr('src', '').hide();
			});
		});"
	);
}
add_action( 'admin_enqueue_scripts', 'interior_admin_media_picker' );

/**
 * Return the selected item image URL.
 *
 * @param int    $post_id Post ID.
 * @param string $size    Image size.
 * @return string
 */
function interior_get_item_image_url( $post_id, $size = 'large' ) {
	$image_id = (int) get_post_meta( $post_id, '_interior_image_id', true );

	if ( $image_id ) {
		$image = wp_get_attachment_image_url( $image_id, $size );
		if ( $image ) {
			return $image;
		}
	}

	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail_url( $post_id, $size );
	}

	return get_template_directory_uri() . '/assets/img/service/service-img-1.png';
}

/**
 * Return ordered Services or Projects.
 *
 * @param string $post_type Post type.
 * @return WP_Query
 */
function interior_get_ordered_items( $post_type ) {
	return new WP_Query(
		array(
			'post_type'      => $post_type,
			'posts_per_page' => -1,
			'meta_key'       => '_interior_order_number',
			'orderby'        => array(
				'meta_value_num' => 'ASC',
				'date'           => 'DESC',
			),
			'order'          => 'ASC',
		)
	);
}

/**
 * Return the newest Service posts.
 *
 * @param int $limit Number of services to fetch.
 * @return WP_Query
 */
function interior_get_latest_services( $limit = 5 ) {
	return new WP_Query(
		array(
			'post_type'      => 'interior_service',
			'posts_per_page' => absint( $limit ),
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
}

/**
 * Return the newest Project posts.
 *
 * @param int $limit Number of projects to fetch.
 * @return WP_Query
 */
function interior_get_latest_projects( $limit = 3 ) {
	return new WP_Query(
		array(
			'post_type'      => 'interior_project',
			'posts_per_page' => absint( $limit ),
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
}

/**
 * Find a page URL assigned to a specific page template.
 *
 * @param string $template Template file name.
 * @return string
 */
function interior_get_template_page_url( $template ) {
	$detail_routes = array(
		'page-serviceDetails.php' => 'service-details',
		'page-projectDetails.php' => 'project-details',
	);

	$pages = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => $template,
			'number'     => 1,
		)
	);

	if ( ! empty( $pages ) ) {
		return get_permalink( $pages[0]->ID );
	}

	if ( isset( $detail_routes[ $template ] ) ) {
		$page = get_page_by_path( $detail_routes[ $template ] );
		if ( $page && 'publish' === $page->post_status ) {
			return get_permalink( $page->ID );
		}
	}

	$fallback_slug = isset( $detail_routes[ $template ] ) ? $detail_routes[ $template ] : preg_replace( '/^page-(.+)\.php$/', '$1', $template );

	return home_url( '/' . trim( $fallback_slug, '/' ) . '/' );
}

/**
 * Register direct detail routes so detail templates work even without a page match.
 */
function interior_register_detail_routes() {
	add_rewrite_rule( '^service-details/?$', 'index.php?interior_detail_template=service', 'top' );
	add_rewrite_rule( '^serviceDetails/?$', 'index.php?interior_detail_template=service', 'top' );
	add_rewrite_rule( '^project-details/?$', 'index.php?interior_detail_template=project', 'top' );
	add_rewrite_rule( '^projectDetails/?$', 'index.php?interior_detail_template=project', 'top' );
}
add_action( 'init', 'interior_register_detail_routes' );

/**
 * Allow the detail-route query var.
 *
 * @param array $vars Public query vars.
 * @return array
 */
function interior_detail_query_vars( $vars ) {
	$vars[] = 'interior_detail_template';
	return $vars;
}
add_filter( 'query_vars', 'interior_detail_query_vars' );

/**
 * Load service/project detail templates for the direct routes.
 *
 * @param string $template Current template.
 * @return string
 */
function interior_detail_template_include( $template ) {
	$detail_template = get_query_var( 'interior_detail_template' );

	if ( 'service' === $detail_template ) {
		$file = get_template_directory() . '/page-serviceDetails.php';
		return file_exists( $file ) ? $file : $template;
	}

	if ( 'project' === $detail_template ) {
		$file = get_template_directory() . '/page-projectDetails.php';
		return file_exists( $file ) ? $file : $template;
	}

	return $template;
}
add_filter( 'template_include', 'interior_detail_template_include' );

/**
 * Return a short text summary from item content.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function interior_get_item_summary( $post_id ) {
	$excerpt = get_the_excerpt( $post_id );

	if ( $excerpt ) {
		return $excerpt;
	}

	return wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ), 18 );
}

/**
 * Home page section keys and labels.
 *
 * @return array
 */
function interior_get_home_section_tabs() {
	return array(
		'slider'      => esc_html__( 'Slider', 'interior' ),
		'services'    => esc_html__( 'Services Intro', 'interior' ),
		'about'       => esc_html__( 'About', 'interior' ),
		'features'    => esc_html__( 'Feature Services', 'interior' ),
		'counter'     => esc_html__( 'Counter', 'interior' ),
		'process'     => esc_html__( 'Process', 'interior' ),
		'projects'    => esc_html__( 'Projects', 'interior' ),
		'testimonial' => esc_html__( 'Testimonials', 'interior' ),
		// 'sponsors'    => esc_html__( 'Sponsors', 'interior' ),
		// 'team'        => esc_html__( 'Team', 'interior' ),
		'video'       => esc_html__( 'Video', 'interior' ),
		// 'blog'        => esc_html__( 'Blog', 'interior' ),
		'gallery'     => esc_html__( 'Gallery', 'interior' ),
		'newsletter'  => esc_html__( 'Newsletter', 'interior' ),
	);
}

/**
 * Default home slider values.
 *
 * @return array
 */
function interior_get_home_slider_defaults() {
	$defaults = array();

	for ( $i = 1; $i <= 2; $i++ ) {
		$defaults[ 'slide_' . $i . '_bg_image_id' ]    = 0;
		$defaults[ 'slide_' . $i . '_subtitle' ]       = 'FAST AND RELIABLE';
		$defaults[ 'slide_' . $i . '_title' ]          = 'The Art of Stunning <br> Interior Design';
		$defaults[ 'slide_' . $i . '_description' ]    = "Whether it's your home, office, or a commercial <br> project, we are always dedicated to bringing <br> your vision to life.";
		$defaults[ 'slide_' . $i . '_button_text' ]    = 'Take counsel';
		$defaults[ 'slide_' . $i . '_button_url' ]     = home_url( '/contact/' );
		$defaults[ 'slide_' . $i . '_stat_number' ]    = '260+';
		$defaults[ 'slide_' . $i . '_stat_label' ]     = 'Successful projects <br> and counting';
		$defaults[ 'slide_' . $i . '_stat_desc' ]      = 'Tech Specifications <br>Design Project <br>3D visualisation';
		$defaults[ 'slide_' . $i . '_thumb_image_id' ] = 0;
	}

	return $defaults;
}

/**
 * Get saved home slider values.
 *
 * The slider data is stored as a theme option (site-wide) so that updates
 * made from any home/front-page editor screen are always reflected on the
 * front-end regardless of which page ID is queried.
 *
 * @param int $page_id Optional page ID (kept for backwards compatibility).
 * @return array
 */
function interior_get_home_slider_data( $page_id = 0 ) {
	$saved = get_option( 'interior_home_slider', array() );

	// Backwards compatibility: if a previous version stored data per-page,
	// fall back to that page meta the first time and migrate it to the option.
	if ( ( ! is_array( $saved ) || empty( $saved ) ) ) {
		$lookup_id = $page_id ? (int) $page_id : (int) get_queried_object_id();
		if ( ! $lookup_id ) {
			$lookup_id = (int) get_option( 'page_on_front' );
		}
		if ( $lookup_id ) {
			$legacy = get_post_meta( $lookup_id, '_interior_home_slider', true );
			if ( is_array( $legacy ) && ! empty( $legacy ) ) {
				$saved = $legacy;
				update_option( 'interior_home_slider', $saved );
			}
		}
	}

	return wp_parse_args( is_array( $saved ) ? $saved : array(), interior_get_home_slider_defaults() );
}

/**
 * Default home services section values.
 *
 * @return array
 */
function interior_get_home_services_defaults() {
	return array(
		'subtitle'    => 'WHO We Are',
		'title'       => 'Experience <span>the art of Interior</span> Design',
		'description' => 'We specialize in transforming visions into reality. <br> Explore our portfolio of innovative architectural and interior design projects <br> crafted with precision.',
		'items'       => array(
			array(
				'title'       => 'Architectural <br> Design',
				'description' => 'Dream it, we will design it! From big picture layouts to the tiniest details, our architectural magic brings your ideas to life with creativity and precision!',
				'url'         => home_url( '/service-details/' ),
				'icon_id'     => 0,
				'icon_url'    => get_template_directory_uri() . '/assets/img/icon/service-icon-1.png',
				'direction'   => 'left',
			),
			array(
				'title'       => 'Interior Design <br> & Planning',
				'description' => 'Dream it, we will design it! From big picture layouts to the tiniest details, our architectural magic brings your ideas to life with creativity and precision!',
				'url'         => home_url( '/service-details/' ),
				'icon_id'     => 0,
				'icon_url'    => get_template_directory_uri() . '/assets/img/icon/service-icon-2.png',
				'direction'   => 'bottom',
			),
			array(
				'title'       => 'Consulting <br> Services',
				'description' => 'Dream it, we will design it! From big picture layouts to the tiniest details, our architectural magic brings your ideas to life with creativity and precision!',
				'url'         => home_url( '/service-details/' ),
				'icon_id'     => 0,
				'icon_url'    => get_template_directory_uri() . '/assets/img/icon/service-icon-3.png',
				'direction'   => 'bottom',
			),
			array(
				'title'       => 'Project <br> Management',
				'description' => 'Dream it, we will design it! From big picture layouts to the tiniest details, our architectural magic brings your ideas to life with creativity and precision!',
				'url'         => home_url( '/service-details/' ),
				'icon_id'     => 0,
				'icon_url'    => get_template_directory_uri() . '/assets/img/icon/service-icon-4.png',
				'direction'   => 'right',
			),
		),
	);
}

/**
 * Get saved home services section values.
 *
 * @param int $page_id Optional page ID.
 * @return array
 */
function interior_get_home_services_data( $page_id = 0 ) {
	$defaults = interior_get_home_services_defaults();
	$saved    = get_option( 'interior_home_services', array() );

	if ( ( ! is_array( $saved ) || empty( $saved ) ) && $page_id ) {
		$legacy = get_post_meta( $page_id, '_interior_home_services', true );
		if ( is_array( $legacy ) && ! empty( $legacy ) ) {
			$saved = $legacy;
			update_option( 'interior_home_services', $saved );
		}
	}

	$saved = is_array( $saved ) ? $saved : array();
	$data  = wp_parse_args( $saved, $defaults );

	$data['items'] = isset( $saved['items'] ) && is_array( $saved['items'] ) ? $saved['items'] : array();
	for ( $i = 0; $i < 4; $i++ ) {
		$data['items'][ $i ] = wp_parse_args( isset( $data['items'][ $i ] ) && is_array( $data['items'][ $i ] ) ? $data['items'][ $i ] : array(), $defaults['items'][ $i ] );
	}

	return $data;
}

/**
 * Default home about section values.
 *
 * @return array
 */
function interior_get_home_about_defaults() {
	return array(
		'subtitle'      => 'Started In 1991',
		'title'         => 'Where Spaces <br> Inspire, and <span>Design <br> Comes Alive</span>',
		'description'   => "Whether it's your home, office, or a commercial project, we are always dedicated to bringing your vision to life. Our numbers speak better than words:",
		'button_text'   => 'More About Us',
		'button_url'    => home_url( '/about/' ),
		'background_text' => 'antra',
		'image_id'      => 0,
		'image_url'     => get_template_directory_uri() . '/assets/img/images/about-img-1.png',
		'icon_url'      => get_template_directory_uri() . '/assets/img/icon/about-1.png',
		'items'         => array(
			'Latest technologies',
			'High-Quality Designs',
			'5 Years Warranty',
			'Residential Design',
		),
	);
}

/**
 * Get saved home about section values.
 *
 * @param int $page_id Optional page ID.
 * @return array
 */
function interior_get_home_about_data( $page_id = 0 ) {
	$defaults = interior_get_home_about_defaults();
	$saved    = get_option( 'interior_home_about', array() );

	if ( ( ! is_array( $saved ) || empty( $saved ) ) && $page_id ) {
		$legacy = get_post_meta( $page_id, '_interior_home_about', true );
		if ( is_array( $legacy ) && ! empty( $legacy ) ) {
			$saved = $legacy;
			update_option( 'interior_home_about', $saved );
		}
	}

	$saved = is_array( $saved ) ? $saved : array();
	$data  = wp_parse_args( $saved, $defaults );

	$data['items'] = isset( $saved['items'] ) && is_array( $saved['items'] ) ? $saved['items'] : array();
	for ( $i = 0; $i < 4; $i++ ) {
		$data['items'][ $i ] = isset( $data['items'][ $i ] ) ? $data['items'][ $i ] : $defaults['items'][ $i ];
	}

	return $data;
}

/**
 * Default home feature services section values.
 *
 * @return array
 */
function interior_get_home_features_defaults() {
	return array(
		'subtitle'    => 'WHO We Are',
		'title'       => 'Explore our <span>comprehensive <br> interior design</span> services',
		'description' => 'We specialize in transforming visions into reality. Explore our portfolio of innovative architectural and interior design projects crafted with precision.',
	);
}

/**
 * Get saved home feature services section values.
 *
 * @param int $page_id Optional page ID.
 * @return array
 */
function interior_get_home_features_data( $page_id = 0 ) {
	$defaults = interior_get_home_features_defaults();
	$saved    = get_option( 'interior_home_features', array() );

	if ( ( ! is_array( $saved ) || empty( $saved ) ) && $page_id ) {
		$legacy = get_post_meta( $page_id, '_interior_home_features', true );
		if ( is_array( $legacy ) && ! empty( $legacy ) ) {
			$saved = $legacy;
			update_option( 'interior_home_features', $saved );
		}
	}

	return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
}

/**
 * Default home counter section values.
 *
 * @return array
 */
function interior_get_home_counter_defaults() {
	return array(
		'background_text' => 'antra',
		'image_id'        => 0,
		'image_url'       => get_template_directory_uri() . '/assets/img/images/counter-img-1.png',
		'items'           => array(
			array(
				'number'      => '22',
				'suffix'      => '+',
				'title'       => 'Years experience',
				'description' => 'Improving homes with expert <br> craftsmanship for years',
			),
			array(
				'number'      => '189',
				'suffix'      => '+',
				'title'       => 'Projects completed',
				'description' => 'Improving homes with expert <br> craftsmanship for years',
			),
			array(
				'number'      => '265',
				'suffix'      => '+',
				'title'       => 'Skilled Tradespeople',
				'description' => 'Improving homes with expert <br> craftsmanship for years',
			),
			array(
				'number'      => '328',
				'suffix'      => '+',
				'title'       => 'Client satisfaction',
				'description' => 'Improving homes with expert <br> craftsmanship for years',
			),
		),
	);
}

/**
 * Get saved home counter section values.
 *
 * @param int $page_id Optional page ID.
 * @return array
 */
function interior_get_home_counter_data( $page_id = 0 ) {
	$defaults = interior_get_home_counter_defaults();
	$saved    = get_option( 'interior_home_counter', array() );

	if ( ( ! is_array( $saved ) || empty( $saved ) ) && $page_id ) {
		$legacy = get_post_meta( $page_id, '_interior_home_counter', true );
		if ( is_array( $legacy ) && ! empty( $legacy ) ) {
			$saved = $legacy;
			update_option( 'interior_home_counter', $saved );
		}
	}

	$saved = is_array( $saved ) ? $saved : array();
	$data  = wp_parse_args( $saved, $defaults );

	$data['items'] = isset( $saved['items'] ) && is_array( $saved['items'] ) ? $saved['items'] : array();
	for ( $i = 0; $i < 4; $i++ ) {
		$data['items'][ $i ] = wp_parse_args( isset( $data['items'][ $i ] ) && is_array( $data['items'][ $i ] ) ? $data['items'][ $i ] : array(), $defaults['items'][ $i ] );
	}

	return $data;
}

/**
 * Default home process section values.
 *
 * @return array
 */
function interior_get_home_process_defaults() {
	return array(
		'subtitle'    => 'How We Work',
		'title'       => 'Description <span>Architecture <br> process</span> for exceptional <br> results.',
		'description' => 'Our process is alive - adapting, refining, and growing <br> with your vision. Always. <br> Like artists with a blank canvas, we transform rooms <br> into living works of art.',
		'bottom_text' => "We've been working hard to impress you.",
		'link_text'   => "Start your's today",
		'link_url'    => home_url( '/contact/' ),
		'items'       => array(
			array(
				'title'       => 'Initial Consultation',
				'description' => 'We begin by understanding <br> your vision, goals, and needs, <br> followed Antra.',
				'image_id'    => 0,
				'image_url'   => get_template_directory_uri() . '/assets/img/images/process-img-1.png',
			),
			array(
				'title'       => 'Design & Planning',
				'description' => 'We begin by understanding <br> your vision, goals, and needs, <br> followed Antra.',
				'image_id'    => 0,
				'image_url'   => get_template_directory_uri() . '/assets/img/images/process-img-2.png',
			),
			array(
				'title'       => 'Implementation',
				'description' => 'We begin by understanding <br> your vision, goals, and needs, <br> followed Antra.',
				'image_id'    => 0,
				'image_url'   => get_template_directory_uri() . '/assets/img/images/process-img-3.png',
			),
			array(
				'title'       => 'Project Handover',
				'description' => 'We begin by understanding <br> your vision, goals, and needs, <br> followed Antra.',
				'image_id'    => 0,
				'image_url'   => get_template_directory_uri() . '/assets/img/images/process-img-4.png',
			),
		),
	);
}

/**
 * Get saved home process section values.
 *
 * @param int $page_id Optional page ID.
 * @return array
 */
function interior_get_home_process_data( $page_id = 0 ) {
	$defaults = interior_get_home_process_defaults();
	$saved    = get_option( 'interior_home_process', array() );

	if ( ( ! is_array( $saved ) || empty( $saved ) ) && $page_id ) {
		$legacy = get_post_meta( $page_id, '_interior_home_process', true );
		if ( is_array( $legacy ) && ! empty( $legacy ) ) {
			$saved = $legacy;
			update_option( 'interior_home_process', $saved );
		}
	}

	$saved = is_array( $saved ) ? $saved : array();
	$data  = wp_parse_args( $saved, $defaults );

	$data['items'] = isset( $saved['items'] ) && is_array( $saved['items'] ) ? $saved['items'] : array();
	for ( $i = 0; $i < 4; $i++ ) {
		$data['items'][ $i ] = wp_parse_args( isset( $data['items'][ $i ] ) && is_array( $data['items'][ $i ] ) ? $data['items'][ $i ] : array(), $defaults['items'][ $i ] );
	}

	return $data;
}

/**
 * Default home projects section values.
 *
 * @return array
 */
function interior_get_home_projects_defaults() {
	return array(
		'background_text' => 'Interior',
		'subtitle'        => 'Our Projects',
		'title'           => 'Creative <span>projects that <br> define</span> our style',
		'description'     => 'Our portfolio showcases a diverse range of projects, from beautifully crafted <br> residential spaces functional and stylish commercial interiors',
	);
}

/**
 * Get saved home projects section values.
 *
 * @param int $page_id Optional page ID.
 * @return array
 */
function interior_get_home_projects_data( $page_id = 0 ) {
	$defaults = interior_get_home_projects_defaults();
	$saved    = get_option( 'interior_home_projects', array() );

	if ( ( ! is_array( $saved ) || empty( $saved ) ) && $page_id ) {
		$legacy = get_post_meta( $page_id, '_interior_home_projects', true );
		if ( is_array( $legacy ) && ! empty( $legacy ) ) {
			$saved = $legacy;
			update_option( 'interior_home_projects', $saved );
		}
	}

	return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
}

/**
 * Default home testimonial section values.
 *
 * @return array
 */
function interior_get_home_testimonial_defaults() {
	return array(
		'subtitle'        => 'Owr clients say',
		'title'           => 'Hereâ€™s What <span>warm words <br> our clients</span> say',
		'image_id'        => 0,
		'image_url'       => get_template_directory_uri() . '/assets/img/testi/testi-img-1.png',
		'rating'          => '4.80',
		'reviews'         => '2,688 reviews',
		'intro'           => 'From concept to reality, the team turned my <br> vision into a stunning, livable space. I couldnâ€™t <br> be happier with this!',
		'quote'           => 'â€œA wonderful experience! They knew what they were doing and were incredibly knowledgeable throughout the process."',
		'author_name'     => 'Morgan Dufresne',
		'author_position' => 'Company Owner',
		'author_image_id' => 0,
		'author_image_url' => get_template_directory_uri() . '/assets/img/testi/testi-author-1.png',
	);
}

/**
 * Get saved home testimonial section values.
 *
 * @param int $page_id Optional page ID.
 * @return array
 */
function interior_get_home_testimonial_data( $page_id = 0 ) {
	$defaults = interior_get_home_testimonial_defaults();
	$saved    = get_option( 'interior_home_testimonial', array() );

	if ( ( ! is_array( $saved ) || empty( $saved ) ) && $page_id ) {
		$legacy = get_post_meta( $page_id, '_interior_home_testimonial', true );
		if ( is_array( $legacy ) && ! empty( $legacy ) ) {
			$saved = $legacy;
			update_option( 'interior_home_testimonial', $saved );
		}
	}

	return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
}

/**
 * Default home sponsors section values.
 *
 * @return array
 */
function interior_get_home_sponsors_defaults() {
	$defaults = array(
		'heading_before' => 'Our Website',
		'heading_number' => '75000',
		'heading_after'  => '+ VIP Customer',
		'items'          => array(),
	);

	for ( $i = 1; $i <= 6; $i++ ) {
		$defaults['items'][] = array(
			'image_id'  => 0,
			'image_url' => get_template_directory_uri() . '/assets/img/sponsor/sponsor-' . $i . '.png',
			'link_url'  => '#',
		);
	}

	return $defaults;
}

/**
 * Get saved home sponsors section values.
 *
 * @param int $page_id Optional page ID.
 * @return array
 */
function interior_get_home_sponsors_data( $page_id = 0 ) {
	$defaults = interior_get_home_sponsors_defaults();
	$saved    = get_option( 'interior_home_sponsors', array() );

	if ( ( ! is_array( $saved ) || empty( $saved ) ) && $page_id ) {
		$legacy = get_post_meta( $page_id, '_interior_home_sponsors', true );
		if ( is_array( $legacy ) && ! empty( $legacy ) ) {
			$saved = $legacy;
			update_option( 'interior_home_sponsors', $saved );
		}
	}

	$saved = is_array( $saved ) ? $saved : array();
	$data  = wp_parse_args( $saved, $defaults );

	$data['items'] = isset( $saved['items'] ) && is_array( $saved['items'] ) ? $saved['items'] : array();
	for ( $i = 0; $i < 6; $i++ ) {
		$data['items'][ $i ] = wp_parse_args( isset( $data['items'][ $i ] ) && is_array( $data['items'][ $i ] ) ? $data['items'][ $i ] : array(), $defaults['items'][ $i ] );
	}

	return $data;
}

/**
 * Default home video section values.
 *
 * @return array
 */
function interior_get_home_video_defaults() {
	return array(
		'subtitle' => '360-degree panoramas',
		'title'    => 'Create an even <span>greater <br>experience</span>',
		'items'    => array(
			array(
				'image_id'  => 0,
				'image_url' => get_template_directory_uri() . '/assets/img/bg-img/video-bg-1.png',
			),
			array(
				'image_id'  => 0,
				'image_url' => get_template_directory_uri() . '/assets/img/bg-img/video-bg-2.png',
			),
		),
	);
}

/**
 * Get saved home video section values.
 *
 * @param int $page_id Optional page ID.
 * @return array
 */
function interior_get_home_video_data( $page_id = 0 ) {
	$defaults = interior_get_home_video_defaults();
	$saved    = get_option( 'interior_home_video', array() );

	if ( ( ! is_array( $saved ) || empty( $saved ) ) && $page_id ) {
		$legacy = get_post_meta( $page_id, '_interior_home_video', true );
		if ( is_array( $legacy ) && ! empty( $legacy ) ) {
			$saved = $legacy;
			update_option( 'interior_home_video', $saved );
		}
	}

	$saved = is_array( $saved ) ? $saved : array();
	$data  = wp_parse_args( $saved, $defaults );

	$data['items'] = isset( $saved['items'] ) && is_array( $saved['items'] ) ? $saved['items'] : array();
	for ( $i = 0; $i < 2; $i++ ) {
		$data['items'][ $i ] = wp_parse_args( isset( $data['items'][ $i ] ) && is_array( $data['items'][ $i ] ) ? $data['items'][ $i ] : array(), $defaults['items'][ $i ] );
	}

	return $data;
}

/**
 * Determine if the current page edit screen is the home/front-page template.
 *
 * @param WP_Post|null $post Page post.
 * @return bool
 */
function interior_is_home_editor_page( $post ) {
	if ( ! $post || 'page' !== $post->post_type ) {
		return false;
	}

	$template      = get_page_template_slug( $post->ID );
	$front_page_id = (int) get_option( 'page_on_front' );

	return $post->ID === $front_page_id || in_array( $template, array( 'page-front.php', 'front-page.php' ), true ) || 'home' === $post->post_name;
}

/**
 * Register Home Page Sections metabox.
 */
function interior_register_home_metabox() {
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
	$post    = $post_id ? get_post( $post_id ) : null;

	if ( interior_is_home_editor_page( $post ) ) {
		add_meta_box(
			'interior_home_sections',
			esc_html__( 'Home Page Sections', 'interior' ),
			'interior_render_home_metabox',
			'page',
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'interior_register_home_metabox' );

/**
 * Render Home Page Sections metabox with tabs.
 *
 * @param WP_Post $post Current page.
 */
function interior_render_home_metabox( $post ) {
	$sections = get_post_meta( $post->ID, '_interior_home_sections', true );
	$sections = is_array( $sections ) ? $sections : array();
	$tabs     = interior_get_home_section_tabs();
	$first    = true;
	$slider   = interior_get_home_slider_data( $post->ID );

	wp_nonce_field( 'interior_home_sections_nonce', 'interior_home_sections_nonce_field' );
	?>
	<style>
		.interior-home-tabs-nav { display:flex; flex-wrap:wrap; border-bottom:2px solid #ddd; margin:16px 0 20px; }
		.interior-home-tab-btn { background:#fff; border:0; border-bottom:3px solid transparent; color:#555; cursor:pointer; font-weight:600; padding:10px 14px; }
		.interior-home-tab-btn.active { border-bottom-color:#2271b1; color:#1d2327; }
		.interior-home-tab-content { display:none; }
		.interior-home-tab-content.active { display:block; }
		.interior-home-tab-content .description { margin:0 0 12px; }
	</style>
	<div class="interior-home-tabs">
		<div class="interior-home-tabs-nav">
			<?php foreach ( $tabs as $key => $label ) : ?>
				<button type="button" class="interior-home-tab-btn <?php echo $first ? 'active' : ''; ?>" data-tab="interior-home-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></button>
				<?php $first = false; ?>
			<?php endforeach; ?>
		</div>
		<?php
		$first = true;
		foreach ( $tabs as $key => $label ) :
			$value = isset( $sections[ $key ] ) ? $sections[ $key ] : '';
			?>
			<div id="interior-home-<?php echo esc_attr( $key ); ?>" class="interior-home-tab-content <?php echo $first ? 'active' : ''; ?>">
				<?php if ( 'slider' === $key ) : ?>
					<p class="description"><?php esc_html_e( 'Edit the static homepage slider content here.', 'interior' ); ?></p>
					<?php for ( $i = 1; $i <= 2; $i++ ) : ?>
						<?php
						$bg_id       = (int) $slider[ 'slide_' . $i . '_bg_image_id' ];
						$thumb_id    = (int) $slider[ 'slide_' . $i . '_thumb_image_id' ];
						$bg_url      = $bg_id ? wp_get_attachment_image_url( $bg_id, 'medium' ) : '';
						$thumb_url   = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium' ) : '';
						$field_base  = 'slide_' . $i . '_';
						?>
						<h3><?php echo esc_html( sprintf( 'Slide %d', $i ) ); ?></h3>
						<table class="form-table" role="presentation">
							<tr>
								<th scope="row"><?php esc_html_e( 'Background Image', 'interior' ); ?></th>
								<td>
									<input type="hidden" id="interior_slider_<?php echo esc_attr( $i ); ?>_bg_image_id" name="interior_home_slider[<?php echo esc_attr( $field_base ); ?>bg_image_id]" value="<?php echo esc_attr( $bg_id ); ?>">
									<img id="interior_slider_<?php echo esc_attr( $i ); ?>_bg_preview" src="<?php echo esc_url( $bg_url ); ?>" alt="" style="<?php echo $bg_url ? '' : 'display:none;'; ?>max-width:220px;height:auto;margin:0 0 10px;">
									<br>
									<button type="button" class="button interior-slider-upload" data-target="#interior_slider_<?php echo esc_attr( $i ); ?>_bg_image_id" data-preview="#interior_slider_<?php echo esc_attr( $i ); ?>_bg_preview"><?php esc_html_e( 'Select Image', 'interior' ); ?></button>
									<button type="button" class="button interior-slider-remove" data-target="#interior_slider_<?php echo esc_attr( $i ); ?>_bg_image_id" data-preview="#interior_slider_<?php echo esc_attr( $i ); ?>_bg_preview"><?php esc_html_e( 'Remove Image', 'interior' ); ?></button>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th>
								<td><input type="text" class="large-text" name="interior_home_slider[<?php echo esc_attr( $field_base ); ?>subtitle]" value="<?php echo esc_attr( $slider[ $field_base . 'subtitle' ] ); ?>"></td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th>
								<td><textarea class="large-text" rows="2" name="interior_home_slider[<?php echo esc_attr( $field_base ); ?>title]"><?php echo esc_textarea( $slider[ $field_base . 'title' ] ); ?></textarea></td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th>
								<td><textarea class="large-text" rows="3" name="interior_home_slider[<?php echo esc_attr( $field_base ); ?>description]"><?php echo esc_textarea( $slider[ $field_base . 'description' ] ); ?></textarea></td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Button Text / URL', 'interior' ); ?></th>
								<td>
									<input type="text" name="interior_home_slider[<?php echo esc_attr( $field_base ); ?>button_text]" value="<?php echo esc_attr( $slider[ $field_base . 'button_text' ] ); ?>" placeholder="Button text">
									<input type="text" class="regular-text" name="interior_home_slider[<?php echo esc_attr( $field_base ); ?>button_url]" value="<?php echo esc_attr( $slider[ $field_base . 'button_url' ] ); ?>" placeholder="Button URL">
								</td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Stat Box', 'interior' ); ?></th>
								<td>
									<input type="text" name="interior_home_slider[<?php echo esc_attr( $field_base ); ?>stat_number]" value="<?php echo esc_attr( $slider[ $field_base . 'stat_number' ] ); ?>" placeholder="260+">
									<textarea class="large-text" rows="2" name="interior_home_slider[<?php echo esc_attr( $field_base ); ?>stat_label]" placeholder="Stat label"><?php echo esc_textarea( $slider[ $field_base . 'stat_label' ] ); ?></textarea>
									<textarea class="large-text" rows="2" name="interior_home_slider[<?php echo esc_attr( $field_base ); ?>stat_desc]" placeholder="Stat description"><?php echo esc_textarea( $slider[ $field_base . 'stat_desc' ] ); ?></textarea>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Thumb Image', 'interior' ); ?></th>
								<td>
									<input type="hidden" id="interior_slider_<?php echo esc_attr( $i ); ?>_thumb_image_id" name="interior_home_slider[<?php echo esc_attr( $field_base ); ?>thumb_image_id]" value="<?php echo esc_attr( $thumb_id ); ?>">
									<img id="interior_slider_<?php echo esc_attr( $i ); ?>_thumb_preview" src="<?php echo esc_url( $thumb_url ); ?>" alt="" style="<?php echo $thumb_url ? '' : 'display:none;'; ?>max-width:220px;height:auto;margin:0 0 10px;">
									<br>
									<button type="button" class="button interior-slider-upload" data-target="#interior_slider_<?php echo esc_attr( $i ); ?>_thumb_image_id" data-preview="#interior_slider_<?php echo esc_attr( $i ); ?>_thumb_preview"><?php esc_html_e( 'Select Image', 'interior' ); ?></button>
									<button type="button" class="button interior-slider-remove" data-target="#interior_slider_<?php echo esc_attr( $i ); ?>_thumb_image_id" data-preview="#interior_slider_<?php echo esc_attr( $i ); ?>_thumb_preview"><?php esc_html_e( 'Remove Image', 'interior' ); ?></button>
								</td>
							</tr>
						</table>
					<?php endfor; ?>
				<?php elseif ( 'services' === $key ) : ?>
					<?php $services = interior_get_home_services_data( $post->ID ); ?>
					<p class="description"><?php esc_html_e( 'Edit the homepage service section content here.', 'interior' ); ?></p>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th>
							<td><input type="text" class="large-text" name="interior_home_services[subtitle]" value="<?php echo esc_attr( $services['subtitle'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="2" name="interior_home_services[title]"><?php echo esc_textarea( $services['title'] ); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="3" name="interior_home_services[description]"><?php echo esc_textarea( $services['description'] ); ?></textarea></td>
						</tr>
					</table>
					<?php for ( $i = 0; $i < 4; $i++ ) : ?>
						<?php
						$item       = $services['items'][ $i ];
						$icon_id    = (int) $item['icon_id'];
						$icon_url   = $icon_id ? wp_get_attachment_image_url( $icon_id, 'thumbnail' ) : $item['icon_url'];
						$field_base = 'interior_service_' . ( $i + 1 ) . '_';
						?>
						<h3><?php echo esc_html( sprintf( 'Service Card %d', $i + 1 ) ); ?></h3>
						<table class="form-table" role="presentation">
							<tr>
								<th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th>
								<td><textarea class="large-text" rows="2" name="interior_home_services[items][<?php echo esc_attr( $i ); ?>][title]"><?php echo esc_textarea( $item['title'] ); ?></textarea></td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th>
								<td><textarea class="large-text" rows="3" name="interior_home_services[items][<?php echo esc_attr( $i ); ?>][description]"><?php echo esc_textarea( $item['description'] ); ?></textarea></td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Link URL', 'interior' ); ?></th>
								<td><input type="text" class="large-text" name="interior_home_services[items][<?php echo esc_attr( $i ); ?>][url]" value="<?php echo esc_attr( $item['url'] ); ?>"></td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Icon', 'interior' ); ?></th>
								<td>
									<input type="hidden" id="<?php echo esc_attr( $field_base ); ?>icon_id" name="interior_home_services[items][<?php echo esc_attr( $i ); ?>][icon_id]" value="<?php echo esc_attr( $icon_id ); ?>">
									<img id="<?php echo esc_attr( $field_base ); ?>icon_preview" src="<?php echo esc_url( $icon_url ); ?>" alt="" style="<?php echo $icon_url ? '' : 'display:none;'; ?>max-width:80px;height:auto;margin:0 0 10px;">
									<br>
									<button type="button" class="button interior-slider-upload" data-target="#<?php echo esc_attr( $field_base ); ?>icon_id" data-preview="#<?php echo esc_attr( $field_base ); ?>icon_preview"><?php esc_html_e( 'Select Icon', 'interior' ); ?></button>
									<button type="button" class="button interior-slider-remove" data-target="#<?php echo esc_attr( $field_base ); ?>icon_id" data-preview="#<?php echo esc_attr( $field_base ); ?>icon_preview"><?php esc_html_e( 'Remove Icon', 'interior' ); ?></button>
								</td>
							</tr>
						</table>
					<?php endfor; ?>
				<?php elseif ( 'about' === $key ) : ?>
					<?php
					$about     = interior_get_home_about_data( $post->ID );
					$image_id  = (int) $about['image_id'];
					$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : $about['image_url'];
					?>
					<p class="description"><?php esc_html_e( 'Edit the homepage about section content here.', 'interior' ); ?></p>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th>
							<td><input type="text" class="large-text" name="interior_home_about[subtitle]" value="<?php echo esc_attr( $about['subtitle'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="2" name="interior_home_about[title]"><?php echo esc_textarea( $about['title'] ); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Bullet Items', 'interior' ); ?></th>
							<td>
								<?php for ( $i = 0; $i < 4; $i++ ) : ?>
									<input type="text" class="large-text" name="interior_home_about[items][<?php echo esc_attr( $i ); ?>]" value="<?php echo esc_attr( $about['items'][ $i ] ); ?>" style="margin-bottom:8px;">
								<?php endfor; ?>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="3" name="interior_home_about[description]"><?php echo esc_textarea( $about['description'] ); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Button Text / URL', 'interior' ); ?></th>
							<td>
								<input type="text" name="interior_home_about[button_text]" value="<?php echo esc_attr( $about['button_text'] ); ?>" placeholder="Button text">
								<input type="text" class="regular-text" name="interior_home_about[button_url]" value="<?php echo esc_attr( $about['button_url'] ); ?>" placeholder="Button URL">
							</td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Background Text', 'interior' ); ?></th>
							<td><input type="text" class="regular-text" name="interior_home_about[background_text]" value="<?php echo esc_attr( $about['background_text'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Image', 'interior' ); ?></th>
							<td>
								<input type="hidden" id="interior_about_image_id" name="interior_home_about[image_id]" value="<?php echo esc_attr( $image_id ); ?>">
								<img id="interior_about_image_preview" src="<?php echo esc_url( $image_url ); ?>" alt="" style="<?php echo $image_url ? '' : 'display:none;'; ?>max-width:220px;height:auto;margin:0 0 10px;">
								<br>
								<button type="button" class="button interior-slider-upload" data-target="#interior_about_image_id" data-preview="#interior_about_image_preview"><?php esc_html_e( 'Select Image', 'interior' ); ?></button>
								<button type="button" class="button interior-slider-remove" data-target="#interior_about_image_id" data-preview="#interior_about_image_preview"><?php esc_html_e( 'Remove Image', 'interior' ); ?></button>
							</td>
						</tr>
					</table>
				<?php elseif ( 'features' === $key ) : ?>
					<?php $features = interior_get_home_features_data( $post->ID ); ?>
					<p class="description"><?php esc_html_e( 'Edit the homepage feature services heading here. The service list is pulled automatically from the latest 5 Services.', 'interior' ); ?></p>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th>
							<td><input type="text" class="large-text" name="interior_home_features[subtitle]" value="<?php echo esc_attr( $features['subtitle'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="2" name="interior_home_features[title]"><?php echo esc_textarea( $features['title'] ); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="3" name="interior_home_features[description]"><?php echo esc_textarea( $features['description'] ); ?></textarea></td>
						</tr>
					</table>
				<?php elseif ( 'counter' === $key ) : ?>
					<?php
					$counter     = interior_get_home_counter_data( $post->ID );
					$image_id    = (int) $counter['image_id'];
					$image_url   = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : $counter['image_url'];
					?>
					<p class="description"><?php esc_html_e( 'Edit the homepage counter section content here.', 'interior' ); ?></p>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><?php esc_html_e( 'Background Text', 'interior' ); ?></th>
							<td><input type="text" class="regular-text" name="interior_home_counter[background_text]" value="<?php echo esc_attr( $counter['background_text'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Image', 'interior' ); ?></th>
							<td>
								<input type="hidden" id="interior_counter_image_id" name="interior_home_counter[image_id]" value="<?php echo esc_attr( $image_id ); ?>">
								<img id="interior_counter_image_preview" src="<?php echo esc_url( $image_url ); ?>" alt="" style="<?php echo $image_url ? '' : 'display:none;'; ?>max-width:220px;height:auto;margin:0 0 10px;">
								<br>
								<button type="button" class="button interior-slider-upload" data-target="#interior_counter_image_id" data-preview="#interior_counter_image_preview"><?php esc_html_e( 'Select Image', 'interior' ); ?></button>
								<button type="button" class="button interior-slider-remove" data-target="#interior_counter_image_id" data-preview="#interior_counter_image_preview"><?php esc_html_e( 'Remove Image', 'interior' ); ?></button>
							</td>
						</tr>
					</table>
					<?php for ( $i = 0; $i < 4; $i++ ) : ?>
						<?php $item = $counter['items'][ $i ]; ?>
						<h3><?php echo esc_html( sprintf( 'Counter Item %d', $i + 1 ) ); ?></h3>
						<table class="form-table" role="presentation">
							<tr>
								<th scope="row"><?php esc_html_e( 'Number / Suffix', 'interior' ); ?></th>
								<td>
									<input type="text" name="interior_home_counter[items][<?php echo esc_attr( $i ); ?>][number]" value="<?php echo esc_attr( $item['number'] ); ?>" placeholder="22">
									<input type="text" name="interior_home_counter[items][<?php echo esc_attr( $i ); ?>][suffix]" value="<?php echo esc_attr( $item['suffix'] ); ?>" placeholder="+">
								</td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th>
								<td><input type="text" class="large-text" name="interior_home_counter[items][<?php echo esc_attr( $i ); ?>][title]" value="<?php echo esc_attr( $item['title'] ); ?>"></td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th>
								<td><textarea class="large-text" rows="2" name="interior_home_counter[items][<?php echo esc_attr( $i ); ?>][description]"><?php echo esc_textarea( $item['description'] ); ?></textarea></td>
							</tr>
						</table>
					<?php endfor; ?>
				<?php elseif ( 'process' === $key ) : ?>
					<?php $process = interior_get_home_process_data( $post->ID ); ?>
					<p class="description"><?php esc_html_e( 'Edit the homepage process section content here.', 'interior' ); ?></p>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th>
							<td><input type="text" class="large-text" name="interior_home_process[subtitle]" value="<?php echo esc_attr( $process['subtitle'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="2" name="interior_home_process[title]"><?php echo esc_textarea( $process['title'] ); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="3" name="interior_home_process[description]"><?php echo esc_textarea( $process['description'] ); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Bottom Text / Link', 'interior' ); ?></th>
							<td>
								<input type="text" class="regular-text" name="interior_home_process[bottom_text]" value="<?php echo esc_attr( $process['bottom_text'] ); ?>" placeholder="Bottom text">
								<input type="text" name="interior_home_process[link_text]" value="<?php echo esc_attr( $process['link_text'] ); ?>" placeholder="Link text">
								<input type="text" class="regular-text" name="interior_home_process[link_url]" value="<?php echo esc_attr( $process['link_url'] ); ?>" placeholder="Link URL">
							</td>
						</tr>
					</table>
					<?php for ( $i = 0; $i < 4; $i++ ) : ?>
						<?php
						$item       = $process['items'][ $i ];
						$image_id   = (int) $item['image_id'];
						$image_url  = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : $item['image_url'];
						$field_base = 'interior_process_' . ( $i + 1 ) . '_';
						?>
						<h3><?php echo esc_html( sprintf( 'Process Step %d', $i + 1 ) ); ?></h3>
						<table class="form-table" role="presentation">
							<tr>
								<th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th>
								<td><input type="text" class="large-text" name="interior_home_process[items][<?php echo esc_attr( $i ); ?>][title]" value="<?php echo esc_attr( $item['title'] ); ?>"></td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th>
								<td><textarea class="large-text" rows="3" name="interior_home_process[items][<?php echo esc_attr( $i ); ?>][description]"><?php echo esc_textarea( $item['description'] ); ?></textarea></td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Image', 'interior' ); ?></th>
								<td>
									<input type="hidden" id="<?php echo esc_attr( $field_base ); ?>image_id" name="interior_home_process[items][<?php echo esc_attr( $i ); ?>][image_id]" value="<?php echo esc_attr( $image_id ); ?>">
									<img id="<?php echo esc_attr( $field_base ); ?>image_preview" src="<?php echo esc_url( $image_url ); ?>" alt="" style="<?php echo $image_url ? '' : 'display:none;'; ?>max-width:220px;height:auto;margin:0 0 10px;">
									<br>
									<button type="button" class="button interior-slider-upload" data-target="#<?php echo esc_attr( $field_base ); ?>image_id" data-preview="#<?php echo esc_attr( $field_base ); ?>image_preview"><?php esc_html_e( 'Select Image', 'interior' ); ?></button>
									<button type="button" class="button interior-slider-remove" data-target="#<?php echo esc_attr( $field_base ); ?>image_id" data-preview="#<?php echo esc_attr( $field_base ); ?>image_preview"><?php esc_html_e( 'Remove Image', 'interior' ); ?></button>
								</td>
							</tr>
						</table>
					<?php endfor; ?>
				<?php elseif ( 'projects' === $key ) : ?>
					<?php $projects = interior_get_home_projects_data( $post->ID ); ?>
					<p class="description"><?php esc_html_e( 'Edit the homepage projects heading here. The project cards are pulled automatically from the latest 3 Projects.', 'interior' ); ?></p>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><?php esc_html_e( 'Background Text', 'interior' ); ?></th>
							<td><input type="text" class="regular-text" name="interior_home_projects[background_text]" value="<?php echo esc_attr( $projects['background_text'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th>
							<td><input type="text" class="large-text" name="interior_home_projects[subtitle]" value="<?php echo esc_attr( $projects['subtitle'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="2" name="interior_home_projects[title]"><?php echo esc_textarea( $projects['title'] ); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="3" name="interior_home_projects[description]"><?php echo esc_textarea( $projects['description'] ); ?></textarea></td>
						</tr>
					</table>
				<?php elseif ( 'testimonial' === $key ) : ?>
					<?php
					$testimonial      = interior_get_home_testimonial_data( $post->ID );
					$image_id         = (int) $testimonial['image_id'];
					$image_url        = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : $testimonial['image_url'];
					$author_image_id  = (int) $testimonial['author_image_id'];
					$author_image_url = $author_image_id ? wp_get_attachment_image_url( $author_image_id, 'thumbnail' ) : $testimonial['author_image_url'];
					?>
					<p class="description"><?php esc_html_e( 'Edit the homepage testimonial section content here.', 'interior' ); ?></p>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th>
							<td><input type="text" class="large-text" name="interior_home_testimonial[subtitle]" value="<?php echo esc_attr( $testimonial['subtitle'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="2" name="interior_home_testimonial[title]"><?php echo esc_textarea( $testimonial['title'] ); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Main Image', 'interior' ); ?></th>
							<td>
								<input type="hidden" id="interior_testimonial_image_id" name="interior_home_testimonial[image_id]" value="<?php echo esc_attr( $image_id ); ?>">
								<img id="interior_testimonial_image_preview" src="<?php echo esc_url( $image_url ); ?>" alt="" style="<?php echo $image_url ? '' : 'display:none;'; ?>max-width:220px;height:auto;margin:0 0 10px;">
								<br>
								<button type="button" class="button interior-slider-upload" data-target="#interior_testimonial_image_id" data-preview="#interior_testimonial_image_preview"><?php esc_html_e( 'Select Image', 'interior' ); ?></button>
								<button type="button" class="button interior-slider-remove" data-target="#interior_testimonial_image_id" data-preview="#interior_testimonial_image_preview"><?php esc_html_e( 'Remove Image', 'interior' ); ?></button>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Rating / Reviews', 'interior' ); ?></th>
							<td>
								<input type="text" name="interior_home_testimonial[rating]" value="<?php echo esc_attr( $testimonial['rating'] ); ?>" placeholder="4.80">
								<input type="text" class="regular-text" name="interior_home_testimonial[reviews]" value="<?php echo esc_attr( $testimonial['reviews'] ); ?>" placeholder="2,688 reviews">
							</td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Intro Text', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="3" name="interior_home_testimonial[intro]"><?php echo esc_textarea( $testimonial['intro'] ); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Quote', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="3" name="interior_home_testimonial[quote]"><?php echo esc_textarea( $testimonial['quote'] ); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Author', 'interior' ); ?></th>
							<td>
								<input type="text" class="regular-text" name="interior_home_testimonial[author_name]" value="<?php echo esc_attr( $testimonial['author_name'] ); ?>" placeholder="Name">
								<input type="text" class="regular-text" name="interior_home_testimonial[author_position]" value="<?php echo esc_attr( $testimonial['author_position'] ); ?>" placeholder="Position">
							</td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Author Image', 'interior' ); ?></th>
							<td>
								<input type="hidden" id="interior_testimonial_author_image_id" name="interior_home_testimonial[author_image_id]" value="<?php echo esc_attr( $author_image_id ); ?>">
								<img id="interior_testimonial_author_image_preview" src="<?php echo esc_url( $author_image_url ); ?>" alt="" style="<?php echo $author_image_url ? '' : 'display:none;'; ?>max-width:100px;height:auto;margin:0 0 10px;">
								<br>
								<button type="button" class="button interior-slider-upload" data-target="#interior_testimonial_author_image_id" data-preview="#interior_testimonial_author_image_preview"><?php esc_html_e( 'Select Image', 'interior' ); ?></button>
								<button type="button" class="button interior-slider-remove" data-target="#interior_testimonial_author_image_id" data-preview="#interior_testimonial_author_image_preview"><?php esc_html_e( 'Remove Image', 'interior' ); ?></button>
							</td>
						</tr>
					</table>
				<?php elseif ( 'sponsors' === $key ) : ?>
					<?php $sponsors = interior_get_home_sponsors_data( $post->ID ); ?>
					<p class="description"><?php esc_html_e( 'Edit the homepage sponsor section content here.', 'interior' ); ?></p>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><?php esc_html_e( 'Heading', 'interior' ); ?></th>
							<td>
								<input type="text" class="regular-text" name="interior_home_sponsors[heading_before]" value="<?php echo esc_attr( $sponsors['heading_before'] ); ?>" placeholder="Our Website">
								<input type="text" name="interior_home_sponsors[heading_number]" value="<?php echo esc_attr( $sponsors['heading_number'] ); ?>" placeholder="75000">
								<input type="text" class="regular-text" name="interior_home_sponsors[heading_after]" value="<?php echo esc_attr( $sponsors['heading_after'] ); ?>" placeholder="+ VIP Customer">
							</td>
						</tr>
					</table>
					<?php for ( $i = 0; $i < 6; $i++ ) : ?>
						<?php
						$item       = $sponsors['items'][ $i ];
						$image_id   = (int) $item['image_id'];
						$image_url  = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : $item['image_url'];
						$field_base = 'interior_sponsor_' . ( $i + 1 ) . '_';
						?>
						<h3><?php echo esc_html( sprintf( 'Sponsor Logo %d', $i + 1 ) ); ?></h3>
						<table class="form-table" role="presentation">
							<tr>
								<th scope="row"><?php esc_html_e( 'Logo', 'interior' ); ?></th>
								<td>
									<input type="hidden" id="<?php echo esc_attr( $field_base ); ?>image_id" name="interior_home_sponsors[items][<?php echo esc_attr( $i ); ?>][image_id]" value="<?php echo esc_attr( $image_id ); ?>">
									<img id="<?php echo esc_attr( $field_base ); ?>image_preview" src="<?php echo esc_url( $image_url ); ?>" alt="" style="<?php echo $image_url ? '' : 'display:none;'; ?>max-width:160px;height:auto;margin:0 0 10px;">
									<br>
									<button type="button" class="button interior-slider-upload" data-target="#<?php echo esc_attr( $field_base ); ?>image_id" data-preview="#<?php echo esc_attr( $field_base ); ?>image_preview"><?php esc_html_e( 'Select Logo', 'interior' ); ?></button>
									<button type="button" class="button interior-slider-remove" data-target="#<?php echo esc_attr( $field_base ); ?>image_id" data-preview="#<?php echo esc_attr( $field_base ); ?>image_preview"><?php esc_html_e( 'Remove Logo', 'interior' ); ?></button>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php esc_html_e( 'Link URL', 'interior' ); ?></th>
								<td><input type="text" class="large-text" name="interior_home_sponsors[items][<?php echo esc_attr( $i ); ?>][link_url]" value="<?php echo esc_attr( $item['link_url'] ); ?>"></td>
							</tr>
						</table>
					<?php endfor; ?>
				<?php elseif ( 'video' === $key ) : ?>
					<?php $video = interior_get_home_video_data( $post->ID ); ?>
					<p class="description"><?php esc_html_e( 'Edit the homepage video section content shown below the testimonial section.', 'interior' ); ?></p>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th>
							<td><input type="text" class="large-text" name="interior_home_video[subtitle]" value="<?php echo esc_attr( $video['subtitle'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="2" name="interior_home_video[title]"><?php echo esc_textarea( $video['title'] ); ?></textarea></td>
						</tr>
					</table>
					<?php for ( $i = 0; $i < 2; $i++ ) : ?>
						<?php
						$item       = $video['items'][ $i ];
						$image_id   = (int) $item['image_id'];
						$image_url  = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : $item['image_url'];
						$field_base = 'interior_video_' . ( $i + 1 ) . '_';
						?>
						<h3><?php echo esc_html( sprintf( 'Image %d', $i + 1 ) ); ?></h3>
						<table class="form-table" role="presentation">
							<tr>
								<th scope="row"><?php esc_html_e( 'Image', 'interior' ); ?></th>
								<td>
									<input type="hidden" id="<?php echo esc_attr( $field_base ); ?>image_id" name="interior_home_video[items][<?php echo esc_attr( $i ); ?>][image_id]" value="<?php echo esc_attr( $image_id ); ?>">
									<img id="<?php echo esc_attr( $field_base ); ?>image_preview" src="<?php echo esc_url( $image_url ); ?>" alt="" style="<?php echo $image_url ? '' : 'display:none;'; ?>max-width:220px;height:auto;margin:0 0 10px;">
									<br>
									<button type="button" class="button interior-slider-upload" data-target="#<?php echo esc_attr( $field_base ); ?>image_id" data-preview="#<?php echo esc_attr( $field_base ); ?>image_preview"><?php esc_html_e( 'Select Image', 'interior' ); ?></button>
									<button type="button" class="button interior-slider-remove" data-target="#<?php echo esc_attr( $field_base ); ?>image_id" data-preview="#<?php echo esc_attr( $field_base ); ?>image_preview"><?php esc_html_e( 'Remove Image', 'interior' ); ?></button>
								</td>
							</tr>
						</table>
					<?php endfor; ?>
				<?php else : ?>
					<p class="description"><?php echo esc_html( sprintf( 'Override the %s section HTML. Leave empty to use the default design from front-page.php.', $label ) ); ?></p>
					<?php
					wp_editor(
						$value,
						'interior_home_' . $key,
						array(
							'textarea_name' => 'interior_home_sections[' . $key . ']',
							'textarea_rows' => 16,
							'media_buttons' => true,
							'teeny'         => false,
						)
					);
					?>
				<?php endif; ?>
			</div>
			<?php
			$first = false;
		endforeach;
		?>
	</div>
	<script>
		(function() {
			const buttons = document.querySelectorAll('.interior-home-tab-btn');
			const contents = document.querySelectorAll('.interior-home-tab-content');
			buttons.forEach(function(button) {
				button.addEventListener('click', function(e) {
					e.preventDefault();
					const tab = this.getAttribute('data-tab');
					buttons.forEach(function(item) { item.classList.remove('active'); });
					contents.forEach(function(item) { item.classList.remove('active'); });
					this.classList.add('active');
					document.getElementById(tab).classList.add('active');
				});
			});
		})();
		(function($) {
			$('.interior-slider-upload').on('click', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				var preview = $(this).data('preview');
				var frame = wp.media({ title: 'Select Image', button: { text: 'Use Image' }, multiple: false });
				frame.on('select', function() {
					var attachment = frame.state().get('selection').first().toJSON();
					$(target).val(attachment.id);
					$(preview).attr('src', attachment.url).show();
				});
				frame.open();
			});
			$('.interior-slider-remove').on('click', function(e) {
				e.preventDefault();
				$($(this).data('target')).val('');
				$($(this).data('preview')).attr('src', '').hide();
			});
		})(jQuery);
	</script>
	<?php
}

/**
 * Save Home Page Sections metabox.
 *
 * @param int $post_id Post ID.
 */
function interior_save_home_metabox( $post_id ) {
	if ( ! isset( $_POST['interior_home_sections_nonce_field'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['interior_home_sections_nonce_field'] ) ), 'interior_home_sections_nonce' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );
	if ( ! interior_is_home_editor_page( $post ) ) {
		return;
	}

	$saved = array();
	$raw   = isset( $_POST['interior_home_sections'] ) && is_array( $_POST['interior_home_sections'] ) ? wp_unslash( $_POST['interior_home_sections'] ) : array();

	foreach ( interior_get_home_section_tabs() as $key => $label ) {
		if ( in_array( $key, array( 'slider', 'services', 'about', 'features', 'counter', 'process', 'projects', 'testimonial', 'sponsors', 'video' ), true ) ) {
			continue;
		}
		$saved[ $key ] = isset( $raw[ $key ] ) ? wp_kses_post( $raw[ $key ] ) : '';
	}

	update_post_meta( $post_id, '_interior_home_sections', $saved );

	if ( isset( $_POST['interior_home_slider'] ) && is_array( $_POST['interior_home_slider'] ) ) {
		$slider_raw = wp_unslash( $_POST['interior_home_slider'] );
		$slider     = array();

		foreach ( interior_get_home_slider_defaults() as $key => $default ) {
			if ( ! isset( $slider_raw[ $key ] ) ) {
				// Preserve any existing value when a field is missing from the form.
				$existing       = get_option( 'interior_home_slider', array() );
				$slider[ $key ] = isset( $existing[ $key ] ) ? $existing[ $key ] : $default;
				continue;
			}

			if ( false !== strpos( $key, '_image_id' ) ) {
				$slider[ $key ] = absint( $slider_raw[ $key ] );
			} elseif ( false !== strpos( $key, '_url' ) ) {
				$slider[ $key ] = esc_url_raw( $slider_raw[ $key ] );
			} elseif ( in_array( $key, array( 'slide_1_title', 'slide_2_title', 'slide_1_description', 'slide_2_description', 'slide_1_stat_label', 'slide_2_stat_label', 'slide_1_stat_desc', 'slide_2_stat_desc' ), true ) ) {
				$slider[ $key ] = wp_kses_post( $slider_raw[ $key ] );
			} else {
				$slider[ $key ] = sanitize_text_field( $slider_raw[ $key ] );
			}
		}

		// Store as a site-wide option so the slider always reflects on the front-end
		// regardless of which page ID is queried for the home/front page.
		update_option( 'interior_home_slider', $slider );

		// Also keep the post meta in sync for backwards compatibility.
		update_post_meta( $post_id, '_interior_home_slider', $slider );
	}

	if ( isset( $_POST['interior_home_services'] ) && is_array( $_POST['interior_home_services'] ) ) {
		$services_raw = wp_unslash( $_POST['interior_home_services'] );
		$defaults     = interior_get_home_services_defaults();
		$services     = array(
			'subtitle'    => isset( $services_raw['subtitle'] ) ? sanitize_text_field( $services_raw['subtitle'] ) : $defaults['subtitle'],
			'title'       => isset( $services_raw['title'] ) ? wp_kses_post( $services_raw['title'] ) : $defaults['title'],
			'description' => isset( $services_raw['description'] ) ? wp_kses_post( $services_raw['description'] ) : $defaults['description'],
			'items'       => array(),
		);

		$items_raw = isset( $services_raw['items'] ) && is_array( $services_raw['items'] ) ? $services_raw['items'] : array();

		for ( $i = 0; $i < 4; $i++ ) {
			$item_raw = isset( $items_raw[ $i ] ) && is_array( $items_raw[ $i ] ) ? $items_raw[ $i ] : array();

			$services['items'][ $i ] = array(
				'title'       => isset( $item_raw['title'] ) ? wp_kses_post( $item_raw['title'] ) : $defaults['items'][ $i ]['title'],
				'description' => isset( $item_raw['description'] ) ? wp_kses_post( $item_raw['description'] ) : $defaults['items'][ $i ]['description'],
				'url'         => isset( $item_raw['url'] ) ? esc_url_raw( $item_raw['url'] ) : $defaults['items'][ $i ]['url'],
				'icon_id'     => isset( $item_raw['icon_id'] ) ? absint( $item_raw['icon_id'] ) : $defaults['items'][ $i ]['icon_id'],
				'icon_url'    => $defaults['items'][ $i ]['icon_url'],
				'direction'   => $defaults['items'][ $i ]['direction'],
			);
		}

		update_option( 'interior_home_services', $services );
		update_post_meta( $post_id, '_interior_home_services', $services );
	}

	if ( isset( $_POST['interior_home_about'] ) && is_array( $_POST['interior_home_about'] ) ) {
		$about_raw = wp_unslash( $_POST['interior_home_about'] );
		$defaults  = interior_get_home_about_defaults();
		$about     = array(
			'subtitle'        => isset( $about_raw['subtitle'] ) ? sanitize_text_field( $about_raw['subtitle'] ) : $defaults['subtitle'],
			'title'           => isset( $about_raw['title'] ) ? wp_kses_post( $about_raw['title'] ) : $defaults['title'],
			'description'     => isset( $about_raw['description'] ) ? wp_kses_post( $about_raw['description'] ) : $defaults['description'],
			'button_text'     => isset( $about_raw['button_text'] ) ? sanitize_text_field( $about_raw['button_text'] ) : $defaults['button_text'],
			'button_url'      => isset( $about_raw['button_url'] ) ? esc_url_raw( $about_raw['button_url'] ) : $defaults['button_url'],
			'background_text' => isset( $about_raw['background_text'] ) ? sanitize_text_field( $about_raw['background_text'] ) : $defaults['background_text'],
			'image_id'        => isset( $about_raw['image_id'] ) ? absint( $about_raw['image_id'] ) : $defaults['image_id'],
			'image_url'       => $defaults['image_url'],
			'icon_url'        => $defaults['icon_url'],
			'items'           => array(),
		);

		$items_raw = isset( $about_raw['items'] ) && is_array( $about_raw['items'] ) ? $about_raw['items'] : array();
		for ( $i = 0; $i < 4; $i++ ) {
			$about['items'][ $i ] = isset( $items_raw[ $i ] ) ? sanitize_text_field( $items_raw[ $i ] ) : $defaults['items'][ $i ];
		}

		update_option( 'interior_home_about', $about );
		update_post_meta( $post_id, '_interior_home_about', $about );
	}

	if ( isset( $_POST['interior_home_features'] ) && is_array( $_POST['interior_home_features'] ) ) {
		$features_raw = wp_unslash( $_POST['interior_home_features'] );
		$defaults     = interior_get_home_features_defaults();
		$features     = array(
			'subtitle'    => isset( $features_raw['subtitle'] ) ? sanitize_text_field( $features_raw['subtitle'] ) : $defaults['subtitle'],
			'title'       => isset( $features_raw['title'] ) ? wp_kses_post( $features_raw['title'] ) : $defaults['title'],
			'description' => isset( $features_raw['description'] ) ? wp_kses_post( $features_raw['description'] ) : $defaults['description'],
		);

		update_option( 'interior_home_features', $features );
		update_post_meta( $post_id, '_interior_home_features', $features );
	}

	if ( isset( $_POST['interior_home_counter'] ) && is_array( $_POST['interior_home_counter'] ) ) {
		$counter_raw = wp_unslash( $_POST['interior_home_counter'] );
		$defaults    = interior_get_home_counter_defaults();
		$counter     = array(
			'background_text' => isset( $counter_raw['background_text'] ) ? sanitize_text_field( $counter_raw['background_text'] ) : $defaults['background_text'],
			'image_id'        => isset( $counter_raw['image_id'] ) ? absint( $counter_raw['image_id'] ) : $defaults['image_id'],
			'image_url'       => $defaults['image_url'],
			'items'           => array(),
		);

		$items_raw = isset( $counter_raw['items'] ) && is_array( $counter_raw['items'] ) ? $counter_raw['items'] : array();
		for ( $i = 0; $i < 4; $i++ ) {
			$item_raw = isset( $items_raw[ $i ] ) && is_array( $items_raw[ $i ] ) ? $items_raw[ $i ] : array();

			$counter['items'][ $i ] = array(
				'number'      => isset( $item_raw['number'] ) ? sanitize_text_field( $item_raw['number'] ) : $defaults['items'][ $i ]['number'],
				'suffix'      => isset( $item_raw['suffix'] ) ? sanitize_text_field( $item_raw['suffix'] ) : $defaults['items'][ $i ]['suffix'],
				'title'       => isset( $item_raw['title'] ) ? sanitize_text_field( $item_raw['title'] ) : $defaults['items'][ $i ]['title'],
				'description' => isset( $item_raw['description'] ) ? wp_kses_post( $item_raw['description'] ) : $defaults['items'][ $i ]['description'],
			);
		}

		update_option( 'interior_home_counter', $counter );
		update_post_meta( $post_id, '_interior_home_counter', $counter );
	}

	if ( isset( $_POST['interior_home_process'] ) && is_array( $_POST['interior_home_process'] ) ) {
		$process_raw = wp_unslash( $_POST['interior_home_process'] );
		$defaults    = interior_get_home_process_defaults();
		$process     = array(
			'subtitle'    => isset( $process_raw['subtitle'] ) ? sanitize_text_field( $process_raw['subtitle'] ) : $defaults['subtitle'],
			'title'       => isset( $process_raw['title'] ) ? wp_kses_post( $process_raw['title'] ) : $defaults['title'],
			'description' => isset( $process_raw['description'] ) ? wp_kses_post( $process_raw['description'] ) : $defaults['description'],
			'bottom_text' => isset( $process_raw['bottom_text'] ) ? sanitize_text_field( $process_raw['bottom_text'] ) : $defaults['bottom_text'],
			'link_text'   => isset( $process_raw['link_text'] ) ? sanitize_text_field( $process_raw['link_text'] ) : $defaults['link_text'],
			'link_url'    => isset( $process_raw['link_url'] ) ? esc_url_raw( $process_raw['link_url'] ) : $defaults['link_url'],
			'items'       => array(),
		);

		$items_raw = isset( $process_raw['items'] ) && is_array( $process_raw['items'] ) ? $process_raw['items'] : array();
		for ( $i = 0; $i < 4; $i++ ) {
			$item_raw = isset( $items_raw[ $i ] ) && is_array( $items_raw[ $i ] ) ? $items_raw[ $i ] : array();

			$process['items'][ $i ] = array(
				'title'       => isset( $item_raw['title'] ) ? sanitize_text_field( $item_raw['title'] ) : $defaults['items'][ $i ]['title'],
				'description' => isset( $item_raw['description'] ) ? wp_kses_post( $item_raw['description'] ) : $defaults['items'][ $i ]['description'],
				'image_id'    => isset( $item_raw['image_id'] ) ? absint( $item_raw['image_id'] ) : $defaults['items'][ $i ]['image_id'],
				'image_url'   => $defaults['items'][ $i ]['image_url'],
			);
		}

		update_option( 'interior_home_process', $process );
		update_post_meta( $post_id, '_interior_home_process', $process );
	}

	if ( isset( $_POST['interior_home_projects'] ) && is_array( $_POST['interior_home_projects'] ) ) {
		$projects_raw = wp_unslash( $_POST['interior_home_projects'] );
		$defaults     = interior_get_home_projects_defaults();
		$projects     = array(
			'background_text' => isset( $projects_raw['background_text'] ) ? sanitize_text_field( $projects_raw['background_text'] ) : $defaults['background_text'],
			'subtitle'        => isset( $projects_raw['subtitle'] ) ? sanitize_text_field( $projects_raw['subtitle'] ) : $defaults['subtitle'],
			'title'           => isset( $projects_raw['title'] ) ? wp_kses_post( $projects_raw['title'] ) : $defaults['title'],
			'description'     => isset( $projects_raw['description'] ) ? wp_kses_post( $projects_raw['description'] ) : $defaults['description'],
		);

		update_option( 'interior_home_projects', $projects );
		update_post_meta( $post_id, '_interior_home_projects', $projects );
	}

	if ( isset( $_POST['interior_home_testimonial'] ) && is_array( $_POST['interior_home_testimonial'] ) ) {
		$testimonial_raw = wp_unslash( $_POST['interior_home_testimonial'] );
		$defaults        = interior_get_home_testimonial_defaults();
		$testimonial     = array(
			'subtitle'         => isset( $testimonial_raw['subtitle'] ) ? sanitize_text_field( $testimonial_raw['subtitle'] ) : $defaults['subtitle'],
			'title'            => isset( $testimonial_raw['title'] ) ? wp_kses_post( $testimonial_raw['title'] ) : $defaults['title'],
			'image_id'         => isset( $testimonial_raw['image_id'] ) ? absint( $testimonial_raw['image_id'] ) : $defaults['image_id'],
			'image_url'        => $defaults['image_url'],
			'rating'           => isset( $testimonial_raw['rating'] ) ? sanitize_text_field( $testimonial_raw['rating'] ) : $defaults['rating'],
			'reviews'          => isset( $testimonial_raw['reviews'] ) ? sanitize_text_field( $testimonial_raw['reviews'] ) : $defaults['reviews'],
			'intro'            => isset( $testimonial_raw['intro'] ) ? wp_kses_post( $testimonial_raw['intro'] ) : $defaults['intro'],
			'quote'            => isset( $testimonial_raw['quote'] ) ? wp_kses_post( $testimonial_raw['quote'] ) : $defaults['quote'],
			'author_name'      => isset( $testimonial_raw['author_name'] ) ? sanitize_text_field( $testimonial_raw['author_name'] ) : $defaults['author_name'],
			'author_position'  => isset( $testimonial_raw['author_position'] ) ? sanitize_text_field( $testimonial_raw['author_position'] ) : $defaults['author_position'],
			'author_image_id'  => isset( $testimonial_raw['author_image_id'] ) ? absint( $testimonial_raw['author_image_id'] ) : $defaults['author_image_id'],
			'author_image_url' => $defaults['author_image_url'],
		);

		update_option( 'interior_home_testimonial', $testimonial );
		update_post_meta( $post_id, '_interior_home_testimonial', $testimonial );
	}

	if ( isset( $_POST['interior_home_sponsors'] ) && is_array( $_POST['interior_home_sponsors'] ) ) {
		$sponsors_raw = wp_unslash( $_POST['interior_home_sponsors'] );
		$defaults     = interior_get_home_sponsors_defaults();
		$sponsors     = array(
			'heading_before' => isset( $sponsors_raw['heading_before'] ) ? sanitize_text_field( $sponsors_raw['heading_before'] ) : $defaults['heading_before'],
			'heading_number' => isset( $sponsors_raw['heading_number'] ) ? sanitize_text_field( $sponsors_raw['heading_number'] ) : $defaults['heading_number'],
			'heading_after'  => isset( $sponsors_raw['heading_after'] ) ? sanitize_text_field( $sponsors_raw['heading_after'] ) : $defaults['heading_after'],
			'items'          => array(),
		);

		$items_raw = isset( $sponsors_raw['items'] ) && is_array( $sponsors_raw['items'] ) ? $sponsors_raw['items'] : array();
		for ( $i = 0; $i < 6; $i++ ) {
			$item_raw = isset( $items_raw[ $i ] ) && is_array( $items_raw[ $i ] ) ? $items_raw[ $i ] : array();

			$sponsors['items'][ $i ] = array(
				'image_id'  => isset( $item_raw['image_id'] ) ? absint( $item_raw['image_id'] ) : $defaults['items'][ $i ]['image_id'],
				'image_url' => $defaults['items'][ $i ]['image_url'],
				'link_url'  => isset( $item_raw['link_url'] ) ? esc_url_raw( $item_raw['link_url'] ) : $defaults['items'][ $i ]['link_url'],
			);
		}

		update_option( 'interior_home_sponsors', $sponsors );
		update_post_meta( $post_id, '_interior_home_sponsors', $sponsors );
	}

	if ( isset( $_POST['interior_home_video'] ) && is_array( $_POST['interior_home_video'] ) ) {
		$video_raw = wp_unslash( $_POST['interior_home_video'] );
		$defaults  = interior_get_home_video_defaults();
		$video     = array(
			'subtitle' => isset( $video_raw['subtitle'] ) ? sanitize_text_field( $video_raw['subtitle'] ) : $defaults['subtitle'],
			'title'    => isset( $video_raw['title'] ) ? wp_kses_post( $video_raw['title'] ) : $defaults['title'],
			'items'    => array(),
		);

		$items_raw = isset( $video_raw['items'] ) && is_array( $video_raw['items'] ) ? $video_raw['items'] : array();
		for ( $i = 0; $i < 2; $i++ ) {
			$item_raw = isset( $items_raw[ $i ] ) && is_array( $items_raw[ $i ] ) ? $items_raw[ $i ] : array();

			$video['items'][ $i ] = array(
				'image_id'  => isset( $item_raw['image_id'] ) ? absint( $item_raw['image_id'] ) : $defaults['items'][ $i ]['image_id'],
				'image_url' => $defaults['items'][ $i ]['image_url'],
			);
		}

		update_option( 'interior_home_video', $video );
		update_post_meta( $post_id, '_interior_home_video', $video );
	}
}
add_action( 'save_post_page', 'interior_save_home_metabox' );

/**
 * Get saved home section override HTML for the rendered front page.
 *
 * @param string $section Section key.
 * @return string
 */
function interior_get_home_section_override( $section ) {
	if ( in_array( $section, array( 'services', 'about', 'features', 'counter', 'process', 'projects', 'testimonial', 'sponsors', 'video' ), true ) ) {
		return '';
	}

	$page_id = get_queried_object_id();

	if ( ! $page_id ) {
		$page_id = (int) get_option( 'page_on_front' );
	}

	$sections = $page_id ? get_post_meta( $page_id, '_interior_home_sections', true ) : array();

	if ( ! is_array( $sections ) || empty( $sections[ $section ] ) ) {
		return '';
	}

	return do_shortcode( $sections[ $section ] );
}

/**
 * Render the editable homepage slider.
 */
function interior_render_home_slider_section() {
	$slider = interior_get_home_slider_data();
	?>
	<section class="slider-section overflow-hidden">
		<div class="antra-slider swiper-container">
			<div class="swiper-wrapper">
				<?php for ( $i = 1; $i <= 2; $i++ ) : ?>
					<?php
					$field_base = 'slide_' . $i . '_';
					$bg_url     = ! empty( $slider[ $field_base . 'bg_image_id' ] ) ? wp_get_attachment_image_url( (int) $slider[ $field_base . 'bg_image_id' ], 'full' ) : get_template_directory_uri() . '/assets/img/bg-img/slider-img-' . $i . '.png';
					$thumb_url  = ! empty( $slider[ $field_base . 'thumb_image_id' ] ) ? wp_get_attachment_image_url( (int) $slider[ $field_base . 'thumb_image_id' ], 'full' ) : get_template_directory_uri() . '/assets/img/images/slider-thumb-1.png';
					?>
					<div class="swiper-slide">
						<div class="slider-item">
							<div class="bg-img" data-background="<?php echo esc_url( $bg_url ); ?>"></div>
							<div class="container slider-container">
								<div class="slider-content-wrap">
									<div class="slider-content">
										<div class="section-heading white-content">
											<h4 class="sub-heading" data-animation="antra-fadeInDown" data-delay="1000ms" data-duration="1400ms"><?php echo esc_html( $slider[ $field_base . 'subtitle' ] ); ?></h4>
											<h2 class="section-title cursor-effect" data-animation="antra-fadeInDown" data-delay="1200ms" data-duration="1400ms"><?php echo wp_kses_post( $slider[ $field_base . 'title' ] ); ?></h2>
										</div>
										<div class="bottom-content">
											<div class="antra-desc" data-animation="antra-fadeInUp" data-delay="1000ms" data-duration="1400ms">
												<p><?php echo wp_kses_post( $slider[ $field_base . 'description' ] ); ?></p>
											</div>
											<?php if ( ! empty( $slider[ $field_base . 'button_text' ] ) ) : ?>
												<div class="antra-btn" data-animation="antra-fadeInUp" data-delay="1200ms" data-duration="1400ms">
													<a href="<?php echo esc_url( $slider[ $field_base . 'button_url' ] ); ?>" class="tl-primary-btn white-btn"><?php echo esc_html( $slider[ $field_base . 'button_text' ] ); ?> <span class="icon"><i class="fa-regular fa-arrow-right"></i></span></a>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
							<div class="slider-element-wrap" data-animation="antra-fadeInRight" data-delay="1300ms" data-duration="1300ms">
								<div class="slider-element">
									<h3 class="element-title"><?php echo esc_html( $slider[ $field_base . 'stat_number' ] ); ?></h3>
									<span><?php echo wp_kses_post( $slider[ $field_base . 'stat_label' ] ); ?></span>
									<p><?php echo wp_kses_post( $slider[ $field_base . 'stat_desc' ] ); ?></p>
								</div>
								<div class="slider-thumb">
									<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( sprintf( 'Slider %d', $i ) ); ?>">
								</div>
							</div>
						</div>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</section>
	<!-- ./ slider-section -->
	<?php
}

/**
 * About page section keys and labels.
 *
 * @return array
 */
function interior_get_about_section_tabs() {
	return array(
		'page_header'  => esc_html__( 'Page Header', 'interior' ),
		'about_intro'  => esc_html__( 'About Intro', 'interior' ),
		'video'        => esc_html__( 'Video', 'interior' ),
		'history'      => esc_html__( 'History', 'interior' ),
		'process'      => esc_html__( 'Process', 'interior' ),
		'awards'       => esc_html__( 'Awards', 'interior' ),
		'gallery'      => esc_html__( 'Gallery', 'interior' ),
		'testimonial'  => esc_html__( 'Testimonials', 'interior' ),
		'sponsors'     => esc_html__( 'Sponsors', 'interior' ),
		'newsletter'   => esc_html__( 'Newsletter', 'interior' ),
	);
}

/**
 * Contact page section keys and labels.
 *
 * @return array
 */
function interior_get_contact_section_tabs() {
	return array(
		'page_header' => esc_html__( 'Page Header', 'interior' ),
		'contact'     => esc_html__( 'Contact Form', 'interior' ),
		'map'         => esc_html__( 'Map', 'interior' ),
	);
}

/**
 * Determine if a page uses a given template or slug.
 *
 * @param WP_Post|null $post     Page post.
 * @param string       $template Template file.
 * @param string       $slug     Page slug.
 * @return bool
 */
function interior_is_template_editor_page( $post, $template, $slug ) {
	if ( ! $post || 'page' !== $post->post_type ) {
		return false;
	}

	return $slug === $post->post_name || $template === get_page_template_slug( $post->ID );
}

/**
 * Register About and Contact page section metaboxes.
 */
function interior_register_page_section_metaboxes() {
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
	$post    = $post_id ? get_post( $post_id ) : null;

	if ( interior_is_template_editor_page( $post, 'page-about.php', 'about-us' ) || interior_is_template_editor_page( $post, 'page-about.php', 'about' ) ) {
		add_meta_box(
			'interior_about_sections',
			esc_html__( 'About Page Sections', 'interior' ),
			'interior_render_about_metabox',
			'page',
			'normal',
			'high'
		);
	}

	if ( interior_is_template_editor_page( $post, 'page-contact.php', 'contact' ) ) {
		add_meta_box(
			'interior_contact_sections',
			esc_html__( 'Contact Page Sections', 'interior' ),
			'interior_render_contact_metabox',
			'page',
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'interior_register_page_section_metaboxes' );

/**
 * Render a generic tabbed section editor.
 *
 * @param WP_Post $post      Current page.
 * @param string  $meta_key  Meta key.
 * @param array   $tabs      Tabs.
 * @param string  $nonce_key Nonce action/key prefix.
 */
function interior_render_tabbed_section_editor( $post, $meta_key, $tabs, $nonce_key ) {
	$sections = get_post_meta( $post->ID, $meta_key, true );
	$sections = is_array( $sections ) ? $sections : array();
	$first    = true;

	wp_nonce_field( $nonce_key, $nonce_key . '_field' );
	?>
	<style>
		.interior-page-tabs-nav { display:flex; flex-wrap:wrap; border-bottom:2px solid #ddd; margin:16px 0 20px; }
		.interior-page-tab-btn { background:#fff; border:0; border-bottom:3px solid transparent; color:#555; cursor:pointer; font-weight:600; padding:10px 14px; }
		.interior-page-tab-btn.active { border-bottom-color:#2271b1; color:#1d2327; }
		.interior-page-tab-content { display:none; }
		.interior-page-tab-content.active { display:block; }
		.interior-page-tab-content .description { margin:0 0 12px; }
	</style>
	<div class="interior-page-tabs">
		<div class="interior-page-tabs-nav">
			<?php foreach ( $tabs as $key => $label ) : ?>
				<button type="button" class="interior-page-tab-btn <?php echo $first ? 'active' : ''; ?>" data-tab="<?php echo esc_attr( $nonce_key . '-' . $key ); ?>"><?php echo esc_html( $label ); ?></button>
				<?php $first = false; ?>
			<?php endforeach; ?>
		</div>
		<?php
		$first = true;
		foreach ( $tabs as $key => $label ) :
			$value = isset( $sections[ $key ] ) ? $sections[ $key ] : '';
			?>
			<div id="<?php echo esc_attr( $nonce_key . '-' . $key ); ?>" class="interior-page-tab-content <?php echo $first ? 'active' : ''; ?>">
				<p class="description"><?php echo esc_html( sprintf( 'Override the %s section HTML. Leave empty to use the default design from the page template.', $label ) ); ?></p>
				<?php
				wp_editor(
					$value,
					$nonce_key . '_' . $key,
					array(
						'textarea_name' => $nonce_key . '_sections[' . $key . ']',
						'textarea_rows' => 16,
						'media_buttons' => true,
					)
				);
				?>
			</div>
			<?php
			$first = false;
		endforeach;
		?>
	</div>
	<script>
		(function() {
			const buttons = document.querySelectorAll('.interior-page-tab-btn');
			const contents = document.querySelectorAll('.interior-page-tab-content');
			buttons.forEach(function(button) {
				button.addEventListener('click', function(e) {
					e.preventDefault();
					const tab = this.getAttribute('data-tab');
					buttons.forEach(function(item) { item.classList.remove('active'); });
					contents.forEach(function(item) { item.classList.remove('active'); });
					this.classList.add('active');
					document.getElementById(tab).classList.add('active');
				});
			});
		})();
	</script>
	<?php
}

/**
 * Render About sections metabox.
 *
 * @param WP_Post $post Current page.
 */
function interior_render_about_metabox( $post ) {
	interior_render_tabbed_section_editor( $post, '_interior_about_sections', interior_get_about_section_tabs(), 'interior_about' );
}

/**
 * Render Contact sections metabox.
 *
 * @param WP_Post $post Current page.
 */
function interior_render_contact_metabox( $post ) {
	interior_render_tabbed_section_editor( $post, '_interior_contact_sections', interior_get_contact_section_tabs(), 'interior_contact' );
}

/**
 * Save About and Contact section metaboxes.
 *
 * @param int $post_id Post ID.
 */
function interior_save_page_section_metaboxes( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$configs = array(
		'interior_about'   => array( '_interior_about_sections', interior_get_about_section_tabs() ),
		'interior_contact' => array( '_interior_contact_sections', interior_get_contact_section_tabs() ),
	);

	foreach ( $configs as $nonce_key => $config ) {
		if ( ! isset( $_POST[ $nonce_key . '_field' ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ $nonce_key . '_field' ] ) ), $nonce_key ) ) {
			continue;
		}

		$raw   = isset( $_POST[ $nonce_key . '_sections' ] ) && is_array( $_POST[ $nonce_key . '_sections' ] ) ? wp_unslash( $_POST[ $nonce_key . '_sections' ] ) : array();
		$saved = array();

		foreach ( $config[1] as $key => $label ) {
			$saved[ $key ] = isset( $raw[ $key ] ) ? wp_kses_post( $raw[ $key ] ) : '';
		}

		update_post_meta( $post_id, $config[0], $saved );
	}
}
add_action( 'save_post_page', 'interior_save_page_section_metaboxes' );

/**
 * Get saved page section override HTML.
 *
 * @param string $meta_key Meta key.
 * @param string $section  Section key.
 * @return string
 */
function interior_get_page_section_override( $meta_key, $section ) {
	$page_id  = get_queried_object_id();
	$sections = $page_id ? get_post_meta( $page_id, $meta_key, true ) : array();

	if ( ! is_array( $sections ) || empty( $sections[ $section ] ) ) {
		return '';
	}

	return do_shortcode( $sections[ $section ] );
}
