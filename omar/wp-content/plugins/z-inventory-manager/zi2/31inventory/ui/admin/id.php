<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_31Inventory_Ui_Admin_Id
{
	private function _import(
		ZI2_11Items_Data_Repo $repo,

		HC4_Html_Input_Text $inputText,
		HC4_Html_Input_RichTextarea $inputTextarea
	)
	{}

	public function title( $slug, $id )
	{
		$model = $this->repo->findById( $id );
		return $model->title;
	}

	public function get( $slug, $id )
	{
		$model = $this->repo->findById( $id );
		$return = $this->render( $model );
		return $return;
	}

	public function render( ZI2_11Items_Data_Model $model )
	{
		ob_start();
?>
<form method="post" action="HREFPOST:..">

	<div class="hc4-form-elements">

		<div class="hc-grid hc-mxn2">
			<div class="hc-col hc-col-9 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Title__
						<?php echo $this->inputText->render( 'title', $model->title ); ?>
					</label>
				</div>
			</div>

			<div class="hc-col hc-col-3 hc-px2">
				<div class="hc4-form-element">
					<label>
						__SKU__
						<?php echo $this->inputText->render( 'sku', $model->sku ); ?>
					</label>
				</div>
			</div>
		</div>

		<div class="hc4-form-element">
			<label>
				__Description__
			</label>
			<?php echo $this->inputTextarea->render( 'description', $model->description, 4 ); ?>
		</div>

		<div class="hc-grid hc-mxn2">
			<div class="hc-col hc-col-6 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Default Cost__
						<?php echo $this->inputText->render( 'default_cost', $model->defaultCost ); ?>
					</label>
				</div>
			</div>

			<div class="hc-col hc-col-6 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Default Price__
						<?php echo $this->inputText->render( 'default_price', $model->defaultPrice ); ?>
					</label>
				</div>
			</div>
		</div>

	</div>

	<div class="hc4-form-buttons">
		<button type="submit" class="hc4-admin-btn-primary">__Save__</button>
	</div>

</form>

<?php 
		return ob_get_clean();
	}

	public function post( $slug, array $post, $id )
	{
	// VALIDATE POST
		$errors = array();

		if( ! (isset($post['title']) && strlen($post['title'])) ){
			$errors['title'] = '__Required Field__';
		}
		if( ! (isset($post['sku']) && strlen($post['sku'])) ){
			$errors['sku'] = '__Required Field__';
		}

		if( $errors ){
			throw new HC4_App_Exception_FormErrors( $errors );
		}

	// DO
		try {
			$model = $this->repo->findById( $id );
			$model = clone $model;

			$model->title = $post['title'];
			$model->sku = $post['sku'];
			$model->description = $post['description'];
			$model->defaultCost = $post['default_cost'];
			$model->defaultPrice = $post['default_price'];

			$model = $this->repo->update( $model );
		}
		catch( HC4_App_Exception_DataError $e ){
			$to = '-referrer-';
			$return = array( $to, NULL, $e->getMessage() );
			return $return;
		}

		$slugArray = explode( '/', $slug );
		$to = implode( '/', array_slice($slugArray, 0, -1) );
		$return = array( $to, '__Inventory Updated__' );

		return $return;
	}
}