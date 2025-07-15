/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */

/**
 * External Dependencies
 */

/**
 * WordPress Dependencies
 */
import { registerBlockVariation } from '@wordpress/blocks';

/**
 * Internal Dependencies
 */

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor. All other files
 * get applied to the editor only.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */

registerBlockVariation('core/image', {
	name: 'Node Photo',
	title: 'Node Photo Binding',
	attributes: {
		metadata: {
			url: 'https://place-hold.it/200x200/aaa/Profil',
			bindings: {
				url: {
					source: 'prc-platform/node-info',
					args: {
						valueToFetch: 'photo',
					},
				},
				title: {
					source: 'prc-platform/node-info',
					args: {
						valueToFetch: 'photo',
					},
				},
				alt: {
					source: 'prc-platform/node-info',
					args: {
						valueToFetch: 'photo',
					},
				},
			},
		},
	},
});

registerBlockVariation('core/buttons', {
	name: 'Node Download Photo Button',
	title: 'Node Download Photo Button Binding',
	innerBlocks: [
		[
			'core/button',
			{
				url: '#',
				metadata: {
					bindings: {
						text: {
							source: 'prc-platform/node-info',
							args: {
								valueToFetch: 'photo-full-download-text',
							},
						},
						url: {
							source: 'prc-platform/node-info',
							args: {
								valueToFetch: 'photo-full',
							},
						},
					},
				},
			},
		],
	],
});

registerBlockVariation('core/paragraph', {
	name: 'Node Expertise',
	title: 'Node Expertise Binding',
	attributes: {
		content:
			'<span class="wp-block-prc-block-node-context-provider__expertise-label">Expertise:</span> <a class="wp-block-prc-block-node-context-provider__expertise-link" href="#">Expertise</a>, <a class="wp-block-prc-block-node-context-provider__expertise-link" href="#">Expertise</a>',
		metadata: {
			bindings: {
				content: {
					source: 'prc-platform/node-info',
					args: {
						valueToFetch: 'expertise',
					},
				},
			},
		},
	},
});

registerBlockVariation('core/paragraph', {
	name: 'Node Bio',
	title: 'Node Bio Binding',
	attributes: {
		content:
			'Adipisicing fugiat veniam sunt tempor est anim laboris reprehenderit esse labore ut ea. Reprehenderit excepteur pariatur eu fugiat eu. Ipsum aliquip voluptate fugiat magna labore Lorem ex nulla nisi labore sit. Est reprehenderit aute anim qui commodo quis incididunt. Esse eu Lorem enim duis elit laboris pariatur esse pariatur adipisicing reprehenderit in non. Consectetur eu deserunt adipisicing in est fugiat pariatur voluptate eiusmod magna incididunt.',
		metadata: {
			bindings: {
				content: {
					source: 'prc-platform/node-info',
					args: {
						valueToFetch: 'bio',
					},
				},
			},
		},
	},
});

registerBlockVariation('core/paragraph', {
	name: 'Node Mini Bio',
	title: 'Node Mini Bio Binding',
	attributes: {
		content:
			'<p><a href="#">Commodo Duis</a> is a research analyst focusing on social and demographic research at Pew Research Center.</p>',
		metadata: {
			bindings: {
				content: {
					source: 'prc-platform/node-info',
					args: {
						valueToFetch: 'mini_bio',
					},
				},
			},
		},
	},
});

registerBlockVariation('core/paragraph', {
	name: 'Node Job Title',
	title: 'Node Job Title Binding',
	attributes: {
		content: 'Research Associate',
		metadata: {
			bindings: {
				content: {
					source: 'prc-platform/node-info',
					args: {
						valueToFetch: 'job_title',
					},
				},
			},
		},
	},
});

registerBlockVariation('core/paragraph', {
	name: 'Node Job Title Extended',
	title: 'Node Job Title Extended Binding',
	attributes: {
		content:
			'a research analyst focusing on social and demographic research at Pew Research Center',
		metadata: {
			bindings: {
				content: {
					source: 'prc-platform/node-info',
					args: {
						valueToFetch: 'job_title_extended',
					},
				},
			},
		},
	},
});

registerBlockVariation('core/paragraph', {
	name: 'Node Name and Job Title Full with Link',
	title: 'Node Name and Job Title Full with Link Binding',
	attributes: {
		content: '<a href="#">Jane Doe</a>, Senior Researcher, Research Team',
		metadata: {
			bindings: {
				content: {
					source: 'prc-platform/node-info',
					args: {
						valueToFetch: 'name_and_job_title',
					},
				},
			},
		},
	},
});

registerBlockVariation('core/heading', {
	name: 'Node Name (Heading)',
	title: 'Node Name Binding (Heading)',
	attributes: {
		level: 3,
		content: 'Commodo Duis',
		metadata: {
			bindings: {
				content: {
					source: 'prc-platform/node-info',
					args: {
						valueToFetch: 'name',
					},
				},
			},
		},
	},
});

registerBlockVariation('core/paragraph', {
	name: 'Node Name',
	title: 'Node Name Binding (Paragaph)',
	attributes: {
		content: 'Commodo Duis',
		metadata: {
			bindings: {
				content: {
					source: 'prc-platform/node-info',
					args: {
						valueToFetch: 'name',
					},
				},
			},
		},
	},
});

registerBlockVariation('core/paragraph', {
	name: 'Node Name Link',
	title: 'Node Name Binding (Paragaph/Link)',
	attributes: {
		content: '<a href="#">Commodo Duis</a>',
		metadata: {
			bindings: {
				content: {
					source: 'prc-platform/node-info',
					args: {
						valueToFetch: 'name',
						outputLink: true,
					},
				},
			},
		},
	},
});
