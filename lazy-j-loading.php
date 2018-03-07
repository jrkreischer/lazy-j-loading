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
// function lazy_j_img_datasrc( $content ) {
//   // Checks if the content we're receiving isn't empty
//   if ( empty( $content ) ) {
//     return false;
//   }
//
//   $document = new DOMDocument();
//   // Ensure UTF-8 is respected by using 'mb_convert_encoding'
//   $document->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );
//
//   $tags = $document->getElementsByTagName('img');
//   foreach ($tags as $tag) {
//     // $tag->createAttribute('data-src');
//     $tag->setAttribute( 'data-src', $tag->getAttribute('src') );
//     $tag->setAttribute( 'src', '' );
//   }
//   return $document->saveHTML();
//   // echo $content;
// }
// add_filter('the_content', 'lazy_j_img_datasrc');





function lazy_j_prepare_img( $content ) {
  if ( empty( $content ) ) {
    return false;
  }

  if ( !function_exists( 'lazy_j_img_datasrc' ) ) {
    function lazy_j_img_datasrc( $atts, $attachment ) {
      if ( $img = wp_get_attachment_image_src( $attachment->ID, 'large' ) ) {

        if ( ! empty( $img[0] ) ) {
          // $srcset = wp_get_attachment_image_srcset( $img );

          $atts['data-src'] = $img[0];

          $atts['srcset'] = '';
          $atts['src'] = '';
          // $atts['src'] = plugins_url('/images/placeholder.svg', __FILE__);
        }
      }
      return $atts;
    }
    add_filter('wp_get_attachment_image_attributes', 'lazy_j_img_datasrc', 1, 2);
  }


  return $content;
}
add_filter('the_content', 'lazy_j_prepare_img', 1, 1);

?>
