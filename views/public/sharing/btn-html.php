<div id="<?php echo esc_attr( 'next_social_share_section' );?>" class="next-social-sharing <?php echo $this->content_position; ?> <?php echo  esc_attr($this->class_name );?>" >
	<ul class="_next_style_ul next-ul-<?php echo  esc_attr($this->btn_style);?>">
		<?php
			$getProviderSorting = get_option( '__next_social_sotring_sharing_provider', '' );
			if( is_array($getProviderSorting) && sizeof($getProviderSorting) > 0){
				$order_provider = $getProviderSorting;
			}else{
				$order_provider = $provider;
			}
			$prev_data	 = get_post_meta( $postId, '__next_share_data_post', true ) ? get_post_meta( $postId, '__next_share_data_post', true ) : [];
							
			if(is_array($order_provider) && sizeof($order_provider) > 0){
				foreach($order_provider as $k=>$v):
					if(in_array($k, $this->allow_pro) ){
						if(isset($provider[$k]['enable']) && $getAPiServices[$k] ){
							
							$defalut_text = isset($this->but_content[$k]['login']) ? $this->but_content[$k]['login'] : '';
							$btn_text = isset($provider[$k]['data']['label']) ? $provider[$k]['data']['label'] : $defalut_text;
							
							$add_text = isset($provider[$k]['data']['text']) ? $provider[$k]['data']['text'] : '';
							
							$pre_data = isset($prev_data[$k]) ? $prev_data[$k] : 0;
							
							$count_text = isset($provider[$k]['data']['count']) ? $provider[$k]['data']['count'] : 0;
							$count_text = ($pre_data > $count_text) ? $pre_data : $count_text;
							
							$defalut_icon = 'nx-social nx-social-'.$k.$line_icon;
							$btn_icon = isset($this->getProvider['provider'][$k]['logo_url'])  && strlen($this->getProvider['provider'][$k]['logo_url']) > 2 ? $this->getProvider['provider'][$k]['logo_url'] : $defalut_icon;
							
							$getURL = isset($getAPiServices[$k]['url']) ? $getAPiServices[$k]['url'] : '';
							$getParams = isset($getAPiServices[$k]['params']) ? $getAPiServices[$k]['params'] : '';
							
							
							$urlCon = array_combine(
								 array_keys($getParams), 
								 array_map( function($v){ 
									global $currentUrl, $title, $author, $details, $source, $media, $app_id;
									return str_replace(['%%url%%', '%%title%%', '%%author%%', '%%details%%', '%%source%%', '%%media%%', '%%app_id%%'], [$currentUrl, $title, $author, $details, $source, $media, $app_id], $v); 
								 }, $getParams)
							);
							
							$params = http_build_query($urlCon , '&');
							
							$urlData = esc_url($getURL.'?'.$params);
							
							$posturl = isset($urlCon['url']) ? $urlCon['url'] : '';
							
							?>
								<li class="_next_style_li next-li-<?php echo  esc_attr($this->btn_style.' '.$k);?>">
									<a href="javascript:void('');" data-active="<?php echo  self::unit_converter($count_text); ?>" data-inactive="<?php echo __($add_text, 'themedev-social-services'); ?>" id="themedev_feed_<?php echo $k?>" onclick="themedev_feed_share(this);" nx-feed-link="<?php echo $urlData;?>">
										<div class="next-social-icon">
											<?php if( in_array($this->btn_style, ['button3', 'button1', 'button2', 'button4', 'button5', 'button6', 'button7', 'button8', 'button9', 'button10', 'button11', 'button12', 'button13', 'button14', 'button15', 'button16'] )){?>
											<div class="next-icon">
												<i class="<?php echo esc_attr( $btn_icon ); ?>"></i> 
											</div>
											<?php }
											
											 if( in_array($this->btn_style, ['button7', 'button9', 'button10', 'button11', 'button13', 'button14']) ){ ?>
												<span class="login-label"> <?php echo __($btn_text, 'themedev-social-services'); ?> </span> 
											 <?php }
											 if( in_array($this->btn_style, ['button1', 'button10',]) ){ ?>
												<span class="login-count"> <?php echo  self::unit_converter($count_text); ?> </span> 
											<?php } 
											if( in_array($this->btn_style, ['button1', ]) ){ ?>
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
		<?php 
		if( in_array($this->btn_style, ['button12', 'button13', 'button14']) ){ ?>
			<li class="_next_style_li next-li-<?php echo  esc_attr($this->btn_style);?> next-link">
				<a href="javascript:void('');" onclick="themedev_feed_copy_link(this);" nx-feed-link="<?php echo $posturl;?>">
					<div class="next-social-icon">
						<?php if( in_array($this->btn_style, ['button12', 'button13', 'button14'] )){?>
						<div class="next-icon">
							<i class="nx-social nx-social-link<?php echo $line_icon;?>"></i> 
						</div>
						<?php }
						if( in_array($this->btn_style, [ 'button13', 'button14']) ){ ?>
							<span class="login-label"> <?php echo __('Get Link', 'themedev-social-services'); ?> </span> 
						<?php }?>
					</div>
				</a>
			</li>
		<?php } ?>
	</ul>
</div>