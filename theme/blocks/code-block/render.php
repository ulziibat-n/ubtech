<?php
declare(strict_types=1);

/**
 * Code Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 *
 * @package ulziibat-tech
 */

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = ' id="' . esc_attr( $block['anchor'] ) . '"';
}

$title = get_field( 'code_title' );
$code  = get_field( 'code_content' );
$wrap  = get_field( 'code_wrap' );

if ( ! $code ) {
	if ( $is_preview ) {
		echo '<div class="p-4 border border-dashed bg-slate-50 text-slate-400">' . esc_html__( 'Кодоо энд оруулна уу...', 'ulziibat-tech' ) . '</div>';
	}
	return;
}

$white_space = $wrap ? 'normal' : 'pre';
?>

<div<?php echo $anchor; ?> class="overflow-hidden my-10 rounded-sm shadow-md code-block-container group shadow-slate-200/20">
	<?php if ( $title || ! $is_preview ) : ?>
		<div class="flex relative z-10 justify-between items-center px-5 py-2 bg-white rounded-t-md shadow-md shadow-slate-200/20">
			<span class="text-sm font-medium leading-none text-slate-500"><?php echo esc_html( $title ); ?></span>
			<button 
				type="button" 
				class="flex gap-1.5 items-center px-3 py-1 text-[0.65rem] leading-none font-bold tracking-wide uppercase transition-colors cursor-pointer copy-code-btn text-slate-500 hover:text-lime-600"
				data-code="<?php echo esc_attr( $code ); ?>"
			>
				<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
				<span class="copy-text"><?php esc_html_e( 'Хуулах', 'ulziibat-tech' ); ?></span>
			</button>
		</div>
	<?php endif; ?>

	<div class="relative">
		<pre class="m-0 p-6 bg-white text-xs font-mono text-slate-600 tracking-tight leading-relaxed <?php echo $title ? 'rounded-b-md' : 'rounded-md'; ?> overflow-x-auto" style="white-space: <?php echo esc_attr( $white_space ); ?>;"><code class="font-mono"><?php echo esc_html( $code ); ?></code></pre>
	</div>
</div>
