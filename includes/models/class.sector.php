<?php
/**
 * Sector model
 *
 * @package Milos
 * @subpackage Chriss
 */

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

/**
 * Sector model
 */
final class Sector {

	/**
	 * Post ID.
	 *
	 * @var int
	 */
	private $id;

	/**
	 * Get instance of Sector class.
	 *
	 * @param  int $id post ID of an sector.
	 * @return Sector
	 */
	public static function get_instance( $id ) {
		return new Sector( $id );
	}

	/**
	 * Sector constructor.
	 *
	 * @param  int $id post ID of an sector.
	 * @return void
	 */
	public function __construct( $id ) {
		$this->id = $id;
	}

	/**
	 * Get ID of the sector
	 *
	 * @return int
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Get URL of the sector
	 *
	 * @return string
	 */
	public function get_url() {
		return $this->is_external_url() ? $this->get_external_url() : $this->get_permalink();
	}

	/**
	 * Get permalink of the sector
	 *
	 * @return string
	 */
	public function get_permalink() {
		return get_permalink( $this->id );
	}

	/**
	 * Get external URL of the sector
	 *
	 * @return string
	 */
	public function get_external_url() {
		return get_field( 'sector_external_url', $this->id );
	}

	/**
	 * Get sector name.
	 *
	 * @return string
	 */
	public function get_name() {
		return get_the_title( $this->id );
	}

	/**
	 * Does sector have external URL?
	 *
	 * @return boolean
	 */
	public function is_external_url() {
		return get_field( 'sector_is_external_url', $this->id );
	}

	/**
	 * Get icon SVG for embedding into html.
	 *
	 * @return string
	 */
	public function get_icon_svg() {
		$image_id = get_field( 'sector_icon', $this->id );

		return $image_id ? file_get_contents( get_attached_file( $image_id ) ) : '';
	}

	/**
	 * Get teaser text.
	 *
	 * @return string
	 */
	public function get_teaser_text() {
		return get_field( 'sector_teaser_text', $this->id );
	}

	/**
	 * Is external URL leading to it34.com
	 *
	 * @return boolean
	 */
	public function is_it34_url() {
		return 0 === strpos( strtolower( $this->get_external_url() ), 'https://it34.com' );
	}
}
