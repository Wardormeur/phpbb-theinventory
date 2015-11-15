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
		$this->phpbb_root_path = $phpbb_container->getParameter('core.root_path');
		$this->mapper = $mapper;
	}

	public function save($values)
	{

		$exists = isset($values['local_id']);
		if($exists){
			$models = $this->get(['local_id'=>$values['local_id']]);
			$model = $models[0];
		}

		$upload_dir = 'images/brand';
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

		if(isset($values['img_path']) )
		{
			if($exists){
				$values['image_path'] = $model->get_image_path();
				if( $values['img_path'] != 	$values['image_path'] ){
					$file = $upload->remote_upload($values['img_path']);
				}
			}
			else {
				$file = $upload->remote_upload($values['img_path']);
			}
		}
		
		if (!empty($file->filename))
		{
			$file->move_file($upload_dir, true);
			$values['image_path'] = $file->uploadname;
		}

		$model = new \wardormeur\theinventory\model\parent_model($values);
		if($exists)
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

	public function remove($parent_id)
	{
		$this->mapper->delete($parent_id);
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
