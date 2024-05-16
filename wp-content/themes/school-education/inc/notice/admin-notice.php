<?php
$theme = wp_get_theme();

$screen = get_current_screen();
if ( ! empty( $screen->base ) && 'appearance_page_school-education-getting-started' === $screen->base ) {
	return false;
}

?>
<div class="notice notice-success is-dismissible school-education-admin-notice">
	<div class="school-education-admin-notice-wrapper">
		<h2><?php esc_html_e( 'Thank you for selecting ', 'school-education' ); ?> <?php echo $theme->get( 'Name' ); ?> <?php esc_html_e( 'Theme!', 'school-education' ); ?></h2>
		<p><?php esc_html_e( 'Explore the benefits of our simple Demo Importer and automatic Plugin Installation. Click the button below to begin.', 'school-education' ); ?></p>
		<span class="admin-2-btn" >
			<a class="button-secondary" style="margin-bottom: 15px; margin-right: 10px; " href="<?php echo esc_url( admin_url( 'themes.php?page=school-education-getting-started' ) ); ?>"><?php esc_html_e( 'Import Theme Demo', 'school-education' ); ?></a>
	        <a class="button-primary" style="margin-bottom: 15px; " href="<?php echo esc_url('https://www.mizanthemes.com/elementor/school-wordpress-theme/'); ?>" target="_blank"><?php esc_html_e('Get School Education Pro', 'school-education'); ?></a>
        </span>
	</div>
</div>