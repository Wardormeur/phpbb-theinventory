<?php

namespace wardormeur\theinventory\model;
include_once 'abstract_model.php';

class parent_model extends abstract_model{
  private $name = '';
  private $brand_id = null;
  private $local_id = null;
  private $image_path = '';
  private $description = '';
  private $url = '';
  private $data;

  public static $fields = ['name','image_path','description','url'];//,'Data'];
  public static $p_fields	= ['local_id','brand_id'];

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
     * Get the value of Brand Id
     *
     * @return mixed
     */
    public function get_brand_id()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of Brand Id
     *
     * @param mixed brand_id
     *
     * @return self
     */
    public function set_brand_id($brand_id)
    {
        $this->brand_id = $brand_id;

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
     * Get the value of Description
     *
     * @return mixed
     */
    public function get_description()
    {
        return $this->description;
    }

    /**
     * Set the value of Description
     *
     * @param mixed description
     *
     * @return self
     */
    public function set_description($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of Url
     *
     * @return mixed
     */
    public function get_url()
    {
        return $this->url;
    }

    /**
     * Set the value of Url
     *
     * @param mixed url
     *
     * @return self
     */
    public function set_url($url)
    {
        $this->url = $url;

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
