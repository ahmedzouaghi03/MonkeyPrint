<?php
namespace Templately\Core\Platform;

use Templately\API\Import;
use Templately\Core\Importer\Utils\GutenbergHelper;
use Templately\Core\Platform;
use Templately\Core\Module;
use Templately\Utils\Helper;

use WP_Error;
use function get_permalink;
use function get_edit_post_link;
use function wp_insert_post;
use function wp_slash;
use function wp_unslash;
use function json_decode;

class Gutenberg extends Platform {
    /**
     * Platform ID
     * @var string
     */
    private $id = 'gutenberg';

    /**
     * Is gutenberg is active or not
     * @var boolean
     */
    public $is_gutenberg_active = false;

    /**
     * Initializing the platform and add it to module.
     */
    public function __construct(){
        Module::get_instance()->add( (object) [
            'id' => $this->id,
            'object' => $this
        ]);

        $this->hooks();
    }

    /**
     * Initializing Hooks
     * @return void
     */
    public function hooks(){
        add_action( 'enqueue_block_editor_assets', [ $this, 'scripts' ] );
        add_action( 'admin_footer', [ $this, 'print_admin_js_template' ] );
    }

    /**
     * Assets Enqueueing
     * @return void
     */
    public function scripts(){
        $this->is_gutenberg_active = true;
        templately()->assets->enqueue( 'templately-gutenberg', 'css/gutenberg.css' );
        templately()->assets->enqueue( 'templately-gutenberg', 'js/gutenberg.js' );
        templately()->admin->scripts( 'gutenberg' );
    }

    /**
     * 	Templately Button and Wrapper for Gutenberg
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function print_admin_js_template() {
        if ( ! $this->is_gutenberg_active ) {
            return;
        }
        $post_type = apply_filters( 'templately_cloud_push_post_type', get_post_type());

        ?>
        <div id="templately-gutenberg"></div>
        <script id="templately-gutenberg-button-switch-mode" type="text/html">
            <div id="templately-gutenberg-buttons">
                <button id="templately-gutenberg-button" type="button" class="button button-primary button-large gutenberg-add-templately-button">
                    <i class="templately-icon" aria-hidden="true"></i>
                    <?php echo esc_html__( 'Templately', 'templately' ); ?>
                </button>
                <button id="templately-cloud-push" type="button" class="button button-primary button-large">
                    <i class="templately-cloud-icon" aria-hidden="true"></i>
                    <?php echo sprintf( __( 'Save %s in Templately', 'templately' ), $post_type ); ?>
                </button>
            </div>
        </script>
        <?php
    }

    /**
     * Determine Active UI Theme
     * @return string
     */
    public function ui_theme(){
        return 'light';
    }

    /**
     * Creating a gutenberg page
     *
     * @param integer $id
     * @param string $title
     * @param Import $importer
     *
     * @since 2.0.0
     *
     * @return array|WP_Error array on success, WP_Error on failure.
     */
	public function create_page( $id, $title, $importer = null ){
		$post_data = $inserted_ID = $importer->get_content( $id, 'gutenberg' );

		if( is_wp_error( $inserted_ID ) ) {
			return $inserted_ID;
		}

		if ( ! empty( $inserted_ID['content'] ) ) {
			$inserted_ID = wp_insert_post( array (
				'post_status'  => 'draft',
				'post_type'    => 'page',
				'post_title'   => $title,
				'post_content' => wp_slash($inserted_ID['content']),
			) );
		}

		if ( is_wp_error( $inserted_ID ) ) {
			return Helper::error(
				'import_failed',
				$inserted_ID->get_error_message(),
				'import/page',
				$inserted_ID->get_error_code()
			);
		}

		if($inserted_ID){
			$post_data 	  = $this->process_images($post_data, $inserted_ID);

			// Update the post content with the processed images
			$updated_post = array(
				'ID'           => $inserted_ID,
				'post_content' => wp_slash($post_data['content']),
			);
			wp_update_post($updated_post);
		}

		return [
			'post_id'             => $inserted_ID,
			'edit_link'           => get_edit_post_link( $inserted_ID, 'internal' ),
			'visit'               => get_permalink( $inserted_ID )
		];
	}

    /**
     * Inserts a template into the Gutenberg editor.
     *
     * @param mixed $data
     * @param int $postId
     * @return array
     */
    public function insert($data, $postId = 0) {
        $data = $this->process_images($data, $postId);
        return $data;
    }

    /**
     * Inserts a template into the Gutenberg editor.
     *
     * @param mixed $data
     * @param int $postId
     * @return array
     */
    public function process_images($data, $postId = 0) {
        // Instantiate GutenbergHelper
        $helper = new GutenbergHelper();

        // Organize URLs from the content
        $organizedUrls = $helper->parse_images($data['content']);

        // Define template settings
        $template_settings = [
            'post_id'       => $postId,
            '__attachments' => $organizedUrls,
        ];

        // Map post IDs and disable logging
        $helper->map_post_ids[$postId] = $postId;
        $helper->shouldLog = false;

        // Prepare the helper with the data and settings
        $helper->prepare($data, $template_settings);

        // Update the content in the data array
        $data['content'] = wp_unslash($helper->get_content());

        return $data;
    }
}