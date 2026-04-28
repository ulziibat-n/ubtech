<?php declare(strict_types=1);
/**
 * Site SEO Core System: Schema, Redirects & Expanded Sitemap.
 * 
 * @package ulziibat-tech
 */

class Site_SEO_System {

	public function __construct() {
		add_action( 'wp_head', array( $this, 'render_meta_tags' ), 1 );
		add_action( 'wp_head', array( $this, 'render_breadcrumb_json_ld' ), 2 );
		add_action( 'template_redirect', array( $this, 'handle_slug_redirects' ) );
		add_action( 'init', array( $this, 'add_sitemap_rewrites' ) );
		add_filter( 'query_vars', array( $this, 'add_sitemap_query_vars' ) );
		add_action( 'template_redirect', array( $this, 'render_xml_sitemap' ) );
		
		remove_action( 'wp_head', 'wp_generator' );
	}

	/**
	 * 1. Render SEO Meta Tags (Expanded for Archives)
	 */
	public function render_meta_tags(): void {
		if ( is_admin() ) return;
		$post_id = get_queried_object_id();
		$title   = '';
		$desc    = '';

		if ( is_singular() ) {
			$title = get_field( '_site_seo_title', $post_id ) ?: wp_get_document_title();
			$desc  = get_field( '_site_seo_description', $post_id );
		} elseif ( is_category() || is_tag() ) {
			$term  = get_queried_object();
			$title = $term->name . ' - ' . get_bloginfo('name');
			$desc  = term_description();
		} elseif ( is_author() ) {
			$author = get_queried_object();
			$title  = $author->display_name . ' - Нийтлэлүүд';
			$desc   = $author->description ?: $author->display_name . '-ийн бичсэн бүх нийтлэлүүд.';
		} else {
			$title = wp_get_document_title();
		}

		$keywords = get_field( '_site_seo_keywords', $post_id );
		$og_img   = get_field( '_site_social_image', $post_id ) ?: get_the_post_thumbnail_url( $post_id, 'full' );

		echo "\n<!-- Site SEO System -->\n";
		echo '<title>' . esc_html( $title ) . "</title>\n";
		if ( $desc ) echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags($desc) ) . "\">\n";
		if ( $keywords ) echo '<meta name="keywords" content="' . esc_attr( $keywords ) . "\">\n";

		echo '<meta property="og:type" content="' . ( is_singular() ? 'article' : 'website' ) . "\">\n";
		echo '<meta property="og:title" content="' . esc_attr( $title ) . "\">\n";
		if ( $og_img ) echo '<meta property="og:image" content="' . esc_url( $og_img ) . "\">\n";
		echo '<meta property="og:url" content="' . esc_url( get_permalink() ?: home_url($_SERVER['REQUEST_URI']) ) . "\">\n";
		echo "<!-- / Site SEO System -->\n\n";
	}

	/**
	 * 2. Render JSON-LD Breadcrumbs
	 */
	public function render_breadcrumb_json_ld(): void {
		if ( is_front_page() || is_admin() ) return;

		$items = array();
		$items[] = array( 'id' => home_url(), 'name' => 'Home' );

		if ( is_singular() ) {
			if ( is_singular('post') ) {
				$cats = get_the_category();
				if ( ! empty( $cats ) ) $items[] = array( 'id' => get_category_link( $cats[0]->term_id ), 'name' => $cats[0]->name );
			}
			$items[] = array( 'id' => get_permalink(), 'name' => get_the_title() );
		} elseif ( is_category() || is_tag() ) {
			$term = get_queried_object();
			$items[] = array( 'id' => get_term_link( $term ), 'name' => $term->name );
		} elseif ( is_author() ) {
			$author = get_queried_object();
			$items[] = array( 'id' => get_author_posts_url( $author->ID ), 'name' => $author->display_name );
		}

		if ( empty( $items ) ) return;

		$json_ld = array(
			'@context' => 'https://schema.org',
			'@type'    => 'BreadcrumbList',
			'itemListElement' => array(),
		);

		foreach ( $items as $index => $item ) {
			$json_ld['itemListElement'][] = array(
				'@type'    => 'ListItem',
				'position' => $index + 1,
				'item'     => array( '@id'  => $item['id'], 'name' => $item['name'] ),
			);
		}

		echo "\n<script type=\"application/ld+json\">\n" . wp_json_encode( $json_ld, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . "\n</script>\n";
	}

	/**
	 * 3. Redirects & Sitemap
	 */
	public function handle_slug_redirects(): void {
		if ( is_404() && isset( $_SERVER['REQUEST_URI'] ) ) {
			global $wpdb;
			$uri = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
			$slug = end( explode( '/', $uri ) );
			if ( ! empty( $slug ) ) {
				$pid = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_wp_old_slug' AND meta_value = %s LIMIT 1", $slug ) );
				if ( $pid ) { wp_redirect( get_permalink( $pid ), 301 ); exit; }
			}
		}
	}

	public function add_sitemap_rewrites() { add_rewrite_rule( '^sitemap\.xml$', 'index.php?site_sitemap=1', 'top' ); }
	public function add_sitemap_query_vars( $vars ) { $vars[] = 'site_sitemap'; return $vars; }

	public function render_xml_sitemap() {
		if ( get_query_var( 'site_sitemap' ) ) {
			header( 'Content-Type: application/xml; charset=utf-8' );
			echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
			echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

			// Pages, Posts, CPTs
			$posts = get_posts( array( 'post_type' => array( 'post', 'page', 'portfolio', 'courses' ), 'post_status' => 'publish', 'posts_per_page' => 1000 ) );
			foreach ( $posts as $p ) {
				echo "  <url>\n    <loc>" . get_permalink( $p->ID ) . "</loc>\n    <lastmod>" . get_the_modified_date( 'c', $p->ID ) . "</lastmod>\n    <priority>0.8</priority>\n  </url>\n";
			}

			// Categories
			$cats = get_categories( array( 'hide_empty' => 1 ) );
			foreach ( $cats as $c ) {
				echo "  <url>\n    <loc>" . get_category_link( $c->term_id ) . "</loc>\n    <priority>0.5</priority>\n  </url>\n";
			}

			// Authors
			$authors = get_users( array( 'has_published_posts' => array( 'post' ) ) );
			foreach ( $authors as $a ) {
				echo "  <url>\n    <loc>" . get_author_posts_url( $a->ID ) . "</loc>\n    <priority>0.4</priority>\n  </url>\n";
			}

			echo '</urlset>';
			exit;
		}
	}
}

new Site_SEO_System();
