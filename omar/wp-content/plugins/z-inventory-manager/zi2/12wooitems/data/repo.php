<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_12WooItems_Data_Repo
	extends ZI2_11Items_Data_Repo_Builtin
	implements ZI2_11Items_Data_Repo
{
	protected $_loaded = NULL;

	public function __construct(
	)
	{}

	protected function _fromWoo( WC_Product $p )
	{
		$return = new ZI2_11Items_Data_Model;

		$return->id = $p->get_id();
		$return->title = $p->get_name();
		$return->description = $p->get_description();
		$return->status = $p->get_status();
		$return->sku = $p->get_sku();
		// $return->defaultCost = $array['default_cost'];
		$return->defaultPrice = $p->get_price();

		return $return;
	}

	protected function _load()
	{
		if( NULL !== $this->_loaded ){
			return;
		}

		$this->_loaded = array();

		$q = array();
		$q['limit'] = -1;
		$q['orderby'] = 'name';
		$q['order'] = 'ASC';

		$wcProducts = wc_get_products( $q );

		foreach( $wcProducts as $p ){
			$model = $this->_fromWoo( $p );
			$this->_loaded[ $model->id ] = $model;
		}
	}
}