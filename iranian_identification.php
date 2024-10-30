<?php
/*
Plugin Name: افزونه شناسایی کاربران ایرانی
Plugin URI: http://vahidd.com
Description: افزونه ای ساده که شامل ابزارک، تابع و کد میانبر برای شناسایی کاربران ایرانی می باشد.
Version: 1.3
Author: Vahidd
Author URI: http://vahidd.com
License: GPLv2 or later
*/
	
	define( 'vahidd_plugin_url' , plugins_url(plugin_basename(dirname(__FILE__)).'/') );
	define( 'vahidd_plugin_dir' , WP_PLUGIN_DIR . "/" . dirname ( plugin_basename ( __FILE__ ) ) );
	$geodbfile = vahidd_plugin_dir . '/GeoIP.dat';
	require_once ( 'db_downloader.php');
	require_once ( 'vahidd_widget.php');
	require_once ( 'base.php');
	add_action ( 'admin_menu', 'iranian_else_plugin_create_menu' );
	function iranian_else_plugin_create_menu() {
		add_submenu_page( 'tools.php', 'افزونه ایرانیان', 'افزونه ایرانیان', 'manage_options', 'Iranian', 'global_custom_options' ); 
	}
    function global_custom_options()  
    {  
		global $geodbfile,$country_code,$country_name;
		?>
		<div class="wrap">  
			<form name="download_geoip" action="#download" method="post">
				<input type="hidden" name="action" value="download" />
				<div class="submit">
				<h3>افزونه شناسایی ایرانیان</h3>
					<p>در اصل این افزونه از دیتابیس GeoIP برای شناسایی کاربران ایرانی استفاده می کند، که این دیتابیس هر ماه به روز شده و آی پی های جدید به آن اضافه می شود، به همین خاطر نیاز است تا هر ماه با استفاده از دکمه زیر آخرین نسخه دیتابیس رو دانلود کنید.</p>
					<input type="submit" name="test" value="دریافت آخرین نسخه GeoIP" />
				</div>
				<?php wp_nonce_field('vahidd_iranian');?>
			</form>
				<?php 
					if ( isset( $_POST['action'] ) && $_POST[ 'action' ] == 'download') 
					{
						echo "در حال دانلود...";	
						vahidd_downloadgeodatabase('4');	
					}
					if (!file_exists($geodbfile)) 
					{
						echo '<p>فایل دیتابیس آی پی ها موجود نیست! در حال دانلود فایل...</p>';
						vahidd_downloadgeodatabase();
					} 
				?>
			<?php 
			if (file_exists($geodbfile)) {
				echo "<p style='color:#E0386D'>کد کشور شما <strong>$country_code</strong> و همچین نام کشور شما <strong>$country_name</strong> می باشد.</p>";
				echo '<p>پلاگین از <a href="http://vahidd.com">وحيد محمدي</a></p>';
				echo '<p>همچنین دوست عزیز اگر از این پلاگین استفاده لازم رو کردید خوش حال میشم به سایت موسیقی من یه سری بزنید و اگر براتون امکانش بود منو لینک کنید. <a href="http://music.vahidd.com">دانلود رایگان موسیقی</a></p>';
			}
			?>			
		</div>  
	<?php } ?>