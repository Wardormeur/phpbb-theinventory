<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\controller;

include_once 'abstract_controller.php' ;


class brand extends abstract_controller
{


public function show($name)
	{
		if($name) //We have a specific brand to display
		{
			$this->parent_model->get(['name'=>$name]);
			$this->template->assign_block_vars('brand',
				array(
					'name'=> $this->parent_model->get_name(),
					'local_id'=>$this->parent_model->get_local_id(),
					'description'=>$this->parent_model->get_description(),
					'url'=>$this->parent_model->get_url(),
					'image'=>$this->parent_model->get_image(),
					'U_NEW' => $this->helper->route('wardormeur_theinventory_newbrand'),
					'U_EDIT' => $this->helper->route('wardormeur_theinventory_editbrand',array('name'=>$this->parent_model->get_name())),
					'U_DELETE' => $this->helper->route('wardormeur_theinventory_removebrand',array('name'=>$this->parent_model->get_name())),
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
			$this->parent_model->get(['name'=>$name]);
			$this->template->assign_block_vars('brand',
				array(
					'name'=> $this->parent_model->get_name(),
					'local_id'=>$this->parent_model->get_local_id(),
					'image_path'=>$this->parent_model->get_image(),
					'url'=>$this->parent_model->get_url(),
					'description'=>$this->parent_model->get_description(),
					'U_EDIT' => $this->helper->route('wardormeur_theinventory_savebrand',array('name'=>$this->parent_model->get_name())),
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
		$this->setExpected(['local_id','image','brand','description','name']);
		$values = $this->getValues();
		$added = $this->parent_model->save($values);
		if($added && !$fast_redir)
		{
			redirect($this->helper->route('wardormeur_theinventory_brand',array('name'=>$added->get_name())));
		}else
		{
			if($fast_redir){
				redirect($this->helper->route('wardormeur_theinventory_main', array('brand_id'=>$added->get_name())));
			}else {
				return $this->helper->render('edit_brand_body.html', $added->get_name()); //??scenario
			}
		}

	}

	public function remove($name){

		$brand = $this->parent_model->get(['name'=>$name]);
		$this->parent_model->remove($brand->get_local_id());
		redirect($this->helper->route('wardormeur_theinventory_main'));

	}
}
