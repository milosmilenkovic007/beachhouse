<?php
/**
 * Employee model
 *
 * @package Milos
 * @subpackage Chriss
 */

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

/**
 * Employee model
 */
final class Employee {

	/**
	 * Post ID.
	 *
	 * @var int
	 */
	private $id;

	/**
	 * Employee constructor.
	 *
	 * @param  int $id post ID of an employee.
	 * @return void
	 */
	public function __construct( $id ) {
		$this->id = $id;
	}

	/**
	 * Get ID of the employee
	 *
	 * @return int
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Get permalink of the employee
	 *
	 * @return string
	 */
	public function get_url() {
		return get_permalink( $this->id );
	}

	/**
	 * Get employee name.
	 *
	 * @return string
	 */
	public function get_name() {
		return get_the_title( $this->id );
	}

	/**
	 * Get employee image's attachment ID.
	 *
	 * @return int
	 */
	public function get_image_id() {
		$image = get_field( 'employee_image', $this->id );
		return $image['ID'];
	}

	/**
	 * Get employee's phone number.
	 *
	 * @return string
	 */
	public function get_phone() {
		return get_field( 'employee_phone', $this->id );
	}

	/**
	 * Get employee's email.
	 *
	 * @return string
	 */
	public function get_email() {
		return get_field( 'employee_email', $this->id );
	}

	/**
	 * Get employee's positions.
	 *
	 * @return string[]
	 */
	public function get_positions() {
		$terms = get_field( 'employee_positions', $this->id );
		$positions = array();
		foreach ( $terms as $term ) :
			$positions[] = $term->name;
		endforeach;
		return $positions;
	}

	/**
	 * Get employee's offices.
	 *
	 * @return mixed[]
	 */
	public function get_offices() {
		return array_map(
			function ( $post ) {
				return $post->post_title;
			},
			$this->get_offices_posts()
		);
	}

	/**
	 * Get employee's offices WP posts.
	 *
	 * @return mixed[]
	 */
	public function get_offices_posts() {
		$office_ids = get_field( 'employee_office', $this->id );
		$items = array();
		if ( ! empty( $office_ids ) ) :
			foreach ( $office_ids as $office_id ) :
				$post = get_post( $office_id );
				if ( $post ) :
					$items[] = $post;
				endif;
			endforeach;
		endif;
		return $items;
	}

/**
 * Get the content of the "About" field for the employee with preserved formatting.
 *
 * @return string
 */
public function get_about() {

    $content = get_field('employee_about', $this->id);
    return wpautop($content);
}
}
