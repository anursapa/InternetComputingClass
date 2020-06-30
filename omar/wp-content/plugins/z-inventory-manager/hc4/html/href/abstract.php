<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
abstract class HC4_Html_Href_Abstract
{
	protected $assetSrc = array();
	protected $currentSlug = NULL;
	protected $aliases = array();

	public function alias( $from, $to )
	{
		$this->aliases[ $from ] = $to;
		return $this;
	}

	public function fromTemplate( $template, $slug )
	{
		if( isset($this->aliases[$slug]) ){
			$slug = $this->aliases[$slug];
		}

		if( HC4_App_Uri::isFullUrl($slug) ){
			$return = $slug;
		}
		else {
			$slug = str_replace( '..', $this->currentSlug, $slug );
			$return = str_replace( '{SLUG}', $slug, $template );
		}
		return $return;
	}

	public function hrefAsset( $slug )
	{
		$return = NULL;

	// if we have supplied paths
		reset( $this->assetSrc );
		foreach( $this->assetSrc as $prefix => $moduleDir ){
			if( substr($slug, 0, strlen($prefix) + 1) == $prefix . '/' ){
				$shortSlug = substr( $slug, strlen($prefix) + 1 );
				$return = $moduleDir . '/' . $shortSlug;
				break;
			}
		}

		return $return;
	}

	public function processOutput( $string )
	{
		$string = "" . $string;

		preg_match_all( '/[\'"]HREFGET\:(.+)[\'"]/U', $string, $ma );
		$count = count($ma[0]);

		for( $ii = 0; $ii < $count; $ii++ ){
			$what = $ma[0][$ii];

			$slug = $ma[1][$ii];
			$to = $this->hrefGet( $slug );
			$to = '"' . $to . '"';
// echo "'$what' -> '$to'<br>";
			$string = str_replace( $what, $to, $string );
		}

		preg_match_all( '/[\'"]HREFPOST\:(.+)[\'"]/U', $string, $ma );
		$count = count($ma[0]);
		for( $ii = 0; $ii < $count; $ii++ ){
			$what = $ma[0][$ii];

			$slug = $ma[1][$ii];
			$to = $this->hrefPost( $slug );
			$to = '"' . $to . '"';
			$string = str_replace( $what, $to, $string );
		}

		preg_match_all( '/[\'"]HREFAPI\:(.+)[\'"]/U', $string, $ma );
		$count = count($ma[0]);
		for( $ii = 0; $ii < $count; $ii++ ){
			$what = $ma[0][$ii];

			$slug = $ma[1][$ii];
			$to = $this->hrefApi( $slug );
			$to = '"' . $to . '"';
			$string = str_replace( $what, $to, $string );
		}

		return $string;
	}
}