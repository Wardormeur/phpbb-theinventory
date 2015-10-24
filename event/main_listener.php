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
	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template)
	{
		$this->helper = $helper;
		$this->template = $template;
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
