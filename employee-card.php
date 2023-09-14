<?php

/**
 * Plugin Name: Employee Card
 * Plugin URI: http://wpminers.com/
 * Description: A sample Wordpress plugin to implement Vue with tailwind.
 * Author: Hasanuzzaman
 * Author URI: http://hasanuzzaman.com/
 * Version: 1.0.1
 */
define('EMPLOYEE_CARD_URL', plugin_dir_url(__FILE__));
define('EMPLOYEE_CARD_DIR', plugin_dir_path(__FILE__));

define('EMPLOYEE_CARD_VERSION', '1.0.5');

class EmployeeCard
{
    public function boot()
    {
        $this->registerFrontendRoute();
        $this->loadClasses();
        $this->registerShortCodes();
        $this->ActivatePlugin();
        $this->renderMenu();
        $this->registerEndpoints();
    }

    public function registerFrontendRoute()
    {
        add_action( 'init',  function() {
            add_rewrite_rule( 'contact_card/([a-z0-9-]+)[/]?$', 'index.php?contact_card=$matches[1]', 'top' );
        } );

        add_filter( 'query_vars', function( $query_vars ) {
            $query_vars[] = 'contact_card';
            return $query_vars;
        } );



        add_action( 'template_include', function( $template ) {
            if ( get_query_var( 'contact_card' ) == false || get_query_var( 'contact_card' ) == '' ) {
                return $template;
            }

            return EMPLOYEE_CARD_DIR.'/views/contactcard.php';
        } );
    }

    public function loadClasses()
    {
        require EMPLOYEE_CARD_DIR . 'includes/autoload.php';
    }

    public function renderMenu()
    {
        add_action('admin_menu', function () {
            if (!current_user_can('manage_options')) {
                return;
            }
            global $submenu;
            add_menu_page(
                'Employee Card',
                'Employee Card',
                'manage_options',
                'employee-card.php',
                array($this, 'renderAdminPage'),
                'dashicons-admin-users',
                25
            );
            $submenu['employee-card.php']['dashboard'] = array(
                'Employees',
                'manage_options',
                'admin.php?page=employee-card.php#/',
            );
            // $submenu['employee-card.php']['contact'] = array(
            //     'Contact',
            //     'manage_options',
            //     'admin.php?page=employee-card.php#/contact',
            // );
        });
    }

    public function renderAdminPage()
    {

        wp_enqueue_media();
        wp_enqueue_script('employee_card-script-boot', EMPLOYEE_CARD_URL . 'assets/admin/js/start.js', array('jquery'), EMPLOYEE_CARD_VERSION, false);
        wp_enqueue_style('employee_card-global-styling', EMPLOYEE_CARD_URL . 'assets/css/element.css', array(), EMPLOYEE_CARD_VERSION);

        $employee_card = apply_filters('employee_card/admin_app_vars', array(
            //'image_upload_url' => admin_url('admin-ajax.php?action=wpf_global_settings_handler&route=wpf_upload_image'),
            'assets_url' => EMPLOYEE_CARD_URL . 'assets/',
            'ajaxurl' => admin_url('admin-ajax.php'),
            'site_url' => site_url(),
        ));

        wp_localize_script('employee_card-script-boot', 'employeeCard', $employee_card);

    //     <div class="main-menu text-white-200 bg-wheat-600 p-4">
    //     <router-link to="/">
    //         Home
    //     </router-link> |
    //     <router-link to="/contact" >
    //         Contact
    //     </router-link>
    // </div>

        echo '<div class="employee_card-admin-page" id="employee_card_app">
            <hr/>
            <router-view></router-view>
        </div>';
    }

    public function registerShortCodes()
    {
        // your shortcode here
    }

    public function registerEndpoints()
    {
        require_once(EMPLOYEE_CARD_DIR . 'includes/Classes/AdminAjaxHandler.php');
        (new EmployeeCard\Classes\AdminAjaxHandler())->registerEndpoints();
    }

    public function ActivatePlugin()
    {
        //activation deactivation hook
        register_activation_hook(__FILE__, function ($newWorkWide) {
            require_once(EMPLOYEE_CARD_DIR . 'includes/Classes/Activator.php');
            $activator = new \EmployeeCard\Classes\Activator();
            $activator->migrateDatabases($newWorkWide);
        });
    }
}

(new EmployeeCard())->boot();



