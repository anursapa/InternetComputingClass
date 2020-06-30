<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Screen_WordPress_Enqueuer
implements HC4_Html_Screen_Enqueuer_Interface
{
	public function __invoke( array $assetsCss, array $assetsJs )
	{
		$handleId = 1;

		foreach( $assetsCss as $src ){
			$handle = 'hc4-' . $handleId;
			wp_enqueue_style( $handle, $src );
			$handleId++;
		}

		foreach( $assetsJs as $src ){
			$handle = 'hc4-' . $handleId;
			wp_enqueue_script( $handle, $src );
			$handleId++;
		}
	}
}