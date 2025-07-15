/**
 * WordPress Dependencies
 */
import apiFetch from '@wordpress/api-fetch';

/**
 * Gets a single node member by ID from PRC primary site.
 * @param {*} nodeId
 * @returns
 */
export function fetchNode(nodeId, valueToFetch) {
	const endpointUrl = `${window.location.origin}/wp-json/wp/v2/node/${nodeId}`;

	return new Promise((resolve) => {
		apiFetch({
			url: endpointUrl,
		}).then((post) => {
			// eslint-disable-next-line camelcase
			const { nodeInfo } = post;
			const value = nodeInfo[`${valueToFetch}`];
			return resolve(value);
		});
	});
}

/**
 * Gets a single value from a byline term by termId from the current PRC site.
 * @param {*} termId
 * @param {*} valueToFetch
 */
export function fetchByline(termId, valueToFetch) {
	return new Promise((resolve) => {
		apiFetch({
			path: `/wp/v2/bylines/${termId}`,
		}).then((byline) => {
			// eslint-disable-next-line camelcase
			const { nodeInfo } = byline;
			console.log('bylines nodeInfo...', nodeInfo);
			const value = nodeInfo[`${valueToFetch}`];
			return resolve(value);
		});
	});
}
