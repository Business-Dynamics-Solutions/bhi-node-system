/**
 * WordPress Dependencies
 */
import { Fragment } from '@wordpress/element';
import { registerPlugin } from '@wordpress/plugins';

/**
 * Internal Dependencies
 */
import MaelstromPanel from './maelstrom';
import NodeInfoPanel from './node-info';
import WPUserPanel from './wp-user';

registerPlugin('prc-node-info', {
	render: () => {
		return (
			<Fragment>
				<NodeInfoPanel />
				<MaelstromPanel />
				<WPUserPanel />
			</Fragment>
		);
	},
	icon: null,
});
