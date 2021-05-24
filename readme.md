# JBR Starter Theme

I've created this starter theme to speed up custom theme development. It's a bare-bones theme structured in the way I like to work (for better or worse).

## Getting Started

To get started, simply run `pnpm run create`. You will be guided through setting up the theme's name and specific information, and then install the dependencies for the theme.

- `|_NAME_|`: Human-readable name for the theme
- `|_SLUG_|`: Theme Slug
- `|_PACKAGE_|`: PHP Package name for composer
- `|_JS_PACKAGE_|`: JS Package name for NPM

## Development

- To build the theme's scripts and styles for development, run `npm run build`
- To watch the theme's scripts and styles to compile as you work, run `npm run dev`
- To build the theme's scripts and styles for production, run `npm run buildprod`