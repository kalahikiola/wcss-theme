<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package West_Coast_Summit_Supply
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<h1>About Us</h1>
				</header>
				<div class="entry-content">
				<?php the_post_thumbnail('large')?>

					<?php if ( function_exists ( 'get_field' ) ) {
						if(get_field('about_us')){
							?><p><?php the_field('about_us')?></p><?php
						}
					}?>
				</div>

	 		</article>
		<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();