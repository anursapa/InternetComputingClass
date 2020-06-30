<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Email_Wordpress_Implementation
	implements HC4_Email_Interface
{
	public $emailHtml = 1;
	public $from;
	public $fromName;

	public function _import(
		HC4_Email_Logger $logger,
		$logFile = NULL
	)
	{}

	public function send( $to, $subj, $msg )
	{
		add_filter( 'wp_mail_content_type', array($this, '_setHtmlMailContentType') );
		if( $this->emailHtml ){
			$msg = nl2br( $msg );
		}
		@wp_mail( $to, $subj, $msg );
		remove_filter( 'wp_mail_content_type', array($this, '_setHtmlMailContentType') );

		if( $this->logFile ){
			call_user_func( $this->logger, $to, $subj, $msg, $this->logFile );
		}

		return $this;
	}

	public function _setHtmlMailContentType()
	{
		$return = $this->emailHtml ? 'text/html' : 'text/plain';
		return $return;
	}
}