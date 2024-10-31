<?php
$active_tab = isset($_GET["tab"]) ? $_GET["tab"] : 'general';
?>
 <ul class="nav-tab-wrapper">
	<li><a href="<?php echo esc_url(admin_url().'admin.php?page=next-social-sharing&tab=general');?>" class="nav-tab <?php if($active_tab == 'general'){echo 'nav-tab-active';} ?>"><?php echo esc_html__('General', 'themedev-social-services');?></a></li>
	<li><a href="<?php echo esc_url(admin_url().'admin.php?page=next-social-sharing&tab=providers');?>" class="nav-tab <?php if($active_tab == 'providers'){echo 'nav-tab-active';} ?> "><?php echo esc_html__('Providers', 'themedev-social-services');?></a></li>
	<li><a href="<?php echo esc_url(admin_url().'admin.php?page=next-social-sharing&tab=display');?>" class="nav-tab <?php if($active_tab == 'display'){echo 'nav-tab-active';} ?>"><?php echo esc_html__('Display', 'themedev-social-services');?></a></li>
	<li><a href="<?php echo esc_url(admin_url().'admin.php?page=next-social-sharing&tab=shotrcode');?>" class="nav-tab <?php if($active_tab == 'shotrcode'){echo 'nav-tab-active';} ?>"><?php echo esc_html__('Shortcode', 'themedev-social-services');?></a></li>
</ul>