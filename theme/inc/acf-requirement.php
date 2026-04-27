<?php
/**
 * ACF Requirement Check
 *
 * @package ulziibat-tech
 */

function site_check_acf_requirement() {
	if ( ! function_exists( 'get_field' ) ) {
		// If we are on the frontend, show a friendly error page matching 404.php design.
		if ( ! is_admin() ) {
			add_filter(
				'template_include',
				function() {
					return get_template_directory() . '/template-parts/layout/acf-error.php';
				},
				99
			);
		}

		// Show notice in admin.
		add_action(
			'admin_notices',
			function() {
				?>
			<div class="notice notice-error is-dismissible">
				<p><?php esc_html_e( 'CRITICAL: Advanced Custom Fields (ACF) PRO plugin is required for this theme to function properly. Please install and activate it.', 'ulziibat-tech' ); ?></p>
			</div>
				<?php
			}
		);
	}
}
add_action( 'plugins_loaded', 'site_check_acf_requirement' );
