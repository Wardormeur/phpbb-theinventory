<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\wardormeur\theinventory\acp\main_module',
			'title'		=> 'ACP_TI_TITLE',
			'version'	=> '0.0.1',
			'modes'		=> array(
				'settings'	=> array(
					'title' => 'ACP_TI',
					'auth' => 'ext_wardormeur/theinventory && acl_a_user',
					'cat' => array('ACP_TI_TITLE')),
			),
		);
	}
}
