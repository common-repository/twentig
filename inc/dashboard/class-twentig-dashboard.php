<?php

/**
 * Twentig dashboard class.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TwentigDashboard {

	private static $instance;
	private $website_importer;
	private $settings_manager;

	/**
	 * Gets class instance.
	 *
	 * @return object Instance.
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Initializes the dashboard.
	 */
	protected function __construct() {
		$this->load_dependencies();

		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_init', array( $this, 'redirect_dashboard' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'rest_api_init', array( $this, 'register_routes' ), 10, 2 );
	}

	/**
	 * Loads the required dependencies for the Twentig dashboard.
	 */
	private function load_dependencies() {
		require_once TWENTIG_PATH . 'inc/dashboard/class-twentig-website-importer.php';
		require_once TWENTIG_PATH . 'inc/dashboard/class-twentig-settings.php';

		$this->website_importer = new TwentigWebsiteImporter();
		$this->settings_manager = new TwentigSettings();
	}

	/**
	 * Adds a menu item for Twentig dashboard in the WordPress admin panel.
	 */
	public function add_menu() {
		add_menu_page(
			'Twentig',
			'Twentig',
			'edit_pages',
			'twentig',
			array( $this, 'render_menu_page' ),
			'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyMCAyMCI+PHBhdGggZmlsbD0iYmxhY2siIGQ9Ik0yMCA1LjUzOXEtLjAwMi0uMzAyLS4wMS0uNjAzYTguNzI1IDguNzI1IDAgMDAtLjExNS0xLjMxMyA0LjQzNiA0LjQzNiAwIDAwLS40MTItMS4yNUE0LjIgNC4yIDAgMDAxNy42MjcuNTM3IDQuNDUyIDQuNDUyIDAgMDAxNi4zOC4xMjUgOC43MjUgOC43MjUgMCAwMDE1LjA2NC4wMXEtLjMtLjAwOC0uNjAzLS4wMUg1LjU0cS0uMzAyLjAwMi0uNjA0LjAxYTguODI3IDguODI3IDAgMDAtMS4zMTMuMTE1IDQuNDQ0IDQuNDQ0IDAgMDAtMS4yNDguNDEyQTQuMiA0LjIgMCAwMC41MzggMi4zNzNhNC40MjIgNC40MjIgMCAwMC0uNDEyIDEuMjVBOC42MDQgOC42MDQgMCAwMC4wMSA0LjkzNXEtLjAwNy4zMDItLjAwOC42MDRDMCA1Ljc3OSAwIDYuMDE3IDAgNi4yNTZ2Ny40ODhjMCAuMjM5IDAgLjQ3Ny4wMDIuNzE2IDAgLjIwMS4wMDMuNDAzLjAwOC42MDRhOC43ODQgOC43ODQgMCAwMC4xMTYgMS4zMTMgNC40MzEgNC40MzEgMCAwMC40MTIgMS4yNSA0LjIgNC4yIDAgMDAxLjgzNiAxLjgzNSA0LjQyOSA0LjQyOSAwIDAwMS4yNDguNDEzIDguNzE1IDguNzE1IDAgMDAxLjMxNC4xMTVxLjMwMS4wMDguNjAzLjAxaDguMjA1bC43MTctLjAwMnEuMzAyIDAgLjYwMy0uMDA5YTguNzI0IDguNzI0IDAgMDAxLjMxNS0uMTE1IDQuNDI2IDQuNDI2IDAgMDAxLjI0OC0uNDEyIDQuMiA0LjIgMCAwMDEuODM2LTEuODM2IDQuNDE3IDQuNDE3IDAgMDAuNDEyLTEuMjQ5IDguNzM1IDguNzM1IDAgMDAuMTE1LTEuMzEzYy4wMDUtLjIwMS4wMDgtLjQwMy4wMS0uNjA0VjUuODQyek0xNS4xMTMgMTRoLTEuMkwxMi4zNSA5LjcyNyAxMC43ODcgMTRIOS42TDcuNzMxIDguODM3SDUuMjY0djIuNjI5YTEuMTYgMS4xNiAwIDAwMS4yIDEuMjI2IDIuMDM4IDIuMDM4IDAgMDAuNTEyLS4wOGwuMDggMS4zMmExLjkyNiAxLjkyNiAwIDAxLS44MDguMTYyIDIuMzUgMi4zNSAwIDAxLTIuNDgtMi41NlY4LjgzNkgyLjVWNy40MDhoMS4yNjdWNS42NDJoMS40OTd2MS43NjZoMy41NTRsMS4zODkgNC4yNzMgMS41MzctNC4yNzNoMS4yMTNsMS41NSA0LjI3MyAxLjM4OS00LjI3M0gxNy41eiIvPjwvc3ZnPg=='
		);
	}

	/**
	 * Renders the Twentig dashboard page.
	 */
	public function render_menu_page() {
		if ( isset( $_GET['setting-updated'] ) ) {
			flush_rewrite_rules( false );
		}
		?>
		<div id="twentig-dashboard"></div>
		<?php
	}

	/**
	 * Redirects to the Twentig dashboard on single plugin activation.
	 */
	public function redirect_dashboard() {
		if ( get_transient( '_twentig_activation_redirect' ) && apply_filters( 'twentig_enable_activation_redirect', true ) ) {
			$do_redirect = true;
			delete_transient( '_twentig_activation_redirect' );

			if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
				$do_redirect = false;
			}

			if ( $do_redirect ) {
				wp_safe_redirect( esc_url( admin_url( 'admin.php?page=twentig' ) ) );
				exit;
			}
		}
	}

	/**
	 * Registers the necessary REST API routes.
	 */
	public function register_routes() {
		$this->website_importer->register_routes();
		$this->settings_manager->register_routes();
	}

	/**
	 * Enqueues admin scripts (JS and CSS).
	 */
	public function admin_enqueue_scripts() {

		if ( in_array( get_current_screen()->base, array( 'toplevel_page_twentig' ), true ) ) {
			$asset_file = include plugin_dir_path( dirname( __DIR__ ) ) . 'dist/index.asset.php';

			foreach ( $asset_file['dependencies'] as $style ) {
				wp_enqueue_style( $style );
			}

			wp_enqueue_style( 'twentig-editor', plugins_url( 'dist/index.css', dirname( __DIR__ ) ), array(), $asset_file['version'] );
			wp_enqueue_script( 'twentig-homescreen', plugins_url( 'dist/index.js', dirname( __DIR__ ) ), $asset_file['dependencies'], $asset_file['version'] );

			$config = array(
				'theme'        => get_template(),
				'isBlockTheme' => wp_is_block_theme(),
				'cssClasses'   => array(),
				'spacingSizes' => array(),
			);

			wp_localize_script( 'twentig-homescreen', 'twentigEditorConfig', $config );

			if ( function_exists( 'wp_set_script_translations' ) ) {
				wp_set_script_translations( 'twentig-homescreen', 'twentig' );
			}

			global $wp_version;

			$plugin            = 'twentig/twentig.php';
			$plugin_update_url = wp_nonce_url( self_admin_url( 'update.php?return=kit-importer&action=upgrade-plugin&plugin=' . $plugin ), 'upgrade-plugin_' . $plugin );

			$default_theme_slug = 'twentytwentyfour';
			$defaultThemeURL    = '';

			if ( wp_get_theme( $default_theme_slug )->exists() ) {
				$defaultThemeURL = wp_nonce_url( admin_url( 'themes.php?action=activate&amp;stylesheet=' . urlencode( $default_theme_slug ) ), 'switch-theme_' . $default_theme_slug );
			} else {
				$defaultThemeURL = self_admin_url( 'theme-install.php?search=' . $default_theme_slug );
			}

			$home_template = get_block_template( get_stylesheet() . '//home', 'wp_template' );
			$blog_template = $home_template ? 'home' : 'index';

			$typography_settings = get_option('twentig_typography', array( 'local' => true ) );
			$google_fonts        = empty( $typography_settings['font1'] ) && empty( $typography_settings['font2'] ) && class_exists( 'WP_Font_Library' ) ? array() : twentig_get_fonts_data();
		
			wp_localize_script(
				'twentig-homescreen',
				'twentigDashboardConfig',
				array(
					'siteUrl'            => esc_url( get_home_url() ),
					'editorUrl'          => esc_url( admin_url( 'site-editor.php' ) ),
					'defaultThemeUrl'    => $defaultThemeURL,
					'assetsUrl'          => TWENTIG_ASSETS_URI . '/images/',
					'theme'              => get_template(),
					'isBlockTheme'       => wp_is_block_theme(),
					'isTwentigTheme'     => current_theme_supports( 'twentig-theme' ),
					'blogTemplate'       => $blog_template,
					'wpVersion'          => $wp_version,
					'updateWordPressUrl' => current_user_can( 'update_core' ) ? network_admin_url( 'update-core.php' ) : '',
					'twentigVersion'     => TWENTIG_VERSION,
					'updateTwentigUrl'   => current_user_can( 'update_plugins' ) ? $plugin_update_url : '',
					'deletePrevious'     => $this->website_importer->has_imported_posts(),
					'isFreshSite'        => get_option( 'fresh_site' ) ? '1' : '0',
					'twentigOptions'     => twentig_get_options(),
					'typographyOptions'  => get_option( 'twentig_typography', array( 'local' => true ) ),
					'googleFontsData'    => $google_fonts,
					'fontLibraryEnabled' => class_exists( 'WP_Font_Library' ),
					'starterTemplates'   => $this->website_importer->get_website_templates(),
				)
			);
		}
	}

}
TwentigDashboard::get_instance();
