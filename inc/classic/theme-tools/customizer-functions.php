<?php
/**
 * Functions for the Customizer
 *
 * @package twentig
 */

/**
 * Sanitize select.
 *
 * @param string $choice  The value from the setting.
 * @param object $setting The selected setting.
 */
function twentig_sanitize_choices( $choice, $setting ) {
	$choice  = sanitize_key( $choice );
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return ( array_key_exists( $choice, $choices ) ? $choice : $setting->default );
}

/**
 * Sanitize multiple choices.
 *
 * @param array $value Array holding values from the setting.
 */
function twentig_sanitize_multi_choices( $value ) {
	$value = ! is_array( $value ) ? explode( ',', $value ) : $value;
	return ( ! empty( $value ) ? array_map( 'sanitize_text_field', $value ) : array() );
}

/**
 * Sanitize fonts choices.
 *
 * @param string $choice  The value from the setting.
 * @param object $setting The selected setting.
 */
function twentig_sanitize_fonts( $choice, $setting ) {
	$choices = $setting->manager->get_control( $setting->id )->choices;
	$choices = call_user_func_array( 'array_merge', array_values( $choices ) );
	return ( array_key_exists( $choice, $choices ) ? $choice : $setting->default );
}

/**
 * Sanitizes font-weight value.
 *
 * @param string $choice  The value from the setting.
 * @param object $setting The selected setting.
 */
function twentig_sanitize_font_weight( $choice, $setting ) {
	$valid = array( '100', '200', '300', '400', '500', '600', '700', '800', '900' );
	if ( in_array( $choice, $valid, true ) ) {
		return $choice;
	}
	return $setting->default;
}

/**
 * Sanitizes integer.
 *
 * @param int $value The value from the setting.
 */
function twentig_sanitize_integer( $value ) {
	if ( ! $value || is_null( $value ) ) {
		return $value;
	}
	return intval( $value );
}

/**
 * Sanitizes float.
 *
 * @param float $value The value from the setting.
 */
function twentig_sanitize_float( $value ) {
	if ( ! $value || is_null( $value ) ) {
		return $value;
	}
	return floatval( $value );
}

/**
 * Sanitizes reusable block id.
 *
 * @param int $block_id The block id.
 */
function twentig_sanitize_block_id( $block_id ) {
	$block_id = absint( $block_id );
	if ( $block_id && 'wp_block' === get_post_type( $block_id ) ) {
		return $block_id;
	}
	return 0;
}

/**
 * Renders the HTML block content of the referenced block.
 *
 * @param int $block_id The block id.
 * @see render_block_core_block()
 */
function twentig_render_reusable_block( $block_id ) {

	if ( empty( $block_id ) ) {
		return '';
	}

	$block_query = new WP_Query(
		array(
			'p'           => $block_id,
			'post_type'   => 'wp_block',
			'post_status' => 'publish',
		)
	);

	if ( $block_query->have_posts() ) {
		while ( $block_query->have_posts() ) {
			$block_query->the_post();
			the_content();
		}
	}
	wp_reset_postdata();
}

/**
 * Determines if AMP
 */
function twentig_is_amp_endpoint() {
	if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
		return true;
	}
	return false;
}
