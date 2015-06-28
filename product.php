<?php


namespace wardormeur\theinventory;



class product{

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

	public function set_name($name)
	{
		$this->name = $name;
	}
	public function get_name()
	{
		return $this->name;
	}

	public function set_brand($brand)
	{
		$this->brand = $brand;
	}

	public function set_local_id($local_id)
	{
		$this->local_id= $local_id;
	}

	public function get_brand()
	{
		return $this->brand;
	}

	public function set_image($image_path)
	{
		$this->image = $image_path;
	}

	public function get_local_id()
	{
		return $this->local_id;
	}

	public function get_image()
	{
		return $this->image;
	}

	public function save()
	{
		if($this->get_local_id())
		{
			//local_id is auto et product-Id is remote, we dont know either of them atm.
			$sql = "UPDATE {$this->table_prefix}ti_product SET name='".$this->name."',brand_name='".$this->brand."',image_path='".$this->image."' WHERE local_id={$this->get_local_id()}";
			$this->db->sql_query($sql);

		}
		else
		{
			//local_id is auto et product-Id is remote, we dont know either of them atm.
			$sql = "INSERT INTO {$this->table_prefix}ti_product(name,brand_name,image_path) VALUES('".$this->name."','".$this->brand."','".$this->image."')";
			$this->db->sql_query($sql);
			//select missing fields ?

		}
		return (bool) $this->db->sql_affectedrows();
	}

	public function remove()
	{
		$sql = "DELETE FROM {$this->table_prefix}ti_product WHERE local_id={$this->get_local_id()}";
		$this->db->sql_query($sql);

	}

	public function get_product_by_name($name)
	{
			$sql = "SELECT name,local_id,product_id, brand_name, image_path FROM {$this->table_prefix}ti_product WHERE LOWER(name) = '$name'";
			$result = $this->db->sql_query($sql);
			$product = $this->db->sql_fetchrow($result);
			$this->set_name($product['name']);
			$this->set_brand($product['brand_name']);
			$this->set_image($product['image_path']);
			$this->product_id = $product['product_id'];
			$this->local_id = $product['local_id'];
	}

	public function get_brands()
	{
		$brands = [];
		$sql = "SELECT DISTINCT brand_name FROM {$this->table_prefix}ti_product";
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$brands[] = $row;
		}

		return $brands;

	}

	public function search_product($name,$brand)
	{
		$products = [];
		$search_params = [];

		if($name)
			 $search_params['name'] = "$name";
		if($brand)
				$search_params['brand_name'] = "$brand";


		$sql = "SELECT name,local_id,product_id, brand_name, image_path FROM {$this->table_prefix}ti_product";
		if(!empty($search_params))
		{
			$sql .= " WHERE ".$this->db->sql_build_array('SELECT', $search_params);
		}
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$products[] = $row;
		}

		return $products;

	}

}
?>
