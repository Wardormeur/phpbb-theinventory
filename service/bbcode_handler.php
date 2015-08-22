<?php
/**
*
* Advanced BBCode Box
*
* @copyright (c) 2013 Matt Friedman
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace wardormeur\theinventory\service;

/**
* ABBC3 core BBCodes display class
*/
class bbcode_handler
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\extension\manager */
	protected $extension_manager;

	/** @var \phpbb\user */
	protected $user;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $ext_root_path;

	/** @var array */
	protected $memberships;

	/**
	 * Constructor
	 *
	 * @param string                            $root_path         phpBB root path
	 * @param string                            $ext_root_path     Extension root path
	 * @access public
	 */
	public function __construct($root_path, $ext_root_path)
	{
		$this->root_path = $root_path;
		$this->ext_root_path = $ext_root_path;
	}


}
