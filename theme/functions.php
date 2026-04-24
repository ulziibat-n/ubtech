<?php
/**
 * ulziibat-tech functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ulziibat-tech
 */

if ( ! defined( 'UB_VERSION' ) ) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define( 'UB_VERSION', wp_get_theme()->get( 'Version' ) );
}

if ( ! function_exists( 'ub_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ub_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ulziibat-tech, use a find and replace
		 * to change 'ulziibat-tech' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ulziibat-tech', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'ulziibat-tech' ),
				'menu-2' => __( 'Footer Menu', 'ulziibat-tech' ),
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

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'ub_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ub_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'ulziibat-tech' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'ulziibat-tech' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'ub_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ub_scripts() {
	wp_enqueue_style( 'ulziibat-tech-style', get_stylesheet_uri(), array(), UB_VERSION );

	wp_enqueue_script(
		'ulziibat-tech-script',
		get_template_directory_uri() . '/js/script.min.js',
		array(),
		UB_VERSION,
		array(
			'in_footer' => true, // Load in the footer.
			'strategy'  => 'defer', // Defer the script.
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ub_scripts' );

/**
 * Completely remove Gutenberg global styles and block library CSS.
 */
function ub_remove_global_styles_and_blocks() {
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-block-style' );
	wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'ub_remove_global_styles_and_blocks', 100 );
add_action( 'admin_enqueue_scripts', 'ub_remove_global_styles_and_blocks', 100 );

// Aggressive removal of core actions.
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'admin_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

/**
 * Enqueue the block editor script.
 */
function ub_enqueue_block_editor_script() {
	$current_screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if (
		$current_screen &&
		$current_screen->is_block_editor() &&
		'widgets' !== $current_screen->id
	) {
		wp_enqueue_script(
			'ulziibat-tech-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			UB_VERSION,
			array(
				'in_footer' => true, // Load in the footer.
				'strategy'  => 'defer', // Defer the script.
			)
		);
	}
}
add_action( 'enqueue_block_assets', 'ub_enqueue_block_editor_script' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Disable WordPress comments.
 */
require get_template_directory() . '/inc/disable-comments.php';
