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
class Post_Creator_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        add_action( 'admin_menu', [$this, 'post_creator_menu_page'], 25 );
	}

    /**
     * Register the menu page for the admin area.
     *
     * @since    1.0.0
     */
    public function post_creator_menu_page(){
        add_menu_page(
            'Создание постов',
            'Creator',
            'manage_options',
            'post-creator',
            [$this, 'post_creator_page_callback'],
            'dashicons-welcome-add-page',
            2
        );
    }

    public function post_creator_page_callback(){?>
        <h1><?php echo get_admin_page_title()?></h1>

        <div class="tabs">
            <ul>
                <li><a href="#create">Создать</a></li>
                <li><a href="#update">Обновить</a></li>
            </ul>
            <div id="create">
                <?php include plugin_dir_path( __FILE__ ) . '/template-parts/tabs/creating.php'; ?>
            </div>
            <div id="update">
                <?php include plugin_dir_path( __FILE__ ) . '/template-parts/tabs/updating.php'; ?>
            </div>
        </div>
        <?php
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Post_Creator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Creator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        if ($hook !== 'toplevel_page_post-creator') return;

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/post-creator-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Post_Creator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Post_Creator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        if ($hook !== 'toplevel_page_post-creator') return;
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-tabs');

        wp_enqueue_script( 'popper-core', 'https://unpkg.com/@popperjs/core@2', [], '', false );
        wp_enqueue_script( 'tippy', 'https://unpkg.com/tippy.js@6', [], '', false );

        wp_enqueue_script( $this->plugin_name.'-frontend', plugin_dir_url( __FILE__ ) . 'js/frontend.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name.'-backend', plugin_dir_url( __FILE__ ) . 'js/backend.js', array( 'jquery' ), $this->version, false );

        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
        wp_enqueue_script( $this->plugin_name.'-media', plugin_dir_url( __FILE__ ) . 'js/media.js', array('jquery'), $this->version, false );
    }

}
