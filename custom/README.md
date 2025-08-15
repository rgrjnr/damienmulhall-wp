# Custom Components Directory

This directory contains all Carbon Fields customizations organized into logical subdirectories. The structure is automatically loaded via the `index.php` autoloader.

## Directory Structure

```
custom/
├── index.php              # Autoloader - loads all components
├── post-types/            # Custom post type definitions
│   └── team.php           # Team members post type
├── taxonomies/            # Custom taxonomy definitions
│   └── team-departments.php # Team departments taxonomy
├── fields/                # Custom field definitions (metaboxes)
│   └── team-fields.php    # Team member custom fields
├── blocks/                # Gutenberg block definitions
│   └── team-showcase.php  # Team showcase block
└── theme-options/         # Theme options panels
    └── general.php        # General theme options
```

## Usage

Include this entire structure in your theme by requiring the main index file:

```php
require_once(get_template_directory() . '/custom/index.php');
```

This is automatically done in `carbon.php` after Carbon Fields is initialized.

## Adding New Components

### Custom Post Types
Create a new file in `post-types/` following this pattern:
- Use `register_post_type()` function
- Hook to `init` action
- Prefix functions with `rgrjnr_`

### Custom Taxonomies
Create a new file in `taxonomies/` following this pattern:
- Use `register_taxonomy()` function
- Hook to `init` action
- Associate with appropriate post types

### Custom Fields
Create a new file in `fields/` following this pattern:
- Use Carbon Fields Container and Field classes
- Hook to `carbon_fields_register_fields` action
- Group related fields logically

### Gutenberg Blocks
Create a new file in `blocks/` following this pattern:
- Use Carbon Fields Block class
- Include render callback function
- Hook to `carbon_fields_register_fields` action

### Theme Options
Create a new file in `theme-options/` following this pattern:
- Use Carbon Fields Container with 'theme_options' type
- Organize fields into logical tabs
- Hook to `carbon_fields_register_fields` action

## Important Notes

- All files are automatically loaded via `index.php`
- Function names should use `rgrjnr_` prefix to avoid conflicts
- Custom fields use `rgrjnr_` prefix in field names
- Always include proper security checks (`ABSPATH` check)
- Use WordPress coding standards and proper documentation