<?php

namespace wardormeur\theinventory\model;

/**
 * Simplified version of tI's property, not handling properly the classification of the property itself
 */
class property extends abstract_model{

  private $label;
  private $value;
  private $type = "string";
  private $local_id;
  private $unit;
  private $property_id;
  private $parent_id;

  //ids
	static public $p_fields = ['property_id','local_id'];
	//single-value fields
	static public $fields = ['label','value','type','parent_id','unit'];
	//dynamic fields
  static public $d_fields = [];

  static private $types = ['string','int','date'];

    /**
     * Get the value of Simplified version of tI's property, not handling properly the classification of the property itself
     *
     * @return mixed
     */
    public function get_label()
    {
        return $this->label;
    }

    /**
     * Set the value of Simplified version of tI's property, not handling properly the classification of the property itself
     *
     * @param mixed label
     *
     * @return self
     */
    public function set_label($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the value of Value
     *
     * @return mixed
     */
    public function get_value()
    {
        return $this->value;
    }

    /**
     * Set the value of Value
     *
     * @param mixed value
     *
     * @return self
     */
    public function set_value($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of Type
     *
     * @return mixed
     */
    public function get_type()
    {
        return $this->type;
    }

    /**
     * Set the value of Type
     *
     * @param mixed type
     *
     * @return self
     */
    public function set_type($type)
    {
        $this->type = $type;

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
    public function get_parent_id()
    {
        return $this->parent_id;
    }

    /**
     * Set the value of Product Id
     *
     * @param mixed product_id
     *
     * @return self
     */
    public function set_parent_id($parent_id)
    {
        $this->parent_id = $parent_id;

        return $this;
    }


    /**
     * Get the value of unit
     *
     * @return mixed
     */
    public function get_unit()
    {
        return $this->unit;
    }

    /**
     * Set the value of unit
     *
     * @param mixed product_id
     *
     * @return self
     */
    public function set_unit($unit)
    {
        $this->unit = $unit;

        return $this;
    }


    /**
     * Get the value of unit
     *
     * @return mixed
     */
    public function get_property_id()
    {
        return $this->property_id;
    }

    /**
     * Set the value of unit
     *
     * @param mixed product_id
     *
     * @return self
     */
    public function set_property_id($property_id)
    {
        $this->property_id = $property_id;

        return $this;
    }



}


 ?>
