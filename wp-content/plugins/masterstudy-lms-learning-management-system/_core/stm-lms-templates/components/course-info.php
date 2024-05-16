<?php
/**
 * Course info component.
 *
 * @var boolean $course_id
 * @var string $meta
 * @var string $title
 *
 * @package masterstudy
 */

if ( ! empty( $meta ) ) {
	?>
	<div class="multiseparator"></div>
	<div class="masterstudy-course-basic-info-content">
		<div class="info-title">
			<?php echo esc_html( $title ); ?>
		</div>
		<?php echo ( $meta ); //phpcs:ignore ?>
	</div>
	<?php
}
