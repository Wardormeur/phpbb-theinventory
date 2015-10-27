<?php
namespace wardormeur\theinventory\mapper;

class user{


    public function __construct(
      \phpbb\config\config $config,
      \phpbb\db\driver\driver_interface $db,
      $table_prefix
    ){

      $this->config = $config;
      $this->db = $db;
  		$this->table_prefix = $table_prefix;
    }


    /**
     * By default, returns every genModels, else filter upon parameters
     * @return [type] [description]
     */
    public function get_by_session($session_id){

      $sql = "SELECT session_user_id FROM {$this->table_prefix}sessions WHERE session_id='$session_id'";
      $result = $this->db->sql_query($sql);
      $users = $this->db->sql_fetchrowset($result);
      return $users[0];

    }

}
