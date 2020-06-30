<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class ZI2_03Acl_Ui_NotAllowed
{
	public function get( $slug )
	{
		$return = $this->render();
		return $return;
	}

	public function render()
	{
		ob_start();
?>
<p>
__You are not allowed to view this page.__
</p>

<?php 
		return ob_get_clean();
	}
}