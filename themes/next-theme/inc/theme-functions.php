<?php
    function dd($var)
    {
        echo '<pre style=" background: #000; color: green; padding: 15px; font-size: 12px;">';
        print_r($var);
        echo '</pre>';
        die();
    }
    if ( function_exists( 'acf_add_options_page' ) ) {

        $option_page = acf_add_options_page( array(
            'page_title' => 'Global options',
            'menu_title' => 'Global options',
            'menu_slug'  => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect'   => false
        ) );
    }
    function get_registered_languages() {
        $languages = icl_get_languages('skip_missing=0&orderby=code');

        if (!empty($languages)) {
            return $languages;
        }

        return [];
    }
    function get_current_language () {
        return apply_filters('wpml_current_language', 'en');
    }