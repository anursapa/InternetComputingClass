<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_21Purchases_Ui_Admin_Id
{
	private function _import(
		ZI2_21Purchases_Data_Repo $repo,

		ZI2_21Purchases_Ui_Status $viewStatus,

		HC4_Html_Input_RadioSet $inputRadioSet,
		HC4_Html_Input_Text $inputText,
		HC4_Html_Input_Date $inputDate,
		HC4_Html_Input_Textarea $inputTextarea,

		ZI2_04Finance_Ui_Price $viewPrice,
		ZI2_11Items_Ui_Title $viewItem,

		HC4_Finance_Calculator $calculator,
		HC4_Time_Format $tf
	)
	{}

	public function get( $slug, $id )
	{
		$model = $this->repo->findById( $id );

		$canEdit = $model->isDraft() ? TRUE : FALSE;
		if( $canEdit ){
			$return = $this->renderEdit( $model );
		}
		else {
			$return = $this->render( $model );
		}

		return $return;
	}

	public function post( $slug, $post, $id )
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
			$model = $this->repo->findById( $id );

			$model = clone $model;
			$model->refno = $post['refno'];
			$model->status = $post['status'];
			$model->createdDate = $createdDate;
			$model->description = $post['description'];

			$model = $this->repo->update( $model );
		}
		catch( HC4_App_Exception_DataError $e ){
			$to = '-referrer-';
			$return = array( $to, NULL, $e->getMessage() );
			return $return;
		}

		$slugArray = explode( '/', $slug );
		// $to = implode( '/', array_slice($slugArray, 0, -1) );
		$to = $slug;

		$return = array( $to, '__Purchase Saved__' );

		return $return;
	}

	public function title( $slug, $id )
	{
		$model = $this->repo->findById( $id );
		$return = $model->refno;
		return $return;
	}

	public function menu( $slug, $id )
	{
		$return = array();

		$model = $this->repo->findById( $id );
		if( $model->isDraft() ){
			if( $model->lines ){
				$return[] = array( '../items', '__Edit Items__' );
			}
			else {
				$return[] = array( '../items/new', '+ ' . '__Add Items__' );
			}
		}
		else {
			if( $model->receipts ){
				$return[] = array( '../receipts', '&#9776; ' . '__Received Items__' );
			}

			$toReceive = $model->getItemsToReceive();
			if( $toReceive ){
				$return[] = array( '../receipts/new', '&rarr; ' . '__Receive Items__' );
			}
		}

		return $return;
	}

	public function render( ZI2_21Purchases_Data_Model $model )
	{
		$canEdit = $model->isDraft() ? TRUE : FALSE;

		$statuses = array( 'draft', 'issued' );
		$statusOptions = array();
		foreach( $statuses as $e ){
			$statusOptions[ $e ] = $this->viewStatus->render( $e );
		}

		ob_start();
?>

	<div class="hc4-form-elements">

		<div class="hc-grid hc-mxn2">
			<div class="hc-col hc-col-5 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Purchase Number__
					</label>
					<div class="hc-p2 hc-border hc-border-gray hc-rounded">
						<?php echo $model->refno; ?>
					</div>
				</div>
			</div>

			<div class="hc-col hc-col-3 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Status__
					</label>
					<?php echo $this->viewStatus->render( $model->status ); ?>
				</div>
			</div>

			<div class="hc-col hc-col-4 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Date__
					</label>
					<div class="hc-p2 hc-border hc-border-gray hc-rounded">
						<?php echo $this->tf->formatDateWithWeekday( $model->createdDate ); ?>
					</div>
				</div>
			</div>
		</div>

		<?php if( strlen($model->description) ) : ?>
			<div class="hc4-form-element">
				<label>
					__Comments__
				</label>
				<em>
				<?php echo $model->description; ?>
				</em>
			</div>
		<?php endif; ?>

		<div class="hc4-form-element">
			<label>
				__Items__
			</label>
			<?php echo $this->renderLines( $model->lines ); ?>
		</div>

	</div>

<?php 
		return ob_get_clean();
	}

	public function renderEdit( ZI2_21Purchases_Data_Model $model )
	{

		$statuses = array( 'draft', 'issued' );
		$statusOptions = array();
		foreach( $statuses as $e ){
			$statusOptions[ $e ] = $this->viewStatus->render( $e );
		}

		ob_start();
?>
<form method="post" action="HREFPOST:..">

	<div class="hc4-form-elements">

		<div class="hc-grid hc-mxn2">
			<div class="hc-col hc-col-5 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Purchase Number__
					</label>
					<?php echo $this->inputText->render( 'refno', $model->refno ); ?>
				</div>
			</div>

			<div class="hc-col hc-col-3 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Status__
					</label>
					<?php echo $this->inputRadioSet->renderInline( 'status', $statusOptions, $model->status ); ?>
				</div>
			</div>

			<div class="hc-col hc-col-4 hc-px2">
				<div class="hc4-form-element">
					<label>
						__Date__
					</label>
					<?php echo $this->inputDate->render( 'created_date', $model->createdDate ); ?>
				</div>
			</div>

		</div>

		<div class="hc4-form-element">
			<label>
				__Comments__
			<?php echo $this->inputTextarea->render( 'description', $model->description, 4 ); ?>
			</label>
		</div>
	</div>

	<div class="hc4-form-buttons">
		<button type="submit" class="hc4-admin-btn-primary">__Save__</button>
	</div>

</form>

<div class="hc4-form-element">
	<label>
		__Items__
	</label>
	<?php echo $this->renderLines( $model->lines ); ?>
</div>

<?php 
		return ob_get_clean();
	}

	public function renderLines( array $entries )
	{
		$total = 0;
		$this->calculator->reset();
		foreach( $entries as $e ){
			$this->calculator->add( $e->qty * $e->price );
		}
		$total = $this->calculator->get();

		ob_start();
?>
<div class="hc4-admin-list-primary hc4-admin-list-striped">

<?php if( $entries ) : ?>
	<div>
		<div class="hc-flex-auto-grid">
			<div>__Title__</div>
			<div>__Quantity__</div>
			<div>__Price__</div>
			<div>__Total__</div>
		</div>
	</div>
<?php endif; ?>

<?php foreach( $entries as $e ) : ?>
	<div>
		<div class="hc-flex-auto-grid">
			<div>
				<?php echo $this->viewItem->render( $e->item ); ?>
			</div>
			<div>
				<?php echo $e->qty; ?>
			</div>
			<div>
				<?php echo $this->viewPrice->render( $e->price ); ?>
			</div>
			<div>
				<?php echo $this->viewPrice->render( $e->qty * $e->price ); ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<?php if( $entries ) : ?>
	<div>
		<div class="hc-flex-auto-grid">
			<div><strong>__Total__</strong></div>
			<div></div>
			<div></div>
			<div>
				<strong>
				<?php echo $this->viewPrice->render( $total ); ?>
				</strong>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php 
		return ob_get_clean();
	}
}