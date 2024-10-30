<?php

class GoogleMapsWidget extends WP_Widget
{
  function GoogleMapsWidget()
  {
    $widget_ops = array('classname' => 'google-maps-widget', 'description' => 'Displays a Google Map of your location' );
    $this->WP_Widget('GoogleMapsWidget', 'LimeSquare: Google Map', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 
                                                         'location' => '', 
                                                         'width' => '240', 
                                                         'height' => '320', 
                                                         'zoom' => '15',
                                                         'mode' => 0,
                                                          ) );
    $title = $instance['title'];
    $location = $instance['location'];
    $width = $instance['width'];
    $height = $instance['height'];
    $zoom = $instance['zoom'];
    $mode = $instance['mode'];
    
?>
      <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">Title: </label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
      </p>
      
      <p>
        <label for="<?php echo $this->get_field_id('location'); ?>">Location: </label>
        <input class="widefat" id="<?php echo $this->get_field_id('location'); ?>" name="<?php echo $this->get_field_name('location'); ?>" type="text" value="<?php echo esc_attr($location); ?>" />
      </p>
      
      <p>
        <label for="<?php echo $this->get_field_id('width'); ?>">Width: </label>
        <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($width); ?>" />
      </p>
      
      <p>
        <label for="<?php echo $this->get_field_id('height'); ?>">Height: </label>
        <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>" />
      </p>
      
      <p>
        <label for="<?php echo $this->get_field_id('zoom'); ?>">Zoom: </label>
        <input class="widefat" id="<?php echo $this->get_field_id('zoom'); ?>" name="<?php echo $this->get_field_name('zoom'); ?>" type="text" value="<?php echo esc_attr($zoom); ?>" />
      </p>
      
      <p>
        <label for="<?php echo $this->get_field_id('mode'); ?>">Mode: </label>
        <br />
        <input class="" name="<?php echo $this->get_field_name('mode'); ?>" type="radio" value="0" <?php if ($mode == 0) echo "checked"; ?> /> Static
        <br />
        <input class="" name="<?php echo $this->get_field_name('mode'); ?>" type="radio" value="1" <?php if ($mode == 1) echo "checked"; ?>/> Interactive
      </p>

<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    
    $instance['title'] = $new_instance['title'];
    $instance['location'] = $new_instance['location'];
    $instance['width'] = $new_instance['width'];
    $instance['height'] = $new_instance['height'];
    $instance['zoom'] = $new_instance['zoom'];
    $instance['mode'] = $new_instance['mode'];
    
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    
    $mode = empty($instance['mode']) ? '0' : $instance['mode'];
    $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
    $zoom = empty($instance['zoom']) ? '15' : $instance['zoom'];
    $width = empty($instance['width']) ? '240' : $instance['width'];
    $height = empty($instance['height']) ? '320' : $instance['height'];
    $rawlocation = empty($instance['location']) ? '1600 Amphitheatre Parkway Mountain View, CA 94043' : $instance['location'];
    $location = urlencode($rawlocation);
 
    if (!empty($title)) 
    {
      echo $before_title . $title . $after_title;
    }
 
    // Check if in interactive mode
    if ($mode == 1) 
    {
    ?>
    
      <iframe class="sidebar-map" width="100%" height="<?php echo $height; ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $location; ?>&output=embed&z=<?php echo $zoom; ?>&iwloc=near"></iframe>
      <p>
        <a class="sidebar-map-link" href="http://maps.google.com/?q=<?php echo $location; ?>" target="_blank" alt="View on Google Maps">View on Google Maps</a>
      </p>
      
    <?php 
    // Otherwise static mode
    } else {      
    ?>
      
      <a class="sidebar-map-link" href="http://maps.google.com/?q=<?php echo $location; ?>" target="_blank" alt="View on Google Maps">
        <img class="sidebar-map" src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $location; ?>&zoom=<?php echo $zoom; ?>&size=<?php echo $width; ?>x<?php echo $height; ?>&maptype=roadmap&markers=color:red|label:A|<?php echo $location; ?>&sensor=false&region=AU&scale=2" style="width: 100%; height: auto;"/>
      </a>

    <?php
    } // $mode == 1
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("GoogleMapsWidget");') );

?>