<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace wardormeur\theinventory\migrations;

class release_0_0_1 extends \phpbb\db\migration\migration
{
	//A product table
	//a table to link a product to a page
	//a tag table -> yes, but should not be synchronised with master, only local or slave
	//an img table?->no, link to img (allows phpbbGallery) or local upload ?
	//a brand table?->no, this is a light plugin, most work is handled by the slave or the master

	public function update_schema()
	{
		return
			array(
				'add_tables'    => array(
					$this->table_prefix . 'ti_product'        => array(
            'COLUMNS'        => array(
              'local_id'                => array('UINT', NULL, 'auto_increment'),
              'product_id'                => array('UINT',0),
              'name'                => array('VCHAR:255', ''),
              'brand_id'        		=> array('UINT', 0),
            	'image_path'                => array('VCHAR:255', ''),
              ),
              'PRIMARY_KEY'        => 'local_id',
//              'FOREIGN_KEY'				=> array('brand_id','brand_id'),
							'KEYS'                => array(
                'product_nm'            => array('INDEX', 'name'),
              ),
            ),
						$this->table_prefix . 'ti_brand'        => array(
	            'COLUMNS'        => array(
								'local_id'				=> array('UINT', NULL, 'auto_increment'),
								'brand_id'        => array('UINT', 0),
	            	'name'                => array('VCHAR:255', ''),
	              'image_path'			=> array('VCHAR:255',''),
								'description'			=> array('TEXT',''),
								'url'							=> array('VCHAR:255','')
								),
	              'PRIMARY_KEY'        => 'local_id',
	              'KEYS'                => array(
	                'brand_nm'            => array('INDEX', 'name'),
	              ),
          ),
		    	$this->table_prefix. 'ti_post_product'	=> array(
						'COLUMNS'	=> array(
			    	'local_id'	=> array('UINT',0),
			    	'post_id'	=> array('UINT',0)
	        	),
					'PRIMARY_KEY'	=> array('local_id','post_id'),
		    	)
				)
			);
	}


	public function revert_schema()
	{
		return array(
			'drop_tables'	=>array(
				$this->table_prefix . 'ti_product',
				$this->table_prefix . 'ti_post_product',
				$this->table_prefix . 'ti_brand'
			)
		);

	}

	public function update_data()
	{
		return array(
			array('config.add', array('ti_slave_path', '')),
			array('config.add', array('ti_mode',0)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_TI_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_TI_TITLE',
				array(
					'module_basename'	=> '\wardormeur\theinventory\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
