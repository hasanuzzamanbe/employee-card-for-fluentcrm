<?php

// write your global functions here

if(!function_exists('wpFluent')) {
    include EMPLOYEE_CARD_DIR . 'includes/libs/wp-fluent/wp-fluent.php';
}

if (!function_exists('emcDb')) {
    function emcDb() {
        if (!function_exists('wpFluent')) {
            include EMPLOYEE_CARD_DIR . 'includes/libs/wp-fluent/wp-fluent.php';
        }
        return wpFluent();
    }
}

