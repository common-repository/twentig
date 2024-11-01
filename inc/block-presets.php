<?php
/**
 * Twentig utility classes for blocks.
 *
 * @package twentig
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Retrieves additional CSS classes for blocks.
 */
function twentig_get_block_css_classes() {

	$classes = array(

		'core/paragraph'             => array(
			'tw-eyebrow'              => __( 'Make the text small and uppercase.', 'twentig' ),
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-link-no-underline'    => __( 'Remove underline from link.', 'twentig' ),
			'tw-text-shadow'          => __( 'Add shadow to text.', 'twentig' ),
			'tw-text-gradient'        => __( 'Apply background gradient to text.', 'twentig' ),
			'tw-highlight-padding'    => __( 'Add padding to the highlighted text’s background.', 'twentig' ),
			'tw-rounded'              => __( 'Make the corners of the block rounded if a background color is set.', 'twentig' ),
			'tw-md-text-left'         => __( 'Align text left on tablet and mobile.', 'twentig' ),
			'tw-md-text-center'       => __( 'Align text center on tablet and mobile.', 'twentig' ),
			'tw-md-text-right'        => __( 'Align text right on tablet and mobile.', 'twentig' ),
			'tw-sm-text-left'         => __( 'Align text left on mobile.', 'twentig' ),
			'tw-sm-text-center'       => __( 'Align text center on mobile.', 'twentig' ),
			'tw-sm-text-right'        => __( 'Align text right on mobile.', 'twentig' ),
		),
		'core/heading'               => array(
			'tw-link-hover-underline'  => __( 'Underline link only on hover.', 'twentig' ),
			'tw-link-no-underline'     => __( 'Remove underline from link.', 'twentig' ),
			'tw-heading-border-bottom' => __( 'Add a border below the heading.', 'twentig' ),
			'tw-heading-dash-bottom'   => __( 'Add a short line below the heading.', 'twentig' ),
			'tw-text-shadow'           => __( 'Add shadow to text.', 'twentig' ),
			'tw-text-gradient'         => __( 'Apply background gradient to text.', 'twentig' ),
			'tw-highlight-padding'     => __( 'Add padding to the highlighted text’s background.', 'twentig' ),
			'tw-eyebrow'               => __( 'Make the text small and uppercase.', 'twentig' ),
			'tw-rounded'               => __( 'Make the corners of the block rounded if a background color is set.', 'twentig' ),
			'tw-md-text-left'          => __( 'Align text left on tablet and mobile.', 'twentig' ),
			'tw-md-text-center'        => __( 'Align text center on tablet and mobile.', 'twentig' ),
			'tw-md-text-right'         => __( 'Align text right on tablet and mobile.', 'twentig' ),
			'tw-sm-text-left'          => __( 'Align text left on mobile.', 'twentig' ),
			'tw-sm-text-center'        => __( 'Align text center on mobile.', 'twentig' ),
			'tw-sm-text-right'         => __( 'Align text right on mobile.', 'twentig' ),
		),
		'core/post-title'            => array(
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-link-no-underline'    => __( 'Remove underline from link.', 'twentig' ),
			'tw-text-shadow'          => __( 'Add shadow to text.', 'twentig' ),
			'tw-text-gradient'        => __( 'Apply background gradient to text.', 'twentig' ),
			'tw-md-text-left'         => __( 'Align text left on tablet and mobile.', 'twentig' ),
			'tw-md-text-center'       => __( 'Align text center on tablet and mobile.', 'twentig' ),
			'tw-md-text-right'        => __( 'Align text right on tablet and mobile.', 'twentig' ),
			'tw-sm-text-left'         => __( 'Align text left on mobile.', 'twentig' ),
			'tw-sm-text-center'       => __( 'Align text center on mobile.', 'twentig' ),
			'tw-sm-text-right'        => __( 'Align text right on mobile.', 'twentig' ),
		),
		'core/list'                  => array(
			'has-text-align-center'   => __( 'Align text center.', 'twentig' ),
			'tw-list-spacing-medium'  => __( 'Set a medium spacing between the list items.', 'twentig' ),
			'tw-list-spacing-loose'   => __( 'Set a loose spacing between the list items.', 'twentig' ),
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-highlight-padding'    => __( 'Add padding to the highlighted text’s background.', 'twentig' ),
		),
		'core/table'                 => array(
			'tw-row-valign-top' => __( 'Vertically align top the text in the cells.', 'twentig' ),
		),
		'core/group'                 => array(
			'tw-height-full'          => __( 'Make the block full height.', 'twentig' ),
			'tw-height-100'           => __( 'Make the block height 100%.', 'twentig' ),
			'tw-width-100'            => __( 'Make the block width 100%.', 'twentig' ),
			'tw-layout-inline'        => __( 'Arrange blocks inline.', 'twentig' ),
			'tw-group-overlap-bottom' => __( 'Make the last block of the group overlap the group just below.', 'twentig' ),
			'tw-rounded'              => __( 'Make the corners of the block rounded.', 'twentig' ),
			'tw-backdrop-blur'        => __( 'Apply backdrop blur filter.', 'twentig' ),
			'tw-md-justify-start'     => __( 'Justify items from the start on tablet and mobile.', 'twentig' ),
			'tw-md-justify-center'    => __( 'Justify items center on tablet and mobile.', 'twentig' ),
			'tw-md-justify-end'       => __( 'Justify items from the end on tablet and mobile.', 'twentig' ),
			'tw-sm-justify-start'     => __( 'Justify items from the start on mobile.', 'twentig' ),
			'tw-sm-justify-center'    => __( 'Justify items center on mobile.', 'twentig' ),
			'tw-sm-justify-end'       => __( 'Justify items from the end on mobile.', 'twentig' ),
			'tw-align-baseline'       => __( 'Align items baseline.', 'twentig' ),
		),
		'core/columns'               => array(
			'tw-stretched-blocks'   => __( 'Make the blocks inside the columns (Image, Group, Cover) the same height.', 'twentig' ),
			'tw-justify-center'     => __( 'Center the columns horizontally.', 'twentig' ),
			'has-text-align-center' => __( 'Align text center.', 'twentig' ),
		),
		'core/column'                => array(
			'tw-rounded'        => __( 'Make the corners of the block rounded.', 'twentig' ),
			'tw-md-order-first' => __( 'Order first on tablet and mobile.', 'twentig' ),
			'tw-md-order-last'  => __( 'Order last on tablet and mobile.', 'twentig' ),
			'tw-sm-order-first' => __( 'Order first on mobile.', 'twentig' ),
			'tw-sm-order-last'  => __( 'Order last on mobile.', 'twentig' ),
			'tw-empty-hidden'   => __( 'Hide column if empty.', 'twentig' ),
		),
		'core/cover'                 => array(
			'tw-content-width-100' => __( 'Make the inner content width 100%.', 'twentig' ), 
			'tw-img-bw'            => __( 'Add a black & white filter to the image.', 'twentig' ),
		),
		'core/media-text'            => array(
			'tw-media-narrow'   => __( 'Limit the media width when the media and the text are stacked.', 'twentig' ),
			'tw-height-full'    => __( 'Make the block full height. You must enable the “Crop image to fill entire column” setting.', 'twentig' ),
			'tw-rounded'        => __( 'Make the corners of the block rounded.', 'twentig' ),
			'tw-img-rounded'    => __( 'Make the corners of the image rounded.', 'twentig' ),
		),
		'core/image'                 => array(
			'tw-img-bw'        => __( 'Add a black & white filter to the image.', 'twentig' ),
			'tw-caption-large' => __( 'Make the font size of the caption larger.', 'twentig' ),
		),
		'core/post-featured-image'   => array(
			'tw-img-bw' => __( 'Add a black & white filter to the image.', 'twentig' ),
		),
		'core/gallery'               => array(
			'tw-caption-large'      => __( 'Make the font size of the caption larger.', 'twentig' ),
			'tw-hover-show-caption' => __( 'Reveal the caption on hover.', 'twentig' ),
			'tw-img-border'         => __( 'Add a border around the images (useful for logos and illustrations).', 'twentig' ),
			'tw-img-border-inner'   => __( 'Add an inner border between the images (useful for logos).', 'twentig' ),
			'tw-img-bw'             => __( 'Add a black & white filter to the images.', 'twentig' ),
			'tw-img-center'         => __( 'Center the images of the last row. You must enable the “Fixed width columns” setting.', 'twentig' ),
			'tw-text-shadow'        => __( 'Add shadow to text.', 'twentig' ),
		),
		'core/embed'                 => array(
			'is-style-tw-frame' => __( 'Add a frame around the block.', 'twentig' ),
		),
		'core/video'                 => array(
			'is-style-tw-frame' => __( 'Add a frame around the block.', 'twentig' ),
		),
		'core/buttons'               => array(
			'tw-md-justify-start'  => __( 'Justify items from the start on tablet and mobile.', 'twentig' ),
			'tw-md-justify-center' => __( 'Justify items center on tablet and mobile.', 'twentig' ),
			'tw-md-justify-end'    => __( 'Justify items from the end on tablet and mobile.', 'twentig' ),
			'tw-sm-justify-start'  => __( 'Justify items from the start on mobile.', 'twentig' ),
			'tw-sm-justify-center' => __( 'Justify items center on mobile.', 'twentig' ),
			'tw-sm-justify-end'    => __( 'Justify items from the end on mobile.', 'twentig' ),
		),
		'core/social-links'          => array(
			'tw-md-justify-start'  => __( 'Justify items from the start on tablet.', 'twentig' ),
			'tw-md-justify-center' => __( 'Justify items center on tablet.', 'twentig' ),
			'tw-md-justify-end'    => __( 'Justify items from the end on tablet.', 'twentig' ),
			'tw-sm-justify-start'  => __( 'Justify items from the start on mobile.', 'twentig' ),
			'tw-sm-justify-center' => __( 'Justify items center on mobile.', 'twentig' ),
			'tw-sm-justify-end'    => __( 'Justify items from the end on mobile.', 'twentig' ),
		),
		'core/latest-posts'          => array(
			'tw-posts-rounded'      => __( 'Make the corners of the cards rounded.', 'twentig' ),
			'tw-img-rounded'        => __( 'Make the corners of the image rounded.', 'twentig' ),
			'has-text-align-center' => __( 'Align text center.', 'twentig' ),
		),
		'core/post-date'             => array(
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-link-no-underline'    => __( 'Remove underline from link.', 'twentig' ),
		),
		'core/post-terms'            => array(
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-link-no-underline'    => __( 'Remove underline from link.', 'twentig' ),
		),
		'core/post-author'           => array(
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-link-no-underline'    => __( 'Remove underline from link.', 'twentig' ),
		),
		'core/query-pagination' => array(
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-link-no-underline'    => __( 'Remove underline from link.', 'twentig' ),
		),
		'core/query-pagination-next' => array(
			'tw-ml-auto' => __( 'Set margin-left to auto.', 'twentig' ),
		),
		'core/read-more'             => array(
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-link-no-underline'    => __( 'Remove underline from link.', 'twentig' ),
		),
		'core/query-title'           => array(
			'tw-text-shadow'    => __( 'Add shadow to text.', 'twentig' ),
			'tw-text-gradient'  => __( 'Apply background gradient to text.', 'twentig' ),
			'tw-md-text-left'   => __( 'Align text left on tablet and mobile.', 'twentig' ),
			'tw-md-text-center' => __( 'Align text center on tablet and mobile.', 'twentig' ),
			'tw-md-text-right'  => __( 'Align text right on tablet and mobile.', 'twentig' ),
			'tw-sm-text-left'   => __( 'Align text left on mobile.', 'twentig' ),
			'tw-sm-text-center' => __( 'Align text center on mobile.', 'twentig' ),
			'tw-sm-text-right'  => __( 'Align text right on mobile.', 'twentig' ),
		),
		'core/categories'            => array(
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-no-bullet'            => __( 'Remove bullet from list.', 'twentig' ),
		),
		'core/archives'              => array(
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-no-bullet'            => __( 'Remove bullet from list.', 'twentig' ),
		),
		'core/site-title'            => array(
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-link-no-underline'    => __( 'Remove underline from link.', 'twentig' ),
			'tw-text-shadow'          => __( 'Add shadow to text.', 'twentig' ),
			'tw-text-gradient'        => __( 'Apply background gradient to text.', 'twentig' ),
		),
		'core/separator'             => array(
			'tw-ml-0' => __( 'Set margin-left to 0.', 'twentig' ),
			'tw-mr-0' => __( 'Set margin-right to 0.', 'twentig' ),
		),
		'core/post-navigation-link'  => array(
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-link-no-underline'    => __( 'Remove underline from link.', 'twentig' ),
			'tw-md-text-left'         => __( 'Align text left on tablet and mobile.', 'twentig' ),
			'tw-md-text-center'       => __( 'Align text center on tablet and mobile.', 'twentig' ),
			'tw-md-text-right'        => __( 'Align text right on tablet and mobile.', 'twentig' ),
			'tw-sm-text-left'         => __( 'Align text left on mobile.', 'twentig' ),
			'tw-sm-text-center'       => __( 'Align text center on mobile.', 'twentig' ),
			'tw-sm-text-right'        => __( 'Align text right on mobile.', 'twentig' ),
		),
		'core/tag-cloud'             => array(
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-link-no-underline'    => __( 'Remove underline from link.', 'twentig' ),
		),
		'core/post-comments-form'    => array(
			'tw-form-rounded' => __( 'Make the corners of the input and textarea rounded.', 'twentig' ),
		),
	);

	if ( wp_is_block_theme() ) {
		unset( $classes['core/paragraph']['tw-eyebrow'] );
		unset( $classes['core/heading']['tw-eyebrow'] );
		unset( $classes['core/group']['tw-height-full'] );
		unset( $classes['core/media-text']['tw-media-narrow'] );
	} else {
		unset( $classes['core/group']['tw-layout-inline'] );
	}

	return apply_filters( 'twentig_block_classes', $classes );
}
