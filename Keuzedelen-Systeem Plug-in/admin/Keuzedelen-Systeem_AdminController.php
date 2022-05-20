<?php

/**
 * This Admin controller file provide functionality for the Admin
 *
 * @author Arran Crowley
 * @version 0.1
 *
 * Version history
 * 0.1 Arran Crowley Initial version
 */
class Keuzedelen_Systeem_AdminController
{

    //This function will prepare all Admin functionality for the plugin
    static function prepare()
    {
        // Check that we are in the admin area
        if (is_admin()) :
            // Add the sidebar Menu structure
            add_action('admin_menu', array('Keuzedelen_Systeem_AdminController', 'addMenus'));
        endif;
    }

    // Add the Menu structure to the Admin sidebar
    static function addMenus()
    {
        add_menu_page(
        // string $page_title The text to be displayed in the title tags of the page when the menu is selected
            __('BranchPagina', 'BranchPagina'),
            // string $menu_title The text to be used for the menu
            __('Keuzedelen-Systeem Plug-in', 'Keuzedelen-Systeem Plug-in'),
            // string $capability The capability required for this menu to be displayed to the user.
            'manage_options',
            // string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
            'branchpagina'
        );

        //vragen pagina submenu
        add_submenu_page(
        // string $parent_slug The slug name for the parent menu
        // (or the file name of a standard WordPress admin page)
            'branchpagina',
            // string $page_title The text to be displayed in the title tags of the page when the menu is selected
            __('BranchPagina', 'branchPagina'),
            // string $menu_title The text to be used for the menu
            __('BranchPagina', 'branchPagina'),
            // string $capability The capability required for this menu to be displayed to the user.
            'manage_options',
            // string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
            'branchpagina',
            // callback $function The function to be called to output the content for this page.
            array('Keuzedelen_Systeem_AdminController', 'adminSubMenuBranchPagina')
        );

        //Cluster en opleidingen pagina submenu
        add_submenu_page(
        // string $parent_slug The slug name for the parent menu
        // (or the file name of a standard WordPress admin page)
            'branchpagina',
            // string $page_title The text to be displayed in the title tags of the page when the menu is selected
            __('Opleiding Pagina', 'Opleiding Pagina'),
            // string $menu_title The text to be used for the menu
            __('Opleiding Pagina', 'Opleiding Pagina'),
            // string $capability The capability required for this menu to be displayed to the user.
            'manage_options',
            // string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
            'opleidingpagina',
            // callback $function The function to be called to output the content for this page.
            array('Keuzedelen_Systeem_AdminController', 'adminSubMenuOpleidingenPagina')
        );


        //Categoriepagina submenu
        add_submenu_page(
        // string $parent_slug The slug name for the parent menu
        // (or the file name of a standard WordPress admin page)
            'branchpagina',
            // string $page_title The text to be displayed in the title tags of the page when the menu is selected
            __('Keuzedelen Pagina', 'Keuzedelen Pagina'),
            // string $menu_title The text to be used for the menu
            __('Keuzedelen Pagina', 'Keuzedelen Pagina'),
            // string $capability The capability required for this menu to be displayed to the user.
            'manage_options',
            // string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
            'keuzedelenpagina',
            // callback $function The function to be called to output the content for this page.
            array('Keuzedelen_Systeem_AdminController', 'adminSubMenuKeuzedelenPage')
        );
    }

    // The question page
    static function adminSubMenuBranchPagina()
    {
        // Include the view for this menu page.
        include KEUZEDELEN_SYSTEEM_PLUGIN_ADMIN_VIEWS_DIR . '/branchpagina.php';

    }

    // The cluster and education page
    static function adminSubMenuOpleidingenPagina()
    {
        // Include the view for this menu page.
        include KEUZEDELEN_SYSTEEM_PLUGIN_ADMIN_VIEWS_DIR . '/opleidingpagina.php';
    }

    // The category page
    static function adminSubMenuKeuzedelenPage()
    {
        // Include the view for this menu page.
        include KEUZEDELEN_SYSTEEM_PLUGIN_ADMIN_VIEWS_DIR . '/keuzedelenpagina.php';
    }
}