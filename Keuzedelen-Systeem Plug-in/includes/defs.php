<?php

/**
 * Definitions needed in the plugin
 *
 * @author Arran Crowley
 * @version 0.1
 *
 * Version history
 *
 */
// De versie moet gelijk zijn met het versie nummer in de vragenapp.php header

define('KEUZEDELEN_SYSTEEM_VERSION', '1.0.0');
// Minimum required Wordpress version for this plugin

define('KEUZEDELEN_SYSTEEM_REQUIRED_WP_VERSION', '4.0');
define('KEUZEDELEN_SYSTEEM_PLUGIN_BASENAME', plugin_basename(KEUZEDELEN_SYSTEEM_PLUGIN));
define('KEUZEDELEN_SYSTEEM_PLUGIN_NAME', trim(dirname(KEUZEDELEN_SYSTEEM_PLUGIN_BASENAME), '/'));

// Folder structure
define('KEUZEDELEN_SYSTEEM_PLUGIN_DIR', untrailingslashit(dirname(KEUZEDELEN_SYSTEEM_PLUGIN)));
define('KEUZEDELEN_SYSTEEM_PLUGIN_INCLUDES_DIR', KEUZEDELEN_SYSTEEM_PLUGIN_DIR . '/includes');
define('KEUZEDELEN_SYSTEEM_PLUGIN_MODEL_DIR', KEUZEDELEN_SYSTEEM_PLUGIN_INCLUDES_DIR . '/model');
define('KEUZEDELEN_SYSTEEM_PLUGIN_ADMIN_DIR', KEUZEDELEN_SYSTEEM_PLUGIN_DIR . '/admin');
define('KEUZEDELEN_SYSTEEM_PLUGIN_ADMIN_VIEWS_DIR', KEUZEDELEN_SYSTEEM_PLUGIN_ADMIN_DIR . '/views');
define('KEUZEDELEN_SYSTEEM_PLUGIN_INCLUDES_VIEWS_DIR', KEUZEDELEN_SYSTEEM_PLUGIN_INCLUDES_DIR . '/views');
define('KEUZEDELEN_SYSTEEM_PLUGIN_INCLUDES_IMGS_DIR', KEUZEDELEN_SYSTEEM_PLUGIN_INCLUDES_DIR . '/imgs');
?>