<?php
require get_template_directory() . '/inc/wpscripts.php';
require get_template_directory() . '/inc/themefeature.php';
require get_template_directory() . '/inc/blog_theme_options.php';
require get_template_directory() . '/inc/wsne-general-functions.php';




// old functions

function show_new_comments( $post_ID ) {
	$comments_unapproved = get_comments(
		array(
			'status'  => 'hold',
			'post_id' => $post_ID,
		)
	);
	if ( ! empty( $comments_unapproved ) ) {
		echo count( $comments_unapproved ) . ' New Comments';
	} else {
		echo 'No new comments';
	}
}

/**
 * Adding active class to the navigation bar
 *
 * @since pits web 2016 1.0
 */
// add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_classes( $classes, $item ) {
	if ( in_array( 'current-menu-item', $classes ) || in_array( 'menu-item-home', $classes ) ) {
		$classes[] = 'active ';
	}
	return $classes;
}

/**
*   Excerpt Configuring
*
* @since pits web 2016 1.0
*/
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function custom_excerpt_length( $length ) {
	return 30;
}
/**
*   Excerpt Configuring
*
* @since pits web 2016 1.0
*/
add_filter( 'excerpt_more', 'new_excerpt_more' );
function new_excerpt_more( $more ) {
	return '.....';
}
/**
 * Function for getting current page url
 *
 * @since pits web 2016 1.0
 */
function current_page_url() {
	$pageURL = 'http';
	if ( isset( $_SERVER['HTTPS'] ) ) {
		if ( $_SERVER['HTTPS'] == 'on' ) {
			$pageURL .= 's';}
	}
	$pageURL .= '://';
	if ( $_SERVER['SERVER_PORT'] != '80' ) {
		$pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
	} else {
		$pageURL .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	}
	return $pageURL;
}

function newsletter_status() {
	if ( isset( $_GET['tx_pitsmailchimp_pitsmailchimpnwsstat'] ) && $_GET['tx_pitsmailchimp_pitsmailchimpnwsstat'] != '' ) {
		return $_GET['tx_pitsmailchimp_pitsmailchimpnwsstat'];
	}
}

function twentyfourteen_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="nav-links">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'twentyfourteen' ) );
			else :
				previous_post_link( '%link', __( '<span class="meta-nav"></span>%title', 'twentyfourteen' ) );
				next_post_link( '%link', __( '<span class="meta-nav"></span>%title', 'twentyfourteen' ) );
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

function twentyfourteen_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links(
		array(
			'base'      => $pagenum_link,
			'format'    => $format,
			'total'     => $GLOBALS['wp_query']->max_num_pages,
			'current'   => $paged,
			'mid_size'  => 1,
			'add_args'  => array_map( 'urlencode', $query_args ),
			'prev_text' => __( '&larr; Previous', 'twentyfourteen' ),
			'next_text' => __( 'Next &rarr;', 'twentyfourteen' ),
		)
	);

	if ( $links ) :

		?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( '', 'twentyfourteen' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
		<?php
	endif;
}
function mytheme_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract( $args, EXTR_SKIP );

	if ( 'div' == $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}
	?>
	<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
		<article class="" id="div-comment-<?php comment_ID(); ?>">
			<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<?php endif; ?>
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
					if ( $args['avatar_size'] != 0 ) {
						echo get_avatar( $comment, $args['avatar_size'] );}
					?>
					<?php printf( __( '<b class="fn">%s <span class="says">says:</span></b> ' ), get_comment_author_link() ); ?>
				</div>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-metadata">
					<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="2008-02-07T11:42:01+00:00">
							<?php
							/* translators: 1: date, 2: time */
							printf( __( '%1$s at %2$s' ), get_comment_date(), get_comment_time() );
							?>
						</time>
					</a>
					<?php
					edit_comment_link( __( '(Edit)' ), '  ', '' );
					?>
				</div>
			</footer>
			<div class="comment-content">
				<?php comment_text(); ?>
			</div>

			<div class="reply">
				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => $add_below,
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
						)
					)
				);
				?>
			</div>
			<?php if ( 'div' != $args['style'] ) : ?>
			</div></article>
		<?php endif; ?>
		<?php
}
if ( ! function_exists( 'twentyfourteen_paging_nav' ) ) :
	/**
	 Display navigation to next/previous set of posts when applicable.

	 @since Twenty Fourteen 1.0

	 @global WP_Query   $wp_query   WordPress Query object.
	 @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
	 */
	function twentyfourteen_paging_nav() {
		global $wp_query, $wp_rewrite;

		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links(
			array(
				'base'      => $pagenum_link,
				'format'    => $format,
				'total'     => 6,
				'current'   => $paged,
				'show_all'  => false,
				'mid_size'  => 3,
				'end_size'  => 6,
				'add_args'  => array_map( 'urlencode', $query_args ),
				'prev_text' => __( '&larr; Previous', 'twentyfourteen' ),
				'next_text' => __( 'Next &rarr;', 'twentyfourteen' ),
			)
		);

		if ( $links ) :
			?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentyfourteen' ); ?></h1>
		<div class="pagination loop-pagination">
				<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
			<?php
		endif;
	}
endif;

/**
 *   Function for displaying custom posts
 *
 * @since pits web 2016 1.0
 */

function pits_custom_post_type() {

	// Set UI labels for Custom Post Type
	$labels = array(
		'name'               => _x( 'Address', 'Post Type General Name', 'pitsweb2016' ),
		'singular_name'      => _x( 'Address', 'Post Type Singular Name', 'pitsweb2016' ),
		'menu_name'          => __( 'Address', 'pitsweb2016' ),
		'parent_item_colon'  => __( 'Parent Address', 'pitsweb2016' ),
		'all_items'          => __( 'All Address', 'pitsweb2016' ),
		'view_item'          => __( 'View Address', 'pitsweb2016' ),
		'add_new_item'       => __( 'Add New Address', 'pitsweb2016' ),
		'add_new'            => __( 'Add New', 'pitsweb2016' ),
		'edit_item'          => __( 'Edit Address', 'pitsweb2016' ),
		'update_item'        => __( 'Update Address', 'pitsweb2016' ),
		'search_items'       => __( 'Search Address', 'pitsweb2016' ),
		'not_found'          => __( 'Not Found', 'pitsweb2016' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'pitsweb2016' ),
	);

	// Set other options for Custom Post Type
	$args = array(
		'label'                  => __( 'Address', 'pitsweb2016' ),
		'description'            => __( 'Address news and reviews', 'pitsweb2016' ),
		'labels'                 => $labels,
		// Features this CPT supports in Post Editor
					'supports'   => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
		// You can associate this CPT with a taxonomy or custom taxonomy.
					'taxonomies' => array( 'genres' ),
		/*
		A hierarchical CPT is like Pages and can have
		   * Parent and child items. A non-hierarchical CPT
		   * is like Posts.
		   */
			   'hierarchical'    => false,
		'public'                 => true,
		'show_ui'                => true,
		'show_in_menu'           => true,
		'show_in_nav_menus'      => true,
		'show_in_admin_bar'      => true,
		'menu_position'          => 5,
		'can_export'             => true,
		'has_archive'            => true,
		'exclude_from_search'    => false,
		'publicly_queryable'     => true,
		'capability_type'        => 'page',
		'exclude_from_search'    => true,
	);
	register_post_type( 'Address', $args );
}
add_action( 'init', 'pits_custom_post_type' );

/*
*calling the options page for theme options
*/
// require_once('pits_options.php');

/**
 * Walker class
 *
 * Walker class added to customise each menu item
 *
 * @since 1.0.0
 */

class pits_description_walker extends Walker_Nav_Menu {

	// function start_el(&$output, $item, $depth, $args, $id = 0)
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$mydb = new wpdb( 'pitsolu_livusr', 'dI8Gc7qr8rw3', 'pitsolu_live1', 'localhost' );
		// $rows = $mydb->get_results("select uid from tt_content where deleted=0 AND hidden=0 AND PID=64 AND sys_language_uid IN (0,-1)");
		// $vacancy=count($rows);
		// Query updated on 25/02/2020 since website changed job implementation to a Typo3 extension
		$rows    = $mydb->get_results( 'SELECT COUNT(*) as count FROM tx_pitsjob_domain_model_job WHERE sys_language_uid=0 AND deleted=0 AND hidden=0' );
		$vacancy = $rows[0]->count;

		global $wp_query;
		$indent      = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';
		$classes     = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li class="hire-count">';

		$attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

		$prepend = '';
		$append  = '';
		if ( $item->description != 'active' ) {

			$description = '<span class="count-num">' . esc_attr( $vacancy ) . '</span>';

		} else {
			$description = ! empty( $item->description ) ? '<span class="count-num">' . esc_attr( '' ) . '</span>' : '';
		}
		if ( $depth != 0 ) {
			$description = $append = $prepend = '';
		}

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $prepend . apply_filters( 'the_title', $item->title, $item->ID ) . $append;

		$item_output .= '</a>';
		$item_output .= $description . $args->link_after;
		$item_output .= $args->after;
		if ( $item->description == 'active' ) {
			$output .= $indent . '<li class="active">';

		}

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}


/**
 * edited by Vishnu Jayan
 * To deny the permission for publishing post for editors
 */
// include_once( get_stylesheet_directory() . '/inc/pits_features.php' );

add_theme_support( 'menus' );
add_theme_support( 'widgets' );



  add_theme_support( 'post-thumbnails' );

  add_image_size( 'smallest', 300, 300, true );
  add_image_size( 'largest', 800, 800, true );


  // register sidebar
function registersidebars() {

	register_sidebar(
		array(
			'name'         => 'Page Sidebar',
			'id'           => 'page-sidebar',
			'before_title' => '<h4 class="widget-title">',
			'after_title'  => '</h4>',
		)
	);
	register_sidebar(
		array(
			'name'         => 'Blog Sidebar',
			'id'           => 'blog-sidebar',
			'before_title' => '<h4 class="widget-title">',
			'after_title'  => '</h4>',
		)
	);
}
  add_action( 'widgets_init', 'registersidebars' );


  // custom logo
function themename_custom_logo() {

}
   add_action( 'after_setup_theme', 'themename_custom_logo' );

function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
  add_filter( 'upload_mimes', 'cc_mime_types' );


/**
 * Custom metabox for blog
 */
function team_member_checkbox() {

		add_meta_box(
			'title',
			'Post Title',
			'team_member_title_display',
			'post',
			'side',
			'high'
		);

		add_meta_box(
			'description',
			'Post description ',
			'team_member_description_display',
			'post',
			'side',
			'high'
		);	
}
	add_action( 'add_meta_boxes', 'team_member_checkbox' );

function team_member_title_display( $post ) {

	wp_nonce_field( 'role_save_meta_box_data', 'role_meta_box_nonce' );
	$value = get_post_meta( $post->ID, '_role_meta_value', true );
	echo '<input type="text" id="title" name="title" style="width:100%" value="' . esc_attr( $value ) . '" required/>';
}
function role_save_meta_box_data( $post_id ) {
	if ( ! isset( $_POST['role_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['role_meta_box_nonce'], 'role_save_meta_box_data' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	if ( ! isset( $_POST['title'] ) ) {
		return;
	}
	$team_data = sanitize_text_field( $_POST['title'] );
	update_post_meta( $post_id, '_role_meta_value', $team_data );
}
		add_action( 'save_post', 'role_save_meta_box_data' );


function team_member_description_display( $post ) {

	wp_nonce_field( 'description_save_meta_box_data', 'description_meta_box_nonce' );
	$value = get_post_meta( $post->ID, '_description_meta_value', true );
	echo '<input type="text" id="description" name="description" style="width:100%" value="' . esc_attr( $value ) . '" required/>';
}
function description_save_meta_box_data( $post_id ) {
	if ( ! isset( $_POST['description_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['description_meta_box_nonce'], 'description_save_meta_box_data' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	if ( ! isset( $_POST['description'] ) ) {
		return;
	}
	$team_data = sanitize_text_field( $_POST['description'] );
	update_post_meta( $post_id, '_description_meta_value', $team_data );
}
		add_action( 'save_post', 'description_save_meta_box_data' );

		add_action( 'wp_enqueue_scripts', 'enqueue_my_scripts' );

function toolset_fix_custom_posts_per_page( $query_string ) {
	if ( is_admin() || ! is_array( $query_string ) ) {
		return $query_string;
	}

	$post_types_to_fix = array(
		array(
			'post_type'      => 'news_article',
			'posts_per_page' => 10,
		),

	);

	foreach ( $post_types_to_fix as $fix ) {
		if ( array_key_exists( 'post_type', $query_string )
			&& $query_string['post_type'] == $fix['post_type']
		) {
			$query_string['posts_per_page'] = $fix['posts_per_page'];
			return $query_string;
		}
	}

	return $query_string;
}

			add_filter( 'request', 'toolset_fix_custom_posts_per_page' );


