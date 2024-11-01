<?php
/**
 * Twentig_Nav_Menu class
 *
 * @package twentig
 */

/**
 * Class used to separate menu action items from the menu navigation.
 */
class Twentig_Nav_Menu {

	/**
	 * Menu items for header actions.
	 *
	 * @var array
	 */
	public $action_menu_items;

	/**
	 * Indicate if the menu has text items.
	 *
	 * @var boolean
	 */
	public $has_text_menu_items = true;

	/**
	 * Instantiate the object.
	 */
	public function __construct() {
		$this->action_menu_items = array();
		add_filter( 'wp_nav_menu_objects', array( $this, 'twentig_twentyone_filter_primary_nav_menu_objects' ), 10, 2 );
		add_filter( 'walker_nav_menu_start_el', array( $this, 'twentig_twentyone_nav_menu_social_icons' ), 10, 4 );
		add_filter( 'wp_nav_menu', array( $this, 'twentig_twentyone_custom_primary_nav' ), 10, 2 );
	}

	/**
	 * Filter primary nav menu to store actions nav items.
	 *
	 * @param array    $items The menu items.
	 * @param stdClass $args  An object containing wp_nav_menu() arguments.
	 */
	public function twentig_twentyone_filter_primary_nav_menu_objects( $items, $args ) {
		$menu_items  = $items;
		$has_socials = get_theme_mod( 'twentig_header_social_icons', false );
		$has_button  = get_theme_mod( 'twentig_header_button', false );

		if ( 'primary' === $args->theme_location && ( $has_socials || $has_button ) ) {
			foreach ( $items as $index => &$item ) {
				if ( $has_socials ) {
					$svg = twenty_twenty_one_get_social_link_svg( $item->url );
					if ( ! empty( $svg ) ) {
						$item->classes[]           = 'social-item';
						$this->action_menu_items[] = $item;
						$item                      = array();
						continue;
					}
				}

				if ( $has_button && $index === count( $items ) ) {
					$item->classes[]           = 'menu-button';
					$this->action_menu_items[] = $item;
					$item                      = array();
				}
			}
			if ( count( $this->action_menu_items ) === count( $menu_items ) ) {
				$this->has_text_menu_items = false;
				return $menu_items;
			}
		}
		return $items;
	}

	/**
	 * Replace menu with social icons.
	 *
	 * @param string   $item_output The menu item's starting HTML output.
	 * @param WP_Post  $item        Menu item data object.
	 * @param int      $depth       Depth of the menu.
	 * @param stdClass $args       An object of wp_nav_menu() arguments.
	 */
	public function twentig_twentyone_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
		// Change SVG icon inside social links menu if there is supported URL.
		if ( get_theme_mod( 'twentig_header_social_icons', false ) && 'primary' === $args->theme_location ) {
			$svg = twenty_twenty_one_get_social_link_svg( $item->url, 24 );
			if ( ! empty( $svg ) ) {
				$icon_output = $svg . $item->title . '</span>';
				$item_output = str_replace( $item->title, $icon_output, $item_output );
			}
		}

		return $item_output;
	}

	/**
	 * Header menu actions output.
	 *
	 * @param string   $nav_menu The HTML content for the navigation menu.
	 * @param stdClass $args     An object containing wp_nav_menu() arguments.
	 */
	public function twentig_twentyone_custom_primary_nav( $nav_menu, $args ) {
		if ( 'primary' === $args->theme_location ) {
			$menu = '';
			if ( get_theme_mod( 'twentig_header_search', false ) ) {
				$menu .= '<li class="menu-search">' . $this->twentig_twentyone_get_search_form() . '</li>';
			}
			$menu .= walk_nav_menu_tree( $this->action_menu_items, 0, $args );
			if ( $menu ) {
				if ( ! $this->has_text_menu_items ) {
					$nav_menu = '<div class="primary-menu-container"><ul class="header-actions">' . $menu . '</ul></div>';
				} else {
					$nav_menu = str_replace( '</div>', '<ul class="header-actions">' . $menu . '</ul></div>', $nav_menu );
				}
			}
			return $nav_menu;
		}
		return $nav_menu;
	}

	/**
	 * Search form output.
	 */
	public function twentig_twentyone_get_search_form() {

		ob_start();
		$twentytwentyone_unique_id = wp_unique_id( 'search-form-' );
		?>
		<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label for="<?php echo esc_attr( $twentytwentyone_unique_id ); ?>" class="screen-reader-text"><?php _e( 'Search&hellip;', 'twentytwentyone' ); // phpcs:ignore: WordPress.Security.EscapeOutput.UnsafePrintingFunction -- core trusts translations ?></label>
			<input type="search" autocomplete="off" id="<?php echo esc_attr( $twentytwentyone_unique_id ); ?>" placeholder="<?php _e( 'Search&hellip;', 'twentytwentyone' ); // phpcs:ignore: WordPress.Security.EscapeOutput.UnsafePrintingFunction -- core trusts translations ?>" class="search-field" value="" name="s" />
			<button type="submit" class="search-submit" aria-label="<?php echo esc_attr_x( 'Search', 'submit button', 'twentytwentyone' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M1.5 11.4a8.323 8.323 0 008.25 8.25 7.86 7.86 0 005.4-2.1l5.1 4.35 1.5-1.65-5.1-4.5a7.937 7.937 0 001.35-4.5A8.323 8.323 0 009.75 3a8.355 8.355 0 00-8.25 8.4zm2.25-.15a6 6 0 116 6 6.018 6.018 0 01-6-6z"/></svg>
			</button>
		</form>

		<?php
		$form = ob_get_clean();
		return $form;
	}

}
