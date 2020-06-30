<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Redirect_Ajax
	implements HC4_Redirect_Interface
{
	public function __invoke( $to )
	{
		$out = '<hc4redirect>' . $to . '</hc4redirect>';
		echo $out;
		exit;
	}
}