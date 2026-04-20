# Skill: create-tutor-override

## Purpose
Override a TutorLMS template in the theme without touching plugin files.

## Steps

### 1. Identify the template
Find the template to override in:
```
wp-content/plugins/tutor/templates/
```

Common targets:
- `single-course.php`
- `course/enrolled.php`
- `lesson/lesson.php`
- `quiz/quiz.php`
- `dashboard/index.php`

### 2. Copy to theme (preserve path)
```bash
# Example: overriding single-course.php
cp wp-content/plugins/tutor/templates/single-course.php \
   wp-content/themes/ubtech/theme/tutor/single-course.php

# Example: overriding a nested template
cp wp-content/plugins/tutor/templates/dashboard/index.php \
   wp-content/themes/ubtech/theme/tutor/dashboard/index.php
```

### 3. Edit the theme copy only
- Open `theme/tutor/{template-path}.php`
- Replace plugin markup with Tailwind utility classes
- Keep all TutorLMS PHP logic intact — only change HTML/CSS
- Wrap in `<div class="ub-tutor-{name}">` for scoping

### 4. Style with Tailwind v4
```php
<div class="ub-tutor-course flex flex-col gap-6 p-4 md:p-8">
    <h1 class="text-2xl font-bold text-gray-900">
        <?php echo esc_html( get_the_title() ); ?>
    </h1>
</div>
```

### 5. Verify TutorLMS loads the override
TutorLMS checks `get_template_directory() . '/tutor/'` automatically.
No additional registration needed.

## Checklist
- [ ] Template copied (not moved) from plugin
- [ ] Path in `theme/tutor/` matches plugin path exactly
- [ ] All PHP logic from original preserved
- [ ] All output escaped
- [ ] Tested at 375px mobile
- [ ] No PHP errors in debug log
- [ ] Plugin files untouched

## Verify Loop
PLAN → IDENTIFY template → COPY → STYLE (Tailwind) → FORMAT (Prettier) → REVIEW (code-reviewer) → QA (375px) → SHIP
