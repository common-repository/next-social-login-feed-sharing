
<form action="<?php echo esc_url(admin_url().'admin.php?page=next-social-login&tab=providers');?>" name="setting_ebay_form" method="post" >
	<h3><?php echo esc_html__('Login Providers', 'themedev-social-services');?></h3>
	<div class="next-providers">
		<div class="next-social-block-wraper">
			<ul class="next-social-block ui-sortable" id="themedev-social-sortable" >
				<?php
				$icon_style = isset($getGeneral['general']['icon_style']) ? $getGeneral['general']['icon_style'] : 'line';
                
				$line = ($icon_style == 'line')	? '-line' : '';
				
				if(is_array($order_provider) && sizeof($order_provider) > 0){
					foreach($order_provider as $k=>$v):
					$pro_class = '';
					$pro_enable = false;
					if(!file_exists( NEXT_SOCIAL_FEED_PLUGIN_PATH .'/apps/providers/'.$k.'.php' )){
						$pro_class = 'next-pro-service';
						$pro_enable = true;
					}
				?>
				<li class="ui-state-default">
					<div class="next-single-social-block <?php echo $k;?>">
						<div class="next-block-header  <?php echo $pro_class;?>" <?php if(!$pro_enable){?>onclick="next_modal_popup(this)" <?php }?> nx-target-common=".next-modal-dialog" nx-target="#next-modal-<?php echo $k;?>">
							<span class="drag-icon"></span>
							<div class="next-social-icon">
								<i class="nx-social nx-social-<?php echo $k.$line;?>"></i>
							</div>
							<h2 class="next-social-icon-title"><?php echo esc_html($v, 'themedev-social-services');?></h2>
						</div>
						<div class="next-block-footer">
							<div class="left-content">
								<div class="configure <?php echo isset($getProvider['provider'][$k]['enable']) ? 'enable' : 'disable';?>">
									<span class="enable"><?php echo esc_html__('Active', 'themedev-social-services');?></span>
									<span class="disable"><?php echo esc_html__('DeActive', 'themedev-social-services');?></span>
								</div>
								<input type="hidden" name="loginsorting[<?php echo $k;?>]" value="<?php echo $v;?>">
							</div>
							<div class="right-content">
								<?php if($pro_enable){?>
									<a href="<?php echo esc_url('http://themedev.net/next-social/');?>" class="next-btn btn-special small"> <?php echo esc_html__('Go PRO', 'themedev-social-services');?></a>
								<?php								
								}else{?>
									<a href="javascript:void()" class="next-btn btn-special small" onclick="next_modal_popup(this)" nx-target-common=".next-modal-dialog" nx-target="#next-modal-<?php echo $k;?>"> <?php if( isset($getProvider['provider'][$k]['enable']) ? $getProvider['provider'][$k]['enable'] : 0 == 1){ echo esc_html__('Update', 'themedev-social-services');?> <?php }else{?> <?php echo esc_html__('Setup', 'themedev-social-services'); }?></a>
								<?php }?>
							</div>
						</div>
					</div>
				</li>
				<?php endforeach;
					}
				?>
			</ul>
		</div>
	
	<div class="<?php echo esc_attr('themeDev-form');?>">
		<button type="submit" name="themedev-social-providers" class="themedev-submit"> <?php echo esc_html__('Save ', 'themedev-social-services');?></button>
	</div>
	<?php
	if(is_array($provider) && sizeof($provider) > 0){	
		foreach($provider as $kk=>$vv):
			if(file_exists( NEXT_SOCIAL_FEED_PLUGIN_PATH .'/apps/providers/'.$kk.'.php' )){
		
	?>

	<div class="next-modal-dialog" id="next-modal-<?php echo $kk;?>">
		<div class="next-modal-content post__tab">
			<div class="next-modal-header clear-both">
				<div class="tabHeader">
					<ul class="tab__list clear-both">
						<li class="tab__list__item active" onclick="next_tab_control(this)" nx-target="#next_tab_<?php echo $kk;?>__crediential" nx-target-common=".next-tab-item" ><?php echo esc_html__('Credentials', 'themedev-social-services');?></li>
						<li class="tab__list__item" onclick="next_tab_control(this)" nx-target="#next_tab_<?php echo $kk;?>__button" nx-target-common=".next-tab-item" ><?php echo esc_html__('Buttons', 'themedev-social-services');?></li>
						<li class="tab__list__item" onclick="next_tab_control(this)" nx-target="#next_tab_<?php echo $kk;?>__shortcode" nx-target-common=".next-tab-item" ><?php echo esc_html__('Shortcode', 'themedev-social-services');?></li>
						<li class="tab__list__item" onclick="next_tab_control(this)" nx-target="#next_tab_<?php echo $kk;?>__callback" nx-target-common=".next-tab-item" ><?php echo esc_html__('Callback', 'themedev-social-services');?></li>
					</ul>
				</div>
				<button type="button" class="next-btn danger" onclick="next_hide_popup(this);" ><?php echo esc_html__('X');?></button>
			</div>
			<div class="next-modal-body">
				<div class="next--tab__post__details tabContent">
					<h6 class="next_section-title"><?php echo esc_html__($vv, 'themedev-social-services');?></h6>
					<div class="tabItem next-tab-item active" id="next_tab_<?php echo $kk;?>__crediential">
						<div class="setting-section">
							<h3><?php echo esc_html__('Credentials ', 'themedev-social-services');?></h3>
							<div class="next-section-blog">
								<div class="setting-label-wraper">
									<label class="setting-label" for="<?php echo $kk;?>_enable"><?php echo __('Enable '.$vv.'', 'themedev-social-services');?> 
									<span> -
									<?php if($kk == 'facebook'){
											echo __('Go to <a href="'.esc_url('https://developers.facebook.com/apps/').'" target="_blank">https://developers.facebook.com/apps/</a>');
										 }else if($kk == 'linkedin'){
											echo __('Go to <a href="'.esc_url('https://www.linkedin.com/developers/').'" target="_blank">https://www.linkedin.com/developers/</a>');
										}else if($kk == 'dribbble'){
											echo __('Go to <a href="'.esc_url('https://developer.dribbble.com/v1/oauth/').'" target="_blank">https://developer.dribbble.com/v1/oauth/ </a>, <a href="'.esc_url('https://dribbble.com/account/applications/').'" target="_blank"> https://dribbble.com/account/applications/</a>');
										}else if($kk == 'twitter'){
											echo __('Go to <a href="'.esc_url('	https://developer.twitter.com/en/apps/create').'" target="_blank">https://developer.twitter.com/en/apps/create</a>');
										}else if($kk == 'google'){
											echo __('Go to <a href="'.esc_url('https://console.developers.google.com/apis/').'" target="_blank">https://console.developers.google.com/apis/</a>');
										}else if($kk == 'bitbucket'){
											echo __('Go to <a href="'.esc_url('https://developer.atlassian.com/bitbucket/concepts/oauth2.html').'" target="_blank">https://developer.atlassian.com/bitbucket/</a>');
										}else if($kk == 'instagram'){
											echo __('Go to <a href="'.esc_url('https://www.instagram.com/developer/authentication/').'" target="_blank">https://www.instagram.com/developer/authentication/</a>');
										}else if($kk == 'github'){
											echo __('Go to <a href="'.esc_url('https://developer.github.com/apps/building-oauth-apps/authorizing-oauth-apps/').'" target="_blank">https://github.com/settings/developers/</a>');
										}else if($kk == 'envato'){
											echo __('Go to <a href="'.esc_url('https://build.envato.com/').'" target="_blank">https://build.envato.com/</a>');
										}else if($kk == 'wordpress'){
											echo __('Go to <a href="'.esc_url('https://developer.wordpress.com/apps/').'" target="_blank">https://developer.wordpress.com/apps/</a>');
										}else if($kk == 'pinterest'){
											echo __('Go to <a href="'.esc_url('https://developers.pinterest.com/apps/').'" target="_blank">https://developers.pinterest.com/apps/</a>');
										}else if($kk == 'mailchimp'){
											echo __('Go to <a href="'.esc_url('https://developer.mailchimp.com/documentation/mailchimp/guides/how-to-use-oauth2/').'" target="_blank">https://developer.mailchimp.com/documentation/mailchimp/</a>');
										}else if($kk == 'yandex'){
											echo __('Go to <a href="'.esc_url('https://tech.yandex.com/oauth/doc/dg/tasks/register-client-docpage/').'" target="_blank">https://tech.yandex.com/oauth/</a>');
										}
									?>
									</span>
									</label>
								</div>
								<input type="checkbox" onclick="themedev_show(this);" nx-target=".next-custom-login-page" name="themedev[provider][<?php echo $kk ;?>][enable]" <?php echo isset($getProvider['provider'][$kk]['enable']) ? 'checked' : ''; ?> class="themedev-switch-input" value="Yes" id="themedev-provider-<?php echo $kk ;?>-enable"/>
								<label class="themedev-checkbox-switch" for="themedev-provider-<?php echo $kk ;?>-enable">
									<span class="themedev-label-switch" data-active="ON" data-inactive="OFF"></span>
								</label>
							</div>
							<?php
							$app_label = 'App ID';
							$secrect_label = 'App Secret';
							if(in_array($kk, ['yandex'])){
								$app_label = 'ID';
								$secrect_label = 'Password';
							}else if(in_array($kk, ['twitter'])){
								$app_label = 'App Key';
							}else if(in_array($kk, ['instagram', 'github', 'linkedin', 'google', 'wordpress', 'mailchimp'])){
								$app_label = 'Client ID';
								$secrect_label = 'Client Secret';
							}else if(in_array($kk, ['envato'])){
								$app_label = 'OAuth Client ID';
								$secrect_label = 'Access Token';
							}else if(in_array($kk, ['bitbucket'])){
								$app_label = 'Key';
								$secrect_label = 'Secret';
							}
							?>
							<div class="next-section-blog next-custom-login-page  nx-hide-target <?php echo isset($getProvider['provider'][$kk]['enable']) ? 'nx-show-target' : ''?>">
								<div class="setting-label-wraper">
									<label class="setting-label" for="<?php echo $kk;?>_appid"><?php echo __($app_label, 'themedev-social-services');?> </label>
								</div>
								<input placeholder="741888455955744" name="themedev[provider][<?php echo $kk;?>][id]" type="text" id="<?php echo $kk;?>_appid" value="<?php echo esc_html(isset($getProvider['provider'][$kk]['id']) ? $getProvider['provider'][$kk]['id'] : '');?>" class="next-regular-text">
							</div>
							<div class="next-section-blog next-custom-login-page  nx-hide-target <?php echo isset($getProvider['provider'][$kk]['enable']) ? 'nx-show-target' : ''?>">
								<div class="setting-label-wraper">
									<label class="setting-label" for="<?php echo $kk;?>_secret"><?php echo __($secrect_label, 'themedev-social-services');?></label>
								</div>
								<input placeholder="32fd74bcaacf588c4572946f201eee8e" name="themedev[provider][<?php echo $kk;?>][secret]" type="text" id="<?php echo $kk;?>_secret" value="<?php echo esc_html(isset($getProvider['provider'][$kk]['secret']) ? $getProvider['provider'][$kk]['secret'] : '');?>" class="next-regular-text">
							</div>
							
						</div>
					</div>
					<div class="tabItem next-tab-item" id="next_tab_<?php echo $kk;?>__button">
						<div class="button-section">
							<h3><?php echo esc_html__('Button Content', 'themedev-social-services');?></h3>
							<div class="next-section-blog">
								<div class="setting-label-wraper">
									<label class="setting-label"  for="<?php echo $kk;?>_login_label"><?php echo esc_html__('Label Text ', 'themedev-social-services');?> </label>
								</div>
								<input placeholder="Login with <?php echo $vv; ?>" name="themedev[provider][<?php echo $kk;?>][login]" type="text" id="<?php echo $kk;?>_login_label" value="<?php echo esc_html(isset($getProvider['provider'][$kk]['login']) ? $getProvider['provider'][$kk]['login'] : 'Login with '.$vv.'');?>" class="next-regular-text">
							</div>
							
							<div class="next-section-blog">
								<div class="setting-label-wraper">
									<label class="setting-label" for="<?php echo $kk;?>_logo_label"><?php echo esc_html__('Custom Icon Class ', 'themedev-social-services');?> </label>
								</div>
								<input placeholder="Icon url of <?php echo $vv; ?>" name="themedev[provider][<?php echo $kk;?>][logo_url]" type="text" id="<?php echo $kk;?>_logo_label" value="<?php echo esc_html(isset($getProvider['provider'][$kk]['logo_url']) ? $getProvider['provider'][$kk]['logo_url'] : '');?>" class="next-regular-text">
							</div>
						</div>
					</div>
					<div class="tabItem next-tab-item" id="next_tab_<?php echo $kk;?>__shortcode">
						<div class="shortcode-section">
							<h3><?php echo esc_html__('Shortcode ', 'themedev-social-services');?></h3>
							<div class="short-code-section" style="cursor: copy;" onclick="themedev_copy_link(this)" themedev-link='[next-social-login provider="<?php echo esc_html($kk);?>" btn-text="Login with <?php echo esc_html($vv);?>"]'>
								<pre style="cursor: copy;">[next-social-login provider="<?php echo esc_html($kk);?>" btn-text="Login with <?php echo esc_html($vv);?>"]</pre>
							</div>
							<?php _e('<strong>Link</strong>');?>
							<div class="short-code-section" style="cursor: copy;" onclick="themedev_copy_link(this)" themedev-link="<?php echo esc_url(get_site_url().'/wp-json/next-social-login/provider/'.$kk);?>">
								<pre style="cursor: copy;">Now click for copy Link</pre>
							</div>
						</div>
					</div>
					<div class="tabItem next-tab-item" id="next_tab_<?php echo $kk;?>__callback">
						<div class="callback-section">
							<h3><?php echo esc_html__('Callback URL ', 'themedev-social-services');?></h3>
							<div class="short-code-section" style="cursor: copy;" onclick="themedev_copy_link(this)" themedev-link='<?php echo get_site_url().'/wp-json/next-social-login/provider/'.esc_html($kk);?>'>
								<pre style="cursor: copy;"><?php echo get_site_url().'/wp-json/next-social-login/provider/'.esc_html($kk);?></pre>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="next-modal-footer">
				<button type="submit" name="themedev-social-providers" class="next-btn btn-special"><?php echo esc_html__('Save');?></button>
			</div>
		</div>
	</div>
			<?php }
			endforeach;
		}
	?>
	<div class="next-backdrop"></div>
	</div>
	
</form>

<script>
jQuery( function() {
jQuery( "#themedev-social-sortable" ).sortable();
jQuery( "#themedev-social-sortable" ).disableSelection();
} );
</script>