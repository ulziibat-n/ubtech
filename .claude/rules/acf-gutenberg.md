# ACF Gutenberg Block Rules

## Block Registration Pattern
Register in `functions.php` inside `after_setup_theme` or dedicated `init` hook:
```php
add_action( 'acf/init', 'ub_register_acf_blocks' );
function ub_register_acf_blocks() {
    if ( function_exists( 'acf_register_block_type' ) ) {
        acf_register_block_type( array(
            'name'            => 'ub-block-name',
            'title'           => __( 'Block Title', 'ub' ),
            'render_template' => get_template_directory() . '/theme/blocks/block-name/render.php',
            'category'        => 'ubtech',
            'icon'            => 'admin-generic',
            'keywords'        => array( 'ub', 'keyword' ),
            'supports'        => array( 'align' => false, 'jsx' => true ),
        ) );
    }
}
```

## block.json (preferred for WP 6.0+)
```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 3,
    "name": "ubtech/block-name",
    "title": "Block Title",
    "category": "ubtech",
    "icon": "admin-generic",
    "acf": {
        "mode": "preview",
        "renderTemplate": "blocks/block-name/render.php"
    },
    "supports": { "align": false }
}
```

## render.php Pattern
```php
<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

$fields = get_fields();
$title  = isset( $fields['title'] ) ? $fields['title'] : '';
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
    <?php if ( $title ) : ?>
        <h2><?php echo esc_html( $title ); ?></h2>
    <?php endif; ?>
</div>
```

## ACF JSON Sync
- Field groups auto-save to `theme/json/` (configured via `acf/settings/save_json`)
- Commit `theme/json/*.json` files — they are the source of truth
- Never manually edit JSON files; use ACF UI then commit the updated JSON

## Directory Structure
```
theme/
└── blocks/
    └── block-name/
        ├── block.json
        ├── render.php
        └── (optional) index.css
```
