<?php
/**
 * Class used to create a new options page.
 * 
 * @package WP_Options_Page
 * @author Mikael Fourré
 * @version 1.0.0
 * @see https://github.com/FmiKL/wp-options-page
 */
class Option_Page {
    /**
     * Path to the assets.
     * 
     * @var string
     * @since 1.0.0
     * @see Option_Page::enqueues_scripts()
     */
    private const ASSETS_PATH = '/wp-options-page/assets';

    /**
     * Title of the page.
     * 
     * @var string
     * @since 1.0.0
     */
    private $title;

    /**
     * Unique identifier needed to register the settings.
     * 
     * @var string
     * @since 1.0.0
     */
    private $key;

    /**
     * Fields to create.
     * 
     * @var array<string, array>
     * @since 1.0.0
     * @see Option_Page::add_field()
     */
    private $fields = array();

    /**
     * @param string $title Title of the page.
     * @param string $key   Unique identifier needed to register the settings.
     * @since 1.0.0
     */
    public function __construct( $title, $key ) {
        $this->title = $title;
        $this->key   = $key;
        $this->add_hooks();
    }

    /**
     * Adds hooks the methods to the appropriate actions.
     * 
     * @since 1.0.0
     */
    private function add_hooks() {
        add_action( 'admin_menu', array( $this, 'add_page' ) );
        add_action( 'admin_init', array( $this, 'register_setting' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueues_scripts' ) );
    }

    /**
     * Adds a new field.
     * 
     * @param string $type    Type of the field.
     * @param string $name    Name of the field.
     * @param array  $options Additional options for the field. Can include label and placeholder.
     *                        If the placeholder contains a reserved word (e.g., "image", "avatar" or "icon"),
     *                        a double-click will trigger the WordPress media library to open directly.
     *                        If the placeholder contains an indication of an image size "{size}px", the selected image will be the one closest to this size.
     * @since 1.0.0
     */
    public function add_field( $type, $name, $options = array() ) {
        $types = array( 'type' => $type );
        $this->fields[ $name ] = array_merge( $types, $options );
    }

    /**
     * Adds a page to the WordPress admin area.
     * 
     * @since 1.0.0
     * @link https://developer.wordpress.org/reference/functions/add_options_page/
     */
    public function add_page() {
        add_options_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'render_form' ) );
    }

    /**
     * Renders the form for the options page.
     * 
     * @since 1.0.0
     */
    public function render_form() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( $this->title ); ?></h1>
            <form method="post" action="options.php">
                <?php settings_fields( $this->key ); ?>
                    <table class="form-table" role="presentation">
                        <tbody>
                        <?php foreach ( $this->fields as $name => $field ) : ?>
                        <tr>
                        <th scope="row">
                            <?php if ( ! empty( $field['label'] ) ) : ?>
                                <label for="<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $field['label'] ); ?></label>
                            <?php endif; ?>
                        </th>
                        <td>
                            <?php if ( $field['type'] === 'checkbox' ) : ?>
                                <input
                                    type="checkbox"
                                    id="<?php echo esc_attr( $name ); ?>"
                                    name="<?php echo esc_attr( $name ); ?>"
                                    value="1"
                                    <?php checked( 1, get_option( $name ), true ); ?>
                                >
                            <?php else: ?>
                                <input
                                    type="<?php echo esc_attr( $field['type'] ?? 'text' ); ?>" 
                                    id="<?php echo esc_attr( $name ); ?>" 
                                    class="regular-text"
                                    name="<?php echo esc_attr( $name ); ?>" 
                                    value="<?php echo esc_attr( get_option( $name ) ); ?>"
                                    placeholder="<?php echo esc_attr( $field['placeholder'] ?? '' ); ?>"
                                >
                            <?php endif; ?>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Enqueues the necessary scripts.
     * 
     * @since 1.0.0
     */
    public function enqueues_scripts() {
        wp_enqueue_media();

        if ( ! wp_script_is( 'field-media', 'registered' ) ) {
            wp_enqueue_script( 'field-media', get_template_directory_uri() . self::ASSETS_PATH . '/js/field-media.js', array(), false, true );
        }
    }

    /**
     * Registers the settings.
     * 
     * @since 1.0.0
     * @link https://developer.wordpress.org/reference/functions/register_setting/
     */
    public function register_setting() {
        foreach ( $this->fields as $name => $field ) {
            register_setting( $this->key, $name, array(
                'sanitize_callback' => function ( $input ) use ( $name ) {
                    if ( empty( $input ) ) {
                        delete_option( $name );
                        return false;
                    }
                    return $input;
                }
            ) );
        }
    }
}
