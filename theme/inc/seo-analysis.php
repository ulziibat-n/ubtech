<?php declare(strict_types=1);
/**
 * Site SEO Analysis & AI Auto-Optimizer Engine (Powered by Gemini).
 * 
 * @package ulziibat-tech
 */

class Site_SEO_Analysis {

	/**
	 * Gemini API Key
	 */
	private static $api_key = 'AIzaSyAZrS3PH84o_H5cdsbPXIch_ebZR4yrF7w';

	/**
	 * Call Gemini AI API
	 *
	 * @param string $prompt The prompt to send.
	 * @return string|null Response from AI.
	 */
	private static function call_gemini( $prompt ) {
		$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . self::$api_key;

		$body = array(
			'contents' => array(
				array(
					'parts' => array(
						array( 'text' => $prompt ),
					),
				),
			),
			'generationConfig' => array(
				'response_mime_type' => 'application/json',
			),
		);

		$response = wp_remote_post( $url, array(
			'body'      => wp_json_encode( $body ),
			'headers'   => array( 'Content-Type' => 'application/json' ),
			'timeout'   => 30,
			'sslverify' => false, // Set to false to work on localhost/local environments
		) );

		if ( is_wp_error( $response ) ) {
			error_log( 'Gemini API Error: ' . $response->get_error_message() );
			return null;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );
		return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
	}

	/**
	 * Run analysis for a specific post.
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

		// Basic Structural Checks
		if ( ! has_block( 'acf/faq-block', $content ) && $word_count > 500 ) {
			$results['suggestions'][] = '💡 <b>AI Suggestion:</b> Энэ нийтлэлд FAQ блок нэмбэл SEO-д сайнаар нөлөөлнө.';
		}

		if ( ! $keyphrase ) {
			$results['problems'][] = '<b>Focus Keyphrase байхгүй байна.</b> AI Auto-Optimizer ашиглан тохируулна уу.';
			return $results;
		}

		$keyphrase_lower = mb_strtolower( (string) $keyphrase );
		$content_lower   = mb_strtolower( $clean_content );

		// 1. Links
		preg_match_all( '/<a [^>]*href=["\'](https?:\/\/[^"\']+)["\'][^>]*>/i', $content, $links );
		if ( empty( $links[1] ) ) {
			$results['problems'][] = 'Дотоод болон гадаад холбоос (links) байхгүй байна.';
		} else {
			$results['good'][] = 'Холбоосууд илэрсэн.';
		}

		// 2. Intro & Density
		if ( strpos( mb_substr( $content_lower, 0, 500 ), $keyphrase_lower ) !== false ) {
			$results['good'][] = 'Түлхүүр үг эхлэл хэсэгт байна.';
		} else {
			$results['problems'][] = 'Түлхүүр үг эхний хэсэгт алга.';
		}

		// 3. Meta Desc & Title
		if ( strpos( mb_strtolower( (string) $seo_title ), $keyphrase_lower ) !== false ) {
			$results['good'][] = 'Түлхүүр үг гарчигт байна.';
		}
		if ( $seo_desc && strpos( mb_strtolower( (string) $seo_desc ), $keyphrase_lower ) !== false ) {
			$results['good'][] = 'Түлхүүр үг тайлбарт байна.';
		}

		return $results;
	}

	/**
	 * AI Auto-Optimizer using Gemini
	 */
	public static function auto_optimize( $post_id ): array {
		$post    = get_post( $post_id );
		$content = wp_strip_all_tags( strip_shortcodes( $post->post_title . ' ' . $post->post_content ) );
		
		$prompt = "You are a World-Class Technical SEO Specialist. Analyze this WordPress article and provide SEO optimization data in JSON format.
		Language: Mongolian.
		Article Content: '{$content}'
		
		Return ONLY a JSON object with these keys:
		- focus: (Ideal single focus keyphrase)
		- related: (3-4 related keyphrases separated by comma)
		- seo_title: (Compelling SEO title under 60 chars)
		- seo_desc: (Meta description under 155 chars)
		- keywords: (Comma separated keywords)
		- social_title: (Eye-catching Facebook title)
		- social_desc: (Engaging Facebook description)
		- analysis: (An array of 3-4 professional SEO recommendations for the user to improve the content)";

		$ai_response = self::call_gemini( $prompt );
		$data        = $ai_response ? json_decode( $ai_response, true ) : null;

		if ( ! $data ) {
			// Fallback if AI fails
			return array(
				'focus'        => 'AI Error',
				'related'      => '',
				'seo_title'    => $post->post_title,
				'seo_desc'     => '',
				'keywords'     => '',
				'social_title' => $post->post_title,
				'social_desc'  => '',
				'analysis'     => array( 'AI-тай холбогдож чадсангүй. Дахин оролдоно уу.' ),
			);
		}

		// Save analysis results for metabox display
		update_post_meta( $post_id, '_site_seo_ai_analysis', $data['analysis'] );

		return $data;
	}

	/**
	 * AJAX Handler
	 */
	public static function ajax_auto_optimize(): void {
		check_ajax_referer( 'site_seo_analysis', 'nonce' );
		$post_id = isset( $_POST['post_id'] ) ? (int) $_POST['post_id'] : 0;
		$data    = self::auto_optimize( $post_id );
		wp_send_json_success( $data );
	}

	/**
	 * Meta Box
	 */
	public static function add_meta_box(): void {
		$screens = array( 'post', 'page', 'courses', 'portfolio' );
		foreach ( $screens as $screen ) {
			add_meta_box( 'site_seo_analysis_box', '🤖 Gemini AI SEO Optimizer', array( __CLASS__, 'render_meta_box' ), $screen, 'normal', 'high' );
		}
	}

	/**
	 * Render Meta Box
	 */
	public static function render_meta_box( $post ): void {
		$results     = self::run( $post->ID );
		$ai_analysis = get_post_meta( $post->ID, '_site_seo_ai_analysis', true );
		$nonce       = wp_create_nonce( 'site_seo_analysis' );
		?>
		<div class="site-seo-analysis-results" data-post-id="<?php echo (int) $post->ID; ?>" data-nonce="<?php echo esc_attr( $nonce ); ?>">
			
			<div class="seo-optimize-section" style="margin-bottom: 25px; padding: 15px; background: #eefbff; border-radius: 10px; border: 1px solid #7ed3ed; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
				<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
					<h4 style="margin: 0; font-size: 16px; color: #007cba; display: flex; align-items: center;">
						<span style="font-size: 20px; margin-right: 8px;">✨</span> Gemini AI Auto-Optimizer
					</h4>
					<button type="button" class="button button-primary" id="btn-auto-optimize" style="background: #007cba; padding: 5px 20px; height: auto; font-weight: 600; border-radius: 20px;">AI-аар оновчлох</button>
				</div>
				<p style="font-size: 13px; color: #50575e;">Gemini AI таны агуулгыг шинжилж, хамгийн төгс SEO тохиргоог (Title, Meta, Keywords) автоматаар хийхэд бэлэн байна.</p>
			</div>

			<?php if ( ! empty( $ai_analysis ) && is_array( $ai_analysis ) ) : ?>
				<div class="ai-recommendations" style="margin-bottom: 25px; background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 5px solid #007cba;">
					<h5 style="margin: 0 0 10px 0; color: #007cba;">👨‍🏫 AI-ийн өгсөн зөвлөмж:</h5>
					<ul style="margin: 0; padding-left: 18px; font-size: 13px; color: #3c434a;">
						<?php foreach ( $ai_analysis as $rec ) : ?>
							<li style="margin-bottom: 5px;"><?php echo esc_html( $rec ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

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
				$('#btn-auto-optimize').on('click', function() {
					var $btn = $(this);
					if(!confirm('Gemini AI-аар SEO тохиргоог автоматаар бөглөх үү?')) return;
					$btn.prop('disabled', true).html('AI Шинжилж байна...');
					$.post(ajaxurl, {
						action: 'site_auto_optimize',
						post_id: $('.site-seo-analysis-results').data('post-id'),
						nonce: $('.site-seo-analysis-results').data('nonce')
					}, function(r) {
						$btn.prop('disabled', false).html('AI-аар оновчлох');
						if(r.success) {
							var d = r.data;
							$('input[name="acf[field_site_focus_keyphrase]"]').val(d.focus).trigger('change');
							$('textarea[name="acf[field_site_related_keyphrases]"]').val(d.related).trigger('change');
							$('input[name="acf[field_site_seo_title]"]').val(d.seo_title).trigger('change');
							$('textarea[name="acf[field_site_seo_description]"]').val(d.seo_desc).trigger('change');
							$('input[name="acf[field_site_seo_keywords]"]').val(d.keywords).trigger('change');
							$('input[name="acf[field_site_social_title]"]').val(d.social_title).trigger('change');
							$('textarea[name="acf[field_site_social_description]"]').val(d.social_desc).trigger('change');
							alert('AI бүх талбарыг амжилттай бөглөлөө! Хадгалахын тулд "Update" хийнэ үү.');
							location.reload(); // Reload to see AI analysis recommendations
						} else {
							alert('Алдаа гарлаа. API Key эсвэл интернэт холболтоо шалгана уу.');
						}
					});
				});
			});
			</script>
		</div>
		<?php
	}
}

add_action( 'add_meta_boxes', array( 'Site_SEO_Analysis', 'add_meta_box' ) );
add_action( 'wp_ajax_site_auto_optimize', array( 'Site_SEO_Analysis', 'ajax_auto_optimize' ) );
