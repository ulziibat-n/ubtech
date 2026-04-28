<?php declare(strict_types=1);
/**
 * Site SEO Analysis & Auto-Populate Engine.
 * 
 * Automatically populates SEO fields based on post content upon saving,
 * but ONLY if the fields are currently empty.
 * 
 * @package ulziibat-tech
 */

class Site_SEO_Analysis {

	/**
	 * Run basic analysis for a specific post.
	 */
	public static function run( $post_id ): array {
		$post          = get_post( $post_id );
		$keyphrase     = get_field( '_site_focus_keyphrase', $post_id );
		$seo_title     = get_field( '_site_seo_title', $post_id ) ?: $post->post_title;
		$seo_desc      = get_field( '_site_seo_description', $post_id );
		$content       = $post->post_content;
		$clean_content = wp_strip_all_tags( strip_shortcodes( $content ) );
		$word_count    = str_word_count( $clean_content );

		$results = array(
			'problems'    => array(),
			'good'        => array(),
			'suggestions' => array(),
		);

		if ( ! $keyphrase ) {
			$results['problems'][] = 'Focus Keyphrase тохируулаагүй байна.';
		}

		if ( $word_count < 300 ) {
			$results['problems'][] = 'Нийтлэл хэт богино байна (300-аас бага үгтэй).';
		} else {
			$results['good'][] = "Нийтлэлийн урт: Сайн ($word_count үг).";
		}

		if ( has_post_thumbnail( $post_id ) ) {
			$results['good'][] = 'Featured Image тохируулсан байна.';
		} else {
			$results['problems'][] = 'Featured Image байхгүй байна.';
		}

		return $results;
	}

	/**
	 * Automatically populate SEO fields from post data.
	 * 
	 * Triggered on acf/save_post.
	 * Only updates fields if they are empty or contain only whitespace.
	 */
	public static function auto_populate( $post_id ): void {
		if ( ! is_numeric( $post_id ) ) {
			return;
		}

		if ( get_post_type( $post_id ) === 'revision' ) {
			return;
		}

		$post = get_post( $post_id );
		if ( ! $post || in_array( $post->post_type, array( 'acf-field-group', 'acf-field' ) ) ) {
			return;
		}

		// Helper to check if a field is actually empty
		$is_empty = function( $field_key, $pid ) {
			$val = get_field( $field_key, $pid );
			return empty( trim( (string) $val ) );
		};

		// 1. Focus Keyphrase (Use primary/first category)
		if ( $is_empty( '_site_focus_keyphrase', $post_id ) ) {
			$categories = get_the_category( $post_id );
			if ( ! empty( $categories ) ) {
				update_field( '_site_focus_keyphrase', $categories[0]->name, $post_id );
			}
		}

		// 2. SEO Title & Social Title
		if ( $is_empty( '_site_seo_title', $post_id ) ) {
			update_field( '_site_seo_title', $post->post_title, $post_id );
		}
		if ( $is_empty( '_site_social_title', $post_id ) ) {
			update_field( '_site_social_title', $post->post_title, $post_id );
		}

		// 3. SEO Description & Social Description
		if ( $is_empty( '_site_seo_description', $post_id ) || $is_empty( '_site_social_description', $post_id ) ) {
			$excerpt = $post->post_excerpt ?: wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), 25, '' );
			
			if ( $is_empty( '_site_seo_description', $post_id ) ) {
				update_field( '_site_seo_description', $excerpt, $post_id );
			}
			if ( $is_empty( '_site_social_description', $post_id ) ) {
				update_field( '_site_social_description', $excerpt, $post_id );
			}
		}

		// 4. SEO Keywords
		if ( $is_empty( '_site_seo_keywords', $post_id ) ) {
			$categories   = get_the_category( $post_id );
			$tags         = get_the_tags( $post_id );
			$keyword_list = array();
			if ( $categories ) {
				foreach ( $categories as $cat ) $keyword_list[] = $cat->name;
			}
			if ( $tags ) {
				foreach ( $tags as $tag ) $keyword_list[] = $tag->name;
			}
			if ( ! empty( $keyword_list ) ) {
				update_field( '_site_seo_keywords', implode( ', ', array_unique( $keyword_list ) ), $post_id );
			}
		}

		// 5. Social Image
		if ( $is_empty( '_site_social_image', $post_id ) && has_post_thumbnail( $post_id ) ) {
			$thumb_url = get_the_post_thumbnail_url( $post_id, 'full' );
			update_field( '_site_social_image', $thumb_url, $post_id );
		}
	}

	/**
	 * Meta Box for analysis.
	 */
	public static function add_meta_box(): void {
		$screens = array( 'post', 'page', 'courses', 'portfolio' );
		foreach ( $screens as $screen ) {
			add_meta_box( 'site_seo_analysis_box', '📊 SEO Health Analysis', array( __CLASS__, 'render_meta_box' ), $screen, 'normal', 'high' );
		}
	}

	/**
	 * Render Meta Box.
	 */
	public static function render_meta_box( $post ): void {
		$results = self::run( $post->ID );
		?>
		<div class="site-seo-analysis-results">
			<div style="background: #f0f6ff; padding: 15px; border-radius: 8px; border: 1px solid #c2d1e9; margin-bottom: 20px;">
				<h4 style="margin: 0 0 5px 0; font-size: 14px; color: #007cba;">⚙️ Ухаалаг систем идэвхтэй</h4>
				<p style="margin: 0; font-size: 12px; color: #646970;">Систем зөвхөн <b>хоосон байгаа</b> талбаруудыг автоматаар бөглөх бөгөөд таны өөрөө гараар оруулсан мэдээллийг огт өөрчлөхгүй.</p>
			</div>

			<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
				<div class="results-col">
					<h5 style="color: #d63638; border-bottom: 2px solid #f8d7da; padding-bottom: 8px; margin-top: 0;">🚩 Problems</h5>
					<ul style="font-size: 13px; margin: 0; padding-left: 15px;">
						<?php foreach ( $results['problems'] as $p ) echo "<li style='margin-bottom:6px;'>$p</li>"; ?>
					</ul>
				</div>
				<div class="results-col">
					<h5 style="color: #00a32a; border-bottom: 2px solid #d1e7dd; padding-bottom: 8px; margin-top: 0;">✅ Good Results</h5>
					<ul style="font-size: 13px; margin: 0; padding-left: 15px;">
						<?php foreach ( $results['good'] as $g ) echo "<li style='margin-bottom:6px;'>$g</li>"; ?>
					</ul>
				</div>
			</div>
		</div>
		<?php
	}
}

// Hooks
add_action( 'add_meta_boxes', array( 'Site_SEO_Analysis', 'add_meta_box' ) );
add_action( 'acf/save_post', array( 'Site_SEO_Analysis', 'auto_populate' ), 20 );
