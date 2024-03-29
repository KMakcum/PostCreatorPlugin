<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://test.com
 * @since      1.0.0
 *
 * @package    Post_Creator
 * @subpackage Post_Creator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Post_Creator
 * @subpackage Post_Creator/public
 * @author     Max One <test@gmail.com>
 */
class Post_Creator_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        add_action('wp_ajax_update_categories', [$this, 'update_categories_handler']);
        add_action('wp_ajax_nopriv_update_categories', [$this, 'update_categories_handler']);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/post-creator-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/post-creator-public.js', array( 'jquery' ), $this->version, false );

	}

    /**
     * Sorts terms into a hierarchy.
     *
     * @since    1.0.0
     */
    public function sort_terms_hierarchicaly( & $cats, & $into, $parentId = 0 ){
        foreach( $cats as $i => $cat ){
            if( $cat->parent == $parentId ){
                $into[ $cat->term_id ] = $cat;
                unset( $cats[$i] );
            }
        }

        foreach( $into as $top_cat ){
            $top_cat->children = [];
            $this->sort_terms_hierarchicaly( $cats, $top_cat->children, $top_cat->term_id );
        }
    }

    /**
     * Display all categories in a selector.
     *
     * @since    1.0.0
     */
    public function display_category_selector($post_type) {

        $args = array(
            'public'   => true,
            'object_type' => [$post_type],
        );

        $taxonomies = get_taxonomies( $args, 'names', 'and' );

        if (!empty($taxonomies['post_format'])) unset($taxonomies['post_format']);
        if (!empty($taxonomies['post_tag'])) unset($taxonomies['post_tag']);
        if (!empty($taxonomies['product_shipping_class'])) unset($taxonomies['product_shipping_class']);

        if (!empty($taxonomies)) {
            foreach ($taxonomies as $taxonomy) {
                if (!empty($taxonomy)) {
                    $categories = get_categories( [
                        'taxonomy'   => $taxonomy,
                        'hide_empty' => 0,
                    ] );

                    $cat_hierarchy = [];
                    $this->sort_terms_hierarchicaly( $categories, $cat_hierarchy );

                    $this->categories_hierarchy_list($cat_hierarchy);
                }
            }
        }
    }

    public function categories_hierarchy_list($cat_hierarchy){

        if (!empty($cat_hierarchy)) {
            echo '<ul style="padding-left: 15px">';
            foreach ($cat_hierarchy as $cat) {
                echo '<li>';
                    echo '<label>
                        <input type="checkbox" 
                        name="post_cats['. $cat->term_id .']"
                        value="'. $cat->term_id .'">
                        ' . $cat->name . '
                    </label>';

                $this->categories_hierarchy_list($cat->children);
                echo '</li>';
            }
            echo '</ul>';
        }
    }

    /**
     * Ajax handler update category
     *
     * @since    1.0.0
     */
    public function update_categories_handler(){
        $post_type = !empty($_POST['post_type']) ? $_POST['post_type'] : '';

        if (empty($post_type)) wp_send_json_error('Post type not found');

        ob_start();
        $this->display_category_selector($post_type);
        $new_categories_html = ob_get_clean();

        if (empty($new_categories_html)) wp_send_json_error('Not categories');

        wp_send_json_success( $new_categories_html, 200);

        die();
    }
}
