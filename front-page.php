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
			the_post();

			the_content();
			?>


			<section class="featured-workshops">
			<?php
			$category_id = 18;

			$args = array(
				'post_type' => 'product',
				'posts_per_page' => 4,
				'tax_query' => array(
					array(
						'taxonomy' => 'product_cat',
						'field' => 'term_id',
						'terms' => $category_id,
					)
				)
			);

			$query = new WP_Query($args);

			if ($query->have_posts()) { ?>
					<h2>Some of Our Workshops</h2><?php
				while ($query->have_posts()) {
					$query->the_post();
					?>
					<article>
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail('medium'); ?>
							<h3><?php the_title();?></h3>
						</a>
					</article>
					<?php
					}
				wp_reset_postdata();
				} ?>
				</section>

				<section class="testimonials">
				<?php
				$args = array(
				    'post_type'      => 'wcss-testimonial',
				    'posts_per_page' => 3
				);

				$query = new WP_Query( $args );

				if ( $query->have_posts() ) { ?>
				        <?php while ( $query->have_posts() ) { $query->the_post(); ?>
				             <?php the_content(); ?>
				        <?php } ?>
				    <?php
				    wp_reset_postdata();
					}
				?>
				</section>
				<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
