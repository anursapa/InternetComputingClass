<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class HC4_Html_Screen_Layout
{
	public function _import(
		HC4_Html_Screen_Layout_Menu $menuView,
		HC4_Html_Screen_Layout_MenuItem $menuItemView,
		HC4_Html_Screen_Layout_Breadcrumb $breadcrumbView
	)
	{}

	public function __invoke(
		$slug,
		$content,
		$title = NULL,
		array $menu = array(),
		array $breadcrumb = array(),
		$header = NULL,
		$subheader = NULL,
		$subfooter = NULL
		)
	{
		$contentAsMenu = array();

	/* prepare menu */
		$menuView = array();
		foreach( $menu as $menuItem ){
			$menuItemView = call_user_func( $this->menuItemView, $slug, $menuItem );
			if( NULL !== $menuItemView ){
				$menuView[] = $menuItemView;
			}
		}

		if( ! strlen($content) && $menuView ){
			$contentAsMenu = $menuView;
			$menuView = array();
		}

		$breadcrumbView = call_user_func( $this->breadcrumbView, $breadcrumb );

		if( ! strlen($slug) ){
			$title = NULL;
		}

		ob_start();
?>

<?php if( strlen($header) ) : ?>
	<div class="hc4-page-header">
		<?php echo $header; ?>
	</div>
<?php endif; ?>

<?php if( strlen($breadcrumbView) ) : ?>
	<div class="hc4-page-breadcrumb">
		<?php echo $breadcrumbView; ?>
	</div>
<?php endif; ?>

<div class="hc4-page">

<div class="hc4-page-title">
	<?php if( strlen($title) ) : ?>
		<?php if( defined('WPINC') && is_admin() ) : ?>
			<h1 class="wp-heading-inline hc-inline-block" style="margin: 0 0 0 0; padding: 0 0 0 0;"><?php echo $title; ?></h1>
		<?php else : ?>
			<h1><?php echo $title; ?></h1>
		<?php endif; ?>
	<?php endif; ?>

	<?php if( $menuView ) : ?>
		<div class="hc4-page-menu">
			<?php echo call_user_func( $this->menuView, $menuView ); ?>
		</div>
	<?php endif; ?>
</div>

<?php if( strlen($subheader) ) : ?>
	<div class="hc4-page-subheader">
		<?php echo $subheader; ?>
	</div>
<?php endif; ?>

<div class="hc4-page-content">
	<?php if( $contentAsMenu ) : ?>
		<div class="hc4-list">
		<?php foreach( $contentAsMenu as $menuItem ) : ?>
			<div><?php echo $menuItem; ?></div>
		<?php endforeach; ?>
		</div>
	<?php else : ?>
		<?php echo $content; ?>
	<?php endif; ?>
</div>

<?php if( strlen($subfooter) ) : ?>
	<div class="hc4-page-subfooter">
		<?php echo $subfooter; ?>
	</div>
<?php endif; ?>

</div><!-- /hc4-page -->

<?php 
		$return = ob_get_clean();
		return $return;
	}

	public function renderRoot( HA7_01Users_Data_Model $user, $currentSlug )
	{
		$return = NULL;

		$skips = array( 'setup', 'debug', 'login' );
		foreach( $skips as $skip ){
			if( substr($currentSlug, 0, strlen($skip)) == $skip ){
				return;
			}
		}

		if( $user->id ){
			$slug = 'user/profile';
			$slug = '/';
			$label = $this->viewUser->render( $user, 'HREFGET:' . $slug );
			$label = str_replace( '<a', '<a class="hc4-admin-link-ternary"', $label );

			$return = array( $slug, $label );
			// return $return;
			// $slug = 'user/profile';
			// $return = $this->viewUser->render( $user, 'HREFGET:' . $slug );
			// $return = str_replace( '<a', '<a class="hc4-admin-link-ternary"', $return );
		}
		else {
			$return = array( '', '__Menu__' );
		}

		return $return;
	}
}