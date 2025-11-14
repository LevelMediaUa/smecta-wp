<?php
    /**
     * robert-theme functions and definitions
     *
     * @link https://developer.wordpress.org/themes/basics/theme-functions/
     *
     * @package robert-theme
     */

    if ( ! defined( '_S_VERSION' ) ) {
        // Replace the version number of the theme on each release.
        define( '_S_VERSION', '1.0.0' );
    }

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function next_theme_setup() {
        /*
            * Make theme available for translation.
            * Translations can be filed in the /languages/ directory.
            * If you're building a theme based on robert-theme, use a find and replace
            * to change 'robert-theme' to the name of your theme in all the template files.
            */
        load_theme_textdomain( 'next-theme', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
            * Let WordPress manage the document title.
            * By adding theme support, we declare that this theme does not use a
            * hard-coded <title> tag in the document head, and expect WordPress to
            * provide it for us.
            */
        add_theme_support( 'title-tag' );

        /*
            * Enable support for Post Thumbnails on posts and pages.
            *
            * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
            */
        add_theme_support( 'post-thumbnails' );


        /*
            * Switch default core markup for search form, comment form, and comments
            * to output valid HTML5.
            */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );



        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 38,
                'width'       => 145,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );
    }
    add_action( 'after_setup_theme', 'next_theme_setup' );

    /**
     * Allow svg files uploading.
     */
    require get_template_directory() . '/inc/Allow_SVG_Upload.php';
    Allow_SVG_Upload::init();

    require get_template_directory() . '/inc/theme-functions.php';
    require get_template_directory() . '/inc/routes.php';
    if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
        require_once __DIR__ . '/vendor/autoload.php';
    }

    function remove_wp_version() {
        remove_action('wp_head', 'wp_generator');
    }
    add_action('init', 'remove_wp_version');
