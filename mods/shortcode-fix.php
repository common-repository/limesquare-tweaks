<?php

  // Move Auto Paragraph tags filter until AFTER the shortcode is processed
  remove_filter( 'the_content', 'wpautop' );
  add_filter( 'the_content', 'wpautop' , 99);
  add_filter( 'the_content', 'shortcode_unautop', 100 );
  
?>