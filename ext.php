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

      $image_bpath = $phpbb_root_path.'/images/brand';
      $image_ppath = $phpbb_root_path.'/images/product';
      if(!is_dir($image_ppath)){
  	   mkdir($image_ppath);
      }
      if(!is_dir($image_bpath)){
   	   mkdir($image_bpath);
      }

			return parent::enable_step($old_state);

  	}

  	/**
  	* @param mixed $old_state State returned by previous call of this method
  	* @return mixed Returns false after last step, otherwise temporary state
  	* @access public
  	*/
  	public function purge_step($old_state)
  	{
      //TODO : loop plz
      global $phpbb_root_path;
      $image_ppath = $phpbb_root_path.'/images/product';
      $image_bpath = $phpbb_root_path.'/images/brand';
      array_map('unlink', glob("$image_ppath/*.*"));
      array_map('unlink', glob("$image_bpath/*.*"));
      rmdir($image_bpath);
      rmdir($image_ppath);

      return parent::disable_step($old_state);

  	}

}
