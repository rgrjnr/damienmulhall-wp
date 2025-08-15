# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a modern WordPress theme starter that combines traditional WordPress development with TypeScript, SCSS, and Tailwind CSS. The theme uses Carbon Fields for custom fields and includes a custom SPA-like navigation system.

## Essential Commands

### Development
```bash
npm run dev          # Start development mode with file watching (SCSS, TypeScript, Tailwind)
npm run build        # Production build with minification
npm run lint         # Run all linters (TypeScript and SCSS)
npm run lint:fix     # Auto-fix linting issues
npm run format       # Format all files with Prettier
npm run format:check # Check if files need formatting
```

### Testing Individual Components
```bash
npm run dev:scss     # Watch and compile SCSS only
npm run dev:ts       # Watch and compile TypeScript only
npm run dev:tailwind # Watch and compile Tailwind only
npm run lint:ts      # Lint TypeScript files only
npm run lint:scss    # Lint SCSS files only
```

## Architecture & Key Patterns

### Asset Pipeline
- **Source files** in `assets/ts/` and `assets/scss/` compile to `assets/dist/`
- TypeScript compiles through Webpack to `bundle.js`
- SCSS files import partials (e.g., `_main.scss`) and compile to minified CSS
- Tailwind CSS is processed separately with PostCSS
- The `assets/dist/` directory is gitignored and regenerated on build

### WordPress Integration Points
- `functions.php`: Enqueues compiled assets from `assets/dist/`, registers menus and theme supports
- `carbon.php`: Initializes Carbon Fields for custom fields (loaded via Composer autoload)
- `custom-posts/`: Contains custom post type definitions (e.g., team.php)
- Theme files must properly enqueue assets using `rgrjnr_enqueue_assets()` function

### Custom Navigation System
The theme includes a TypeScript-based SPA navigation (`assets/ts/main.ts`) that:
- Intercepts link clicks for same-domain navigation
- Fetches page content via AJAX
- Updates the DOM without full page reload
- Manages loading states with CSS classes

### Carbon Fields Usage
- Initialized in `carbon.php` with `rgrjnr_crb_load()` function
- Components organized in `custom/` directory with secure whitelist-based loader
- Custom post types, taxonomies, fields, blocks, and theme options in separate subdirectories
- Uses `RGRJNR_Component_Loader` class with explicit file whitelist for security
- Required via Composer, not committed to repository

### Security Implementation
- **Component Loader**: Uses whitelist-based approach instead of glob patterns to prevent arbitrary file inclusion
- **File Validation**: Validates file existence, type, and location before loading
- **Suspicious Pattern Detection**: Logs warnings for potentially dangerous PHP functions
- **Directory Protection**: `.htaccess` and `index.php` files prevent direct access to component files
- **Extensibility**: Child themes/plugins can safely register components via `rgrjnr_register_custom_components` action

## Development Workflow

### Setting Up a New Feature
1. Create TypeScript modules in `assets/ts/`
2. Add SCSS partials to `assets/scss/` and import in main files
3. Use Tailwind classes directly in PHP templates
4. Run `npm run dev` to watch changes
5. Test with `npm run lint` before committing

### Adding Custom Components
1. Create new file in appropriate `custom/` subdirectory:
   - `custom/post-types/` for custom post types
   - `custom/taxonomies/` for custom taxonomies
   - `custom/fields/` for Carbon Fields configurations
   - `custom/blocks/` for custom Gutenberg blocks
   - `custom/theme-options/` for theme settings
2. Add the filename to the whitelist in `custom/index.php` in the `$components` array
3. Follow existing patterns for component structure
4. Use Carbon Fields for custom fields and metaboxes

### Component Whitelist Management
**CRITICAL**: When creating or removing custom components, you MUST update the whitelist in `custom/index.php` to maintain security:

#### Adding Components:
1. **Automatically add** new filenames to the appropriate section in the `$components` array:
   - `'post-types'` => array for custom post type files
   - `'taxonomies'` => array for custom taxonomy files  
   - `'fields'` => array for Carbon Fields configuration files
   - `'blocks'` => array for custom Gutenberg block files
   - `'theme-options'` => array for theme options files

2. **Maintain array structure**: Add filenames as strings in the correct subdirectory array
3. **Preserve formatting**: Keep existing indentation and array syntax
4. **Example whitelist update**:
   ```php
   private static $components = [
       'post-types' => [
           'team.php',
           'products.php'  // <- New file added here
       ],
       'taxonomies' => [
           'team-departments.php',
           'product-categories.php'  // <- New file added here
       ],
       // ... other sections
   ];
   ```

#### Removing Components:
1. **Remove filename** from the appropriate `$components` array section
2. **Clean up empty arrays** but maintain the structure
3. **Verify** the component file is also deleted from the filesystem

#### Security Requirements:
- **Never bypass** the whitelist system
- **Always validate** that new components follow the security patterns
- **Ensure** all component files include the `@package WPThemeStarter` header
- **Use** the `rgrjnr_` prefix for all functions to avoid conflicts

### Modifying Build Configuration
- Webpack config: `webpack.config.js` (TypeScript bundling)
- Tailwind config: `tailwind.config.js` (utility classes, theme)
- PostCSS config: `postcss.config.js` (CSS processing)
- TypeScript config: `tsconfig.json` (compiler options)

## Important Conventions

### File Organization
- Keep WordPress template files in root
- Place reusable template parts in `parts/`
- Source assets go in `assets/[ts|scss]/`
- Compiled assets output to `assets/dist/` (never commit)

### Naming Conventions
- Functions prefixed with `rgrjnr_` to avoid conflicts
- SCSS partials prefixed with underscore (e.g., `_main.scss`)
- TypeScript classes use PascalCase, files use kebab-case

### WordPress Stubs
The project includes WordPress stubs via Composer for better IDE support. This resolves undefined function warnings for WordPress core functions in PHP files.

## Critical Files to Understand

- `assets/ts/main.ts`: Core navigation system implementation
- `functions.php`: Theme setup and asset enqueuing
- `carbon.php`: Carbon Fields initialization
- `custom/index.php`: Secure component loader with whitelist
- `package.json`: Build scripts and dependencies
- `webpack.config.js`: TypeScript bundling configuration