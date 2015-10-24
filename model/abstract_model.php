<?php
namespace wardormeur\theinventory\model;
use inflector\Inflector;

abstract class abstract_model {

  public function __construct($values){
			foreach($values as $name=>$value){
				if(
            in_array($name,$this->get_p_fields())
            // && is_callable('set'.$camel_name)
          ){
					call_user_func(array($this,'set_'.$name),$value);
				}else {

          if(  in_array($name,$this->get_d_fields())){
          // && is_callable('set'.$camel_name)){
            call_user_func(array($this,'set_'.$name),$value);

          }
        }
			}
	}

  public function get_values($source){
		$values = [];
		foreach($source as $name){
			if(in_array($name,$this->get_p_fields())
          // && is_callable('get'.$camel_name)
        ){
				$values[$name] = call_user_func(array($this,'get_'.$name));
			}
		}
		return $values;
	}

	public function get_dynamic_values($source){
		$values = [];
		foreach($source as $name){
			if(in_array($name,$this->get_d_fields())
          // && is_callable('get'.$camel_name)
        ){
				$values[$name] = call_user_func(array($this,'get_'.$name));
			}
		}
		return $values;
	}

	public static function get_fields(){
		return static::$fields;
	}


	public static function get_p_fields(){
		return array_merge(self::get_fields(), static::$p_fields);
	}

	public static function get_d_fields(){
		return static::$d_fields;
	}

}
