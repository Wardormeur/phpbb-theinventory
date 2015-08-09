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

  }
  public function search()
  {
    $brand = $this->request->variable('brand','');
    $name = $this->request->variable('name','');
    $brands = $this->brand->get_brands();
    array_unshift($brands,['name'=>'']);

    foreach($brands as $l_brand){
			$l_brand['selected'] = $l_brand['name'] == $brand ? true : false;
      $this->template->assign_block_vars(
        'option', $l_brand
      );
    }

    $this->template->assign_vars(
      array(
        'U_NEW' => $this->helper->route('wardormeur_theinventory_savenewproduct'),
        'U_NEW_BRAND' => $this->helper->route('wardormeur_theinventory_savenewbrand')
      )
    );
    $products = $this->product->search_product($name,$brand);
     foreach($products as $product){
      $product['url'] = $this->helper->route('wardormeur_theinventory_product',
													array('name'=>$product['name'])
												);
			$brand = $this->brand->get($product['brand_id']);
			$product['brand_url'] = $this->helper->route('wardormeur_theinventory_brand',
													array('name'=>$brand->get_name())
												);
			$product['brand'] = $brand->get_name();
      $this->template->assign_block_vars(
        'product'	,	$product
      );
     }
    return $this->helper->render('search_body.html'); //necrophile, yeahss
  }

}
