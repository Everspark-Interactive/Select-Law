<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Admin
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://my.studiopress.com/themes/genesis/
 */

/**
 * Registers a new admin page, providing content and corresponding menu item for the Theme Settings page.
 *
 * Although this class was added in 1.8.0, some of the methods were originally* standalone functions added in previous
 * versions of Genesis.
 *
 * @package Genesis\Admin
 *
 * @since 1.8.0
 */
class Genesis_Admin_Settings extends Genesis_Admin_Boxes {

	/**
	 * Create an admin menu item and settings page.
	 *
	 * @since 1.8.0
	 */
	public function __construct() {

		$this->redirect_to     = admin_url( 'customize.php?autofocus[panel]=genesis' );
		$this->redirect_bypass = 'noredirect';

		$page_id = 'genesis';

		$menu_ops = apply_filters(
			'genesis_theme_settings_menu_ops',
			array(
				'main_menu'     => array(
					'sep'        => array(
						'sep_position'   => '58.995',
						'sep_capability' => 'edit_theme_options',
					),
					'page_title' => 'Theme Settings',
					'menu_title' => 'Genesis',
					'capability' => 'edit_theme_options',
					'icon_url'   => GENESIS_ADMIN_IMAGES_URL . '/genesis-menu.png',
					'position'   => '58.996',
				),
				'first_submenu' => array( // Do not use without 'main_menu'.
					'page_title' => __( 'Theme Settings', 'genesis' ),
					'menu_title' => __( 'Theme Settings', 'genesis' ),
					'capability' => 'edit_theme_options',
				),
			)
		);

		$page_ops = apply_filters(
			'genesis_theme_settings_page_ops',
			array(
				'save_button_text'  => __( 'Save Changes', 'genesis' ),
				'reset_button_text' => __( 'Reset Settings', 'genesis' ),
				'saved_notice_text' => __( 'Settings saved.', 'genesis' ),
				'reset_notice_text' => __( 'Settings reset.', 'genesis' ),
				'error_notice_text' => __( 'Error saving settings.', 'genesis' ),
			)
		);

		$settings_field = GENESIS_SETTINGS_FIELD;

		$default_settings = apply_filters(
			'genesis_theme_settings_defaults',
			array(
				'update'                    => 1,
				'update_email'              => 0,
				'update_email_address'      => '',
				'blog_title'                => 'text',
				'style_selection'           => '',
				'site_layout'               => genesis_get_default_layout(),
				'superfish'                 => 0,
				'nav_extras'                => '',
				'nav_extras_twitter_id'     => '',
				'nav_extras_twitter_text'   => __( 'Follow me on Twitter', 'genesis' ),
				'feed_uri'                  => '',
				'redirect_feed'             => 0,
				'comments_feed_uri'         => '',
				'redirect_comments_feed'    => 0,
				'adsense_id'                => '',
				'comments_pages'            => 0,
				'comments_posts'            => 1,
				'trackbacks_pages'          => 0,
				'trackbacks_posts'          => 1,
				'breadcrumb_home'           => 0,
				'breadcrumb_front_page'     => 0,
				'breadcrumb_posts_page'     => 0,
				'breadcrumb_single'         => 0,
				'breadcrumb_page'           => 0,
				'breadcrumb_archive'        => 0,
				'breadcrumb_404'            => 0,
				'breadcrumb_attachment'     => 0,
				'content_archive'           => 'full',
				'content_archive_thumbnail' => 0,
				'image_size'                => '',
				'image_alignment'           => 'alignleft',
				'posts_nav'                 => 'numeric',
				'blog_cat'                  => '',
				'blog_cat_exclude'          => '',
				'blog_cat_num'              => 10,
				'header_scripts'            => '',
				'footer_scripts'            => '',
				'theme_version'             => PARENT_THEME_VERSION,
				'db_version'                => PARENT_DB_VERSION,
				'first_version'             => genesis_first_version(),
			)
		);

		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );

	}

	/**
	 * Register each of the settings with a sanitization filter type.
	 *
	 * There is no filter for: image_size
	 *
	 * @since 1.7.0
	 *
	 * @see \Genesis_Settings_Sanitizer::add_filter() Add sanitization filters to options.
	 */
	public function sanitizer_filters() {

		genesis_add_option_filter(
			'one_zero',
			$this->settings_field,
			array(
				'breadcrumb_front_page',
				'breadcrumb_home',
				'breadcrumb_single',
				'breadcrumb_page',
				'breadcrumb_posts_page',
				'breadcrumb_archive',
				'breadcrumb_404',
				'breadcrumb_attachment',
				'comments_posts',
				'comments_pages',
				'content_archive_thumbnail',
				'superfish',
				'redirect_feed',
				'redirect_comments_feed',
				'trackbacks_posts',
				'trackbacks_pages',
				'update',
				'update_email',
			)
		);

		genesis_add_option_filter(
			'no_html',
			$this->settings_field,
			array(
				'blog_cat_exclude',
				'blog_title',
				'adsense_id',
				'content_archive',
				'nav_extras',
				'nav_extras_twitter_id',
				'posts_nav',
				'site_layout',
				'style_selection',
				'theme_version',
			)
		);

		genesis_add_option_filter(
			'absint',
			$this->settings_field,
			array(
				'blog_cat',
				'blog_cat_num',
				'content_archive_limit',
				'db_version',
			)
		);

		genesis_add_option_filter(
			'safe_html',
			$this->settings_field,
			array(
				'nav_extras_twitter_text',
			)
		);

		genesis_add_option_filter(
			'requires_unfiltered_html',
			$this->settings_field,
			array(
				'header_scripts',
				'footer_scripts',
			)
		);

		genesis_add_option_filter(
			'url',
			$this->settings_field,
			array(
				'feed_uri',
				'comments_feed_uri',
			)
		);

		genesis_add_option_filter(
			'email_address',
			$this->settings_field,
			array(
				'update_email_address',
			)
		);

	}

	/**
	 * Contextual help content.
	 *
	 * @since 2.0.0
	 */
	public function help() {

		$this->add_help_tab( 'theme-settings', __( 'Theme Settings', 'genesis' ) );
		$this->add_help_tab( 'information', __( 'Information', 'genesis' ) );
		$this->add_help_tab( 'feeds', __( 'Custom Feeds', 'genesis' ) );
		$this->add_help_tab( 'layout', __( 'Default Layout', 'genesis' ) );
		$this->add_help_tab( 'header', __( 'Header', 'genesis' ) );

		if ( genesis_first_version_compare( '2.0.2', '<=' ) ) {
			$this->add_help_tab( 'navigation', __( 'Navigation', 'genesis' ) );
		}

		$this->add_help_tab( 'breadcrumbs', __( 'Breadcrumbs', 'genesis' ) );
		$this->add_help_tab( 'comments', __( 'Comments and Trackbacks', 'genesis' ) );
		$this->add_help_tab( 'archives', __( 'Content Archives', 'genesis' ) );
		$this->add_help_tab( 'blog', __( 'Blog Page', 'genesis' ) );
		$this->add_help_tab( 'scripts', __( 'Header and Footer Scripts', 'genesis' ) );
		$this->add_help_tab( 'home', __( 'Home Pages', 'genesis' ) );

		// Add help sidebar.
		$this->set_help_sidebar();

	}

	/**
	 * Register meta boxes on the Theme Settings page.
	 *
	 * Some of the meta box additions are dependent on certain theme support or user capabilities.
	 *
	 * The 'genesis_theme_settings_metaboxes' action hook is called at the end of this function.
	 *
	 * @since 1.0.0
	 */
	public function metaboxes() {

		add_action( 'genesis_admin_before_metaboxes', array( $this, 'customizer_notice' ) );
		add_action( 'genesis_admin_before_metaboxes', array( $this, 'hidden_fields' ) );

		$this->add_meta_box( 'genesis-theme-settings-version', __( 'Information', 'genesis' ), 'high' );

		if ( current_theme_supports( 'genesis-style-selector' ) ) {
			$this->add_meta_box( 'genesis-theme-settings-style-selector', __( 'Color Style', 'genesis' ) );
		}

		if ( genesis_first_version_compare( '2.6.0', '<=' ) ) {
			$this->add_meta_box( 'genesis-theme-settings-feeds', __( 'Custom Feeds', 'genesis' ) );
		}

		$this->add_meta_box( 'genesis-theme-settings-adsense', __( 'Google AdSense', 'genesis' ) );

		if ( genesis_has_multiple_layouts() ) {
			$this->add_meta_box( 'genesis-theme-settings-layout', __( 'Default Layout', 'genesis' ) );
		}

		if ( ! current_theme_supports( 'genesis-custom-header' ) && ! current_theme_supports( 'custom-header' ) ) {
			$this->add_meta_box( 'genesis-theme-settings-header', __( 'Header', 'genesis' ) );
		}

		if ( current_theme_supports( 'genesis-menus' ) && genesis_first_version_compare( '2.0.2', '<=' ) ) {
			$this->add_meta_box( 'genesis-theme-settings-nav', __( 'Navigation', 'genesis' ) );
		}

		if ( current_theme_supports( 'genesis-breadcrumbs' ) ) {
			$this->add_meta_box( 'genesis-theme-settings-breadcrumb', __( 'Breadcrumbs', 'genesis' ) );
		}

		$this->add_meta_box( 'genesis-theme-settings-comments', __( 'Comments and Trackbacks', 'genesis' ) );
		$this->add_meta_box( 'genesis-theme-settings-posts', __( 'Content Archives', 'genesis' ) );
		$this->add_meta_box( 'genesis-theme-settings-blogpage', __( 'Blog Page Template', 'genesis' ) );

		if ( current_user_can( 'unfiltered_html' ) ) {
			$this->add_meta_box( 'genesis-theme-settings-scripts', __( 'Header and Footer Scripts', 'genesis' ) );
		}

		/**
		 * Fires after Theme Settings meta boxes have been added.
		 *
		 * @since 1.7.0
		 *
		 * @param string $pagehook Page hook for the Theme Settings page.
		 */
		do_action( 'genesis_theme_settings_metaboxes', $this->pagehook );

	}

	/**
	 * Notify the user that settings are available in the Customizer.
	 *
	 * @since 2.6.0
	 *
	 * @param string $pagehook Name of the page hook when the menu is registered.
	 */
	public function customizer_notice( $pagehook ) {

		if ( $pagehook !== $this->pagehook ) {
			return;
		}

		printf(
			'<div class="notice notice-info"><p>%s</p><p>%s</p></div>',
			esc_html__( 'Hey there! Did you know that theme settings can now be configured with a live preview in the Customizer?', 'genesis' ),
			sprintf(
				/* translators: %s: Customizer admin URL */
				wp_kses_post( __( 'Eventually, settings pages like this one will no longer be available, and everything will be configured in the Customizer, so go ahead and <a href="%s">start using it now</a>!', 'genesis' ) ),
				esc_url( admin_url( 'customize.php?autofocus[panel]=genesis' ) )
			)
		);

	}

	/**
	 * Echo hidden form fields before the meta boxes.
	 *
	 * @since 1.8.0
	 *
	 * @param string $pagehook Page hook.
	 *
	 * @return void Return early if not on the right page.
	 */
	public function hidden_fields( $pagehook ) {

		if ( $pagehook !== $this->pagehook ) {
			return;
		}

		printf( '<input type="hidden" name="%s" value="%s" />', esc_attr( $this->get_field_name( 'theme_version' ) ), esc_attr( $this->get_field_value( 'theme_version' ) ) );
		printf( '<input type="hidden" name="%s" value="%s" />', esc_attr( $this->get_field_name( 'db_version' ) ), esc_attr( $this->get_field_value( 'db_version' ) ) );
		printf( '<input type="hidden" name="%s" value="%s" />', esc_attr( $this->get_field_name( 'first_version' ) ), esc_attr( $this->get_field_value( 'first_version' ) ) );

	}

	/**
	 * Save method.
	 *
	 * Adjust named settings before storing.
	 *
	 * @since 2.5.0
	 *
	 * @param mixed $new_value New value.
	 * @param mixed $old_value Old value.
	 * @return string Value to save.
	 */
	public function save( $new_value, $old_value ) {

		// Prevent filtering during upgrade.
		if ( isset( $new_value['upgrade'] ) ) {
			unset( $new_value['upgrade'] );
			return $new_value;
		}

		// Validate AdSense publisher id format.
		if ( isset( $new_value['adsense_id'] ) && 23 > strlen( $new_value['adsense_id'] ) ) {

			// Remove all but numbers.
			$adsense = preg_replace( '/[^0-9]/', '', $new_value['adsense_id'] );

			if ( 16 === strlen( $adsense ) ) {
				$new_value['adsense_id'] = 'ca-pub-' . $adsense;
			} else {
				$new_value['adsense_id'] = '';
			}

		}

		return $new_value;

	}

}