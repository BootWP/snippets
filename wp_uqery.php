<?php
/**
 * WP_Query
 */

$args = array(
	'post_type'      => 'post', // page, post, project
	'posts_per_page' => -1, // -1
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) :

	while ( $query->have_posts() ) : $query->the_post();

	endwhile;

else:

endif;

wp_reset_postdata();


/**
 * Advanced WP_Query
 */

$page   = get_query_var( 'page' );
$pages  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$sticky = get_option( 'sticky_posts' );

if ( is_front_page() ){
	$pages = $page;
}

$args = array(
	'post_type'      => 'post_type', // page, post, project
	'posts_per_page' => 5, // -1
	'orderby'        => 'menu_order', // rand, title, meta_value, meta_value_num, 'post__in', 'orderby' => 'comment_count'
	'orderby'        => array( 'post__in' => 'desc', 'title' => 'asc' ),
	'order'          => 'ASC', // DESC
	'offset'         => '1',
	'post_parent'    => get_the_ID(),
	'post__not_in'   => array('11'),
	'post__in'       => array('11','12'), // $sticky = get_option( 'sticky_posts' ); 'post__in' => $sticky
	//'post_name__in' =>
	//'post_parent__in' =>
	//'name' => 'hello-world', by post/page name
	//'pagename' => 'contact', by page name
	'ignore_sticky_posts' => true,
	'meta_key'       => 'custom-filed-name', // views, get only post with thumbnail '_thumbnail_id',
	'meta_value'     => 1,
	'cat'            => array(1,2,3), // get categories and childrens
	'category__in'   => array(1,2,3), // get categories without childrens
	// 'category_name'       => 'cat-slug,cat-slug-2',
	//'paged'          => $pages,
	// 'post_status' => 'publish', // pending
	'meta_query'	=> array(
		array(
			// 'compare_key' => 'LIKE', Meta query for wp 5.1
			'key'     => 'promo',
			'value'   => '',
			'compare' => '!=', // NOT EXISTS, 

			//  must be only numbers
			//'value' => '^[0-9]*$', // "misha_key" must be only numbers
			//'compare' => 'REGEXP'
		),

	),
	'tax_query' => array(
		'relation' => 'OR',
		array(
			'taxonomy' => 'product_cat',
			'field'    => 'id',
			'terms'    => array( $term->term_id ), // get_queried_object_id()
		),
		array(
			'taxonomy' => 'post_format',
			'field'    => 'slug',
			'terms'    => array( 'video' )
		)
	),
	'date_query' => array(
		//'after' => '2 weeks ago',
		'after'     => '10 days ago',
		'inclusive' => true,
	),
);


//global $wp_query;
//$save_wpq = $wp_query;
//$wp_query = new WP_Query( $args );

$query = new WP_Query( $args );

$post_count = $query->post_count; // get count of post on current page $total_post_count = wp_count_posts();
$found_posts = $query->found_posts; // get count of all posts

if ( $query->have_posts() ) :

	while ( $query->have_posts() ) : $query->the_post();
		the_title();
		$post_name = get_post_field( 'post_name' );

		//$current_post = $wp_query->current_post + 1;

		// $index = $current_post;

		// if ( is_paged() ) {
		// 	$posts_per_page = $wp_query->query_vars['posts_per_page'];
		// 	$paged = $wp_query->query_vars['paged'];
		// 	$index = $current_post + ( $posts_per_page * ( $paged - 1 ) );
		// }

		// echo $index;

		// // if is third
		// if ( $index % 3 == 0 ) {
		// 	echo 'third';
		// }

	endwhile;

	the_posts_pagination(); // add_filter('navigation_markup_template', 'custom_navigation_markup_template', 10, 2 ); $template, $class

else:

endif;
//$wp_query = null;
//$wp_query = $save_wpq;
wp_reset_postdata();
//$wp_query = $save_wpq;


