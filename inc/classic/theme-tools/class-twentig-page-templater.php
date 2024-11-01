<?php
/**
 * Twentig_Page_Templater class
 *
 * @link https://github.com/tommcfarlin/page-template-example
 *
 * @package twentig
 */

/**
 * Class used for creating page templates.
 */
class Twentig_Page_Templater {

	/**
	 * Container for the main instance of the class.
	 *
	 * @var Twentig_Page_Templater|null
	 */
	private static $instance;

	/**
	 * Registered templates array.
	 *
	 * @var array
	 */
	protected $templates;

	/**
	 * Returns an instance of this class.
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new Twentig_Page_Templater();
		}

		return self::$instance;
	}

	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	private function __construct() {

		$this->templates = array(
			'tw-no-title.php'                 => esc_html_x( 'Twentig - No title', 'page template name', 'twentig' ),
			'tw-no-header-footer.php'         => esc_html_x( 'Twentig - No header, no footer', 'page template name', 'twentig' ),
			'tw-header-transparent.php'       => esc_html_x( 'Twentig - Transparent header', 'page template name', 'twentig' ),
			'tw-header-transparent-light.php' => esc_html_x( 'Twentig - Transparent header light', 'page template name', 'twentig' ),
		);

		$this->templates = apply_filters( 'twentig_template_pages', $this->templates );

		add_filter( 'theme_page_templates', array( $this, 'add_new_template' ) );
		add_filter( 'wp_insert_post_data', array( $this, 'register_project_templates' ) );
		add_filter( 'template_include', array( $this, 'view_project_template' ) );
	}

	/**
	 * Adds the templates to the page dropdown
	 *
	 * @param array $page_templates Page templates.
	 */
	public function add_new_template( $page_templates ) {
		$page_templates = array_merge( $page_templates, $this->templates );
		return $page_templates;
	}

	/**
	 * Adds the templates to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doesn't really exist.
	 *
	 * @param  array $atts The attributes for the page attributes dropdown.
	 */
	public function register_project_templates( $atts ) {

		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		}

		wp_cache_delete( $cache_key, 'themes' );
		$templates = array_merge( $templates, $this->templates );
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;
	}

	/**
	 * Checks if the template is assigned to the page
	 *
	 * @param string $template The path of the template to include.
	 */
	public function view_project_template( $template ) {

		global $post;

		if ( is_search() ) {
			return $template;
		}

		if ( ! $post ) {
			return $template;
		}

		if ( ! isset( $this->templates[ get_post_meta( $post->ID, '_wp_page_template', true ) ] ) ) {
			return $template;
		}

		$template_path = TWENTIG_PATH . 'inc/classic/' . get_template() . '/templates/';
		$template_name = get_post_meta( $post->ID, '_wp_page_template', true );
		$post_type     = get_post_type( $post );
		$file          = apply_filters( 'twentig_template_page_file', $template_path . $template_name, $template_name );

		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		return $template;
	}

}
add_action( 'plugins_loaded', array( 'Twentig_Page_Templater', 'get_instance' ) );
