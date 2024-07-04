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
			the_post();?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1>Contact Us</h1>

				<div class="entry-content">

					<?php if ( function_exists ( 'get_field' ) ) {
						if(get_field('top_section_info')){
							?><p><?php the_field('top_section_info')?></p><?php
						}
						if ( get_field('contact_email') ) {
							$email  = get_field( 'contact_email' );
							$mailto = 'mailto:' . $email;
							?>
							<p><a href="<?php echo esc_url( $mailto ); ?> "><?php echo esc_html( $email ); ?></a></p>
							<?php
						}
						if(get_field('contact_phone')){
							$phone_number = preg_replace('/[^0-9]/', '', get_field('contact_phone'));
							?><a href="tel:<?php echo $phone_number; ?>"><?php the_field('contact_phone')?></a><?php
						}
						if(get_field('address')){
							?><address><p><?php the_field('address') ?></p></address><?php
						}
					}

					the_content();?>
				</div>

	 		</article>
			<?php

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
