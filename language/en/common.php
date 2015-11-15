<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_TI_TITLE'			=> 'TheInventory Module',
	'ACP_TI'					=> 'Settings',
	'EMPTY'						=> 'Nothing here, yet?',
	// rights
	'ACP_TI_SETTING_SAVED'	=> 'Settings have been saved successfully!',
	'ACL_A_TI_CREATE' => 'Can create products & brands',
	'ACL_A_TI_EDIT' => 'Can edit products & brands',
	'ACL_A_TI_REMOVE' => 'Can remove products & brands',
	'PRODUCT_PAGE'	=> 'Product page',
	// Buttons
	'PRODUCT_SEARCH'	=>	'Search a product',
	'NEW_PRODUCT'		=> 'Add new product',
	'LINK_TO'			=>	'Use online image',
	'UPLOAD_FROM'	=> 'Upload local image',
	'REMOVE_PROPERTY' => 'Remove property',
	'ADD_PROPERTY' => 'Add property',
	'NEW_BRAND'		=> 'Add new brand',
	'EDIT_PRODUCT' => 'Edit product',
	'DELETE_PRODUCT' => 'Remove product',
	// Details
	'BRAND_NAME'	=>	'Brand name',
	'BRAND_DESCRIPTION' => 'Description',
	'BRAND_URL'	=> 'Brands\'s website',
	'PRODUCT_NAME'	=>	'Product name',
	'BY'				=> 'By',
	//others
	'HAVE' => 'have',
	'HAD'=> 'had',
	'OWN_DESC' => 'Ownership action has been done',
	'GEAR' => 'Gear',
	'GEAR_BRAND' => 'Brand',
	'GEAR_NAME' => 'Product name'
));
