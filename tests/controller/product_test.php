<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2014 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace acme\demo\tests\controller;

class product_test extends \phpbb_test_case
{
	public function handle_data()
	{
		return array(
			array(200, 'demo_body.html'),
		);
	}

	/**
	 * @dataProvider handle_data
	 */
	public function test_show($status_code, $page_content)
	{
		$controller = new \wardormeur\theinventory\controller\product(
		new \phpbb\config\config(array()),
		new \acme\demo\tests\mock\controller_helper(),
		new \acme\demo\tests\mock\template(),
		new \acme\demo\tests\mock\user(),
		new \phpbb\request\request(),
		$phpEx,
		$phpbb_root_path,
		new \wardormeur\theinventory\service\search(),
		new \wardormeur\theinventory\service\gen_model(),
		new \wardormeur\theinventory\service\parent_model()
		);

		$response = $controller->handle('test');
		$this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $response);
		$this->assertEquals($status_code, $response->getStatusCode());
		$this->assertEquals($page_content, $response->getContent());
	}

	/*


	 */
	 public function test_edit(){

	 }

	 public function test_add(){

	 }

	 public function test_save(){

	 }

	 public function test_remove(){
		 
	 }
}
