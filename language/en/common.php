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
	'ACP_TI_SETTING_SAVED'	=> 'Settings have been saved successfully!',
	'PRODUCT_PAGE'	=> 'Product page',
	'NEW_PRODUCT'		=> 'Add new product',
	'BY'				=> 'By',
	'PRODUCT_SEARCH'	=>	'Search a product',
	'PRODUCT_NAME'	=>	'Product name',
	'LINK_TO'			=>	'Use online image',
	'UPLOAD_FROM'	=> 'Upload local image',

	'BRAND_NAME'	=>	'Brand name',
	'NEW_BRAND'		=> 'Add new brand',
	'BRAND_DESCRIPTION' => 'Description',
	'BRAND_URL'	=> 'Brands\'s website'

));
