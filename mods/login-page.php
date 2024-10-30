<?php

  function custom_login_logo() 
  {
    $loginLogo = plugins_url('/login-logo.png', __FILE__);
  	?>
  	
  	<style>
  	body.login {
    	background: #121212;
  	}
  	
  	body.login #login h1 a {
  		background: url('<?php echo $loginLogo; ?>') no-repeat scroll center top transparent;
  		width: 320px;
  		height: 68px;
  	}
  	
  	body.login #nav, body.login #backtoblog
  	{
    	text-shadow: none;
  	}

  	body.login #nav a, body.login #backtoblog a
  	{
    	color: !pink;
  	}
  	
  	</style>
  	
  	<?php
  }
  
  
  function register_login_settings() 
  {
  	// Register our settings
  	register_setting( 'ls_option_group', 'ls_login_branding' );
  	
    add_settings_section('ls_login_section', 'Login Settings', 'ls_login_description', 'limesquare');
    
    add_settings_field('ls_login_branding', 'Display Branding', 'ls_login_branding_checkbox', 'limesquare', 'ls_login_section', array( 'label_for' => 'ls_login_branding' ));
  }
  add_action('admin_init', 'register_login_settings');
  
  function ls_login_description() 
  {
    echo '<p>Control login branding and security settings.</p>';
  }
  
  function ls_login_branding_checkbox() 
  {
    $checked = get_option( 'ls_login_branding', 0 );
    
    echo "<input id='ls_login_branding' name='ls_login_branding' type='checkbox' value='1' " . checked( $checked, 1, false ) . " />";
  }
  
  
  // Get the preferences
  $login_branding = get_option( 'ls_login_branding', 0 );

  // Check if we should display the branding
  if ($login_branding)
  {
    add_filter('login_headerurl', create_function(false, "return 'http://www.limesquare.com.au/';"));
    add_filter('login_headertitle', create_function(false, "return 'LimeSquare WordPress Development';"));
    add_action("login_head", "custom_login_logo");
  }
  
?>