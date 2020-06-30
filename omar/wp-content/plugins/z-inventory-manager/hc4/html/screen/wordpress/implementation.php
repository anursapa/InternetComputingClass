<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Screen_WordPress_Implementation
	implements HC4_Html_Screen_Interface
{
	private function _import(
		HC4_Html_Screen_Enqueuer_Interface $enqueuer,
		HC4_Translate_Interface $translate,
		HC4_Html_Screen_Config $config,
		HC4_Html_Screen_Content $content,
		HC4_Html_Href_Interface $href
	)
	{}

	public function __invoke( $slug, $result, $isAjax )
	{
		$result = call_user_func( $this->content, $slug, $result, $isAjax );

		$cssReplace = array(
			'hc4-admin-btn-primary' => 'button button-primary button-large',
			'hc4-admin-link-secondary'	=> 'hc-block page-title-action hc-top-auto',
			'hc4-table-header'	=> 'hc4-table-header hc4-table-header-wpadmin',
			'hc4-list-header'	=> 'hc4-list-header hc4-list-header-wpadmin',
			);
		foreach( $cssReplace as $from => $to ){
			$result = str_replace( $from, $to, $result );
		}

		if( $isAjax ){
			return $result;
		}

	// ASSETS
		$css = $this->config->getCss($slug);
		for( $ii = 0; $ii < count($css); $ii++ ){
			$css[$ii] = $this->href->hrefAsset( $css[$ii] );
		}
		$js = $this->config->getJs( $slug );
		for( $ii = 0; $ii < count($js); $ii++ ){
			$js[$ii] = $this->href->hrefAsset( $js[$ii] );
		}

		$assetsView = call_user_func( $this->enqueuer, $css, $js );

		ob_start();
?>

<div class="wrap">
<div class="hc4-main">
<?php echo $result; ?>
</div>
</div>

<?php 
		$return = ob_get_clean();
		return $return;
	}
}