<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Screen_Layout_MenuItem
{
	public function _import(
		HC4_App_SlugCheck $slugCheck
	)
	{}

	public function __invoke( $slug, array $toLabel )
	{
		if( 1 === count($toLabel) ){
			array_unshift( $toLabel, NULL );
		}

		list( $to, $label ) = $toLabel;

		if( 'GET/' == substr($to, 0, strlen('GET/')) ){
			$method = 'GET';
			$to = substr( $to, strlen('GET/') );
		}
		elseif( 'POST/' == substr($to, 0, strlen('POST/')) ){
			$method = 'POST';
			$to = substr( $to, strlen('POST/') );
		}
		else {
			$method = 'GET';
		}

		if( $to ){
			$to = str_replace( '..', $slug, $to );
			if( FALSE === call_user_func($this->slugCheck, $method, $to) ){
				return;
			}
		}

		ob_start();
?>
	<?php if( NULL === $to ) : ?>

		<?php echo $label; ?>

	<?php else : ?>
		<?php if( 'POST' == $method ) : ?>
			<form method="post" action="HREFPOST:<?php echo $to; ?>">
			<?php if( FALSE === strpos($label, '<') ) : ?>
				<button type="submit" title="<?php echo $label; ?>"><?php echo $label; ?></button>
			<?php else : ?>
				<?php echo $label; ?>
			<?php endif; ?>
			</form>
		<?php else : ?>
			<?php if( FALSE === strpos($label, '<') ) : ?>
				<a href="HREFGET:<?php echo $to; ?>" title="<?php echo $label; ?>"><?php echo $label; ?></a>
			<?php else : ?>
				<?php echo $label; ?>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
<?php 
		$return = ob_get_clean();
		return $return;
	}
}