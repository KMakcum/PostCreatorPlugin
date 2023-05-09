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


        wp_send_json_success(
            [
                '$_POST' => $_POST,
            ],
            200);

        die();
    }
}
