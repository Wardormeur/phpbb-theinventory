<?php
namespace wardormeur\theinventory\model;
use inflector\Inflector;
include_once 'abstract_model.php';

class gen_model extends abstract_model{


	private $name = '';
	private $local_id = null;
	private $product_id = null;
	private $brand_id = null;
	private $image_path = '';
  private $data;
	//TODO : fix this public thingy
	static public $p_fields = ['local_id','product_id'];
	static public $fields = ['name','brand_id','image_path'];//,'Data'];

    /**
     * Get the value of Name
     *
     * @return mixed
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param mixed name
     *
     * @return self
     */
    public function set_name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Local Id
     *
     * @return mixed
     */
    public function get_local_id()
    {
        return $this->local_id;
    }

    /**
     * Set the value of Local Id
     *
     * @param mixed local_id
     *
     * @return self
     */
    public function set_local_id($local_id)
    {
        $this->local_id = $local_id;

        return $this;
    }

    /**
     * Get the value of Product Id
     *
     * @return mixed
     */
    public function get_product_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of Product Id
     *
     * @param mixed product_id
     *
     * @return self
     */
    public function set_product_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of Brand
     *
     * @return mixed
     */
    public function get_brand_id()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of Brand
     *
     * @param mixed brand
     *
     * @return self
     */
    public function set_brand_id($brand)
    {
        $this->brand_id = $brand;

        return $this;
    }

    /**
     * Get the value of Image
     *
     * @return mixed
     */
    public function get_image_path()
    {
        return $this->image_path;
    }

    /**
     * Set the value of Image
     *
     * @param mixed image
     *
     * @return self
     */
    public function set_image_path($image)
    {
        $this->image_path = $image;

        return $this;
    }

    /**
     * Get the value of Data
     *
     * @return mixed
     */
    public function get_data()
    {
        return $this->data;
    }

    /**
     * Set the value of Data
     *
     * @param mixed data
     *
     * @return self
     */
    public function set_data($data)
    {
        $this->data = $data;

        return $this;
    }

}
