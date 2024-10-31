
<form action="<?php echo esc_url(admin_url().'admin.php?page=next-social-counter&tab=providers');?>" name="setting_ebay_form" method="post" >
	<h3><?php echo esc_html__('Next Providers', 'themedev-social-services');?></h3>
	<div class="next-providers">
		<div class="next-social-block-wraper">
			<ul class="next-social-block next-sharing ui-sortable" id="themedev-social-sortable" >
				<?php
				$icon_style = isset($getGeneral['general']['icon_style']) ? $getGeneral['general']['icon_style'] : 'line';
				$line = ($icon_style == 'line')	? '-line' : '';
				
				if(is_array($order_provider) && sizeof($order_provider) > 0){
					foreach($order_provider as $k=>$v):
						$pro_class = '';
						$pro_enable = false;
						if(!file_exists( NEXT_SOCIAL_FEED_PLUGIN_PATH .'/apps/counters/'.$k.'.php' )){
							$pro_class = 'next-pro-service';
							$pro_enable = true;
						}
						
						$provider_data = isset($provider[$k]) ? $provider[$k] : [];
						$name = isset($provider_data['name']) ? $provider_data['name'] : ucfirst($k); 
				?>
				<li class="ui-state-default">
					<div class="next-single-social-block <?php echo $pro_class;?> <?php echo $k;?>" title="<?php echo esc_html($name, 'themedev-social-services');?>" <?php if(!$pro_enable){?> onclick="next_modal_popup(this)" <?php }?> nx-target-common=".next-modal-dialog" nx-target="#next-modal-<?php echo $k;?>" nx-target=".next-custom-login-page" >
						<div class="next-block-header " >
							<div class="next-social-icon">
								<i class="nx-social nx-social-<?php echo $k.$line;?>"></i>
							</div>
							
						</div>
						<div class="next-block-footer">
							<h6 class="next_section-title <?php echo isset($getProvider['provider'][$k]['enable']) ? 'enable-ser' : ''; ?> "><?php echo esc_html__($name, 'themedev-social-services');?></h6>
						</div>
						<input type="hidden" name="countersorting[<?php echo $k;?>]" value="<?php echo $k;?>">
					</div>
				</li>
				<?php endforeach;
					}
				?>
			</ul>
		</div>
		<div class="<?php echo esc_attr('themeDev-form');?>">
			<label><input type="checkbox" value="Yes" name="next_cache">  <?php echo esc_html__('Cache Clear for Update Previous Counter Data.', 'themedev-social-services');?>	</label>
		</div>
		<div class="<?php echo esc_attr('themeDev-form');?>">
			<button type="submit" name="themedev-social-providers" class="themedev-submit"> <?php echo esc_html__('Save ', 'themedev-social-services');?></button>
		</div>
	
	<?php
	
	if(is_array($order_provider) && sizeof($order_provider) > 0){	
		$counter = new \themeDevSocial\Apps\Counter(false);
		$filed = $counter->next_counter_providers_data();

		foreach($order_provider as $kk=>$vv):
			if(file_exists( NEXT_SOCIAL_FEED_PLUGIN_PATH .'/apps/counters/'.$kk.'.php' )){
				$provider_data = isset($provider[$kk]) ? $provider[$kk] : [];
				$name = isset($provider_data['name']) ? $provider_data['name'] : ucfirst($kk); 

				$label_text = isset($getProvider['provider'][$kk]['data']['label']) ? $getProvider['provider'][$kk]['data']['label'] : $name;	
				$followers_text = isset($getProvider['provider'][$kk]['data']['text']) ? $getProvider['provider'][$kk]['data']['text'] : 'Followers';
				$followers_count = isset($getProvider['provider'][$kk]['data']['count']) ? (int) $getProvider['provider'][$kk]['data']['count'] : 0;
	?>
		<div class="next-modal-dialog <?php echo  ($get_type == $kk) ? esc_attr('is-open') : ''; ?>" id="next-modal-<?php echo $kk;?>">
			<div class="next-modal-content post__tab">
				<div class="next-modal-header clear-both">
					<div class="tabHeader">
						<ul class="tab__list clear-both">
							<li class="tab__list__item <?php echo  (empty($get_type)) ? esc_attr('active') : ''; ?>" onclick="next_tab_control(this)" nx-target="#next_tab_<?php echo $kk;?>__setup" nx-target-common=".next-tab-item" ><?php echo esc_html__('Setup', 'themedev-social-services');?></li>
							<li class="tab__list__item <?php echo  (!empty($get_type)) ? esc_attr('active') : ''; ?>" onclick="next_tab_control(this)" nx-target="#next_tab_<?php echo $kk;?>__crediential" nx-target-common=".next-tab-item" ><?php echo esc_html__('Credentials', 'themedev-social-services');?></li>
						</ul>
					</div>
					<button type="button" class="next-btn danger" onclick="next_hide_popup(this);" ><?php echo esc_html__('X');?></button>
				</div>
				<div class="next-modal-body">
					<div class="next--tab__post__details tabContent">
						<h6 class="next_section-title"><?php echo esc_html__($name, 'themedev-social-services');?></h6>
						<!--Setup Data-->
						<div class="tabItem next-tab-item <?php echo  (empty($get_type)) ? esc_attr('active') : ''; ?>" id="next_tab_<?php echo $kk;?>__setup">
							<div class="setting-section">
								<h3><?php echo esc_html__('Setup ', 'themedev-social-services');?></h3>
								
								<div class="next-section-blog ">
									<div class="setting-label-wraper">
										<label class="setting-label" for="<?php echo $kk;?>_enable"><?php echo __('Enable '.$name.'', 'themedev-social-services');?> 
									</div>
									
								</div>
								<div class="next-section-blog next-custom-login-page ">		
									<input onclick="themedev_show(this);" nx-target=".next-custom-login-page"  type="checkbox" name="themedev[provider][<?php echo $kk ;?>][enable]" <?php echo isset($getProvider['provider'][$kk]['enable']) ? 'checked' : ''; ?> class="themedev-switch-input" value="Yes" id="themedev-provider-<?php echo $kk ;?>-enable"/>
									<label class="themedev-checkbox-switch" for="themedev-provider-<?php echo $kk ;?>-enable">
										<span class="themedev-label-switch" data-active="ON" data-inactive="OFF"></span>
									</label>
								</div>
								<div class="next-section-blog next-custom-login-page  nx-hide-target <?php echo isset($getProvider['provider'][$kk]['enable']) ? 'nx-show-target' : ''?>">
									<div class="setting-label-wraper">
										<label class="setting-label" for="<?php echo $kk;?>_label"><?php echo __('Label', 'themedev-social-services');?> </label>
									</div>
									<input placeholder="Label Name" name="themedev[provider][<?php echo $kk;?>][data][label]" type="text" id="<?php echo $kk;?>_label" value="<?php echo esc_html( $label_text );?>" class="next-regular-text">
								</div>
								<div class="next-section-blog next-custom-login-page  nx-hide-target <?php echo isset($getProvider['provider'][$kk]['enable']) ? 'nx-show-target' : ''?>">
									<div class="setting-label-wraper">
										<label class="setting-label" for="<?php echo $kk;?>_count"><?php echo __('Default '.$followers_text, 'themedev-social-services');?> </label>
									</div>
									<input placeholder="Label Name" name="themedev[provider][<?php echo $kk;?>][data][count]" type="text" id="<?php echo $kk;?>_count" value="<?php echo esc_html($followers_count);?>" class="next-regular-text">
								</div>
								<div class="next-section-blog next-custom-login-page  nx-hide-target <?php echo isset($getProvider['provider'][$kk]['enable']) ? 'nx-show-target' : ''?>">
									<div class="setting-label-wraper">
										<label class="setting-label" for="<?php echo $kk;?>_text"><?php echo __('Additional Text', 'themedev-social-services');?> </label>
									</div>
									<input placeholder="Label Name" name="themedev[provider][<?php echo $kk;?>][data][text]" type="text" id="<?php echo $kk;?>_text" value="<?php echo esc_html( $followers_text );?>" class="next-regular-text">
								</div>


							</div>
						</div>
						<!--Setup Credientails-->
						<div class="tabItem next-tab-item <?php echo  (!empty($get_type)) ? esc_attr('active') : ''; ?>" id="next_tab_<?php echo $kk;?>__crediential">
							<div class="setting-section">
								<h3><?php echo esc_html__('Credentials ', 'themedev-social-services');?></h3>
								<?php
									$filedData = isset($filed[$kk]) ? $filed[$kk] : '';
									
									if(is_array($filedData)){
										foreach($filedData as $fk=>$fv):
											$lavelFIled = isset($fv['label']) ? $fv['label'] : 'Id';
						
											$input = isset($fv['input']) ? $fv['input'] : 'text';
											$type = isset($fv['type']) ? $fv['type'] : 'normal';
											
											$set_data = (isset($getProvider['provider'][$kk][$fk]) && strlen($getProvider['provider'][$kk][$fk]) > 2) ? $getProvider['provider'][$kk][$fk] : '';
											
								?>
											<div class="next-section-blog <?php echo ($type == 'access') ? 'next-access-button-inline' : '';?>">
												<div class="setting-label-wraper">
													<label class="setting-label" for="<?php echo $kk;?>_[<?php echo $fk;?>]_label"><?php echo __($lavelFIled, 'themedev-social-services');?> </label>
												</div>
												<?php if( $input == 'text' ){?>
													<input  name="themedev[provider][<?php echo $kk;?>][<?php echo $fk;?>]" type="text" id="<?php echo $kk;?>_[<?php echo $fk;?>]_label" value="<?php echo esc_html( $set_data );?>" class="next-regular-text">
													<?php
													if($type == 'access'){?>
														<button class="next-button-none" onclick="themedev_show(this);"  nx-target="#next_token_<?php echo $kk;?>__<?php echo $fk;?>__access" type="button"> <?php echo esc_html__('Get Access Token', 'themedev-social-services'); ?></button>
													
														<div class="nx-hide-target" id="next_token_<?php echo $kk;?>__<?php echo $fk;?>__access">
														<?php
														$filed_api = isset($fv['filed']) ? $fv['filed'] : '';													
														if(is_array($filed_api)){
															foreach($filed_api as $fkl=>$fvl){
																$value_APp = (isset($getProvider['provider'][$kk][$fkl]) && strlen($getProvider['provider'][$kk][$fkl]) > 2) ? $getProvider['provider'][$kk][$fkl] : '';
																?>
																	<div class="xs-counter-lavel form-table">
																		<div class="setting-label-wraper">
																			<label class="setting-label" for="next_cre_<?php echo $kk;?>_<?php echo $fkl;?>"><?php echo __($fvl, 'themedev-social-services');?> </label>
																		</div>
																		<input type="text" name="accesskey[<?php echo $kk;?>][<?php echo $fkl;?>]" class="next-regular-text" id="next_cre_<?php echo $kk;?>_<?php echo $fkl;?>" value="<?php echo $value_APp;?>" >
																	</div>
																	<input  name="themedev[provider][<?php echo $kk;?>][<?php echo $fkl;?>]" type="hidden" value="<?php echo esc_html( $value_APp );?>" >
																<?php
															}
														}
														?>
														<div class="xs-counter-lavel form-table">
															<button type="submit" formaction="<?php echo esc_url(admin_url().'admin.php?page=next-social-counter&tab=providers&type='.$kk);?>" name="next_access_token" class="next-btn next-special"><?php echo esc_html__('Generate Token', 'themedev-social-services');?></button>
															
															<?php
															$callBack = admin_url().'admin.php?page=next-social-counter&tab=providers&type='.$kk;
															if($kk == 'instagram'){
																?>
																<p class="next-api-document"><?php echo esc_html__('Go to APP Settings', 'themedev-social-services');?><a href="<?php echo esc_url('https://www.instagram.com/developer/clients/manage/');?>"> <?php echo esc_html__('App Settings ', 'themedev-social-services');?></a></p>
																<p class="next-api-document"><?php echo esc_html__('Set Callback URL:', 'themedev-social-services');?> <strong><?php echo esc_url($callBack);?></strong></p>
															<?php }
															if($kk == 'linkedin'){
																?>
																<p class="next-api-document"><?php echo esc_html__('Go to APP Settings ', 'themedev-social-services');?><a href="<?php echo esc_url('https://www.linkedin.com/developers/');?>"> <?php echo esc_html__('App Settings ', 'themedev-social-services');?></a></p>
																<p class="next-api-document"><?php echo esc_html__('Set Callback URL:', 'themedev-social-services');?> <strong><?php echo esc_url($callBack);?></strong></p>
															<?php }
															if($kk == 'dribbble'){
																?>
																<p class="next-api-document"><?php echo esc_html__('Go to APP Settings', 'themedev-social-services');?><a href="<?php echo esc_url('https://dribbble.com/account/applications/');?>"> <?php echo esc_html__('App Settings ', 'themedev-social-services');?></a></p>
																<p class="next-api-document"><?php echo esc_html__('Set Callback URL:', 'themedev-social-services');?> <strong><?php echo esc_url($callBack);?></strong></p>
															<?php }
															 if($kk == 'twitter'){
																 ?>
																<p class="next-api-document"><?php echo esc_html__('Go to APP Settings', 'themedev-social-services');?><a href="<?php echo esc_url('https://developer.twitter.com/en/apps/create');?>"> <?php echo esc_html__('App Settings ', 'themedev-social-services');?></a></p>
															<?php }
															if($kk == 'facebook'){
																 ?>
																<p class="next-api-document"><?php echo esc_html__('Go to APP Settings', 'themedev-social-services');?><a href="<?php echo esc_url('https://developers.facebook.com/apps/');?>"> <?php echo esc_html__('App Settings ', 'themedev-social-services');?></a></p>
																<p class="next-api-document"><?php echo esc_html__('Set Callback URL:', 'themedev-social-services');?> <strong><?php echo esc_url($callBack);?></strong></p>
															<?php }
															if($kk == 'envato'){
																?>
																<p class="next-api-document"><?php echo esc_html__('Go to APP Settings', 'themedev-social-services');?><a href="<?php echo esc_url('https://build.envato.com/my-apps');?>"> <?php echo esc_html__('App Settings ', 'themedev-social-services');?></a></p>
																<p class="next-api-document"><?php echo esc_html__('Set Callback URL:', 'themedev-social-services');?> <strong><?php echo esc_url($callBack);?></strong></p>
															<?php }
															if($kk == 'github'){
																?>
																<p class="next-api-document"><?php echo esc_html__('Go to APP Settings', 'themedev-social-services');?><a href="<?php echo esc_url('https://github.com/settings/applications/');?>"> <?php echo esc_html__('App Settings ', 'themedev-social-services');?></a></p>
																<p class="next-api-document"><?php echo esc_html__('Set Callback URL:', 'themedev-social-services');?> <strong><?php echo esc_url($callBack);?></strong></p>
															<?php } ?>
														</div>
													</div>		
													<?php
													}
													?>
												<?php }else if($input == 'select'){
													$dataSelect = isset($fv['data']) ? $fv['data'] : '';
									
													if(is_array($dataSelect)){
													?>	
														<select name="themedev[provider][<?php echo $kk;?>][<?php echo $fk;?>]" id="<?php echo $kk;?>_[<?php echo $fk;?>]_label">
															<?php foreach($dataSelect as $dk=>$dv):?>
																<option value="<?php echo $dk;?>" <?php echo ($set_data == $dk) ? 'selected' : '';?>><?php echo $dv;?> </option>
															<?php endforeach;?>
														</select>
												<?php }
												}?>
											</div>
								<?php
										endforeach;
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="next-modal-footer">
					<button type="submit" name="themedev-social-providers" class="next-btn btn-special"><?php echo esc_html__('Save');?></button>
				</div>
			</div>
		</div>
			<?php 
			}
			endforeach;
		}
	?>
	<div class="next-backdrop <?php echo  (!empty($get_type)) ? esc_attr('is-open') : ''; ?>"></div>
	</div>
</form>

<script>
jQuery( function() {
	jQuery( "#themedev-social-sortable" ).sortable();
	jQuery( "#themedev-social-sortable" ).disableSelection();
} );
</script>