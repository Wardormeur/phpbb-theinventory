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


class product extends abstract_controller
{

		// include_once($phpbb_root_path . 'includes/functions_upload.' . $phpEx);
		// $this->upload = new \fileupload();


public function show($name)
	{
		if($name) //We have a specific product to display
		{
			$products = $this->gen_model->get(['name'=>$name]);
			$product = $products[0];
			$brands = $this->parent_model->get(['local_id'=>$product->getBrandId()]);
			$brand = $brands[0];
			$this->template->assign_block_vars('product',
				array(
					'name'=> $product->get_name(),
					'id'=>$product->get_name(),
					'brand'=> $brand->get_name(),
					'image'=>$product->getImagePath(),
					'U_NEW' => $this->helper->route('wardormeur_theinventory_newproduct'),
					'U_EDIT' => $this->helper->route('wardormeur_theinventory_editproduct',array('name'=>$product->get_name())),
					'U_DELETE' => $this->helper->route('wardormeur_theinventory_removeproduct',array('name'=>$product->get_name())),
					'U_SEARCH_BRAND' => $this->helper->route('wardormeur_theinventory_main',array('brand'=>$brand->get_name())),
					// 'U_WARN_PRODUCT' => $this->helper->route('wardormeur_theinventory_newproduct'),
					// 'U_INFO_PRODUCT' => $this->helper->route('wardormeur_theinventory_newproduct'),
					// 'U_QUOTE_PRODUCT' => $this->helper->route('wardormeur_theinventory_newproduct')
				)
			);
		}

		return $this->helper->render('product_body.html', $name);
	}


	public function edit($name)
	{
		if($name) //We have a specific product to display
		{
			$models = $this->gen_model->get(['name'=>$name]);
			$model = $models[0];
			$brands = $this->parent_model->get();
			$brand = $brands[0];
			foreach($brands as $l_brand){
	      $a_brand = $l_brand->get_values(['name','local_id']);
	      if(!empty($values['brand_id'])){
	        $a_brand['selected'] = $a_brand['local_id'] == $brand['local_id'] ? true : false;
	      }
	      $this->template->assign_block_vars(
	        'option', $a_brand
	      );
	    }
			$this->template->assign_block_vars('product',
				array(
					'name'=> $model->get_name(),
					'local_id'=>$model->get_name(),
					'image_path'=>$model->getImagePath(),
					'U_EDIT' => $this->helper->route('wardormeur_theinventory_saveproduct',array('name'=>$model->get_name())),
					'U_NEW_PRODUCT' => $this->helper->route('wardormeur_theinventory_newproduct')
				)
			);
		}

		return $this->helper->render('edit_product_body.html', $name);
	}


	public function add()
	{
		$name = $this->request->variable('name','');
		$this->save($name);
	}

	public function save($name)
	{
		$this->setExpected(['brand_id','img_path','img_file','product_gallery','local_id','name']);
		$values = $this->getValues();

		$added = $this->gen_model->save($values);
		if($added)
		{
			redirect($this->helper->route('wardormeur_theinventory_product',array('name'=>$values['name'])));
		}else
		{
			return $this->helper->render('edit_product_body.html', $values['name']);
		}

	}

	public function remove($name){

		$product = $this->gen_model->get(['name'=>$name]);
		$this->gen_model->remove($product->get_name());
		redirect($this->helper->route('wardormeur_theinventory_main'));

	}



}
