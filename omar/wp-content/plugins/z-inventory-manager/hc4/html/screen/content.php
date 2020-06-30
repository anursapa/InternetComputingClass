<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Screen_Content
{
	public function _import(
		HC4_Html_Screen_Config $config,
		HC4_Html_Screen_Layout $layout,

		HC4_Csrf_Interface $csrf,
		HC4_Translate_Interface $translate,
		HC4_Html_Href_Interface $href,
		HC4_Session_Interface $session
	)
	{}

	public function __invoke( $slug, $return, $isAjax )
	{
	// ANNOUNCE IF ANY
		$announceView = NULL;

		if( $this->session ){
			$message = $this->session->getFlashdata('message');
			$error = $this->session->getFlashdata('error');
			$debug = $this->session->getFlashdata('debug');

			if( $message OR $debug OR $error ){
				$announce = new HC4_Ui_Announce;
				$announceView = $announce->render( $message, $error, $debug );
				$return = $announceView . $return;
			}
		}

	// LAYOUT
		$breadcrumb = $isAjax ? array() : $this->config->getBreadcrumb( $slug );

		$title = $this->config->getTitle( $slug );
		if( is_array($title) ){
			$title = join( ' ', $title );
		}

		$menu = $this->config->getMenu( $slug );
		$header = $this->config->getHeader( $slug );
		$subheader = $this->config->getSubheader( $slug );
		$subfooter = $this->config->getSubfooter( $slug );

		$return = call_user_func( $this->layout,
			$slug,
			$return,
			$title,
			$menu,
			$breadcrumb,
			$header,
			$subheader,
			$subfooter
		);

		$return = $this->csrf->render( $return );

	// TRANSLATE
		$return = $this->translate->translate( $return );

	// HREFS
		$return = $this->href->processOutput( $return );
		return $return;
	}
}