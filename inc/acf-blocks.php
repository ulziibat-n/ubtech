<?php
declare(strict_types=1);

/**
 * ACF Gutenberg Blocks Registration
 *
 * @package ulziibat-tech
 * @since 1.0.5
 */

/**
 * Register a custom block category for the theme.
 *
 * @param array $categories List of block categories.
 * @return array
 */
function site_block_categories( array $categories ): array {
	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'ubtech',
				'title' => __( 'UB Tech Blocks', 'ulziibat-tech' ),
				'icon'  => 'superhero',
			),
		)
	);
}
add_filter( 'block_categories_all', 'site_block_categories' );

/**
 * Automatically register all blocks in the theme/blocks directory.
 * Each block must have a block.json file.
 *
 * @return void
 */
function site_register_acf_blocks(): void {
	$blocks_dir = get_template_directory() . '/blocks';

	if ( ! is_dir( $blocks_dir ) ) {
		return;
	}

	$blocks = scandir( $blocks_dir );

	foreach ( $blocks as $block ) {
		if ( '.' === $block || '..' === $block || '.DS_Store' === $block ) {
			continue;
		}

		$block_path = $blocks_dir . '/' . $block;

		if ( is_dir( $block_path ) ) {
			// Register block from block.json
			if ( file_exists( $block_path . '/block.json' ) ) {
				register_block_type( $block_path );
			}
			
			// Register ACF fields if exists
			if ( file_exists( $block_path . '/fields.php' ) ) {
				require_once $block_path . '/fields.php';
			}
		}
	}
}
add_action( 'init', 'site_register_acf_blocks', 5 );
