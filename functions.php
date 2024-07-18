<?php
/**
 * West Coast Summit Supply functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package West_Coast_Summit_Supply
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

require('inc/api.php');

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wcss_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on West Coast Summit Supply, use a find and replace
		* to change 'wcss-theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'wcss-theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'wcss-theme' ),
            'header-right' => esc_html__( 'Header - Right', 'wcss-theme' ),
            'footer-menu' => esc_html__( 'Footer - Middle', 'wcss-theme' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

// Add theme support for align-wide and align-full
	add_theme_support( 'align-wide' );
    add_theme_support( 'align-full' );
}
add_action( 'after_setup_theme', 'wcss_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wcss_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wcss_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'wcss_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wcss_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'wcss-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'wcss-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'wcss_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wcss_theme_scripts() {
	wp_enqueue_style('wcss-theme-googlefonts', 'https://fonts.googleapis.com/css2?family=Encode+Sans:wght@100..900&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap',
	array(), null 
);
	wp_enqueue_style( 'wcss-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'wcss-theme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'wcss-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Google Map scripts and styling
	if ( is_page(14) ) {
		wp_enqueue_style(
		'google-styles',
		get_template_directory_uri() . '/google-map.css',
		array(),
		null
		);
		wp_enqueue_script(
		'google-maps-api',
		'https://maps.googleapis.com/maps/api/js?key='. $GLOBALS['api_key'] .'&loading=async&
		callback=Function.prototype',
		null,
		null,
		true
		);
		wp_enqueue_script(
		'google-map',
		get_template_directory_uri() . '/js/google-map.js',
		array( 'google-maps-api', 'jquery' ),
		null,
		true
		);
		}
}
add_action( 'wp_enqueue_scripts', 'wcss_theme_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

// CPTS
require get_template_directory() . '/inc/cpt.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// Remove workshop items from products page
function custom_pre_get_posts_query( $q ) {

    if ( ! $q->is_main_query() ) return;
    if ( ! $q->is_post_type_archive() ) return;

    if ( ! is_admin() && is_shop() ) {

        $q->set( 'tax_query', array(array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array( 'workshops' ),
            'operator' => 'NOT IN'
        )));

    }

    remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

}
add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );


// Google Map API
function my_acf_google_map_api( $api ){
	$api['key'] = $GLOBALS['api_key'];
	return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');


// Lower Yoast SEO Metabox location
function yoast_to_bottom(){
    return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoast_to_bottom' );

// Function to customize the login page logo, background, and link styles
function wcss_login_styles() {
    ?>
    <style type="text/css">
        /* Custom login logo styling */
        #login h1 a {
            background-image: url(<?php echo esc_url(get_stylesheet_directory_uri() . '/images/WCSS-Logo-Official.svg'); ?>);
            height: 320px;
            width: 320px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
        
        /* Custom background styling */
        body.login.js.login-action-login.wp-core-ui {
            background-image: url(<?php echo esc_url(get_stylesheet_directory_uri() . '/images/wcss-bg.jpeg'); ?>);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center; 
        }

		/* Forgotten password text */
		body.login #nav .wp-login-lost-password,
		body.login div#login p#backtoblog a,
		body.login .privacy-policy-link {
			color: white;
			transition: all 0.3s ease;
			border-radius: 5px;
			padding: 0.75rem 0.25rem;
			font-weight: 600;
			text-transform: uppercase;
			display: flex;
			justify-content: center;
		}

		body.login #nav .wp-login-lost-password:hover,
		body.login div#login p#backtoblog a:hover {
			color: white;
			background-color: #00422A;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
		}

		body.login .submit #wp-submit {
			background: #00422A;
			border-color: black;
		}

		/* privacy policy */
		body.login .privacy-policy-link {
			text-decoration: none;	
		}

		body.login .privacy-policy-link:hover {
			text-decoration: underline;	
		}

    </style>
    <?php
}
add_action('login_enqueue_scripts', 'wcss_login_styles');

function wcss_login_title() {
    return home_url();
}
add_filter( 'login_headerurl', 'wcss_login_title' );

function wcss_login_title_title() {
    return 'West Coast Summit Supply';
}
add_filter( 'login_headertext', 'wcss_login_title_title' );

// Remove unwanted widgets from dashboard
function remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    remove_meta_box( 'wc_admin_dashboard_setup', 'dashboard', 'normal');
} 
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );

// Remove block editor from cpt's and pages
//  that dont use it
function wcss_post_filter( $use_block_editor, $post) {

	$page_ids = array(14);
	$post_types = array('wcss-instructors');

	if ( in_array( $post->ID, $page_ids) || in_array($post->post_type, $post_types)) {
        return false;
    } else {
        return $use_block_editor;
    }
}
add_filter('use_block_editor_for_post', 'wcss_post_filter', 10, 2);


// add tutorial videos to dash
function dashboard_video_tutorial() {
    wp_add_dashboard_widget(
		    // widget
        'custom_dashboard_widget',
			// title
        'Tutorial Videos',
			// display func
        'display_dashboard_tutorials'
    );
}
add_action('wp_dashboard_setup', 'dashboard_video_tutorial');

function display_dashboard_tutorials() {
    ?>
    <div class="dashboard-tutorials">
        <h3>Tutorial Videos</h3>
        <p>Watch the videos below to learn how to use the site:</p>
        <ul>
			<h4>How to create a new free workshop</h4>
            <li>
                <video width=320 height=240 controls>
                    <source src="<?php echo site_url('/wp-content/uploads/2024/07/how-to-create-a-workshop.mp4'); ?>" type="video/mp4">
                </video>
            </li>
			<h4>How to create a new testimonial</h4>
			<li>
                <video width=320 height=240 controls>
                    <source src="<?php echo site_url('/wp-content/uploads/2024/07/Testimonial-Tutorial.mp4'); ?>" type="video/mp4">
                </video>
            </li>
        </ul>
    </div>
    <?php
}

function tutorial_styles() {
    ?>
    <style>
    .dashboard-tutorials ul {
        list-style-type: none;
        padding: 0;
    }
    .dashboard-tutorials li {
        margin-bottom: 1rem;
    }
    .dashboard-tutorials video {
        max-width: 100%;
        height: auto;
    }
    </style>
    <?php
}
add_action('admin_head', 'tutorial_styles');