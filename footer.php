<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package West_Coast_Summit_Supply
 */

?>

	<footer id="colophon" class="site-footer">
        <div class="footer-logo">
            <?php 
            if ( function_exists( 'the_custom_logo' ) ) {
                the_custom_logo();
            }
            ?>
        </div>

        <div class="store-info">
            <?php 
            if ( function_exists ( 'get_field' ) ) {
                if(get_field('address', 16)){
                    ?><address><p><?php the_field('address', 16) ?></p></address><?php
                }
            }
            ?>
		</div>

        <nav id="footer-navigation" class="footer-navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'footer-menu') ); ?>
        </nav>

        <div class="footer-sign-in">
            <svg class="sign-in-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <circle cx="12" cy="8" r="4" fill="#000"/>
                <path d="M12 14c-5.33 0-8 2.67-8 4v2h16v-2c0-1.33-2.67-4-8-4z" fill="#000"/>
            </svg>

            <a class="sign-in-link" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Sign-In',''); ?>"><?php _e('Sign-In',''); ?></a>
        </div>
        

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
