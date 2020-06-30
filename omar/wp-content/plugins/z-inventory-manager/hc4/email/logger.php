<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Email_Logger
{
	public function __invoke( $to, $subj, $body, $logFile )
	{
		$now = time();
		$date = date( "Y-m-d H:i", $now );

		$out = array();
		$out[] = $date;
		$out[] = $to;
		$out[] = $subj;
		$out[] = $body;
		// $out[] = '';
		$out = join( "\n", $out );

		$fp = fopen( $logFile, 'a' );
		fwrite( $fp, $out . "\n\n" );
		fclose( $fp );
	}
}