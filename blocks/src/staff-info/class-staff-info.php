<?php
/**
 * Node Info Block
 *
 * @package PRC\Platform\Node_System
 */

namespace PRC\Platform\Node_System;

/**
 * Block Name:        Node Info
 * Description:       Display node info from a byline; supports name, job title, twitter, and expertise.
 * Version:           0.1.0
 * Requires at least: 6.1
 * Requires PHP:      8.1
 * Author:            Seth Rubenstein
 *
 * @package           prc-node-bylines
 */
class Node_Info {
	/**
	 * Block JSON
	 *
	 * @var array
	 */
	public $block_json;

	/**
	 * Editor script handle
	 *
	 * @var string
	 */
	public $editor_script_handle;

	/**
	 * Block bound node
	 *
	 * @var bool
	 */
	public $block_bound_node = false;

	/**
	 * Constructor
	 *
	 * @param mixed $loader Loader.
	 */
	public function __construct( $loader ) {
		$this->block_json = Blocks::get_block_json( 'node-info' );
		$this->init( $loader );
	}

	/**
	 * Initialize the block
	 *
	 * @param mixed $loader Loader.
	 */
	public function init( $loader = null ) {
		if ( null !== $loader ) {
			$loader->add_action( 'init', $this, 'block_init' );
			$loader->add_action( 'init', $this, 'register_assets' );
			$loader->add_action( 'enqueue_block_editor_assets', $this, 'register_editor_script' );
		}
	}

	/**
	 * Register assets
	 *
	 * @hook init
	 * @return void
	 */
	public function register_assets() {
		$this->editor_script_handle = register_block_script_handle( $this->block_json, 'editorScript' );
	}

	/**
	 * Register editor script
	 *
	 * @hook enqueue_block_editor_assets
	 * @return void
	 */
	public function register_editor_script() {
		wp_enqueue_script( $this->editor_script_handle );
	}

	/**
	 * Get node info for block binding
	 *
	 * @param mixed $source_args Source args.
	 * @param mixed $block Block.
	 * @param mixed $attribute_name Attribute name.
	 * @return mixed
	 */
	public function get_node_info_for_block_binding( $source_args, $block, $attribute_name ) {
		$block_context = $block->context;
		$node_post_id = array_key_exists( 'nodeId', $block_context ) ? $block_context['nodeId'] : false;
		if ( false === $node_post_id ) {
			return null;
		}
		// First instance lets set the $this->block_bound_node to the node object so its available for later blocks.
		if ( false === $this->block_bound_node || $this->block_bound_node['ID'] !== $node_post_id ) {
			$node                   = new Node( $node_post_id );
			$this->block_bound_node = get_object_vars( $node );
		}

		$block_name       = $block->name;
		$value_to_replace = null;
		if ( in_array( $block_name, array( 'core/image', 'core/paragraph', 'core/heading', 'core/button' ) ) ) {
			$value_to_fetch = array_key_exists( 'valueToFetch', $source_args ) ? $source_args['valueToFetch'] : null;
			if ( null === $value_to_fetch ) {
				return null;
			}
			$output_link = array_key_exists( 'outputLink', $source_args );

			if ( 'photo-full' === $value_to_fetch && isset( $this->block_bound_node['photo']['full'][0] ) ) {
				// If there is no photo we need to bail...
				if ( 'url' === $attribute_name ) {
					$value_to_replace = $this->block_bound_node['photo']['full'][0];
				}
			}
			if ( 'photo-full-download-text' === $value_to_fetch ) {
				if ( ! empty( $this->block_bound_node['photo'] ) ) {
					// If there is no photo we need to bail...
					if ( 'text' === $attribute_name ) {
						$value_to_replace = wp_sprintf(
							'Download %1$s\'s photo',
							$this->block_bound_node['name']
						);
					}
				} elseif ( 'text' === $attribute_name ) {
						$value_to_replace = null;
				}
			}

			if ( 'photo' === $value_to_fetch && isset( $this->block_bound_node['photo']['thumbnail'][0] ) ) {
				// If there is no photo we need to bail...
				if ( 'url' === $attribute_name ) {
					$value_to_replace = $this->block_bound_node['photo']['thumbnail'][0];
				}
				if ( 'title' === $attribute_name ) {
					$value_to_replace = wp_sprintf(
						'Photo of %1$s',
						$this->block_bound_node['name']
					);
				}
				if ( 'alt' === $attribute_name ) {
					$value_to_replace = wp_sprintf(
						'Download %1$s\'s photo',
						$this->block_bound_node['name']
					);
				}
			}
			if ( 'bio' === $value_to_fetch && isset( $this->block_bound_node['bio'] ) && ! empty( $this->block_bound_node['bio'] ) ) {
				$value_to_replace = $this->block_bound_node['bio'];
			}
			// If we are looking for the bio and its not set, set as the mini_bio.
			if ( 'bio' === $value_to_fetch && empty( $this->block_bound_node['bio'] ) ) {
				$value_to_replace = $this->block_bound_node['mini_bio'];
			}
			if ( 'mini_bio' === $value_to_fetch && isset( $this->block_bound_node['mini_bio'] ) ) {
				$value_to_replace = $this->block_bound_node['mini_bio'];
			}
			if ( 'name' === $value_to_fetch && isset( $this->block_bound_node['name'] ) ) {
				$value_to_replace = $this->block_bound_node['name'];
			}
			if ( 'job_title' === $value_to_fetch && isset( $this->block_bound_node['job_title'] ) ) {
				$value_to_replace = $this->block_bound_node['job_title'];
			}
			if ( 'job_title_extended' === $value_to_fetch && isset( $this->block_bound_node['job_title_extended'] ) ) {
				$value_to_replace = $this->block_bound_node['job_title'];
			}
			if ( true === $output_link && isset( $this->block_bound_node['link'] ) && false !== $this->block_bound_node['link'] ) {
				$value_to_replace = wp_sprintf(
					'<a href="%1$s">%2$s</a>',
					$this->block_bound_node['link'],
					$value_to_replace
				);
			}
			if ( 'expertise' === $value_to_fetch && ! empty( $this->block_bound_node['expertise'] ) ) {
				$expertise = $this->block_bound_node['expertise'];
				$tmp       = '<span class="wp-block-prc-block-node-context-provider__expertise-label">Expertise:</span>';
				$total     = count( $expertise );
				$sep       = $total > 1 ? ', ' : '';
				$i         = 1;
				foreach ( $expertise as $term ) {
					if ( $i === $total ) {
						$sep = '';
					}
					$tmp .= wp_sprintf(
						'<a class="wp-block-prc-block-node-context-provider__expertise-link" href="%1$s">%2$s</a>%3$s',
						$term['url'],
						$term['label'],
						$sep
					);
					++$i;
				}
				$value_to_replace = $tmp;
			}
			if ( 'expertise' === $value_to_fetch && empty( $this->block_bound_node['expertise'] ) ) {
				$value_to_replace = '';
			}
			if ( 'name_and_job_title' === $value_to_fetch && ! empty( $this->block_bound_node['name'] ) && ! empty( $this->block_bound_node['job_title'] ) ) {
				$name      = $this->block_bound_node['name'];
				$job_title = $this->block_bound_node['job_title'];
				$link      = $this->block_bound_node['link'];
				if ( empty( $link ) ) {
					$value_to_replace = wp_sprintf(
						'<strong>%1$s</strong>, %2$s',
						$name,
						$job_title
					);
				} else {
					$value_to_replace = wp_sprintf(
						'<strong><a href="%2$s">%1$s</a></strong>, %3$s',
						$name,
						$link,
						$job_title
					);
				}
			}
		}
		return $value_to_replace;
	}

	/**
	 * Registers the block using the metadata loaded from the `block.json` file.
	 * Behind the scenes, it registers also all assets so they can be enqueued
	 * through the block editor in the corresponding context.
	 *
	 * @hook init
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	public function block_init() {
		register_block_bindings_source(
			'prc-platform/node-info',
			array(
				'label'              => __( 'Node Info API', 'prc-platform/node-info' ),
				'get_value_callback' => array( $this, 'get_node_info_for_block_binding' ),
				'uses_context'       => array( 'nodeId' ),
			)
		);
	}
}
