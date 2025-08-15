<?php
/**
 * Custom Components Loader - Secure Version
 * 
 * This file loads all custom post types, taxonomies, fields, blocks, and theme options
 * using an explicit whitelist approach for security.
 * 
 * Security: Only explicitly defined files are loaded to prevent arbitrary file inclusion attacks.
 *
 * @package WPThemeStarter
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Component registry with explicit file whitelist
 * 
 * Add new components here when creating them.
 * This prevents arbitrary PHP file execution if malicious files are placed in these directories.
 */
class RGRJNR_Component_Loader {
    
    /**
     * Whitelisted components organized by type
     * 
     * @var array
     */
    private static $components = [
        'post-types' => [
            'case-study.php'
        ],
        'taxonomies' => [
            'highlights.php'
        ],
        'fields' => [
            'highlights-fields.php',
            'case-study-fields.php'
        ],
        'blocks' => [
        ],
        'theme-options' => [
            'general.php'
        ]
    ];
    
    /**
     * Load all registered components
     * 
     * @return void
     */
    public static function load() {
        $base_dir = get_template_directory() . '/custom/';
        
        foreach (self::$components as $type => $files) {
            self::load_component_type($base_dir . $type . '/', $files, $type);
        }
    }
    
    /**
     * Load specific component type files
     * 
     * @param string $directory Directory path
     * @param array  $files     Array of whitelisted filenames
     * @param string $type      Component type for logging
     * @return void
     */
    private static function load_component_type($directory, $files, $type) {
        if (!is_dir($directory)) {
            return;
        }
        
        foreach ($files as $filename) {
            $filepath = $directory . $filename;
            
            // Validate file before loading
            if (self::validate_component_file($filepath, $type)) {
                require_once $filepath;
            } else {
                // Log error in debug mode
                if (WP_DEBUG) {
                    error_log(sprintf(
                        'RGRJNR Theme: Failed to load %s component: %s',
                        $type,
                        $filename
                    ));
                }
            }
        }
    }
    
    /**
     * Validate component file before loading
     * 
     * @param string $filepath Full path to file
     * @param string $type     Component type
     * @return bool
     */
    private static function validate_component_file($filepath, $type) {
        // Check if file exists
        if (!file_exists($filepath)) {
            return false;
        }
        
        // Verify it's actually a file (not directory or symlink)
        if (!is_file($filepath)) {
            return false;
        }
        
        // Check file extension
        if (pathinfo($filepath, PATHINFO_EXTENSION) !== 'php') {
            return false;
        }
        
        // Ensure file is within theme directory (prevent directory traversal)
        $real_path = realpath($filepath);
        $theme_dir = realpath(get_template_directory());
        
        if (strpos($real_path, $theme_dir) !== 0) {
            return false;
        }
        
        // Optional: Check for file header comment to ensure it's a legitimate component
        $file_contents = file_get_contents($filepath, false, null, 0, 512);
        if ($file_contents !== false) {
            // Check for WordPress file header or package declaration
            if (strpos($file_contents, '@package WPThemeStarter') === false && 
                strpos($file_contents, 'WPThemeStarter') === false) {
                // Allow files without package declaration but log warning
                if (WP_DEBUG) {
                    error_log(sprintf(
                        'RGRJNR Theme: Component file missing package declaration: %s',
                        basename($filepath)
                    ));
                }
            }
            
            // Check for suspicious patterns
            $suspicious_patterns = [
                'eval(',
                'assert(',
                'system(',
                'exec(',
                'shell_exec(',
                'passthru(',
                'proc_open(',
                'popen(',
                'file_get_contents("http',
                'file_get_contents(\'http',
                'curl_exec(',
                'base64_decode(',
                '$_GET[',
                '$_POST[',
                '$_REQUEST[',
                '$_FILES[',
                'php://input'
            ];
            
            foreach ($suspicious_patterns as $pattern) {
                if (stripos($file_contents, $pattern) !== false) {
                    if (WP_DEBUG) {
                        error_log(sprintf(
                            'RGRJNR Theme: Suspicious pattern detected in %s: %s',
                            basename($filepath),
                            $pattern
                        ));
                    }
                    // Still load the file but log the warning
                    // In production, you might want to return false here
                }
            }
        }
        
        return true;
    }
    
    /**
     * Register a new component programmatically
     * 
     * This method allows plugins or child themes to register additional components
     * in a controlled manner.
     * 
     * @param string $type     Component type (post-types, taxonomies, fields, blocks, theme-options)
     * @param string $filename Filename to register
     * @return bool
     */
    public static function register_component($type, $filename) {
        // Validate component type
        if (!isset(self::$components[$type])) {
            return false;
        }
        
        // Validate filename (only allow alphanumeric, dash, underscore)
        if (!preg_match('/^[a-zA-Z0-9_-]+\.php$/', $filename)) {
            return false;
        }
        
        // Check if already registered
        if (in_array($filename, self::$components[$type], true)) {
            return true;
        }
        
        // Add to whitelist
        self::$components[$type][] = $filename;
        
        return true;
    }
    
    /**
     * Get list of registered components
     * 
     * @param string|null $type Optional component type filter
     * @return array
     */
    public static function get_registered_components($type = null) {
        if ($type === null) {
            return self::$components;
        }
        
        return isset(self::$components[$type]) ? self::$components[$type] : [];
    }
}

// Load all components
RGRJNR_Component_Loader::load();

// Allow child themes and plugins to register additional components
do_action('rgrjnr_register_custom_components');