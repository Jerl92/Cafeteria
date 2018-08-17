<?php

// Show posts of 'post', 'page', 'acme_product' and 'movie' post types on home page
function search_filter( $query ) {
  if ( !is_admin() && $query->is_main_query() ) {
    if ( $query->is_search ) {
      $query->set( 'post_type', array( 'post', 'page', 'cafeteria' ) );
    }
  }
} 
add_action( 'pre_get_posts','search_filter' );

add_action( 'after_setup_theme', 'mcplayer_support' );
function mcplayer_support() {
  add_theme_support( 'cafeteria' );
}

?>