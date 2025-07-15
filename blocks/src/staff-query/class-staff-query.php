<?php
/**
 * Node Query Block
 *
 * @package PRC\Platform\Node_System
 */

namespace PRC\Platform\Node_System;

use WP_Query;
use WP_Block;
use WP_Error;

/**
 * Block Name:        Node Query
 * Description:       Query the Node by Node Type and Research Area.
 * Requires at least: 6.4
 * Requires PHP:      8.l1
 * Author:            Seth Rubenstein
 *
 * @package           prc-node-bylines
 */
class Node_Query {
	/**
	 * Constructor
	 *
	 * @param mixed $loader Loader.
	 */
	public function __construct( $loader ) {
		$this->init( $loader );
	}

	/**
	 * Initialize the block
	 *
	 * @hook init
	 *
	 * @param mixed $loader Loader.
	 */
	public function init( $loader = null ) {
		if ( null !== $loader ) {
			$loader->add_action( 'init', $this, 'block_init' );
		}
	}

	/**
	 * Get expertise
	 *
	 * @param mixed $post_id Post ID.
	 * @return array
	 */
	public function get_expertise( $post_id ) {
		$terms     = get_the_terms( $post_id, 'areas-of-expertise' );
		$expertise = array();
		if ( $terms ) {
			foreach ( $terms as $term ) {
				// if $term is wp error and or is not a term object then skip it.
				if ( is_wp_error( $term ) || ! is_object( $term ) ) {
					continue;
				}
				$link        = get_term_link( $term, 'areas-of-expertise' );
				$expertise[] = array(
					'url'   => $link,
					'label' => $term->name,
					'slug'  => $term->slug,
				);
			}
		}
		return $expertise;
	}

	/**
	 * Query node posts
	 *
	 * @param array $attributes Attributes.
	 * @return array
	 */
	public function query_node_posts( $attributes = array() ) {
		$node_type    = array_key_exists( 'nodeType', $attributes ) ? $attributes['nodeType'] : false;
		$research_area = array_key_exists( 'researchArea', $attributes ) ? $attributes['researchArea'] : false;
		$tax_query     = array();
		if ( $node_type ) {
			$node_type  = $node_type['slug'];
			$tax_query[] = array(
				'taxonomy' => 'node-type',
				'field'    => 'slug',
				'terms'    => $node_type,
			);
		}
		if ( $research_area ) {
			$research_area = $research_area['slug'];
			$tax_query[]   = array(
				'taxonomy' => 'research-teams',
				'field'    => 'slug',
				'terms'    => $research_area,
			);
		}
		if ( count( $tax_query ) > 1 ) {
			$tax_query['relation'] = 'AND';
		}

		$query_args = array(
			'post_type'      => 'node',
			'posts_per_page' => 200,
			'orderby'        => 'last_name',
			'order'          => 'ASC',
		);
		if ( count( $tax_query ) > 0 ) {
			$query_args['tax_query'] = $tax_query;
		}

		$node_posts = array();

		switch_to_blog( 20 );

		$node_query = new WP_Query( $query_args );

		if ( $node_query->have_posts() ) {
			while ( $node_query->have_posts() ) {
				$node_query->the_post();
				$node = new Node( get_the_ID(), false );
				if ( is_wp_error( $node ) ) {
					continue;
				}
				if ( ! $node->is_currently_employed ) {
					continue;
				}

				$node_posts[] = array(
					'nodeId' => $node->ID,
				);
			}
		}

		wp_reset_postdata();

		restore_current_blog();

		return $node_posts;
	}
	/**
	 * Render block callback
	 *
	 * @param array    $attributes Attributes.
	 * @param string   $content Content.
	 * @param WP_Block $block Block.
	 * @return string
	 */
	public function render_block_callback( $attributes, $content, $block ) {
		$node_posts = $this->query_node_posts( $attributes );

		$block_content = '';

		if ( empty( $node_posts ) ) {
			$block_content = '<p>No node found.</p>';
		}

		$block_attrs = get_block_wrapper_attributes();

		$block_instance = $block->parsed_block;

		// Set the block name to one that does not correspond to an existing registered block.
		// This ensures that for the inner instances of the Node Query block, we do not render any block supports.
		$block_instance['blockName'] = 'core/null';

		foreach ( $node_posts as $node_post_context ) {
			// Render the inner blocks of the Node Query block with `dynamic` set to `false` to prevent calling
			// `render_callback` and ensure that no wrapper markup is included.
			$block_content .= (
				new WP_Block(
					$block_instance,
					$node_post_context
				)
			)->render( array( 'dynamic' => false ) );
		}

		return wp_sprintf(
			'<div %1$s>%2$s</div>',
			$block_attrs, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$block_content // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}

	/**
	 * Registers the block using the metadata loaded from the `block.json` file.
	 * Behind the scenes, it registers also all assets so they can be enqueued
	 * through the block editor in the corresponding context.
	 *
	 * @hook init
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	public function block_init() {
		register_block_type_from_metadata(
			PRC_NODE_SYSTEM_BLOCKS_DIR . '/build/node-query',
			array(
				'render_callback' => array( $this, 'render_block_callback' ),
			)
		);
	}
}
