<?php

  function google_analytics() 
  {
    $default = array( 'ls_analytics_code' => '' );  
    $options = get_option( 'ls_analytics_options', $default );
    $account_number = $options['ls_analytics_code'];
    
    // Check if running localhost
    $islocal = strpos($_SERVER['HTTP_HOST'], 'localhost') !== FALSE || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== FALSE;
  
    // Check if the account number is set, user is not admin, and not localhost
    if ($account_number != "" && current_user_can('manage_options') == false && $islocal == false ) :
    ?>
    
      <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', '<?php echo $account_number; ?>']);
        _gaq.push(['_trackPageview']);
    
        (function() {
           var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
           ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
           var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
      </script>
    
    <?php
    endif; // $account_number != "" && is_admin() == false && not localhost
  }
  add_action('wp_head', 'google_analytics');


  function register_analytics_settings() 
  {
  	// Register our settings
  	register_setting( 'ls_option_group', 'ls_analytics_options', 'ls_analytics_validate' );
  	
    add_settings_section('ls_analytics_section', 'Google Analytics', 'ls_analytics_description', 'limesquare');
    
    add_settings_field('ls_analytics_code', 'Google Analytics Code', 'ls_analytics_code_input', 'limesquare', 'ls_analytics_section', array( 'label_for' => 'ls_analytics_code' ));
  }
  add_action('admin_init', 'register_analytics_settings');
  
  function ls_analytics_description() 
  {
    echo '<p>Enable tracking and statistics using Google Analytics.</p>';
  }
  
  function ls_analytics_code_input() 
  {
    $default = array( 'ls_analytics_code' => '' );
    
    $options = get_option( 'ls_analytics_options', $default );
    
    echo "<input id='ls_analytics_code' name='ls_analytics_options[ls_analytics_code]' size='40' type='text' value='$options[ls_analytics_code]' />";
  }
  
  // Validate our options
  function ls_analytics_validate($input) 
  {
    $default = array( 'ls_analytics_code' => '' );
    
    $options = get_option( 'ls_analytics_options', $default );
    
    $options['ls_analytics_code'] = trim($input['ls_analytics_code']);
    if(!preg_match('/^UA-[0-9]{1,10}-[0-9]/', $options['ls_analytics_code'])) 
    {
      $options['ls_analytics_code'] = '';
    }
    return $options;
  }

?>