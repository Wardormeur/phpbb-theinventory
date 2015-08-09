<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\controller;

class product
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
	\wardormeur\theinventory\service\product $product,
	\wardormeur\theinventory\service\brand $brand,
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
		$this->brand = $brand;
		include_once($phpbb_root_path . 'includes/functions_upload.' . $phpEx);
		$this->upload = new \fileupload();
	}


public function show($name)
	{
		if($name) //We have a specific product to display
		{
			$this->product->get_product_by_name($name);
			$this->product->set_brand(
				$this->brand->get(
					$this->product->get_brand())); //thx php for non-typed variable
			$this->template->assign_block_vars('product',
				array(
					'name'=> $this->product->get_name(),
					'id'=>$this->product->get_local_id(),
					'brand'=> $this->product->get_brand()->get_name(),
					'image'=>$this->product->get_image(),
					'U_NEW' => $this->helper->route('wardormeur_theinventory_newproduct'),
					'U_EDIT' => $this->helper->route('wardormeur_theinventory_editproduct',array('name'=>$this->product->get_name())),
					'U_DELETE' => $this->helper->route('wardormeur_theinventory_removeproduct',array('name'=>$this->product->get_name())),
					'U_SEARCH_BRAND' => $this->helper->route('wardormeur_theinventory_main',array('brand'=>$this->product->get_brand()->get_name())),
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
			$product_brand = $this->brand->get($this->product->get_brand());
			$this->product->set_brand($product_brand);

			$brands = $this->brand->get_brands();
			foreach($brands as $l_brand){
				$l_brand['selected'] = $l_brand['name'] == $product_brand->get_name() ? true : false;
				$this->template->assign_block_vars(
					'option', $l_brand
				);
			}
			$this->template->assign_block_vars('product',
				array(
					'name'=> $this->product->get_name(),
					'local_id'=>$this->product->get_local_id(),
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
		$product_name = $this->request->variable('name',$name);

		if (!class_exists('fileupload'))
			 {
					 include_once($phpbb_root_path . 'includes/functions_upload.' . $phpEx);
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

		if($product_gallery)
		{	//eheck if gallery exists?
			$img = $product_gallery;
		}
		if($img_path)
		{
				$img = $file->filename;
		}

		//should recover and update instead of doing that
		$this->product->set_name($product_name);
		$this->product->set_brand($this->brand->get_brand_by_name($brand));
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
		redirect($this->helper->route('wardormeur_theinventory_main'));

	}



}
