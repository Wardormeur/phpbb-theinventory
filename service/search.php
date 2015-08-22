<?php


namespace wardormeur\theinventory\service;



class search{


	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		$table_prefix,
		$phpEx,
		$phpbb_root_path)
	{
		global $phpbb_container;

		$this->db = $db;
		$this->table_prefix = $table_prefix;
		$this->phpbb_phpEx = $phpEx;
		$this->phpbb_root_path = $phpbb_root_path;

	}


	public function search($filters)
	{
		$products = [];
		$search_params = [];

		if(isset($filters['name']))
			 $search_params['p.name'] = "{$filters['name']}";
		if(isset($filters['brand_id']))
				$search_params['b.local_id'] = "{$filters['brand_id']}";


		$sql = "SELECT p.name,p.local_id, p.image_path,p.brand_id FROM {$this->table_prefix}ti_product p
				INNER JOIN {$this->table_prefix}ti_brand b on p.brand_id = b.local_id";
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
