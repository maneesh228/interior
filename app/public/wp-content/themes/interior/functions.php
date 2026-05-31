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
 * Default header editable values.
 *
 * @return array
 */
function interior_get_header_defaults() {
	$theme_uri = get_template_directory_uri();

	return array(
		'preloader_text' => 'ANTRA',
		'logo_dark_id'   => 0,
		'logo_dark_url'  => $theme_uri . '/assets/img/logo/logo-2.png',
		'logo_light_id'  => 0,
		'logo_light_url' => $theme_uri . '/assets/img/logo/logo-1.png',
		'nav_items'      => array(
			array( 'label' => 'Home', 'url' => home_url( '/' ) ),
			array( 'label' => 'About Us', 'url' => home_url( '/about-us/' ) ),
			array( 'label' => 'Media', 'url' => home_url( '/media/' ) ),
			array( 'label' => 'Contact', 'url' => home_url( '/contact/' ) ),
		),
		'services_label' => 'Services',
		'services_url'   => home_url( '/services/' ),
		'projects_label' => 'Projects',
		'projects_url'   => home_url( '/projects/' ),
		'phone_label'    => 'Call Us Phone',
		'phone_number'   => '(+480) 123 678 900',
		'phone_url'      => 'tel:+480123678900',
		'button_text'    => 'Get in Touch',
		'button_url'     => home_url( '/contact/' ),
		'search_placeholder' => 'Type keywords here...',
		'side_title'     => 'We Shape Interior Designs, Crafting Timeless and Inspiring Spaces',
		'side_address'   => "5609 E Sprague Ave,\nSpokane Valley, WA 99212,\nUSA",
		'side_phone'     => '+(084) 456-0789',
		'side_phone_url' => 'tel:+0844560789',
		'side_email'     => 'support@example.com',
		'side_email_url' => 'mailto:support@example.com',
		'mobile_title'   => 'Contact Us',
		'mobile_address' => 'Valentin, Street Road 24, New York,',
		'mobile_phone'   => '+000 123 (456) 789',
		'mobile_phone_url' => 'tel:+000123456789',
		'mobile_email'   => 'antra@gmail.com',
		'mobile_email_url' => 'mailto:antra@gmail.com',
		'social_items'   => array(
			array( 'label' => 'Facebook', 'icon' => 'fab fa-facebook-f', 'url' => '#' ),
			array( 'label' => 'Instagram', 'icon' => 'fab fa-instagram', 'url' => '#' ),
			array( 'label' => 'Twitter', 'icon' => 'fab fa-twitter', 'url' => '#' ),
			array( 'label' => 'Google Plus', 'icon' => 'fab fa-fab fa-google-plus', 'url' => '#' ),
		),
		'gallery_items'  => array(
			array( 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/project/sidebar-gallary-1.png' ),
			array( 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/project/sidebar-gallary-2.png' ),
			array( 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/project/sidebar-gallary-3.png' ),
			array( 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/project/sidebar-gallary-4.png' ),
			array( 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/project/sidebar-gallary-5.png' ),
			array( 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/project/sidebar-gallary-6.png' ),
		),
	);
}

/**
 * Get header editable values.
 *
 * @return array
 */
function interior_get_header_data() {
	return interior_parse_theme_option_data( get_option( 'interior_header_settings', array() ), interior_get_header_defaults() );
}

/**
 * Default footer editable values.
 *
 * @return array
 */
function interior_get_footer_defaults() {
	$theme_uri = get_template_directory_uri();

	return array(
		'bg_image_id'  => 0,
		'bg_image_url' => $theme_uri . '/assets/img/bg-img/footer-bg.png',
		'logo_id'      => 0,
		'logo_url'     => $theme_uri . '/assets/img/logo/logo-2.png',
		'description'  => 'We transform your vision into beautifully <br> crafted spaces.',
		'address'      => '5609 E Sprague Ave, Spokane Valley, <br> WA 99212, USA',
		'phone'        => '+(084) 456-0789',
		'phone_url'    => 'tel:+0844560789',
		'email'        => 'support@example.com',
		'email_url'    => 'mailto:support@example.com',
		'copyright'    => '© 2025 antra. All Rights Reserved.',
		'big_text'     => 'antra',
		'link_columns' => array(
			array(
				array( 'label' => 'About Us', 'url' => home_url( '/about-us/' ) ),
				array( 'label' => 'Services', 'url' => home_url( '/services/' ) ),
				array( 'label' => 'Careers', 'url' => home_url( '/contact/' ) ),
				array( 'label' => 'our Team', 'url' => '#' ),
				array( 'label' => 'Blog', 'url' => '#' ),
				array( 'label' => 'Contact Us', 'url' => home_url( '/contact/' ) ),
			),
			array(
				array( 'label' => 'Our Projects', 'url' => home_url( '/projects/' ) ),
				array( 'label' => 'Partners', 'url' => home_url( '/contact/' ) ),
				array( 'label' => 'Partners Program', 'url' => home_url( '/contact/' ) ),
				array( 'label' => 'Affiliate Program', 'url' => home_url( '/contact/' ) ),
				array( 'label' => 'Terms & Conditions', 'url' => '#' ),
				array( 'label' => 'Support Center', 'url' => '#' ),
			),
		),
		'social_items' => array(
			array( 'label' => 'Facebook', 'url' => '#' ),
			array( 'label' => 'Instagram', 'url' => '#' ),
			array( 'label' => 'YouTube', 'url' => '#' ),
			array( 'label' => 'Twitter', 'url' => '#' ),
		),
	);
}

/**
 * Get footer editable values.
 *
 * @return array
 */
function interior_get_footer_data() {
	$defaults = interior_get_footer_defaults();
	$saved    = get_option( 'interior_footer_settings', array() );
	$saved    = is_array( $saved ) ? $saved : array();
	$data     = interior_parse_theme_option_data( $saved, $defaults );

	if ( isset( $saved['link_columns'] ) && is_array( $saved['link_columns'] ) ) {
		$data['link_columns'] = $defaults['link_columns'];

		foreach ( $defaults['link_columns'] as $column_index => $column_defaults ) {
			$column_saved = isset( $saved['link_columns'][ $column_index ] ) && is_array( $saved['link_columns'][ $column_index ] ) ? $saved['link_columns'][ $column_index ] : array();

			foreach ( $column_defaults as $link_index => $link_defaults ) {
				$link_saved = isset( $column_saved[ $link_index ] ) && is_array( $column_saved[ $link_index ] ) ? $column_saved[ $link_index ] : array();

				$data['link_columns'][ $column_index ][ $link_index ] = array(
					'label' => isset( $link_saved['label'] ) && ! is_array( $link_saved['label'] ) ? $link_saved['label'] : $link_defaults['label'],
					'url'   => isset( $link_saved['url'] ) && ! is_array( $link_saved['url'] ) ? $link_saved['url'] : $link_defaults['url'],
				);
			}
		}
	}

	return $data;
}

/**
 * Recursively parse saved theme option data with defaults.
 *
 * @param array $saved    Saved data.
 * @param array $defaults Default data.
 * @return array
 */
function interior_parse_theme_option_data( $saved, $defaults ) {
	$saved = is_array( $saved ) ? $saved : array();
	$data  = wp_parse_args( $saved, $defaults );

	foreach ( $defaults as $key => $default ) {
		if ( is_array( $default ) ) {
			$data[ $key ] = array();
			foreach ( $default as $index => $item_default ) {
				$saved_item = array();
				if ( isset( $saved[ $key ] ) && is_array( $saved[ $key ] ) && isset( $saved[ $key ][ $index ] ) ) {
					$saved_item = $saved[ $key ][ $index ];
				}
				$data[ $key ][ $index ] = is_array( $item_default )
					? interior_parse_theme_option_data( is_array( $saved_item ) ? $saved_item : array(), $item_default )
					: ( '' !== $saved_item ? $saved_item : $item_default );
			}
		} elseif ( isset( $data[ $key ] ) && is_array( $data[ $key ] ) ) {
			$data[ $key ] = $default;
		}
	}

	return $data;
}

/**
 * Register Header/Footer edit pages.
 */
function interior_register_theme_edit_pages() {
	add_theme_page(
		esc_html__( 'Header Edit', 'interior' ),
		esc_html__( 'Header Edit', 'interior' ),
		'manage_options',
		'interior-header-edit',
		'interior_render_header_edit_page'
	);

	add_theme_page(
		esc_html__( 'Footer Edit', 'interior' ),
		esc_html__( 'Footer Edit', 'interior' ),
		'manage_options',
		'interior-footer-edit',
		'interior_render_footer_edit_page'
	);
}
add_action( 'admin_menu', 'interior_register_theme_edit_pages' );

/**
 * Enqueue media picker for Header/Footer edit pages.
 *
 * @param string $hook Current admin hook.
 */
function interior_theme_edit_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'appearance_page_interior-header-edit', 'appearance_page_interior-footer-edit' ), true ) ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_script( 'jquery' );
}
add_action( 'admin_enqueue_scripts', 'interior_theme_edit_admin_assets' );

/**
 * Render shared Header/Footer tab script.
 */
function interior_render_theme_edit_scripts() {
	?>
	<script>
		(function() {
			function setupInteriorThemeTabs() {
				const buttons = document.querySelectorAll('.interior-theme-tab-btn');
				const contents = document.querySelectorAll('.interior-theme-tab-content');
				if (!buttons.length || !contents.length) {
					return;
				}
				buttons.forEach(function(button) {
					button.addEventListener('click', function(e) {
						e.preventDefault();
						const tab = this.getAttribute('data-tab');
						const target = document.getElementById(tab);
						if (!target) {
							return;
						}
						buttons.forEach(function(item) { item.classList.remove('active'); });
						contents.forEach(function(item) { item.classList.remove('active'); });
						this.classList.add('active');
						target.classList.add('active');
					});
				});
			}
			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', setupInteriorThemeTabs);
			} else {
				setupInteriorThemeTabs();
			}
		})();
		(function($) {
			$('.interior-theme-upload').on('click', function(e) {
				e.preventDefault();
				const target = $(this).data('target');
				const preview = $(this).data('preview');
				const frame = wp.media({ title: 'Select Image', button: { text: 'Use this image' }, multiple: false });
				frame.on('select', function() {
					const attachment = frame.state().get('selection').first().toJSON();
					$(target).val(attachment.id);
					$(preview).attr('src', attachment.url).show();
				});
				frame.open();
			});
			$('.interior-theme-remove').on('click', function(e) {
				e.preventDefault();
				$($(this).data('target')).val('');
				$($(this).data('preview')).attr('src', '').hide();
			});
		})(jQuery);
	</script>
	<?php
}

/**
 * Render shared Header/Footer tab styles.
 */
function interior_render_theme_edit_styles() {
	?>
	<style>
		.interior-theme-tabs-nav { display:flex !important; flex-wrap:wrap; gap:4px; margin:16px 0 20px; visibility:visible !important; }
		.interior-theme-tab-btn { display:inline-block !important; background:#fff; border:1px solid #c3c4c7; border-bottom:3px solid transparent; color:#555; cursor:pointer; font-weight:600; padding:10px 14px; text-decoration:none; visibility:visible !important; }
		.interior-theme-tab-btn.active { border-bottom-color:#2271b1; color:#1d2327; background:#f6f7f7; }
		.interior-theme-tab-content { display:none; }
		.interior-theme-tab-content.active { display:block; }
		.interior-theme-preview { display:block; max-width:220px; height:auto; margin:0 0 10px; }
		.interior-theme-repeat h3 { margin-top:24px; }
	</style>
	<?php
}

/**
 * Render an option image picker row.
 *
 * @param string $name     Input name.
 * @param string $id_base  ID base.
 * @param int    $image_id Attachment ID.
 * @param string $fallback Fallback URL.
 * @param string $label    Label.
 */
function interior_render_theme_image_field( $name, $id_base, $image_id, $fallback, $label ) {
	$image_id  = (int) $image_id;
	$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : $fallback;
	?>
	<tr>
		<th scope="row"><?php echo esc_html( $label ); ?></th>
		<td>
			<input type="hidden" id="<?php echo esc_attr( $id_base ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $image_id ); ?>">
			<img id="<?php echo esc_attr( $id_base ); ?>_preview" class="interior-theme-preview" src="<?php echo esc_url( $image_url ); ?>" alt="" style="<?php echo $image_url ? '' : 'display:none;'; ?>">
			<button type="button" class="button interior-theme-upload" data-target="#<?php echo esc_attr( $id_base ); ?>" data-preview="#<?php echo esc_attr( $id_base ); ?>_preview"><?php esc_html_e( 'Select Image', 'interior' ); ?></button>
			<button type="button" class="button interior-theme-remove" data-target="#<?php echo esc_attr( $id_base ); ?>" data-preview="#<?php echo esc_attr( $id_base ); ?>_preview"><?php esc_html_e( 'Remove Image', 'interior' ); ?></button>
		</td>
	</tr>
	<?php
}

/**
 * Render Header edit page.
 */
function interior_render_header_edit_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$data = interior_get_header_data();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Header Edit', 'interior' ); ?></h1>
		<?php if ( isset( $_GET['updated'] ) && 'true' === $_GET['updated'] ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Header settings saved.', 'interior' ); ?></p></div>
		<?php endif; ?>
		<?php interior_render_theme_edit_styles(); ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="interior_save_header_settings">
			<?php wp_nonce_field( 'interior_save_header_settings', 'interior_header_nonce' ); ?>
			<div class="interior-theme-tabs">
				<div class="interior-theme-tabs-nav">
					<button class="interior-theme-tab-btn active" type="button" data-tab="header-branding"><?php esc_html_e( 'Branding', 'interior' ); ?></button>
					<button class="interior-theme-tab-btn" type="button" data-tab="header-menu"><?php esc_html_e( 'Menu', 'interior' ); ?></button>
					<button class="interior-theme-tab-btn" type="button" data-tab="header-contact"><?php esc_html_e( 'Contact', 'interior' ); ?></button>
					<button class="interior-theme-tab-btn" type="button" data-tab="header-sidebar"><?php esc_html_e( 'Side Menu', 'interior' ); ?></button>
					<button class="interior-theme-tab-btn" type="button" data-tab="header-social"><?php esc_html_e( 'Social', 'interior' ); ?></button>
				</div>
				<div id="header-branding" class="interior-theme-tab-content active">
					<table class="form-table" role="presentation">
						<tr><th scope="row"><?php esc_html_e( 'Preloader Text', 'interior' ); ?></th><td><input class="regular-text" type="text" name="header[preloader_text]" value="<?php echo esc_attr( $data['preloader_text'] ); ?>"></td></tr>
						<?php interior_render_theme_image_field( 'header[logo_dark_id]', 'header_logo_dark_id', $data['logo_dark_id'], $data['logo_dark_url'], __( 'Dark Logo', 'interior' ) ); ?>
						<?php interior_render_theme_image_field( 'header[logo_light_id]', 'header_logo_light_id', $data['logo_light_id'], $data['logo_light_url'], __( 'Light Logo', 'interior' ) ); ?>
					</table>
				</div>
				<div id="header-menu" class="interior-theme-tab-content">
					<table class="form-table" role="presentation">
						<tr><th scope="row"><?php esc_html_e( 'Services Dropdown', 'interior' ); ?></th><td><input type="text" name="header[services_label]" value="<?php echo esc_attr( $data['services_label'] ); ?>" placeholder="Label"> <input class="regular-text" type="text" name="header[services_url]" value="<?php echo esc_attr( $data['services_url'] ); ?>" placeholder="URL"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Projects Dropdown', 'interior' ); ?></th><td><input type="text" name="header[projects_label]" value="<?php echo esc_attr( $data['projects_label'] ); ?>" placeholder="Label"> <input class="regular-text" type="text" name="header[projects_url]" value="<?php echo esc_attr( $data['projects_url'] ); ?>" placeholder="URL"></td></tr>
						<?php foreach ( $data['nav_items'] as $index => $item ) : ?>
							<tr><th scope="row"><?php echo esc_html( sprintf( 'Menu Item %d', $index + 1 ) ); ?></th><td><input type="text" name="header[nav_items][<?php echo esc_attr( $index ); ?>][label]" value="<?php echo esc_attr( $item['label'] ); ?>" placeholder="Label"> <input class="regular-text" type="text" name="header[nav_items][<?php echo esc_attr( $index ); ?>][url]" value="<?php echo esc_attr( $item['url'] ); ?>" placeholder="URL"></td></tr>
						<?php endforeach; ?>
					</table>
				</div>
				<div id="header-contact" class="interior-theme-tab-content">
					<table class="form-table" role="presentation">
						<tr><th scope="row"><?php esc_html_e( 'Phone Label', 'interior' ); ?></th><td><input class="regular-text" type="text" name="header[phone_label]" value="<?php echo esc_attr( $data['phone_label'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Phone', 'interior' ); ?></th><td><input type="text" name="header[phone_number]" value="<?php echo esc_attr( $data['phone_number'] ); ?>"> <input class="regular-text" type="text" name="header[phone_url]" value="<?php echo esc_attr( $data['phone_url'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Button', 'interior' ); ?></th><td><input type="text" name="header[button_text]" value="<?php echo esc_attr( $data['button_text'] ); ?>"> <input class="regular-text" type="text" name="header[button_url]" value="<?php echo esc_attr( $data['button_url'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Search Placeholder', 'interior' ); ?></th><td><input class="large-text" type="text" name="header[search_placeholder]" value="<?php echo esc_attr( $data['search_placeholder'] ); ?>"></td></tr>
					</table>
				</div>
				<div id="header-sidebar" class="interior-theme-tab-content">
					<table class="form-table" role="presentation">
						<tr><th scope="row"><?php esc_html_e( 'Side Title', 'interior' ); ?></th><td><textarea class="large-text" rows="2" name="header[side_title]"><?php echo esc_textarea( $data['side_title'] ); ?></textarea></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Side Contact', 'interior' ); ?></th><td><textarea class="large-text" rows="3" name="header[side_address]"><?php echo esc_textarea( $data['side_address'] ); ?></textarea><input type="text" name="header[side_phone]" value="<?php echo esc_attr( $data['side_phone'] ); ?>"> <input class="regular-text" type="text" name="header[side_phone_url]" value="<?php echo esc_attr( $data['side_phone_url'] ); ?>"><br><input type="text" name="header[side_email]" value="<?php echo esc_attr( $data['side_email'] ); ?>"> <input class="regular-text" type="text" name="header[side_email_url]" value="<?php echo esc_attr( $data['side_email_url'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Mobile Contact', 'interior' ); ?></th><td><input class="regular-text" type="text" name="header[mobile_title]" value="<?php echo esc_attr( $data['mobile_title'] ); ?>"><br><textarea class="large-text" rows="2" name="header[mobile_address]"><?php echo esc_textarea( $data['mobile_address'] ); ?></textarea><input type="text" name="header[mobile_phone]" value="<?php echo esc_attr( $data['mobile_phone'] ); ?>"> <input class="regular-text" type="text" name="header[mobile_phone_url]" value="<?php echo esc_attr( $data['mobile_phone_url'] ); ?>"><br><input type="text" name="header[mobile_email]" value="<?php echo esc_attr( $data['mobile_email'] ); ?>"> <input class="regular-text" type="text" name="header[mobile_email_url]" value="<?php echo esc_attr( $data['mobile_email_url'] ); ?>"></td></tr>
					</table>
					<div class="interior-theme-repeat">
						<?php foreach ( $data['gallery_items'] as $index => $item ) : ?>
							<h3><?php echo esc_html( sprintf( 'Side Gallery Image %d', $index + 1 ) ); ?></h3>
							<table class="form-table" role="presentation">
								<?php interior_render_theme_image_field( 'header[gallery_items][' . $index . '][image_id]', 'header_gallery_' . $index, $item['image_id'], $item['image_url'], __( 'Image', 'interior' ) ); ?>
							</table>
						<?php endforeach; ?>
					</div>
				</div>
				<div id="header-social" class="interior-theme-tab-content">
					<table class="form-table" role="presentation">
						<?php foreach ( $data['social_items'] as $index => $item ) : ?>
							<tr><th scope="row"><?php echo esc_html( sprintf( 'Social Item %d', $index + 1 ) ); ?></th><td><input type="text" name="header[social_items][<?php echo esc_attr( $index ); ?>][label]" value="<?php echo esc_attr( $item['label'] ); ?>" placeholder="Label"> <input type="text" name="header[social_items][<?php echo esc_attr( $index ); ?>][icon]" value="<?php echo esc_attr( $item['icon'] ); ?>" placeholder="Icon class"> <input class="regular-text" type="text" name="header[social_items][<?php echo esc_attr( $index ); ?>][url]" value="<?php echo esc_attr( $item['url'] ); ?>" placeholder="URL"></td></tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
			<?php submit_button(); ?>
		</form>
		<?php interior_render_theme_edit_scripts(); ?>
	</div>
	<?php
}

/**
 * Render Footer edit page.
 */
function interior_render_footer_edit_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$data = interior_get_footer_data();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Footer Edit', 'interior' ); ?></h1>
		<?php if ( isset( $_GET['updated'] ) && 'true' === $_GET['updated'] ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Footer settings saved.', 'interior' ); ?></p></div>
		<?php endif; ?>
		<?php interior_render_theme_edit_styles(); ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="interior_save_footer_settings">
			<?php wp_nonce_field( 'interior_save_footer_settings', 'interior_footer_nonce' ); ?>
			<div class="interior-theme-tabs">
				<div class="interior-theme-tabs-nav">
					<button class="interior-theme-tab-btn active" type="button" data-tab="footer-branding"><?php esc_html_e( 'Branding', 'interior' ); ?></button>
					<button class="interior-theme-tab-btn" type="button" data-tab="footer-links"><?php esc_html_e( 'Links', 'interior' ); ?></button>
					<button class="interior-theme-tab-btn" type="button" data-tab="footer-contact"><?php esc_html_e( 'Contact', 'interior' ); ?></button>
					<button class="interior-theme-tab-btn" type="button" data-tab="footer-bottom"><?php esc_html_e( 'Bottom', 'interior' ); ?></button>
				</div>
				<div id="footer-branding" class="interior-theme-tab-content active">
					<table class="form-table" role="presentation">
						<?php interior_render_theme_image_field( 'footer[bg_image_id]', 'footer_bg_image_id', $data['bg_image_id'], $data['bg_image_url'], __( 'Background Image', 'interior' ) ); ?>
						<?php interior_render_theme_image_field( 'footer[logo_id]', 'footer_logo_id', $data['logo_id'], $data['logo_url'], __( 'Logo', 'interior' ) ); ?>
						<tr><th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th><td><textarea class="large-text" rows="2" name="footer[description]"><?php echo esc_textarea( $data['description'] ); ?></textarea></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Address', 'interior' ); ?></th><td><textarea class="large-text" rows="2" name="footer[address]"><?php echo esc_textarea( $data['address'] ); ?></textarea></td></tr>
					</table>
				</div>
				<div id="footer-links" class="interior-theme-tab-content">
					<?php foreach ( $data['link_columns'] as $column_index => $column ) : ?>
						<h2><?php echo esc_html( sprintf( 'Link Column %d', $column_index + 1 ) ); ?></h2>
						<table class="form-table" role="presentation">
							<?php foreach ( $column as $index => $item ) : ?>
								<?php
								$item_label = isset( $item['label'] ) && ! is_array( $item['label'] ) ? $item['label'] : '';
								?>
								<tr><th scope="row"><?php echo esc_html( sprintf( 'Link %d', $index + 1 ) ); ?></th><td><input class="regular-text" type="text" name="footer[link_columns][<?php echo esc_attr( $column_index ); ?>][<?php echo esc_attr( $index ); ?>][label]" value="<?php echo esc_attr( $item_label ); ?>" placeholder="Label"></td></tr>
							<?php endforeach; ?>
						</table>
					<?php endforeach; ?>
				</div>
				<div id="footer-contact" class="interior-theme-tab-content">
					<table class="form-table" role="presentation">
						<tr><th scope="row"><?php esc_html_e( 'Phone', 'interior' ); ?></th><td><input type="text" name="footer[phone]" value="<?php echo esc_attr( $data['phone'] ); ?>"> <input class="regular-text" type="text" name="footer[phone_url]" value="<?php echo esc_attr( $data['phone_url'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Email', 'interior' ); ?></th><td><input type="text" name="footer[email]" value="<?php echo esc_attr( $data['email'] ); ?>"> <input class="regular-text" type="text" name="footer[email_url]" value="<?php echo esc_attr( $data['email_url'] ); ?>"></td></tr>
						<?php foreach ( $data['social_items'] as $index => $item ) : ?>
							<tr><th scope="row"><?php echo esc_html( sprintf( 'Social Item %d', $index + 1 ) ); ?></th><td><input type="text" name="footer[social_items][<?php echo esc_attr( $index ); ?>][label]" value="<?php echo esc_attr( $item['label'] ); ?>" placeholder="Label"> <input class="regular-text" type="text" name="footer[social_items][<?php echo esc_attr( $index ); ?>][url]" value="<?php echo esc_attr( $item['url'] ); ?>" placeholder="URL"></td></tr>
						<?php endforeach; ?>
					</table>
				</div>
				<div id="footer-bottom" class="interior-theme-tab-content">
					<table class="form-table" role="presentation">
						<tr><th scope="row"><?php esc_html_e( 'Copyright', 'interior' ); ?></th><td><input class="large-text" type="text" name="footer[copyright]" value="<?php echo esc_attr( $data['copyright'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Large Footer Text', 'interior' ); ?></th><td><input class="large-text" type="text" name="footer[big_text]" value="<?php echo esc_attr( $data['big_text'] ); ?>"></td></tr>
					</table>
				</div>
			</div>
			<?php submit_button(); ?>
		</form>
		<?php interior_render_theme_edit_scripts(); ?>
	</div>
	<?php
}

/**
 * Sanitize nested Header/Footer settings.
 *
 * @param array $raw      Raw values.
 * @param array $defaults Defaults.
 * @return array
 */
function interior_sanitize_theme_settings( $raw, $defaults ) {
	$raw  = is_array( $raw ) ? $raw : array();
	$data = $defaults;

	foreach ( $defaults as $key => $default ) {
		if ( is_array( $default ) ) {
			foreach ( $default as $index => $item_default ) {
				if ( is_array( $item_default ) ) {
					$raw_item = isset( $raw[ $key ] ) && is_array( $raw[ $key ] ) && isset( $raw[ $key ][ $index ] ) ? $raw[ $key ][ $index ] : array();
					$data[ $key ][ $index ] = interior_sanitize_theme_settings( is_array( $raw_item ) ? $raw_item : array(), $item_default );
				}
			}
			continue;
		}

		if ( ! isset( $raw[ $key ] ) ) {
			continue;
		}

		if ( is_array( $raw[ $key ] ) ) {
			$data[ $key ] = $default;
			continue;
		}

		if ( false !== strpos( $key, 'image_id' ) || false !== strpos( $key, 'logo_id' ) || 'bg_image_id' === $key ) {
			$data[ $key ] = absint( $raw[ $key ] );
		} elseif ( false !== strpos( $key, 'url' ) ) {
			$data[ $key ] = esc_url_raw( $raw[ $key ] );
		} elseif ( in_array( $key, array( 'description', 'address', 'side_address', 'mobile_address', 'side_title' ), true ) ) {
			$data[ $key ] = wp_kses_post( $raw[ $key ] );
		} else {
			$data[ $key ] = sanitize_text_field( $raw[ $key ] );
		}
	}

	return $data;
}

/**
 * Sanitize Footer edit page settings.
 *
 * @param array $raw Raw values.
 * @return array
 */
function interior_sanitize_footer_settings( $raw ) {
	$defaults = interior_get_footer_defaults();
	$current  = interior_get_footer_data();
	$raw      = is_array( $raw ) ? $raw : array();
	$data     = interior_sanitize_theme_settings( $raw, $current );

	if ( isset( $raw['link_columns'] ) && is_array( $raw['link_columns'] ) ) {
		$data['link_columns'] = $current['link_columns'];

		foreach ( $defaults['link_columns'] as $column_index => $column_defaults ) {
			$column_raw = isset( $raw['link_columns'][ $column_index ] ) && is_array( $raw['link_columns'][ $column_index ] ) ? $raw['link_columns'][ $column_index ] : array();

			foreach ( $column_defaults as $link_index => $link_defaults ) {
				$link_raw = isset( $column_raw[ $link_index ] ) && is_array( $column_raw[ $link_index ] ) ? $column_raw[ $link_index ] : array();
				$link_current = isset( $current['link_columns'][ $column_index ][ $link_index ] ) && is_array( $current['link_columns'][ $column_index ][ $link_index ] ) ? $current['link_columns'][ $column_index ][ $link_index ] : $link_defaults;

				$data['link_columns'][ $column_index ][ $link_index ] = array(
					'label' => isset( $link_raw['label'] ) && ! is_array( $link_raw['label'] ) ? sanitize_text_field( $link_raw['label'] ) : $link_defaults['label'],
					'url'   => isset( $link_raw['url'] ) && ! is_array( $link_raw['url'] ) ? esc_url_raw( $link_raw['url'] ) : $link_current['url'],
				);
			}
		}
	}

	if ( isset( $raw['social_items'] ) && is_array( $raw['social_items'] ) ) {
		$data['social_items'] = $defaults['social_items'];

		foreach ( $defaults['social_items'] as $index => $item_defaults ) {
			$item_raw = isset( $raw['social_items'][ $index ] ) && is_array( $raw['social_items'][ $index ] ) ? $raw['social_items'][ $index ] : array();

			$data['social_items'][ $index ] = array(
				'label' => isset( $item_raw['label'] ) && ! is_array( $item_raw['label'] ) ? sanitize_text_field( $item_raw['label'] ) : $item_defaults['label'],
				'url'   => isset( $item_raw['url'] ) && ! is_array( $item_raw['url'] ) ? esc_url_raw( $item_raw['url'] ) : $item_defaults['url'],
			);
		}
	}

	return $data;
}

/**
 * Save Header edit page values.
 */
function interior_save_header_settings() {
	if ( ! current_user_can( 'manage_options' ) || ! isset( $_POST['interior_header_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['interior_header_nonce'] ) ), 'interior_save_header_settings' ) ) {
		wp_die( esc_html__( 'You are not allowed to save these settings.', 'interior' ) );
	}

	$raw = isset( $_POST['header'] ) && is_array( $_POST['header'] ) ? wp_unslash( $_POST['header'] ) : array();
	update_option( 'interior_header_settings', interior_sanitize_theme_settings( $raw, interior_get_header_defaults() ) );

	wp_safe_redirect( add_query_arg( 'updated', 'true', wp_get_referer() ? wp_get_referer() : admin_url( 'themes.php?page=interior-header-edit' ) ) );
	exit;
}
add_action( 'admin_post_interior_save_header_settings', 'interior_save_header_settings' );

/**
 * Save Footer edit page values.
 */
function interior_save_footer_settings() {
	if ( ! current_user_can( 'manage_options' ) || ! isset( $_POST['interior_footer_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['interior_footer_nonce'] ) ), 'interior_save_footer_settings' ) ) {
		wp_die( esc_html__( 'You are not allowed to save these settings.', 'interior' ) );
	}

	$raw = isset( $_POST['footer'] ) && is_array( $_POST['footer'] ) ? wp_unslash( $_POST['footer'] ) : array();
	update_option( 'interior_footer_settings', interior_sanitize_footer_settings( $raw ) );

	wp_safe_redirect( add_query_arg( 'updated', 'true', wp_get_referer() ? wp_get_referer() : admin_url( 'themes.php?page=interior-footer-edit' ) ) );
	exit;
}
add_action( 'admin_post_interior_save_footer_settings', 'interior_save_footer_settings' );

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
	$project_gallery_ids_raw = get_post_meta( $post->ID, '_interior_project_gallery_ids', true );
	$project_gallery_ids     = is_array( $project_gallery_ids_raw ) ? $project_gallery_ids_raw : array_filter( array_map( 'absint', explode( ',', (string) $project_gallery_ids_raw ) ) );
	$project_video_urls      = get_post_meta( $post->ID, '_interior_project_video_urls', true );
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
	<?php if ( 'interior_project' === $post->post_type ) : ?>
		<hr>
		<p>
			<label><strong><?php esc_html_e( 'Project Images', 'interior' ); ?></strong></label><br>
			<input type="hidden" id="interior_project_gallery_ids" name="interior_project_gallery_ids" value="<?php echo esc_attr( implode( ',', $project_gallery_ids ) ); ?>">
			<button type="button" class="button button-primary" id="interior_upload_project_gallery"><?php esc_html_e( 'Select / Upload Project Images', 'interior' ); ?></button>
			<button type="button" class="button" id="interior_clear_project_gallery" style="<?php echo ! empty( $project_gallery_ids ) ? '' : 'display:none;'; ?>"><?php esc_html_e( 'Clear Project Images', 'interior' ); ?></button>
		</p>
		<div id="interior_project_gallery_preview" style="display:flex;flex-wrap:wrap;gap:10px;margin:10px 0 18px;">
			<?php foreach ( $project_gallery_ids as $project_gallery_id ) : ?>
				<?php $project_gallery_thumb = wp_get_attachment_image_url( (int) $project_gallery_id, 'thumbnail' ); ?>
				<?php if ( $project_gallery_thumb ) : ?>
					<img src="<?php echo esc_url( $project_gallery_thumb ); ?>" alt="" style="max-width:110px;height:auto;border:1px solid #ddd;">
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<p>
			<label for="interior_project_video_urls"><strong><?php esc_html_e( 'Project Videos (YouTube Link)', 'interior' ); ?></strong></label><br>
			<textarea id="interior_project_video_urls" name="interior_project_video_urls" rows="4" class="large-text" placeholder="https://www.youtube.com/watch?v=..."><?php echo esc_textarea( $project_video_urls ); ?></textarea>
			<span class="description"><?php esc_html_e( 'Add one YouTube link per line.', 'interior' ); ?></span>
		</p>
	<?php endif; ?>
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

	if ( 'interior_project' === get_post_type( $post_id ) ) {
		$gallery_ids_raw = isset( $_POST['interior_project_gallery_ids'] ) ? sanitize_text_field( wp_unslash( $_POST['interior_project_gallery_ids'] ) ) : '';
		$gallery_ids     = array_filter( array_map( 'absint', explode( ',', $gallery_ids_raw ) ) );
		update_post_meta( $post_id, '_interior_project_gallery_ids', $gallery_ids );

		$video_urls = isset( $_POST['interior_project_video_urls'] ) ? sanitize_textarea_field( wp_unslash( $_POST['interior_project_video_urls'] ) ) : '';
		update_post_meta( $post_id, '_interior_project_video_urls', $video_urls );
	}
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

	if ( ! $screen || ( ! in_array( $screen->post_type, array( 'interior_service', 'interior_project' ), true ) && ! interior_is_home_editor_page( $post ) && ! interior_is_template_editor_page( $post, 'page-about.php', 'about-us' ) && ! interior_is_template_editor_page( $post, 'page-about.php', 'about' ) && ! interior_is_template_editor_page( $post, 'page-contact.php', 'contact' ) && ! interior_is_template_editor_page( $post, 'page-downloads.php', 'downloads' ) && ( ! function_exists( 'interior_is_media_editor_page' ) || ! interior_is_media_editor_page( $post ) ) ) ) {
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
			$('#interior_upload_project_gallery').on('click', function(e){
				e.preventDefault();
				var galleryFrame = wp.media({title:'Select Project Images', button:{text:'Use Images'}, multiple:true});
				galleryFrame.on('select', function(){
					var selection = galleryFrame.state().get('selection');
					var ids = [];
					var preview = $('#interior_project_gallery_preview');
					preview.empty();
					selection.each(function(attachment){
						var item = attachment.toJSON();
						ids.push(item.id);
						preview.append('<img src=\"' + (item.sizes && item.sizes.thumbnail ? item.sizes.thumbnail.url : item.url) + '\" alt=\"\" style=\"max-width:110px;height:auto;border:1px solid #ddd;\" />');
					});
					$('#interior_project_gallery_ids').val(ids.join(','));
					$('#interior_clear_project_gallery').show();
				});
				galleryFrame.open();
			});
			$('#interior_clear_project_gallery').on('click', function(e){
				e.preventDefault();
				$('#interior_project_gallery_ids').val('');
				$('#interior_project_gallery_preview').empty();
				$(this).hide();
			});
		});"
	);
}
add_action( 'admin_enqueue_scripts', 'interior_admin_media_picker' );

/**
 * Return project gallery image data.
 *
 * @param int $project_id Project ID.
 * @return array
 */
function interior_get_project_gallery_items( $project_id ) {
	$gallery_ids = get_post_meta( $project_id, '_interior_project_gallery_ids', true );
	$gallery_ids = is_array( $gallery_ids ) ? $gallery_ids : array_filter( array_map( 'absint', explode( ',', (string) $gallery_ids ) ) );
	$items       = array();

	foreach ( $gallery_ids as $image_id ) {
		$image_url = wp_get_attachment_image_url( (int) $image_id, 'large' );
		$full_url  = wp_get_attachment_image_url( (int) $image_id, 'full' );

		if ( ! $image_url ) {
			continue;
		}

		$items[] = array(
			'id'    => (int) $image_id,
			'image' => $image_url,
			'full'  => $full_url ? $full_url : $image_url,
			'title' => get_the_title( $image_id ),
		);
	}

	return $items;
}

/**
 * Convert a YouTube URL into an embeddable URL.
 *
 * @param string $url Video URL.
 * @return string
 */
function interior_get_youtube_embed_url( $url ) {
	$url = trim( $url );

	if ( '' === $url ) {
		return '';
	}

	if ( preg_match( '~(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{6,})~', $url, $matches ) ) {
		return 'https://www.youtube.com/embed/' . $matches[1];
	}

	return '';
}

/**
 * Return project YouTube embed URLs.
 *
 * @param int $project_id Project ID.
 * @return array
 */
function interior_get_project_video_embeds( $project_id ) {
	$raw_urls = get_post_meta( $project_id, '_interior_project_video_urls', true );
	$urls     = preg_split( '/\r\n|\r|\n/', (string) $raw_urls );
	$embeds   = array();

	foreach ( $urls as $url ) {
		$embed = interior_get_youtube_embed_url( $url );
		if ( $embed ) {
			$embeds[] = $embed;
		}
	}

	return array_values( array_unique( $embeds ) );
}

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
 * Default home newsletter section values.
 *
 * @return array
 */
function interior_get_home_newsletter_defaults() {
	return array(
		'subtitle'          => 'Subscribe to the newsletter',
		'title'             => 'Join <span>our newsletter <br> stay</span> up to date',
		'description'       => 'Join our newsletter. Learn something new, gain access to exclusive content, <br> and stay informed with the latest updates in the industry.',
		'placeholder'       => 'Email address..',
		'success_message'   => 'Thank you for subscribing.',
		'duplicate_message' => 'You are already subscribed.',
		'shape_image_id'    => 0,
		'shape_url'         => get_template_directory_uri() . '/assets/img/shapes/newsletter-shape.png',
	);
}

/**
 * Get saved home newsletter section values.
 *
 * @param int $page_id Optional page ID.
 * @return array
 */
function interior_get_home_newsletter_data( $page_id = 0 ) {
	$defaults = interior_get_home_newsletter_defaults();
	$saved    = get_option( 'interior_home_newsletter', array() );

	if ( ( ! is_array( $saved ) || empty( $saved ) ) && $page_id ) {
		$legacy = get_post_meta( $page_id, '_interior_home_newsletter', true );
		if ( is_array( $legacy ) && ! empty( $legacy ) ) {
			$saved = $legacy;
			update_option( 'interior_home_newsletter', $saved );
		}
	}

	return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
}

/**
 * Handle newsletter subscription requests.
 */
function interior_handle_newsletter_subscription() {
	if ( ! check_ajax_referer( 'interior_newsletter_subscribe', 'nonce', false ) ) {
		wp_send_json_error(
			array(
				'message' => esc_html__( 'Security check failed. Please refresh the page and try again.', 'interior' ),
			),
			403
		);
	}

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

	if ( ! is_email( $email ) ) {
		wp_send_json_error(
			array(
				'message' => esc_html__( 'Please enter a valid email address.', 'interior' ),
			),
			400
		);
	}

	$newsletter = interior_get_home_newsletter_data();
	$email_key   = strtolower( $email );
	$subscribers = get_option( 'interior_newsletter_subscribers', array() );
	$subscribers = is_array( $subscribers ) ? $subscribers : array();

	if ( isset( $subscribers[ $email_key ] ) ) {
		wp_send_json_success(
			array(
				'message' => $newsletter['duplicate_message'],
			)
		);
	}

	$subscribers[ $email_key ] = array(
		'email'      => $email,
		'subscribed' => current_time( 'mysql' ),
		'ip'         => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
	);

	ksort( $subscribers );
	update_option( 'interior_newsletter_subscribers', $subscribers, false );

	$admin_email = get_option( 'admin_email' );
	if ( is_email( $admin_email ) ) {
		wp_mail(
			$admin_email,
			sprintf(
				/* translators: %s: site name. */
				esc_html__( '[%s] New newsletter subscriber', 'interior' ),
				wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES )
			),
			sprintf(
				/* translators: %s: subscriber email. */
				esc_html__( 'A new visitor subscribed to the newsletter: %s', 'interior' ),
				$email
			)
		);
	}

	wp_send_json_success(
		array(
			'message' => $newsletter['success_message'],
		)
	);
}
add_action( 'wp_ajax_interior_newsletter_subscribe', 'interior_handle_newsletter_subscription' );
add_action( 'wp_ajax_nopriv_interior_newsletter_subscribe', 'interior_handle_newsletter_subscription' );

/**
 * Print lightweight newsletter form styles.
 */
function interior_print_newsletter_styles() {
	?>
	<style>
		.newsletter-wrap .newsletter-form .interior-newsletter-message {
			font-size: 14px;
			line-height: 1.4;
			margin: 12px 0 0;
			min-height: 20px;
			position: absolute;
			left: 0;
			right: 0;
			text-align: left;
			top: 100%;
		}
		.newsletter-wrap .newsletter-form .interior-newsletter-message.is-success {
			color: #2f7d32;
		}
		.newsletter-wrap .newsletter-form .interior-newsletter-message.is-error {
			color: #b42318;
		}
		.newsletter-wrap .newsletter-form button:disabled {
			cursor: wait;
			opacity: .7;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'interior_print_newsletter_styles' );

/**
 * Print frontend newsletter AJAX script.
 */
function interior_print_newsletter_script() {
	?>
	<script>
		window.interiorNewsletter = {
			ajaxUrl: <?php echo wp_json_encode( admin_url( 'admin-ajax.php' ) ); ?>,
			nonce: <?php echo wp_json_encode( wp_create_nonce( 'interior_newsletter_subscribe' ) ); ?>,
			errorMessage: <?php echo wp_json_encode( esc_html__( 'Something went wrong. Please try again.', 'interior' ) ); ?>
		};
		document.addEventListener('submit', function(event) {
			var form = event.target.closest('.interior-newsletter-form');
			if (!form || !window.interiorNewsletter) {
				return;
			}

			event.preventDefault();

			var message = form.querySelector('.interior-newsletter-message');
			var button = form.querySelector('button[type="submit"]');
			var data = new FormData(form);
			data.set('action', 'interior_newsletter_subscribe');
			data.set('nonce', window.interiorNewsletter.nonce);

			if (message) {
				message.textContent = '';
				message.classList.remove('is-success', 'is-error');
			}
			if (button) {
				button.disabled = true;
			}

			fetch(window.interiorNewsletter.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				body: data
			})
				.then(function(response) {
					return response.json();
				})
				.then(function(response) {
					var text = response && response.data && response.data.message ? response.data.message : window.interiorNewsletter.errorMessage;
					if (message) {
						message.textContent = text;
						message.classList.add(response && response.success ? 'is-success' : 'is-error');
					}
					if (response && response.success) {
						form.reset();
					}
				})
				.catch(function() {
					if (message) {
						message.textContent = window.interiorNewsletter.errorMessage;
						message.classList.add('is-error');
					}
				})
				.finally(function() {
					if (button) {
						button.disabled = false;
					}
				});
		});
	</script>
	<?php
}
add_action( 'wp_footer', 'interior_print_newsletter_script', 30 );

/**
 * Add a simple admin page for newsletter subscribers.
 */
function interior_register_newsletter_subscribers_page() {
	add_submenu_page(
		'tools.php',
		esc_html__( 'Newsletter Subscribers', 'interior' ),
		esc_html__( 'Newsletter Subscribers', 'interior' ),
		'manage_options',
		'interior-newsletter-subscribers',
		'interior_render_newsletter_subscribers_page'
	);
}
add_action( 'admin_menu', 'interior_register_newsletter_subscribers_page' );

/**
 * Render newsletter subscribers admin page.
 */
function interior_render_newsletter_subscribers_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$subscribers = get_option( 'interior_newsletter_subscribers', array() );
	$subscribers = is_array( $subscribers ) ? $subscribers : array();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Newsletter Subscribers', 'interior' ); ?></h1>
		<p><?php echo esc_html( sprintf( __( '%d subscriber(s) saved.', 'interior' ), count( $subscribers ) ) ); ?></p>
		<table class="widefat striped">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Email', 'interior' ); ?></th>
					<th><?php esc_html_e( 'Subscribed On', 'interior' ); ?></th>
					<th><?php esc_html_e( 'IP Address', 'interior' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( empty( $subscribers ) ) : ?>
					<tr>
						<td colspan="3"><?php esc_html_e( 'No subscribers yet.', 'interior' ); ?></td>
					</tr>
				<?php else : ?>
					<?php foreach ( array_reverse( $subscribers ) as $subscriber ) : ?>
						<tr>
							<td><?php echo esc_html( isset( $subscriber['email'] ) ? $subscriber['email'] : '' ); ?></td>
							<td><?php echo esc_html( isset( $subscriber['subscribed'] ) ? $subscriber['subscribed'] : '' ); ?></td>
							<td><?php echo esc_html( isset( $subscriber['ip'] ) ? $subscriber['ip'] : '' ); ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
	<?php
}

/**
 * Return the Media page ID used for gallery content.
 *
 * @return int
 */
function interior_get_media_page_id() {
	$media_page = get_page_by_path( 'media' );

	if ( $media_page && 'publish' === $media_page->post_status ) {
		return (int) $media_page->ID;
	}

	$pages = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'page-media.php',
			'number'     => 1,
		)
	);

	return ! empty( $pages ) ? (int) $pages[0]->ID : 0;
}

/**
 * Return gallery image data from the Media page.
 *
 * @return array
 */
function interior_get_media_gallery_items() {
	$media_id = interior_get_media_page_id();

	if ( ! $media_id ) {
		return array();
	}

	$gallery_ids = get_post_meta( $media_id, '_media_gallery_ids', true );
	$gallery_ids = is_array( $gallery_ids ) ? $gallery_ids : array_filter( array_map( 'intval', explode( ',', (string) $gallery_ids ) ) );
	$items       = array();

	foreach ( $gallery_ids as $image_id ) {
		$image_url = wp_get_attachment_image_url( (int) $image_id, 'large' );
		$full_url  = wp_get_attachment_image_url( (int) $image_id, 'full' );

		if ( ! $image_url ) {
			continue;
		}

		$items[] = array(
			'id'    => (int) $image_id,
			'image' => $image_url,
			'full'  => $full_url ? $full_url : $image_url,
			'title' => get_the_title( $image_id ),
		);
	}

	return $items;
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
 * Return the admin edit link for the Home page, optionally targeting a tab.
 *
 * @param string $tab Home tab key.
 * @return string
 */
function interior_get_home_editor_link( $tab = '' ) {
	$page_id = (int) get_option( 'page_on_front' );

	if ( ! $page_id ) {
		$home_page = get_page_by_path( 'home' );
		$page_id   = $home_page ? (int) $home_page->ID : 0;
	}

	if ( ! $page_id ) {
		$pages = get_pages(
			array(
				'meta_key'   => '_wp_page_template',
				'meta_value' => 'page-front.php',
				'number'     => 1,
			)
		);
		$page_id = ! empty( $pages ) ? (int) $pages[0]->ID : 0;
	}

	$link = $page_id ? get_edit_post_link( $page_id, 'raw' ) : '';

	if ( $link && $tab ) {
		$link .= '#interior-home-' . sanitize_key( $tab );
	}

	return $link;
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
				<?php elseif ( 'gallery' === $key ) : ?>
					<?php
					$media_page_id = interior_get_media_page_id();
					$media_edit    = $media_page_id ? get_edit_post_link( $media_page_id ) : '';
					$media_link    = $media_page_id ? get_permalink( $media_page_id ) : '';
					?>
					<p class="description"><?php esc_html_e( 'The homepage gallery uses images selected on the Media page. Update the Media page gallery to change these images.', 'interior' ); ?></p>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><?php esc_html_e( 'Media Page Gallery', 'interior' ); ?></th>
							<td>
								<?php if ( $media_edit ) : ?>
									<a class="button button-primary" href="<?php echo esc_url( $media_edit ); ?>"><?php esc_html_e( 'Edit Media Page Gallery', 'interior' ); ?></a>
									<?php if ( $media_link ) : ?>
										<a class="button" href="<?php echo esc_url( $media_link ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'View Media Page', 'interior' ); ?></a>
									<?php endif; ?>
								<?php else : ?>
									<p><?php esc_html_e( 'Create a page with the slug "media" or assign the Media template to a page to manage gallery images.', 'interior' ); ?></p>
								<?php endif; ?>
							</td>
						</tr>
					</table>
				<?php elseif ( 'newsletter' === $key ) : ?>
					<?php
					$newsletter     = interior_get_home_newsletter_data( $post->ID );
					$shape_image_id  = (int) $newsletter['shape_image_id'];
					$shape_image_url = $shape_image_id ? wp_get_attachment_image_url( $shape_image_id, 'medium' ) : $newsletter['shape_url'];
					?>
					<p class="description"><?php esc_html_e( 'Edit the homepage newsletter section content here.', 'interior' ); ?></p>
					<table class="form-table" role="presentation">
						<tr>
							<th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th>
							<td><input type="text" class="large-text" name="interior_home_newsletter[subtitle]" value="<?php echo esc_attr( $newsletter['subtitle'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="2" name="interior_home_newsletter[title]"><?php echo esc_textarea( $newsletter['title'] ); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th>
							<td><textarea class="large-text" rows="3" name="interior_home_newsletter[description]"><?php echo esc_textarea( $newsletter['description'] ); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Email Placeholder', 'interior' ); ?></th>
							<td><input type="text" class="large-text" name="interior_home_newsletter[placeholder]" value="<?php echo esc_attr( $newsletter['placeholder'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Success Message', 'interior' ); ?></th>
							<td><input type="text" class="large-text" name="interior_home_newsletter[success_message]" value="<?php echo esc_attr( $newsletter['success_message'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Already Subscribed Message', 'interior' ); ?></th>
							<td><input type="text" class="large-text" name="interior_home_newsletter[duplicate_message]" value="<?php echo esc_attr( $newsletter['duplicate_message'] ); ?>"></td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Shape Image', 'interior' ); ?></th>
							<td>
								<input type="hidden" id="interior_newsletter_shape_image_id" name="interior_home_newsletter[shape_image_id]" value="<?php echo esc_attr( $shape_image_id ); ?>">
								<img id="interior_newsletter_shape_image_preview" src="<?php echo esc_url( $shape_image_url ); ?>" alt="" style="<?php echo $shape_image_url ? '' : 'display:none;'; ?>max-width:180px;height:auto;margin:0 0 10px;">
								<br>
								<button type="button" class="button interior-slider-upload" data-target="#interior_newsletter_shape_image_id" data-preview="#interior_newsletter_shape_image_preview"><?php esc_html_e( 'Select Image', 'interior' ); ?></button>
								<button type="button" class="button interior-slider-remove" data-target="#interior_newsletter_shape_image_id" data-preview="#interior_newsletter_shape_image_preview"><?php esc_html_e( 'Remove Image', 'interior' ); ?></button>
							</td>
						</tr>
					</table>
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
			function activateTab(tab) {
				const target = document.getElementById(tab);
				const button = document.querySelector('.interior-home-tab-btn[data-tab="' + tab + '"]');
				if (!target || !button) {
					return;
				}
				buttons.forEach(function(item) { item.classList.remove('active'); });
				contents.forEach(function(item) { item.classList.remove('active'); });
				button.classList.add('active');
				target.classList.add('active');
			}
			buttons.forEach(function(button) {
				button.addEventListener('click', function(e) {
					e.preventDefault();
					activateTab(this.getAttribute('data-tab'));
				});
			});
			if (window.location.hash) {
				activateTab(window.location.hash.substring(1));
			}
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
		if ( in_array( $key, array( 'slider', 'services', 'about', 'features', 'counter', 'process', 'projects', 'testimonial', 'sponsors', 'video', 'gallery', 'newsletter' ), true ) ) {
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

	if ( isset( $_POST['interior_home_newsletter'] ) && is_array( $_POST['interior_home_newsletter'] ) ) {
		$newsletter_raw = wp_unslash( $_POST['interior_home_newsletter'] );
		$defaults       = interior_get_home_newsletter_defaults();
		$newsletter     = array(
			'subtitle'       => isset( $newsletter_raw['subtitle'] ) ? sanitize_text_field( $newsletter_raw['subtitle'] ) : $defaults['subtitle'],
			'title'          => isset( $newsletter_raw['title'] ) ? wp_kses_post( $newsletter_raw['title'] ) : $defaults['title'],
			'description'    => isset( $newsletter_raw['description'] ) ? wp_kses_post( $newsletter_raw['description'] ) : $defaults['description'],
			'placeholder'    => isset( $newsletter_raw['placeholder'] ) ? sanitize_text_field( $newsletter_raw['placeholder'] ) : $defaults['placeholder'],
			'success_message'   => isset( $newsletter_raw['success_message'] ) ? sanitize_text_field( $newsletter_raw['success_message'] ) : $defaults['success_message'],
			'duplicate_message' => isset( $newsletter_raw['duplicate_message'] ) ? sanitize_text_field( $newsletter_raw['duplicate_message'] ) : $defaults['duplicate_message'],
			'shape_image_id'    => isset( $newsletter_raw['shape_image_id'] ) ? absint( $newsletter_raw['shape_image_id'] ) : $defaults['shape_image_id'],
			'shape_url'         => $defaults['shape_url'],
		);

		update_option( 'interior_home_newsletter', $newsletter );
		update_post_meta( $post_id, '_interior_home_newsletter', $newsletter );
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
	if ( in_array( $section, array( 'services', 'about', 'features', 'counter', 'process', 'projects', 'testimonial', 'sponsors', 'video', 'gallery', 'newsletter' ), true ) ) {
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
 * Default structured About page values.
 *
 * @return array
 */
function interior_get_about_page_defaults() {
	$theme_uri = get_template_directory_uri();

	return array(
		'page_header' => array(
			'title'           => 'About us',
			'breadcrumb_home' => 'Home',
			'breadcrumb_url'  => home_url( '/' ),
			'breadcrumb_text' => 'About Us',
			'bg_image_id'     => 0,
			'bg_image_url'    => $theme_uri . '/assets/img/bg-img/page-header-bg.png',
		),
		'about_intro' => array(
			'subtitle'       => 'Started In 1991',
			'title'          => 'We Shape <span>Interior Designs, <br> Crafting Timeless</span> and Inspiring <br> Spaces',
			'counter_number' => '26',
			'counter_text'   => 'Years of <br> experience',
			'description'    => 'We believe that every space has the power to inspire, and that great design brings. Our mission is to craft environments that stir creativity, evoke emotion, and reflect the essence of those who inhabit them.',
			'button_text'    => 'More About Us',
			'button_url'     => home_url( '/about/' ),
			'counter_image_id' => 0,
			'counter_image_url' => $theme_uri . '/assets/img/images/about-img-2.png',
			'main_image_id'  => 0,
			'main_image_url' => $theme_uri . '/assets/img/images/about-img-3.png',
		),
		'video' => array(
			'video_url'   => 'https://youtu.be/JwC-Qx1lJso',
			'button_text' => 'play',
			'bg_image_id' => 0,
			'bg_image_url' => $theme_uri . '/assets/img/bg-img/video-bg-3.png',
		),
		'history' => array(
			'background_text' => 'antra',
			'subtitle'        => 'our History',
			'title'           => 'Our history <span>is full of <br> interesting</span> stages <br> and events.',
			'element_image_id' => 0,
			'element_image_url' => $theme_uri . '/assets/img/images/counter-img-1.png',
			'items'           => array_fill(
				0,
				6,
				array(
					'year'        => '2025',
					'description' => 'Celebrates 15 years with a retrospective showcase of the company projects and milestones.',
					'image_id'    => 0,
					'image_url'   => $theme_uri . '/assets/img/images/history-img-1.png',
				)
			),
		),
		'process' => interior_get_home_process_defaults(),
		'awards' => array(
			'subtitle' => 'Award & achievement',
			'title'    => 'Design That <span>Speaks Our <br> Industry</span> Awards',
			'items'    => array(
				array( 'year' => '2025', 'title' => 'Best Residential Design', 'category' => 'Interior Design', 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/images/award-img-1.png' ),
				array( 'year' => '2024', 'title' => 'Top Commercial Design', 'category' => 'Architecture', 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/images/award-img-2.jpg' ),
				array( 'year' => '2023', 'title' => 'Sustainable Design Award', 'category' => 'Community Center', 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/images/award-img-3.jpg' ),
				array( 'year' => '2022', 'title' => 'Creative Office Space Award', 'category' => 'Corporation Building', 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/images/award-img-4.jpg' ),
				array( 'year' => '2020', 'title' => 'Emerging Designer of the Year', 'category' => 'Interior Design', 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/images/award-img-5.jpg' ),
			),
		),
		'gallery' => array(
			'subtitle' => 'our gallery',
			'title'    => 'Interior <br>design',
			'description' => 'Lorem ipsum dolor sit amet consectetur. <br> Magna nunc porttitor convallis faucibus <br> laoreet.',
			'bg_image_id' => 0,
			'bg_image_url' => $theme_uri . '/assets/img/bg-img/gallary-bg-1.png',
			'items'    => array(
				array( 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/images/gallary-img-1.png', 'link_url' => home_url( '/about/' ) ),
				array( 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/images/gallary-img-2.png', 'link_url' => home_url( '/about/' ) ),
				array( 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/images/gallary-img-3.png', 'link_url' => home_url( '/about/' ) ),
				array( 'image_id' => 0, 'image_url' => $theme_uri . '/assets/img/images/gallary-img-4.png', 'link_url' => home_url( '/about/' ) ),
			),
		),
		'testimonial' => interior_get_home_testimonial_defaults(),
		'sponsors'    => interior_get_home_sponsors_defaults(),
		'newsletter'  => interior_get_home_newsletter_defaults(),
	);
}

/**
 * Get structured About page values.
 *
 * @param int $page_id Page ID.
 * @return array
 */
function interior_get_about_page_data( $page_id = 0 ) {
	$page_id  = $page_id ? $page_id : get_queried_object_id();
	$defaults = interior_get_about_page_defaults();
	$saved    = $page_id ? get_post_meta( $page_id, '_interior_about_page_data', true ) : array();
	$saved    = is_array( $saved ) ? $saved : array();
	$data     = wp_parse_args( $saved, $defaults );

	foreach ( $defaults as $section => $section_defaults ) {
		$data[ $section ] = wp_parse_args( isset( $saved[ $section ] ) && is_array( $saved[ $section ] ) ? $saved[ $section ] : array(), $section_defaults );
		if ( isset( $section_defaults['items'] ) && is_array( $section_defaults['items'] ) ) {
			$data[ $section ]['items'] = isset( $saved[ $section ]['items'] ) && is_array( $saved[ $section ]['items'] ) ? $saved[ $section ]['items'] : array();
			foreach ( $section_defaults['items'] as $index => $item_defaults ) {
				$data[ $section ]['items'][ $index ] = wp_parse_args( isset( $data[ $section ]['items'][ $index ] ) && is_array( $data[ $section ]['items'][ $index ] ) ? $data[ $section ]['items'][ $index ] : array(), $item_defaults );
			}
		}
	}

	return $data;
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
 * Default structured Contact page values.
 *
 * @return array
 */
function interior_get_contact_page_defaults() {
	return array(
		'page_header' => array(
			'title'           => 'Contact Us',
			'breadcrumb_home' => 'Home',
			'breadcrumb_url'  => home_url( '/' ),
			'breadcrumb_text' => 'Contact Us',
			'bg_image_id'     => 0,
			'bg_image_url'    => get_template_directory_uri() . '/assets/img/bg-img/page-header-bg.png',
		),
		'contact'     => array(
			'subtitle'            => 'get in touch',
			'title'               => 'Have a Project in <span>Mind? Let&rsquo;s <br> Make</span> It Happen',
			'address_label'       => 'Address',
			'address_text'        => '5609 E Sprague Ave, Spokane <br> Valley, WA 99212, USA',
			'support_label'       => 'Support',
			'phone'               => '+(084) 456-0789',
			'phone_url'           => 'tel:+0844560789',
			'email'               => 'support@example.com',
			'email_url'           => 'mailto:support@example.com',
			'image_id'            => 0,
			'image_url'           => get_template_directory_uri() . '/assets/img/images/contact-img-1.png',
			'cf7_shortcode'       => '',
		),
		'map'         => array(
			'iframe_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8826.923787362664!2d-118.27754354757262!3d34.03471770929568!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c75ddc27da13%3A0xe22fdf6f254608f4!2sLos%20Angeles%2C%20California%2C%20Hoa%20K%E1%BB%B3!5e0!3m2!1svi!2s!4v1566525118697!5m2!1svi!2s',
			'height'     => '620',
		),
	);
}

/**
 * Get structured Contact page values.
 *
 * @param int $page_id Page ID.
 * @return array
 */
function interior_get_contact_page_data( $page_id = 0 ) {
	$page_id  = $page_id ? $page_id : get_queried_object_id();
	$defaults = interior_get_contact_page_defaults();
	$saved    = $page_id ? get_post_meta( $page_id, '_interior_contact_page_data', true ) : array();
	$saved    = is_array( $saved ) ? $saved : array();
	$data     = wp_parse_args( $saved, $defaults );

	foreach ( $defaults as $section => $section_defaults ) {
		$data[ $section ] = wp_parse_args( isset( $saved[ $section ] ) && is_array( $saved[ $section ] ) ? $saved[ $section ] : array(), $section_defaults );
	}

	return $data;
}

/**
 * Downloads page section keys and labels.
 *
 * @return array
 */
function interior_get_downloads_section_tabs() {
	return array(
		'page_header' => esc_html__( 'Page Header', 'interior' ),
		'uploads'     => esc_html__( 'Uploads', 'interior' ),
	);
}

/**
 * Default structured Downloads page values.
 *
 * @return array
 */
function interior_get_downloads_page_defaults() {
	return array(
		'page_header' => array(
			'title'           => 'Downloads',
			'breadcrumb_home' => 'Home',
			'breadcrumb_url'  => home_url( '/' ),
			'breadcrumb_text' => 'Downloads',
			'bg_image_id'     => 0,
			'bg_image_url'    => get_template_directory_uri() . '/assets/img/bg-img/page-header-bg.png',
		),
		'uploads'     => array(
			'file_ids' => array(),
		),
	);
}

/**
 * Get structured Downloads page values.
 *
 * @param int $page_id Page ID.
 * @return array
 */
function interior_get_downloads_page_data( $page_id = 0 ) {
	$page_id  = $page_id ? $page_id : get_queried_object_id();
	$defaults = interior_get_downloads_page_defaults();
	$saved    = $page_id ? get_post_meta( $page_id, '_interior_downloads_page_data', true ) : array();
	$saved    = is_array( $saved ) ? $saved : array();
	$data     = wp_parse_args( $saved, $defaults );

	foreach ( $defaults as $section => $section_defaults ) {
		$data[ $section ] = wp_parse_args( isset( $saved[ $section ] ) && is_array( $saved[ $section ] ) ? $saved[ $section ] : array(), $section_defaults );
	}

	$data['uploads']['file_ids'] = isset( $data['uploads']['file_ids'] ) && is_array( $data['uploads']['file_ids'] ) ? array_filter( array_map( 'absint', $data['uploads']['file_ids'] ) ) : array();

	return $data;
}

/**
 * Get downloads page file attachment data.
 *
 * @param int $page_id Page ID.
 * @return array
 */
function interior_get_downloads_files( $page_id = 0 ) {
	$data  = interior_get_downloads_page_data( $page_id );
	$files = array();

	foreach ( $data['uploads']['file_ids'] as $file_id ) {
		$url = wp_get_attachment_url( $file_id );

		if ( ! $url ) {
			continue;
		}

		$file_path = get_attached_file( $file_id );

		$files[] = array(
			'id'    => $file_id,
			'title' => get_the_title( $file_id ),
			'url'   => $url,
			'type'  => get_post_mime_type( $file_id ),
			'size'  => $file_path && file_exists( $file_path ) ? size_format( (int) filesize( $file_path ) ) : '',
		);
	}

	return $files;
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

	if ( interior_is_template_editor_page( $post, 'page-downloads.php', 'downloads' ) ) {
		add_meta_box(
			'interior_downloads_sections',
			esc_html__( 'Downloads Page Sections', 'interior' ),
			'interior_render_downloads_metabox',
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
 * Render an About page image picker row.
 *
 * @param string $name      Field name.
 * @param string $id_base   Field ID base.
 * @param int    $image_id  Attachment ID.
 * @param string $fallback  Fallback image URL.
 * @param string $label     Field label.
 */
function interior_render_about_image_field( $name, $id_base, $image_id, $fallback, $label ) {
	$image_id  = (int) $image_id;
	$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : $fallback;
	?>
	<tr>
		<th scope="row"><?php echo esc_html( $label ); ?></th>
		<td>
			<input type="hidden" id="<?php echo esc_attr( $id_base ); ?>_image_id" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $image_id ); ?>">
			<img id="<?php echo esc_attr( $id_base ); ?>_image_preview" class="interior-page-image-preview" src="<?php echo esc_url( $image_url ); ?>" alt="" style="<?php echo $image_url ? '' : 'display:none;'; ?>">
			<button type="button" class="button interior-about-upload" data-target="#<?php echo esc_attr( $id_base ); ?>_image_id" data-preview="#<?php echo esc_attr( $id_base ); ?>_image_preview"><?php esc_html_e( 'Select Image', 'interior' ); ?></button>
			<button type="button" class="button interior-about-remove" data-target="#<?php echo esc_attr( $id_base ); ?>_image_id" data-preview="#<?php echo esc_attr( $id_base ); ?>_image_preview"><?php esc_html_e( 'Remove Image', 'interior' ); ?></button>
		</td>
	</tr>
	<?php
}

/**
 * Render About sections metabox.
 *
 * @param WP_Post $post Current page.
 */
function interior_render_about_metabox( $post ) {
	$data  = interior_get_about_page_data( $post->ID );
	$tabs  = interior_get_about_section_tabs();
	$first = true;

	wp_nonce_field( 'interior_about_page', 'interior_about_page_field' );
	?>
	<style>
		.interior-page-tabs-nav { display:flex; flex-wrap:wrap; border-bottom:2px solid #ddd; margin:16px 0 20px; }
		.interior-page-tab-btn { background:#fff; border:0; border-bottom:3px solid transparent; color:#555; cursor:pointer; font-weight:600; padding:10px 14px; }
		.interior-page-tab-btn.active { border-bottom-color:#2271b1; color:#1d2327; }
		.interior-page-tab-content { display:none; }
		.interior-page-tab-content.active { display:block; }
		.interior-page-tab-content h3 { margin-top:24px; }
		.interior-page-image-preview { display:block; max-width:220px; height:auto; margin:0 0 10px; }
	</style>
	<div class="interior-page-tabs">
		<div class="interior-page-tabs-nav">
			<?php foreach ( $tabs as $key => $label ) : ?>
				<button type="button" class="interior-page-tab-btn <?php echo $first ? 'active' : ''; ?>" data-tab="<?php echo esc_attr( 'interior-about-' . $key ); ?>"><?php echo esc_html( $label ); ?></button>
				<?php $first = false; ?>
			<?php endforeach; ?>
		</div>
		<?php $first = true; ?>
		<?php foreach ( $tabs as $key => $label ) : ?>
			<div id="<?php echo esc_attr( 'interior-about-' . $key ); ?>" class="interior-page-tab-content <?php echo $first ? 'active' : ''; ?>">
				<p class="description"><?php echo esc_html( sprintf( 'Edit the %s section content here.', $label ) ); ?></p>
				<table class="form-table" role="presentation">
					<?php if ( 'page_header' === $key ) : ?>
						<?php $section = $data['page_header']; ?>
						<tr><th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th><td><input type="text" class="large-text" name="interior_about_page[page_header][title]" value="<?php echo esc_attr( $section['title'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Breadcrumb', 'interior' ); ?></th><td><input type="text" name="interior_about_page[page_header][breadcrumb_home]" value="<?php echo esc_attr( $section['breadcrumb_home'] ); ?>" placeholder="Home"> <input type="text" class="regular-text" name="interior_about_page[page_header][breadcrumb_url]" value="<?php echo esc_attr( $section['breadcrumb_url'] ); ?>" placeholder="Home URL"> <input type="text" name="interior_about_page[page_header][breadcrumb_text]" value="<?php echo esc_attr( $section['breadcrumb_text'] ); ?>" placeholder="Current"></td></tr>
						<?php interior_render_about_image_field( 'interior_about_page[page_header][bg_image_id]', 'about_page_header_bg', $section['bg_image_id'], $section['bg_image_url'], __( 'Background Image', 'interior' ) ); ?>
					<?php elseif ( 'about_intro' === $key ) : ?>
						<?php $section = $data['about_intro']; ?>
						<tr><th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th><td><input type="text" class="large-text" name="interior_about_page[about_intro][subtitle]" value="<?php echo esc_attr( $section['subtitle'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th><td><textarea class="large-text" rows="3" name="interior_about_page[about_intro][title]"><?php echo esc_textarea( $section['title'] ); ?></textarea></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Counter', 'interior' ); ?></th><td><input type="text" name="interior_about_page[about_intro][counter_number]" value="<?php echo esc_attr( $section['counter_number'] ); ?>" placeholder="26"> <textarea class="large-text" rows="2" name="interior_about_page[about_intro][counter_text]"><?php echo esc_textarea( $section['counter_text'] ); ?></textarea></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th><td><textarea class="large-text" rows="3" name="interior_about_page[about_intro][description]"><?php echo esc_textarea( $section['description'] ); ?></textarea></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Button', 'interior' ); ?></th><td><input type="text" name="interior_about_page[about_intro][button_text]" value="<?php echo esc_attr( $section['button_text'] ); ?>" placeholder="Button text"> <input type="text" class="regular-text" name="interior_about_page[about_intro][button_url]" value="<?php echo esc_attr( $section['button_url'] ); ?>" placeholder="Button URL"></td></tr>
						<?php interior_render_about_image_field( 'interior_about_page[about_intro][counter_image_id]', 'about_intro_counter', $section['counter_image_id'], $section['counter_image_url'], __( 'Counter Image', 'interior' ) ); ?>
						<?php interior_render_about_image_field( 'interior_about_page[about_intro][main_image_id]', 'about_intro_main', $section['main_image_id'], $section['main_image_url'], __( 'Main Image', 'interior' ) ); ?>
					<?php elseif ( 'video' === $key ) : ?>
						<?php $section = $data['video']; ?>
						<tr><th scope="row"><?php esc_html_e( 'Video URL', 'interior' ); ?></th><td><input type="text" class="large-text" name="interior_about_page[video][video_url]" value="<?php echo esc_attr( $section['video_url'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Button Text', 'interior' ); ?></th><td><input type="text" class="regular-text" name="interior_about_page[video][button_text]" value="<?php echo esc_attr( $section['button_text'] ); ?>"></td></tr>
						<?php interior_render_about_image_field( 'interior_about_page[video][bg_image_id]', 'about_video_bg', $section['bg_image_id'], $section['bg_image_url'], __( 'Background Image', 'interior' ) ); ?>
					<?php elseif ( 'history' === $key ) : ?>
						<?php $section = $data['history']; ?>
						<tr><th scope="row"><?php esc_html_e( 'Background Text', 'interior' ); ?></th><td><input type="text" class="regular-text" name="interior_about_page[history][background_text]" value="<?php echo esc_attr( $section['background_text'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th><td><input type="text" class="large-text" name="interior_about_page[history][subtitle]" value="<?php echo esc_attr( $section['subtitle'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th><td><textarea class="large-text" rows="2" name="interior_about_page[history][title]"><?php echo esc_textarea( $section['title'] ); ?></textarea></td></tr>
						<?php interior_render_about_image_field( 'interior_about_page[history][element_image_id]', 'about_history_element', $section['element_image_id'], $section['element_image_url'], __( 'Element Image', 'interior' ) ); ?>
					<?php elseif ( 'process' === $key ) : ?>
						<?php $section = $data['process']; ?>
						<tr><th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th><td><input type="text" class="large-text" name="interior_about_page[process][subtitle]" value="<?php echo esc_attr( $section['subtitle'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th><td><textarea class="large-text" rows="2" name="interior_about_page[process][title]"><?php echo esc_textarea( $section['title'] ); ?></textarea></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th><td><textarea class="large-text" rows="3" name="interior_about_page[process][description]"><?php echo esc_textarea( $section['description'] ); ?></textarea></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Bottom Text', 'interior' ); ?></th><td><input type="text" class="large-text" name="interior_about_page[process][bottom_text]" value="<?php echo esc_attr( $section['bottom_text'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Bottom Link', 'interior' ); ?></th><td><input type="text" name="interior_about_page[process][link_text]" value="<?php echo esc_attr( $section['link_text'] ); ?>" placeholder="Link text"> <input type="text" class="regular-text" name="interior_about_page[process][link_url]" value="<?php echo esc_attr( $section['link_url'] ); ?>" placeholder="Link URL"></td></tr>
					<?php elseif ( 'awards' === $key || 'gallery' === $key ) : ?>
						<?php $section = $data[ $key ]; ?>
						<tr><th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th><td><input type="text" class="large-text" name="interior_about_page[<?php echo esc_attr( $key ); ?>][subtitle]" value="<?php echo esc_attr( $section['subtitle'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th><td><textarea class="large-text" rows="2" name="interior_about_page[<?php echo esc_attr( $key ); ?>][title]"><?php echo esc_textarea( $section['title'] ); ?></textarea></td></tr>
						<?php if ( 'gallery' === $key ) : ?>
							<?php
							$media_page_id = interior_get_media_page_id();
							$media_edit    = $media_page_id ? get_edit_post_link( $media_page_id ) : '';
							$media_link    = $media_page_id ? get_permalink( $media_page_id ) : '';
							?>
							<tr><th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th><td><textarea class="large-text" rows="3" name="interior_about_page[gallery][description]"><?php echo esc_textarea( $section['description'] ); ?></textarea></td></tr>
							<?php interior_render_about_image_field( 'interior_about_page[gallery][bg_image_id]', 'about_gallery_bg', $section['bg_image_id'], $section['bg_image_url'], __( 'Background Image', 'interior' ) ); ?>
							<tr>
								<th scope="row"><?php esc_html_e( 'Gallery Images', 'interior' ); ?></th>
								<td>
									<p class="description"><?php esc_html_e( 'About page gallery images are fetched from the Media page image gallery.', 'interior' ); ?></p>
									<?php if ( $media_edit ) : ?>
										<a class="button button-primary" href="<?php echo esc_url( $media_edit ); ?>"><?php esc_html_e( 'Edit Media Page Gallery', 'interior' ); ?></a>
										<?php if ( $media_link ) : ?>
											<a class="button" href="<?php echo esc_url( $media_link ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'View Media Page', 'interior' ); ?></a>
										<?php endif; ?>
									<?php else : ?>
										<p><?php esc_html_e( 'Create a page with the slug "media" or assign the Media template to a page to manage gallery images.', 'interior' ); ?></p>
									<?php endif; ?>
								</td>
							</tr>
						<?php endif; ?>
					<?php elseif ( 'testimonial' === $key ) : ?>
						<?php $home_testimonial_link = interior_get_home_editor_link( 'testimonial' ); ?>
						<tr>
							<th scope="row"><?php esc_html_e( 'Home Testimonials', 'interior' ); ?></th>
							<td>
								<p class="description"><?php esc_html_e( 'The About page testimonial section uses the content from Home edit > Testimonials tab.', 'interior' ); ?></p>
								<?php if ( $home_testimonial_link ) : ?>
									<a class="button button-primary" href="<?php echo esc_url( $home_testimonial_link ); ?>"><?php esc_html_e( 'Edit Home Testimonials Tab', 'interior' ); ?></a>
								<?php else : ?>
									<p><?php esc_html_e( 'Set a Home page in Settings > Reading or create a page with the slug "home" to edit these fields.', 'interior' ); ?></p>
								<?php endif; ?>
							</td>
						</tr>
					<?php elseif ( 'sponsors' === $key ) : ?>
						<?php $section = $data['sponsors']; ?>
						<tr><th scope="row"><?php esc_html_e( 'Heading', 'interior' ); ?></th><td><input type="text" name="interior_about_page[sponsors][heading_before]" value="<?php echo esc_attr( $section['heading_before'] ); ?>"> <input type="text" name="interior_about_page[sponsors][heading_number]" value="<?php echo esc_attr( $section['heading_number'] ); ?>"> <input type="text" class="regular-text" name="interior_about_page[sponsors][heading_after]" value="<?php echo esc_attr( $section['heading_after'] ); ?>"></td></tr>
					<?php elseif ( 'newsletter' === $key ) : ?>
						<?php $home_newsletter_link = interior_get_home_editor_link( 'newsletter' ); ?>
						<tr>
							<th scope="row"><?php esc_html_e( 'Home Newsletter', 'interior' ); ?></th>
							<td>
								<p class="description"><?php esc_html_e( 'The About page newsletter section uses the content from Home edit > Newsletter tab.', 'interior' ); ?></p>
								<?php if ( $home_newsletter_link ) : ?>
									<a class="button button-primary" href="<?php echo esc_url( $home_newsletter_link ); ?>"><?php esc_html_e( 'Edit Home Newsletter Tab', 'interior' ); ?></a>
								<?php else : ?>
									<p><?php esc_html_e( 'Set a Home page in Settings > Reading or create a page with the slug "home" to edit these fields.', 'interior' ); ?></p>
								<?php endif; ?>
							</td>
						</tr>
					<?php endif; ?>
				</table>

				<?php if ( in_array( $key, array( 'history', 'process', 'awards', 'sponsors' ), true ) ) : ?>
					<?php foreach ( $data[ $key ]['items'] as $index => $item ) : ?>
						<h3><?php echo esc_html( sprintf( '%s Item %d', $label, $index + 1 ) ); ?></h3>
						<table class="form-table" role="presentation">
							<?php if ( 'history' === $key ) : ?>
								<tr><th scope="row"><?php esc_html_e( 'Year', 'interior' ); ?></th><td><input type="text" class="regular-text" name="interior_about_page[history][items][<?php echo esc_attr( $index ); ?>][year]" value="<?php echo esc_attr( $item['year'] ); ?>"></td></tr>
								<tr><th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th><td><textarea class="large-text" rows="2" name="interior_about_page[history][items][<?php echo esc_attr( $index ); ?>][description]"><?php echo esc_textarea( $item['description'] ); ?></textarea></td></tr>
								<?php interior_render_about_image_field( 'interior_about_page[history][items][' . $index . '][image_id]', 'about_history_' . $index, $item['image_id'], $item['image_url'], __( 'Image', 'interior' ) ); ?>
							<?php elseif ( 'process' === $key ) : ?>
								<tr><th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th><td><input type="text" class="large-text" name="interior_about_page[process][items][<?php echo esc_attr( $index ); ?>][title]" value="<?php echo esc_attr( $item['title'] ); ?>"></td></tr>
								<tr><th scope="row"><?php esc_html_e( 'Description', 'interior' ); ?></th><td><textarea class="large-text" rows="2" name="interior_about_page[process][items][<?php echo esc_attr( $index ); ?>][description]"><?php echo esc_textarea( $item['description'] ); ?></textarea></td></tr>
								<?php interior_render_about_image_field( 'interior_about_page[process][items][' . $index . '][image_id]', 'about_process_' . $index, $item['image_id'], $item['image_url'], __( 'Image', 'interior' ) ); ?>
							<?php elseif ( 'awards' === $key ) : ?>
								<tr><th scope="row"><?php esc_html_e( 'Award', 'interior' ); ?></th><td><input type="text" name="interior_about_page[awards][items][<?php echo esc_attr( $index ); ?>][year]" value="<?php echo esc_attr( $item['year'] ); ?>" placeholder="Year"> <input type="text" class="regular-text" name="interior_about_page[awards][items][<?php echo esc_attr( $index ); ?>][title]" value="<?php echo esc_attr( $item['title'] ); ?>" placeholder="Title"> <input type="text" class="regular-text" name="interior_about_page[awards][items][<?php echo esc_attr( $index ); ?>][category]" value="<?php echo esc_attr( $item['category'] ); ?>" placeholder="Category"></td></tr>
								<?php interior_render_about_image_field( 'interior_about_page[awards][items][' . $index . '][image_id]', 'about_awards_' . $index, $item['image_id'], $item['image_url'], __( 'Image', 'interior' ) ); ?>
							<?php elseif ( 'sponsors' === $key ) : ?>
								<tr><th scope="row"><?php esc_html_e( 'Link URL', 'interior' ); ?></th><td><input type="text" class="large-text" name="interior_about_page[sponsors][items][<?php echo esc_attr( $index ); ?>][link_url]" value="<?php echo esc_attr( $item['link_url'] ); ?>"></td></tr>
								<?php interior_render_about_image_field( 'interior_about_page[sponsors][items][' . $index . '][image_id]', 'about_sponsor_' . $index, $item['image_id'], $item['image_url'], __( 'Logo', 'interior' ) ); ?>
							<?php endif; ?>
						</table>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<?php $first = false; ?>
		<?php endforeach; ?>
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
		(function($) {
			$('.interior-about-upload').on('click', function(e) {
				e.preventDefault();
				const target = $(this).data('target');
				const preview = $(this).data('preview');
				const frame = wp.media({ title: 'Select Image', button: { text: 'Use this image' }, multiple: false });
				frame.on('select', function() {
					const attachment = frame.state().get('selection').first().toJSON();
					$(target).val(attachment.id);
					$(preview).attr('src', attachment.url).show();
				});
				frame.open();
			});
			$('.interior-about-remove').on('click', function(e) {
				e.preventDefault();
				$($(this).data('target')).val('');
				$($(this).data('preview')).attr('src', '').hide();
			});
		})(jQuery);
	</script>
	<?php
}

/**
 * Render Contact sections metabox.
 *
 * @param WP_Post $post Current page.
 */
function interior_render_contact_metabox( $post ) {
	$data  = interior_get_contact_page_data( $post->ID );
	$tabs  = interior_get_contact_section_tabs();
	$first = true;

	wp_nonce_field( 'interior_contact_page', 'interior_contact_page_field' );
	?>
	<style>
		.interior-page-tabs-nav { display:flex; flex-wrap:wrap; border-bottom:2px solid #ddd; margin:16px 0 20px; }
		.interior-page-tab-btn { background:#fff; border:0; border-bottom:3px solid transparent; color:#555; cursor:pointer; font-weight:600; padding:10px 14px; }
		.interior-page-tab-btn.active { border-bottom-color:#2271b1; color:#1d2327; }
		.interior-page-tab-content { display:none; }
		.interior-page-tab-content.active { display:block; }
		.interior-page-image-preview { display:block; max-width:220px; height:auto; margin:0 0 10px; }
	</style>
	<div class="interior-page-tabs">
		<div class="interior-page-tabs-nav">
			<?php foreach ( $tabs as $key => $label ) : ?>
				<button type="button" class="interior-page-tab-btn <?php echo $first ? 'active' : ''; ?>" data-tab="<?php echo esc_attr( 'interior-contact-' . $key ); ?>"><?php echo esc_html( $label ); ?></button>
				<?php $first = false; ?>
			<?php endforeach; ?>
		</div>
		<?php $first = true; ?>
		<?php foreach ( $tabs as $key => $label ) : ?>
			<div id="<?php echo esc_attr( 'interior-contact-' . $key ); ?>" class="interior-page-tab-content <?php echo $first ? 'active' : ''; ?>">
				<p class="description"><?php echo esc_html( sprintf( 'Edit the %s section content here.', $label ) ); ?></p>
				<table class="form-table" role="presentation">
					<?php if ( 'page_header' === $key ) : ?>
						<?php $section = $data['page_header']; ?>
						<tr><th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th><td><input type="text" class="large-text" name="interior_contact_page[page_header][title]" value="<?php echo esc_attr( $section['title'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Breadcrumb', 'interior' ); ?></th><td><input type="text" name="interior_contact_page[page_header][breadcrumb_home]" value="<?php echo esc_attr( $section['breadcrumb_home'] ); ?>" placeholder="Home"> <input type="text" class="regular-text" name="interior_contact_page[page_header][breadcrumb_url]" value="<?php echo esc_attr( $section['breadcrumb_url'] ); ?>" placeholder="Home URL"> <input type="text" name="interior_contact_page[page_header][breadcrumb_text]" value="<?php echo esc_attr( $section['breadcrumb_text'] ); ?>" placeholder="Current"></td></tr>
						<?php interior_render_about_image_field( 'interior_contact_page[page_header][bg_image_id]', 'contact_page_header_bg', $section['bg_image_id'], $section['bg_image_url'], __( 'Background Image', 'interior' ) ); ?>
					<?php elseif ( 'contact' === $key ) : ?>
						<?php $section = $data['contact']; ?>
						<tr><th scope="row"><?php esc_html_e( 'Subtitle', 'interior' ); ?></th><td><input type="text" class="large-text" name="interior_contact_page[contact][subtitle]" value="<?php echo esc_attr( $section['subtitle'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th><td><textarea class="large-text" rows="2" name="interior_contact_page[contact][title]"><?php echo esc_textarea( $section['title'] ); ?></textarea></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Address Box', 'interior' ); ?></th><td><input type="text" class="regular-text" name="interior_contact_page[contact][address_label]" value="<?php echo esc_attr( $section['address_label'] ); ?>"><textarea class="large-text" rows="2" name="interior_contact_page[contact][address_text]"><?php echo esc_textarea( $section['address_text'] ); ?></textarea></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Support Box', 'interior' ); ?></th><td><input type="text" class="regular-text" name="interior_contact_page[contact][support_label]" value="<?php echo esc_attr( $section['support_label'] ); ?>"><br><input type="text" name="interior_contact_page[contact][phone]" value="<?php echo esc_attr( $section['phone'] ); ?>" placeholder="Phone"> <input type="text" class="regular-text" name="interior_contact_page[contact][phone_url]" value="<?php echo esc_attr( $section['phone_url'] ); ?>" placeholder="Phone URL"><br><input type="text" name="interior_contact_page[contact][email]" value="<?php echo esc_attr( $section['email'] ); ?>" placeholder="Email"> <input type="text" class="regular-text" name="interior_contact_page[contact][email_url]" value="<?php echo esc_attr( $section['email_url'] ); ?>" placeholder="Email URL"></td></tr>
						<?php interior_render_about_image_field( 'interior_contact_page[contact][image_id]', 'contact_section_image', $section['image_id'], $section['image_url'], __( 'Contact Image', 'interior' ) ); ?>
						<tr><th scope="row"><?php esc_html_e( 'Contact Form 7 Shortcode', 'interior' ); ?></th><td><input type="text" class="large-text" name="interior_contact_page[contact][cf7_shortcode]" value="<?php echo esc_attr( $section['cf7_shortcode'] ); ?>" placeholder='[contact-form-7 id="123" title="Contact form"]'><p class="description"><?php esc_html_e( 'Create a form in Contact Form 7, then paste its shortcode here.', 'interior' ); ?></p></td></tr>
					<?php elseif ( 'map' === $key ) : ?>
						<?php $section = $data['map']; ?>
						<tr><th scope="row"><?php esc_html_e( 'Google Map Embed URL', 'interior' ); ?></th><td><textarea class="large-text" rows="4" name="interior_contact_page[map][iframe_url]"><?php echo esc_textarea( $section['iframe_url'] ); ?></textarea></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Map Height', 'interior' ); ?></th><td><input type="number" class="small-text" name="interior_contact_page[map][height]" value="<?php echo esc_attr( $section['height'] ); ?>"> px</td></tr>
					<?php endif; ?>
				</table>
			</div>
			<?php $first = false; ?>
		<?php endforeach; ?>
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
		(function($) {
			$('.interior-about-upload').on('click', function(e) {
				e.preventDefault();
				const target = $(this).data('target');
				const preview = $(this).data('preview');
				const frame = wp.media({ title: 'Select Image', button: { text: 'Use this image' }, multiple: false });
				frame.on('select', function() {
					const attachment = frame.state().get('selection').first().toJSON();
					$(target).val(attachment.id);
					$(preview).attr('src', attachment.url).show();
				});
				frame.open();
			});
			$('.interior-about-remove').on('click', function(e) {
				e.preventDefault();
				$($(this).data('target')).val('');
				$($(this).data('preview')).attr('src', '').hide();
			});
		})(jQuery);
	</script>
	<?php
}

/**
 * Render Downloads sections metabox.
 *
 * @param WP_Post $post Current page.
 */
function interior_render_downloads_metabox( $post ) {
	$data        = interior_get_downloads_page_data( $post->ID );
	$tabs        = interior_get_downloads_section_tabs();
	$first       = true;
	$upload_ids  = $data['uploads']['file_ids'];
	$upload_data = array();

	foreach ( $upload_ids as $file_id ) {
		$url = wp_get_attachment_url( $file_id );

		if ( ! $url ) {
			continue;
		}

		$upload_data[] = array(
			'id'    => $file_id,
			'title' => get_the_title( $file_id ),
			'url'   => $url,
			'type'  => get_post_mime_type( $file_id ),
		);
	}

	wp_nonce_field( 'interior_downloads_page', 'interior_downloads_page_field' );
	?>
	<style>
		.interior-page-tabs-nav { display:flex; flex-wrap:wrap; border-bottom:2px solid #ddd; margin:16px 0 20px; }
		.interior-page-tab-btn { background:#fff; border:0; border-bottom:3px solid transparent; color:#555; cursor:pointer; font-weight:600; padding:10px 14px; }
		.interior-page-tab-btn.active { border-bottom-color:#2271b1; color:#1d2327; }
		.interior-page-tab-content { display:none; }
		.interior-page-tab-content.active { display:block; }
		.interior-page-image-preview { display:block; max-width:220px; height:auto; margin:0 0 10px; }
		.interior-downloads-admin-list { margin:12px 0 0; max-width:720px; }
		.interior-downloads-admin-item { align-items:center; background:#fff; border:1px solid #dcdcde; display:flex; gap:10px; justify-content:space-between; margin:0 0 8px; padding:9px 12px; }
		.interior-downloads-admin-title { font-weight:600; }
		.interior-downloads-admin-type { color:#646970; font-size:12px; }
	</style>
	<div class="interior-page-tabs">
		<div class="interior-page-tabs-nav">
			<?php foreach ( $tabs as $key => $label ) : ?>
				<button type="button" class="interior-page-tab-btn <?php echo $first ? 'active' : ''; ?>" data-tab="<?php echo esc_attr( 'interior-downloads-' . $key ); ?>"><?php echo esc_html( $label ); ?></button>
				<?php $first = false; ?>
			<?php endforeach; ?>
		</div>
		<?php $first = true; ?>
		<?php foreach ( $tabs as $key => $label ) : ?>
			<div id="<?php echo esc_attr( 'interior-downloads-' . $key ); ?>" class="interior-page-tab-content <?php echo $first ? 'active' : ''; ?>">
				<p class="description"><?php echo esc_html( sprintf( 'Edit the %s section content here.', $label ) ); ?></p>
				<table class="form-table" role="presentation">
					<?php if ( 'page_header' === $key ) : ?>
						<?php $section = $data['page_header']; ?>
						<tr><th scope="row"><?php esc_html_e( 'Title', 'interior' ); ?></th><td><input type="text" class="large-text" name="interior_downloads_page[page_header][title]" value="<?php echo esc_attr( $section['title'] ); ?>"></td></tr>
						<tr><th scope="row"><?php esc_html_e( 'Breadcrumb', 'interior' ); ?></th><td><input type="text" name="interior_downloads_page[page_header][breadcrumb_home]" value="<?php echo esc_attr( $section['breadcrumb_home'] ); ?>" placeholder="Home"> <input type="text" class="regular-text" name="interior_downloads_page[page_header][breadcrumb_url]" value="<?php echo esc_attr( $section['breadcrumb_url'] ); ?>" placeholder="Home URL"> <input type="text" name="interior_downloads_page[page_header][breadcrumb_text]" value="<?php echo esc_attr( $section['breadcrumb_text'] ); ?>" placeholder="Current"></td></tr>
						<?php interior_render_about_image_field( 'interior_downloads_page[page_header][bg_image_id]', 'downloads_page_header_bg', $section['bg_image_id'], $section['bg_image_url'], __( 'Background Image', 'interior' ) ); ?>
					<?php elseif ( 'uploads' === $key ) : ?>
						<tr>
							<th scope="row"><?php esc_html_e( 'Download Files', 'interior' ); ?></th>
							<td>
								<input type="hidden" id="interior_download_file_ids" name="interior_downloads_page[uploads][file_ids]" value="<?php echo esc_attr( implode( ',', $upload_ids ) ); ?>">
								<button type="button" class="button button-primary" id="interior_download_upload_files"><?php esc_html_e( 'Select Files', 'interior' ); ?></button>
								<button type="button" class="button" id="interior_download_clear_files" <?php echo empty( $upload_ids ) ? 'style="display:none;"' : ''; ?>><?php esc_html_e( 'Clear Files', 'interior' ); ?></button>
								<p class="description"><?php esc_html_e( 'Upload or choose PDF, Word, Excel, or CSV files. They will display one below another on the Downloads page.', 'interior' ); ?></p>
								<div id="interior_download_files_preview" class="interior-downloads-admin-list"></div>
							</td>
						</tr>
					<?php endif; ?>
				</table>
			</div>
			<?php $first = false; ?>
		<?php endforeach; ?>
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
		(function($) {
			const allowedExt = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv'];
			let selectedFiles = <?php echo wp_json_encode( $upload_data ); ?>;

			function renderFiles() {
				const preview = $('#interior_download_files_preview');
				const ids = selectedFiles.map(function(file) { return file.id; });
				preview.empty();
				$('#interior_download_file_ids').val(ids.join(','));
				$('#interior_download_clear_files').toggle(ids.length > 0);

				selectedFiles.forEach(function(file) {
					const title = file.title || file.url || 'Download file';
					const type = file.type || '';
					preview.append('<div class="interior-downloads-admin-item"><div><div class="interior-downloads-admin-title">' + $('<div>').text(title).html() + '</div><div class="interior-downloads-admin-type">' + $('<div>').text(type).html() + '</div></div><button type="button" class="button interior-download-remove-file" data-id="' + file.id + '"><?php echo esc_js( __( 'Remove', 'interior' ) ); ?></button></div>');
				});
			}

			$('#interior_download_upload_files').on('click', function(e) {
				e.preventDefault();
				const frame = wp.media({ title: 'Select Download Files', button: { text: 'Use these files' }, multiple: true });
				frame.on('select', function() {
					const seen = {};
					selectedFiles.forEach(function(file) {
						seen[file.id] = true;
					});
					frame.state().get('selection').each(function(attachment) {
						const item = attachment.toJSON();
						const ext = (item.filename || item.url || '').split('.').pop().toLowerCase();
						if (-1 === allowedExt.indexOf(ext) || seen[item.id]) {
							return;
						}
						seen[item.id] = true;
						selectedFiles.push({ id: item.id, title: item.title || item.filename, url: item.url, type: item.mime || item.subtype || '' });
					});
					renderFiles();
				});
				frame.open();
			});

			$('#interior_download_clear_files').on('click', function(e) {
				e.preventDefault();
				selectedFiles = [];
				renderFiles();
			});

			$('#interior_download_files_preview').on('click', '.interior-download-remove-file', function(e) {
				e.preventDefault();
				const id = parseInt($(this).data('id'), 10);
				selectedFiles = selectedFiles.filter(function(file) {
					return parseInt(file.id, 10) !== id;
				});
				renderFiles();
			});

			$('.interior-about-upload').on('click', function(e) {
				e.preventDefault();
				const target = $(this).data('target');
				const preview = $(this).data('preview');
				const frame = wp.media({ title: 'Select Image', button: { text: 'Use this image' }, multiple: false });
				frame.on('select', function() {
					const attachment = frame.state().get('selection').first().toJSON();
					$(target).val(attachment.id);
					$(preview).attr('src', attachment.url).show();
				});
				frame.open();
			});
			$('.interior-about-remove').on('click', function(e) {
				e.preventDefault();
				$($(this).data('target')).val('');
				$($(this).data('preview')).attr('src', '').hide();
			});

			renderFiles();
		})(jQuery);
	</script>
	<?php
}

/**
 * Sanitize structured About page data.
 *
 * @param array $raw Raw submitted data.
 * @return array
 */
function interior_sanitize_about_page_data( $raw ) {
	$defaults = interior_get_about_page_defaults();
	$raw      = is_array( $raw ) ? $raw : array();
	$data     = $defaults;

	foreach ( $defaults as $section_key => $section_defaults ) {
		$section_raw = isset( $raw[ $section_key ] ) && is_array( $raw[ $section_key ] ) ? $raw[ $section_key ] : array();

		foreach ( $section_defaults as $field_key => $default_value ) {
			if ( 'items' === $field_key || is_array( $default_value ) ) {
				continue;
			}

			if ( ! isset( $section_raw[ $field_key ] ) ) {
				continue;
			}

			if ( false !== strpos( $field_key, 'image_id' ) ) {
				$data[ $section_key ][ $field_key ] = absint( $section_raw[ $field_key ] );
			} elseif ( false !== strpos( $field_key, 'url' ) ) {
				$data[ $section_key ][ $field_key ] = esc_url_raw( $section_raw[ $field_key ] );
			} elseif ( in_array( $field_key, array( 'title', 'description', 'counter_text', 'intro', 'quote', 'bottom_text' ), true ) ) {
				$data[ $section_key ][ $field_key ] = wp_kses_post( $section_raw[ $field_key ] );
			} else {
				$data[ $section_key ][ $field_key ] = sanitize_text_field( $section_raw[ $field_key ] );
			}
		}

		if ( isset( $section_defaults['items'] ) && is_array( $section_defaults['items'] ) ) {
			$items_raw = isset( $section_raw['items'] ) && is_array( $section_raw['items'] ) ? $section_raw['items'] : array();
			foreach ( $section_defaults['items'] as $index => $item_defaults ) {
				$item_raw = isset( $items_raw[ $index ] ) && is_array( $items_raw[ $index ] ) ? $items_raw[ $index ] : array();
				foreach ( $item_defaults as $item_key => $item_default ) {
					if ( ! isset( $item_raw[ $item_key ] ) ) {
						continue;
					}

					if ( false !== strpos( $item_key, 'image_id' ) ) {
						$data[ $section_key ]['items'][ $index ][ $item_key ] = absint( $item_raw[ $item_key ] );
					} elseif ( false !== strpos( $item_key, 'url' ) ) {
						$data[ $section_key ]['items'][ $index ][ $item_key ] = esc_url_raw( $item_raw[ $item_key ] );
					} elseif ( in_array( $item_key, array( 'title', 'description' ), true ) ) {
						$data[ $section_key ]['items'][ $index ][ $item_key ] = wp_kses_post( $item_raw[ $item_key ] );
					} else {
						$data[ $section_key ]['items'][ $index ][ $item_key ] = sanitize_text_field( $item_raw[ $item_key ] );
					}
				}
			}
		}
	}

	return $data;
}

/**
 * Sanitize structured Contact page data.
 *
 * @param array $raw Raw submitted data.
 * @return array
 */
function interior_sanitize_contact_page_data( $raw ) {
	$defaults = interior_get_contact_page_defaults();
	$raw      = is_array( $raw ) ? $raw : array();
	$data     = $defaults;

	foreach ( $defaults as $section_key => $section_defaults ) {
		$section_raw = isset( $raw[ $section_key ] ) && is_array( $raw[ $section_key ] ) ? $raw[ $section_key ] : array();

		foreach ( $section_defaults as $field_key => $default_value ) {
			if ( ! isset( $section_raw[ $field_key ] ) ) {
				continue;
			}

			if ( false !== strpos( $field_key, 'image_id' ) ) {
				$data[ $section_key ][ $field_key ] = absint( $section_raw[ $field_key ] );
			} elseif ( 'height' === $field_key ) {
				$data[ $section_key ][ $field_key ] = absint( $section_raw[ $field_key ] );
			} elseif ( false !== strpos( $field_key, 'url' ) || 'form_action' === $field_key || 'iframe_url' === $field_key ) {
				$data[ $section_key ][ $field_key ] = esc_url_raw( $section_raw[ $field_key ] );
			} elseif ( in_array( $field_key, array( 'title', 'address_text' ), true ) ) {
				$data[ $section_key ][ $field_key ] = wp_kses_post( $section_raw[ $field_key ] );
			} else {
				$data[ $section_key ][ $field_key ] = sanitize_text_field( $section_raw[ $field_key ] );
			}
		}
	}

	return $data;
}

/**
 * Sanitize structured Downloads page data.
 *
 * @param array $raw Raw submitted data.
 * @return array
 */
function interior_sanitize_downloads_page_data( $raw ) {
	$defaults     = interior_get_downloads_page_defaults();
	$raw          = is_array( $raw ) ? $raw : array();
	$data         = $defaults;
	$allowed_exts = array( 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv' );

	if ( isset( $raw['page_header'] ) && is_array( $raw['page_header'] ) ) {
		foreach ( $defaults['page_header'] as $field_key => $default_value ) {
			if ( ! isset( $raw['page_header'][ $field_key ] ) ) {
				continue;
			}

			if ( 'bg_image_id' === $field_key ) {
				$data['page_header'][ $field_key ] = absint( $raw['page_header'][ $field_key ] );
			} elseif ( false !== strpos( $field_key, 'url' ) ) {
				$data['page_header'][ $field_key ] = esc_url_raw( $raw['page_header'][ $field_key ] );
			} else {
				$data['page_header'][ $field_key ] = sanitize_text_field( $raw['page_header'][ $field_key ] );
			}
		}
	}

	$file_ids_raw = isset( $raw['uploads']['file_ids'] ) ? $raw['uploads']['file_ids'] : '';
	$file_ids     = is_array( $file_ids_raw ) ? $file_ids_raw : explode( ',', (string) $file_ids_raw );
	$file_ids     = array_filter( array_map( 'absint', $file_ids ) );
	$file_ids     = array_values( array_unique( $file_ids ) );

	foreach ( $file_ids as $file_id ) {
		if ( 'attachment' !== get_post_type( $file_id ) ) {
			continue;
		}

		$file_url = wp_get_attachment_url( $file_id );
		$file_ext = strtolower( pathinfo( (string) $file_url, PATHINFO_EXTENSION ) );

		if ( in_array( $file_ext, $allowed_exts, true ) ) {
			$data['uploads']['file_ids'][] = $file_id;
		}
	}

	return $data;
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

	if ( isset( $_POST['interior_about_page_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['interior_about_page_field'] ) ), 'interior_about_page' ) ) {
		$raw = isset( $_POST['interior_about_page'] ) && is_array( $_POST['interior_about_page'] ) ? wp_unslash( $_POST['interior_about_page'] ) : array();
		update_post_meta( $post_id, '_interior_about_page_data', interior_sanitize_about_page_data( $raw ) );
		return;
	}

	if ( isset( $_POST['interior_contact_page_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['interior_contact_page_field'] ) ), 'interior_contact_page' ) ) {
		$raw = isset( $_POST['interior_contact_page'] ) && is_array( $_POST['interior_contact_page'] ) ? wp_unslash( $_POST['interior_contact_page'] ) : array();
		update_post_meta( $post_id, '_interior_contact_page_data', interior_sanitize_contact_page_data( $raw ) );
		return;
	}

	if ( isset( $_POST['interior_downloads_page_field'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['interior_downloads_page_field'] ) ), 'interior_downloads_page' ) ) {
		$raw = isset( $_POST['interior_downloads_page'] ) && is_array( $_POST['interior_downloads_page'] ) ? wp_unslash( $_POST['interior_downloads_page'] ) : array();
		update_post_meta( $post_id, '_interior_downloads_page_data', interior_sanitize_downloads_page_data( $raw ) );
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
	if ( '_interior_about_sections' === $meta_key && array_key_exists( $section, interior_get_about_section_tabs() ) ) {
		return '';
	}

	if ( '_interior_contact_sections' === $meta_key && array_key_exists( $section, interior_get_contact_section_tabs() ) ) {
		return '';
	}

	$page_id  = get_queried_object_id();
	$sections = $page_id ? get_post_meta( $page_id, $meta_key, true ) : array();

	if ( ! is_array( $sections ) || empty( $sections[ $section ] ) ) {
		return '';
	}

	return do_shortcode( $sections[ $section ] );
}

/**
 * Determine if a page is the Media editor page.
 *
 * @param WP_Post|null $post Page post.
 * @return bool
 */
function interior_is_media_editor_page( $post ) {
	if ( ! $post || 'page' !== $post->post_type ) {
		return false;
	}

	return 'media' === $post->post_name || 'page-media.php' === get_page_template_slug( $post->ID );
}

/**
 * Register Media page settings metabox.
 */
function interior_register_media_metabox() {
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
	$post    = $post_id ? get_post( $post_id ) : null;

	if ( interior_is_media_editor_page( $post ) ) {
		add_meta_box(
			'interior_media_sections',
			esc_html__( 'Media Page Settings', 'interior' ),
			'interior_render_media_metabox',
			'page',
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'interior_register_media_metabox' );

/**
 * Render Media page settings metabox.
 *
 * @param WP_Post $post Current page.
 */
function interior_render_media_metabox( $post ) {
	wp_nonce_field( 'interior_media_nonce', 'interior_media_nonce_field' );

	$banner_title    = get_post_meta( $post->ID, '_media_banner_title', true );
	$banner_text     = get_post_meta( $post->ID, '_media_banner_text', true );
	$banner_image_id = (int) get_post_meta( $post->ID, '_media_banner_image_id', true );
	$banner_image    = $banner_image_id ? wp_get_attachment_image_url( $banner_image_id, 'medium' ) : '';
	$gallery_ids_raw = get_post_meta( $post->ID, '_media_gallery_ids', true );
	$gallery_ids     = is_array( $gallery_ids_raw ) ? $gallery_ids_raw : array_filter( array_map( 'intval', explode( ',', (string) $gallery_ids_raw ) ) );
	$video_urls      = get_post_meta( $post->ID, '_media_video_urls', true );
	?>
	<style>
		.media-tabs-container { margin-top:20px; }
		.media-tabs-nav { display:flex; flex-wrap:wrap; border-bottom:2px solid #ddd; margin-bottom:20px; }
		.media-tabs-nav button { background:#fff; border:0; border-bottom:3px solid transparent; color:#555; cursor:pointer; font-weight:600; padding:10px 14px; margin-bottom:-2px; }
		.media-tabs-nav button.active { border-bottom-color:#2271b1; color:#1d2327; }
		.media-tabs-content { display:none; }
		.media-tabs-content.active { display:block; }
		.media-section-field { margin-bottom:20px; }
		.media-section-field label { display:block; font-weight:600; margin-bottom:8px; }
		.media-section-field input[type="text"], .media-section-field textarea { width:100%; }
		.media-section-field textarea { min-height:90px; }
		.media-gallery-grid { display:flex; flex-wrap:wrap; gap:10px; margin-top:12px; }
		.media-gallery-grid img { max-width:120px; height:auto; border:1px solid #ddd; border-radius:4px; }
		.media-note { background:#f6f7f7; border-left:4px solid #72aee6; color:#50575e; margin-bottom:12px; padding:10px; }
	</style>

	<div class="media-tabs-container">
		<div class="media-tabs-nav">
			<button type="button" class="media-tab-btn active" data-tab="media-banner"><?php esc_html_e( 'Banner', 'interior' ); ?></button>
			<button type="button" class="media-tab-btn" data-tab="media-gallery"><?php esc_html_e( 'Image Gallery', 'interior' ); ?></button>
			<button type="button" class="media-tab-btn" data-tab="media-videos"><?php esc_html_e( 'Video URLs', 'interior' ); ?></button>
		</div>

		<div class="media-tabs-content active" id="media-banner">
			<div class="media-section-field">
				<label><?php esc_html_e( 'Banner Title', 'interior' ); ?></label>
				<input type="text" name="media_banner_title" value="<?php echo esc_attr( $banner_title ? $banner_title : 'Gallery' ); ?>" placeholder="Gallery">
			</div>
			<div class="media-section-field">
				<label><?php esc_html_e( 'Banner Text', 'interior' ); ?></label>
				<textarea name="media_banner_text" placeholder="Short description shown under the page title."><?php echo esc_textarea( $banner_text ); ?></textarea>
			</div>
			<div class="media-section-field">
				<label><?php esc_html_e( 'Banner Background Image', 'interior' ); ?></label>
				<input type="hidden" id="media_banner_image_id" name="media_banner_image_id" value="<?php echo esc_attr( $banner_image_id ); ?>">
				<img id="media_banner_image_preview" src="<?php echo esc_url( $banner_image ); ?>" alt="" style="<?php echo $banner_image ? '' : 'display:none;'; ?>max-width:300px;height:auto;border:1px solid #ddd;border-radius:4px;margin:0 0 10px;">
				<br>
				<button type="button" id="upload_media_banner_image" class="button button-primary"><?php esc_html_e( 'Upload Banner Image', 'interior' ); ?></button>
				<button type="button" id="remove_media_banner_image" class="button" style="<?php echo $banner_image ? '' : 'display:none;'; ?>"><?php esc_html_e( 'Remove Image', 'interior' ); ?></button>
			</div>
		</div>

		<div class="media-tabs-content" id="media-gallery">
			<div class="media-note"><?php esc_html_e( 'Select multiple images. These will appear in the Media page gallery grid.', 'interior' ); ?></div>
			<div class="media-section-field">
				<input type="hidden" id="media_gallery_ids" name="media_gallery_ids" value="<?php echo esc_attr( implode( ',', $gallery_ids ) ); ?>">
				<button type="button" id="upload_media_gallery" class="button button-primary"><?php esc_html_e( 'Select / Upload Images', 'interior' ); ?></button>
				<button type="button" id="clear_media_gallery" class="button" style="<?php echo ! empty( $gallery_ids ) ? '' : 'display:none;'; ?>"><?php esc_html_e( 'Clear Gallery', 'interior' ); ?></button>
			</div>
			<div class="media-gallery-grid" id="media_gallery_preview">
				<?php foreach ( $gallery_ids as $image_id ) : ?>
					<?php $thumb = wp_get_attachment_image_url( (int) $image_id, 'thumbnail' ); ?>
					<?php if ( $thumb ) : ?>
						<img src="<?php echo esc_url( $thumb ); ?>" alt="">
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="media-tabs-content" id="media-videos">
			<div class="media-note"><?php esc_html_e( 'Add one video URL per line. YouTube and Vimeo URLs are supported.', 'interior' ); ?></div>
			<div class="media-section-field">
				<label><?php esc_html_e( 'Video URLs', 'interior' ); ?></label>
				<textarea name="media_video_urls" placeholder="https://www.youtube.com/watch?v=...&#10;https://vimeo.com/..."><?php echo esc_textarea( $video_urls ); ?></textarea>
			</div>
		</div>
	</div>

	<script>
		(function() {
			const buttons = document.querySelectorAll('.media-tab-btn');
			const contents = document.querySelectorAll('.media-tabs-content');
			buttons.forEach(function(button) {
				button.addEventListener('click', function(e) {
					e.preventDefault();
					const tabName = this.getAttribute('data-tab');
					buttons.forEach(function(item) { item.classList.remove('active'); });
					contents.forEach(function(item) { item.classList.remove('active'); });
					this.classList.add('active');
					document.getElementById(tabName).classList.add('active');
				});
			});
		})();
		(function($) {
			$('#upload_media_banner_image').on('click', function(e) {
				e.preventDefault();
				var frame = wp.media({ title: 'Select Banner Image', button: { text: 'Use this image' }, multiple: false });
				frame.on('select', function() {
					var attachment = frame.state().get('selection').first().toJSON();
					$('#media_banner_image_id').val(attachment.id);
					$('#media_banner_image_preview').attr('src', attachment.url).show();
					$('#remove_media_banner_image').show();
				});
				frame.open();
			});
			$('#remove_media_banner_image').on('click', function(e) {
				e.preventDefault();
				$('#media_banner_image_id').val('');
				$('#media_banner_image_preview').attr('src', '').hide();
				$(this).hide();
			});
			$('#upload_media_gallery').on('click', function(e) {
				e.preventDefault();
				var galleryFrame = wp.media({ title: 'Select Gallery Images', button: { text: 'Use these images' }, multiple: true });
				galleryFrame.on('select', function() {
					var selection = galleryFrame.state().get('selection');
					var ids = [];
					var preview = $('#media_gallery_preview');
					preview.empty();
					selection.each(function(attachment) {
						var item = attachment.toJSON();
						ids.push(item.id);
						preview.append('<img src="' + (item.sizes && item.sizes.thumbnail ? item.sizes.thumbnail.url : item.url) + '" alt="" />');
					});
					$('#media_gallery_ids').val(ids.join(','));
					$('#clear_media_gallery').show();
				});
				galleryFrame.open();
			});
			$('#clear_media_gallery').on('click', function(e) {
				e.preventDefault();
				$('#media_gallery_ids').val('');
				$('#media_gallery_preview').empty();
				$(this).hide();
			});
		})(jQuery);
	</script>
	<?php
}

/**
 * Save Media page settings metabox.
 *
 * @param int $post_id Post ID.
 */
function interior_save_media_metabox( $post_id ) {
	$post = get_post( $post_id );
	if ( ! interior_is_media_editor_page( $post ) ) {
		return;
	}

	if ( ! isset( $_POST['interior_media_nonce_field'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['interior_media_nonce_field'] ) ), 'interior_media_nonce' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['media_banner_title'] ) ) {
		update_post_meta( $post_id, '_media_banner_title', sanitize_text_field( wp_unslash( $_POST['media_banner_title'] ) ) );
	}

	if ( isset( $_POST['media_banner_text'] ) ) {
		update_post_meta( $post_id, '_media_banner_text', sanitize_textarea_field( wp_unslash( $_POST['media_banner_text'] ) ) );
	}

	if ( isset( $_POST['media_banner_image_id'] ) ) {
		$image_id = absint( $_POST['media_banner_image_id'] );
		if ( $image_id ) {
			update_post_meta( $post_id, '_media_banner_image_id', $image_id );
		} else {
			delete_post_meta( $post_id, '_media_banner_image_id' );
		}
	}

	if ( isset( $_POST['media_gallery_ids'] ) ) {
		$ids_raw = sanitize_text_field( wp_unslash( $_POST['media_gallery_ids'] ) );
		$ids     = array_filter( array_map( 'absint', explode( ',', $ids_raw ) ) );
		update_post_meta( $post_id, '_media_gallery_ids', $ids );
	}

	if ( isset( $_POST['media_video_urls'] ) ) {
		update_post_meta( $post_id, '_media_video_urls', sanitize_textarea_field( wp_unslash( $_POST['media_video_urls'] ) ) );
	}
}
add_action( 'save_post_page', 'interior_save_media_metabox' );
