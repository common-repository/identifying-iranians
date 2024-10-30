<?php
function vahidd_downloadgeodatabase() {
/*
 * Download the GeoIP database from MaxMind
 */
 /* GeoLite URL */
	
 if( !class_exists( 'WP_Http' ) )
        include_once( ABSPATH . WPINC. '/class-http.php' );

	global $geodbfile;
	$url = 'http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz';
	$geofile = $geodbfile;
 $request = new WP_Http ();
 $result = $request->request ( $url );
 $content = array ();

 if ((in_array ( '403', $result ['response'] )) && (preg_match('/Rate limited exceeded, please try again in 24 hours./', $result['body'] )) )  {
 ?>
 	<p>خطا: قادر به دريافت فايل ديتابيس از آدرس <?php echo $url;?> نيستيم.<br />
	سرور کامپيوتر و يا آي پي هاست شما را براي 24 ساعت بن کرده است.<br />
	مي توانيد فايل را خودتان دانلود کرده و در مسير رو به رو کپي نماييد.<br /> <strong><?php echo $geofile;?></strong></p>
 <?php
 }
 elseif ((isset ( $result->errors )) || (! (in_array ( '200', $result ['response'] )))) {
 ?>
 	<p>خطا: قادر به دريافت فايل ديتابيس از آدرس رو به رو نيستيم. <?php echo $url;?><br />
	لطفا فايل را به صورت دستي دانلود و در مسير رو به رو کپي نماييد.<br /> 
	<strong><?php echo $geofile;?></strong></p>
 <?php
 } else {

//	global $geodbfile;
			
	/* Download file */
	if (file_exists ( $geofile . ".gz" )) { unlink ( $geofile . ".gz" ); }
	$content = $result ['body'];
	$fp = fopen ( $geofile . ".gz", "w" );
	fwrite ( $fp, "$content" );
	fclose ( $fp );
		
	/* Unzip this file and throw it away afterwards*/
	$zd = gzopen ( $geofile . ".gz", "r" );
	$buffer = gzread ( $zd, 2000000 );
	gzclose ( $zd );
	if (file_exists ( $geofile . ".gz" )) { unlink ( $geofile . ".gz" ); }
			
	/* Write this file to the GeoIP database file */
	if (file_exists ( $geofile )) { unlink ( $geofile ); } 
	$fp = fopen ( $geofile, "w" );
	fwrite ( $fp, "$buffer" );
	fclose ( $fp );
	print "<p>دانلود به اتمام رسيد!</p>";	
 }
 print "<hr>";
}

?>