<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
interface HC4_Html_Screen_Enqueuer_Interface
{
/**
* Gets an array of assets, does its job to enqueue them
*
* @param array		$assetsCss	Array of CSS links
* @param array		$assetsJs	Array of CSS links
*
* @return NULL
*/
	public function __invoke( array $assetsCss, array $assetsJs );
}