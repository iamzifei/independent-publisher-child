<?php

/*
 * You can add your own functions here. You can also override functions that are
 * called from within the parent theme. For a complete list of function you can
 * override here, please see the docs:
 *
 * https://github.com/raamdev/independent-publisher#functions-you-can-override-in-a-child-theme
 *
 */


/*
 * Uncomment the following to add a favicon to your site. You need to add favicon
 * image to the images folder of Independent Publisher Child Theme for this to work.
 */
/*
function blog_favicon() {
  echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/images/favicon.ico" />' . "\n";
}
add_action('wp_head', 'blog_favicon');
*/

/*
 * Add version number to main style.css file with version number that matches the
 * last modified time of the file. This helps when making frequent changes to the
 * CSS file as the browser will always load the newest version.
 */
/*
function independent_publisher_stylesheet() {
	wp_enqueue_style( 'independent-publisher-style', get_stylesheet_uri(), '', filemtime( get_stylesheet_directory() . '/style.css') );
}
*/

/*
 * Modifies the default theme footer.
 * This also applies the changes to JetPack's Infinite Scroll footer, if you're using that module.
 */
/*
function independent_publisher_footer_credits() {
	$my_custom_footer = 'This is my custom footer.';
	return $my_custom_footer;
}
*/

/**
 * Return true if show fixed nav on home page
 */
function independent_publisher_show_fix_nav_on_home() {
    	$independent_publisher_general_options = get_option( 'independent_publisher_general_options' );
	if ( isset( $independent_publisher_general_options['show_fixed_nav_menu_on_home'] ) && $independent_publisher_general_options['show_fixed_nav_menu_on_home'] ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Show fixed navigation menu on the home page
 */

if ( ! function_exists( 'independent_publisher_fixed_nav' ) ) :
	/**
	 * Outputs fixed nav for display on home page
	 *
	 * @since Independent Publisher 1.0
	 */
	function independent_publisher_fixed_nav() {
		/**
		 * This function gets called outside the loop (in header.php),
		 * so we need to figure out the post author ID and Nice Name manually.
		 */
		global $wp_query;
		$post_author_id = $wp_query->post->post_author;
		?>
                <a class="blog-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<?php echo get_avatar( get_the_author_meta( 'ID', $post_author_id ), 38 ); ?>
		</a>
                <a class="subscribe-button icon-feed" href="<?php echo esc_url( home_url( '/' ) ); ?>rss/"><i class="fa fa-rss"></i><?php _e('Subscribe', 'independent-publisher'); ?></a>
	<?php
	}
endif;

/**
 * Overwrite the output for site info on home page header
 */

if ( ! function_exists( 'independent_publisher_site_info' ) ) :
	/**
	 * Outputs site info for display on non-single pages
	 *
	 * @since Independent Publisher 1.0
	 */
	function independent_publisher_site_info() {
		?>
                    <div class="vertical">
                        <div class="site-head-content inner">
                            <h1 class="blog-title"><?php bloginfo( 'name' ); ?></h1>
                            <h2 class="blog-description"><?php bloginfo( 'description' ); ?></h2>
                        </div>
                    </div>
                
		<?php get_template_part( 'menu', 'social' ); ?>
                <a class="scroll-down animated bounce" href="#content"><i class="fa fa-angle-down fa-2x"></i></a>
	<?php
	}
endif;

/**
 * Register fixed navigation menu on home page settings
 */

add_action( 'customize_register', 'independent_publisher_show_fixed_nav' );

function independent_publisher_show_fixed_nav($wp_customize){
                 // Show Nav Menu on Single Posts
		$wp_customize->add_setting(
					 'independent_publisher_general_options[show_fixed_nav_menu_on_home]', array(
							 'default'    => false,
							 'type'       => 'option',
							 'capability' => 'edit_theme_options',
							 'sanitize_callback' => 'independent_publisher_sanitize_checkbox',
						 )
		);
		$wp_customize->add_control(
					 'show_fixed_nav_menu_on_home', array(
							 'settings' => 'independent_publisher_general_options[show_fixed_nav_menu_on_home]',
							 'label'    => __( 'Show Fixed Nav Menu on Home', 'independent-publisher' ),
							 'section'  => 'independent_publisher_general_options',
							 'type'     => 'checkbox',
						 )
		);
                
}

/**
 * Change default size of custom header image
 */

function independent_publisher_custom_header_setup_mod() {
	$args = array(
		'default-image'          => independent_publisher_get_default_header_image(),
		'width'                  => 2560,
		'height'                 => 1600,
		'flex-width'             => true,
		'flex-height'            => true,
		'header-text'            => false,
		'default-text-color'     => '',
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);

	$args = apply_filters( 'independent_publisher_custom_header_args', $args );

	add_theme_support( 'custom-header', $args );

}

add_action( 'after_setup_theme', 'independent_publisher_custom_header_setup_mod' );

/**
 * Add awesome font into head
 */
function independent_publisher_extra_assets() {
    echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/font-awesome/css/font-awesome.min.css">' . "\n";
    echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/css/animation.min.css">' . "\n";
    echo '<script type="text/javascript" src="'.get_stylesheet_directory_uri().'/js/util.js"></script>' . "\n";
}
add_action('wp_head', 'independent_publisher_extra_assets');

/**
 * Overwrite wordcount for Chinese
 */
define("WORD_COUNT_MASK", "/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}]*/u");

function str_word_count_utf8($string, $format = 0)
{
    $string =  $string = preg_replace("/～|！|｀|·|＃|￥|％|…|—|（|）|＋|－|＝|｛|｝|［|］|\＼|｜|“|”|’|‘|；|：|《|》|〈|〉|、|？|。|，/",' ',$string);
    $string = preg_replace('/[\x80-\xff]{3}/', ' a ', $string);
    switch ($format) {
    case 1:
        preg_match_all(WORD_COUNT_MASK, $string, $matches);
        return $matches[0];
    case 2:
        preg_match_all(WORD_COUNT_MASK, $string, $matches, PREG_OFFSET_CAPTURE);
        $result = array();
        foreach ($matches[0] as $match) {
            $result[$match[1]] = $match[0];
        }
        return $result;
    }
    return preg_match_all(WORD_COUNT_MASK, $string, $matches);
}

function mtw_string_wordcount($instring) {
    if ( function_exists('str_word_count_utf8') ) {
        return str_word_count_utf8(strip_tags($instring));
    } else {
        return count(explode(" ",strip_tags($instring)));
    }
}

if ( ! function_exists( 'independent_publisher_post_word_count' ) ):
	/**
	 * Returns number of words in a post
	 * @return string
	 */
	function independent_publisher_post_word_count() {
		global $post;
		$content = get_post_field( 'post_content', $post->ID );
		$count   = mtw_string_wordcount($content);

		return number_format( $count );
	}
endif;





if ( ! function_exists( 'independent_publisher_posted_author_cats' ) ) :
	/**
	 * Prints HTML with meta information for the current author and post categories.
	 *
	 * Only prints author name when Multi-Author Mode is enabled.
	 *
	 * @since Independent Publisher 1.0
	 */
	function independent_publisher_posted_author_cats() {

		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'independent-publisher' ) );

		if ( ( ! post_password_required() && comments_open() && ! independent_publisher_hide_comments() ) || ( ! post_password_required() && independent_publisher_show_post_word_count() && ! get_post_format() ) || independent_publisher_show_date_entry_meta() ) {
			$separator = apply_filters( 'independent_publisher_entry_meta_separator', '|' );
		} else {
			$separator = '';
		}

		if ( independent_publisher_is_multi_author_mode() ) :
			if ( $categories_list && independent_publisher_categorized_blog() ) :
				echo '<span class="cat-links">';
				printf(
					'<a href="%1$s" title="%2$s">%3$s</a> %4$s %5$s',
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_attr( sprintf( __( 'View all posts by %s', 'independent-publisher' ), get_the_author() ) ),
					esc_html( get_the_author() ),
					independent_publisher_entry_meta_category_prefix(),
					$categories_list
				);
				echo '</span> <span class="sep"> ' . $separator . '</span>';
			else :
				echo '<span class="cat-links">';
				printf(
					'%1$s <a href="%2$s" title="%3$s">%4$s</a>',
					'',
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_attr( sprintf( __( 'View all posts by %s', 'independent-publisher' ), get_the_author() ) ),
					esc_html( get_the_author() )
				);
				echo '</span>';
			endif; // End if categories
		else : // not Multi-Author Mode
			if ( $categories_list && independent_publisher_categorized_blog() ) :
				echo '<span class="cat-links">';
				printf(
					'%1$s %2$s',
					independent_publisher_entry_meta_category_prefix(),
					$categories_list
				);
				echo '</span> <span class="sep"> ' . $separator . '</span>';
			else :
				echo '<span class="cat-links">';
				echo '</span>';
			endif; // End if categories
		endif; // End if independent_publisher_is_multi_author_mode()
                // get post tags
                $posttags = get_the_tags();
                if ($posttags) {
                    $prefix = '';
                    echo __(' on ', 'independent-publisher');
                    foreach($posttags as $tag) {
                        echo $prefix . '<a href="'. get_tag_link($tag->term_id).'">'.$tag->name.'</a>';
                        $prefix = ', ';
                    }
                }
                echo '<span class="sep"> ' . $separator . '</span>';
	}
endif;