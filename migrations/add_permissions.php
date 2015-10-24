<?php
/**
*
* @package Ban Hammer
* @copyright (c) 2015 phpBB Modders <https://phpbbmodders.net/>
* @author Jari Kanerva <jari@tumba25.net>
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\migrations;

class add_permissions extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
			return array(
					'\wardormeur\theinventory\migrations\release_0_0_1'
			);
	}
	public function update_data()
	{

		return(array(
			array('permission.add', array('a_ti_edit')),
			array('permission.add', array('m_ti_edit')),
			array('permission.add', array('u_ti_edit')),

  		array('permission.add', array('a_ti_remove')),
			array('permission.add', array('m_ti_remove')),
			array('permission.add', array('u_ti_remove')),
		));
	}

	public function revert_data()
	{
		return(array(
			array('permission.remove', array('a_ti_edit')),
			array('permission.remove', array('m_ti_edit')),
			array('permission.remove', array('u_ti_edit')),

  		array('permission.remove', array('a_ti_remove')),
			array('permission.remove', array('m_ti_remove')),
			array('permission.remove', array('u_ti_remove')),

		));
	}

}