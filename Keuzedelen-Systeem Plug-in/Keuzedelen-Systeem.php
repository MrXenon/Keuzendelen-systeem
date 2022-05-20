<?php
/**
 * Plugin Name: KeuzedelenPlugin
 * Plugin URI: < your plugin url >
 * Description: Plugin voor het aanmaken van keuzedelen
 * Author: Arran Crowley
 * Author URI: < your uri >
 * Version: 0.1
 * Text Domain: Keuzedelen
 * Domain Path: languages
 *
 * This is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with your plugin. If not, see <http://www.gnu.org/licenses/>.
 */
// Define the plugin name:
define('KEUZEDELEN_SYSTEEM_PLUGIN', __FILE__);
// Include the general definition file:
require_once plugin_dir_path(__FILE__) . 'includes/defs.php';

class Keuzedelen_Systeem
{

    public function __construct()
    {
        // Fire a hook before the class is setup.
        do_action('keuzedelen_pre_init');
        // Load the plugin.
        add_action('init', array($this, 'init'), 1);
    }

    //Loads the plugin into WordPress.
    public function init()
    {
        // Run hook once Plugin has been initialized.
        do_action('keuzedelen_init');
        // Load admin only components.
        if (is_admin()) {
            // Load all admin specific includes
            $this->requireAdmin();
            // Setup admin page
            $this->createAdmin();
        }
        // Load the view shortcodes
        $this->loadViews();
    }

    // Loads all admin related files into scope.
    public function requireAdmin()
    {
        // Admin controller file
        require_once KEUZEDELEN_SYSTEEM_PLUGIN_ADMIN_DIR .
            '/Keuzedelen-Systeem_AdminController.php';
    }

    // Admin controller functionality
    public function createAdmin()
    {
        Keuzedelen_Systeem_AdminController::prepare();
    }

    // Load the view shortcodes:
    public function loadViews()
    {
        include KEUZEDELEN_SYSTEEM_PLUGIN_INCLUDES_VIEWS_DIR . '/view_shortcodes.php';
    }
}
// Instantiate the class
$Keuzedelen_Systeem = new Keuzedelen_Systeem();
?>