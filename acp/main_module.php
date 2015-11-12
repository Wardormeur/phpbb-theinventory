<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\acp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache, $request;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$this->config = $config;
		$this->request = $request;


		$user->add_lang('acp/common');
		$this->tpl_name = 'ti_body';
		$this->page_title = $user->lang('ACP_TI_TITLE');
		add_form_key('theinventory');

		// if ($request->is_set_post('submit'))
		// {
		// 	if (!check_form_key('theinventory'))
		// 	{
		// 		trigger_error('FORM_INVALID');
		// 	}
		// 	$this->config->set('ti_slave_path',$this->request->variable('slave_path',''));
		// 	$this->config->set('ti_mode',$this->request->variable('mode',0));
		//
		//
		// 	trigger_error($user->lang('ACP_TI_SETTING_SAVED') . adm_back_link($this->u_action));
		// }
		//
		// $template->assign_vars(array(
		// 	'U_ACTION'				=> $this->u_action,
		// ));
	}
}
