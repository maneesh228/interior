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
		'sponsors'    => esc_html__( 'Sponsors', 'interior' ),
		'team'        => esc_html__( 'Team', 'interior' ),
		'video'       => esc_html__( 'Video', 'interior' ),
		'blog'        => esc_html__( 'Blog', 'interior' ),
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
		if ( 'slider' === $key ) {
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
}
add_action( 'save_post_page', 'interior_save_home_metabox' );

/**
 * Get saved home section override HTML for the rendered front page.
 *
 * @param string $section Section key.
 * @return string
 */
function interior_get_home_section_override( $section ) {
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
