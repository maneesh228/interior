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
	if ( ! $screen || ! in_array( $screen->post_type, array( 'interior_service', 'interior_project' ), true ) ) {
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
