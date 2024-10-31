<div class="next-social-login-widget">
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Login Title :' , 'themedev-social-services' ) ?> </label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id( 'providers' ); ?>"><?php _e( 'Providers :' , 'themedev-social-services' ) ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'providers' ); ?>" name="<?php echo $this->get_field_name( 'providers' ); ?>[]" multiple>
			<option value="">All</option>
			<?php
			 foreach( $this->login->allow_pro as $v):
			   if( file_exists( NEXT_SOCIAL_FEED_PLUGIN_PATH .'/apps/providers/'.$v.'.php' ) ){
			?>
				<option value="<?php echo $v;?>" <?php echo (in_array($v, $select_provider)) ? 'selected' : ''; ?>> <?php _e($v, 'themedev-social-services'); ?> </option>
			 <?php } 
			 endforeach;?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Button Style :' , 'themedev-social-services' ) ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
			<option value="">Default</option>
			<?php
			 foreach( $this->login_style as $k=>$v):
				if( in_array($k, ['button1', 'button2', 'button3', 'button4', 'button5', 'button6', 'button7', 'button8', 'button9', 'button10', 'button11']) ):
			?>
				<option value="<?php echo $k;?>" <?php echo ($instance['style'] == $k ) ? 'selected' : ''; ?> > <?php _e( isset($v['text']) ? $v['text'] : $k, 'themedev-social-services'); ?> </option>
			 <?php 
			 	endif;
			 endforeach;?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'box_only' ); ?>"><?php _e( 'Hide Title' , 'themedev-social-services' ) ?></label>
		<input id="<?php echo $this->get_field_id( 'box_only' ); ?>" name="<?php echo $this->get_field_name( 'box_only' ); ?>" value="true" <?php if( $instance['box_only'] ) echo 'checked="checked"'; ?> type="checkbox" />
		<br /><small><?php _e( 'Only Show the Social Login Box button without Title.' , 'themedev-social-services' ) ?></small>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'custom_class' ); ?>"><?php _e( 'Custom Class :' , 'themedev-social-services' ) ?> </label>
		<input id="<?php echo $this->get_field_id( 'custom_class' ); ?>" name="<?php echo $this->get_field_name( 'custom_class' ); ?>" value="<?php echo $instance['custom_class']; ?>" class="widefat" type="text" />
	</p>
</div>