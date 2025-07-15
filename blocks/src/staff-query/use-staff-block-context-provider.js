/**
 * WordPress Dependencies
 */
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import { useEntityRecords } from '@wordpress/core-data';
import {
	useMemo,
	useEffect,
} from '@wordpress/element';

const placeholderNode = [
	{
		"nodeName": "John Doe",
		"nodeJobTitle": "Associate Researcher",
		"nodeImage": false,
		"nodeTwitter": 'johndoe',
		"nodeExpertise": [],
		"nodeBio": "Cupidatat minim amet labore esse adipisicing. Exercitation duis culpa do incididunt cillum Lorem dolor. Et irure non veniam amet deserunt officia aute do qui. Voluptate anim in duis.",
		"nodeMiniBio": "Cillum dolor nisi exercitation nostrud anim non ea deserunt deserunt ut tempor ut eiusmod",
		"nodeLink": false
	},
	{
		"nodeName": "Jane Doe",
		"nodeJobTitle": "VP of Research Methods",
		"nodeImage": false,
		"nodeTwitter": 'janedoe',
		"nodeExpertise": [],
		"nodeBio": "Proident sit magna ullamco commodo esse duis labore. Consequat sint dolor incididunt id dolor laboris duis nulla pariatur. Consequat pariatur et ex. Dolore velit non deserunt. Dolore esse commodo deserunt magna quis irure. Ipsum id occaecat ea labore ipsum et proident culpa ullamco amet pariatur consequat elit ullamco mollit.",
		"nodeMiniBio": "Magna reprehenderit cupidatat magna elit do excepteur minim velit ex culpa nostrud voluptate laborum enim nulla amet laborum occaecat incididunt",
		"nodeLink": false
	}
];

export default function useNodeBlockContextProvider({ attributes, clientId }) {
	const { nodeType, researchArea } = attributes;
	const nodeTypeId = nodeType ? nodeType.id : null;
	const args = {
		per_page: 100,
		orderby: 'last_name',
		order: 'asc',
		fields: 'id,slug,title,type,name,nodeInfo',
	};
	if (nodeTypeId) {
		args['node-type'] = nodeTypeId;
	}
	const researchAreaId = researchArea ? researchArea.id : null;
	if (researchAreaId) {
		args['research-area'] = researchAreaId;
	}

	const {records, isResolving, hasResolved} = useEntityRecords( 'postType', 'node', args);

	const blockContexts = useMemo(() => {
		if (!records || 0 === records.length) {
			return placeholderNode;
		}
		return records?.map((nodePost) => {
			return nodePost?.nodeInfo || {};
		});
	}, [records]);

	useEffect(() => {
		console.log('Node Posts Data', records);
	}, [clientId, records, isResolving, nodeType, researchArea]);

	return {
		blockContexts,
		isResolving,
		hasResolved,
	};
};
