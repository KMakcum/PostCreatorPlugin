<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://test.com
 * @since      1.0.0
 *
 * @package    Post_Creator
 * @subpackage Post_Creator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Post_Creator
 * @subpackage Post_Creator/admin
 * @author     Max One <test@gmail.com>
 */
class Post_Creator_Main {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
        add_action('wp_ajax_create_posts', [$this, 'create_posts']);
        add_action('wp_ajax_nopriv_create_posts', [$this, 'create_posts']);
	}

    /**
     * Handler for creating posts.
     *
     * @since    1.0.0
     */
    public function create_posts(){
        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'create_posts__nonce' ) ) {
            wp_send_json_error();
        }

        if (empty($_POST['count_posts'])) die('Введите количество постов');
        if (empty($_POST['post_title'])) die('Введите заголовок поста');
        if (empty($_POST['post_title'])) die('Введите заголовок поста');


        $user_id = get_current_user_id();
        $post_data = array(
            'post_author'           => $user_id,
            'post_content'          => $_POST['post_content'],
            'post_content_filtered' => '',
            'post_title'            => sanitize_text_field( $_POST['post_title'] ),
            'post_excerpt'          => $_POST['post_excerpt'],
            'post_status'           => 'publish',
            'post_type'             => $_POST['post_type'],
            'comment_status'        => '',
            'ping_status'           => '',
            'post_password'         => '',
            'to_ping'               => '',
            'pinged'                => '',
            'post_parent'           => 0,
            'menu_order'            => 0,
            'guid'                  => '',
            'import_id'             => 0,
            'context'               => '',
            'post_date'             => '',
            'post_date_gmt'         => '',
            'post_category'         => $_POST['posts_cats'],
        );

        for ($i = 1; $i < $_POST['count_posts']; $i++) {
            wp_insert_post( $post_data );
        }



        wp_send_json_success(
            [
                '$post_data' => $post_data,
            ],
            200);

        die();
    }
}
