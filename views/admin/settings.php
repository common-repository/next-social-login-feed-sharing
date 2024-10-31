<section class="<?php echo esc_attr('themeDev-social-body');?>">
	<div class="header-settings">
		<figure>
			<img src="<?php echo NEXT_SOCIAL_FEED_PLUGIN_URL.'assets/images/icon-128x128.png'?>" alt="<?php esc_attr('Icon')?>">
		</figure>
		<h2 class="title"><?php echo esc_html__('Next Login Panel', 'themedev-social-services');?></h2>
	</div>
	<div class="nav-settings">
		<?php require ( NEXT_SOCIAL_FEED_PLUGIN_PATH.'views/admin/tab-menu-settings.php' );?>
	</div>
	<?php if($message_status == 'yes'){?>
    <div class="message-settings">
        <div class ="notice is-dismissible" style="margin: 1em 0px; visibility: visible; opacity: 1;">
            <p><?php echo esc_html__(''.$message_text.' ', 'themedev-social-services');?></p>
        </div>
    </div>
    <?php }?>
	<div class="settings-content">
		 <?php
		 if($active_tab == 'display'){ 
			include( __DIR__ .'/include/option-display.php');
		 }else if($active_tab == 'general'){
			 include( __DIR__ .'/include/option-general.php');
		 }else if($active_tab == 'global'){
			 include( __DIR__ .'/include/option-global.php');
		 }else if($active_tab == 'providers'){
			 include( __DIR__ .'/include/option-providers.php');
		 }else if($active_tab == 'shotrcode'){
			 include( __DIR__ .'/include/option-shotrcode.php');
		 }
		 ?>
	 </div>
</section>
