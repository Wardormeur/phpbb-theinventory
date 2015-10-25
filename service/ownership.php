<?php


namespace wardormeur\theinventory\service;


//strangest class of my life
class ownership{


	private $toggle_own = ["have","had"];
	private $toggle_want = ["want","wanted"];
	private $toggle_sell = ["sell","sold"];
	private $relationships = [];

	public function __construct(
		$phpEx,
		$phpbb_root_path,
		$mapper)
	{
		global $phpbb_container;

		$this->relationships = ["have-had" => $this->toggle_own, "want-wanted" => $this->toggle_want, "sell-sold" => $this->toggle_sell];

		$this->phpbb_phpEx = $phpEx;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->mapper = $mapper;
	}

/*
Possibe keywords :
 have
 had
 want
 sell?
 sold?
 reviewed?
 stole :D

 */



	public function get_user_ownings($id)
	{
		$products = $this->mapper->select(['user_id'=>$id]);
		return $products;
	}

	public function toggle_user_own_product($user_id, $product_id, $keyword)
	{
		//Generic togggler
		$relations = array_keys($this->relationships);
		foreach($relations as $relation){
			if(strpos($relation, $keyword) !== false){
					break;
			}
		}
		$indexOf = array_search($keyword, array_values($this->relationships[$relation]));
		//we take the opposite value of the array index
		$this->mapper->update($user_id, $product_id, $this->relationships[$relation][(int)(!$indexOf)]);
		return strtoupper($this->relationships[$relation][(int)(!$indexOf)]);
	}
	public function add_user_own_product($user_id, $product_id)
	{
		$this->mapper->insert($user_id, $product_id,'have');
		return strtoupper('have');
	}
	public function used_used_own_product($user_id, $product_id)
	{
		$products = $this->mapper->select(['user_id'=>$user_id,'product_id'=> $product_id,'status'=>'had']);
		return $products;
	}

	public function remove_user_product_previous_ownership($user_id, $product_id)
	{
		$products = $this->mapper->delete(['user_id'=>$user_id,'product_id'=> $product_id]);
	}

	/**
	* @return brand_id if linked and specified, null if not, brands_id if !brand_id
	*/
	// public function user_sponsorship($user_id, $brand_id = [])
	// {
	//
	// 	$sql = 'SELECT brand_id FROM {$this->table_prefix}ti_users_sponsorship WHERE user_id = $id';
	//
	// 	if($brand_id){
	// 		 if(in_array($result,$brand_id)){
	// 			$return = $brand_id;
	// 		}else{
	// 				$return = null;
	// 		}
	// 	}else{
	// 		$return = $brands_id;
	// 	}
	// 	return $return;
	//
	// }
	//
	// public function toggle_user_sponsorised_by($user_id, $brand_id)
	// {
	// 	$sql = 'UPDATE {$this->table_prefix}ti_users_sponsorship(status) VALUES(!status)
	// 	WHERE user_id = $id AND brand_id = $brand_id';
	//
	// }
	// private function add_user_sponsor($user_id, $brand_id)
	// {
	// 	$sql = 'INSERT INTO {$this->table_prefix}ti_users_sponsorship($user_id, $brand_id, status) VALUES($user_id, $brand_id, true)';
	// }
	// private function remove_user_sponsor($user_id, $brand_id)
	// {
	// 	$sql = 'DELETE {$this->table_prefix}ti_users_sponsorship WHERE user_id = $id AND brand_id = $brand_id';
	// }


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
