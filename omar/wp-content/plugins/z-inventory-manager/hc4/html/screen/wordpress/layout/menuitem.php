<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Screen_WordPress_Layout_MenuItem
{
	public function __invoke( $event, $return, $slug, array $toLabel )
	{
		$return = str_replace( '<a ', '<a class="hc-block page-title-action hc-top-auto" ', $return );
		$return = str_replace( '<button ', '<button class="hc-block page-title-action hc-top-auto" ', $return );
		return $return;
	}
}