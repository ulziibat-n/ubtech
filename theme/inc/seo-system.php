<?php declare(strict_types=1);
/**
 * Custom Unified SEO System for ULZIIBAT.TECH
 * Handles: Meta Tags, Open Graph, Twitter Cards, JSON-LD Schema, and Redirection.
 *
 * @package ulziibat-tech
 * @since 1.0.0
 */

/**
 * 1. AUTHOR ARCHIVE REDIRECT (301 to Home)
 * Since this is a single-author site, we redirect author archives to prevent duplicate content.
 */
function site_seo_redirect_author_archive(): void {
	if ( is_author() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'site_seo_redirect_author_archive' );

/**
 * 2. TUTOR LMS "NOINDEX" FOR SUBPAGES
 */
function site_seo_noindex_tutor_subpages(): void {
	if ( is_singular( array( 'lesson', 'tutor_quiz', 'tutor_assignments' ) ) ) {
		echo '<meta name="robots" content="noindex, nofollow" />' . "\n";
	}
}
add_action( 'wp_head', 'site_seo_noindex_tutor_subpages' );

/**
 * HELPER: Get clean description for SEO
 */
function site_get_seo_description(): string {
	if ( is_front_page() || is_home() ) {
		return esc_attr( 'Вэб хөгжүүлэлт, UI/UX дизайн болон технологийн зөвлөх үйлчилгээ.' );
	}

	$description = '';
	if ( is_singular() ) {
		$post_id     = get_the_ID();
		$custom_desc = get_field( '_site_seo_description', $post_id );

		if ( $custom_desc ) {
			$description = $custom_desc;
		} else {
			$post        = get_post();
			$description = has_excerpt() ? get_the_excerpt() : $post->post_content;
		}
	} elseif ( is_archive() ) {
		$description = get_the_archive_description();
	}

	$description = wp_strip_all_tags( strip_shortcodes( $description ) );
	return wp_trim_words( $description, 25, '' );
}

/**
 * 3. DYNAMIC BASIC META TAGS & CANONICAL URLs
 */
function site_seo_basic_meta(): void {
	if ( is_admin() ) {
		return;
	}

	$post_id   = get_the_ID();
	$canonical = is_singular() ? get_permalink() : home_url( add_query_arg( array(), $GLOBALS['wp']->request ) . '/' );
	$keywords  = is_singular() ? get_field( '_site_seo_keywords', $post_id ) : '';

	echo '<!-- Site SEO -->' . "\n";
	echo '<link rel="canonical" href="' . esc_url( $canonical ) . '" />' . "\n";
	echo '<meta name="description" content="' . esc_attr( site_get_seo_description() ) . '" />' . "\n";

	if ( $keywords ) {
		echo '<meta name="keywords" content="' . esc_attr( $keywords ) . '" />' . "\n";
	}
}
add_action( 'wp_head', 'site_seo_basic_meta', 1 );

/**
 * 4. OPEN GRAPH & TWITTER CARDS
 */
function site_seo_og_meta(): void {
	if ( is_admin() ) {
		return;
	}

	$site_name    = get_bloginfo( 'name' );
	$post_id      = get_the_ID();
	$custom_title = is_singular() ? get_field( '_site_seo_title', $post_id ) : '';
	$custom_image = is_singular() ? get_field( '_site_og_image', $post_id ) : '';

	$title       = $custom_title ? $custom_title : ( is_front_page() ? $site_name : get_the_title() );
	$description = site_get_seo_description();
	$url         = is_singular() ? get_permalink() : home_url( add_query_arg( array(), $GLOBALS['wp']->request ) );
	$type        = is_singular( 'post' ) ? 'article' : 'website';
	$image       = get_template_directory_uri() . '/assets/images/default-og.jpg'; // Fallback

	if ( $custom_image ) {
		$image = $custom_image;
	} elseif ( is_singular() && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( $post_id, 'full' );
	}

	// Conditional Overrides
	if ( is_page( 'services' ) ) {
		$title       = 'Үйлчилгээ | ' . $site_name;
		$description = 'UI/UX Дизайн, Вэб болон Апп хөгжүүлэлтийн мэргэжлийн үйлчилгээ.';
	} elseif ( is_post_type_archive( 'portfolio' ) || is_page( 'portfolio' ) ) {
		$title       = 'Портфолио | ' . $site_name;
		$description = 'Бидний гүйцэтгэсэн вэб болон гар утасны апп хөгжүүлэлтийн төслүүд.';
	}

	?>
	<!-- Open Graph / Facebook -->
	<meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>" />
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>" />
	<meta property="og:description" content="<?php echo esc_attr( $description ); ?>" />
	<meta property="og:url" content="<?php echo esc_url( $url ); ?>" />
	<meta property="og:type" content="<?php echo esc_attr( $type ); ?>" />
	<meta property="og:image" content="<?php echo esc_url( $image ); ?>" />
	<meta property="og:image:width" content="1200" />
	<meta property="og:image:height" content="630" />
	<!-- Twitter -->
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="<?php echo esc_attr( $title ); ?>" />
	<meta name="twitter:description" content="<?php echo esc_attr( $description ); ?>" />
	<meta name="twitter:image" content="<?php echo esc_url( $image ); ?>" />
	<?php
}
add_action( 'wp_head', 'site_seo_og_meta', 5 );

/**
 * 5. ADVANCED CONDITIONAL JSON-LD SCHEMA (Using Site_Schema_Manager)
 */
function site_seo_json_ld(): void {
	if ( is_admin() || ! class_exists( 'Site_Schema_Manager' ) ) {
		return;
	}

	$site_url = home_url( '/' );

	// WebSite Schema
	if ( is_front_page() || is_home() ) {
		Site_Schema_Manager::add_part(
			'WebSite',
			array(
				'@type'           => 'WebSite',
				'@id'             => $site_url . '#website',
				'url'             => $site_url,
				'name'            => get_bloginfo( 'name' ),
				'potentialAction' => array(
					'@type'       => 'SearchAction',
					'target'      => $site_url . '?s={search_term_string}',
					'query-input' => 'required name=search_term_string',
				),
			)
		);

		Site_Schema_Manager::add_part(
			'ProfessionalService',
			array(
				'@type'  => 'ProfessionalService',
				'name'   => 'Ulziibat Tech',
				'image'  => get_template_directory_uri() . '/assets/images/logo.png',
				'url'    => $site_url,
				'sameAs' => array(
					'https://facebook.com/ulziibat.tech',
					'https://linkedin.com/in/ulziibat',
					'https://github.com/ulziibat-n',
				),
			)
		);
	}

	// Services Page
	if ( is_page( 'services' ) ) {
		Site_Schema_Manager::add_part(
			'Service',
			array(
				'@type'       => 'Service',
				'serviceType' => 'UI/UX Design & Web Development',
				'provider'    => array(
					'@type' => 'LocalBusiness',
					'name'  => 'Ulziibat Tech',
				),
			)
		);
	}

	// Portfolio Archive
	if ( is_post_type_archive( 'portfolio' ) ) {
		Site_Schema_Manager::add_part(
			'CollectionPage',
			array(
				'@type' => 'CollectionPage',
				'name'  => 'Портфолио',
				'url'   => get_post_type_archive_link( 'portfolio' ),
			)
		);
	}

	// Single Portfolio Item
	if ( is_singular( 'portfolio' ) ) {
		Site_Schema_Manager::add_part(
			'CreativeWork',
			array(
				'@type' => 'CreativeWork',
				'name'  => get_the_title(),
				'url'   => get_permalink(),
			)
		);
	}

	// Course (Tutor LMS)
	if ( is_singular( 'courses' ) ) {
		Site_Schema_Manager::add_part(
			'Course',
			array(
				'@type'       => 'Course',
				'name'        => get_the_title(),
				'description' => site_get_seo_description(),
				'provider'    => array(
					'@type'  => 'Organization',
					'name'   => 'Ulziibat Tech',
					'sameAs' => $site_url,
				),
			)
		);
	}

	// Singular Post (BlogPosting)
	if ( is_singular( 'post' ) ) {
		$post_id = get_the_ID();
		Site_Schema_Manager::add_part(
			'BlogPosting',
			array(
				'@type'         => 'BlogPosting',
				'headline'      => get_the_title(),
				'datePublished' => get_the_date( 'c' ),
				'dateModified'  => get_the_modified_date( 'c' ),
				'author'        => array(
					'@type' => 'Person',
					'name'  => get_the_author(),
					'url'   => $site_url . 'about/',
				),
				'image'         => get_the_post_thumbnail_url( $post_id, 'full' ),
			)
		);

		// FAQ Logic
		$faqs = get_field( 'faq_items', $post_id );
		if ( $faqs ) {
			$faq_list = array();
			foreach ( $faqs as $faq ) {
				$faq_list[] = array(
					'@type'          => 'Question',
					'name'           => $faq['question'],
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => wp_strip_all_tags( $faq['answer'] ),
					),
				);
			}
			Site_Schema_Manager::add_part(
				'FAQPage',
				array(
					'@type'      => 'FAQPage',
					'mainEntity' => $faq_list,
				)
			);
		}
	}
}
add_action( 'wp_head', 'site_seo_json_ld', 10 );
add_action( 'wp_head', 'site_seo_json_ld', 10 );
