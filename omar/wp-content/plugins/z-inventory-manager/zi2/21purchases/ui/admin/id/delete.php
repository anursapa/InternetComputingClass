<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Ui_Admin_Id_Delete
{
	private function _import(
		ZI2_21Purchases_Data_Repo $repo
	)
	{}

	public function get( $slug, $id )
	{
		$model = $this->repo->findById( $id );
		$return = $this->render( $model );
		return $return;
	}

	public function render( ZI2_21Purchases_Data_Model $model )
	{
		ob_start();
?>
__This operation cannot be undone.__

<form method="post" action="HREFPOST:..">

	<div class="hc4-form-buttons">
		<button type="submit" class="hc4-admin-btn-primary" title="__Confirm Delete__">__Confirm Delete__</button>
	</div>

</form>

<?php 
		return ob_get_clean();
	}

	public function post( $slug, array $post, $id )
	{
		$model = $this->repo->findById( $id );

		try {
			$model = $this->repo->delete( $model );
		}
		catch( HC4_App_Exception_DataError $e ){
			$to = '-referrer-';
			$return = array( $to, NULL, $e->getMessage() );
			return $return;
		}

		$slugArray = explode( '/', $slug );
		$to = implode( '/', array_slice($slugArray, 0, -2) );
		$return = array( $to, '__Purchase Deleted__' );

		return $return;
	}
}