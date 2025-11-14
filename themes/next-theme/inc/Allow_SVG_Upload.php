<?php

    /**
     * Allow uploading svg webp file types
     *
     * @version 1.1
     */
    final class Allow_SVG_Upload {

        public static function init(): void {

            // Allow file types to be uploaded
            add_filter( 'upload_mimes', [ __CLASS__, 'upload_allow_types' ] );
            add_filter( 'wp_check_filetype_and_ext', [ __CLASS__, 'fix_svg_mime_type' ], 10, 5 );
            add_filter( 'wp_prepare_attachment_for_js', [ __CLASS__, 'show_svg_in_media_library' ] );

            add_filter( 'wp_handle_sideload_prefilter', [ __CLASS__, 'check_upload_file_size' ] );
            add_filter( 'wp_handle_upload_prefilter', [ __CLASS__, 'check_upload_file_size' ] );

            add_filter( 'getimagesize_mimes_to_exts', [ __CLASS__, 'more_mimes_to_exts' ] );
            add_filter( 'image_sideload_extensions', [ __CLASS__, 'more_image_sideload_extensions' ] );
        }

        public static function upload_allow_types( $mimes ){

            if( current_user_can( 'upload_files' ) ){
                $mimes['svg']  = 'image/svg+xml';
            }

            $mimes['webp'] = 'image/webp';

            // deactivate existing
            unset( $mimes['mp4a'] );

            return $mimes;
        }

        public static function more_image_sideload_extensions( $allowed ){
            $allowed[] = 'svg';

            return $allowed;
        }

        public static function more_mimes_to_exts( $mime_to_ext ){
            $mime_to_ext['image/webp'] = 'webp';

            return $mime_to_ext;
        }

        public static function fix_svg_mime_type( $data, $file, $filename, $mimes, $real_mime = '' ){

            // WP 5.1 +
            if( version_compare( $GLOBALS['wp_version'], '5.1.0', '>=' ) ){
                $dosvg = in_array( $real_mime, [ 'image/svg', 'image/svg+xml' ] );
            }
            else{
                $dosvg = ( '.svg' === strtolower( substr( $filename, -4 ) ) );
            }

            // mime type was reset, let's fix it
            // and also check file size and user permissions
            if( $dosvg ){
                if( current_user_can( 'upload_files' ) ){
                    $data['ext']  = 'svg';
                    $data['type'] = 'image/svg+xml';
                }
                // prohibit
                else {
                    $data['ext'] = $type_and_ext['type'] = false;
                }
            }

            return $data;
        }

        /**
         * Generates data for displaying SVGs as images in the media library.
         */
        public static function show_svg_in_media_library( $response ) {

            if ( $response['mime'] === 'image/svg+xml' ) {
                $response['sizes'] = [
                    'medium' => [
                        'url' => $response['url'],
                    ],
                    // when editing a image
                    'full' => [
                        'url' => $response['url'],
                    ],
                ];
            }

            return $response;
        }

        /**
         * Limit the size of uploaded files by type
         */
        public static function check_upload_file_size( $file ){

            if( ! $file ){
                return $file;
            }

            // for SVG
            if( str_contains( ( $file['type'] ?? '' ), 'image/svg+xml' ) ){
                $size_limit = 500 * 1024; // max size in KB

                if( (int) $file['size'] > $size_limit ){
                    $file['error'] = sprintf(
                        __( 'ERROR: Размер этого типа файлов не может превышать %s', 'km' ),
                        size_format( $size_limit )
                    );
                }
            }

            return $file;
        }

    }