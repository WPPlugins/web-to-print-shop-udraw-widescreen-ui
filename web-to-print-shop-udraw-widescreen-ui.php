<?php
/*
 * Plugin Name: Web To Print Shop : uDraw - Widescreen UI
 * Plugin URI: http://www.webtoprintshop.com/
 * Description: Custom Designer UI for uDraw Plugin.
 * Version: 1.2.0
 * Author: Racad Tech, Inc.
 * Author URI: http://www.racadtech.com
 * 
 * Requires at least: 4.1
 * 
 * @package uDraw_Designer_Widescreen_UI
 * @author  Crystal Ng
 */

if (!defined('UDRAW_WIDESCREEN_UI_URL')) {
    define('UDRAW_WIDESCREEN_UI_URL', plugins_url('/', __FILE__));
}

if (!defined('UDRAW_WIDESCREEN_UI_DIR')) {
    define('UDRAW_WIDESCREEN_UI_DIR', dirname(__FILE__));
}
if (!class_exists('uDrawWidescreenUI')) {
    class uDrawWidescreenUI {
        function __contsruct() { }
        
        // ------------------------------------------------------------- //
        // -------------------------- Init ----------------------------- //
        // ------------------------------------------------------------- //        
        public function init() {
            add_filter('udraw_designer_register_skin', array(&$this, 'udraw_designer_register_skin'), 10, 1);
            add_filter('udraw_designer_ui_override', array(&$this,'udraw_designer_ui_override'), 10, 9);
        }
        
        public function udraw_designer_register_skin($skins) {
            $skins['widescreen'] = "Widescreen";
            return $skins;
        }
        
        public function udraw_designer_ui_override($override, $template_id, $current_skin, $displayOptionsFirst,$allowCustomerDownloadDesign,$isPriceMatrix,$templateCount,$isTemplatelessProduct,$isuDrawApparelProduct) {
            if (strtolower($current_skin) == 'widescreen') {
                $this->registerDesignerWidescreenStyles();
                require_once("skin/designer.php");
                return true; // We will override the default UI
            }
            
            return false; // We wont override the default UI
        }
        
        public function registerDesignerWidescreenStyles(){
            wp_register_style('udraw_skin_ui_css' , plugins_url('skin/css/designer-widescreen.css', __FILE__));
            wp_register_script('udraw_skin_resize_ui_js', plugins_url('skin/js/resizeWidescreenDesigner.js', __FILE__));
            wp_enqueue_style('udraw_skin_ui_css');
            wp_enqueue_script('udraw_skin_resize_ui_js');
        }
        
    }
}
$passed_sanity_check = true;
//let user know that he needs the uDraw plugin
function udraw_widescreen_admin_notice() {
?>
<div class="error" style="color: #A95353; background-color: #FDD0D0; border-radius: 5px;">
    <p style="font-size: 14px;">
        <strong>Important:</strong> uDraw - Widescreen UI requires uDraw to be Installed & Activated.
    </p>
</div>
<?php
}

// Check to see if uDraw is Activated.
if (!in_array('udraw/udraw.php', array_map('strtolower', apply_filters('active_plugins', get_option('active_plugins'))))) {
    add_action('admin_notices', 'udraw_widescreen_admin_notice');
    $passed_sanity_check = false;
}

if ($passed_sanity_check) {
    // Init the plugin.
    $uDrawWidescreenUI = new uDrawWidescreenUI();
    $uDrawWidescreenUI->init();
}
?>