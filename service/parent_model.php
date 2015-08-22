<?php


namespace wardormeur\theinventory\service;


class parent_model
{


	public function __construct(
		\wardormeur\theinventory\mapper\parent_model $mapper,
		$phpEx,
		$phpbb_root_path)
	{
		global $phpbb_container;

		$this->phpEx = $phpEx;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->mapper = $mapper;
	}

	public function save($values)
	{

		$img_path = $values['img_path'];
		$img_file = $values['img_file'];

		$upload_dir = 'images/brand/';
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
    }
    $file->move_file($upload_dir, true);

		if($img_path)
		{
				$img = $img_path;
		}

		$model = new \wardormeur\theinventory\model\parent_model($values);
		if(isset($values['local_id']))
		{
			$affected = $this->mapper->update($model);
		}
		else
		{
			$affected = $this->mapper->insert($model);
		}
		
		if($affected > 0){
			$result = $model;
		}else{
			$result = false;
		}
		return $result;
	}

	public function remove()
	{
		$this->mapper->delete();
	}

	public function get($parameters = [])
	{
		$sql_models = $this->mapper->select($parameters);
		$models = [];
		foreach($sql_models as $sql_model){
			$models[] = new \wardormeur\theinventory\model\parent_model($sql_model);
		}
		return $models;

	}


}
?>
