<?php
/**
 * WP_Query
 */

/**
 * Change default WP_Query
 */
function custom_pre_get_posts( $query ){

	if ( ! is_admin() ) {
		$query->set( 'posts_per_page', 10 );

		$query->set( 'meta_key', 'meta_name' );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'order', 'ASC'); // DESC
		$query->set( 'meta_query', array(
			array(
				'key'     => 'meta_name',
				'value'   => 'meta_value',
				'compare' => '==',
			)
		) );
	}

}
add_action( 'pre_get_posts', 'custom_pre_get_posts' );

/**
 * Conditions
 *

if (
	is_admin() // in admin area
	! is_admin() // not in admin area
	) {
}

*/

/**
 * Set
 *

// Meta key
$query->set( 'meta_key', 'meta_name' );
$query->set( 'orderby', 'meta_value_num' );
$query->set( 'order', 'ASC'); // DESC

// Meta Query
$query->set( 'meta_query', array(
	array(
		'key'     => 'meta_name',
		'value'   => 'meta_value',
		'compare' => '==',
	)
) );

*/
