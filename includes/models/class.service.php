<?php
/**
 * Service model
 *
 * @package Milos
 * @subpackage Chriss
 */

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

/**
 * Service model
 */
final class Service {

	/**
	 * ACF data.
	 *
	 * @var mixed[]
	 */
	private $data;

	/**
	 * Get instance of Service class.
	 *
	 * @param  int $data ACF data.
	 * @return Service
	 */
	public static function get_instance( $data ) {
		return new Service( $data );
	}

	/**
	 * Service constructor.
	 *
	 * @param  int $data ACF data.
	 * @return void
	 */
	public function __construct( $data ) {
		$this->data = $data;
	}

	/**
	 * Get URL of the service
	 *
	 * @return string
	 */
	public function get_url() {
		return $this->is_external_url() ? $this->get_external_url() : $this->get_permalink();
	}

	/**
	 * Get permalink of the service
	 *
	 * @return string
	 */
	public function get_permalink() {
		return get_permalink( $this->data['post'] );
	}

	/**
	 * Get external URL of the service
	 *
	 * @return string
	 */
	public function get_external_url() {
		return $this->data['external_url'];
	}

	/**
	 * Get service name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'internal' === $this->data['link_type'] && empty( $this->data['title'] ) ? get_the_title( $this->data['post'] ) : $this->data['title'];
	}

	/**
	 * Does service have external URL?
	 *
	 * @return boolean
	 */
	public function is_external_url() {
		return 'external' === $this->data['link_type'];
	}

	/**
	 * Is external URL leading to it34.com
	 *
	 * @return boolean
	 */
	public function is_it34_url() {
		return 'external' === $this->data['link_type'] && 0 === strpos( strtolower( $this->data['external_url'] ), 'https://it34.com' );
	}

	/**
	 * Does service have URL?
	 *
	 * @return boolean
	 */
	public function has_url() {
		return 'none' !== $this->data['link_type'];
	}
}
