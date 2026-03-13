#!/usr/bin/env bash
# Simple scaffolder for a new ACF Gutenberg block.

set -e

SLUG="$1"
TITLE="$2"

if [ -z "$SLUG" ] || [ -z "$TITLE" ]; then
  echo "Usage: create_acf_block.sh block-slug \"Block Title\""
  exit 1
fi

TEMPLATE_DIR="template-parts/blocks"
PHP_FILE="${TEMPLATE_DIR}/${SLUG}.php"

mkdir -p "${TEMPLATE_DIR}"

if [ -f "${PHP_FILE}" ]; then
  echo "File ${PHP_FILE} already exists. Not overwriting."
  exit 0
fi

cat > "${PHP_FILE}" <<EOF
<?php
/**
 * ${TITLE} Block Template.
 *
 * @var array \$block The block settings and attributes.
 */

\$title        = get_field('title');
\$subtitle     = get_field('subtitle');
\$background   = get_field('background_image');
\$button_text  = get_field('button_text');
\$button_link  = get_field('button_link');
?>

<section class="block-${SLUG}">
  <?php if (!empty(\$background)): ?>
    <div class="block-${SLUG}__bg">
      <img src="<?php echo esc_url(\$background['url']); ?>" alt="<?php echo esc_attr(\$background['alt'] ?? ''); ?>">
    </div>
  <?php endif; ?>

  <div class="block-${SLUG}__content">
    <?php if (!empty(\$title)): ?>
      <h2><?php echo esc_html(\$title); ?></h2>
    <?php endif; ?>

    <?php if (!empty(\$subtitle)): ?>
      <p class="block-${SLUG}__subtitle"><?php echo esc_html(\$subtitle); ?></p>
    <?php endif; ?>

    <?php if (!empty(\$button_text) && !empty(\$button_link)): ?>
      <a class="block-${SLUG}__button" href="<?php echo esc_url(\$button_link); ?>">
        <?php echo esc_html(\$button_text); ?>
      </a>
    <?php endif; ?>
  </div>
</section>
EOF

echo "Created template: ${PHP_FILE}"
