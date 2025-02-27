<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function stm_lms_wp_head() {
	?>
	<script type="text/javascript">
		var stm_lms_ajaxurl = '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>';
		var stm_lms_resturl = '<?php echo rest_url( 'stm-lms/v1', 'json' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>';
		var ms_lms_resturl = '<?php echo rest_url( 'masterstudy-lms/v2', 'json' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>';
		var ms_lms_nonce = '<?php echo wp_create_nonce( 'wp_rest' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>';
		var stm_ajax_add_pear_hb = '<?php echo wp_create_nonce( 'stm_ajax_add_pear_hb' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>';
	</script>
	<style>
		.vue_is_disabled {
			display: none;
		}
		#wp-admin-bar-lms-settings img {
			max-width: 16px;
			vertical-align: sub;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'stm_lms_wp_head' );
add_action( 'admin_head', 'stm_lms_wp_head' );

function stm_lms_enqueue_ss() {
	$v      = ( WP_DEBUG ) ? time() : STM_LMS_DB_VERSION;
	$assets = STM_LMS_URL . 'assets';
	$base   = STM_LMS_URL . 'libraries/nuxy/metaboxes/assets/'; // Rewrite STM_WPCFTO_URL

	wp_enqueue_style( 'fonts', $assets . '/css/variables/fonts.css', array(), $v );
	wp_enqueue_style( 'font-awesome-min', $assets . '/vendors/font-awesome.min.css', null, $v, 'all' );
	wp_enqueue_style( 'ms-font-icomoon', $assets . '/vendors/icomoon.fonts.css', null, $v, 'all' );
	wp_enqueue_style( 'stm_lms_icons', $assets . '/icons/style.css', null, $v );
	wp_enqueue_style( 'video.js', $assets . '/vendors/video-js.min.css', null, $v, 'all' );
	wp_register_style( 'owl.carousel', $assets . '/vendors/owl.carousel.min.css', null, $v, 'all' );

	wp_enqueue_script( 'jquery' );

	if ( STM_LMS_Helpers::is_stripe_enabled() ) {
		wp_enqueue_script( 'stripe.js', 'https://js.stripe.com/v3/#lms_defer', array(), false, false ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.NoExplicitVersion
	}

	$vue = ( ! WP_DEBUG ) ? '.min' : '.min';
	wp_register_script( 'vue.js', $base . "js/vue{$vue}.js", array( 'jquery' ), $v, false );
	wp_register_script( 'vue-resource.js', $base . 'js/vue-resource.min.js', array( 'vue.js' ), $v, false );
	wp_register_script( 'vue2-editor.js', $base . 'js/vue2-editor.min.js', array( 'vue.js' ), $v, false );
	wp_enqueue_script( 'vue.js' );
	wp_enqueue_script( 'vue-resource.js' );
	$r_enabled = STM_LMS_Helpers::g_recaptcha_enabled();
	if ( $r_enabled ) :
		$recaptcha = STM_LMS_Helpers::g_recaptcha_keys();

		wp_register_script(
			'stm_grecaptcha',
			'https://www.google.com/recaptcha/api.js?T=1&render=' . $recaptcha['public'],
			array( 'jquery' ),
			$v,
			true
		);
	endif;

	wp_register_script( 'jquery.cookie', $assets . '/vendors/jquery.cookie.js', array( 'jquery' ), $v, true );
	wp_register_script( 'resize-sensor', $assets . '/vendors/ResizeSensor.js', array( 'jquery' ), $v, true );
	wp_register_script( 'sticky-sidebar', $assets . '/vendors/sticky-sidebar.min.js', array( 'jquery' ), $v, true );
	wp_register_script( 'video.js', $assets . '/vendors/video.min.js', array(), $v, true );
	wp_register_script( 'owl.carousel', $assets . '/vendors/owl.carousel.js', array( 'jquery' ), $v, true );
	wp_register_script( 'vue2-autocomplete', $assets . '/vendors/vue2-autocomplete.js', array( 'vue.js' ), $v, true );
	wp_enqueue_script( 'vue2-datepicker', $base . 'js/vue2-datepicker.min.js', array( 'vue.js' ), $v, false );
	wp_enqueue_script( 'lms_countdown.js', $assets . '/js/countdown.js', array( 'jquery' ), $v, true );
	wp_register_script( 'jquery.countdown', $assets . '/vendors/jquery.countdown.js', array( 'jquery' ), $v, true );
	wp_register_script( 'js.countdown', $assets . '/vendors/js.countdown.js', array( 'jquery' ), $v, true );
	wp_register_script( 'stm-lms-wishlist', $assets . '/js/wishlist.js', array( 'jquery' ), $v, true );

	if ( stm_lms_has_custom_colors() ) {
		wp_enqueue_style( 'masterstudy-lms-learning-management-system', stm_lms_custom_styles_url() . '/stm_lms_styles/stm_lms.css', array(), stm_lms_custom_styles_v() );
	} else {
		wp_enqueue_style( 'masterstudy-lms-learning-management-system', $assets . '/css/stm_lms.css', array(), time() );
	}

	if ( is_rtl() ) {
		wp_enqueue_style( 'masterstudy-lms-learning-management-system-rtl-styles', $assets . '/css/rtl-styles.css', array(), time() );
	}
	if ( function_exists( 'vc_asset_url' ) ) {
		wp_register_style( 'stm_lms_wpb_front_css', vc_asset_url( 'css/js_composer.min.css' ), null, MS_LMS_VERSION );
	}
	if ( is_user_logged_in() ) {
		stm_lms_register_style( 'become_instructor' );
	}

	if ( current_user_can( 'edit_posts' ) ) {
		wp_enqueue_style( 'stm_lms_logged_in', $assets . '/css/stm_lms_logged_in.css', null, $v, 'all' );
	}

	stm_lms_register_script( 'lms' );
	wp_localize_script(
		'stm-lms-lms',
		'stm_lms_vars',
		array(
			'symbol'             => STM_LMS_Options::get_option( 'currency_symbol', '$' ),
			'position'           => STM_LMS_Options::get_option( 'currency_position', 'left' ),
			'currency_thousands' => STM_LMS_Options::get_option( 'currency_thousands', ',' ),
			'wp_rest_nonce'      => wp_create_nonce( 'wp_rest' ),
		)
	);

	if ( STM_LMS_Subscriptions::subscription_enabled() ) {
		stm_lms_register_style( 'pmpro' );
	}

	/*Enqueue not MasterStudy theme related styles*/
	if ( ! stm_lms_is_masterstudy_theme() ) {
		stm_lms_register_style( 'noconflict/main' );
		stm_lms_register_script( 'noconflict/main', array( 'jquery' ) );
	}
}

function stm_lms_enqueue_component_scripts() {
	/*Components scripts registration*/
	wp_register_script( 'masterstudy-lamejs', STM_LMS_URL . '/assets/vendors/lamejs.js', array( 'jquery' ), MS_LMS_VERSION, true );
	/*Pages styles*/
	wp_register_style( 'masterstudy-login-page', STM_LMS_URL . '/assets/css/pages/login.css', null, MS_LMS_VERSION );

	/*Components vendors*/
	wp_register_script( 'masterstudy-select2', STM_LMS_URL . '/assets/vendors/select2.min.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_style( 'masterstudy-select2', STM_LMS_URL . '/assets/vendors/select2.min.css', null, MS_LMS_VERSION );

	/*Components scripts registration*/
	wp_register_script( 'masterstudy-authorization-main', STM_LMS_URL . '/assets/js/components/authorization/main.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-authorization-ajax', STM_LMS_URL . '/assets/js/components/authorization/ajax.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-authorization-new-pass', STM_LMS_URL . '/assets/js/components/authorization/new-pass.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-countdown', STM_LMS_URL . '/assets/js/components/countdown.js', array( 'jquery', 'jquery.countdown', 'js.countdown' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-curriculum-accordion', STM_LMS_URL . 'assets/js/components/curriculum-accordion.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-curriculum-list', STM_LMS_URL . 'assets/js/components/curriculum-list.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-discussions', STM_LMS_URL . 'assets/js/components/discussions.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-hint', STM_LMS_URL . '/assets/js/components/hint.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-loader', STM_LMS_URL . 'assets/js/components/loader.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-pagination', STM_LMS_URL . 'assets/js/components/pagination.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-ajax-pagination', STM_LMS_URL . 'assets/js/components/ajax-pagination.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-tabs-pagination', STM_LMS_URL . 'assets/js/components/tabs-pagination.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-wp-editor', STM_LMS_URL . 'assets/js/components/wp-editor.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-buy-button', STM_LMS_URL . '/assets/js/components/buy-button.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-dark-mode-button', STM_LMS_URL . '/assets/js/components/dark-mode-button.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-radio-buttons', STM_LMS_URL . '/assets/js/components/radio-buttons.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-message', STM_LMS_URL . '/assets/js/components/message.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-audio-player', STM_LMS_URL . '/assets/js/components/audio-player.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-video-recorder', STM_LMS_URL . '/assets/js/components/video-recorder.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-audio-recorder', STM_LMS_URL . '/assets/js/components/audio-recorder.js', array( 'jquery', 'masterstudy-lamejs' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-modals', STM_LMS_URL . '/assets/js/components/modals/modals.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-membership-trigger', STM_LMS_URL . '/assets/js/components/modals/membership-trigger.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-membership-add-to-cart', STM_LMS_URL . '/assets/js/components/modals/membership-add-to-cart.js', array( 'jquery' ), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-search', STM_LMS_URL . 'assets/js/components/search.js', array(), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-sort-indicator', STM_LMS_URL . 'assets/js/components/sort-indicator.js', array(), MS_LMS_VERSION, true );
	wp_register_script( 'masterstudy-attachment-media', STM_LMS_URL . 'assets/js/components/attachment-media.js', array( 'masterstudy-video-recorder', 'masterstudy-audio-recorder', 'masterstudy-audio-player' ), MS_LMS_VERSION, true );
	wp_register_script( 'ms_lms_courses_searchbox_autocomplete', STM_LMS_URL . '/assets/vendors/vue2-autocomplete.js', array(), STM_LMS_VERSION, true );
	wp_register_script( 'ms_lms_courses_searchbox', STM_LMS_URL . '/assets/js/elementor-widgets/course-search-box/course-search-box.js', array( 'jquery' ), STM_LMS_VERSION, true );

	/*Components styles registration*/
	wp_enqueue_style( 'masterstudy-search', STM_LMS_URL . '/assets/css/components/search.css', null, MS_LMS_VERSION );
	wp_enqueue_style( 'masterstudy-sort-indicator', STM_LMS_URL . '/assets/css/components/sort-indicator.css', null, MS_LMS_VERSION );
	wp_enqueue_style( 'masterstudy-loader', STM_LMS_URL . 'assets/css/components/loader.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-authorization', STM_LMS_URL . 'assets/css/components/authorization.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-components-fonts', STM_LMS_URL . 'assets/css/components/fonts.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-alert', STM_LMS_URL . '/assets/css/components/alert.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-back-link', STM_LMS_URL . '/assets/css/components/back-link.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-button', STM_LMS_URL . '/assets/css/components/button.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-countdown', STM_LMS_URL . '/assets/css/components/countdown.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-curriculum-accordion', STM_LMS_URL . '/assets/css/components/curriculum-accordion.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-curriculum-list', STM_LMS_URL . '/assets/css/components/curriculum-list.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-discussions', STM_LMS_URL . '/assets/css/components/discussions.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-file-attachment', STM_LMS_URL . '/assets/css/components/file-attachment.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-file-upload', STM_LMS_URL . '/assets/css/components/file-upload.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-hint', STM_LMS_URL . '/assets/css/components/hint.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-nav-button', STM_LMS_URL . '/assets/css/components/nav-button.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-pagination', STM_LMS_URL . '/assets/css/components/pagination.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-progress', STM_LMS_URL . '/assets/css/components/progress.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-switch-button', STM_LMS_URL . '/assets/css/components/switch-button.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-tabs-pagination', STM_LMS_URL . '/assets/css/components/tabs-pagination.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-tabs', STM_LMS_URL . '/assets/css/components/tabs.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-wp-editor', STM_LMS_URL . '/assets/css/components/wp-editor.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-buy-button', STM_LMS_URL . '/assets/css/components/buy-button.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-dark-mode-button', STM_LMS_URL . '/assets/css/components/dark-mode-button.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-message', STM_LMS_URL . '/assets/css/components/message.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-radio-buttons', STM_LMS_URL . '/assets/css/components/radio-buttons.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-audio-player', STM_LMS_URL . '/assets/css/components/audio-player.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-video-player', STM_LMS_URL . '/assets/css/components/video-player.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-video-recorder', STM_LMS_URL . '/assets/css/components/video-recorder.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-audio-recorder', STM_LMS_URL . '/assets/css/components/audio-recorder.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-become-instructor-modal', STM_LMS_URL . '/assets/css/components/become-instructor-modal.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-enterprise-modal', STM_LMS_URL . '/assets/css/components/enterprise-modal.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-membership-modal', STM_LMS_URL . '/assets/css/components/membership-modal.css', null, MS_LMS_VERSION );
	wp_register_style( 'masterstudy-attachment-media', STM_LMS_URL . '/assets/css/components/attachment-media.css', array( 'masterstudy-audio-player', 'masterstudy-video-player', 'masterstudy-file-attachment' ), MS_LMS_VERSION );
	wp_register_style( 'masterstudy-call-to-action', STM_LMS_URL . '/assets/css/elementor-widgets/call-to-action.css', array(), STM_LMS_VERSION, false );
	wp_register_style( 'masterstudy-membership-levels', STM_LMS_URL . '/assets/css/elementor-widgets/membership-levels.css', array(), STM_LMS_VERSION, false );
	wp_register_style( 'ms_lms_courses_searchbox', STM_LMS_URL . '/assets/css/elementor-widgets/course-search-box/course-search-box.css', array(), STM_LMS_VERSION, false );
	wp_register_style( 'profile-auth-links-style', STM_LMS_URL . '/assets/css/elementor-widgets/auth-links.css', array(), STM_LMS_VERSION, false );
}

function stm_lms_enqueue_vss() {
	$v      = ( WP_DEBUG ) ? time() : STM_LMS_DB_VERSION;
	$assets = STM_LMS_URL . 'assets';
	$base   = STM_LMS_URL . 'nuxy/metaboxes/assets/';

	if ( apply_filters( 'stm_lms_enqueue_bootstrap', true ) ) {
		wp_enqueue_style( 'masterstudy-bootstrap', $assets . '/vendors/bootstrap.min.css', null, $v, 'all' );
		wp_enqueue_style( 'masterstudy-bootstrap-custom', $assets . '/vendors/ms-bootstrap-custom.css', null, $v, 'all' );

		wp_enqueue_script( 'masterstudy-bootstrap', $assets . '/vendors/bootstrap.min.js', array( 'jquery' ), $v, true );
		wp_enqueue_script( 'masterstudy-bootstrap-custom', $assets . '/vendors/ms-bootstrap-custom.js', array( 'jquery' ), $v, true );
	}
}

add_action( 'wp_enqueue_scripts', 'stm_lms_enqueue_ss' );
add_action( 'wp_enqueue_scripts', 'stm_lms_enqueue_vss', 1 );
add_action( 'wp_enqueue_scripts', 'stm_lms_enqueue_component_scripts' );
add_action( 'admin_enqueue_scripts', 'stm_lms_enqueue_component_scripts' );

add_action( 'admin_head', 'stm_lms_nonces' );
add_action( 'wp_head', 'stm_lms_nonces' );

function stm_lms_elementor__widgets_styles() {
	$v      = ( WP_DEBUG ) ? time() : STM_LMS_DB_VERSION;
	$assets = STM_LMS_URL . 'assets';

	wp_enqueue_style( 'lms-elementor', $assets . '/css/lms-elementor.css', null, $v, 'all' );
}

add_action( 'elementor/editor/before_enqueue_scripts', 'stm_lms_elementor__widgets_styles' );

function stm_lms_nonces() {
	$nonces = array(
		'stm_install_starter_theme',
		'load_modal',
		'load_content',
		'start_quiz',
		'user_answers',
		'get_order_info',
		'user_orders',
		'stm_lms_get_instructor_courses',
		'stm_lms_add_comment',
		'stm_lms_manage_students',
		'stm_lms_get_comments',
		'stm_lms_login',
		'stm_lms_register',
		'stm_lms_become_instructor',
		'stm_lms_enterprise',
		'stm_lms_get_user_courses',
		'stm_lms_get_user_quizzes',
		'stm_lms_wishlist',
		'stm_lms_save_user_info',
		'stm_lms_lost_password',
		'stm_lms_change_avatar',
		'stm_lms_delete_avatar',
		'stm_lms_complete_lesson',
		'stm_lms_use_membership',
		'stm_lms_change_featured',
		'stm_lms_delete_course_subscription',
		'stm_lms_get_reviews',
		'stm_lms_add_review',
		'stm_lms_add_to_cart',
		'stm_lms_delete_from_cart',
		'stm_lms_purchase',
		'stm_lms_send_message',
		'stm_lms_get_user_conversations',
		'stm_lms_get_user_messages',
		'wpcfto_save_settings',
		'stm_lms_tables_update',
		'stm_lms_get_enterprise_groups',
		'stm_lms_get_enterprise_group',
		'stm_lms_add_enterprise_group',
		'stm_lms_delete_enterprise_group',
		'stm_lms_add_to_cart_enterprise',
		'stm_lms_get_user_ent_courses',
		'stm_lms_delete_user_ent_courses',
		'stm_lms_add_user_ent_courses',
		'stm_lms_change_ent_group_admin',
		'stm_lms_delete_user_from_group',
		'stm_lms_import_groups',
		'stm_lms_upload_file_assignment',
		'stm_lms_delete_assignment_file',
		'stm_lms_save_draft_content',
		'stm_lms_accept_draft_assignment',
		'stm_lms_get_assignment_data',
		'stm_lms_get_instructor_assingments',
		'stm_lms_get_user_assingments',
		'stm_lms_edit_user_answer',
		'stm_lms_get_user_points_history',
		'stm_lms_buy_for_points',
		'stm_lms_get_point_users',
		'stm_lms_get_user_points_history_admin',
		'stm_lms_change_points',
		'stm_lms_delete_points',
		'stm_lms_get_user_bundles',
		'stm_lms_change_bundle_status',
		'stm_lms_delete_bundle',
		'stm_lms_check_certificate_code',
		'stm_lms_get_google_classroom_courses',
		'stm_lms_get_google_classroom_course',
		'stm_lms_get_google_classroom_publish_course',
		'stm_lms_get_g_c_get_archive_page',
		'install_zoom_addon',
		'stm_lms_get_course_cookie_redirect',
		'stm_get_certificates',
		'stm_get_certificate_fields',
		'stm_save_certificate',
		'stm_upload_certificate_images',
		'stm_generate_certificates_preview',
		'stm_save_default_certificate',
		'stm_delete_default_certificate',
		'stm_save_certificate_category',
		'stm_delete_certificate_category',
		'stm_get_certificate_categories',
		'stm_get_certificate',
		'stm_delete_certificate',
		'stm_lms_get_users_submissions',
		'stm_lms_update_user_status',
		'stm_lms_hide_become_instructor_notice',
		'stm_lms_ban_user',
		'stm_lms_save_forms',
		'stm_lms_get_forms',
		'stm_lms_upload_form_file',
		'stm_lms_dashboard_get_course_students',
		'stm_lms_dashboard_delete_user_from_course',
		'stm_lms_dashboard_add_user_to_course',
		'stm_lms_dashboard_import_users_to_course',
		'stm_lms_dashboard_export_course_students_to_csv',
		'stm_lms_add_to_cart_guest',
		'stm_lms_fast_login',
		'stm_lms_fast_register',
		'stm_lms_change_lms_author',
		'stm_lms_add_student_manually',
		'stm_lms_change_course_status',
		'stm_lms_total_progress',
		'stm_lms_add_h5p_result',
		'stm_lms_toggle_buying',
		'stm_lms_logout',
		'stm_lms_restore_password',
		'stm_lms_hide_announcement',
		'stm_lms_get_curriculum_v2',
		'stm_lms_dashboard_get_student_progress',
		'stm_lms_dashboard_set_student_item_progress',
		'stm_lms_dashboard_reset_student_progress',
		'stm_lms_dashboard_get_courses_list',
		'stm_lms_dashboard_get_student_assignments',
		'stm_lms_dashboard_get_student_quizzes',
		'stm_lms_dashboard_get_student_quiz',
		'stm_lms_wizard_save_settings',
		'stm_lms_wizard_save_business_type',
		'stm_lms_get_enrolled_assingments',
		'stm-lms-starter-theme-install',
	);

	$nonces_list = array();

	foreach ( $nonces as $nonce_name ) {
		$nonces_list[ $nonce_name ] = wp_create_nonce( $nonce_name );
	}

	?>
	<script>
		var stm_lms_nonces = <?php echo wp_json_encode( $nonces_list ); ?>;
	</script>
	<?php
}
