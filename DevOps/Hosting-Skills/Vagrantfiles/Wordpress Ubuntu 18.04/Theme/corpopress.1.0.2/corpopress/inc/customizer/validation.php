<?php
/**
* Customizer validation functions
*
* @package Theme Palace
* @subpackage Corpopress
* @since Corpopress 1.0.0
*/

if ( ! function_exists( 'corpopress_validate_long_excerpt' ) ) :
  function corpopress_validate_long_excerpt( $validity, $value ){
         $value = intval( $value );
     if ( empty( $value ) || ! is_numeric( $value ) ) {
         $validity->add( 'required', esc_html__( 'You must supply a valid number.', 'corpopress' ) );
     } elseif ( $value < 5 ) {
         $validity->add( 'min_no_of_words', esc_html__( 'Minimum no of words is 5', 'corpopress' ) );
     } elseif ( $value > 100 ) {
         $validity->add( 'max_no_of_words', esc_html__( 'Maximum no of words is 100', 'corpopress' ) );
     }
     return $validity;
  }
endif;

if ( ! function_exists( 'corpopress_validate_blog_count' ) ) :
  function corpopress_validate_blog_count( $validity, $value ){
         $value = intval( $value );
     if ( empty( $value ) || ! is_numeric( $value ) ) {
         $validity->add( 'required', esc_html__( 'You must supply a valid number.', 'corpopress' ) );
     } elseif ( $value < 2 ) {
         $validity->add( 'min_no_of_posts', esc_html__( 'Minimum no of posts is 2', 'corpopress' ) );
     } elseif ( $value > 12 ) {
         $validity->add( 'max_no_of_posts', esc_html__( 'Maximum no of posts is 12', 'corpopress' ) );
     }
     return $validity;
  }
endif;
