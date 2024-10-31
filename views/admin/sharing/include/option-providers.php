
<form action="<?php echo esc_url(admin_url().'admin.php?page=next-social-sharing&tab=providers');?>" name="setting_ebay_form" method="post" >
	<h3><?php echo esc_html__('Share Providers', 'themedev-social-services');?></h3>
	<div class="next-providers">
		<div class="next-social-block-wraper">
			<ul class="next-social-block next-sharing ui-sortable" id="themedev-social-sortable" >
				<?php
				$icon_style = isset($getGeneral['general']['icon_style']) ? $getGeneral['general']['icon_style'] : 'line';
                
				$line = ($icon_style == 'line')	? '-line' : '';
				
				if(is_array($order_provider) && sizeof($order_provider) > 0){
					foreach($order_provider as $k=>$v):
						$provider_data = isset($provider[$k]) ? $provider[$k] : [];
						$name = isset($provider_data['name']) ? $provider_data['name'] : ucfirst($k); 
				?>
				<li class="ui-state-default">
					<div class="next-single-social-block <?php echo $k;?>" title="<?php echo esc_html($name, 'themedev-social-services');?>" onclick="next_modal_popup(this)" nx-target-common=".next-modal-dialog" nx-target="#next-modal-<?php echo $k;?>" nx-target=".next-custom-login-page" >
						<div class="next-block-header" >
							<div class="next-social-icon">
								<i class="nx-social nx-social-<?php echo $k.$line;?>"></i>
							</div>
							
						</div>
						<div class="next-block-footer">
							<h6 class="next_section-title <?php echo isset($getProvider['provider'][$k]['enable']) ? 'enable-ser' : ''; ?> "><?php echo esc_html__($name, 'themedev-social-services');?></h6>
						</div>
						<input type="hidden" name="sharingsorting[<?php echo $k;?>]" value="<?php echo $k;?>">
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
	if(is_array($order_provider) && sizeof($order_provider) > 0){	
		foreach($order_provider as $kk=>$vv):
		$provider_data = isset($provider[$kk]) ? $provider[$kk] : [];
		$name = isset($provider_data['name']) ? $provider_data['name'] : ucfirst($kk); 
	?>

	<div class="next-modal-dialog" id="next-modal-<?php echo $kk;?>">
		<div class="next-modal-content post__tab">
			<div class="next-modal-header clear-both">
				<div class="tabHeader">
					<ul class="tab__list clear-both">
						<li class="tab__list__item active" onclick="next_tab_control(this)" nx-target="#next_tab_<?php echo $kk;?>__crediential" nx-target-common=".next-tab-item" ><?php echo esc_html__('Setup', 'themedev-social-services');?></li>
					</ul>
				</div>
				<button type="button" class="next-btn danger" onclick="next_hide_popup(this);" ><?php echo esc_html__('X');?></button>
			</div>
			<div class="next-modal-body">
				<div class="next--tab__post__details tabContent">
					<h6 class="next_section-title"><?php echo esc_html__($name, 'themedev-social-services');?></h6>
					<div class="tabItem next-tab-item active" id="next_tab_<?php echo $kk;?>__crediential">
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
								<input placeholder="Label Name" name="themedev[provider][<?php echo $kk;?>][data][label]" type="text" id="<?php echo $kk;?>_label" value="<?php echo esc_html(isset($getProvider['provider'][$kk]['data']['label']) ? $getProvider['provider'][$kk]['data']['label'] : $name);?>" class="next-regular-text">
							</div>
							<div class="next-section-blog next-custom-login-page  nx-hide-target <?php echo isset($getProvider['provider'][$kk]['enable']) ? 'nx-show-target' : ''?>">
								<div class="setting-label-wraper">
									<label class="setting-label" for="<?php echo $kk;?>_count"><?php echo __('Default Share Count', 'themedev-social-services');?> </label>
								</div>
								<input placeholder="Label Name" name="themedev[provider][<?php echo $kk;?>][data][count]" type="text" id="<?php echo $kk;?>_count" value="<?php echo esc_html(isset($getProvider['provider'][$kk]['data']['count']) ? $getProvider['provider'][$kk]['data']['count'] : 0);?>" class="next-regular-text">
							</div>
							<div class="next-section-blog next-custom-login-page  nx-hide-target <?php echo isset($getProvider['provider'][$kk]['enable']) ? 'nx-show-target' : ''?>">
								<div class="setting-label-wraper">
									<label class="setting-label" for="<?php echo $kk;?>_text"><?php echo __('Additional Text', 'themedev-social-services');?> </label>
								</div>
								<input placeholder="Label Name" name="themedev[provider][<?php echo $kk;?>][data][text]" type="text" id="<?php echo $kk;?>_text" value="<?php echo esc_html(isset($getProvider['provider'][$kk]['data']['text']) ? $getProvider['provider'][$kk]['data']['text'] : 'Share' );?>" class="next-regular-text">
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
			<?php 
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