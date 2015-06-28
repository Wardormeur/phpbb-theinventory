<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\controller;

class main
{
	/* @var \phpbb\config\config */
	protected $config;

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	/* @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\config\config		$config
	* @param \phpbb\controller\helper	$helper
	* @param \phpbb\template\template	$template
	* @param \phpbb\user				$user
	*/

	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper,
	 \phpbb\template\template $template, \phpbb\user $user,
	\wardormeur\theinventory\product $product,
	\phpbb\request\request $request,
		$phpEx,
		$phpbb_root_path)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->product = $product;
		$this->request = $request;
		include_once($phpbb_root_path . 'includes/functions_upload.' . $phpEx);
		$this->upload = new \fileupload();
	}


public function show($name)
	{
		if($name) //We have a specific product to display
		{
			$this->product->get_product_by_name($name);
			$this->template->assign_block_vars('product',
				array(
					'name'=> $this->product->get_name(),
					'id'=>$this->product->get_local_id(),
					'brand'=> $this->product->get_brand(),
					'image'=>$this->product->get_image(),
					'U_NEW' => $this->helper->route('wardormeur_theinventory_newproduct'),
					'U_EDIT' => $this->helper->route('wardormeur_theinventory_editproduct',array('name'=>$this->product->get_name())),
					'U_DELETE' => $this->helper->route('wardormeur_theinventory_removeproduct',array('name'=>$this->product->get_name())),
					'U_SEARCH_BRAND' => $this->helper->route('wardormeur_theinventory_productlist',array('brand'=>$this->product->get_brand())),
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
			$this->product->get_product_by_name($name);
			$this->template->assign_block_vars('product',
				array(
					'name'=> $this->product->get_name(),
					'local_id'=>$this->product->get_local_id(),
					'brand'=> $this->product->get_brand(),
					'image_path'=>$this->product->get_image(),
					'U_EDIT' => $this->helper->route('wardormeur_theinventory_saveproduct',array('name'=>$this->product->get_name())),
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
		$brand = $this->request->variable('brand','');
		$img_path = $this->request->variable('img_path','');
		$img_file = $this->request->variable('img_file','');
		$product_gallery = $this->request->variable('product_gallery','');
		$local_id = $this->request->variable('local_id','');

		$img = $this->upload->form_upload('img_file');
		if($product_gallery)
		{	//eheck if gallery exists?
			$img = $product_gallery;
		}
		if($img_path)
		{
				$img = $img_path;
		}
		$this->product->set_name($name);
		$this->product->set_brand($brand);
		$this->product->set_image($img);
		$this->product->set_local_id($local_id);
		$added = $this->product->save();
		if($added)
		{
			redirect($this->helper->route('wardormeur_theinventory_product',array('name'=>$this->product->get_name())));
		}else
		{
			return $this->helper->render('edit_product_body.html', $name);
		}

	}

	public function remove($name){

		$product = $this->product->get_product_by_name($name);
		$this->product->remove();
		redirect($this->helper->route('wardormeur_theinventory_productlist'));

	}


	public function search()
	{
		$brand = $this->request->variable('brand','');
		$name = $this->request->variable('name','');
		$brands = $this->product->get_brands();
		array_unshift($brands,['brand_name'=>'']);
	 	foreach($brands as $l_brand){
			$this->template->assign_block_vars(
				'option', $l_brand
			);
		}

		$this->template->assign_vars(
			array(
				'U_NEW' => $this->helper->route('wardormeur_theinventory_savenewproduct')
			)
		);
		$products = $this->product->search_product($name,$brand);
		 foreach($products as $product){
			$product['url'] = $this->helper->route('wardormeur_theinventory_product',array('name'=>$product['name']));
			$this->template->assign_block_vars(
				'product'	,	$product
			);
		 }
		return $this->helper->render('search_body.html'); //necrophile, yeahss
	}
}
