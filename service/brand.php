<?php


namespace wardormeur\theinventory\service;



class brand{

	private $name;
	private $brand_id;
	private $local_id;
	private $image;
	private $description;
	private $url;


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
		return $this;
	}
	public function get_name()
	{
		return $this->name;
	}

	public function set_image($image_path)
	{
		$this->image = $image_path;
		return $this;
	}

	public function get_image()
	{
		return $this->image;
	}

	public function get_brand_id()
	{
		return $this->brand_id;
	}

	public function set_brand_id($id)
	{
	 	$this->brand_id = $id;
		return $this;
	}


	public function get_local_id()
	{
		return $this->brand_id;
	}

	public function set_local_id($id)
	{
	 	$this->brand_id = $id;
		return $this;
	}

	public function set_description($description)
	{
		 $this->description = $description;
		 return $this;
	}

	public function get_description()
	{
		return $this->description;
	}

	public function set_url($url)
	{
		 $this->url = $url;
		 return $this;
	}

	public function get_url()
	{
		return $this->url;
	}



	public function save()
	{

		if($this->get_local_id())
		{
			//local_id is auto et product-Id is remote, we dont know either of them atm.
			$sql = "UPDATE {$this->table_prefix}ti_brand SET name='".$this->name."',image_path='".$this->image."',
			 	description='".$this->description."', url='".$this->url."' WHERE local_id={$this->get_local_id()}";
			$this->db->sql_query($sql);

		}
		else
		{
			//local_id is auto et product-Id is remote, we dont know either of them atm.
			$sql = "INSERT INTO {$this->table_prefix}ti_brand(name,description,image_path,url) VALUES('".$this->name."','".$this->description."','".$this->image."','".$this->url."')";
			$this->db->sql_query($sql);
			//select missing fields ?

		}
		return (bool) $this->db->sql_affectedrows();
	}

	public function remove()
	{
		$sql = "DELETE FROM {$this->table_prefix}ti_brand WHERE brand_id={$this->get_brand_id()}";
		$this->db->sql_query($sql);

	}

	public function get($id){

		$sql = "SELECT name, brand_id, local_id, description, image_path, url FROM {$this->table_prefix}ti_brand WHERE local_id = $id";
		$result = $this->db->sql_query($sql);
		$brand = $this->db->sql_fetchrow($result);
		$this->set_name($brand['name']);
		$this->set_description($brand['description']);
		$this->set_image($brand['image_path']);
		$this->set_brand_id( $brand['brand_id']);
		$this->set_local_id( $brand['local_id']);

		return $this;

	}

	public function get_brand_by_name($name)
	{
			$sql = "SELECT name, brand_id, local_id, description, image_path, url FROM {$this->table_prefix}ti_brand WHERE LOWER(name) = LOWER('$name')";
			$result = $this->db->sql_query($sql);
			$brand = $this->db->sql_fetchrow($result);
			$this->set_name($brand['name']);
			$this->set_description($brand['description']);
			$this->set_image($brand['image_path']);
			$this->set_brand_id( $brand['brand_id']);
			$this->set_local_id( $brand['local_id']);
			$this->set_url($brand['url']);

			return $this;
	}

	public function get_brands()
	{
		$brands = [];
		$sql = "SELECT DISTINCT local_id as id,name FROM {$this->table_prefix}ti_brand";
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$brands[] = $row;
		}

		return $brands;

	}

	public function get_products()
	{
		$products = [];
		$sql = "SELECT DISTINCT name FROM {$this->table_prefix}ti_product WHERE p.brand_id = {$this->brand_id}";
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$products[] = $row;
		}

		return $products;

	}


}
?>
