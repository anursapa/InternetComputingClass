<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface HC4_Html_Screen_Interface
{
	public function __invoke( $slug, $result, $isAjax );
}