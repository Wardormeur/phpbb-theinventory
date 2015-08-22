//add ownership
<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\migrations;

class update_0_0_2 extends \phpbb\db\migration\migration
{
  static public function depends_on()
  {
      return array(
          '\wardormeur\theinventory\migrations\release_0_0_1'
      );
  }

  public function update_schema()
  {
    return
      array(
        'add_tables'    => array(
          $this->table_prefix . 'ti_users_ownership'        => array(
            'COLUMNS'        => array(
              'local_id'                => array('UINT', NULL),
              'user_id'                 =>  array('UINT',NULL,)
              ),
              'PRIMARY_KEY'        => array('local_id','user_id'),
              'KEYS'                => array(
                'product_user'            => array('INDEX', array('local_id','user_id')),
              ),
            ),
          ),
          $this->table_prefix . 'ti_users_sponsorship'        => array(
            'COLUMNS'        => array(
              'brand_id'                => array('UINT', NULL),
              'user_id'                 =>  array('UINT',NULL,)
              ),
              'PRIMARY_KEY'        => array('brand_id','user_id'),
              'KEYS'                => array(
                'product_user'            => array('INDEX', array('brand_id','user_id')),
              ),
            ),
          )
        );
    }

}
