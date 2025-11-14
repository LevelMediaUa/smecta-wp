<?php

    namespace Next\Controllers;

    use WP_Error;
    use WP_Query;
    use WP_REST_Request;
    use WP_REST_Response;

    class PostsController
    {
        public function index(WP_REST_Request $request):WP_REST_Response {
            $lang = $request->get_param('lang') ? sanitize_text_field($request->get_param('lang')) : 'uk';
            $page = $request->get_param('page') ? intval($request->get_param('page')) : 1;
            $limit = $request->get_param('limit') ? intval($request->get_param('limit')) : 3;


            return new WP_REST_Response($this->getPosts($lang,$limit,$page,true),200);
        }

        public function related(WP_REST_Request $request):WP_REST_Response | WP_Error{
            $lang = $request->get_param('lang') ? sanitize_text_field($request->get_param('lang')) : 'uk';
            $exclude_slug = $request->get_param('exclude') ? sanitize_text_field($request->get_param('exclude')) : null;
            $page = 1;
            $limit = 3;
            $data = $exclude_slug ? $this->get_related_posts($exclude_slug,$lang) : $this->getPosts($lang,$limit,$page,false);
            if(!$data) {
                return new WP_Error('no_post', 'Posts not found', ['status' => 404]);
            }

            return new WP_REST_Response($data,200);
        }

        protected function get_related_posts(string $slug, string $lang):array | null
        {
            $post = get_page_by_path($slug, OBJECT, 'post');
            $count = 3;
            if(!$post) {
                return null;
            }
            $post_id = $post->ID;
            $related = get_post_meta($post_id, '_static_related_posts', true);
            if ($related && is_array($related)) {
                $args = [
                    'post__in'       => $related,
                    'orderby'        => 'post__in',
                    'posts_per_page' => $count,
                    'post_type'      => 'post',
                    'lang'           => $lang,
                ];
                $query = new WP_Query($args);
                return $this->get_posts_from_query($query);
            }
            $args = [
                'post__not_in'    => [$post_id],
                'posts_per_page'  => $count,
                'orderby'         => 'rand',
                'post_type'       => 'post',
                'lang'            => $lang,
            ];
            $query = new WP_Query($args);
            $posts = $this->get_posts_from_query($query);


            $related_ids = array_column($posts, 'id');
            update_post_meta($post_id, '_static_related_posts', $related_ids);

            return $posts;
        }

        protected function getPosts(string $lang, int $limit = 3, int $page = 1, bool $with_pagination = false , array | null $args = null) {
            $query_args = [
                'post_type' => 'post',
                'posts_per_page' => $limit,
                'paged' => $page,
                'lang'  => $lang,
            ];
            if(!empty($args))  {
                $query_args = array_merge($query_args,$args);
            }
            $query = new WP_Query($query_args);
            if($with_pagination) {
                return [
                    'posts' => $this->get_posts_from_query($query),
                    'pagination' => $this->get_pagination_data($limit,$page,$query)
                ];
            }


            return $this->get_posts_from_query($query);
        }

        protected function get_posts_from_query(WP_Query $query):array
        {
            $data = [];
            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $image_id = get_post_thumbnail_id(get_the_ID());
                    $image_src = $image_id ? wp_get_attachment_image_src($image_id, 'full')[0] : null;
                    $data[] = array(
                        'id' => get_the_ID(),
                        'title' => esc_html(get_the_title()),
                        'description' => esc_html(get_the_excerpt()),
                        'image' => $image_src,
                        'slug' => get_post_field( 'post_name', get_post() )
                    );
                }
                wp_reset_postdata();
            }

            return $data;
        }
        protected function get_pagination_data(int $per_page,int $page, WP_Query $products_query): array
        {
            $total_products = $products_query->found_posts;

            return array(
                'perPage'     => $per_page,
                'total'        => $total_products,
                'currentPage' => $page,
                'maxPages'    => $products_query->max_num_pages
            );
        }
    }