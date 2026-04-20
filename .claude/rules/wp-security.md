# WordPress Security Rules

## Output Escaping (mandatory on every echo)
- `esc_html()` — plain text content
- `esc_attr()` — HTML attribute values
- `esc_url()` — URLs in href/src
- `esc_textarea()` — textarea content
- `wp_kses_post()` — HTML that allows safe tags
- Never use `echo $var` raw — always escape

## Nonces
- Forms: `wp_nonce_field( 'ub_action', 'ub_nonce' )`
- AJAX: `wp_create_nonce( 'ub_action' )` in JS, verify with `check_ajax_referer()`
- Admin actions: `check_admin_referer( 'ub_action', 'ub_nonce' )`

## Database Queries
- Always use `$wpdb->prepare()` for any query with variables
- Use WP_Query / get_posts over raw SQL when possible
- Never interpolate user input into SQL strings

## File Security
- Every PHP file must start with: `if ( ! defined( 'ABSPATH' ) ) { exit; }`
- Never expose file paths or server info in output

## Capability Checks
- `current_user_can( 'capability' )` before any privileged action
- Use `sanitize_text_field()`, `sanitize_email()`, `absint()` on all user input

## AJAX
```php
add_action( 'wp_ajax_ub_action', 'ub_handle_action' );
add_action( 'wp_ajax_nopriv_ub_action', 'ub_handle_action' ); // if public

function ub_handle_action() {
    check_ajax_referer( 'ub_action', 'nonce' );
    // sanitize input, do work, return JSON
    wp_send_json_success( $data );
}
```
