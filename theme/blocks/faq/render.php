<?php
declare(strict_types=1);

/**
 * FAQ Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 *
 * @package ulziibat-tech
 */

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : '';

$faq_items = get_field( 'faq_items' );

if ( ! $faq_items ) {
	if ( $is_preview ) {
		echo '<div class="p-4 border border-dashed bg-slate-100 border-slate-300 text-slate-500">' . esc_html__( 'Please add FAQ items in the sidebar.', 'ulziibat-tech' ) . '</div>';
	}
	return;
}

// Register FAQ Schema to Manager
if ( ! $is_preview && class_exists( 'Site_Schema_Manager' ) ) {
	$faq_schema = array(
		'mainEntity' => array(),
	);

	foreach ( $faq_items as $item ) {
		$faq_schema['mainEntity'][] = array(
			'@type'          => 'Question',
			'name'           => $item['question'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => html_entity_decode( wp_strip_all_tags( $item['answer'] ), ENT_QUOTES, 'UTF-8' ),
			),
		);
	}
	Site_Schema_Manager::add_part( 'FAQPage', $faq_schema );
}
?>

<div <?php echo $block_id ? 'id="' . esc_attr( $block_id ) . '"' : ''; ?> class="my-12 faq-block">
	<div class="flex flex-col gap-2">
		<?php foreach ( $faq_items as $index => $item ) : ?>
			<details class="overflow-hidden bg-white rounded-md shadow-md transition-all duration-300 faq-item group shadow-slate-200/20">
				<summary class="flex items-center justify-between px-6 py-4 cursor-pointer list-none [&::-webkit-details-marker]:hidden">
					<h3 class="pr-8 max-w-3xl my-0! text-lg font-semibold leading-none! select-none text-slate-900">
						<?php echo esc_html( $item['question'] ); ?>
					</h3>
					<div class="flex flex-none justify-center items-center w-8 h-8 rounded-full transition-all duration-300 bg-slate-50 text-slate-400 group-open:rotate-180 group-open:bg-lime-500 group-open:text-white">
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
					</div>
				</summary>
				<div class="px-6 pb-6 max-w-none faq-answer prose prose-slate prose-p:text-slate-600 prose-p:leading-snug prose-li:leading-snug prose-li:my-0.5 prose-p:my-0">
					<?php echo $item['answer']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</details>
		<?php endforeach; ?>
	</div>
</div>
