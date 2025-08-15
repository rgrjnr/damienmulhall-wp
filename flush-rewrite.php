<?php
/**
 * Temporary file to flush rewrite rules
 * Delete this file after use
 */

// Load WordPress
require_once('../../../wp-load.php');

// Flush rewrite rules
flush_rewrite_rules();

echo "Rewrite rules have been flushed successfully!\n";
echo "The case study URLs should now work.\n";
echo "\nIMPORTANT: Delete this file after use for security.\n";
?>