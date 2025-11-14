<?php

    namespace Next\Controllers;

    use WP_REST_Response;

    class SitemapController
    {
        public function index(): WP_REST_Response {
            $data = array_merge($this->getAllPages(),$this->getAllPosts());

            return  new WP_REST_Response($data,200);
        }


        protected function getAllPages() {
            $pages = get_pages([
                'post_status' => 'publish',
                'sort_column' => 'post_modified',
                'sort_order'  => 'DESC'
            ]);
            $result = [];

            foreach ($pages as $page) {
                $translations = [];
                if (function_exists('icl_get_languages')) {
                    $langs = icl_get_languages('skip_missing=0');
                    foreach ($langs as $lang) {
                        if ($lang['language_code'] !== ICL_LANGUAGE_CODE) {
                            $translations[$lang['language_code']] = apply_filters('wpml_permalink', get_permalink($page->ID), $lang['language_code']);
                        }
                    }
                }

                $result[] = [
                    'url' => get_permalink($page->ID),
                    'lastModified' => get_the_modified_time('c', $page->ID),
                    'alternates' => [
                        'languages' => $translations
                    ]
                ];
            }
            return $result;
        }

        protected function getAllPosts() {
            $posts = get_posts([
                'post_type' => 'post',
                'post_status' => 'publish',
                'numberposts' => -1
            ]);

            $result = [];
            foreach ($posts as $post) {
                $translations = [];
                if (function_exists('icl_get_languages')) {
                    $langs = icl_get_languages('skip_missing=0');
                    foreach ($langs as $lang) {
                        if ($lang['language_code'] !== ICL_LANGUAGE_CODE) {
                            $translations[$lang['language_code']] = apply_filters('wpml_permalink', get_permalink($post->ID), $lang['language_code']);
                        }
                    }
                }

                $result[] = [
                    'url' => get_permalink($post->ID),
                    'lastModified' => get_the_modified_time('c', $post->ID),
                    'alternates' => [
                        'languages' => $translations
                    ]
                ];
            }
            return $result;
        }
    }