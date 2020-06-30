<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Ui_Admin_New
{
	private function _import(
		ZI2_21Purchases_Data_Repo $repo,

		ZI2_21Purchases_Ui_Status $viewStatus,

		HC4_Html_Input_Text $inputText,
		HC4_Html_Input_Textarea $inputTextarea,
		HC4_Html_Input_Date $inputDate,
		HC4_Html_Input_Select $inputSelect,
		HC4_Html_Input_RadioSet $inputRadioSet
	)
	{}

	public function get( $slug )
	{
		$return = $this->render();
		return $return;
	}

	public function render()
	{
		$statuses = array( 'draft', 'issued' );
		$statusOptions = array();
		foreach( $statuses as $e ){
			$statusOptions[ $e ] = $this->viewStatus->render( $e );
		}

		$refno = $this->repo->getNewRefno();

		ob_start();
?>
<form method="post" action="HREFPOST:..">

	<div class="hc4-form-elements">

		<div class="hc4-form-element">
			<label>
				__Purchase Number__
				<?php echo $this->inputText->render( 'refno', $refno ); ?>
			</label>
		</div>

		<div class="hc4-form-element">
			<label>
				__Date__
				<?php echo $this->inputDate->render( 'created_date' ); ?>
			</label>
		</div>

		<div class="hc4-form-element">
			<label>
				__Comments__
				<?php echo $this->inputTextarea->render( 'description', '', 4 ); ?>
			</label>
		</div>

	</div>

	<div class="hc4-form-buttons">
		<button type="submit" class="hc4-admin-btn-primary">__Continue__</button>
	</div>

</form>

<?php 
		return ob_get_clean();
	}

	public function post( $slug, array $post )
	{
		$errors = array();
		if( ! ($post['refno'] && strlen($post['refno'])) ){
			$errors['refno'] = '__Required Field__';
		}
		if( $errors ){
			throw new HC4_App_Exception_FormErrors( $errors );
		}

		$createdDate = $this->inputDate->grab( 'created_date', $post );

	// DO
		try {
			$model = new ZI2_21Purchases_Data_Model;
			$model->refno = $post['refno'];
			$model->createdDate = $createdDate;
			$model->description = $post['description'];

			$model = $this->repo->create( $model );
		}
		catch( HC4_App_Exception_DataError $e ){
			$to = '-referrer-';
			$return = array( $to, NULL, $e->getMessage() );
			return $return;
		}

		$slugArray = explode( '/', $slug );
		$to = implode( '/', array_slice($slugArray, 0, -1) );

		$to = 'admin/purchases/' . $model->id . '/items/new';
		$return = array( $to, '__Purchase Saved__' );

		return $return;
	}
}