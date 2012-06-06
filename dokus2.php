<?php
/*
Plugin Name: Dokus
Plugin URI:
Description: Accounting system to send invoices to some of the users of your site. No need for two databases
Version: 0.2 beta
Author: Sindre Svendby
Author URI:
License: Copyright, no use without permission!
*/
error_reporting(E_ALL ^ E_NOTICE);

require('DokusWP.php');

const POST_WORDPRESS_ID = 'wordpress_id';
const POST_DOKUS_ID = 'dokus_id';
const WP_OPTION_KEY = "dokus";
const WP_OPTION_USERS = "wordpress_users";
const WP_OPTION_GROUPS = "groups";
const WP_OPTION_SETTINGS = "settings";
const WP_OPTION_SETTINGS_EMAIL = "email";
const WP_OPTION_SETTINGS_PASSWORD = "password";
const WP_OPTION_SETTINGS_SUBDOMAIN = "subdomain";

define('DOKUS_PAGE', "dokus-page");
define ('SEE_DOKUS_USERS', "SEE_DOKUS_USERS");
define ('SEE_GROUPS', "SEE_GROUPS");
define("SEE_WORDPRESS_USERS", "SEE_WORDPRESS_USERS");
define('SEE_OPTIONS', 'SEE_OPTIONS');
define('SEE_PEOPLE_LIST', 'SEE_PEOPLE_LIST');
define('SHOW_DOKUS_ADMIN_PAGE', 'options-general.php?page=dokus');
define('DOKUS_ADMIN_URL', get_admin_url() . '' . SHOW_DOKUS_ADMIN_PAGE);

add_action('admin_menu', 'dokus_menu');


class DokusConst
{
    private static $validPages = array('settings', 'default', 'dokusUsers', 'groups', 'options', 'peopleList',
        'wordpressUsers');

    public static function getValidPages()
    {
        return self::$validPages;
    }
}

function dokus_menu()
{
    add_options_page('My Dokus Options', 'Dokus', 'manage_options', 'dokus', 'dokus_options_page');
}



function dokus_options_page()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
        //wp_enqueue_style('css', WP_PLUGIN_URL . '/' . GCE_PLUGIN_NAME . '/dokus.css');
    }
    //wp_enqueue_style('dokus_css_style',  '/pages/templates/dokus.css', false, '1.0', 'all');

    //add_action('wp_enqueue_scripts','dokus_css_style');

    $dokus = null;
    if (dokusAccountNotSet()):
        include "pages/settings.php";
        exit;
    endif;

    $dokus = DokusWPFactory::getDokusService();
    $requestedPage = $_GET[DOKUS_PAGE];

    if ($requestedPage == null) {
        include "pages/default.php";
    } else if (validateRequest($requestedPage)):
        include  "pages/$requestedPage.php";
    else:
        include "noHandler.php";
    endif;
}


function validateRequest($requestPage)
{
    return in_array(DokusConst::getValidPages(), $requestPage);
}

function dokusAccountNotSet()
{
    $options = get_option(WP_OPTION_KEY);
    $settings = $options[WP_OPTION_SETTINGS];
    return (empty($settings[WP_OPTION_SETTINGS_SUBDOMAIN]));
}

function get_list_of_groups($dokus)
{
    $groups = array();
    $options = get_option(Dokus::WP_OPTION_KEY);
    $mapping_groups = $options[Dokus::WP_OPTION_GROUPS];
    $groupsResource = $dokus->dokus_customer_groups_service;
    if ($mapping_groups == null) {
        $mapping_groups = array();
    }
    foreach ($mapping_groups as $wordpress_group_id => $dokus_group_id):
        $dokus_group = $groupsResource->get($dokus_group_id);
        $wordpress_group = PeopleListWrapper::get_people_list_list($wordpress_group_id);
        $groups[$wordpress_group_id] = new MappingGroups($dokus_group, $wordpress_group);
    endforeach;

    $w_user_not_in_d = array();
    foreach (PeopleListWrapper::get_people_list_lists() as $wordpress_group):
        if (array_key_exists($wordpress_group["list_id"], $mapping_groups)
        ):
            //Its in the mapping table
        else:
            $w_user_not_in_d[$wordpress_group["list_id"]] = $wordpress_group;
        endif;
    endforeach;

    $reverted_mapping = array();
    foreach ($mapping_groups as $wordpress_group_id => $dokus_group_id):
        $reverted_mapping[$dokus_group_id] = $wordpress_group_id;
    endforeach;

    $d_user_not_in_w = array();
    foreach ($groupsResource->all() as $dokus_group):
        if (array_key_exists($dokus_group->id, $reverted_mapping)
        ):
            //Its in the mapping table
        else:
            $d_user_not_in_w[$dokus_group->id] = $dokus_group;
        endif;

    endforeach;
    return array($groups, $w_user_not_in_d, $d_user_not_in_w);
}


function get_list_of_users($dokus)
{
    $users = array();
    $options = get_option(WP_OPTION_KEY);
    $mapping_users = $options[WP_OPTION_USERS];

    $customerResource = new DokusCustomersResource($dokus->dokus_service);

    if ($mapping_users != null) {
        foreach ($mapping_users as $wordpress_user_id => $dokus_user_id):
            $dokus_user = $customerResource->get($dokus_user_id);
            $wordpress_user = get_userdata($wordpress_user_id);
            $users[$wordpress_user_id] = new MappingUser($dokus_user, $wordpress_user);
        endforeach;

        $w_user_not_in_d = array();
        foreach (get_users() as $wordpress_user):
            if (array_key_exists($wordpress_user->ID, $mapping_users)
            ):
                //Its in the mapping table
                null;
            else:
                $w_user_not_in_d[$wordpress_user->ID] = $wordpress_user;
            endif;
        endforeach;

        $reverted_mapping = array();
        foreach ($mapping_users as $wordpress_user_id => $dokus_user_id):
            $reverted_mapping[$dokus_user_id] = $wordpress_user_id;
        endforeach;

        $d_user_not_in_w = array();
        foreach ($customerResource->all() as $dokus_user):
            if (array_key_exists($dokus_user->id, $reverted_mapping)
            ) :
                //Its in the mapping table
            else:
                $d_user_not_in_w[$dokus_user->id] = $dokus_user;
            endif;

        endforeach;
    }
    return array($users, $w_user_not_in_d, $d_user_not_in_w);
}


function get_dokus_id($wordpress_id)
{
    $dokus_option = get_option(Dokus::WP_OPTION_KEY);
    $user_mapping = $dokus_option[Dokus::WP_OPTION_USERS];
    return $user_mapping[$wordpress_id];
}


function get_dokus_ids($w_ids)
{
    $d_ids = array();
    foreach ($w_ids as $w_id):
        $d_id = get_dokus_id($w_id);
        if (!empty($d_id)):
            $d_ids[] = $d_id;
        endif;
    endforeach;
    #print_array($d_ids);
    return $d_ids;
}

class MappingGroups
{
    public $dokus_group;
    public $wordpress_group;

    function __construct($d_group, $w_group)
    {
        $this->dokus_group = $d_group;
        $this->wordpress_group = $w_group;
    }

    function __toString()
    {
        return "Wordpress group " . $this->wordpress_group["title"] . " is dokus group with name " . $this->dokus_group->name;
    }

}

class MappingUser
{
    public $dokus_user;
    public $wordpress_user;

    function __construct($d_user, $w_user)
    {
        $this->dokus_user = $d_user;
        $this->wordpress_user = $w_user;
    }

    function __toString()
    {
        return "Wordpress user " . $this->wordpress_user->display_name . " is dokus user with name " . $this->dokus_user->name;
    }

}

class PeopleListWrapper
{
    const WP_OPTION_KEY = "people-lists";
    const WP_OPTION_LIST = "lists";

    static function get_people_list_lists()
    {
        $people_list_option = get_option(PeopleListWrapper::WP_OPTION_KEY);
        $people_list_list = $people_list_option[PeopleListWrapper::WP_OPTION_LIST];
        return $people_list_list;
    }

    static function get_people_list_list($people_list_nr)
    {
        $people_list_option = get_option(PeopleListWrapper::WP_OPTION_KEY);
        $people_list_list = $people_list_option[PeopleListWrapper::WP_OPTION_LIST];

        return $people_list_list[$people_list_nr];
    }
}

function print_array($aArray)
{
    // Print a nicely formatted array representation:
    echo '<pre>';
    print_r($aArray);
    echo '</pre>';
}


?>