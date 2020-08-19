# Speed Up Elementor

Simple snippet to manage JS, CSS and others to improve Elementor performance. Include WordPress improvements too.

Note: I will create a free plugin for WordPress directory with more options soon!

## How to use

You can create a simple plugin for WordPress with code or paste in `functions.php` in your theme.

For example in this snippet i used `is_front_page` for add all optimizations in your front page (home). You can edit all functions to add in other pages, or create others functions to add dynamic options for each page (recomended).

Specific in functions `remove_elementor_pro_js` and `remove_elementor_js` comment or remove dependences for dont load this JS, like:

```
public function remove_elementor_js () {

		if ( is_front_page() ) {

			wp_deregister_script( 'elementor-frontend' );

			wp_register_script(
        		'elementor-frontend',
        		ELEMENTOR_ASSETS_URL . 'js/frontend.min.js',
        		[
          		'elementor-frontend-modules',
          		//'elementor-dialog', //Just comment if you want dont load this JS in page
          		'elementor-waypoints',
          		'swiper',
          		'share-link',
        		],
        		ELEMENTOR_VERSION,
        		true
			);
		}
	}
```

**_Improtant: When you remove CSS and JS by Elementor you need understand if its required or not for your page. If you remove required script your page ir broke. Test each optimizations and check what you can remove._** 
