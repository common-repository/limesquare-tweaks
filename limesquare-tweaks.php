<?php
  /*
    Plugin Name: LimeSquare Tweaks
    Plugin URI: http://www.limesquare.com.au/
    Description: A plugin that makes useful tweaks to core functionality that LimeSquare has delivered to paying clients, now available for free for the WordPress community.
    Version: 1.1.0
    Author: Matthew Blackford / LimeSquare
    Author URI: http://www.limesquare.com.au/
    License: GPL2
  */

  require_once('widgets/google-maps.php');
  require_once('options/google-analytics.php');
  require_once('mods/shortcode-fix.php');
  require_once('mods/login-page.php');
  
  function register_styles() 
  {
    wp_enqueue_style('limesquare', plugins_url('style.css', __FILE__));
  }
  add_action('wp_print_styles', 'register_styles');

  // Create the settings page
  function ls_create_settings_page() 
  {
  	add_options_page('LimeSquare Plugin Settings', 'LimeSquare', 'manage_options', 'limesquare', 'ls_settings_page');
  }
  add_action('admin_menu', 'ls_create_settings_page');
  
  function ls_settings_page() 
  {
  ?>
    <div class="wrap">
      <?php screen_icon(); ?>
      <h2>LimeSquare Plugin Settings</h2>
      
      <p>Custom settings to improve your website and search engine ranking.</p>
      
      <form action="options.php" method="post">
      
        <?php settings_fields('ls_option_group'); ?>
        
        <?php do_settings_sections('limesquare'); ?>
        
        <?php submit_button(); ?>
      </form>
    </div>
  <?php 
  }
  
?>