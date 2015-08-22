<?php
namespace wardormeur\theinventory\mapper;

class property{



  public function __construct(
    \phpbb\config\config $config,
    \phpbb\db\driver\driver_interface $db,
    $table_prefix
  ){

    $this->config = $config;
    $this->db = $db;
    $this->table_prefix = $table_prefix;
  }


    public function select(){

    }

    public function insert(){

    }

    public function delete(){

    }

    public function update(){

    }


}
