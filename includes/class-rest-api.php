<?php
/**
 * REST API class.
 *
 * @package PRC\Platform\Node_System
 */

namespace PRC\Platform\Node_System;

/**
 * REST API class.
 */
class REST_API {

	/**
	 * Constructor.
	 *
	 * @param Loader $loader The loader.
	 */
	public function __construct( $loader ) {
		$loader->add_action( 'rest_api_init', $this, 'add_node_info_term' );
	}

	/**
	 * Add constructed node info to the byline term object and node post object in the rest api.
	 *
	 * @hook rest_api_init
	 * @return void
	 */
	public function add_node_info_term() {
		register_rest_field(
			Content_Type::$taxonomy_object_name,
			'nodeInfo',
			array(
				'get_callback' => array( $this, 'get_node_info_for_byline_term' ),
			)
		);
		// Currently this is only used on the mini node block.
		register_rest_field(
			Content_Type::$post_object_name,
			'nodeInfo',
			array(
				'get_callback' => array( $this, 'get_node_info_for_node_post' ),
			)
		);
	}

	/**
	 * Get node info for the byline term.
	 *
	 * @param mixed $object The object.
	 * @return array The node info.
	 */
	public function get_node_info_for_byline_term( $object ) {
		return $this->get_node_info_for_api( $object, Content_Type::$taxonomy_object_name );
	}

	/**
	 * Get node info for the node post.
	 *
	 * @param mixed $object The object.
	 * @return array The node info.
	 */
	public function get_node_info_for_node_post( $object ) {
		return $this->get_node_info_for_api( $object, Content_Type::$post_object_name );
	}

	/**
	 * Get node info for the rest api.
	 *
	 * @param mixed  $object The object.
	 * @param string $type The type.
	 * @return array The node info.
	 */
	private function get_node_info_for_api( $object, $type ) {
		$byline_term_id = false;
		$node_post_id  = false;
		if ( $type && Content_Type::$post_object_name === $type ) {
			$node_post_id = $object['id'];
		} else {
			$byline_term_id = $object['id'];
		}

		$node = new Node( $node_post_id, $byline_term_id );
		if ( is_wp_error( $node ) ) {
			return $object;
		}
		$node_data = get_object_vars( $node );

		$node_link         = $node_data['link'];
		$node_name_as_link = wp_sprintf(
			'<a href="%1$s">%2$s</a>&nbsp;',
			$node_link,
			$node_data['name']
		);

		$data = array(
			'nodeName'             => $node_data['name'],
			'nodeJobTitle'         => $node_data['job_title'],
			'nodeImage'            => $node_data['photo'],
			'nodeTwitter'          => null,
			'nodeExpertise'        => $node_data['expertise'],
			'nodeBio'              => $node_data['bio'],
			'nodeBioShort'         => $node_name_as_link . ' is ' . $node_data['job_title_extended'],
			'nodeJobTitleExtended' => $node_data['job_title_extended'],
			'nodeLink'             => $node_data['link'],
		);

		return $data;
	}
}
