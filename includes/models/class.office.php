<?php
/**
 * Office model
 *
 * @package Milos
 * @subpackage Chriss
 */

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

/**
 * Office model
 */
final class Office {

	/**
	 * Post ID.
	 *
	 * @var int
	 */
	private $id;

	/**
	 * Office constructor.
	 *
	 * @param  int $id post ID of an office.
	 * @return void
	 */
	public function __construct( $id ) {

		$this->id = $id;
	}

	/**
	 * Get ID of the office
	 *
	 * @return int
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Get permalink of the office
	 *
	 * @return string
	 */
	public function get_url() {
		return get_permalink( $this->id );
	}

	/**
	 * Get office name.
	 *
	 * @return string
	 */
	public function get_name() {
		return get_the_title( $this->id );
	}

	/**
	 * Get office phone number.
	 *
	 * @return string
	 */
	public function get_phone() {
		return get_field( 'office_phone', $this->id );
	}

	/**
	 * Get office email.
	 *
	 * @return string
	 */
	public function get_email() {
		return get_field( 'office_email', $this->id );
	}

	/**
	 * Get office address.
	 *
	 * @return string
	 */
	public function get_address() {
		return get_field( 'office_address', $this->id );
	}

	/**
	 * Get office map URL.
	 *
	 * @return string
	 */
	public function get_map_url() {
		return get_field( 'office_map_link', $this->id );
	}
}
