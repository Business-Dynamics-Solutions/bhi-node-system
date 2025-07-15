/**
 * External Dependencies
 */
import { WPEntitySearch } from '@prc/components';

/**
 * WordPress Dependencies
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';

export default function Controls({ nodeId, setAttributes }) {
	return (
		<InspectorControls>
			<PanelBody title={__('Node Context Provider')}>
				<WPEntitySearch
					placeholder="Search for Node"
					searchLabel="Search for Node"
					entityType="postType"
					entitySubType="node"
					onSelect={(entity) => {
						console.log('Node: ', entity);
						setAttributes({
							nodeSlug: entity.slug,
						});
					}}
					onKeyEnter={() => {
						console.log('Enter Key Pressed');
					}}
					onKeyESC={() => {
						console.log('ESC Key Pressed');
					}}
					perPage={5}
					showExcerpt={false}
				/>
			</PanelBody>
		</InspectorControls>
	);
}
