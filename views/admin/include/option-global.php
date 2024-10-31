
<form action="<?php echo esc_url(admin_url().'admin.php?page=next-social-login&tab=global');?>" name="setting_ebay_form" method="post" >
	<h3><?php echo esc_html__('Global Services', 'themedev-social-services');?></h3>
	<div class="custom-login-div">
		<h4><?php echo esc_html__('Setup Redirect', 'themedev-social-services');?></h4>
		<div class="<?php echo esc_attr('themeDev-form');?>">
			<div class="flex-form">
				<div class="left-div">
					<label for="ebay_show_sold_product" class="inline-label">
						<?php echo esc_html__('Enable Redirect login : ', 'themedev-social-services');?>
					</label>
				</div>
				<div class="right-div">
					<input type="checkbox" onclick="themedev_show(this);" nx-target="#next-custom-login-page" name="themedev[global][custom][enable]" <?php echo isset($getGlobal['global']['custom']['enable']) ? 'checked' : ''; ?> class="themedev-switch-input" value="Yes" id="themedev-enable_custom_login"/>
					<label class="themedev-checkbox-switch" for="themedev-enable_custom_login">
						<span class="themedev-label-switch" data-active="ON" data-inactive="OFF"></span>
					</label>
					
					<span class="themedev-document-info block"> <?php echo esc_html__('Enable custom redirect login url.', 'themedev-social-services');?></span>
				</div>
			</div>
		</div>
		<?php
		$pages = get_pages();
		?>
		<div class="<?php echo esc_attr('themeDev-form');?> nx-hide-target <?php echo isset($getGlobal['global']['custom']['enable']) ? 'nx-show-target' : ''?>" id="next-custom-login-page">
			<div class="flex-form">
				<div class="left-div">
					<label for="ebay_show_sold_product" class="inline-label">
						<?php echo esc_html__('Select Page : ', 'themedev-social-services');?>
					</label>
				</div>
				<div class="right-div">
					<?php
					$defaultdashboardPage = isset($getGlobal['global']['custom']['page']) ? $getGlobal['global']['custom']['page'] : '';
                    if( !isset($getGlobal['global']['custom']['enable']) ){
						$defaultdashboardPage = '';
					}					
					?>
					<select class="themedev-text-input inline-block" onchange="themedev_show_default(this, 'custom-page');" nx-target="#next-custom-login-url" name="themedev[global][custom][page]">
						<option value=""> <?php echo esc_html__('Select Page', 'themedev-social-services');?> </option>
						<option value="custom-page" <?php echo ($defaultdashboardPage == 'custom-page') ? 'selected' : '';?> > <?php echo esc_html__('Custom Page', 'themedev-social-services');?> </option>
						<option value="current-page" <?php echo ($defaultdashboardPage == 'current-page') ? 'selected' : '';?>><?php echo esc_html__(' Back to Current Page', 'themedev-social-services');?></option>
						<?php
						if(is_array($pages) && sizeof($pages) > 0){
							foreach ( $pages as $page ) {
							  $selected = '';
							  $urlPage = get_page_link($page);
							  
							  if($defaultdashboardPage == $urlPage){
								  $selected = 'selected';
							  }
							$option = '<option '.$selected.' value="' . $urlPage . '">';
							$option .= $page->post_title;
							$option .= '</option>';
							echo $option;
						  }
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="<?php echo esc_attr('themeDev-form');?> nx-hide-target <?php echo isset($getGlobal['global']['custom']['enable']) && $defaultdashboardPage == 'custom-page' ? 'nx-show-target' : ''?>" id="next-custom-login-url">
			<div class="flex-form">
				<div class="left-div">
					<label for="ebay_show_sold_product" class="inline-label">
						<?php echo esc_html__('Custom URL : ', 'themedev-social-services');?>
					</label>
				</div>
				<div class="right-div">
					<input type="text" name="themedev[global][custom][url]" class="themedev-text-input inline-block" value="<?php echo isset($getGlobal['global']['custom']['url']) ? $getGlobal['global']['custom']['url'] : ''; ?>" id="themedev-enable_custom_login_url"/>
					<span class="themedev-document-info block"> <?php echo esc_html__('Enter custom URl for redirect after login from providers.', 'themedev-social-services');?></span>
				</div>
			</div>
		</div>
		<h4><?php echo esc_html__('Enable Services', 'themedev-social-services');?></h4>
		<?php 
			//print_r($servicesGlobal);
			if(is_array($servicesGlobal) && sizeof($servicesGlobal) > 0){
				$m = 1;
				foreach($servicesGlobal as $k=>$v):
				?>
				<div class="<?php echo esc_attr('themeDev-form');?> nx-border-bottom">
					<div class="flex-form">
						<div class="left-div">
							<label for="ebay_show_sold_product" class="inline-label">
								<?php echo '<strong> '.$m.'. </strong>'. esc_html__(ucwords(str_replace(['_', ',', ':', '-'], ' ', $k)), 'themedev-social-services');?>
							</label>
						</div>
						<div class="right-div">
							<input type="checkbox" onclick="themedev_show(this);" nx-target="#themedev-enable-<?php echo $k;?>-show" name="themedev[global][<?php echo $k;?>][enable]" <?php echo isset($getGlobal['global'][$k]['enable']) ? 'checked' : ''; ?> class="themedev-switch-input" value="Yes" id="themedev-enable_<?php echo $k;?>_login"/>
							<label class="themedev-checkbox-switch" for="themedev-enable_<?php echo $k;?>_login">
								<span class="themedev-label-switch" data-active="ON" data-inactive="OFF"></span>
							</label>
							<div class="sub-label nx-hide-target <?php echo isset($getGlobal['global'][$k]['enable']) ? 'nx-show-target' : ''?>" id="themedev-enable-<?php echo $k;?>-show">
								<?php if(isset($v) && sizeof($v) > 0):
									echo '<ul class="social-services-list">';
									foreach($v AS $kk=>$vv):
								?>
									<li>
										<input type="radio" name="themedev[global][<?php echo $k;?>][services]" <?php echo isset($getGlobal['global'][$k]['services']) && $getGlobal['global'][$k]['services'] == $kk ? 'checked' : ''; ?> class="themedev-radio-input" value="<?php echo $kk;?>" id="themedev-enable_<?php echo $k;?>_login_<?php echo $kk;?>"/>
										<label for="themedev-enable_<?php echo $k;?>_login_<?php echo $kk;?>"> <?php echo esc_html__($vv, 'themedev-social-services');?></label>
										
									</li>
								<?php endforeach;
								echo '</ul>';
								endif;?>
							</div>
						</div>
					</div>
				</div>
				<?php
				$m++;
				endforeach;
			}
		?>
	</div>
	
	<div class="<?php echo esc_attr('themeDev-form');?>">
		<button type="submit" name="themedev-social-global" class="themedev-submit"> <?php echo esc_html__('Save ', 'themedev-social-services');?></button>
	</div>
</form>