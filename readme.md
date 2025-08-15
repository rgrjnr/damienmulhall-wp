# WordPress Starter Theme

A modern WordPress theme starter with TypeScript, SCSS, Tailwind CSS, and Carbon Fields support.

## Features

- 🎨 **Modern Build System** - TypeScript, SCSS, and Tailwind CSS compilation
- 🚀 **SPA-like Navigation** - Smooth page transitions without full reload
- 📦 **Carbon Fields** - Advanced custom fields and theme options
- ✨ **Code Quality** - ESLint, Stylelint, and Prettier configured
- 🔧 **Developer Friendly** - Hot reloading, source maps, and WordPress stubs

## Prerequisites

- Node.js (v20.9.0 or higher)
- npm or yarn
- PHP 7.4 or higher
- Composer
- Local WordPress development environment

## Getting Started

### 1. Clone the Repository

```bash
cd wp-content/themes/
git clone [repository-url] wp-theme-starter
cd wp-theme-starter
```

### 2. Install Dependencies

```bash
# Install Node dependencies
npm install

# Install PHP dependencies (Carbon Fields)
composer install
```

### 3. Development Setup

```bash
# Start development mode with file watching
npm run dev
```

This will watch and compile:
- TypeScript files from `assets/ts/` → `assets/dist/js/bundle.js`
- SCSS files from `assets/scss/` → `assets/dist/css/stylesheet.css`
- Tailwind CSS → `assets/dist/css/tailwind.css`

### 4. Production Build

```bash
# Create optimized production build
npm run build
```

This will:
- Clean the `assets/dist/` directory
- Compile and minify all assets
- Generate source maps for debugging

## Available Scripts

| Command | Description |
|---------|------------|
| `npm run dev` | Start development mode with file watching |
| `npm run build` | Production build with minification |
| `npm run lint` | Run all linters (TypeScript and SCSS) |
| `npm run lint:fix` | Auto-fix linting issues |
| `npm run lint:ts` | Lint TypeScript files only |
| `npm run lint:scss` | Lint SCSS files only |
| `npm run format` | Format all files with Prettier |
| `npm run format:check` | Check if files need formatting |

## Project Structure

```
wp-theme-starter/
├── assets/
│   ├── ts/              # TypeScript source files
│   │   └── main.ts       # Main navigation system
│   ├── scss/             # SCSS source files
│   │   ├── stylesheet.scss
│   │   ├── _main.scss
│   │   └── tailwind.css
│   ├── dist/             # Compiled assets (gitignored)
│   │   ├── css/
│   │   └── js/
│   └── [fonts|images|js]/ # Static assets
├── custom-posts/         # Custom post type definitions
│   └── team.php
├── parts/                # Template parts
│   └── nav.php
├── vendor/               # Composer dependencies (gitignored)
├── functions.php         # Theme setup and configuration
├── carbon.php            # Carbon Fields initialization
└── [WordPress theme files]
```

## Development Workflow

### Adding New Features

1. **TypeScript**: Create modules in `assets/ts/` - they'll be bundled automatically
2. **Styles**: Add SCSS partials to `assets/scss/` and import them in main files
3. **Tailwind**: Use utility classes directly in PHP templates
4. **Custom Fields**: Use Carbon Fields in `carbon.php` for theme options

### Creating Custom Post Types

1. Create a new file in `custom-posts/` directory
2. Follow the pattern in `team.php`:
```php
register_post_type('your_post_type', [
    'labels' => [...],
    'public' => true,
    'supports' => ['title', 'thumbnail', 'custom-fields'],
    // ... other options
]);
```
3. Include the file in `functions.php` or use autoloading

### Using Carbon Fields

Add custom fields to your theme options or post types:
```php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('theme_options', __('Theme Options'))
    ->add_fields([
        Field::make('text', 'crb_text', 'Text Field'),
        // Add more fields
    ]);
```

## Code Quality

### Linting

The project uses:
- **ESLint** for TypeScript/JavaScript
- **Stylelint** for SCSS/CSS
- **Prettier** for code formatting

Run linters before committing:
```bash
npm run lint
npm run format:check
```

### IDE Setup

For VS Code with Intelephense:
- WordPress stubs are included via Composer
- Configuration in `.vscode/settings.json` and `intelephense.config.json`
- WordPress functions will be recognized after restarting VS Code

## Configuration Files

| File | Purpose |
|------|---------|
| `webpack.config.js` | TypeScript bundling configuration |
| `tailwind.config.js` | Tailwind CSS customization |
| `tsconfig.json` | TypeScript compiler options |
| `.eslintrc.json` | ESLint rules for TypeScript |
| `.stylelintrc.json` | Stylelint rules for SCSS |
| `.prettierrc.json` | Code formatting rules |
| `postcss.config.js` | PostCSS plugins configuration |

## Troubleshooting

### WordPress Functions Not Recognized
- Restart VS Code after initial setup
- Ensure `composer install` has been run
- Check that Intelephense extension is installed

### Build Errors
- Clear `node_modules` and reinstall: `rm -rf node_modules && npm install`
- Ensure Node version is 20.9.0 or higher: `node --version`
- Check for TypeScript errors: `npm run lint:ts`

### Styles Not Updating
- Ensure `npm run dev` is running
- Check that compiled files exist in `assets/dist/`
- Clear browser cache or use incognito mode

## License

[Your License Here]

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Run linters and fix issues (`npm run lint:fix`)
4. Commit your changes (`git commit -m 'Add amazing feature'`)
5. Push to the branch (`git push origin feature/amazing-feature`)
6. Open a Pull Request