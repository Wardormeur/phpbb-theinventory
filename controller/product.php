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

	public function show($name)
	{
		if($name) //We have a specific product to display
		{
			$products = $this->gen_model->get(['name'=>$name]);
			$product = $products[0];
			$brands = $this->parent_model->get(['local_id'=>$product->get_brand_id()]);
			$brand = $brands[0];
			$img_path = $product->get_image_path();
			$img = sizeof($img_path)> 1 ? $this->helper->route('wardormeur_theinventory_image_product', array('name'=>$img_path)) : '';
				$this->template->assign_block_vars('product',
				array(
					'name'=> $product->get_name(),
					'id'=>$product->get_name(),
					'brand'=> $brand->get_name(),
					'image'=> $img,
					'U_NEW' => $this->helper->route('wardormeur_theinventory_newproduct'),
					'U_EDIT' => $this->helper->route('wardormeur_theinventory_editproduct',array('name'=>$product->get_name())),
					'U_DELETE' => $this->helper->route('wardormeur_theinventory_removeproduct',array('name'=>$product->get_name())),
					'U_SEARCH_BRAND' => $this->helper->route('wardormeur_theinventory_main',array('brand'=>$brand->get_name())),
					// 'U_WARN_PRODUCT' => $this->helper->route('wardormeur_theinventory_newproduct'),
					// 'U_INFO_PRODUCT' => $this->helper->route('wardormeur_theinventory_newproduct'),
					// 'U_QUOTE_PRODUCT' => $this->helper->route('wardormeur_theinventory_newproduct')
				)
			);
			$this->template->assign_vars(array(
				'U_FAV_PRODUCT' => $this->helper->route('wardormeur_theinventory_favproduct',array('name'=>$product->get_name())),
			));
		}

		$properties = $product->get_properties();
		if(sizeof($properties)>0){
			foreach($properties as $property){
				$display_properties = $property->get_values(['label','value','unit','local_id']);
				$this->template->assign_block_vars(
					'product.property', $display_properties
				);
			}
			// var_dump($display_properties);
		}


		return $this->helper->render('product_body.html', $name);
	}


	public function edit($name)
	{
		if($name) //We have a specific product to display
		{
			$models = $this->gen_model->get(['name'=>$name]);
			$model = $models[0];
			//TODO : check, empty get returns the full list, so what is $brand ?
			$brands = $this->parent_model->get();
			$brand_id = $model->get_local_id();
			foreach($brands as $l_brand){
	      $a_brand = $l_brand->get_values(['name','local_id']);
	      if(!empty($values['brand_id'])){
	        $a_brand['selected'] = $a_brand['local_id'] ==  $brand_id ? true : false;
	      }
	      $this->template->assign_block_vars(
	        'option', $a_brand
	      );
	    }

			$img_path = $model->get_image_path();
			$img = sizeof($img_path) > 1 ? $this->helper->route('wardormeur_theinventory_image_product', array('name'=>$img_path)) : '';

			$this->template->assign_block_vars('product',
				array(
					'name'=> $model->get_name(),
					'local_id'=>$model->get_local_id(),
					'image_path'=>$img,
					'U_EDIT' => $this->helper->route('wardormeur_theinventory_saveproduct',array('name'=>$model->get_name())),
					'U_NEW_PRODUCT' => $this->helper->route('wardormeur_theinventory_newproduct')
				)
			);

			$properties = $model->get_properties();
			if(sizeof($properties)>0){
				foreach($properties as $property){
					$display_properties = $property->get_values(['label','value','unit','local_id']);
					$this->template->assign_block_vars(
						'product.property', $display_properties
					);
				}
				// var_dump($display_properties);
			}

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
		$this->setExpected(['brand_id','img_path','img_file','product_gallery','local_id','name',
				'propertylabel','propertyvalue','propertyunit','propertylocal_id']);
		$values = $this->getSingleValues();
		$array_values = $this->getArrayValues();
		// $values = array_merge($values, $array_values);
		$values['properties'] = $array_values;
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

	public function fav($name){
		$products = $this->gen_model->get(['name'=>$name]);
		$product = $products[0];
		if($this->ownership->get_user_ownings($this->user->data['user_id'], $product->get_local_id())){
			$this->ownership->toggle_user_own_product($this->user->data['user_id'], $product->get_local_id());
		}else{
			$this->ownership->add_user_own_product($this->user->data['user_id'], $product->get_local_id());
		}
	}


}
