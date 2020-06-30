<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Redirect_Header
	implements HC4_Redirect_Interface
{
	public function __invoke( $to )
	{
		if( ! headers_sent() ){
			header('Location: ' . $to);
		}
		else {
			$html = "<META http-equiv=\"refresh\" content=\"0;URL=$to\">";
			echo $html;
		}
		exit;
	}
}