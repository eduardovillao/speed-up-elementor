<?php 

class Speed_Elementor_Optimize {

	public function __construct () {

		////Remove google fontes from elementor
		add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
    
		add_action( 'wp_enqueue_scripts', [$this, 'dequeue_if_home_page'], 999999 );
		add_action( 'init', [$this, 'disable_wp_emojis'] );
		add_action( 'elementor/frontend/after_register_styles', [$this, 'remove_font_awesome_elementor'], 20 );
    add_action( 'elementor/frontend/after_register_scripts', [$this, 'remove_elementor_js'], 20 );
    add_action( 'wp_enqueue_scripts', [ $this, 'remove_elementor_pro_js' ], 20 );
    add_action( 'elementor/frontend/after_enqueue_styles', [$this, 'remove_style_elementor'], 20 );
		add_action( 'wp_default_scripts', [$this, 'remove_wp_jquery_migrate'] );
		add_filter( 'style_loader_src', [$this, 'remove_cssjs_ver'], 999999, 2 );
		add_filter( 'script_loader_src', [$this, 'remove_cssjs_ver'], 999999, 2 );
	}


	/**
	 * 
	 * Remove CSS and JS if is front page (home)
   *
	 * you can change page or what scripts remove, its just a example
   *
	 */

	public function dequeue_if_home_page () {

	    if ( is_front_page() ) {
      
        ////Remove Elementor icons if you dont use
			  wp_deregister_style( 'elementor-icons' );
          
        ////Remove Dashicons if not logged user
	      wp_dequeue_style( 'dashicons' );
                    
        ////Remove WordPress Block Library if you dont use
        wp_dequeue_style( 'wp-block-library' );
          
        ////Remove WordPress Block Library theme if you dont use
			  wp_dequeue_style( 'wp-block-library-theme' );
	    }
	}
  
  
  /**
	 * 
	 * Remove Elementor JS
   *
	 * improtant: this remove defaults Elementor JS and some its
   * required for each function. Disabe each and test for dont 
   * broke your website functions
   *
	 */

	public function remove_elementor_js () {

		if ( is_front_page() ) {

		  wp_deregister_script( 'elementor-frontend' );

		  wp_register_script(
        'elementor-frontend',
        ELEMENTOR_ASSETS_URL . 'js/frontend.min.js',
        [
          'elementor-frontend-modules',
          //'elementor-dialog', //Just comment if you want remove
          'elementor-waypoints',
          //'swiper', //Example: disable if you dont use slider os others similars in your page
          //'share-link',
        ],
        ELEMENTOR_VERSION,
        true
			);
		}
	}
  
  
    /**
	 * 
	 * Remove Elementor PRO JS
   *
	 * improtant: this remove defaults Elementor PRO JS and some its
   * required for each function. Disabe each and test for dont 
   * broke your website functions
   *
	 */

	public function remove_elementor_pro_js () {

		if ( is_front_page() ) {

			wp_deregister_script( 'elementor-pro-frontend' );

			wp_enqueue_script(
		    'elementor-pro-frontend',
		    ELEMENTOR_PRO_URL . 'assets/js/frontend.min.js',
		    [
		    'elementor-frontend-modules',
		    //'elementor-sticky', ////Remove if you dont use element sticky in your page
		    ],
		    ELEMENTOR_PRO_VERSION,
		    true
			);
		}
	}
  
  
  /**
	 * 
	 * Remove Font Awesome icons by Elementor
   *
	 * Important: this remove all font awesome icons from Elementor
   * use SVG icons for best performance
   *
	 */

	public function remove_font_awesome_elementor () {

		foreach( [ 'solid', 'regular', 'brands' ] as $style ) {
			wp_deregister_style( 'elementor-icons-fa-' . $style );
		}
	}
  
  
  /**
	 * 
	 * Remove others Elementor styles
   *
	 * Important: this remove defaults styles from Elementor
   * Disabe each and test for dont broke your website functions
   *
	 */

	public function remove_style_elementor () {

		//wp_dequeue_style( 'elementor-animations' ); //Example: disable if you dont use animations in you page
		wp_dequeue_style( 'elementor-frontend' );
	}


	/**
	 * 
	 * Disable WordPress emojis 
	 * 
	 */

	public function disable_wp_emojis () {

		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	}


	/**
	 * 
	 * Remove jQuery migrate from WordPress
	 * 
	 */ 

	public function remove_wp_jquery_migrate ($scripts) {

	    if (!is_admin() && isset($scripts->registered['jquery'])) {
	      $script = $scripts->registered['jquery'];
	        
	      if ($script->deps) {
	        $script->deps = array_diff($script->deps, array(
	          'jquery-migrate'
	        ));
	      }
	    }
	}
  

	/**
	 * 
	 * Remove WordPress query strings
	 * 
	 */ 

	public function remove_cssjs_ver ($src) {

		if( strpos( $src, '?ver=' ) ) {

			$src = remove_query_arg( 'ver', $src );
			return $src;
		}
	}
  
}

new Speed_Elementor_Optimize;
