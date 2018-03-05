<?php
/**
 * Plugin Name: Lazy J Loading Galleries
 * Plugin URI:
 * Description: Lazy loading for WordPress galleries.
 * Version: 1.0
 * Author: John Kreischer
 * Author URI:
 * License: GPL2
 */

// Enqueue JavaScript
function lazy_j_add_assets() {
 wp_enqueue_script( 'lazy-j-script', plugins_url('/js/lazy-j-loading.js', __FILE__), array(), '', true );
}
add_action( 'wp_enqueue_scripts', 'lazy_j_add_assets' );

// Enqueue CSS in the footer
function lazy_j_add_footer_styles() {
  wp_enqueue_style( 'lazy-j-styles', plugins_url('/css/lazy-j-style.css', __FILE__) );
}
add_action( 'get_footer', 'lazy_j_add_footer_styles' );

// Set data-src and clear src
function lazy_j_img_datasrc( $content ) {
  $document = new DOMDocument();
  // Ensure UTF-8 is respected by using 'mb_convert_encoding'
  $document->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );

  // if (!empty()) {
  //
  // }
  $tags = $document->getElementsByTagName('img');
  foreach ($tags as $tag) {

    $tag->setAttribute( 'data-src', $tag->getAttribute('src') );
    $tag->setAttribute( 'src', '' );
  }
  return $document->saveHTML();
}
add_filter('the_content', 'lazy_j_img_datasrc');


?>
