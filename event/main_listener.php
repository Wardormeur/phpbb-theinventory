<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'load_language_on_setup',
			'core.page_header'						=> 'add_page_header_link',
      'core.permissions'                  => 'permission_ti',
			/*User display*/
			'core.memberlist_view_profile' => 'get_user_relationships',
			'core.viewtopic_modify_post_row' => 'get_users_relationships',
			// 'core.viewtopic_cache_user_data' => 'set_users_relationships',
			//Credits @vse for ABBBC3.1
			// // functions_content events
			// 'core.modify_text_for_display_before'		=> 'parse_bbcodes_before',
			// 'core.modify_text_for_display_after'		=> 'parse_bbcodes_after',
			//
			// // functions_display events
			// 'core.display_custom_bbcodes_modify_row'	=> 'display_bbcodes',
			//
			// // message_parser events
			// 'core.modify_format_display_text_after'		=> 'parse_bbcodes_after',
			// 'core.modify_bbcode_init'					=> 'allow_custom_bbcodes',
		);
	}

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	/**
	* Constructor
	*
	* @param \phpbb\controller\helper	$helper		Controller helper object
	* @param \phpbb\template			$template	Template object
	*/
	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template,
	\wardormeur\theinventory\service\ownership $ownership, \wardormeur\theinventory\service\gen_model $product ,\wardormeur\theinventory\service\parent_model $parent_model )
	{
		$this->helper = $helper;
		$this->template = $template;
		$this->ownership = $ownership;
		$this->product = $product;
		$this->parent_model = $parent_model;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'wardormeur/theinventory',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_page_header_link($event)
	{
		$this->template->assign_vars(
		array(
			'U_PRODUCT_PAGE'	=> $this->helper->route('wardormeur_theinventory_main')
			)
		);
	}

	public function permission_ti($event)
	{
		$permissions = $event['permissions'];
		$permissions['a_ti_create'] = array('lang' => 'ACL_A_TI_CREATE', 'cat' => 'misc');
		$permissions['a_ti_edit'] = array('lang' => 'ACL_A_TI_EDIT', 'cat' => 'misc');
		$permissions['a_ti_remove'] = array('lang' => 'ACL_A_TI_REMOVE', 'cat' => 'misc');

		$permissions['m_ti_create'] = array('lang' => 'ACL_M_TI_CREATE', 'cat' => 'misc');
		$permissions['m_ti_edit'] = array('lang' => 'ACL_M_TI_EDIT', 'cat' => 'misc');
		$permissions['m_ti_remove'] = array('lang' => 'ACL_M_TI_REMOVE', 'cat' => 'misc');

		$permissions['u_ti_create'] = array('lang' => 'ACL_U_TI_CREATE', 'cat' => 'misc');
		$permissions['u_ti_edit'] = array('lang' => 'ACL_U_TI_EDIT', 'cat' => 'misc');
		$permissions['u_ti_remove'] = array('lang' => 'ACL_U_TI_REMOVE', 'cat' => 'misc');

		$permissions['u_ti_own'] = array('lang' => 'ACL_U_TI_OWN', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}

		public function get_user_relationships($event)
		{
				$meins = $this->get_ownings($event['member']['user_id']);

				foreach($meins as $mein){
					$this->template->assign_block_vars(
						'products', $mein
					);
				}
		}


		public function get_users_relationships($event)
		{
					$meins = $this->get_ownings($event['row']['user_id']);
					$event['post_row'] = array_merge($event['post_row'], array(
						'products' => $meins
					));
		}

	private function get_ownings($user_id){
		$meins = [];
		$mein = [];
		$relationship = $this->ownership->get_user_ownings($user_id );
		foreach ($relationship as $product) {
			$_products = $this->product->get(['local_id' => $product['local_id']]);
			$_product = $_products[0];
			$brands = $this->parent_model->get(['local_id'=>$_product->get_brand_id()]);
			$brand = $brands[0];

			$mein['name'] = $_product->get_name();
			$mein['product_url'] = $this->helper->route('wardormeur_theinventory_product', array('name'=>$_product->get_name()));
			$mein['brand_url'] = $this->helper->route('wardormeur_theinventory_brand', array('name'=>$brand->get_name()));
			$mein['brand'] = $brand->get_name();
			$meins[] = $mein;
		}
		return $meins;
	}
	// /**
	//  * Alter BBCodes before they are processed by phpBB
	//  *
	//  * This is used to change old/malformed ABBC3 BBCodes to a newer structure
	//  *
	//  * @param object $event The event object
	//  * @return null
	//  * @access public
	//  */
	// public function parse_bbcodes_before($event)
	// {
	// 	// $event['text'] = $this->bbcodes_handler->pre_parse_bbcodes($event['text'], $event['uid']);
	// }
	//
	// /**
	//  * Alter BBCodes after they are processed by phpBB
	//  *
	//  * This is used on ABBC3 BBCodes that require additional post-processing
	//  *
	//  * @param object $event The event object
	//  * @return null
	//  * @access public
	//  */
	// public function parse_bbcodes_after($event)
	// {
	// 	// $event['text'] = $this->bbcodes_handler->post_parse_bbcodes($event['text']);
	// }
	//
	// /**
	//  * Alter custom BBCodes display
	//  *
	//  * @param object $event The event object
	//  * @return null
	//  * @access public
	//  */
	// public function display_bbcodes($event)
	// {
	// 	// $event['custom_tags'] = $this->bbcodes_handler->display_bbcodes($event['custom_tags'], $event['row']);
	// }


}
