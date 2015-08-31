<?php
/**
 * Plugin Name.
 *
 * @package   Text_Inserts
 * @author    Roosdoring Inc <roosdoring@hotmail.com>
 * @license   GPL-2.0+
 * @link      http://www.thephysicalaffiliate.com/
 * @copyright 2014 Roosdoring Inc
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-text-inserts-admin.php`
 * @package Text_Inserts
 * @author  Your Name <email@example.com>
 */
class Text_Inserts {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'text-inserts';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/* Define custom functionality.
		 * Refer To http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */

		// prepare the hook/content boxes
		$hook_boxes = json_decode( get_option( 'txtins_hook_boxes' ) );
		$content_boxes = json_decode( get_option( 'txtins_content_boxes' ) );
		$hb_count = count($hook_boxes);
		$cb_count = count($content_boxes);

		// add hook actions
		if ($hb_count > 0) {
			for ($i = 0; $i < $hb_count; $i++) {
				if ($hook_boxes[$i]->enabled) {
					$txt = $hook_boxes[$i]->text;
                    $display = $hook_boxes[$i]->display;
                    $filtering = $hook_boxes[$i]->filtering;
                    $filtered_list = $hook_boxes[$i]->filtered_list;
					add_action($hook_boxes[$i]->hook, function() use($txt, $display, $filtering, $filtered_list) {
                        global $post;
                        
                        $categories = get_the_category( $post->ID );
                        $catid = $categories[0] -> cat_ID;
                        
                        $ids = explode( ',', str_replace( ' ', '', $filtered_list ) );
                        
                        $post_ids = array();
                        $cat_ids = array();
                        
                        for ( $x = 0, $len = count( $ids ); $x < $len; $x++ ) {
                            if ( $ids[$x][0] === 'c' ) {
                                array_push( $cat_ids, substr( $ids[$x], 1 ) );
                            }
                            else {
                                array_push( $post_ids, $ids[$x] );
                            }
                        }
                        
                        $display_ok = false;
                        $filtering_ok = false;
                        
                        switch ( $display ) {
                            case 1:
                                $display_ok = is_single() || is_page();
                                break;
                            case 2:
                                $display_ok = is_single();
                                break;
                            case 3:
                                $display_ok = is_page();
                                break;
                            case 4:
                                $display_ok = is_home();
                                break;
                            case 5:
                                $display_ok = true;
                                break;
                        }
                        
                        $pi_ok = true;
                        $ci_ok = true;
                        
                        switch ( $filtering ) {
                            case 1:
                                $filtering_ok = true;
                                break;
                            case 2:
                                // exclude all except
                                if ( count( $post_ids ) > 0 ) {
                                    $pi_ok = in_array( $post->ID, $post_ids ); 
                                }
                                
                                if ( count( $cat_ids ) > 0 ) {
                                    $ci_ok = in_array( $catid , $cat_ids );
                                }
                                
                                $filtering_ok = $pi_ok || $ci_ok;
                                break;
                            case 3:
                                // include all except
                                if ( count( $post_ids ) > 0 ) {
                                    $pi_ok = !in_array( $post->ID, $post_ids ); 
                                }
                                
                                if ( count( $cat_ids ) > 0 ) {
                                    $ci_ok = !in_array( $catid, $cat_ids );
                                }
                                
                                $filtering_ok = $pi_ok && $ci_ok;
                                break;
                        }
                        
                        if ( $display_ok && $filtering_ok ) {
                            echo urldecode($txt);
                        }
					}, $hook_boxes[$i]->priority );
				}
			}
		}

		// add content filters
		if ($cb_count > 0) {
			for ($i = 0; $i < $cb_count; $i++) {
				if ($content_boxes[$i]->enabled) {
					$txt = urldecode($content_boxes[$i]->text);
					$display = $content_boxes[$i]->display;
                    $filtering = $content_boxes[$i]->filtering;
                    $filtered_list = $content_boxes[$i]->filtered_list;
					$method = $content_boxes[$i]->method;
					$position = $content_boxes[$i]->position;
					add_filter('the_content', function($content) use($txt, $display, $method, $position, $filtering, $filtered_list) {
                        global $post;
                        
                        $categories = get_the_category( $post->ID );
                        $catid = $categories[0] -> cat_ID;
                        
                        $ids = explode( ',', str_replace( ' ', '', $filtered_list ) );
                        
                        $post_ids = array();
                        $cat_ids = array();
                        
                        for ( $x = 0, $len = count( $ids ); $x < $len; $x++ ) {
                            if ( $ids[$x][0] === 'c' ) {
                                array_push( $cat_ids, substr( $ids[$x], 1 ) );
                            }
                            else {
                                array_push( $post_ids, $ids[$x] );
                            }
                        }
                        
                        $display_ok = false;
                        $filtering_ok = false;
                        
                        switch ( $display ) {
                            case 1:
                                $display_ok = is_single() || is_page();
                                break;
                            case 2:
                                $display_ok = is_single();
                                break;
                            case 3:
                                $display_ok = is_page();
                                break;
                        }
                        
                        $pi_ok = true;
                        $ci_ok = true;
                        
                        switch ( $filtering ) {
                            case 1:
                                $filtering_ok = true;
                                break;
                            case 2:
                                // exclude all except
                                if ( count( $post_ids ) > 0 ) {
                                    $pi_ok = in_array( $post->ID, $post_ids ); 
                                }
                                
                                if ( count( $cat_ids ) > 0 ) {
                                    $ci_ok = in_array( $catid , $cat_ids );
                                }
                                
                                $filtering_ok = $pi_ok || $ci_ok;
                                break;
                            case 3:
                                // include all except
                                if ( count( $post_ids ) > 0 ) {
                                    $pi_ok = !in_array( $post->ID, $post_ids ); 
                                }
                                
                                if ( count( $cat_ids ) > 0 ) {
                                    $ci_ok = !in_array( $catid, $cat_ids );
                                } 
                                
                                $filtering_ok = $pi_ok && $ci_ok;
                                break;
                        }

                        if ( $display_ok && $filtering_ok ) {
                            $this->insert_text_html_to_content($txt, $method, $position, $content);
                        }

						return $content;

					}, $content_boxes[$i]->priority);
				}
			}
		}

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
	}

	// auxilliary function, returns closing paragraph tag positions
	public function get_closing_ptag_positions($source) {
	    $positions = array();
	    $offset = 0;

	    do {
	        $pos = strpos($source, '</p>', $offset);
	        if ($pos !== false) {
	            array_push($positions, $pos);
	            $offset = $pos + 1;
	        }
	    } while ($pos !== false);
	    
	    return $positions;
	}

	public function insert_text_html_to_content($txt, $method, $position, &$content) {
		switch ($method) {
			case 1:
				// after nth paragraph
				// Get the closing paragraph tag positions and store them in an array.
				$p_close_tag_positions = $this->get_closing_ptag_positions($content);

		        // Determine which nth paragraph to insert after.
		        $p_count = count($p_close_tag_positions);

		        // Check if there are any paragraphs at all, do nothing if none
		        if ($p_count == 0) { break; }

		        // If there are paragraphs, determine if set position exceeds max number of paragraphs, if yes, insert it after the last </p>
		        $nth_p = $p_count < $position ? $p_count - 1 : $position - 1;

		        // Get insertion position from paragraph closing tag positions array.
		        $insert_pos = $p_close_tag_positions[$nth_p] + 4;

		        // Insert txt/html in specified position.
		        $content = substr_replace($content, $txt, $insert_pos, 0);
				break;
			case 2:
				// after % of total paragraphs
				// Get the closing paragraph tag positions and store them in an array.
				$p_close_tag_positions = $this->get_closing_ptag_positions($content);

		        // Determine which nth paragraph to insert after.
		        $p_count = count($p_close_tag_positions);

		        // Check if there are any paragraphs at all, do nothing if none
		        if ($p_count == 0) { break; }

		        // If there are paragraphs, determine position based on percentage
		        $nth_p = ceil($p_count * ($position / 100)) - 1;

		        // Get insertion position from paragraph closing tag positions array.
		        $insert_pos = $p_close_tag_positions[$nth_p] + 4;

		        // Insert txt/html in specified position.
		        $content = substr_replace($content, $txt, $insert_pos, 0);
				break;
			case 3:
				// at position
				switch ($position) {
					case 1:
						// before content
						$content = $txt . $content;
						break;
					case 2:
						// after content
						$content = $content . $txt;
						break;
					case 3:
						// before first paragraph
						// get first <p> position
						$ppos = strpos($content, '<p>');

						if ($ppos !== false) {
							$content = substr_replace($content, $txt, $ppos, 0);
						}
						break;
					case 4:
						// after last paragraph
						// get first </p> position
						$ppos = strrpos($content, '</p>');

						if ($ppos !== false) {
							$content = substr_replace($content, $txt, $ppos + 4, 0);
						}
						break;
					default:
						break;
				}
				break;
			default:
				break;
		}
	}
}
