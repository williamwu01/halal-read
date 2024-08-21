<?php
/**
 * halal functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package halal
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function halal_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on halal, use a find and replace
		* to change 'halal' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'halal', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'header' => esc_html__( 'Header Menu Location', 'halal' ),
			'footer-middle' => esc_html__( 'Footer - Middle side', 'halal' ),
			'footer-left' => esc_html__('Footer - Left Side', 'halal'),
			'footer-right' => esc_html__('Footer - Right Side', 'halal'),


		)
	);
	

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'halal_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'halal_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function halal_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'halal_content_width', 640 );
}
add_action( 'after_setup_theme', 'halal_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function halal_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'halal' ),
			'id'            => 'footer-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'halal' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer-subscribe', 'halal' ),
			'id'            => 'footer-subscribe',
			'description'   => esc_html__( 'Add widgets here.', 'halal' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'halal_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function halal_scripts() {
	wp_enqueue_style( 'halal-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'halal-style', 'rtl', 'replace' );

	wp_enqueue_script( 'halal-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if (is_front_page()) {
		wp_enqueue_style('swiper-styles', get_template_directory_uri() . '/css/swiper-bundle.css', array(), '11.0.6');
		wp_enqueue_script('swiper-scripts', get_template_directory_uri() . '/js/swiper-bundle.min.js', array('jquery'), '11.0.6', true);
		wp_enqueue_script('swiper-settings', get_template_directory_uri() . '/js/swiper-settings.js', array('swiper-scripts', 'jquery'), _S_VERSION, true);

		// Localize the script with the AJAX URL
		wp_localize_script('swiper-settings', 'swiper_home_params', array(
			'ajax_url' => admin_url('admin-ajax.php')
		));
	}
}
add_action( 'wp_enqueue_scripts', 'halal_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Customizer Post types.
 */
require get_template_directory() . '/inc/cpt-form.php';


function is_user_writer() {
	$user = wp_get_current_user();
	return in_array('writer', (array) $user->roles);
}

// Modify the Admin Query to Show Only Author's Posts
function show_only_writer_posts($query) {
	if (is_admin() && $query->is_main_query() && $query->get('post_type') == 'book') {
			if (!current_user_can('edit_others_posts') && is_user_writer()) {
					$query->set('author', get_current_user_id());
			}
	}
}
add_action('pre_get_posts', 'show_only_writer_posts');


// Restrict Posts to Only Author's Posts in the Admin Dashboard
function restrict_posts_for_writers($query) {
	if (!is_admin() && $query->is_main_query() && $query->get('post_type') == 'book') {
			if (!current_user_can('edit_others_posts') && is_user_writer()) {
					$query->set('author', get_current_user_id());
			}
	}
}
add_action('pre_get_posts', 'restrict_posts_for_writers');

function update_comments_table_schema() {
	global $wpdb;

	// Check if the column already exists
	$column_exists = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->prefix}comments LIKE 'rating'");

	if (empty($column_exists)) {
			// Add the new column
			$wpdb->query("ALTER TABLE {$wpdb->prefix}comments ADD COLUMN rating TINYINT(1) NULL");
	}
}
add_action('init', 'update_comments_table_schema');

// Load more books via AJAX

add_action('wp_footer', function() { if (!is_admin()) {



	// Put the popup code here 
	echo do_shortcode( '[popup type="click" open="referral" content="381"]' );
	echo do_shortcode( '[popup type="click" open="review" content="371"]' );
				
			}});
	add_action('wp_head', function() { ?> 
	
	<style>
	.blur-bg {
			inset: 0;
			z-index: 60;
			backdrop-filter: blur(0px);
		-webkit-backdrop-filter: blur(0px);
		position: fixed;
		pointer-events: none;
		transition: 200ms ease-in-out;
	}
	.blur-bg.active {
				backdrop-filter: blur(10px);
			-webkit-backdrop-filter: blur(10px);	
				 pointer-events: all;
			}	
	.modal {
	max-height: 85%;
	overflow: auto;
	position: fixed;
	top: 50%;
	left: 50%;
	box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
	transform: translate(-50%, calc(-50% - 100px));
	opacity: 0;
	z-index: 100;
	background: rgba(255, 255, 255, 0.9);
	border-radius: 3px;
	width: min(450px , 90%)
	transition: 200ms ease-in-out;
	pointer-events: none;
	}
	.modal.active {
		transform: translate(-50%, -50%);
		opacity: 1;
		pointer-events: all;	
	}
	.modal-header {
		padding: 5px 15px 0px 15px;
		margin: 0px 0px -12px 0px;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}
	.modal-title {
		font-size: 1.2rem;
	}
	.modal .close {
			cursor: pointer;
	}
	button.close-button {
	cursor: pointer;
	border: none;
	outline: none;
	background: none;
	font-size: 1.5rem;
	color: #9e9e9e;
	padding: 0;
	transition: all 0.5s ease;
	margin-right: -5px;
	}
	button.close-button:hover {
	color: black;
	}
	.modal-body {
		padding: 10px 15px;
	}
	.modal.hiden {
			display: none;
	}
	</style>
	 
	<script>
	class redPishiPopUp { 
			constructor(openType, Pclass, id) { 
			this.id = id;
			this.Pid = "a"+id;
			this.pop = '<div class="modal hiden" id="'+ this.Pid +'"> <div class="modal-header" > <div class="modal-title" ></div> <button class="close-button close" > &times; </button> </div> <div class="modal-body" ></div> </div>';	
			document.body.insertAdjacentHTML("beforeend", this.pop);
			this.bg = '<div class="blur-bg close"></div>';
			if ( !document.querySelector('.blur-bg') ) { document.body.insertAdjacentHTML("beforeend", this.bg); }
					this.Pclass = Pclass;
					this.Type = openType;
					if (this.Type == "click" ) {
							this.btnPopShow();
					} else if (this.Type == "time" ) {
							this.showTimePop();           
					}
		
		}
		
		closePopUp(e) {
				setTimeout( () => {      
					document.querySelector("#"+this.Pid+".active")?.classList.remove("active");
					document.querySelector(".blur-bg").classList.remove('active');
				} , e * 1000 ); }
	
				btnPopShow(){  
				document.querySelectorAll("."+this.Pclass).forEach((bot) => {
				bot.addEventListener("click", ()=>{
				document.querySelector("#"+this.Pid)?.classList.remove("hiden");
				setTimeout( () => { 
				document.querySelector("#"+this.Pid).classList.add("active");	
				this.settings();
			}, 100)
			})
			});
			}
		showTimePop(){
		let storage = sessionStorage.getItem(this.Pid) ? sessionStorage.getItem(this.Pid) : 0;
		if (storage > 1 ) return;
		setTimeout( () => {      
			document.querySelector("#"+this.Pid)?.classList.remove("hiden");
		} , 1000 );      
			setTimeout( () => {      
			document.querySelector("#"+this.Pid).classList.add("active");
			this.settings();			
			sessionStorage.setItem(this.Pid, parseInt(storage) + 1);			
		} , this.Pclass * 1000 );
		}
		settings(){
			const observer = new MutationObserver(list => {  this.closePopUp(6); observer.disconnect();});
			observer.observe(document.querySelector("#"+this.Pid+".active .modal-body"), {attributes: true, childList: true, subtree: true });
			[...document.querySelectorAll(".close")]?.forEach(  e => { e.addEventListener("click", e => { this.closePopUp(0) }) }, { once: true });
			document.querySelector(".blur-bg").classList.add('active');
			document.body.addEventListener('click', e => {
			if (!document.querySelector('.modal.active')?.contains(event.target)) {
			this.closePopUp(0);
		}}, { once: true })
	
			}
	}
	 
	</script> 
	<?php });
	add_shortcode( 'popup', 'popup_func' );
	function popup_func( $atts ) {
		$atts = shortcode_atts( array(
			'type' => 'time', 
			'open' => '3',
			'content' => '111',
		), $atts, 'popup' );
	
		$popup ='<script>new redPishiPopUp("'. $atts["type"] .'", "'. $atts["open"] .'", "'. $atts["content"] .'");</script>';
		$content = (!get_post_status($atts["content"])) ? "reusable block not found!" : apply_filters( 'the_content', get_post( $atts["content"] )->post_content);
		$insertContentScript = '<script>document.querySelector("#a'.$atts["content"].' div.modal-body").innerHTML = `'.$content.'`; </script>';	
		return "{$popup}{$insertContentScript}";	
	}	