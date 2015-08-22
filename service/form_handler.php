<?php

class form_handler{

private $data;
private $properties;

  private function __construct($form){
    $data = $form;
    toProperties();
  }

  private function toProperties(){
      foreach ($this->data as $name => $answer) {
        $this->properties[] = new Property($name,$answer->value, $answer->type);
      }
  }

  public function getProperties(){
    return $this->properties;
  }

  public function defineModel($form){


  }

}
