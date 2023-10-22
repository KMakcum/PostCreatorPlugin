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

        $post_count = !empty($_POST['count_posts']) ? esc_html($_POST['count_posts']) : 1;
        $post_title = !empty($_POST['post_title']) ? esc_html($_POST['post_title']) : 'Post';
        $post_type = !empty($_POST['post_type']) ? esc_html($_POST['post_type']) : 'post';
        $posts_cats = !empty($_POST['posts_cats']) ? array_values($_POST['posts_cats']) : [];
        $post_status = !empty($_POST['post_status']) ? esc_html($_POST['post_status']) : 'publish';
        $post_content = !empty($_POST['post_content']) ? esc_html($_POST['post_content']) : '';
        $post_excerpt = !empty($_POST['post_excerpt']) ? esc_html($_POST['post_excerpt']) : '';

        if (empty($post_count)) die('Введите количество записей');
        if (empty($post_title)) die('Введите заголовок записи');
        if (empty($post_type)) die('Выберите тип записи');

        $user_id = get_current_user_id();
        $post_data = [
            'post_author' => $user_id,
            'post_title'  => sanitize_text_field($post_title),
            'post_type'   => $post_type,
            'post_status' => $post_status,
        ];

        if (!empty($post_content)) $post_data['post_content'] = $post_content;
        if (!empty($post_excerpt)) $post_data['post_excerpt'] = $post_excerpt;
        if (!empty($posts_cats)) $post_data['post_category'] = $posts_cats;

        for ($i = 1; $i <= $post_count; $i++) {
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
