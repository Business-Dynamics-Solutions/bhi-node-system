/**
 * WordPress Dependencies
 */
import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import { useSelect } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import { CardDivider, ToggleControl, TextControl } from '@wordpress/components';
import { PluginDocumentSettingPanel } from '@wordpress/editor';

export default function NodeInfoPanel() {
	const { postType, postId } = useSelect(
		(select) => ({
			postType: select('core/editor').getCurrentPostType(),
			postId: select('core/editor').getCurrentPostId(),
		}),
		[]
	);

	const [meta, setMeta] = useEntityProp('postType', postType, 'meta', postId);
	const { jobTitle, jobTitleExtended, socialProfiles, bylineLinkEnabled } =
		meta;

	return (
		<PluginDocumentSettingPanel
			name="prc-node-info"
			title="Node Information"
		>
			<ToggleControl
				label={__('Display Byline Link')}
				help={__(
					'All node are assigned a byline tem, however not all node have a link to a byline archive "node bio" page. If this node member has a bio page, enable this option to link their byline to their bio page.'
				)}
				checked={bylineLinkEnabled}
				onChange={() => {
					setMeta({
						...meta,
						bylineLinkEnabled: !bylineLinkEnabled,
					});
				}}
			/>
			<CardDivider />
			<TextControl
				label={__('Job Title')}
				value={jobTitle}
				onChange={(value) => {
					setMeta({ ...meta, jobTitle: value });
				}}
				placeholder="Research Assistant"
			/>
			<TextControl
				label={__('Job Title Extended')}
				help={__(
					'This extended job title appears under Short Read posts.'
				)}
				value={jobTitleExtended}
				onChange={(value) => {
					setMeta({
						...meta,
						jobTitleExtended: value,
					});
				}}
				placeholder="is a Research Assistant at Pew Research Center."
			/>
		</PluginDocumentSettingPanel>
	);
}
