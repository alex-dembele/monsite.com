<?php
/**
 * @var $course_id
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use MasterStudy\Lms\Repositories\CurriculumSectionRepository;
use MasterStudy\Lms\Repositories\CurriculumMaterialRepository;

stm_lms_register_style( 'course_info' );

$meta          = STM_LMS_Helpers::parse_meta_field( $course_id );
$section_ids   = ( new CurriculumSectionRepository() )->get_course_section_ids( $course_id );
$lessons_count = ( new CurriculumMaterialRepository() )->count_by_type( $section_ids, 'stm-lessons' );
$meta_fields   = array();

$course_allow_basic_info        = \STM_LMS_Options::get_option( 'course_allow_basic_info', false );
$course_allow_requirements_info = \STM_LMS_Options::get_option( 'course_allow_requirements_info', false );
$course_allow_intended_audience = \STM_LMS_Options::get_option( 'course_allow_intended_audience', false );

if ( ! empty( $meta['current_students'] ) ) {
	$meta_fields[ esc_html__( 'Enrolled', 'masterstudy-lms-learning-management-system' ) ] = array(
		'text' => sprintf( _n( '%s student', '%s students', $meta['current_students'], 'masterstudy-lms-learning-management-system' ), $meta['current_students'] ),
		'icon' => 'fa-icon-stm_icon_users',
	);
} else {
	$meta_fields[ esc_html__( 'Enrolled', 'masterstudy-lms-learning-management-system' ) ] = array(
		'text' => sprintf( _n( '%s student', '%s students', 0, 'masterstudy-lms-learning-management-system' ), 0 ),
		'icon' => 'fa-icon-stm_icon_users',
	);
}

if ( ! empty( $meta['duration_info'] ) ) {
	$meta_fields[ esc_html__( 'Duration', 'masterstudy-lms-learning-management-system' ) ] = array(
		'text' => $meta['duration_info'],
		'icon' => 'fa-icon-stm_icon_clock',
	);
}

if ( ! empty( $lessons_count ) ) {
	$meta_fields[ esc_html__( 'Lectures', 'masterstudy-lms-learning-management-system' ) ] = array(
		'text' => $lessons_count,
		'icon' => 'fa-icon-stm_icon_bullhorn',
	);
}

if ( ! empty( $meta['video_duration'] ) ) {
	$meta_fields[ esc_html__( 'Video', 'masterstudy-lms-learning-management-system' ) ] = array(
		'text' => $meta['video_duration'],
		'icon' => 'fa-icon-stm_icon_film-play',
	);
}

if ( ! empty( $meta['level'] ) ) {
	$levels = STM_LMS_Helpers::get_course_levels();

	$meta_fields[ esc_html__( 'Level', 'masterstudy-lms-learning-management-system' ) ] = array(
		'text' => $levels[ $meta['level'] ],
		'icon' => 'stmlms-chart-growth',
	);
}

if ( ! empty( $meta_fields ) ) : ?>
	<div class="stm-lms-course-info heading_font">
		<?php foreach ( $meta_fields as $meta_field_key => $meta_field ) : ?>
			<div class="stm-lms-course-info__single">
				<div class="stm-lms-course-info__single_label">
					<span><?php echo esc_html( $meta_field_key ); ?></span>:
					<strong><?php echo esc_html( $meta_field['text'] ); ?></strong>
				</div>
				<div class="stm-lms-course-info__single_icon">
					<i class="<?php echo esc_html( $meta_field['icon'] ); ?>"></i>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php else : ?>
	<div class="stm-lms-course-info">
		<div class="stm-lms-course-info__single"></div>
	</div>
	<?php
endif;
?>
	<div class="masterstudy-course-meta-info-wrapper">
		<?php
		if ( $course_allow_basic_info ) {
			STM_LMS_Templates::show_lms_template(
				'components/course-info',
				array(
					'course_id' => $course_id,
					'meta'      => $meta['basic_info'] ?? '',
					'title'     => esc_html__( 'Basic info', 'masterstudy-lms-learning-management-system' ),
				),
			);
		}
		if ( $course_allow_requirements_info ) {
			STM_LMS_Templates::show_lms_template(
				'components/course-info',
				array(
					'course_id' => $course_id,
					'meta'      => $meta['requirements'] ?? '',
					'title'     => esc_html__( 'Course requirements', 'masterstudy-lms-learning-management-system' ),
				),
			);
		}
		if ( $course_allow_intended_audience ) {
			STM_LMS_Templates::show_lms_template(
				'components/course-info',
				array(
					'course_id' => $course_id,
					'meta'      => $meta['intended_audience'] ?? '',
					'title'     => esc_html__( 'Intended audience', 'masterstudy-lms-learning-management-system' ),
				),
			);
		}
		?>
	</div>
<?php
