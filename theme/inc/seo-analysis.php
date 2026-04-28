<?php declare(strict_types=1);
/**
 * Site SEO Analysis & Contextual Link Engine.
 * 
 * @package ulziibat-tech
 */

class Site_SEO_Analysis {

	/**
	 * Run deep analysis for a specific post.
	 */
	public static function run( $post_id ): array {
		$post          = get_post( $post_id );
		$keyphrase     = get_field( '_site_focus_keyphrase', $post_id );
		$content       = (string) $post->post_content;
		$clean_content = wp_strip_all_tags( strip_shortcodes( $content ) );
		$word_count    = str_word_count( $clean_content );

		$results = array( 'problems' => array(), 'good' => array(), 'suggestions' => array() );

		if ( ! $keyphrase ) $results['problems'][] = 'Focus Keyphrase тохируулаагүй байна.';

		if ( $keyphrase && $word_count > 0 ) {
			$key_count = mb_substr_count( mb_strtolower( $clean_content ), mb_strtolower( (string) $keyphrase ) );
			$density   = round( ( $key_count / $word_count ) * 100, 2 );
			if ( $density > 0.5 && $density < 2.5 ) $results['good'][] = "Түлхүүр үгний нягтрал: Сайн ($density%).";
			elseif ( $density >= 2.5 ) $results['problems'][] = "Түлхүүр үг хэт их байна ($density%).";
			else $results['suggestions'][] = "Түлхүүр үг бага байна ($density%).";
		}

		if ( preg_match_all( '/<img[^>]+>/i', $content, $matches ) ) {
			$no_alt_count = 0;
			foreach ( $matches[0] as $img_tag ) {
				if ( ! preg_match( '/alt=["\'][^"\']+["\']/i', $img_tag ) ) $no_alt_count++;
			}
			if ( $no_alt_count === 0 ) $results['good'][] = 'Бүх зургууд Alt тайлбартай байна.';
			else $results['problems'][] = "$no_alt_count зураг Alt тайлбаргүй байна.";
		}

		if ( strpos( $content, home_url() ) !== false ) $results['good'][] = 'Дотоод холбоос (Internal Link) байна.';
		else $results['suggestions'][] = 'Өөрийн сайт руу холбоотой линк нэмэхийг зөвлөж байна.';

		return $results;
	}

	/**
	 * Smart Contextual Link Suggestions.
	 * 
	 * Scans content for keywords that match titles of other posts.
	 */
	public static function get_smart_link_suggestions( $post_id, $content ): array {
		$suggestions = array();
		if ( empty( $content ) ) return $suggestions;

		$clean_content = wp_strip_all_tags( strip_shortcodes( $content ) );

		// Get 50 most recent posts to compare against
		$posts = get_posts( array(
			'post_type'      => array( 'post', 'portfolio' ),
			'post_status'    => 'publish',
			'posts_per_page' => 50,
			'post__not_in'   => array( $post_id ),
		) );

		foreach ( $posts as $p ) {
			$title = $p->post_title;
			// Simple matching: check if post title exists in current content
			if ( mb_stripos( $clean_content, $title ) !== false ) {
				$suggestions[] = array(
					'id'      => $p->ID,
					'title'   => $title,
					'link'    => get_permalink( $p->ID ),
					'keyword' => $title, // The word found in text
					'type'    => 'exact'
				);
			} else {
				// Try matching by single words if title is long (optional advanced logic)
				$words = explode( ' ', $title );
				if ( count($words) > 1 ) {
					foreach ($words as $word) {
						if ( mb_strlen($word) > 4 && mb_stripos( $clean_content, $word ) !== false ) {
							// Found a specific keyword match
							$suggestions[] = array(
								'id'      => $p->ID,
								'title'   => $title,
								'link'    => get_permalink( $p->ID ),
								'keyword' => $word,
								'type'    => 'partial'
							);
							break; // Only need one keyword match per post
						}
					}
				}
			}
			if ( count( $suggestions ) >= 5 ) break;
		}

		return $suggestions;
	}

	/**
	 * Get Redirect History
	 */
	public static function get_redirect_history( $post_id ): array {
		global $wpdb;
		$old_slugs = $wpdb->get_col( $wpdb->prepare( "SELECT meta_value FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = '_wp_old_slug' ORDER BY meta_id DESC", $post_id ) );
		return array_unique( (array)$old_slugs );
	}

	public static function add_meta_box(): void {
		$screens = array( 'post', 'page', 'courses', 'portfolio' );
		foreach ( $screens as $screen ) {
			add_meta_box( 'site_seo_analysis_box', '🚀 SEO Hub: Premium Engine', array( __CLASS__, 'render_meta_box' ), $screen, 'normal', 'high' );
		}
	}

	public static function render_meta_box( $post ): void {
		$results     = self::run( $post->ID );
		$suggestions = self::get_smart_link_suggestions( $post->ID, (string)$post->post_content );
		$history     = self::get_redirect_history( $post->ID );
		$site_url    = str_replace( array('https://', 'http://'), '', home_url() );
		?>
		<style>
			.seo-preview-tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
			.preview-tab { cursor: pointer; padding: 6px 14px; border-radius: 4px; font-size: 13px; background: #f0f0f1; border: 1px solid #dcdcde; transition: all 0.2s; }
			.preview-tab.active { background: #007cba; color: #fff; border-color: #007cba; }
			.preview-container { background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 20px; }
			.pv-title { color: #1a0dab; font-size: 19px; margin-bottom: 5px; }
			.fb-preview { border: 1px solid #dadde1; width: 500px; max-width: 100%; }
			.link-suggestion-item, .redirect-history-item { background: #f9f9f9; border: 1px solid #e5e5e5; padding: 10px 15px; border-radius: 5px; margin-bottom: 8px; }
			.copy-btn { cursor: pointer; font-size: 11px; padding: 4px 10px; background: #fff; border: 1px solid #ccd0d4; border-radius: 3px; }
			.match-tag { background: #f0f6ff; color: #007cba; font-size: 10px; padding: 2px 6px; border-radius: 4px; text-transform: uppercase; font-weight: 700; margin-left: 8px; }
		</style>

		<div class="site-seo-analysis-results">
			<div class="seo-preview-tabs">
				<div class="preview-tab active" data-target="google">Google Search</div>
				<div class="preview-tab" data-target="facebook">Facebook Share</div>
				<div class="preview-tab" data-target="links">🔗 Link Suggestions</div>
				<div class="preview-tab" data-target="redirects">🔄 Redirect History</div>
			</div>

			<!-- Previews (Google/FB) - Simplified for brevity in this render -->
			<div id="pv-google" class="preview-container google-preview">
				<div style="color:#202124; font-size:14px;"><?php echo esc_html( $site_url ); ?> › ...</div>
				<div class="pv-title" id="pv-g-title">SEO Title</div>
				<div style="color:#4d5156; font-size:14px;" id="pv-g-desc">Description...</div>
			</div>
			<div id="pv-facebook" class="preview-container fb-preview" style="display:none;">
				<div class="pv-img" id="pv-fb-img" style="background-image: url('<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>');"></div>
				<div style="padding:12px; background:#f2f3f5;">
					<div id="pv-fb-title" style="font-weight:600; font-size:16px;">Social Title</div>
					<div id="pv-fb-desc" style="font-size:14px; color:#606770;">Social Description</div>
				</div>
			</div>

			<!-- Smart Link Suggestions -->
			<div id="pv-links" class="preview-container" style="display:none;">
				<h5 style="margin-top:0;">🔗 Ухаалаг холбоос хийх санал:</h5>
				<?php if ( empty($suggestions) ): ?>
					<p style="font-size:13px; color:#646970;">Текст дотроос өөр нийтлэлтэй тохирох үг олдсонгүй.</p>
				<?php else: ?>
					<p style="font-size:12px; color:#646970; margin-bottom:15px;">Таны бичсэн текст дотор дараах нийтлэлүүдтэй холбоотой үгс олдлоо:</p>
					<?php foreach ( $suggestions as $s ): ?>
						<div class="link-suggestion-item">
							<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:5px;">
								<span style="font-size:13px; font-weight:600;"><?php echo esc_html($s['title']); ?></span>
								<button type="button" class="copy-btn" onclick="navigator.clipboard.writeText('<?php echo esc_url($s['link']); ?>'); alert('Link copied!');">Copy Link</button>
							</div>
							<div style="font-size:12px; color:#646970;">
								Санал болгож буй үг: <b style="color:#2271b1;">"<?php echo esc_html($s['keyword']); ?>"</b>
								<span class="match-tag"><?php echo $s['type']; ?> match</span>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<!-- Redirect History -->
			<div id="pv-redirects" class="preview-container" style="display:none;">
				<h5 style="margin-top:0;">🔄 Redirect түүх:</h5>
				<?php if ( empty($history) ): ?>
					<p style="font-size:13px; color:#646970;">URL өөрчлөгдөөгүй байна.</p>
				<?php else: foreach ( $history as $slug ): ?>
					<div class="redirect-history-item">
						<span style="font-size:13px; font-family:monospace; color:#2271b1;">/<?php echo esc_html($slug); ?>/</span>
						<span style="background:#e7f3ff; color:#007cba; font-size:10px; padding:2px 8px; border-radius:10px; font-weight:600;">301 Active</span>
					</div>
				<?php endforeach; endif; ?>
			</div>

			<!-- Results Summary -->
			<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
				<div class="results-col">
					<h5 style="color:#d63638; border-bottom:2px solid #f8d7da; padding-bottom:8px; margin-top:0;">🚩 Problems & Suggestions</h5>
					<ul style="font-size:13px; margin:0; padding-left:15px;">
						<?php foreach ($results['problems'] as $p) echo "<li style='margin-bottom:6px; color:#d63638;'>$p</li>"; foreach ($results['suggestions'] as $s) echo "<li style='margin-bottom:6px; color:#646970;'>$s</li>"; ?>
					</ul>
				</div>
				<div class="results-col">
					<h5 style="color:#00a32a; border-bottom:2px solid #d1e7dd; padding-bottom:8px; margin-top:0;">✅ Good Results</h5>
					<ul style="font-size:13px; margin:0; padding-left:15px;">
						<?php foreach ($results['good'] as $g) echo "<li style='margin-bottom:6px;'>$g</li>"; ?>
					</ul>
				</div>
			</div>

			<script>
			jQuery(document).ready(function($) {
				$('.preview-tab').on('click', function() {
					$('.preview-tab').removeClass('active'); $(this).addClass('active');
					$('.preview-container').hide(); $('#pv-' + $(this).data('target')).show();
				});
				function updatePreview() {
					var title = $('input[name*="_site_seo_title"]').val() || $('#title').val() || 'Enter Title';
					var desc = $('textarea[name*="_site_seo_description"]').val() || 'Enter description...';
					$('#pv-g-title').text(title); $('#pv-g-desc').text(desc);
					$('#pv-fb-title').text($('input[name*="_site_social_title"]').val() || title);
					$('#pv-fb-desc').text($('textarea[name*="_site_social_description"]').val() || desc);
				}
				$(document).on('input', 'input[name*="site_seo"], textarea[name*="site_seo"], input[name*="site_social"], textarea[name*="site_social"]', updatePreview);
				setTimeout(updatePreview, 1000);
			});
			</script>
		</div>
		<?php
	}

	public static function auto_populate( $post_id ): void {
		if ( ! is_numeric( $post_id ) || get_post_type( $post_id ) === 'revision' ) return;
		$post = get_post( $post_id );
		if ( ! $post || in_array( $post->post_type, array( 'acf-field-group', 'acf-field' ) ) ) return;
		$is_empty = function($k, $p) { $v = get_field($k, $p); return empty(trim((string)$v)); };
		if ( $is_empty('_site_focus_keyphrase', $post_id) ) {
			$primary_cat_id = get_field('_site_primary_category', $post_id);
			if ($primary_cat_id) { $t = get_term((int)$primary_cat_id); if($t) update_field('field_site_focus_keyphrase', $t->name, $post_id); }
			else { $cats = get_the_category($post_id); if(!empty($cats)) { update_field('field_site_focus_keyphrase', $cats[0]->name, $post_id); update_field('field_site_primary_category', $cats[0]->term_id, $post_id); } }
		}
		if ( $is_empty('_site_seo_title', $post_id) ) update_field('field_site_seo_title', $post->post_title, $post_id);
		if ( $is_empty('_site_social_title', $post_id) ) update_field('field_site_social_title', $post->post_title, $post_id);
		if ( $is_empty('_site_seo_description', $post_id) || $is_empty('_site_social_description', $post_id) ) {
			$exc = $post->post_excerpt ?: wp_trim_words(wp_strip_all_tags(strip_shortcodes((string)$post->post_content)), 25, '');
			if ($is_empty('_site_seo_description', $post_id)) update_field('field_site_seo_description', $exc, $post_id);
			if ($is_empty('_site_social_description', $post_id)) update_field('field_site_social_description', $exc, $post_id);
		}
		if ( $is_empty('_site_social_image', $post_id) && has_post_thumbnail($post_id) ) update_field('field_site_social_image', get_post_thumbnail_id($post_id), $post_id);
	}
}

add_action( 'add_meta_boxes', array( 'Site_SEO_Analysis', 'add_meta_box' ) );
add_action( 'acf/save_post', array( 'Site_SEO_Analysis', 'auto_populate' ), 20 );
add_filter('acf/load_field/name=_site_primary_category', function($field) {
	$pid = false;
	if (isset($_GET['post'])) $pid = (int)$_GET['post'];
	elseif (isset($_POST['post_ID'])) $pid = (int)$_POST['post_ID'];
	elseif (function_exists('acf_get_valid_post_id')) $pid = acf_get_valid_post_id(null);
	if ($pid) { $cats = get_the_category((int)$pid); if(!empty($cats)) foreach($cats as $c) $field['choices'][$c->term_id] = $c->name; else foreach(get_categories(array('hide_empty'=>0)) as $c) $field['choices'][$c->term_id] = $c->name; }
	return $field;
});
