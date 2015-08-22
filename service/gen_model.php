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
		$affectd = 0;

		if (!class_exists('fileupload'))
		 {
				 include_once($this->phpbb_root_path . 'includes/functions_upload.' . $this->phpEx);
		 }
		//Upload file
		$upload = new \fileupload();
		$upload->set_allowed_extensions(array('png', 'svg','jpeg','jpg','gif'));
		$file = $upload->form_upload('img_file');
		if (empty($file->filename))
		{
			var_dump('sdsd'.$file->filename);
		}else{
			$file->move_file($upload_dir, true);
		}

		if(isset($values['product_gallery']))
		{	//eheck if gallery exists?
			$img = $product_gallery;
		}
		if(isset($values['$img_path']))
		{
				$img = $file->filename;
		}

		//should recover and update instead of doing that

		if(isset($values['local_id'])){
			// $this->mapper->select(['local_id'=>$values['local_id']]);
			var_dump($values);
			$affected = $this->mapper->update(new \wardormeur\theinventory\model\gen_model($values));
		}else{
			$model = new \wardormeur\theinventory\model\gen_model($values);
			$affected = $this->mapper->insert($model);
		}
		return $affected;
	}

	public function remove()
	{
		$this->mapper->delete();
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
