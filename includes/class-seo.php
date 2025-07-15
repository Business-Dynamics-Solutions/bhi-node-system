<?php
/**
 * SEO class.
 *
 * @package PRC\Platform\Node_System
 */

namespace PRC\Platform\Node_System;

/**
 * SEO class.
 *
 * @package PRC\Platform\Node_System
 */
class SEO {
	/**
	 * Constructor.
	 *
	 * @param Loader $loader The loader.
	 */
	public function __construct( $loader ) {
		$loader->add_filter( 'wp_robots', $this, 'modify_node_robots', 10, 1 );
		$loader->add_filter( 'wpseo_enhanced_slack_data', $this, 'generate_yoast_slack_data', 10, 2 );
		$loader->add_filter( 'wpseo_meta_author', $this, 'generate_yoast_author_data', 10, 2 );
		$loader->add_filter( 'wpseo_opengraph_author_facebook', $this, 'generate_yoast_author_data', 10, 2 );
	}

	/**
	 * Modify the robots meta for the node post.
	 *
	 * @hook wp_robots
	 * @param array $robots_directives The robots directives.
	 * @return array The robots directives.
	 */
	public function modify_node_robots( $robots_directives ) {
		// Check if the current node post has byline link enabled, if not then we should add noindex to the robots meta.
		if ( is_tax( Content_Type::$taxonomy_object_name ) ) {
			// Check if the current node post has byline link enabled, if not then we should add noindex to the robots meta.
			$node = new Node( false, get_queried_object()->term_id );
			if ( is_wp_error( $node ) ) {
				return $robots_directives;
			}
			if ( $node->link ) {
				return $robots_directives;
			}
			// If a node member has no link, then we should disallow all robots.
			$robots_directives['noindex']  = true;
			$robots_directives['nofollow'] = true;
		}
		return $robots_directives;
	}

	/**
	 * Generate Yoast author data.
	 *
	 * @hook wpseo_meta_author
	 * @param array                  $data         The data.
	 * @param Indexable_Presentation $presentation The presentation.
	 *
	 * @return array The data.
	 */
	public function generate_yoast_author_data( $data, $presentation ) {
		$post_id = $presentation->model->object_id;
		$bylines = new Bylines( $post_id );
		if ( is_wp_error( $bylines->bylines ) ) {
			return $data; // Exit early and with no output if there are no bylines.
		}

		$bylines = $bylines->format( 'string' );

		if ( ! empty( $bylines ) ) {
			$data = $bylines;
		}

		return $data;
	}

	/**
	 * Change Enhanced Slack sharing data labels.
	 *
	 * @hook wpseo_enhanced_slack_data
	 * @param array                  $data         The Slack labels + data.
	 * @param Indexable_Presentation $presentation The indexable presentation object.
	 *
	 * @return array The Slack labels + data.
	 */
	public function generate_yoast_slack_data( array $data, $presentation ) {
		$post_id = $presentation->model->object_id;
		$bylines = new Bylines( $post_id );
		if ( is_wp_error( $bylines->bylines ) ) {
			return $data; // Exit early and with no output if there are no bylines.
		}

		$bylines = $bylines->format( 'string' );

		if ( ! empty( $bylines ) ) {
			$data[ __( 'Written by', 'wordpress-seo' ) ] = $bylines;
		}

		return $data;
	}
}
