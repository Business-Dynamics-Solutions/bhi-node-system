import { test, expect } from '@wordpress/e2e-test-utils-playwright';
import { faker } from '@faker-js/faker';

test.describe('Create Node System and Assign to Post', () => {
	const testTitle = faker.person.fullName();
	const testContent = faker.lorem.paragraph();

	test('Ensure node post type is properly registered', async ({
		requestUtils,
	}) => {
		const nodePosts = await requestUtils.rest({
			path: '/wp/v2/node',
			method: 'GET',
		});
		expect(nodePosts).toBeDefined();
	});

	test('Ensure bylines taxonomy is properly registered', async ({
		requestUtils,
	}) => {
		const bylinesTerms = await requestUtils.rest({
			path: '/wp/v2/bylines',
			method: 'GET',
		});
		expect(bylinesTerms).toBeDefined();
	});

	test('Node post created', async ({ admin, editor, requestUtils }) => {
		await admin.createNewPost({
			title: testTitle,
			content: testContent,
			postType: 'node',
		});
		// Publish the node
		await editor.publishPost();

		// Get the created node via REST API
		const nodePosts = await requestUtils.rest({
			path: '/wp/v2/node',
			method: 'GET',
		});
		// Get the first item out of the nodePosts array
		const nodePost = nodePosts?.[0];
		// Verify the node was created with correct title and content
		expect(nodePost.title.rendered).toBe(testTitle);
		expect(nodePost.content.rendered).toContain(testContent);
	});

	test('Matching bylines term created with node post', async ({
		requestUtils,
	}) => {
		const bylinesTerms = await requestUtils.rest({
			path: '/wp/v2/bylines',
			method: 'GET',
		});
		// Get the first item out of the bylinesTerms array
		const bylinesTerm = bylinesTerms?.[0];
		// Verify the bylines term was created with correct title and content
		expect(bylinesTerm.name).toBe(testTitle);
	});

	// test('Publish new post with bylines term', async ({
	// 	admin,
	// 	editor,
	// 	page,
	// 	requestUtils,
	// }) => {
	// 	await admin.createNewPost({
	// 		title: 'Test Post',
	// 		content: 'This is a test post',
	// 		postType: 'post',
	// 	});

	// 	// Add the byline term to the post...

	// 	// Publish the posts.
	// 	await editor.publishPost();

	// 	// Confirm the post has a bylines term in the rest api
	// 	const testPosts = await requestUtils.rest({
	// 		path: '/wp/v2/posts',
	// 		method: 'GET',
	// 	});
	// 	// Get the first item out of the testPosts array
	// 	const testPost = testPosts?.[0];
	// 	// Verify the post has a bylines term in the rest api
	// 	expect(testPost.bylines).toHaveLength(1);
	// 	// Take a screenshot of the post
	// 	const today = new Date();
	// 	// This gives 'YYYY-MM-DD' format.
	// 	const formattedDate = today.toISOString().split('T')[0];
	// 	await page.screenshot({
	// 		path: `tests/screenshots/post-${formattedDate}.png`,
	// 	});
	// });
});
