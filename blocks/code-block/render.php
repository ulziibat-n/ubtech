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

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : '';

$code_title = get_field( 'code_title' );
$code       = get_field( 'code_content' );
$wrap       = get_field( 'code_wrap' );
$collapse   = get_field( 'code_collapse' );

if ( ! $code ) {
	if ( $is_preview ) {
		echo '<div class="p-4 border border-dashed bg-slate-50 text-slate-400">' . esc_html__( 'Кодоо энд оруулна уу...', 'ulziibat-tech' ) . '</div>';
	}
	return;
}

$white_space = $wrap ? 'normal' : 'pre';
?>

<div <?php echo $block_id ? 'id="' . esc_attr( $block_id ) . '"' : ''; ?> class="overflow-hidden my-10 rounded-md shadow-md border-0! code-block-container bg-white flex flex-col group shadow-slate-200/20" data-code-block>
	<?php if ( $code_title || ! $is_preview ) : ?>
		<div class="flex relative z-20 justify-between items-center px-5 py-2 bg-white shadow-md shadow-slate-200/20">
			<span class="text-sm font-semibold leading-none text-slate-500"><?php echo esc_html( $code_title ? $code_title : 'Code' ); ?></span>
			<button 
				type="button" 
				class="flex gap-1.5 items-center px-3 py-1 text-[0.65rem]! leading-none font-bold! tracking-wide uppercase transition-colors cursor-pointer copy-code-btn text-slate-500 hover:text-lime-600"
				data-code="<?php echo esc_attr( $code ); ?>"
			>
				<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
				<span class="copy-text"><?php esc_html_e( 'Хуулах', 'ulziibat-tech' ); ?></span>
			</button>
		</div>
	<?php endif; ?>

	<div class="relative code-content-wrapper <?php echo $collapse ? 'is-collapsed' : ''; ?>" data-code-wrapper>
		<pre class="overflow-x-auto p-6 m-0 font-mono text-xs tracking-tight leading-relaxed text-slate-600" style="white-space: <?php echo esc_attr( $white_space ); ?>;"><code class="font-mono"><?php echo esc_html( $code ); ?></code></pre>
		
		<?php if ( $collapse ) : ?>
			<div class="flex absolute inset-x-0 bottom-0 z-10 justify-center items-end pb-6 h-32 bg-gradient-to-t from-white to-transparent transition-all duration-300 via-white/80 code-expand-overlay">
				<button type="button" class="px-6 py-3 text-[0.65rem]! font-bold! tracking-widest uppercase bg-white rounded-full border shadow-xl transition-all cursor-pointer border-slate-200 shadow-slate-200/50 hover:bg-lime-600 leading-none hover:text-white code-expand-btn text-slate-500">
					<?php esc_html_e( 'Бүгдийг үзэх', 'ulziibat-tech' ); ?>
				</button>
			</div>
		<?php endif; ?>
	</div>
</div>
