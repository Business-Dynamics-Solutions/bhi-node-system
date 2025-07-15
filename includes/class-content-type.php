<?php
/**
 * Content Type class.
 *
 * @package PRC\Platform\Node_System
 */

namespace PRC\Platform\Node_System;

use WP_Query;

/**
 * Content Type class.
 *
 * @package PRC\Platform\Node_System
 */
class Content_Type {

	/**
	 * The name of the post object.
	 *
	 * @var string
	 */
	public static $post_object_name = 'node';

	/**
	 * The name of the taxonomy object.
	 *
	 * @var string
	 */
	public static $taxonomy_object_name = 'bylines';

	/**
	 * The node post type arguments.
	 *
	 * @var array
	 */
	public static $node_post_type_args = array(
		'labels'             => array(
			'name'               => 'Node',
			'singular_name'      => 'Node',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Node',
			'edit_item'          => 'Edit Node',
			'new_item'           => 'New Node',
			'all_items'          => 'All Node',
			'view_item'          => 'View Node',
			'search_items'       => 'Search node',
			'not_found'          => 'No node found',
			'not_found_in_trash' => 'No node found in Trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Node',
			'featured_image'     => 'Node Photo',
			'set_featured_image' => 'Set Node Photo',
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => false,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-groups',
		'query_var'          => true,
		'rewrite'            => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 70,
		'taxonomies'         => array( 'areas-of-expertise', 'bylines', 'node-type', 'research-teams' ),
		'supports'           => array( 'title', 'editor', 'thumbnail', 'revisions', 'author', 'custom-fields', 'excerpt' ),
	);

	/**
	 * The node type taxonomy arguments.
	 *
	 * @var array
	 */
	public static $node_type_taxonomy_args = array(
		'hierarchical'      => true,
		'labels'            => array(
			'name'                       => 'Node Type',
			'singular_name'              => 'Node Type',
			'search_items'               => 'Search Node Type',
			'popular_items'              => 'Popular Node Type',
			'all_items'                  => 'All Node Type',
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => 'Edit Node Type',
			'update_item'                => 'Update Node Type',
			'add_new_item'               => 'Add New Node Type',
			'new_item_name'              => 'New Node Type Name',
			'separate_items_with_commas' => 'Separate node type with commas',
			'add_or_remove_items'        => 'Add or remove node type',
			'choose_from_most_used'      => 'Choose from the most used node types',
		),
		'show_ui'           => true,
		'query_var'         => false,
		'show_admin_column' => true,
		'show_in_rest'      => true,
	);

	/**
	 * The expertise taxonomy arguments.
	 *
	 * @var array
	 */
	public static $expertise_taxonomy_args = array(
		'hierarchical'      => true,
		'labels'            => array(
			'name'                       => 'Areas of Expertise',
			'singular_name'              => 'Expertise',
			'search_items'               => 'Search Expertise',
			'popular_items'              => 'Popular Expertise',
			'all_items'                  => 'All Expertise',
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => 'Edit Expertise',
			'update_item'                => 'Update Expertise',
			'add_new_item'               => 'Add New Expertise',
			'new_item_name'              => 'New Expertise Name',
			'separate_items_with_commas' => 'Separate expertise with commas',
			'add_or_remove_items'        => 'Add or remove expertise',
			'choose_from_most_used'      => 'Choose from the most used expertises',
		),
		'show_ui'           => true,
		'query_var'         => false,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array(
			'slug'         => 'expertise',
			'with_front'   => false,
			'hierarchical' => true,
		),
	);

	/**
	 * The byline taxonomy arguments.
	 *
	 * @var array
	 */
	public static $byline_taxonomy_args = array(
		'hierarchical'      => false,
		'labels'            => array(
			'name'                       => 'Bylines',
			'singular_name'              => 'Byline',
			'search_items'               => 'Search Bylines',
			'popular_items'              => 'Popular Bylines',
			'all_items'                  => 'All Bylines',
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => 'Edit Byline',
			'update_item'                => 'Update Byline',
			'add_new_item'               => 'Add New Byline',
			'new_item_name'              => 'New Byline Name',
			'separate_items_with_commas' => 'Separate bylines with commas',
			'add_or_remove_items'        => 'Add or remove bylines',
			'choose_from_most_used'      => 'Choose from the most used bylines',
		),
		'show_in_rest'      => true,
		'show_ui'           => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'         => 'node',
			'with_front'   => false,
			'hierarchical' => false,
		),
		'show_admin_column' => true,
	);

	/**
	 * The schema for the field.
	 *
	 * @var array
	 */
	public static $field_schema = array(
		'items' => array(
			'type'       => 'object',
			'properties' => array(
				'key'    => array(
					'type' => 'string',
				),
				'termId' => array(
					'type' => 'integer',
				),
			),
		),
	);

	/**
	 * Constructor.
	 *
	 * @param object $loader The loader object.
	 */
	public function __construct( $loader ) {
		$loader->add_action( 'init', $this, 'init' );
		$loader->add_filter( 'tds_balancing_from_term', $this, 'override_term_data_store_for_guests', 10, 4 );
		$loader->add_filter( 'posts_orderby', $this, 'orderby_last_name', PHP_INT_MAX, 2 );
		$loader->add_filter( 'rest_node_collection_params', $this, 'filter_add_rest_orderby_params', 10, 1 );
		$loader->add_action( 'pre_get_posts', $this, 'hide_former_node', 10, 1 );
		$loader->add_filter( 'the_title', $this, 'indicate_former_node', 10, 1 );
		$loader->add_filter( 'post_link', $this, 'modify_node_permalink', 10, 2 );
                $loader->add_filter( 'prc_sitemap_supported_taxonomies', $this, 'opt_into_sitemap', 10, 1 );

                $loader->add_action( 'add_meta_boxes', $this, 'register_post_fieldsets_meta_box' );
                $loader->add_action( 'save_post', $this, 'save_post_fieldsets_meta' );
        }

	/**
	 * Get the enabled post types.
	 *
	 * @return array The enabled post types.
	 */
	public static function get_enabled_post_types() {
		return apply_filters( 'prc_platform__bylines_enabled_post_types', array( 'post' ) );
		return apply_filters( 'prc_platform__node-type_enabled_post_types', array( 'post' ) );
	}

	/**
	 * Initialize the class with the hybrid post type, associated taxonomies, and meta fields.
	 *
	 * @hook init
	 */
	public function init() {
		$enabled_post_types = self::get_enabled_post_types();

		register_post_type( self::$post_object_name, self::$node_post_type_args );

		register_taxonomy( self::$taxonomy_object_name, $enabled_post_types, self::$byline_taxonomy_args );

		register_taxonomy( 'areas-of-expertise', self::$post_object_name, self::$expertise_taxonomy_args );

		register_taxonomy( 'node-type', array( self::$post_object_name, 'post' ), self::$node_type_taxonomy_args );


		// Link the post object and taxonomy object into one entity.
		\TDS\add_relationship( self::$post_object_name, self::$taxonomy_object_name );

		$this->register_meta_fields( $enabled_post_types );
	}

	/**
	 * Opt into sitemap.
	 *
	 * @hook prc_sitemap_supported_taxonomies
	 *
	 * @param array $taxonomy_types The taxonomy types.
	 * @return array The taxonomy types.
	 */
	public function opt_into_sitemap( $taxonomy_types ) {
		$taxonomy_types[] = self::$taxonomy_object_name;
		return $taxonomy_types;
	}

	/**
	 * Register the meta fields.
	 *
	 * @param array $enabled_post_types The enabled post types.
	 */
	public function register_meta_fields( $enabled_post_types ) {
	
		register_post_meta(
			self::$post_object_name,
			'jobTitle',
			array(
				'description'   => 'This node member\'s job title.',
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => 'string',
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);

		register_post_meta(
			self::$post_object_name,
			'jobTitleExtended',
			array(
				'description'   => 'This node member\'s extended job title, "mini biography"; e.g. ... "is a Senior Researcher focusing on Internet and Technology at the Pew Research Center."',
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => 'string',
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);

		register_post_meta(
			self::$post_object_name,
			'bylineLinkEnabled',
			array(
				'description'   => 'Allow this node member to have a byline link?',
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => 'boolean',
				'default'       => false,
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);

		// === REVEAL FIELDS ===
		$revia_meta_fields = [
			'date_from'       => 'string',
			'date_to'         => 'string',
			'date_string'     => 'string',
			'date_label'      => 'string',
			'geo_lat'         => 'string',
			'geo_long'        => 'string',
			'geo_label'       => 'string',
			'geo_coordinates' => 'string',
		];

		foreach ( $revia_meta_fields as $meta_key => $type ) {
			register_post_meta( 'post', $meta_key, [
				'type'          => $type,
				'single'        => true,
				'show_in_rest'  => true,
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			] );
		}

		register_post_meta( 'post', 'narrative_content', [
			'type'          => 'array',
			'single'        => true,
			'show_in_rest'  => [
				'schema' => [
					'type'  => 'array',
					'items' => [
						'type'       => 'object',
						'properties' => [
							'country' => [ 'type' => 'string' ],
							'content' => [ 'type' => 'string' ],
						],
					],
				],
			],
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		] );






		/**
		 * MAELSTROM
		 * This is a misnomer!!! As this field is publicly accessible we want to obfuscate what this is for. This is the "safety net" for node members, this will allow us to hide node members from certain posts based on that post's region and country taxonomy terms. This is a safety net for node members and their families back home to ensure they are not targeted by bad actors by working on posts that are sensitive to their home country.
		 */
		register_post_meta(
			self::$post_object_name,
			'_maelstrom',
			array(
				'description'   => '',
				'show_in_rest'  => array(
					'schema' => array(
						'properties' => array(
							'enabled'    => array(
								'type'    => 'boolean',
								'default' => false,
							),
							'restricted' => array(
								'type'  => 'array',
								'items' => array(
									'type'    => 'string',
									'default' => array(),
								),
							),
						),
					),
				),
				'single'        => true,
				'type'          => 'object',
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);

		register_post_meta(
			self::$post_object_name,
			'socialProfiles',
			array(
				'description'   => 'Social profiles for this node member.',
				'show_in_rest'  => array(
					'schema' => array(
						'items' => array(
							'type'       => 'object',
							'properties' => array(
								'key' => array(
									'type' => 'string',
								),
								'url' => array(
									'type' => 'string',
								),
							),
						),
					),
				),
				'single'        => true,
				'type'          => 'array',
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);

		// Register bylines, acknowledgements, and displayBylines toggle meta for posts.
		foreach ( $enabled_post_types as $post_type ) {
			register_post_meta(
				$post_type,
				'bylines',
				array(
					'single'        => true,
					'type'          => 'array',
					'show_in_rest'  => array(
						'schema' => self::$field_schema,
					),
					'auth_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);

			register_post_meta(
				$post_type,
				'acknowledgements',
				array(
					'single'        => true,
					'type'          => 'array',
					'show_in_rest'  => array(
						'schema' => self::$field_schema,
					),
					'auth_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);

			/**
			 * This handles whether ALL bylines should display on a given post.
			 */
			register_post_meta(
				$post_type,
				'displayBylines',
				array(
					'show_in_rest'  => true,
					'single'        => true,
					'type'          => 'boolean',
					'default'       => true,
					'auth_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}

	/**
	 * Override the term data store for guests, don't try to update it or manage it in the term data store.
	 *
	 * @hook tds_balancing_from_term
	 *
	 * @param boolean $allow Whether to allow the term data store.
	 * @param string  $taxonomy The taxonomy.
	 * @param string  $post_type The post type.
	 * @param integer $term_id The term ID.
	 * @return boolean
	 */
	public function override_term_data_store_for_guests( $allow, $taxonomy, $post_type, $term_id ) {
		if ( self::$taxonomy_object_name === $taxonomy ) {
			$term_meta = get_term_meta( $term_id, 'is_guest_author', true );
			if ( $term_meta ) {
				return true;
			}
		}
		return $allow;
	}

	/**
	 * Order node posts by last name
	 *
	 * @hook posts_orderby
	 *
	 * @param mixed    $orderby The orderby.
	 * @param WP_Query $query The query.
	 * @return mixed The orderby.
	 */
	public function orderby_last_name( $orderby, WP_Query $query ) {
		$order = $query->get( 'order' );
		global $wpdb;
		if ( 'last_name' === $query->get( 'orderby' ) && $order ) {
			if ( in_array( strtoupper( $order ), array( 'ASC', 'DESC' ) ) ) {
				// Order by last name.
				$orderby = "RIGHT($wpdb->posts.post_title, LOCATE(' ', REVERSE($wpdb->posts.post_title)) - 1) " . 'ASC';
			}
			// If Michael Dimock is present, make sure he is always first.
			$orderby = "CASE WHEN $wpdb->posts.post_title = 'Michael Dimock' THEN 1 ELSE 2 END, $orderby";
		}
		return $orderby;
	}

	/**
	 * Add last_name to the list of permitted orderby values
	 *
	 * @hook rest_node_collection_params
	 *
	 * @param array $params The parameters.
	 * @return array The parameters.
	 */
	public function filter_add_rest_orderby_params( $params ) {
		$params['orderby']['enum'][] = 'last_name';
		return $params;
	}

	/**
	 * Hide former node from the node archive and node taxonomy archive
	 *
	 * @hook pre_get_posts
	 *
	 * @param mixed $query The query.
	 */
	public function hide_former_node( $query ) {
		if ( true === $query->get( 'isPubListingQuery' ) ) {
			return $query;
		}
		if ( $query->is_main_query() && ( is_tax( 'areas-of-expertise' ) || is_tax( 'bylines' ) ) ) {
			$tax_query = $query->get( 'tax_query' );
			if ( ! is_array( $tax_query ) ) {
				$tax_query = array();
			}
			$tax_query[] = array(
				'taxonomy' => 'node-type',
				'field'    => 'slug',
				'terms'    => array( 'node', 'executive-team', 'managing-directors' ),
			);
			$query->set( 'tax_query', $tax_query );
		}
	}

	/**
	 * Modifies the node title to indicate former node.
	 *
	 * @hook the_title
	 *
	 * @param mixed $title The title.
	 * @return mixed The title.
	 */
	public function indicate_former_node( $title ) {
		if ( ! is_admin() ) {
			return $title;
		}

		global $post;
		if ( get_post_type( $post ) !== self::$post_object_name ) {
			return $title;
		}

		$node = new Node( $post->ID );
		if ( true !== $node->is_currently_employed ) {
			$title = 'FORMER: ' . $title;
		}
		return $title;
	}

	/**
	 * Modifies the node permalink to point to the bylines term archive permalink.
	 *
	 * @hook post_link
	 *
	 * @param string  $url The URL.
	 * @param WP_Post $post The post.
	 * @return string The URL.
	 */
	public function modify_node_permalink( $url, $post ) {
		if ( 'publish' !== $post->post_status ) {
			return $url;
		}
		if ( self::$post_object_name === $post->post_type ) {
			$node       = new Node( $post->ID );
			$matched_url = $node->link;
			if ( ! is_wp_error( $matched_url ) ) {
				return $matched_url;
			}
		}
		return $url;
	}
	

	/**
	 * Register meta boxes for 'post' to show grouped fieldsets.
	 */
	public function register_post_fieldsets_meta_box() {
		add_meta_box(
			'prc_post_fieldsets',
			__('Post Fieldsets', 'bhi'),
			[ $this, 'render_post_fieldsets_meta_box' ],
			'post',
			'normal',
			'default'
		);
	}
	
	/**
	 * Render the grouped fieldsets in the meta box UI.
	 */
	public function render_post_fieldsets_meta_box($post) {
		$fields = [
			'Date' => ['date_from', 'date_to', 'date_string', 'date_label'],
			'Geo' => ['geo_lat', 'geo_long', 'geo_label', 'geo_coordinates'],
			'Narrative' => ['narrative_country', 'narrative_content']
		];

		foreach ($fields as $group => $group_fields) {
			echo '<fieldset style="margin-bottom:1.5em;"><legend><strong>' . esc_html($group) . '</strong></legend>';
			foreach ($group_fields as $field) {
				$value = get_post_meta($post->ID, $field, true);
				echo '<p><label for="' . $field . '">' . esc_html($field) . ':</label><br />';
                                if ($field === 'narrative_country') {
                                        echo '<select name="' . $field . '" id="' . $field . '">';
                                        $countries = self::get_country_list();
                                        foreach ( $countries as $code => $info ) {
                                                $flag     = $info['flag'];
                                                $label    = $info['name'];
                                                $selected = selected( $value, $code, false );
                                                echo "<option value='{$code}' {$selected}>{$flag} {$label}</option>";
                                        }
                                        echo '</select>';
				} else {
					echo '<input type="text" name="' . $field . '" id="' . $field . '" value="' . esc_attr($value) . '" style="width:100%;" />';
				}
				echo '</p>';
			}
			echo '</fieldset>';
		}
	}

	/**
	 * Save the custom meta fields.
	 */
        public function save_post_fieldsets_meta($post_id) {
                if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
                if (!current_user_can('edit_post', $post_id)) return;

                $fields = [ 'date_from', 'date_to', 'date_string', 'date_label', 'geo_lat', 'geo_long', 'geo_label', 'geo_coordinates', 'narrative_country', 'narrative_content' ];
                foreach ( $fields as $field ) {
                        if ( isset( $_POST[ $field ] ) ) {
                                update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
                        }
                }
        }

        /**
         * Retrieve a list of countries for the narrative dropdown.
         *
         * @return array
         */
        private static function get_country_list() {
                return [
                        'UA' => [ 'name' => 'Ukraine',       'flag' => '🇺🇦' ],
                        'RU' => [ 'name' => 'Russia',        'flag' => '🇷🇺' ],
                        'DE' => [ 'name' => 'Germany',       'flag' => '🇩🇪' ],
                        'FR' => [ 'name' => 'France',        'flag' => '🇫🇷' ],
                        'NL' => [ 'name' => 'Netherlands',   'flag' => '🇳🇱' ],
                        'US' => [ 'name' => 'United States', 'flag' => '🇺🇸' ],
                        'CN' => [ 'name' => 'China',         'flag' => '🇨🇳' ],
                ];
        }


}
