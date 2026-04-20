# TutorLMS Override Rules

## Golden Rule
NEVER edit files inside `wp-content/plugins/tutor/`. All customizations go in the theme.

## Override Workflow
1. Find the template in `wp-content/plugins/tutor/templates/`
2. Copy it to `theme/tutor/` preserving the exact subdirectory path
   - Plugin: `plugins/tutor/templates/single-course.php`
   - Theme:  `theme/tutor/single-course.php`
3. Style with Tailwind utility classes — do not add custom CSS files
4. Test at 375px mobile width before shipping

## Directory Mapping
```
plugins/tutor/templates/          →  theme/tutor/
plugins/tutor/templates/course/   →  theme/tutor/course/
plugins/tutor/templates/lesson/   →  theme/tutor/lesson/
plugins/tutor/templates/quiz/     →  theme/tutor/quiz/
```

## Common Override Targets
- `single-course.php` — course detail page
- `course/enrolled.php` — enrolled student view
- `lesson/lesson.php` — lesson player
- `quiz/quiz.php` — quiz interface
- `dashboard/` — student dashboard pages

## Hooks to Know
- `tutor_course/before_course_content` — inject before course body
- `tutor_course/after_course_content` — inject after course body
- `tutor_lesson/before_lesson_content` — inject before lesson
- Use `add_action()` in `functions.php` for hook-based customizations

## Tailwind in Tutor Overrides
- Use utility classes directly on elements
- Wrap TutorLMS output in a `<div class="ub-tutor-*">` container for scoping
- Ensure Tailwind CSS is compiled and enqueued on tutor pages
