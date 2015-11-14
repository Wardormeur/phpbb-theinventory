<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\controller;

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
			$ownership =  $this->ownership->is_user_owning( $this->user->data['user_id'], $product->get_local_id());
			$img = sizeof($img_path)> 1 ? $this->helper->route('wardormeur_theinventory_image_product', array('name'=>$img_path)) : '';
				$this->template->assign_block_vars('product',
				array(
					'name'=> $product->get_name(),
					'id'=>$product->get_name(),
					'brand'=> $brand->get_name(),
					'image'=> $img,
					'U_NEW' => $this->auth->acl_get('u_ti_create') ? $this->helper->route('wardormeur_theinventory_newproduct') : false,
					'U_EDIT' => $this->auth->acl_get('u_ti_edit') ? $this->helper->route('wardormeur_theinventory_editproduct', array('name'=>$product->get_name())) : false,
					'U_DELETE' => $this->auth->acl_get('u_ti_remove') ? $this->helper->route('wardormeur_theinventory_removeproduct',array('name'=>$product->get_name())) : false,
					'U_SEARCH_BRAND' => $this->helper->route('wardormeur_theinventory_main',array('brand'=>$brand->get_name())),
					'U_OWN' => $ownership
					// 'U_WARN_PRODUCT' => $this->helper->route('wardormeur_theinventory_newproduct'),
					// 'U_INFO_PRODUCT' => $this->helper->route('wardormeur_theinventory_newproduct'),
					// 'U_QUOTE_PRODUCT' => $this->helper->route('wardormeur_theinventory_newproduct')
				)
			);
			$this->template->assign_vars(array(
				'U_FAV_PRODUCT' => $this->helper->route('wardormeur_theinventory_favproduct',array('name'=>$product->get_name())),
				'SESSION_ID' => $this->user->data['session_id']
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

		$products = $this->gen_model->get(['name'=>$name]);
		$this->gen_model->remove($products[0]->get_local_id());
		redirect($this->helper->route('wardormeur_theinventory_main'));

	}
	/*Ajax call*/
	public function fav($name){

		$this->setExpected(['session_id']);
		$values = $this->getSingleValues();
		$user_id = $this->extuser->get_by_session($values['session_id']);
		$products = $this->gen_model->get(['name'=>$name]);
		$product = $products[0];
		$relationship_exists = $this->ownership->is_user_owning( $user_id['session_user_id'], $product->get_local_id());
		if($relationship_exists){
			$relationship = $this->ownership->get_user_ownings( ['user_id' =>$user_id['session_user_id'], 'p.local_id' => $product->get_local_id()]);
			$status = $this->ownership->toggle_user_own_product($user_id['session_user_id'], $product->get_local_id(), $relationship[0]['status']);
		}else{
			$status = $this->ownership->add_user_own_product($user_id['session_user_id'], $product->get_local_id());
		}
		return $this->helper->message($status, [], 'OWN_DESC');
	}


}
