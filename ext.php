<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory;
// require_once __DIR__.'/../model/parent_model.php';
// require_once __DIR__.'/../model/gen_model.php';

/**
* @ignore
*/

class ext extends \phpbb\extension\base
{
  /**
  	* @param mixed $old_state State returned by previous call of this method
  	* @return mixed Returns false after last step, otherwise temporary state
  	* @access public
  	*/
  	public function enable_step($old_state)
  	{
      global $phpbb_root_path;
  	   mkdir($phpbb_root_path.'/images/brand');
   	   mkdir($phpbb_root_path.'/images/product');
  	}

  	/**
  	* @param mixed $old_state State returned by previous call of this method
  	* @return mixed Returns false after last step, otherwise temporary state
  	* @access public
  	*/
  	public function purge_step($old_state)
  	{
      //TODO : find a cleaner way
      // global $phpbb_root_path;
      // $image_bpath = $phpbb_root_path.'/images/brand';
      // $image_ppath = $phpbb_root_path.'/images/product';
      // $windows = ['Windows','MINGW32_NT-6.2','WINNT','WIN32'];
      // if ( in_array(PHP_OS,$windows))
      // {
      //   exec("rd /s /q '{$image_bpath}'");
      //   exec("rd /s /q '{$image_ppath}'");
      // }
      // else
      // {
      //   exit;
      //   exec("rm -rf {$image_bpath}");
      //   exec("rm -rf {$image_ppath}");
      // }

  	}

}
