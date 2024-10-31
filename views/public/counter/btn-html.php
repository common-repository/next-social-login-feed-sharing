<div id="<?php echo esc_attr( 'next_social_counter_section' );?>" class="next-social-counter <?php echo $this->content_position; ?> <?php echo  esc_attr($this->class_name );?>" >
	<ul class="_next_style_ul next-ul-<?php echo  esc_attr($this->btn_style);?>">
		<?php
			$getProviderSorting = get_option( '__next_social_sotring_counter_provider', '' );
			if( is_array($getProviderSorting) && sizeof($getProviderSorting) > 0){
				$order_provider = $getProviderSorting;
			}else{
				$order_provider = $provider;
			}
			
			if(is_array($order_provider) && sizeof($order_provider) > 0){
				foreach($order_provider as $k=>$v):
					if(in_array($k, $this->allow_pro) ){
						if(isset($provider[$k]['enable']) && $provider[$k]['enable'] == 'Yes' ){
							
							$defalut_text = isset($this->but_content[$k]['login']) ? $this->but_content[$k]['login'] : '';
							$btn_text = isset($provider[$k]['data']['label']) ? $provider[$k]['data']['label'] : $defalut_text;
							
							$add_text = isset($provider[$k]['data']['text']) ? $provider[$k]['data']['text'] : '';
							
							$pre_data = isset($api_data[$k]) ? $api_data[$k] : 0;
							
							$count_text = isset($provider[$k]['data']['count']) ? $provider[$k]['data']['count'] : 0;
							$count_text = ($pre_data > $count_text) ? $pre_data : $count_text;
							
							$defalut_icon = 'nx-social nx-social-'.$k.$line_icon;
							$btn_icon = isset($this->getProvider['provider'][$k]['logo_url'])  && strlen($this->getProvider['provider'][$k]['logo_url']) > 2 ? $this->getProvider['provider'][$k]['logo_url'] : $defalut_icon;
							
							$id = isset($this->getProvider['provider'][$k]['user_id']) ? $this->getProvider['provider'][$k]['user_id'] : 'themedev2019';
							$type = isset($this->getProvider['provider'][$k]['type']) ? $this->getProvider['provider'][$k]['type'] : 'channel';
							$url_get = isset($getAPiServices[$k]['data']['url']) ? $getAPiServices[$k]['data']['url'] : '#';
							if($k == 'youtube'){
								$url = sprintf($url_get, strtolower($type), $id);
							}else if($k == 'linkedin'){
								if($type == 'Profile'){
									$url = sprintf($url_get, 'in', $id);
								}else{	
									$url = sprintf($url_get, 'company', $id);
								}
							}else{
								$url = sprintf($url_get, $id);
							}

							?>
								<li class="_next_style_li next-li-<?php echo  esc_attr($this->btn_style.' '.$k);?>" >
									<a href="<?php echo esc_url($url); ?>" data-active="<?php echo  self::unit_converter($count_text); ?>" data-inactive="<?php echo __($add_text, 'themedev-social-services'); ?>" target="_blank" title="<?php echo $btn_text;?>">
										<div class="next-social-icon">
											<?php if( in_array($this->btn_style, ['button1', 'button2', 'button3', 'button4', 'button4-1', 'button4-2', 'button5', 'button6', 'button7', 'button8', 'button9', 'button10', 'button11', 'button12', 'button13', 'button14', 'button15'])){?>
												<div class="next-icon">
													<i class="<?php echo esc_attr( $btn_icon ); ?>"></i> 
												</div>
											<?php }
											 if( in_array($this->btn_style, ['button1', 'button2', 'button3', 'button4', 'button4-1', 'button4-2', 'button5', 'button6', 'button7', 'button8', 'button9', 'button10', 'button11', 'button13', 'button14', 'button15']) ){ ?>
												<span class="login-count"> <?php echo __(self::unit_converter($count_text), 'themedev-social-services'); ?> </span>
											<?php }
											if( in_array($this->btn_style, ['button1', 'button2', 'button3', 'button4', 'button5', 'button6', 'button7', 'button8', 'button10', 'button15']) ){ ?>
												<span class="login-text"> <?php echo __($add_text, 'themedev-social-services'); ?> </span>
											<?php }?>
										</div>
									</a>
								</li>
							<?php
						}
					}
				endforeach;
			}
		?>
	</ul>
</div>