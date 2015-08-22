<?php


namespace wardormeur\theinventory\service;


//strangest class of my life
class ownership{

	private $name;
	private $local_id;
	private $product_id;
	private $brand;
	private $image;


	public function __construct(
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		$table_prefix,
		$phpEx,
		$phpbb_root_path)
	{
		global $phpbb_container;

		$this->db = $db;
		$this->config = $config;
		$this->table_prefix = $table_prefix;
		$this->phpbb_phpEx = $phpEx;
		$this->phpbb_root_path = $phpbb_root_path;

	}

	public function get_products_by_user($id)
	{
		$sql = 'SELECT product_id, user_id FROM {$this->table_prefix}ti_users_ownership WHERE user_id = $id';

	}

	public function toggle_user_own_product($user_id, $product_id)
	{
		$sql = 'UPDATE {$this->table_prefix}ti_users_ownership(status) VALUES(!status)
		WHERE user_id = $id AND product_id = $product_id';
	}
	private function add_user_own_product($user_id, $product_id)
	{
			$sql = 'INSERT INTO {$this->table_prefix}ti_users_ownership($user_id,$product_id,status) VALUES($user_id,$product_id,true)';
	}
	private function used_used_own_product($user_id, $product_id)
	{
		$sql = 'SELECT product_id, user_id FROM {$this->table_prefix}ti_users_ownership WHERE user_id = $id AND product_id = $product_id AND status = false';

	}

	public function remove_user_product_previous_ownership($user_id, $product_id)
	{
		$sql = 'DELETE {$this->table_prefix}ti_users_ownership WHERE user_id = $id AND product_id = $product_id';

	}

	/**
	* @return brand_id if linked and specified, null if not, brands_id if !brand_id
	*/
	public function user_sponsorship($user_id, $brand_id = [])
	{

		$sql = 'SELECT brand_id FROM {$this->table_prefix}ti_users_sponsorship WHERE user_id = $id';

		if($brand_id){
			 if(in_array($result,$brand_id)){
				$return = $brand_id;
			}else{
					$return = null;
			}
		}else{
			$return = $brands_id;
		}
		return $return;

	}

	public function toggle_user_sponsorised_by($user_id, $brand_id)
	{
		$sql = 'UPDATE {$this->table_prefix}ti_users_sponsorship(status) VALUES(!status)
		WHERE user_id = $id AND brand_id = $brand_id';

	}
	private function add_user_sponsor($user_id, $brand_id)
	{
		$sql = 'INSERT INTO {$this->table_prefix}ti_users_sponsorship($user_id, $brand_id, status) VALUES($user_id, $brand_id, true)';
	}
	private function remove_user_sponsor($user_id, $brand_id)
	{
		$sql = 'DELETE {$this->table_prefix}ti_users_sponsorship WHERE user_id = $id AND brand_id = $brand_id';
	}


	public function toggle_user_like_brand()
	{

	}
	private function add_user_fan()
	{

	}
	private function remove_user_fan()
	{

	}

	public function toggle_user_like_product()
	{

	}
	private function add_user_like_product()
	{

	}
	private function remove_user_like_product()
	{

	}

	public function toggle_user_want_product()
	{

	}
	private function add_user_product_buy_list()
	{

	}
	private function remove_user_product_buy_list()
	{

	}
}
?>
