<?php

    const API_DOMAIN = "next-api/v1/";


    add_action('rest_api_init', function () {

        register_rest_route(API_DOMAIN, '/posts', [
            'methods' => 'GET',
            'callback' => [new \Next\Controllers\PostsController(), 'index'],
        ]);
        register_rest_route(API_DOMAIN, '/related', [
            'methods' => 'GET',
            'callback' => [new \Next\Controllers\PostsController(), 'related'],
        ]);
        register_rest_route(API_DOMAIN, '/sitemap', [
            'methods' => 'GET',
            'callback' => [new \Next\Controllers\SitemapController(), 'index'],
        ]);
    });

