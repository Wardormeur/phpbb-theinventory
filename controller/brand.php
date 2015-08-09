<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\controller;

class brand
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
	\wardormeur\theinventory\service\brand $brand,
	\phpbb\request\request $request,
		$phpEx,
		$phpbb_root_path)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->brand = $brand;
		$this->request = $request;
		include_once($phpbb_root_path . 'includes/functions_upload.' . $phpEx);
		$this->upload = new \fileupload();
	}


public function show($name)
	{
		if($name) //We have a specific brand to display
		{
			$this->brand->get_brand_by_name($name);
			$this->template->assign_block_vars('brand',
				array(
					'name'=> $this->brand->get_name(),
					'local_id'=>$this->brand->get_local_id(),
					'description'=>$this->brand->get_description(),
					'url'=>$this->brand->get_url(),
					'image'=>$this->brand->get_image(),
					'U_NEW' => $this->helper->route('wardormeur_theinventory_newbrand'),
					'U_EDIT' => $this->helper->route('wardormeur_theinventory_editbrand',array('name'=>$this->brand->get_name())),
					'U_DELETE' => $this->helper->route('wardormeur_theinventory_removebrand',array('name'=>$this->brand->get_name())),
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
			$this->brand->get_brand_by_name($name);
			$this->template->assign_block_vars('brand',
				array(
					'name'=> $this->brand->get_name(),
					'local_id'=>$this->brand->get_local_id(),
					'image_path'=>$this->brand->get_image(),
					'url'=>$this->brand->get_url(),
					'description'=>$this->brand->get_description(),
					'U_EDIT' => $this->helper->route('wardormeur_theinventory_savebrand',array('name'=>$this->brand->get_name())),
					'U_NEW_BRAND' => $this->helper->route('wardormeur_theinventory_newbrand')
				)
			);
		}

		return $this->helper->render('edit_brand_body.html', $name);
	}


	public function add()
	{
		$name = $this->request->variable('name','');
		$this->save($name,true);
	}

	public function save($name,$fast_redir = false)
	{
		$img_path = $this->request->variable('img_path','');
		$img_file = $this->request->variable('img_file','');
		$local_id = $this->request->variable('brand_id','');
		$description = $this->request->variable('description','');
		$url = $this->request->variable('url','');

		$upload_dir = 'images/brand/';
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

		if($img_path)
		{
				$img = $img_path;
		}
		$this->brand->set_local_id($local_id);
		$this->brand->set_name($name);
		$this->brand->set_image($file->filename);
		$this->brand->set_description($description);
		$this->brand->set_url($url);

		$added = $this->brand->save();
		if($added && !$fast_redir)
		{
			redirect($this->helper->route('wardormeur_theinventory_brand',array('name'=>$this->brand->get_name())));
		}else
		{
			if($fast_redir){
				redirect($this->helper->route('wardormeur_theinventory_main', array('brand'=>$this->brand->get_name())));
			}else {
				return $this->helper->render('edit_brand_body.html', $name);
			}
		}

	}

	public function remove($name){

		$brand = $this->brand->get_brand_by_name($name);
		$this->brand->remove();
		redirect($this->helper->route('wardormeur_theinventory_main'));

	}
}
