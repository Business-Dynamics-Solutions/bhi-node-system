# PRC Node System

PRC Node System is a comprehensive node and bylines management system for WordPress, designed for the PRC Platform. It creates synchronized node profiles and byline taxonomies, provides custom editor blocks, and offers an enhanced multi-author experience.

## Features

- **Custom Node Post Type**: Manage node profiles with job titles, extended bios, photos, and social profiles.
- **Bylines Taxonomy**: Assign multiple node bylines to posts, supporting true multi-author content.
- **Areas of Expertise & Node Types**: Categorize node by expertise and type (e.g., executive, researcher).
- **REST API Integration**: Exposes node and byline data for headless and decoupled applications.
- **Editor UI**: Custom sidebar panels for managing bylines, acknowledgements, and node info in the block editor.
- **Blocks**:
  - **Node Query**: Display node filtered by type or research area.
  - **Bylines Display**: Show a post's bylines in a customizable format.
  - **Bylines Query**: Query and display bylines for the current post.
  - **Node Info**: Display detailed node information.
  - **Node Context Provider**: Pass node context to inner blocks for advanced layouts.
- **SEO & Permalinks**: Integrates with Yoast SEO and customizes node archive links.
- **Security & Privacy**: Includes features to protect sensitive node ("maelstrom" safety net for regional/country-based restrictions).

## Installation

1. Ensure you have [prc-platform-core](../prc-platform-core) installed and activated.
2. Copy or symlink this plugin to your WordPress `plugins` or `mu-plugins` directory.
3. Activate **PRC Node System** from the WordPress admin.
4. Run `npm install` and `npm run build` in this directory to build block assets.

## Usage

- **Managing Node**: Add and edit node profiles under the "Node" menu in the WordPress admin.
- **Assigning Bylines**: In the post editor, use the "Bylines" panel to assign node bylines and acknowledgements to posts.
- **Custom Blocks**: Insert the provided blocks into posts or templates to display node lists, bylines, or detailed node info.
- **REST API**: Node and byline data are available via the WordPress REST API for integration with decoupled frontends.

## Available Blocks

- **Node Query** (`prc-block/node-query`): Query and display node by type or research area.
- **Bylines Display** (`prc-block/bylines-display`): Display a post's bylines with a customizable prefix (e.g., "By").
- **Bylines Query** (`prc-block/bylines-query`): Query and display bylines for the current post.
- **Node Info** (`prc-block/node-info`): Show detailed information for a node member.
- **Node Context Provider** (`prc-block/node-context-provider`): Provide node context to nested blocks for advanced layouts.

## Development

- **Requirements**: Node.js, npm, and Composer (for advanced use).
- **Scripts**:
  - `npm run build`: Build block assets.
  - `npm test`: Run Playwright tests.
  - `npm run test:env:start`: Start the local WordPress environment.
  - `npm run test:env:stop`: Stop the local environment.
  - `npm run test:env:clean`: Clean and restart the environment.
  - `npm run test:env:destroy`: Destroy the environment.
- **Local Environment**: Uses `.wp-env.json` for local development with required plugins and theme.

## License

GPL-2.0-or-later. See the license header in `prc-node-bylines.php`.

## Credits

Developed by Seth Rubenstein for Pew Research Center.

