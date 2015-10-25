<?php


namespace wardormeur\theinventory\service;


class gen_model{



	public function __construct(
		\wardormeur\theinventory\mapper\gen_model $mapper,
		$phpEx,
		$phpbb_root_path)
	{
		global $phpbb_container;

		$this->mapper = $mapper;
		$this->phpEx = $phpEx;
		$this->phpbb_root_path = $phpbb_root_path;
	}

	function save($values){
		$affected = 0;

		$upload_dir = 'images/product';
		if (!class_exists('fileupload'))
		 {
				 include_once($this->phpbb_root_path . 'includes/functions_upload.' . $this->phpEx);
		 }
    $upload = new \fileupload($upload_dir);
    $upload->set_allowed_extensions(array('png', 'svg','jpeg','jpg','gif'));

		if(isset($values['img_file'])){
	    //Upload file
	    $file = $upload->form_upload('img_file');

		}

		if(isset($values['img_path']))
		{
				$file = $upload->remote_upload($values['img_path']);

				// $values['image_path'] = $values['img_path'];
		}
		if (empty($file->filename))
		{
			var_dump('sdsd'.$file->filename);
		}else{
			$file->move_file($upload_dir, true);
			$values['image_path'] = $file->uploadname;
		}

		$model = new \wardormeur\theinventory\model\gen_model($values);
		if(isset($values['local_id'])){
			$affected = $this->mapper->update($model);
		}else{
			$affected = $this->mapper->insert($model);
		}
		return $affected;
	}

	public function remove($product_id)
	{
		$this->mapper->delete($product_id);
	}

	public function get($parameters)
	{
		$sql_models = $this->mapper->select($parameters);
		$models = [];
		foreach($sql_models as $sql_model){
			$models[] = new \wardormeur\theinventory\model\gen_model($sql_model);
		}
		return $models;

	}

}
?>
