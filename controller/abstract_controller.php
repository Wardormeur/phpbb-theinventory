<?php

namespace wardormeur\theinventory\controller;


class abstract_controller{

  private $expected;

  public function __construct(
    \phpbb\config\config $config,
    \phpbb\controller\helper $helper,
    \phpbb\template\template $template,
    \phpbb\user $user,
    \phpbb\request\request $request,
    $phpEx,
    $phpbb_root_path,
    \wardormeur\theinventory\service\search $search,
		\wardormeur\theinventory\service\gen_model $gen_model,
		\wardormeur\theinventory\service\parent_model $parent_model,
		\wardormeur\theinventory\service\ownership $ownership,
    \wardormeur\theinventory\mapper\user $extuser //shouldnt expose this one here, but w/e
  ){
    $this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->request = $request;
    $this->search = $search;
    $this->phpEx = $phpEx;
    $this->phpbb_root_path = $phpbb_root_path;
		$this->gen_model = $gen_model;
		$this->parent_model = $parent_model;
    $this->ownership = $ownership;
    $this->extuser = $extuser;
  }


  public function getSingleValues(){
    $values = [];
    foreach($this->request->variable_names() as $name){
      $value =  $this->request->variable($name, '');
      if($this->isExpected($name) && !empty($value) ){
        $values[$name] = $value;
      }
    }
    return $values;
  }

  public function getArrayValues(){
    $values = [];
    foreach($this->request->variable_names() as $name){
      $value =  $this->request->variable($name, array(''));
      if($this->isExpected($name) && !empty($value) ){
        $values[$name] = $value;
      }
    }
    return $values;
  }

  private function isExpected($variable){
    $valid = false;
    if(in_array($variable, $this->expected)){
      $valid = true;
    }
    return $valid;
  }



    /**
     * Set the value of Expected
     *
     * @param mixed expected
     *
     * @return self
     */
    public function setExpected($expected)
    {
        $this->expected = $expected;

        return $this;
    }

}

 ?>
