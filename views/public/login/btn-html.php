<div id="<?php echo esc_attr( 'next_social_login_section' );?>" class="next-social-login <?php echo  esc_attr($this->class_name );?>" >
	<ul class="_next_style_ul next-ul-<?php echo  esc_attr($this->btn_style);?>">
		<?php
			$getProviderSorting = get_option( '__next_social_sotring_login_provider', '' );
			if( is_array($getProviderSorting) && sizeof($getProviderSorting) > 0){
				$order_provider = $getProviderSorting;
			}else{
				$order_provider = $provider;
			}
			
			if(is_array($order_provider) && sizeof($order_provider) > 0){
				foreach($order_provider as $k=>$v):
					if(in_array($k, $this->allow_pro) ){
						if(isset($provider[$k]['enable']) && $provider[$k]['enable'] == 'Yes' ){
							$defalut_text = isset($provider[$k]['login']) ? $provider[$k]['login'] : '';
							$btn_text = isset($this->but_content[$k]['login']) ? $this->but_content[$k]['login'] : $defalut_text;
							
							$defalut_icon = 'nx-social nx-social-'.$k.$line_icon;
							$btn_icon = isset($this->getProvider['provider'][$k]['logo_url'])  && strlen($this->getProvider['provider'][$k]['logo_url']) > 2 ? $this->getProvider['provider'][$k]['logo_url'] : $defalut_icon;
							
							?>
								<li class="_next_style_li next-li-<?php echo  esc_attr($this->btn_style.' '.$k);?>" title="<?php echo ucfirst($k);?>">
									<a href="<?php echo esc_url(get_site_url().'/wp-json/next-social-login/provider/'.$k); ?>">
										<div class="next-social-icon">
											<?php if( in_array($this->btn_style, ['button1', 'button2', 'button4', 'button5', 'button6', 'button7', 'button9', 'button10', 'button11'] )){?>
											<div class="next-icon">
												<i class="<?php echo esc_attr( $btn_icon ); ?>"></i>
											</div>
											<?php }
											 if( in_array($this->btn_style, ['button1', 'button3', 'button4', 'button7', 'button8', 'button9', 'button10', 'button11']) ){ ?>
												<span class="login-text"> <?php echo __($btn_text, 'themedev-social-services'); ?> </span>
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