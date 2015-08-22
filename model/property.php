<?php

namespace wardormeur\theinventory\model;

/**
 * Simplified version of tI's property, not handling properly the classification of the property itself
 */
class property{

  private $label;
  private $value;
  private $type;
  private $property_id;


  public function __construct($values){
			foreach($values as $name=>$value){
				if(in_array($this->get_p_fields(),$name) && is_callable($this->set_{$name})){
					$this->set_{$name}($value);
				}
			}
	}

  public function get_values($source){
		$values = [];
		foreach($source as $name){
			if(in_array($this->get_p_fields(),$name) && is_callable($this->get_{$name})){
				$values[$name] = $this->get_{$name}($value);
			}
		}
		return $values;
	}

  public static function get_fields(){
		return ['label','value','type'];
	}


	public static function get_p_fields(){
		return array_merge($this->get_fields(),['property_id']);
	}

    /**
     * Get the value of Simplified version of tI's property, not handling properly the classification of the property itself
     *
     * @return mixed
     */
    public function getLabel()
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
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the value of Value
     *
     * @return mixed
     */
    public function getValue()
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
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of Type
     *
     * @return mixed
     */
    public function getType()
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
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

}


 ?>
