<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Href_WordPress_Implementation
	extends HC4_Html_Href_Abstract
	implements HC4_Html_Href_Interface
{
	protected $template;
	protected $templatePost;
	protected $templateApi;
	protected $templateAsset;

	public function __construct( $appShortName, $pluginFile, array $assetSrc = array() )
	{
		$this->assetSrc = $assetSrc;

		$uri = new HC4_App_Uri;
		$template = $uri->makeUrl( '{SLUG}' );
		$this->template = $template;

		$this->currentSlug = $uri->getSlug();

	// post
		$templatePost = $template;
		$templatePost .= ( FALSE === strpos($templatePost, '?') ) ? '?' : '&';
		$templatePost .= 'hcs=' . $appShortName;
		$this->templatePost = $templatePost;

	// api
		$url = parse_url( site_url('/') );
		$baseUrl = $url['scheme'] . '://'. $url['host'];
		if( isset($url['port']) && (80 != $url['port']) ){
			$baseUrl .= ':' . $url['port'];
		}
		$baseUrl .= $url['path'];

		$templateApi = $baseUrl;
		$templateApi .= (isset($url['query']) && $url['query']) ? '?' . $url['query'] . '&' : '?';
		$templateApi .= 'hcs=' . $appShortName . '&hca={SLUG}';
		$this->templateApi = $templateApi;

	// asset
		$templateAsset = plugins_url( '{SLUG}', $pluginFile );
		$this->templateAsset = $templateAsset;
	}

	public function hrefGet( $slug )
	{
		return $this->fromTemplate( $this->template, $slug );
	}

	public function hrefPost( $slug )
	{
		return $this->fromTemplate( $this->templatePost, $slug );
	}

	public function hrefApi( $slug )
	{
		return $this->fromTemplate( $this->templateApi, $slug );
	}

	public function hrefAsset( $slug )
	{
		$return = parent::hrefAsset( $slug );

		if( NULL === $return ){
			$return = $this->fromTemplate( $this->templateAsset, $slug );
		}

		return $return;
	}
}