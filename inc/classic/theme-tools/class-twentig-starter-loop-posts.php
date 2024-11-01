<?php
/**
 * Allow starter content posts to display in the loop.
 *
 * Based on https://gist.github.com/westonruter/5e8fc5b2a972392d85af4d7befcbb8da (by Weston Ruter, XWP).
 *
 */
class Twentig_Starter_Loop_Posts {

	/**
	 * Auto draft post IDs in the current changeset.
	 */
	protected $changeset_auto_draft_post_ids = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'customize_preview_init', array( $this, 'make_auto_draft_post_queryable' ) );
	}

	/**
	 * Add hooks to ensure auto-draft posts from the current changeset are included in WP_Query results.
	 *
	 * @param WP_Customize_Manager $wp_customize Manager.
	 */
	public function make_auto_draft_post_queryable( WP_Customize_Manager $wp_customize ) {
		$this->changeset_auto_draft_post_ids = $wp_customize->get_setting( 'nav_menus_created_posts' )->value();
		if ( empty( $this->changeset_auto_draft_post_ids ) ) {
			return;
		}
		add_action( 'pre_get_posts', array( $this, 'prevent_filter_suppression' ), 100, 2 );
		add_filter( 'posts_where', array( $this, 'filter_posts_where_to_include_post_stubs' ) );
	}

	/**
	 * Make sure that the posts_where filter will be applied.
	 *
	 * @param WP_Query $query The WP_Query instance.
	 */
	public function prevent_filter_suppression( WP_Query $query ) {
		$query->set( 'suppress_filters', false );
	}

	/**
	 * Filter SQL WHERE clause for posts queries to exclude auto-draft posts that aren't part of the current changeset.
	 *
	 * @param string $where The WHERE clause of the query.
	 * @return string Amended SQL WHERE.
	 */
	public function filter_posts_where_to_include_post_stubs( $where ) {
		global $wpdb;

		$old_condition  = "{$wpdb->posts}.post_status = 'publish'";
		$new_condition  = "( $old_condition OR ( ";
		$new_condition .= "{$wpdb->posts}.post_status = 'auto-draft' ";
		$new_condition .= ' AND ';
		$new_condition .= sprintf(
			"{$wpdb->posts}.ID IN ( %s )",
			join( ', ', array_map( 'intval', $this->changeset_auto_draft_post_ids ) )
		);
		$new_condition .= '))';
		$where          = str_replace( $old_condition, $new_condition, $where );

		return $where;
	}
}
new Twentig_Starter_Loop_Posts();
