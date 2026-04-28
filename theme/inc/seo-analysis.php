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
	private static $api_key = 'AIzaSyCInxlDvtNZuA0i4DKNPlG_-clIyema6sY';

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
			'timeout'   => 45, // Increased timeout
			'sslverify' => false,
		) );

		if ( is_wp_error( $response ) ) {
			error_log( 'Gemini API Error: ' . $response->get_error_message() );
			return null;
		}

		$raw_body = wp_remote_retrieve_body( $response );
		$data     = json_decode( $raw_body, true );
		
		$text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
		
		if ( $text ) {
			// Clean Markdown JSON blocks if present
			$text = preg_replace('/^```json\s*|\s*```$/m', '', trim($text));
		}

		return $text;
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

		if ( ! has_block( 'acf/faq-block', $content ) && $word_count > 500 ) {
			$results['suggestions'][] = '💡 <b>AI Suggestion:</b> FAQ блок нэмж баяжуулбал илүү үр дүнтэй.';
		}

		if ( ! $keyphrase ) {
			$results['problems'][] = 'Focus Keyphrase тохируулаагүй байна.';
			return $results;
		}

		$keyphrase_lower = mb_strtolower( (string) $keyphrase );
		$content_lower   = mb_strtolower( $clean_content );

		if ( strpos( mb_substr( $content_lower, 0, 1000 ), $keyphrase_lower ) !== false ) {
			$results['good'][] = 'Түлхүүр үг эхлэл хэсэгт байна.';
		} else {
			$results['problems'][] = 'Түлхүүр үг эхний хэсэгт алга.';
		}

		return $results;
	}

	/**
	 * AI Auto-Optimizer using Gemini
	 */
	public static function auto_optimize( $post_id ): array {
		$post    = get_post( $post_id );
		// Trim content to avoid API issues with very long posts
		$content = mb_substr( wp_strip_all_tags( strip_shortcodes( $post->post_title . ' ' . $post->post_content ) ), 0, 4000 );
		
		$prompt = "You are an Expert SEO Specialist. Analyze this WordPress article and provide SEO optimization data in JSON format.
		Language: Mongolian.
		Content: '{$content}'
		
		Requirements:
		1. Provide a professional Focus Keyphrase.
		2. Create a compelling SEO Title (max 60 chars) and Meta Description (max 155 chars).
		3. Suggest related keyphrases.
		4. Ensure the output is valid JSON.
		
		Return ONLY a JSON object:
		{
			\"focus\": \"focus keyphrase\",
			\"related\": \"related, phrases\",
			\"seo_title\": \"SEO Title\",
			\"seo_desc\": \"SEO Description\",
			\"keywords\": \"keywords\",
			\"social_title\": \"Social Title\",
			\"social_desc\": \"Social Description\",
			\"analysis\": [\"Recommendation 1\", \"Recommendation 2\"]
		}";

		$ai_response = self::call_gemini( $prompt );
		$data        = $ai_response ? json_decode( $ai_response, true ) : null;

		if ( ! $data ) {
			return array(
				'focus'        => 'AI-аар оновчлох боломжгүй байна',
				'related'      => '',
				'seo_title'    => $post->post_title,
				'seo_desc'     => '',
				'keywords'     => '',
				'social_title' => $post->post_title,
				'social_desc'  => '',
				'analysis'     => array( 'Gemini API холболтод алдаа гарлаа. Дараа дахин оролдоно уу.' ),
			);
		}

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
			
			<div class="seo-optimize-section" style="margin-bottom: 25px; padding: 20px; background: #eefbff; border-radius: 12px; border: 1px solid #7ed3ed; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
				<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
					<h4 style="margin: 0; font-size: 16px; color: #007cba; font-weight: 600;">✨ Gemini AI Auto-Optimizer</h4>
					<button type="button" class="button button-primary" id="btn-auto-optimize" style="background: #007cba; height: 36px; border-radius: 18px; padding: 0 20px; font-weight: 600;">AI-аар оновчлох</button>
				</div>
				<p style="font-size: 13px; color: #50575e; margin: 0;">AI ашиглан нэг товчоор SEO талбаруудыг автоматаар бөглөх боломжтой. Энэ нь таны цагийг маш их хэмнэнэ.</p>
			</div>

			<div id="seo-analysis-dynamic-content">
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
			</div>

			<script>
			jQuery(document).ready(function($) {
				$('#btn-auto-optimize').on('click', function() {
					var $btn = $(this);
					if(!confirm('Gemini AI-аар SEO тохиргоог автоматаар бөглөх үү?')) return;
					$btn.prop('disabled', true).html('AI Шинжилж байна...');
					
					$.ajax({
						url: ajaxurl,
						type: 'POST',
						data: {
							action: 'site_auto_optimize',
							post_id: $('.site-seo-analysis-results').data('post-id'),
							nonce: $('.site-seo-analysis-results').data('nonce')
						},
						success: function(r) {
							$btn.prop('disabled', false).html('AI-аар оновчлох');
							if(r.success) {
								var d = r.data;
								// Update ACF fields
								$('input[name^="acf["][name$="site_focus_keyphrase]"]').val(d.focus).trigger('change');
								$('textarea[name^="acf["][name$="site_related_keyphrases]"]').val(d.related).trigger('change');
								$('input[name^="acf["][name$="site_seo_title]"]').val(d.seo_title).trigger('change');
								$('textarea[name^="acf["][name$="site_seo_description]"]').val(d.seo_desc).trigger('change');
								$('input[name^="acf["][name$="site_seo_keywords]"]').val(d.keywords).trigger('change');
								$('input[name^="acf["][name$="site_social_title]"]').val(d.social_title).trigger('change');
								$('textarea[name^="acf["][name$="site_social_description]"]').val(d.social_desc).trigger('change');
								
								alert('AI бүх талбарыг амжилттай бөглөлөө! Хадгалахын тулд "Update" хийнэ үү.');
								
								// Update recommendations list without full reload
								if(d.analysis && d.analysis.length > 0) {
									var listHtml = '<div class="ai-recommendations" style="margin-bottom: 25px; background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 5px solid #007cba;"><h5 style="margin: 0 0 10px 0; color: #007cba;">👨‍🏫 AI-ийн өгсөн зөвлөмж:</h5><ul style="margin: 0; padding-left: 18px; font-size: 13px; color: #3c434a;">';
									d.analysis.forEach(function(rec) {
										listHtml += '<li style="margin-bottom: 5px;">' + rec + '</li>';
									});
									listHtml += '</ul></div>';
									$('#seo-analysis-dynamic-content').prepend(listHtml);
								}
							} else {
								alert('Алдаа гарлаа: ' + (r.data || 'AI холболт амжилтгүй'));
							}
						},
						error: function() {
							$btn.prop('disabled', false).html('AI-аар оновчлох');
							alert('Сервертэй холбогдоход алдаа гарлаа.');
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
