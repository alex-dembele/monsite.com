<?php

namespace MasterStudy\Lms\Repositories;

use MasterStudy\Lms\Repositories\CurriculumMaterialRepository;

final class StudentsRepository {

	public function get_course_students( array $params = array() ) {
		global $wpdb;
		$course_table = stm_lms_user_courses_name( $wpdb );
		$user_table   = $wpdb->users;

		$fields = "{$course_table}.user_id, {$course_table}.course_id, {$course_table}.start_time, {$course_table}.progress_percent, {$user_table}.display_name";

		$per_page  = $params['per_page'] ?? 10;
		$page      = $params['page'] ?? 1;
		$course_id = $params['course_id'] ?? 0;
		$offset    = ( $page - 1 ) * $per_page;
		$filtering = '';

		if ( ! empty( $params['order'] ) && ! empty( $params['orderby'] ) ) {
			$order = strtoupper( $params['order'] );
			if ( in_array( $order, array( 'ASC', 'DESC' ), true ) ) {
				switch ( $params['orderby'] ) {
					case 'username':
						$filtering .= " ORDER BY {$user_table}.display_name {$order}";
						break;
					case 'email':
						$filtering .= " ORDER BY {$user_table}.user_email {$order}";
						break;
					case 'ago':
						$filtering .= " ORDER BY {$course_table}.start_time {$order}";
						break;
					case 'progress_percent':
						$filtering .= " ORDER BY {$course_table}.progress_percent {$order}";
						break;
				}
			}
		}

		if ( ! empty( $params['s'] ) ) {
			$filtering = $wpdb->prepare(
				' AND LOWER(display_name) LIKE %s',
				'%' . strtolower( $params['s'] ) . '%'
			);
		}

		$students = $wpdb->get_results(
			$wpdb->prepare(
				//phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				"SELECT {$fields} FROM {$course_table} INNER JOIN $user_table ON {$course_table}.user_id = {$user_table}.ID WHERE {$course_table}.course_id = %d {$filtering} LIMIT %d OFFSET %d",
				$course_id,
				$per_page,
				$offset
			),
			ARRAY_A
		);

		foreach ( $students as &$data ) {
			$data                  = ( new \STM_LMS_User_Manager_Course() )->map_students( $data );
			$student_id            = $data['user_id'];
			$data['progress_link'] = \STM_LMS_Instructor::instructor_manage_students_url() . "/?course_id=$course_id&student_id=$student_id";
		}

		$total_rows = $wpdb->get_var(
			$wpdb->prepare(
				//phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				"SELECT COUNT(*) FROM {$course_table} INNER JOIN {$user_table} ON {$course_table}.user_id = {$user_table}.ID WHERE {$course_table}.course_id = %d {$filtering}",
				$course_id
			)
		);

		$output = array(
			'students'  => $students,
			'page'      => $page,
			'total'     => $this->get_course_students_count( $course_id ),
			'per_page'  => $per_page,
			'max_pages' => ceil( $total_rows / $per_page ),
		);

		return $output;
	}

	public function get_course_students_count( $course_id ) {
		global $wpdb;
		$course_table = stm_lms_user_courses_name( $wpdb );

		return $wpdb->get_var(
			$wpdb->prepare(
				//phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				"SELECT COUNT(*) FROM {$course_table} WHERE course_id = %d",
				$course_id
			)
		);
	}

	public function add_student( $course_id, $data ) {
		$course_id          = intval( $course_id );
		$user               = get_user_by( 'email', $data['email'] );
		$is_enrolled        = false;
		$is_enrolled_before = false;

		if ( $user ) {
			$course             = \STM_LMS_Course::get_user_course( $user->ID, $course_id );
			$is_enrolled_before = ! empty( $course ) && intval( $course['course_id'] ) === $course_id;
		}

		$added = \STM_LMS_Instructor::add_student_to_course( array( $course_id ), array( $data['email'] ) );

		if ( ! $added['error'] ) {
			$first_name  = sanitize_text_field( trim( $user_data['first_name'] ?? '' ) );
			$last_name   = sanitize_text_field( trim( $user_data['last_name'] ?? '' ) );
			$user        = get_user_by( 'email', $data['email'] );
			$is_enrolled = true;

			if ( $user && ( $first_name || $last_name ) ) {
				wp_update_user(
					array(
						'ID'           => $user->ID,
						'first_name'   => $first_name,
						'last_name'    => $last_name,
						'display_name' => "$first_name $last_name",
					)
				);
			}
		}

		return array(
			'email'              => $data['email'],
			'student_id'         => $user ? $user->ID : 0,
			'is_enrolled'        => $is_enrolled,
			'is_enrolled_before' => $is_enrolled_before,
		);
	}

	public function delete_student( $course_id, $student_id ) {
		$userdata = get_userdata( $student_id );

		if ( $userdata ) {
			stm_lms_get_delete_user_course( $student_id, $course_id );
			$meta = \STM_LMS_Helpers::parse_meta_field( $course_id );

			if ( ! empty( $meta['current_students'] ) && $meta['current_students'] > 0 ) {
				update_post_meta( $course_id, 'current_students', --$meta['current_students'] );
			}
		}
	}

	public function export_students( $course_id ) {
		$users      = stm_lms_get_course_users( $course_id );
		$users_data = array();

		foreach ( $users as $user ) {
			if ( isset( $user['user_id'] ) ) {
				$user_data    = get_userdata( $user['user_id'] );
				$users_data[] = array(
					'email'      => $user_data->user_email,
					'first_name' => $user_data->first_name,
					'last_name'  => $user_data->last_name,
				);
			}
		}

		return $users_data;
	}

	public function set_student_progress( $course_id, $student_id, $data ) {
		$item_id   = $data['item_id'];
		$completed = rest_sanitize_boolean( $data['completed'] );

		$course_materials = ( new CurriculumMaterialRepository() )->get_course_materials( $course_id );
		// phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
		if ( empty( $course_materials ) || ! in_array( $item_id, $course_materials ) ) {
			return array();
		}

		switch ( get_post_type( $item_id ) ) {
			case 'stm-lessons':
				\STM_LMS_User_Manager_Course_User::complete_lesson( $student_id, $course_id, $item_id );
				break;
			case 'stm-assignments':
				\STM_LMS_User_Manager_Course_User::complete_assignment( $student_id, $course_id, $item_id, $completed );
				break;
			case 'stm-quizzes':
				\STM_LMS_User_Manager_Course_User::complete_quiz( $student_id, $course_id, $item_id, $completed );
				break;
		}

		\STM_LMS_Course::update_course_progress( $student_id, $course_id );

		return \STM_LMS_User_Manager_Course_User::_student_progress( $course_id, $student_id );
	}

	public function reset_student_progress( $course_id, $student_id ) {
		$curriculum = ( new CurriculumRepository() )->get_curriculum( $course_id );

		if ( empty( $curriculum['materials'] ) ) {
			return array();
		}

		foreach ( $curriculum['materials'] as $material ) {
			switch ( $material['post_type'] ) {
				case 'stm-lessons':
					\STM_LMS_User_Manager_Course_User::reset_lesson( $student_id, $course_id, $material['post_id'] );
					break;
				case 'stm-assignments':
					\STM_LMS_User_Manager_Course_User::reset_assignment( $student_id, $course_id, $material['post_id'] );
					break;
				case 'stm-quizzes':
					\STM_LMS_User_Manager_Course_User::reset_quiz( $student_id, $course_id, $material['post_id'] );
					break;
			}
		}

		stm_lms_reset_user_answers( $course_id, $student_id );

		\STM_LMS_Course::update_course_progress( $student_id, $course_id, true );

		return \STM_LMS_User_Manager_Course_User::_student_progress( $course_id, $student_id );
	}
}
