<?php
// This file is generated. Do not modify it manually.
return array(
	'bylines-display' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'prc-block/bylines-display',
		'version' => '1.0.0',
		'title' => 'Bylines Display',
		'category' => 'theme',
		'description' => 'Display a post\'s bylines in the format: {prefix \'By\'} 1, 2, and 3.',
		'attributes' => array(
			'prefix' => array(
				'type' => 'string',
				'default' => 'By'
			)
		),
		'supports' => array(
			'anchor' => true,
			'html' => false,
			'color' => array(
				'text' => true,
				'background' => true,
				'link' => true
			),
			'spacing' => array(
				'margin' => array(
					'top',
					'bottom'
				),
				'padding' => true
			),
			'layout' => array(
				'allowEditing' => true,
				'allowJustification' => true,
				'allowInheriting' => false,
				'allowOrientation' => true,
				'allowSizingOnChildren' => true,
				'allowSwitching' => false,
				'allowVerticalAlignment' => false,
				'default' => array(
					'type' => 'flex',
					'justifyContent' => 'left',
					'orientation' => 'horizontal'
				)
			),
			'typography' => array(
				'fontSize' => true,
				'fontAppearance' => true,
				'lineHeight' => true,
				'__experimentalFontStyle' => false,
				'__experimentalFontFamily' => true,
				'__experimentalFontWeight' => true,
				'__experimentalLetterSpacing' => true,
				'__experimentalTextTransform' => true,
				'__experimentalDefaultControls' => array(
					'fontSize' => true,
					'__experimentalLetterSpacing' => true,
					'__experimentalTextTransform' => true,
					'__experimentalFontFamily' => true
				)
			)
		),
		'example' => array(
			'attributes' => array(
				'textAlign' => 'left',
				'prefix' => 'By'
			),
			'viewportWidth' => 400
		),
		'usesContext' => array(
			'postId'
		),
		'textdomain' => 'bylines-display',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'bylines-query' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'prc-block/bylines-query',
		'version' => '1.0.0',
		'title' => 'Bylines Query',
		'category' => 'theme',
		'description' => 'Query the current post for bylines.',
		'usesContext' => array(
			'queryId',
			'postId',
			'postType'
		),
		'attributes' => array(
			'allowedBlocks' => array(
				'type' => 'array'
			),
			'style' => array(
				'type' => 'object',
				'default' => array(
					'spacing' => array(
						'blockGap' => 'var:preset|spacing|20'
					)
				)
			)
		),
		'supports' => array(
			'anchor' => true,
			'html' => false,
			'spacing' => array(
				'blockGap' => true,
				'margin' => array(
					'top',
					'bottom'
				),
				'padding' => true
			),
			'layout' => array(
				'allowEditing' => true,
				'allowJustification' => true,
				'allowInheriting' => false,
				'allowOrientation' => true,
				'allowSizingOnChildren' => true,
				'allowSwitching' => false,
				'allowVerticalAlignment' => true,
				'default' => array(
					'type' => 'flex',
					'justifyContent' => 'left',
					'orientation' => 'vertical'
				)
			),
			'typography' => array(
				'fontSize' => true,
				'fontAppearance' => true,
				'__experimentalFontStyle' => false,
				'__experimentalFontFamily' => true,
				'__experimentalFontWeight' => true,
				'__experimentalLetterSpacing' => true,
				'__experimentalTextTransform' => true
			)
		),
		'textdomain' => 'bylines-query',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css'
	),
	'node-context-provider' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'prc-block/node-context-provider',
		'version' => '0.1.0',
		'title' => 'Node Context Provider',
		'category' => 'widgets',
		'description' => 'Provides information about a Node member via termId and passes that information via block context to its innerblocks.',
		'attributes' => array(
			'allowedBlocks' => array(
				'type' => 'array'
			),
			'orientation' => array(
				'type' => 'string',
				'default' => 'vertical'
			),
			'nodeSlug' => array(
				'type' => 'string'
			)
		),
		'supports' => array(
			'anchor' => true,
			'html' => false,
			'interactivity' => true
		),
		'usesContext' => array(
			'postId',
			'postType'
		),
		'textdomain' => 'node-context-provider',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css'
	),
	'node-info' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'prc-block/node-info',
		'version' => '0.1.0',
		'title' => 'Node Info',
		'editorScript' => 'file:./index.js'
	),
	'node-query' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'prc-block/node-query',
		'version' => '1.0.0',
		'title' => 'Node Query',
		'category' => 'theme',
		'description' => 'Query the Node by Node Type and Research Area.',
		'attributes' => array(
			'allowedBlocks' => array(
				'type' => 'array'
			),
			'nodeType' => array(
				'type' => 'object'
			),
			'researchArea' => array(
				'type' => 'object'
			),
			'style' => array(
				'type' => 'object',
				'default' => array(
					'spacing' => array(
						'blockGap' => 'var:preset|spacing|20'
					)
				)
			)
		),
		'supports' => array(
			'anchor' => true,
			'html' => false,
			'spacing' => array(
				'blockGap' => true,
				'margin' => array(
					'top',
					'bottom'
				),
				'padding' => true
			),
			'typography' => array(
				'fontSize' => true,
				'__experimentalFontFamily' => true
			)
		),
		'textdomain' => 'node-query',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css'
	)
);
