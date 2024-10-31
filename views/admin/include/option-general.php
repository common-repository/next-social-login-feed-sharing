
<form action="<?php echo esc_url(admin_url().'admin.php?page=next-social-login&tab=general');?>" name="setting_ebay_form" method="post" >
	<h3><?php echo esc_html__('General Services', 'themedev-social-services');?></h3>
	
	<div class="<?php echo esc_attr('themeDev-form');?>">
		<div class="flex-form">
			<div class="left-div">
				<label class="inline-label">
					<?php echo esc_html__('Enable Social Login ', 'themedev-social-services');?>
				</label>
			</div>
			<div class="right-div">
				<?php
				$loginEbnalbe = isset($getGeneral['general']['login']['ebable']) ? 'Yes' : 'No';
				if( !isset($getGeneral['general']) ){
					$loginEbnalbe = 'Yes';
				}
				?>
				<input type="checkbox" name="themedev[general][login][ebable]" <?php echo ($loginEbnalbe == 'Yes') ? 'checked' : ''; ?> class="themedev-switch-input" value="Yes" id="themedev-enable_login" onclick="themedev_show(this);" nx-target=".next-custom-login-page"> 
				<label class="themedev-checkbox-switch" for="themedev-enable_login">
					<span class="themedev-label-switch" data-active="ON" data-inactive="OFF"></span>
				</label>
				
				<span class="themedev-document-info block"> <?php echo esc_html__('User login & register by using login services.', 'themedev-social-services');?></span>
				
				<div class="<?php echo esc_attr('themeDev-form');?> next-custom-login-page nx-hide-target <?php echo ($loginEbnalbe == 'Yes') ? 'nx-show-target' : ''?>"  >
					<?php $role =  isset($getGeneral['general']['user']['role']) ? $getGeneral['general']['user']['role'] : 'subscriber'; ?> 
					<label for="next-user-role" class="block-label">
						<?php echo esc_html__('New User Default Role ', 'themedev-social-services');?>
					</label>
					<select class="themedev-text-input inline-block" id="next-user-role" name="themedev[general][user][role]">
					   <?php wp_dropdown_roles( $role ); ?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="themeDev-form next-custom-login-page nx-hide-target <?php echo isset($getGeneral['general']['login']['ebable']) ? 'nx-show-target' : ''?>" id="next-custom-login-page">
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