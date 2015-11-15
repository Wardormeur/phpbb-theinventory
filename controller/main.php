<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\controller;

class main extends abstract_controller
{

  public function search()
  {
		$this->setExpected(['brand_id','name']);
		$values = $this->getSingleValues();
    $brands = $this->parent_model->get();
    //initwith no value
    $this->template->assign_block_vars(
      'option', ['name'=>'']
    );

    //search filter init
    foreach($brands as $l_brand){
      $a_brand = $l_brand->get_values(['name','local_id']);
      if(!empty($values['brand_id'])){
        $a_brand['selected'] = $a_brand['local_id'] == $values['brand_id'] ? true : false;
      }
      $this->template->assign_block_vars(
        'option', $a_brand
      );
    }

    $this->template->assign_vars(
      array(
        'U_NEW' => $this->auth->acl_get('a_ti_create') || $this->auth->acl_get('m_ti_create') || $this->auth->acl_get('u_ti_create') ? $this->helper->route('wardormeur_theinventory_savenewproduct') : false,
        'U_NEW_BRAND' => $this->auth->acl_get('a_ti_create') || $this->auth->acl_get('m_ti_create') || $this->auth->acl_get('u_ti_create') ? $this->helper->route('wardormeur_theinventory_savenewbrand') : false
      )
    );

    //search results
    $products = $this->search->search($values);
     foreach($products as $product){
	      $product['url'] = $this->helper->route('wardormeur_theinventory_product',
														array('name'=>$product['name'])
													);
				$brands = $this->parent_model->get(['local_id'=>$product['brand_id']]);
        $brand = $brands[0];
        $product['brand_url'] = $this->helper->route('wardormeur_theinventory_brand',
														array('name'=>$brand->get_name())
													);
				$product['brand'] = $brand->get_name();
        $product['image_path'] = 	strlen($product['image_path'])> 1 ? $this->helper->route('wardormeur_theinventory_image_product', array('name'=>$product['image_path'])) : '';
	      $this->template->assign_block_vars(
	        'product'	,	$product
	      );
     }
    return $this->helper->render('search_body.html'); //necrophile, yeahss
  }

}
