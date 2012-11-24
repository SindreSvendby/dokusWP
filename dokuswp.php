<?php
/*
Plugin Name: Dokus
Plugin URI:
Description: Wordpress pluging for Dokus.no, lets you easily create and groups based on your wordpress user.
Version: 1.0
Author: Sindre Svendby
Author URI:
License: Copyright, no use without permission!
*/
#error_reporting(E_ALL ^ E_STRICT);

$dir = dirname(__FILE__);
$files_in_dir = (glob($dir . "/classes/*.php"));
foreach ($files_in_dir as $filename) {
    require($filename);
}


define('WP_OPTION_KEY', "dokus");
define('WP_OPTION_SETTINGS', "settings");

define('WP_OPTION_SETTINGS_EMAIL', "email");
define('WP_OPTION_SETTINGS_PASSWORD', "password");
define('WP_OPTION_SETTINGS_SUBDOMAIN', "subdomain");

define('DOKUS_PAGE', "dokus-page");
define ('SEE_DOKUS_USERS', "dokusUsers");
define ('SEE_GROUPS', "dokusGroups");
define('SEE_OPTIONS_VALUES', 'see_values');
define('SEE_SETTINGS', 'settings');
define('SEE_WORDPRESS_USERS', 'wordpressUsers');

define('SEE_PEOPLE_LIST', 'SEE_PEOPLE_LIST');
define('SHOW_DOKUS_ADMIN_PAGE', 'options-general.php?page=dokus');
define('DOKUS_ADMIN_URL', get_admin_url() . '' . SHOW_DOKUS_ADMIN_PAGE);

add_action('admin_menu', 'dokus_menu');

function dokus_menu()
{
    add_options_page('My Dokus Options', 'Dokus', 'manage_options', 'dokus', 'dokus_options_page');
}


function dokus_options_page()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));

    }
    wp_enqueue_style('css', WP_PLUGIN_URL . '/dokusWP/pages/templates/dokus.css');
    include 'pages/templates/header.php';
    $dokus = null;
    if (dokusAccountNotSet()):
        include "pages/settings.php";
    else:
        $customerCache = new DokusCustomersCache();
        $groupCache = new DokusCustomerGroupCache();
        $cache = array();
        $cache['group'] = $groupCache;
        $cache['customer'] = $customerCache;
        $dokus = getDokusService();
        //$dokus->setDebug(true);
        $requestedPage = (isset ($_GET[DOKUS_PAGE])) ? $_GET[DOKUS_PAGE] : false;
        $requestedHandler = new RequestHandler();
        if ($requestedPage == null) {
            include "pages/default.php";
        } else if ($requestedHandler->validateRequest($requestedPage . ".php")):
            include  "pages/$requestedPage.php";
        else:
            include "pages/noHandler.php";
        endif;
    endif;
}

function dokusAccountNotSet()
{
    $options = get_option(WP_OPTION_KEY);
    $settings = $options[WP_OPTION_SETTINGS];
    return (empty($settings[WP_OPTION_SETTINGS_SUBDOMAIN]));
}

function print_array($aArray)
{
    echo '<pre>';
        print_r($aArray);
    echo '</pre>';
}
?>