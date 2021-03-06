<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\controller;

class brand extends abstract_controller
{


public function show($name)
	{
		if($name) //We have a specific brand to display
		{
			$models = $this->parent_model->get(['name'=>$name]);
			$model = $models[0];
			$img = strlen($model->get_image_path())> 1 ? $this->helper->route('wardormeur_theinventory_image_brand', array('name'=>$model->get_image_path())) : '';
			$this->template->assign_block_vars('brand',
				array(
					'name'=> $model->get_name(),
					'local_id'=>$model->get_local_id(),
					'description'=>$model->get_description(),
					'url'=>$model->get_url(),
					'image'=>$img,
					'U_NEW' => $this->auth->acl_get('a_ti_create')||$this->auth->acl_get('m_ti_create')||$this->auth->acl_get('u_ti_create')  ? $this->helper->route('wardormeur_theinventory_newbrand') : false,
					'U_EDIT' => $this->auth->acl_get('a_ti_edit')||$this->auth->acl_get('m_ti_edit')||$this->auth->acl_get('u_ti_edit') ? $this->helper->route('wardormeur_theinventory_editbrand',array('name'=>$model->get_name())) : false,
					'U_DELETE' => $this->auth->acl_get('a_ti_remove')||$this->auth->acl_get('m_ti_remove')||$this->auth->acl_get('u_ti_remove') ?$this->helper->route('wardormeur_theinventory_removebrand',array('name'=>$model->get_name())) : false,
					// 'U_WARN_brand' => $this->helper->route('wardormeur_theinventory_newbrand'),
					// 'U_INFO_brand' => $this->helper->route('wardormeur_theinventory_newbrand'),
					// 'U_QUOTE_brand' => $this->helper->route('wardormeur_theinventory_newbrand')
				)
			);
		}

		return $this->helper->render('brand_body.html', $name);
	}


	public function edit($name)
	{
		if($name) //We have a specific brand to display
		{
			$models = $this->parent_model->get(['name'=>$name]);
			$model = $models[0];
			$img = strlen($model->get_image_path())> 1 ? $this->helper->route('wardormeur_theinventory_image_brand', array('name'=>$model->get_image_path())) : '';

			$this->template->assign_block_vars('brand',
				array(
					'name'=> $model->get_name(),
					'local_id'=>$model->get_local_id(),
					'image'=>$img,
					'image_path'=>$model->get_image_path(),
					'url'=>$model->get_url(),
					'description'=>$model->get_description(),
					'U_EDIT' => $this->helper->route('wardormeur_theinventory_savebrand',array('name'=>$model->get_name())),
					'U_NEW_BRAND' => $this->helper->route('wardormeur_theinventory_newbrand')
				)
			);
		}

		return $this->helper->render('edit_brand_body.html', $name);
	}


	public function add()
	{
		$this->expected = ['name'];
		$name = $this->request->variable('name','');
		$this->save($name,true);
	}

	public function save($name,$fast_redir = false)
	{
		$this->setExpected(['local_id','img_path','brand','description','name','url']);
		$values = $this->getSingleValues();
		$added = $this->parent_model->save($values);
		if($added && !$fast_redir)
		{
			redirect($this->helper->route('wardormeur_theinventory_brand',array('name'=>$added->get_name())));
		}else
		{
			if($fast_redir){
				redirect($this->helper->route('wardormeur_theinventory_main', array('brand_id'=>$added->get_local_id())));
			}else {
				return $this->helper->render('edit_brand_body.html', $added->get_name()); //??scenario
			}
		}

	}

	public function remove($name){

		$brands = $this->parent_model->get(['name'=>$name]);
		$brand = $brands[0];
		$this->parent_model->remove($brand->get_local_id());
		redirect($this->helper->route('wardormeur_theinventory_main'));

	}
}
