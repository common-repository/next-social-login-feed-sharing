<div class="next_sharing_custom_post_type" >
	<div class="themeDev-form" style="margin-top: 10px;">
		<div class="setting-section" style="display: flex; justify-content: space-between;align-items: center; ">
			<?php
				$enable = isset( $options['counter_meta']['enable'] ) ? $options['counter_meta']['enable'] : 'enable';
			?>
			<label class="inline-label">
				<?php echo esc_html__('Social Counter ', 'themedev-social-services');?>			
			</label>
			<select class="themedev-text-input inline-block" name="themedev_counter[counter_meta][enable]">
				<option value="enable" <?php echo ($enable == 'enable') ? 'selected' : '';?>> <?php echo esc_html__('Enable ', 'themedev-social-services');?> </option>
				<option value="disable" <?php echo ($enable == 'disable') ? 'selected' : '';?>> <?php echo esc_html__('Disable ', 'themedev-social-services');?> </option>
			</select>
		</div>
	</div>
	<div class="themeDev-form" style="margin-top: 10px;">
		<div class="setting-section" style="display: flex; justify-content: space-between;align-items: center; ">
			<?php
				$content_position = isset( $options['counter_meta']['content_position'] ) ? $options['counter_meta']['content_position'] : '';
			?>
			<label class="inline-label">
				<?php echo esc_html__('Counter Position ', 'themedev-social-services');?>			
			</label>
			
			<select class="themedev-text-input inline-block" name="themedev_counter[counter_meta][content_position]" >
				<option value=""> </option>
				<?php 
				foreach( $position as $k=>$v):
				?>
					<option value="<?php echo $k;?>" <?php echo ($content_position == $k) ? 'selected' : '';?> > <?php echo esc_html__($v, 'themedev-social-services');?></option>
				
				<?php endforeach;?>
			</select>
		</div>
	</div>
</div>