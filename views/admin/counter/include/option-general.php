
<form action="<?php echo esc_url(admin_url().'admin.php?page=next-social-counter&tab=general');?>" name="setting_ebay_form" method="post" >
	<h3><?php echo esc_html__('General Services', 'themedev-social-services');?></h3>
	<div class="<?php echo esc_attr('themeDev-form');?>">
		<div class="flex-form">
			<div class="left-div">
				<label for="ebay_show_sold_product" class="inline-label">
					<?php echo esc_html__('Enable Counter ', 'themedev-social-services');?>
				</label>
			</div>
			<div class="right-div">
				<input type="checkbox" onclick="themedev_show(this);" nx-target=".next-custom-login-page" name="themedev[general][counter][ebable]" <?php echo isset($getGeneral['general']['counter']['ebable']) ? 'checked' : ''; ?>  class="themedev-switch-input" value="Yes" id="themedev-enable_feed">
				<label class="themedev-checkbox-switch" for="themedev-enable_feed">
					<span class="themedev-label-switch" data-active="ON" data-inactive="OFF"></span>
				</label>
				<span class="themedev-document-info block"> <?php echo esc_html__('Enable Counter service for Display your social Follower, Fan & Others.', 'themedev-social-services');?></span>
			</div>
		</div>
	</div>
	
	<div class="themeDev-form next-custom-login-page nx-hide-target <?php echo isset($getGeneral['general']['counter']['ebable']) ? 'nx-show-target' : ''?>" id="next-custom-login-page">
		<div class="flex-form">
			<div class="left-div">
				<label class="inline-label">
					<?php echo esc_html__('Content Position ', 'themedev-social-services');?>			
				</label>
				<span class="themedev-document-info block">  <?php echo esc_html__('Set position for share button in content.', 'themedev-social-services');?></span>
			</div>
			<div class="right-div">
				<ul class="next-custom-post-ul">
					<?php 
					$content_position = isset($getGeneral['general']['content_position']) ? $getGeneral['general']['content_position'] : 'unset_position';
					foreach( self::$sharing_content_position as $k=>$v):
					?>
						<li>
							<input type="radio" <?php echo ($content_position == $k) ? 'checked' : '';?> name="themedev[general][content_position]" id="custom_post_content<?php echo $k;?>" value="<?php echo $k;?>">
							<label for="custom_post_content<?php echo $k;?>"><?php echo esc_html__($v, 'themedev-social-services');?>	</label>
					  </li>
					<?php endforeach;?>
				</ul>
			</div>
		</div>
	</div>
	<div class="themeDev-form next-custom-login-page nx-hide-target <?php echo isset($getGeneral['general']['counter']['ebable']) ? 'nx-show-target' : ''?>" id="next-custom-login-page">
		<div class="flex-form">
			<div class="left-div">
				<label class="inline-label">
					<?php echo esc_html__('Icon Style ', 'themedev-social-services');?>					
				</label>
				<span class="themedev-document-info block"> <?php echo esc_html__('Select Icon Style for providers icon. ', 'themedev-social-services');?>	</span>
			</div>
			<div class="right-div">
				<?php
				$icon_style = isset($getGeneral['general']['icon_style']) ? $getGeneral['general']['icon_style'] : 'line';
                    
				?>
				<ul class="next-custom-post-ul">
				  <li>
						<input type="radio" <?php echo ($icon_style == 'line') ? 'checked' : '';?> name="themedev[general][icon_style]" id="custom_post_position_line" value="line">
						<label for="custom_post_position_line"><?php echo esc_html__('Line ', 'themedev-social-services');?>	</label>
				  </li>
				  <li>
						<input type="radio" <?php echo ($icon_style == 'bold') ? 'checked' : '';?> name="themedev[general][icon_style]" id="custom_post_position_bold" value="bold">
						<label for="custom_post_position_bold"><?php echo esc_html__('Bold ', 'themedev-social-services');?></label>
				  </li>
				  
				</ul>
				
			</div>
		</div>
	</div>
	
	<div class="<?php echo esc_attr('themeDev-form');?>">
		<button type="submit" name="themedev-social-general" class="themedev-submit"> <?php echo esc_html__('Save ', 'themedev-social-services');?></button>
	</div>
</form>