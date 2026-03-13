---
name: acf-gutenberg-block
description: Use this skill when the user wants to create or modify a custom Gutenberg block using Advanced Custom Fields Pro in a WordPress theme or plugin.
---

# ACF Gutenberg Block Skill

Goal  
Help the user create or update a custom Gutenberg block using ACF Pro, including PHP registration, render template, and ACF field group definition.

## When to use

Use this skill when the user says things like:
- "Create a custom Gutenberg block with ACF"
- "Add a hero section block with image, title and button"
- "Refactor my existing ACF block structure"

## Instructions

1. Analyze the user's request:
   - Identify the block name (slug), title, and purpose.
   - Identify the fields needed (e.g., title, subtitle, image, button text, link, etc.).
   - Ask clarification if the layout or fields are ambiguous.

2. Project detection:
   - Detect if this is a theme (functions.php) or a plugin (main plugin file or `includes/`).
   - Locate an appropriate PHP file to register blocks (e.g., `includes/blocks.php` or `functions.php`).
   - If none exists, propose creating a dedicated file like `includes/acf-blocks.php`.

3. Block registration:
   - Use `acf_register_block_type` inside an `acf/init` hook.
   - Follow this pattern:

     ```php
     if ( function_exists('acf_register_block_type') ) {
         add_action('acf/init', 'project_register_acf_blocks');
     }

     function project_register_acf_blocks() {
         acf_register_block_type([
             'name'              => 'BLOCK_SLUG',
             'title'             => __('BLOCK_TITLE'),
             'description'       => 'SHORT_DESCRIPTION',
             'render_template'   => 'PATH_TO_TEMPLATE',
             'category'          => 'formatting',
             'icon'              => 'screenoptions',
             'keywords'          => ['keyword1', 'keyword2'],
             'mode'              => 'edit',
             'supports'          => [
                 'align' => true,
                 'anchor' => true,
                 'jsx' => false,
             ],
         ]);
     }
     ```

   - Replace `BLOCK_SLUG`, `BLOCK_TITLE`, `SHORT_DESCRIPTION`, and `PATH_TO_TEMPLATE` based on the user's context.

4. Template creation:
   - Create or update the render template file, e.g. `template-parts/blocks/BLOCK_SLUG.php`.
   - Use `get_field()` or `the_field()` to read ACF fields.
   - Follow the pattern from `examples/hero_block.php` for structure and escaping.
   - Always use proper escaping: `esc_html`, `esc_url`, `esc_attr`.

5. ACF field group:

   - Describe a field group the user can create in the ACF UI.
   - Specify:
     - Field names and types.
     - Location rule: "Block is equal to {BLOCK_TITLE}".
   - If the user prefers PHP export, generate the `acf_add_local_field_group` snippet.

6. Scripts usage (optional):

   - If the user asks to "scaffold the block files", call the script:

     ```bash
     bash scripts/create_acf_block.sh BLOCK_SLUG "Block Title"
     ```

   - Explain what the script will do: create a PHP registration stub and a template file based on the example.

7. Output:

   - Provide:
     - The PHP registration code.
     - The template PHP code.
     - The ACF field group definition (UI description or PHP export).
   - Show where to paste each snippet (which file and path).
   - Remind the user to clear cache and re-build assets if using a build pipeline.

## Constraints

- Do not modify WordPress core files.
- Do not register blocks without a unique `name` slug.
- Always escape data before output.
- If the project already has an ACF block pattern, follow that style instead of introducing a new pattern.

## Example

User: "Create a hero banner block with background image, title, subtitle, and button."  
Agent:
- Creates `hero-banner` block registration.
- Writes a template similar to `examples/hero_block.php`.
- Lists the four fields for the ACF field group and the proper location rule.
