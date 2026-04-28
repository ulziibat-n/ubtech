<?php declare(strict_types=1);
/**
 * Site SEO Analysis & Auto-Populate Engine.
 * 
 * Automatically populates SEO fields based on post content and Primary Category.
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
		$word_count    = str_word_count( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ) );

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
		}

		if ( has_post_thumbnail( $post_id ) ) {
			$results['good'][] = 'Featured Image тохируулсан байна.';
		}

		return $results;
	}

	/**
	 * Automatically populate SEO fields from post data.
	 * 
	 * Triggered on acf/save_post.
	 */
	public static function auto_populate( $post_id ): void {
		if ( ! is_numeric( $post_id ) ) return;
		if ( get_post_type( $post_id ) === 'revision' ) return;

		$post = get_post( $post_id );
		if ( ! $post || in_array( $post->post_type, array( 'acf-field-group', 'acf-field' ) ) ) return;

		$is_empty = function( $field_key, $pid ) {
			$val = get_field( $field_key, $pid );
			return empty( trim( (string) $val ) );
		};

		// 1. Primary Category & Focus Keyphrase
		$primary_cat_id = get_field( '_site_primary_category', $post_id );
		$primary_cat_name = '';

		if ( $primary_cat_id ) {
			$term = get_term( (int) $primary_cat_id );
			if ( $term && ! is_wp_error( $term ) ) {
				$primary_cat_name = $term->name;
			}
		} else {
			// Fallback to first category if no primary set
			$categories = get_the_category( $post_id );
			if ( ! empty( $categories ) ) {
				$primary_cat_name = $categories[0]->name;
				// Auto-set as primary if not set
				update_field( '_site_primary_category', $categories[0]->term_id, $post_id );
			}
		}

		if ( ! empty( $primary_cat_name ) && $is_empty( '_site_focus_keyphrase', $post_id ) ) {
			update_field( '_site_focus_keyphrase', $primary_cat_name, $post_id );
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
			if ( $categories ) foreach ( $categories as $cat ) $keyword_list[] = $cat->name;
			if ( $tags ) foreach ( $tags as $tag ) $keyword_list[] = $tag->name;
			if ( ! empty( $keyword_list ) ) {
				update_field( '_site_seo_keywords', implode( ', ', array_unique( $keyword_list ) ), $post_id );
			}
		}

		// 5. Social Image
		if ( $is_empty( '_site_social_image', $post_id ) && has_post_thumbnail( $post_id ) ) {
			update_field( '_site_social_image', get_the_post_thumbnail_url( $post_id, 'full' ), $post_id );
		}
	}

	/**
	 * Meta Box Analysis.
	 */
	public static function add_meta_box(): void {
		$screens = array( 'post', 'page', 'courses', 'portfolio' );
		foreach ( $screens as $screen ) {
			add_meta_box( 'site_seo_analysis_box', '📊 SEO Health Analysis', array( __CLASS__, 'render_meta_box' ), $screen, 'normal', 'high' );
		}
	}

	/**
	 * Render Meta Box with JS Sync for Primary Category.
	 */
	public static function render_meta_box( $post ): void {
		$results = self::run( $post->ID );
		?>
		<div class="site-seo-analysis-results">
			<div style="background: #f0f6ff; padding: 15px; border-radius: 8px; border: 1px solid #c2d1e9; margin-bottom: 20px;">
				<h4 style="margin: 0 0 5px 0; font-size: 14px; color: #007cba;">⚙️ Native Primary Category System</h4>
				<p style="margin: 0; font-size: 12px; color: #646970;">"Үндсэн ангилал"-ыг сонгосноор Focus Keyphrase болон SEO тохиргоо түүний дагуу автоматаар хийгдэнэ.</p>
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

			<script>
			jQuery(document).ready(function($) {
				function syncPrimaryCategoryChoices() {
					var $primarySelect = $('select[name^="acf["][name$="_site_primary_category]"]');
					if (!$primarySelect.length) return;

					var currentVal = $primarySelect.val();
					var choices = [];

					// Standard WP Category checkboxes
					$('#categorychecklist input:checked').each(function() {
						var id = $(this).val();
						var name = $(this).closest('label').text().trim();
						choices.push({ id: id, name: name });
					});

					// Gutenberg Category list
					$('.editor-post-taxonomies__hierarchical-terms-list input:checked').each(function() {
						var id = $(this).val();
						var name = $(this).parent().find('label').text().trim();
						choices.push({ id: id, name: name });
					});

					// Clear and rebuild choices
					$primarySelect.find('option').not('[value=""]').remove();
					choices.forEach(function(c) {
						var selected = (c.id == currentVal) ? 'selected' : '';
						$primarySelect.append('<option value="' + c.id + '" ' + selected + '>' + c.name + '</option>');
					});
					
					// If only one category, auto-select it if none selected
					if (choices.length === 1 && !currentVal) {
						$primarySelect.val(choices[0].id).trigger('change');
					}
				}

				// Sync on load and on category change
				setTimeout(syncPrimaryCategoryChoices, 1000);
				$(document).on('change', '#categorychecklist input, .editor-post-taxonomies__hierarchical-terms-list input', function() {
					syncPrimaryCategoryChoices();
				});
			});
			</script>
		</div>
		<?php
	}
}

// Hooks
add_action( 'add_meta_boxes', array( 'Site_SEO_Analysis', 'add_meta_box' ) );
add_action( 'acf/save_post', array( 'Site_SEO_Analysis', 'auto_populate' ), 20 );

/**
 * Filter to ensure Primary Category field is populated via AJAX/Load
 */
add_filter('acf/load_field/name=_site_primary_category', function($field) {
	$post_id = false;
	if (isset($_GET['post'])) $post_id = $_GET['post'];
	if (isset($_POST['post_ID'])) $post_id = $_POST['post_ID'];

	if ($post_id) {
		$categories = get_the_category($post_id);
		foreach($categories as $cat) {
			$field['choices'][$cat->term_id] = $cat->name;
		}
	}
	return $field;
});
