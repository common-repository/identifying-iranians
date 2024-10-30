<?php
	if (file_exists($geodbfile)) {
		require_once( vahidd_plugin_dir . "/geoip.inc");
		$gi = geoip_open( vahidd_plugin_dir . "/GeoIP.dat" , GEOIP_STANDARD );
		$country_code = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
		$country_name = geoip_country_name_by_addr($gi, $_SERVER['REMOTE_ADDR']);
		geoip_close($gi);
	}
	
	function is_IR() {
		global $country_name,$country_code;
		if ( $country_code == 'IR' ) :
			return true;
		else:
			return false;
		endif;
	}
	
	function get_country_code() {
		global $country_name,$country_code;
		return $country_code;
	}
	define( 'CountryCode' , get_country_code() );
	
	function get_country_name($lang) {
		global $country_name,$country_code;
		if ( $lang == 'fa' ) 
		{
			if     ( $country_code == "IR" ) { echo 'ایران'; }
			elseif ( $country_code == "US" ) { echo 'ایالات متحده آمریکا'; }
			elseif ( $country_code == "UK" ) { echo 'انگلستان'; }
			elseif ( $country_code == "IQ" ) { echo 'عراق'; }
			else { echo 'کشور شما یافت نشد، می توانید از طریق فایل base.php که در پوشه پلاگین هست و کدی که از کشور شما در صفحه تنظیمات پلاگین داده شده است، برای کشور خود نامی تعیین کنید.';  }
		} 
		elseif ( $lang == 'en' ) 
		{
			return $country_name;
		}
	}
	define( 'CountryName' , get_country_name('en') );
	
	function iranian_shortcode( $atts, $content = null ) 
	{
		global $country_name,$country_code;
		extract( shortcode_atts( array(
			'class' => 'vahidd',
			'o' => 'no',
			), $atts ) );
			if ( $o == 'yes' &&  $country_code != 'IR' ) 
			{
				return '<span class="' . esc_attr($class) . '">' . $content . '</span>';
			}
			elseif ( $o == 'no' &&  $country_code == 'IR' ) 
			{
				return '<span class="' . esc_attr($class) . '">' . $content . '</span>';
			}
		}
	add_shortcode( 'iran', 'iranian_shortcode' );
?>