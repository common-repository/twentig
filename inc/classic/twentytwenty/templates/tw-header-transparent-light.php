<?php
/**
 * Template Name: Twentig - Transparent header light
 *
 * @package twentig
 */

get_header();
?>

<main id="site-content">

	<?php

	if ( have_posts() ) :

		while ( have_posts() ) :
			the_post();
			?>

			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<div class="post-inner">

					<div class="entry-content">

						<?php the_content(); ?>

					</div><!-- .entry-content -->

				</div><!-- .post-inner -->

				<?php do_action( 'twentig_article_end' ); ?>
			</article>

			<?php
		endwhile;

	endif;
	?>

</main><!-- #site-content -->


<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
