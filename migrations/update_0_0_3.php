<?php
//add ownership
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\migrations;

class update_0_0_3 extends \phpbb\db\migration\migration
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
          $this->table_prefix . 'ti_product_properties'        => array(
            'COLUMNS'        => array(
              'local_id'                => array('UINT', NULL,'auto_increment'),
              'property_id'                 =>  array('UINT',NULL),
              'label'                 =>  array('VCHAR:255',''),
              'value'                 =>  array('TEXT',''),
              'unit'                  =>  array('VCHAR:255',''),
              'type'                  =>  array('VCHAR',32),
              'parent_id'                  =>  array('UINT',0)
              ),
              'PRIMARY_KEY'        => 'local_id',
              'KEYS'                => array(
                'pk'            => array('INDEX', 'local_id'),
              ),
            ),
          // $this->table_prefix . 'ti_property_types'        => array(
          //   'COLUMNS'        => array(
          //     'type_id'               => array('UINT', NULL),
          //     'type_value'            => array('VCHAR:255')
          //     ),
          //     'PRIMARY_KEY'        => 'type_id',
          //     'KEYS'                => array(
          //       'pk'            => array('INDEX', 'type_id'),
          //     ),
          //   ) ,
          )
        );
    }

    public function revert_schema()
    {
      return array(
        'drop_tables'	=>array(
          $this->table_prefix . 'ti_product_properties',
          // $this->table_prefix . 'ti_property_types'
        )
      );

    }
    //
    // public function update_data()
    // {
    //   return array(
    //     array('custom',
    //       array(
    //           array($this, 'add_types')
    //       )
    //   ));
    // }

    private function add_types(){
      $types = ['number','text','textarea','mail','url'];//,'list']
      foreach($types as $type){
        $row['type_value'] = $type;
        $sql = "INSERT INTO {$this->table_prefix} {$this->db->sql_build_array('INSERT',$row)}";
      }

    }
  }
