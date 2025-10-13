<?php
/**
 * Plugin Name: Turbo Addons Elementor
 * Plugin URI: https://turbo-addons.com/
 * Description: Turbo-Addons is towards limitless Elementor Addons with 85+ Elementor Free & Pro Widgets, including WooCommerce widgets, for easy customization.
 * Version: 1.8.2
 * Author: Turbo Addons
 * Author URI: https://wp-turbo.com/
 * License: GPLv3
 * License URI: https://opensource.org/licenses/GPL-3.0
 * Text Domain: turbo-addons-elementor
 * Elementor tested up to: 3.31.5
 * Elementor Pro tested up to: 3.31.3
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define the free version's constant...
if ( ! defined( 'TURBO_ADDONS_VERSION' ) ) {
    define( 'TURBO_ADDONS_VERSION', '1.8.2' ); // Update the version as necessary
}

/**
 * Main Plugin Class
 * @since 1.0.0
 */
final class TRAD_Turbo_Addons {

    const TRAD_TURBO_ADDONS_PLUGIN_VERSION = '1.8.2';
    const TRAD_TURBO_ADDONS_MIN_ELEMENTOR_VERSION = '3.0.0';
    const TRAD_TURBO_ADDONS_MIN_PHP_VERSION = '7.4';
    
    private static $_instance = null;

    /**
     * Singleton Instance Method
     * @since 1.0.0
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     * @since 1.0.0
     */
    public function __construct() {
        $this->define_constants();
        $this->call_main_file();
        // Include the helper file
        include_once plugin_dir_path(__FILE__) . 'helper/helper.php';
        include_once plugin_dir_path(__FILE__) . 'widgets/helper/helper.php';
        require_once plugin_dir_path(__FILE__) . 'helper/classes/helperClass.php';
        include_once plugin_dir_path(__FILE__) . 'helper/admin-info.php';
        add_action( 'wp_enqueue_scripts', 'trad_enqueue_scripts_styles' );
        add_action( 'elementor/editor/after_enqueue_scripts', [$this, 'trad_after_enqueue_scripts_styles'] );
        add_action( 'init', [ $this, 'trad_load_textdomain' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );
        add_action( 'elementor/editor/wp_head', [ $this, 'trad_editor_icon_enqueue_scripts' ] );
        // add_action( 'elementor/frontend/before_enqueue_styles', [$this, 'trad_add_turbo_icon'], 1 );
        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'trad_enqueue_panel_scripts' ], 999 );

        // Register activation and deactivation hooks for tracking
        register_activation_hook(__FILE__, [$this, 'trad_turbo_on_activation']);
        register_deactivation_hook(__FILE__, [$this, 'trad_turbo_on_deactivation']);

        // Hook into plugin upgrade process for tracking
        add_action('upgrader_process_complete', [$this, 'trad_turbo_on_upgrade'], 11, 2);
        // Check if Elementor is active
        if ( did_action( 'elementor/loaded' ) ) {
            register_activation_hook( __FILE__, [ $this, 'turbo_addons_elementor_activate' ] );
            add_action( 'admin_init', [ $this, 'handle_activation_redirect' ] );
        } else {
            add_action( 'admin_notices', [ $this, 'trad_admin_notice_missing_main_plugin' ] );
        } 
        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'trad_enqueue_warn_scripts' ] );     
    }

    /**
     * Define Plugin Constants
     * @since 1.0.0
     */
    private function define_constants() {
        define( 'TRAD_TURBO_ADDONS_PLUGIN_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
        define( 'TRAD_TURBO_ADDONS_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
        define( 'TRAD_TURBO_ADDONS_PLUGIN_VERSION', '1.8.2' );

        // Include the necessary plugin management functions if not already included
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        if ( ! function_exists( 'is_plugin_active' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $active_plugins = get_option( 'active_plugins' );
        $all_plugins = get_plugins();
        $pro_plugin_found = false; // Default to false

        foreach ( $active_plugins as $plugin_file ) {
            if ( isset( $all_plugins[ $plugin_file ] ) ) {
                $plugin = $all_plugins[ $plugin_file ];
                if ( $plugin['Name'] === 'Turbo Addons Elementor Pro' ) {
                    $pro_plugin_found = true;
                    break; // Exit the loop as soon as the plugin is found
                }
            }
        }

        define( 'TRAD_TURBO_ADDONS_PRO_PLUGIN_IS_ACTIVE', $pro_plugin_found );
    }

    public function trad_enqueue_warn_scripts() {
        wp_enqueue_style( 
            'trad-turbo-editor-warning-style',
            TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/editor-warning.css',
            [],
            filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/editor-warning.css' ),
            'all'
        );
    }

    // Register activation hook to redirect after plugin activation
    public function turbo_addons_elementor_activate() {
        // Set a transient to show the redirect
        set_transient( 'turbo_addons_activation_redirect', true, 30 ); // 30 seconds
    }

    public function handle_activation_redirect() {
        if ( get_transient( 'turbo_addons_activation_redirect' ) ) {
            delete_transient( 'turbo_addons_activation_redirect' ); // Clean up the transient
            wp_redirect( admin_url( 'admin.php?page=turbo_addons' ) ); // Redirect to the admin homepage
            exit; // Always exit after redirecting
        }
    }

    public function trad_editor_icon_enqueue_scripts() {
        wp_enqueue_style( 'trad-widget-icons', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/trad-icons/style.css', [], '1.0', '' );
    }


    /**
     * Enqueue Scripts & Styles
     * @since 1.0.0
     */

    public function trad_enqueue_panel_scripts() {
		wp_enqueue_script(
			'turbo-premium-promotion-script',
			TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/admin/editor.min.js',
			[ 'jquery'],
			TRAD_TURBO_ADDONS_PLUGIN_PATH,
			true
		); 
	}
    public function trad_after_enqueue_scripts_styles() {
        wp_register_style('trad-ent-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/vendor/ticker/css/ent-style.css', [], filemtime( TRAD_TURBO_ADDONS_PLUGIN_PATH . 'assets/css/vendor/ticker/css/ent-style.css' ), 'all' );
        wp_register_script( 'trad-ent-script', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/css/vendor/ticker/js/ent-script.min.js', ['jquery'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );

        // Custom JS
        wp_register_script( 'trad-news-ticker-init', TRAD_TURBO_ADDONS_PLUGIN_URL . 'assets/js/news-ticker.js', ['jquery'], TRAD_TURBO_ADDONS_PLUGIN_VERSION, true );
    }
    /**
     * Load Text Domain for Translations
     * @since 1.0.0
     */
    public function trad_load_textdomain() {
        load_plugin_textdomain( 'turbo-addons-elementor', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    /**
     * Initialize the plugin
     * @since 1.0.0
     */
    public function init() {
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'trad_admin_notice_missing_main_plugin' ] );
            return;
        }

        if ( ! version_compare( ELEMENTOR_VERSION, self::TRAD_TURBO_ADDONS_MIN_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'trad_admin_notice_minimum_elementor_version' ] );
            return;
        }

        if ( ! version_compare( PHP_VERSION, self::TRAD_TURBO_ADDONS_MIN_PHP_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'trad_admin_notice_minimum_php_version' ] );
            return;
        }

        require_once plugin_dir_path(__FILE__) . 'includes/call-admin-ajax.php';
        
        
        add_action( 'elementor/init', [ $this, 'trad_init_category' ] );
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'trad_init_widgets' ] );

        if (is_admin()) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
            if(did_action( 'elementor/loaded' )) {
                // Ensure the plugin.php file is included to use is_plugin_active 
                if ( ! $this->is_turbo_addons_elementor_pro_active() ) {
                    $this->custom_actions();
                    require_once plugin_dir_path(__FILE__) . 'admin/admin-page.php';
                }
            }else{
                add_action( 'admin_notices', [ $this, 'trad_admin_notice_missing_main_plugin' ] );
                return;
            }
            
        }

        //Template Library Logo ...............................................................................................................

		add_action('elementor/preview/enqueue_styles', [$this, 'trad_editor_preview_widget_styles']);


    }

    /**
     * Check if Turbo Addons Elementor Pro is active
     * @return bool
     */
    private function is_turbo_addons_elementor_pro_active() {
        return is_plugin_active( 'turbo-addons-elementor-pro/turbo-addons-elementor-pro.php' );
    }

    /**
     * Initialize Widgets
     * @since 1.0.0
     */
    public function trad_init_widgets() {
        // Retrieve the widget settings from the database
        $widgets = get_option('turbo_addons_widgets', []);
    
        // Define an array to map widget keys to their corresponding file paths
        $widget_files = get_widget_lists();

        if (empty($widgets)) {
            $widgets = [
                'advanced-heading',
                'contact-info',                                  
                'popular-post',            
                'preview-card',            
                'pricing-table',          
                'text-animation', 
                'icon-button',              
                'shape-divider', 
                'countdown-timer',      
                'social-bar',                 
                'review-star',               
                'most-top-bar',             
                'team-slider',              
                // 'fancy-card',                
                'fancy-alert',             
                'dual-header',               
                'info-box',                     
                'business-hour',           
                'carousel',                     
                'call-to-action',       
                'accordion',                 
                // 'tooltip',                      
                // 'accordion',                 
                'tooltip',                      
                'floating-effect',       
                'image-overlay-effects', 
                'food-menu', 
                'coupon-code',
                'single-testimonial',
                'data-table',
                'photo-stack',
                'debit-card',
                // 'icon_card',
                'image_icon_card',
                'copy-right-footer',
                'read-more',
                'google-map',
                'google-event-calender',
                'image-compare',
                'advance-search',
                'scroll-to-top',
                'scroll-navigation',
                // 'vision-card',
                'flipbook-img',
                'cookie-consent',
                'navigation-menu',
                'contact-form-7', 
                'logo-carousel',
                'counter',
                'news-ticker',
            ];
        }

        // Include each widget based on the stored settings
        foreach ($widget_files as $widget_key => $file) {
            if (in_array($widget_key, $widgets)) {
                require_once TRAD_TURBO_ADDONS_PLUGIN_PATH . 'widgets/' . $file;
            }
        }
    }
    
    // Premium Promotions

    /**
     * Initialize Category Section
     * @since 1.0.0
     */
    public function trad_init_category() {
        Elementor\Plugin::instance()->elements_manager->add_category(
            'turbo-addons',
            [
                'title' => esc_html__( 'Turbo Addons', 'turbo-addons-elementor' )
            ]
        );

        // Add Premium Widgets category in panel
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'trad-premium-widgets',
            [
                'title' => esc_html__( 'Turbo Premium Widgets', 'turbo-addons-elementor' ),
                'icon' => 'font',
            ]
        );
    }

    public function trad_promote_premium_widgets($config) {

        $config['promotionWidgets'] = [];

        // Get promotion widgets data from the helper function
        $promotion_widgets_data = get_promotion_widgets_data();
        $config['promotionWidgets'] = array_merge($config['promotionWidgets'], $promotion_widgets_data);

        // Additional expert widgets
        $expert_widgets_data = get_expert_widgets_data();
        $config['promotionWidgets'] = array_merge($config['promotionWidgets'], $expert_widgets_data);

        return $config;
    }

    protected function custom_actions() {
        // Promote Premium Widgets
        if ( current_user_can('administrator') ) {
            add_filter('elementor/editor/localize_settings', [$this, 'trad_promote_premium_widgets']);
        }
    }
    
    /**
     * Admin Notice for Missing Elementor
     * @since 1.0.0
     */
    public function trad_admin_notice_missing_main_plugin() {
        if ( isset( $_GET['activate'] ) && isset( $_GET['_wpnonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'turbo_addons_activate_nonce' ) ) {
            return; // Nonce verification failed
        }

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
            wp_kses_post( sprintf(
                /* translators: 1: Plugin name (Turbo Addons), 2: Dependency name (Elementor) */
                esc_html__( '"%1$s" requires %2$s to be installed and activated. Please install and activate %2$s to use all features of %1$s.', 'turbo-addons-elementor' ),
                '<strong>' . esc_html__( 'Turbo Addons', 'turbo-addons-elementor' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'turbo-addons-elementor' ) . '</strong>'
            ) )
        );
     }

    /**
     * Admin Notice for Minimum Elementor Version
     * @since 1.0.0
     */
    public function trad_admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) && isset( $_GET['_wpnonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'activate_plugin' ) ) {
            return; // Nonce verification failed
        }

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
            wp_kses_post( sprintf(
                /* translators: 1: Plugin name (Turbo Addons), 2: Dependency name (Elementor), 3: Minimum required Elementor version */
                esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'turbo-addons-elementor' ),
                '<strong>' . esc_html__( 'Turbo Addons', 'turbo-addons-elementor' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'turbo-addons-elementor' ) . '</strong>',
                esc_html( self::TRAD_TURBO_ADDONS_MIN_ELEMENTOR_VERSION )
            ) )
        );
    }

    /**
     * Send tracking data on plugin activation
     */
    public function trad_turbo_on_activation() {
        $this->trad_turbo_send_tracking_data_to_server('activated');
    }

    /**
     * Send tracking data on plugin deactivation
     */
    public function trad_turbo_on_deactivation() {
        $this->trad_turbo_send_tracking_data_to_server('deactivated');
    }

    /**
     * Send tracking data on plugin upgrade
     *
     * @param WP_Upgrader $upgrader_object Upgrader object.
     * @param array $options Upgrade options.
     */
    public function trad_turbo_on_upgrade($upgrader_object, $options) {
        if ($options['action'] === 'update' && $options['type'] === 'plugin') {
            // Get the list of plugins being updated
            if (isset($options['plugins']) && in_array(plugin_basename(__FILE__), $options['plugins'])) {
                $this->trad_turbo_send_tracking_data_to_server('updated');
            }
        }
    }

    /**
     * Send tracking data to Turbo Addons Usage Tracker
     *
     * @param string $status Tracking status (e.g., activated, deactivated, updated).
     */
    public function trad_turbo_send_tracking_data_to_server($status) {
        $secret_key = 'u_o_i_3_lZXl_czV'; // Change this to your unique key
        $data = array(
            'domain' => home_url(),
            'email' => get_option('admin_email'),
            'plugin_version' => self::TRAD_TURBO_ADDONS_PLUGIN_VERSION,
            'status' => $status,
        );

        // Send a POST request to the Turbo Addons Usage Tracker
        $response = wp_remote_post('https://turbo-addons.com/wp-json/turbo-addons/v1/track?secret_key=' . $secret_key, array(
            'body' => json_encode($data),
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
        ));
    }

    /**
     * Admin Notice for Minimum PHP Version
     * @since 1.0.0
     */
    public function trad_admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) && isset( $_GET['_wpnonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'activate_plugin' ) ) {
            return; // Nonce verification failed
        }

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        printf(
            '<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
            wp_kses_post( sprintf(
                /* translators: 1: Plugin name (Turbo Addons), 2: Software name (PHP), 3: Minimum required PHP version */
                esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'turbo-addons-elementor' ),
                '<strong>' . esc_html__( 'Turbo Addons', 'turbo-addons-elementor' ) . '</strong>',
                '<strong>' . esc_html__( 'PHP', 'turbo-addons-elementor' ) . '</strong>',
                esc_html( self::TRAD_TURBO_ADDONS_MIN_PHP_VERSION )
            ) )
        );

    }

	function trad_editor_preview_widget_styles()
	{
        wp_enqueue_style( 'trad-editor-prev-style', TRAD_TURBO_ADDONS_PLUGIN_URL . 'libs/lib/assets/css/trad-editor-style-preview.css', [], TRAD_TURBO_ADDONS_PLUGIN_VERSION, 'all');
	}

    /**
	 * Call base file
	 *
	 * Include  files 
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function call_main_file()
	{
		//............................................. Added Template Library .............................................
		require_once(TRAD_TURBO_ADDONS_PLUGIN_PATH . '/libs/lib/index.php');
	}
}

/**
 * Initializes the Plugin
 * @since 1.0.0
 */
function trad_turbo_addons() {
    return TRAD_Turbo_Addons::instance();
}

trad_turbo_addons();