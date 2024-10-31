<form action="<?php echo esc_url(admin_url().'admin.php?page=next-social-counter&tab=display');?>" name="setting_ebay_form" method="post" >
	<h3><?php echo esc_html__('Display', 'themedev-social-services');?></h3>
	<div class="disply-login-div">
		<h4><?php echo esc_html__('Icon Style', 'themedev-social-services');?></h4>
		
		<?php if(is_array($buttonstyle)){
			foreach($buttonstyle as $k=>$v){
				$value  = isset($getDisplay['display']['button']) ? $getDisplay['display']['button'] : 'button1';
				$proclass = 'style-counter-pro';
			?>
			<div class="<?php echo esc_attr('themeDev-form');?> style-sec-next <?php echo ($value == $k ) ? 'style-active' : ''; ?>">
				<?php if( in_array($k, ['button1', 'button2', 'button3', 'button4', 'button4-1', 'button4-2', 'button5', 'button6', 'button7', 'button8', 'button9', 'button10', 'button11', 'button12', 'button13', 'button14', 'button15']) ):
					$proclass = '';
					?>
					<input type="radio" name="themedev[display][button]" <?php echo ($value == $k ) ? 'checked' : ''; ?> class="hidden-checkbox" value="<?php echo esc_html($k);?>" id="themedev-style-<?php echo esc_html($k);?>"/>
				<?php endif;?>
				<label class="next-display-label <?php echo esc_attr($proclass);?>" for="themedev-style-<?php echo esc_html($k);?>">
					<span><?php echo esc_html($v['text']);?></span>
					<figure class="image-figure">
						<img src="<?php echo esc_url( NEXT_SOCIAL_FEED_PLUGIN_URL.'assets/images/counter/styles/'.esc_html($k).'.png' ); ?>" alt="<?php echo esc_html($k);?>">
					</figure>
				</label>
			</div>
			
		<?php }
		}
		?>
	</div>
	<div class="<?php echo esc_attr('themeDev-form');?>">
		<button type="submit" name="themedev-social-display" class="themedev-submit"> <?php echo esc_html__('Save ', 'themedev-social-services');?></button>
	</div>
</form>	