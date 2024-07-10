<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package West_Coast_Summit_Supply
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function wcss_theme_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 300,
			'single_image_width'    => 400,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'wcss_theme_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function wcss_theme_woocommerce_scripts() {
	wp_enqueue_style( 'wcss-theme-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _S_VERSION );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'wcss-theme-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'wcss_theme_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function wcss_theme_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'wcss_theme_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function wcss_theme_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'wcss_theme_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'wcss_theme_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function wcss_theme_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'wcss_theme_woocommerce_wrapper_before' );

if ( ! function_exists( 'wcss_theme_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function wcss_theme_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'wcss_theme_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'wcss_theme_woocommerce_header_cart' ) ) {
			wcss_theme_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'wcss_theme_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function wcss_theme_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		wcss_theme_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'wcss_theme_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'wcss_theme_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function wcss_theme_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'wcss-theme' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'wcss-theme' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'wcss_theme_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function wcss_theme_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php wcss_theme_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

// Remove breadcrumbs
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20);

// Add categories to top of shop pages
function add_category_links() {
    if ( ( is_shop() || is_product_category() ) && !is_product_category( 'workshops' ) ) {
        $product_categories = array("camping", "climbing", "snow");

        echo '<nav class="category-links-section">';
        foreach( $product_categories as $category ) {

            $term = get_term_by( 'slug', sanitize_title( $category ), 'product_cat' );
            $term_link = get_term_link( $term, 'product_cat' );

            echo '<a class="category-link" href="' . $term_link . '">';
            echo $term->name;
            woocommerce_subcategory_thumbnail( $term );
            echo '</a>';
            
        }
        echo '</nav>';
    }
}
add_action( 'woocommerce_shop_loop_header', 'add_category_links', 9);

// Add testimonials to workshop page
function testimonials_workshop() {

    if ( is_product_category( 'workshops' ) ) {
        echo '<section class="testimonials">';
            $args = array(
                'post_type'      => 'wcss-testimonial',
                'posts_per_page' => 3
            );

            $query = new WP_Query( $args );

            if ( $query->have_posts() ) {
                    while ( $query->have_posts() ) { $query->the_post();
                        the_content();
                    }
                wp_reset_postdata();
            }
        echo '</section>';
    }

}
add_action( 'woocommerce_after_main_content', 'testimonials_workshop', 9 );


// Add instructors to workshop page
function instructors_workshop() {
    if (is_product_category('workshops')) {
        echo '<section class="instructors">';
		echo '<h2>Meet our Instructors</h2>';
        
        $args = array(
            'post_type'      => 'wcss-instructors',
            'posts_per_page' => -1 
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <article>
                    <?php the_post_thumbnail(); ?>
                    <h3><?php the_title(); ?></h3>
                    <?php
                    if (function_exists('get_field')) { 
                        if (get_field('bio')) {
                            ?>
                            <p><?php the_field('bio'); ?></p>
                            <?php
                        }
                    }
                    ?>
                </article>
                <?php
            }
            wp_reset_postdata();
        }
        echo '</section>';
    }
}
add_action('woocommerce_after_main_content', 'instructors_workshop', 8);


// Remove SKU from single product 
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

// Remove Workshops default title

function remove_workshops_title() {
	if ( is_product_category( 'workshops' ) ) {
		add_filter( 'woocommerce_show_page_title', '__return_false' );
    }
}
add_action( 'wp', 'remove_workshops_title' );

// display Calendar on workshops
function display_calendar() {
    if (is_product_category('workshops')) {

		$category = get_queried_object();

		$query = new WP_Query( array( 'page_id' => 285 ) );

        if ($query->have_posts()) {
			$query->the_post();?>
			<div class="workshops-hero">
				<h1 class="workshops-header"><?php echo esc_html($category->name); ?></h1>
				<?php the_post_thumbnail(); ?>
			</div>
		  <section class='calendar'><?php
		  if (function_exists('get_field')) { 
			if (get_field('workshop_overview')) {
				?>
				<p class="workshop-overview"><?php the_field('workshop_overview'); ?></p>
				<?php
			}
		}
				the_content();
        	}
            wp_reset_postdata();

        ?> </section> <?php
    }
}
add_action('woocommerce_shop_loop_header', 'display_calendar');

// display upcoming workshops header on Workshops page
function upcoming_workshops() {
    if (is_product_category('workshops')) {

		?><h2>Upcoming Workshops</h2><?php
    }
}
add_action('woocommerce_shop_loop_header', 'upcoming_workshops');


// Remove results from product categories 
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

// Remove sorting on workshop page
function remove_catalog_ordering() {
	if (is_product_category('workshops')) {
	remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
	}
}
add_filter('woocommerce_before_shop_loop', 'remove_catalog_ordering');

// remove compare from workshop products
function no_compare_button($html) {
	global $woocommerce_loop;
	global $product;
    if (is_product_category('workshops') || is_product() && has_term( 'workshops', 'product_cat', $product->get_id() ) ) {
		// empty string to prevent button from diplaying
        return '';
    }
    return $html;
}
add_filter('woocommerce_products_compare_compare_button', 'no_compare_button', 10);

// Remove Single Product Description heading
add_filter('woocommerce_product_description_heading', '__return_null');

// remove tabs from single product description but keep the content
function remove_woocommerce_product_tabs( $tabs ) {
	unset( $tabs['description'] );
	unset( $tabs['reviews'] );
	unset( $tabs['additional_information'] );
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'remove_woocommerce_product_tabs', 98 );

add_action( 'woocommerce_after_single_product_summary', 'woocommerce_product_description_tab' );
add_action( 'woocommerce_after_single_product_summary', 'comments_template' );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_product_additional_information_tab' );