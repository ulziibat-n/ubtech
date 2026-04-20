# Skill: create-acf-block

## Purpose
Scaffold a new ACF Gutenberg block from scratch.

## Steps

### 1. Create block directory
```
theme/blocks/{block-name}/
├── block.json
├── render.php
└── (optional) index.css
```

### 2. block.json
```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 3,
    "name": "ubtech/{block-name}",
    "title": "{Block Title}",
    "description": "{Description}",
    "category": "ubtech",
    "icon": "admin-generic",
    "acf": {
        "mode": "preview",
        "renderTemplate": "blocks/{block-name}/render.php"
    },
    "supports": {
        "align": false,
        "anchor": true
    }
}
```

### 3. render.php
```php
<?php
/**
 * {Block Title} block render template.
 *
 * @package ulziibat-tech
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = get_fields();
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
    <!-- block content here -->
</div>
```

### 4. Register in functions.php
Add inside `ub_register_acf_blocks()`:
```php
acf_register_block_type( array(
    'name'            => '{block-name}',
    'title'           => __( '{Block Title}', 'ub' ),
    'render_template' => get_template_directory() . '/theme/blocks/{block-name}/render.php',
    'category'        => 'ubtech',
    'icon'            => 'admin-generic',
    'keywords'        => array( 'ub', '{keyword}' ),
    'supports'        => array( 'align' => false, 'jsx' => true ),
) );
```

### 5. ACF Field Group Reminder
- Create field group in WP Admin → Custom Fields
- Set location rule: Block = {Block Title}
- ACF will auto-sync to `theme/json/` — commit the JSON file

## Verify Loop
PLAN → WRITE (block.json + render.php + register) → FORMAT (PHPCS + Prettier) → REVIEW (code-reviewer) → QA → SHIP
