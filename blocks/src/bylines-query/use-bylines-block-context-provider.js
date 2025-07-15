/**
 * External Dependencies
 */

/**
 * WordPress Dependencies
 */
import { useMemo, useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import { useEntityProp } from '@wordpress/core-data';

const placeholderBylines = [
	{
		nodeName: 'John Doe',
		nodeJobTitle: 'Associate Researcher',
		nodeImage: false,
		nodeTwitter: 'johndoe',
		nodeExpertise: [],
		nodeBio:
			'Cupidatat minim amet labore esse adipisicing. Exercitation duis culpa do incididunt cillum Lorem dolor. Et irure non veniam amet deserunt officia aute do qui. Voluptate anim in duis.',
		nodeMiniBio:
			'Cillum dolor nisi exercitation nostrud anim non ea deserunt deserunt ut tempor ut eiusmod',
		nodeLink: false,
		nodeJobTitleExtended: 'an Associate Researcher focusing on XYZ',
		nodeBioShort:
			'<a href="#">John Doe</a> is an Associate Researcher focusing on XYZ.',
	},
	{
		nodeName: 'Jane Doe',
		nodeJobTitle: 'VP of Research Methods',
		nodeImage: false,
		nodeTwitter: 'janedoe',
		nodeExpertise: [],
		nodeBio:
			'Proident sit magna ullamco commodo esse duis labore. Consequat sint dolor incididunt id dolor laboris duis nulla pariatur. Consequat pariatur et ex. Dolore velit non deserunt. Dolore esse commodo deserunt magna quis irure. Ipsum id occaecat ea labore ipsum et proident culpa ullamco amet pariatur consequat elit ullamco mollit.',
		nodeMiniBio:
			'Magna reprehenderit cupidatat magna elit do excepteur minim velit ex culpa nostrud voluptate laborum enim nulla amet laborum occaecat incididunt',
		nodeLink: false,
		nodeJobTitleExtended: 'an Associate Researcher focusing on XYZ',
		nodeBioShort:
			'<a href="#">Jane Doe</a> is VP of Research Methods focusing on XYZ.',
	},
];

const getBylineNameAsync = (termId) =>
	new Promise((resolve, reject) => {
		apiFetch({
			path: `/wp/v2/bylines/${termId}`,
		})
			.then((byline) => {
				const { nodeInfo } = byline;
				console.log('getBylineNameAsync', byline);
				return resolve(nodeInfo);
			})
			.catch((err) => {
				console.error(err);
				return reject(err);
			});
	});

async function getBlockBylineContexts(bylineTermIds) {
	console.log('getBlockBylineContexts', bylineTermIds);
	if (!bylineTermIds) {
		return placeholderBylines;
	}
	return await Promise.all(
		bylineTermIds.map((termId) => getBylineNameAsync(termId))
	);
}

/**
 * Returns an object containing the bylines context and a contextId.
 * The bylines context is an array of nodeInfo objects matching each bylineTermId passed in.
 * The contextId is a hash of the first nodeInfo object in the bylines context array.
 * @param {*} bylineTermIds
 * @return
 */
export default function useBylinesContextProvider({ postId, postType }) {
	const [bylineTermIds] = useEntityProp('postType', postType, 'bylines');
	const [bylinesContext, _setBylines] = useState([]);
	const isResolving = useMemo(
		() => null === bylinesContext,
		[bylinesContext]
	);

	useEffect(() => {
		getBlockBylineContexts(bylineTermIds).then((bylines) => {
			_setBylines(bylines);
		});
	}, [bylineTermIds]);

	return {
		isResolving,
		bylinesContext,
	};
}
