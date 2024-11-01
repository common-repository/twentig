<?php
/**
 * Customize Dropdown Reusable Blocks Control class.
 *
 * @package twentig
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Dropdown reusable blocks control.
	 */
	class Twentig_Customize_Dropdown_Reusable_Blocks_Control extends WP_Customize_Control {
		/**
		 * Type.
		 *
		 * @var string
		 */
		public $type = 'twentig-dropdown-reusable-blocks';

		/**
		 * Render the content of the dropdown reusable blocks control.
		 */
		public function render_content() {
			$input_id         = '_customize-input-' . $this->id;
			$description_id   = '_customize-description-' . $this->id;
			$describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';
			?>

			<?php if ( ! empty( $this->label ) ) : ?>
				<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo ( $this->description ); ?></span>
			<?php endif; ?>

			<?php

			$blocks = get_posts(
				array(
					'post_type'   => 'wp_block',
					'numberposts' => 100,
				)
			);

			$choices = array(
				0 => esc_html__( '&mdash; Select &mdash;' ),
			);

			foreach ( $blocks as $block ) {
				$choices[ $block->ID ] = $block->post_title;
			}

			?>

			<select id="<?php echo esc_attr( $input_id ); ?>" <?php echo esc_html( $describedby_attr ); ?> <?php $this->link(); ?>>
				<?php
				foreach ( $choices as $value => $label ) {
					echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . esc_html( $label ) . '</option>';
				}
				?>
			</select>

			<?php
		}
	}
}
