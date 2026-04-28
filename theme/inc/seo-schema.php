<?php
declare(strict_types=1);

/**
 * SEO Schema Aggregator Logic
 *
 * @package ulziibat-tech
 * @since 1.0.6
 */

/**
 * Class to manage and aggregate JSON-LD schemas.
 */
class Site_Schema_Manager {
	/**
	 * Array to store schema parts.
	 *
	 * @var array
	 */
	private static array $schema_parts = array();

	/**
	 * Add a schema part.
	 *
	 * @param string $type The schema type (e.g., FAQPage, BreadcrumbList).
	 * @param array  $data The schema data.
	 * @return void
	 */
	public static function add_part( string $type, array $data ): void {
		if ( ! isset( self::$schema_parts[ $type ] ) ) {
			self::$schema_parts[ $type ] = array();
		}
		self::$schema_parts[ $type ][] = $data;
	}

	/**
	 * Output the aggregated schema in the footer.
	 *
	 * @return void
	 */
	public static function output_schema(): void {
		if ( is_admin() || is_preview() ) {
			return;
		}

		$graph = array();

		// 1. Add Main Article/WebPage Schema
		if ( is_singular() ) {
			$post = get_post();
			$article_schema = array(
				'@type'            => is_singular( 'post' ) ? 'BlogPosting' : 'WebPage',
				'@id'              => get_permalink() . '#main-content',
				'url'              => get_permalink(),
				'name'             => get_the_title(),
				'headline'         => get_the_title(),
				'description'      => html_entity_decode( wp_strip_all_tags( get_the_excerpt() ), ENT_QUOTES, 'UTF-8' ),
				'datePublished'    => get_the_date( 'c' ),
				'dateModified'     => get_the_modified_date( 'c' ),
				'timeRequired'     => 'PT' . ( function_exists( 'ub_get_read_time' ) ? ub_get_read_time( get_the_ID() ) : '1' ) . 'M',
				'author'           => ( function() use ( $post ) {
					$author_id    = (int) $post->post_author;
					$custom_name  = function_exists( 'get_field' ) ? get_field( 'author_name', 'user_' . $author_id ) : null;
					$custom_image = function_exists( 'get_field' ) ? get_field( 'author_avatar', 'user_' . $author_id ) : null;

					return array(
						'@type' => 'Person',
						'name'  => $custom_name ?: get_the_author_meta( 'display_name', $author_id ),
						'url'   => get_author_posts_url( $author_id ),
						'image' => $custom_image ?: get_avatar_url( $author_id ),
					);
				} )(),
				'mainEntityOfPage' => array(
					'@type' => 'WebPage',
					'@id'   => get_permalink(),
				),
			);

			if ( has_post_thumbnail() ) {
				$article_schema['image'] = get_the_post_thumbnail_url( null, 'full' );
			}

			// Add Related Links to Article
			if ( isset( self::$schema_parts['RelatedLinks'] ) ) {
				$all_related = array();
				foreach ( self::$schema_parts['RelatedLinks'] as $links ) {
					$all_related = array_merge( $all_related, $links );
				}
				$article_schema['relatedLink'] = array_values( array_unique( $all_related ) );
			}

			$graph[] = $article_schema;
		}

		// 2. Aggregate Breadcrumbs
		if ( isset( self::$schema_parts['BreadcrumbList'] ) ) {
			foreach ( self::$schema_parts['BreadcrumbList'] as $bc ) {
				$graph[] = $bc;
			}
		}

		// 3. Aggregate FAQ
		if ( isset( self::$schema_parts['FAQPage'] ) ) {
			$faq_schema = array(
				'@type'      => 'FAQPage',
				'mainEntity' => array(),
			);
			foreach ( self::$schema_parts['FAQPage'] as $faq_part ) {
				if ( isset( $faq_part['mainEntity'] ) ) {
					$faq_schema['mainEntity'] = array_merge( $faq_schema['mainEntity'], $faq_part['mainEntity'] );
				}
			}
			if ( ! empty( $faq_schema['mainEntity'] ) ) {
				$graph[] = $faq_schema;
			}
		}


		if ( empty( $graph ) ) {
			return;
		}

		$final_schema = array(
			'@context' => 'https://schema.org',
			'@graph'   => $graph,
		);

		echo "\n" . '<!-- Unified SEO Schema by UB Tech -->' . "\n";
		echo '<script type="application/ld+json">' . wp_json_encode( $final_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
	}
}

add_action( 'wp_footer', array( 'Site_Schema_Manager', 'output_schema' ), 100 );
