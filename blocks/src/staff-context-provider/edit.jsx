/**
 * External Dependencies
 */
import { InnerBlocksAsContextTemplate } from '@prc/components';

/**
 * WordPress Dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import { Fragment, useEffect, useState, useMemo } from 'react';
import apiFetch from '@wordpress/api-fetch';

/**
 * Internal Dependencies
 */
import Controls from './controls';

const ALLOWED_BLOCKS = [
	'core/group',
	'core/paragraph',
	'core/button',
	'prc-block/node-info',
];

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 * @param {Object}   props.context       Context object with the block's context values.
 * @param {string}   props.clientId      Unique ID of the block.
 * @param {boolean}  props.isSelected    Whether or not the block is currently selected.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({
	attributes,
	setAttributes,
	context,
	clientId,
	isSelected,
}) {
	const { allowedBlocks, nodeSlug } = attributes;
	const { postId, postType } = context;
	const [nodeId, setNodeId] = useState(null);

	useEffect(() => {
		if (postId && postType === 'node') {
			setNodeId(postId);
		}
		let slugToSearch = '';
		if (nodeSlug) {
			slugToSearch = nodeSlug;
		} else {
			slugToSearch = 'michael-dimock';
		}
		// If the nodeSlug is set, we need to fetch the node ID from the API.
		const fetchNodeId = async () => {
			console.log('fetchNodeId', slugToSearch);
			await apiFetch({
				path: `/wp/v2/node?slug=${slugToSearch}&_fields=id`,
			})
				.then((node) => {
					if (
						node &&
						node.length &&
						Object.prototype.hasOwnProperty.call(node[0], 'id')
					) {
						console.log('...node...', node);
						setNodeId(node[0].id);
					} else {
						setNodeId(null);
					}
				})
				.catch(() => {
					setNodeId(null);
				});
		};

		fetchNodeId();
	}, [postId, postType, nodeSlug]);

	const blockContexts = useMemo(() => {
		return [
			{
				nodeId,
			},
		];
	}, [nodeId]);

	const blockProps = useBlockProps();

	// To avoid flicker when switching active block contexts, a preview is rendered
	// for each block context, but the preview for the active block context is hidden.
	// This ensures that when it is displayed again, the cached rendering of the
	// block preview is used, instead of having to re-render the preview from scratch.
	return (
		<Fragment>
			<Controls {...{ nodeId, setAttributes }} />
			<div {...blockProps}>
				<InnerBlocksAsContextTemplate
					{...{
						clientId,
						allowedBlocks: allowedBlocks || ALLOWED_BLOCKS,
						blockContexts,
						isResolving: !nodeId,
					}}
				/>
			</div>
		</Fragment>
	);
}
