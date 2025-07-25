/* eslint-disable indent */
/**
 * External Dependencies
 */
import { TermSelect } from '@prc/components';
import styled from '@emotion/styled';

/**
 * WordPress Dependencies
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import {
	__experimentalToolsPanel as ToolsPanel,
	__experimentalToolsPanelItem as ToolsPanelItem,
} from '@wordpress/components';
import { has } from 'lodash';

const PanelDescription = styled.div`
	grid-column: span 2;
`;

export default function Controls({ attributes, setAttributes, clientId }) {
	const { nodeType, researchArea } = attributes;
	const resetAll = () => {
		setAttributes({
			nodeType: null,
			researchArea: null,
		});
	};
	return (
		<InspectorControls>
			<ToolsPanel
				label={__('Node Query Filters')}
				resetAll={() => {
					resetAll();
				}}
				panelId={clientId}
			>
				<PanelDescription>
					{__(
						'Use the filters below to filter node members by node type or research area.'
					)}
				</PanelDescription>
				<ToolsPanelItem
					label={__('Filter by Node Type')}
					hasValue={() => nodeType !== undefined}
					onDeselect={() => setAttributes({ nodeType: null })}
					resetAllFilter={() => resetAll()}
					panelId={clientId}
				>
					<TermSelect
						maxTerms={1}
						value={
							has(nodeType, 'name')
								? [
										{
											value: nodeType.name,
											title: nodeType.name,
										},
								  ]
								: []
						}
						taxonomy="node-type"
						onChange={(term) => {
							setAttributes({ nodeType: term });
						}}
					/>
				</ToolsPanelItem>
				<ToolsPanelItem
					label={__('Filter by Research Area')}
					hasValue={() => researchArea !== undefined}
					onDeselect={() => setAttributes({ researchArea: null })}
					resetAllFilter={() => resetAll()}
					panelId={clientId}
				>
					<TermSelect
						maxTerms={1}
						value={
							has(researchArea, 'name')
								? [
										{
											value: researchArea.name,
											title: researchArea.name,
										},
								  ]
								: []
						}
						taxonomy="research-teams"
						usePrimaryRestAPI
						onChange={(term) => {
							setAttributes({ researchArea: term });
						}}
					/>
				</ToolsPanelItem>
			</ToolsPanel>
		</InspectorControls>
	);
}
