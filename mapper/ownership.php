<?php
namespace wardormeur\theinventory\mapper;

class ownership {



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
     * @return [type] [description]
     */
    public function select($filters){

      if (sizeof($filters) > 0){
        $sql_filters = $this->db->sql_build_array('SELECT', $filters);
      }

      $sql_array = array(
          'SELECT'    => 'product_id, user_id',

          'FROM'      => array(
              "{$this->table_prefix}ti_ownership"  => 'own',
          ),

          'LEFT_JOIN' => array(
              array(
                  'FROM'  => array("{$this->table_prefix}ti_product" => 'p'),
                  'ON'    => 'p.local_id = own.local_id',
              ),
          // 'WHERE'=> $sql_filters
          ));
        $sql = $this->db->sql_build_query('SELECT', $sql_array);

        // now run the query...
        $result = $this->db->sql_query($sql);
        return $this->db->sql_fetchrowset($result);
      }


      public function insert( $user_id,$product_id,$keyword){
        $sql = "INSERT INTO {$this->table_prefix}ti_ownership(user_id,local_id,status) VALUES($user_id,$product_id,'$keyword')";
        $this->db->sql_query($sql);
        return (bool) $this->db->sql_affectedrows();

      }

      public function update( $user_id,$product_id, $keyword){

        $sql = "UPDATE {$this->table_prefix}ti_ownership(status) VALUES($keyword)
          WHERE user_id = $id AND product_id = $product_id";
          $this->db->sql_query($sql);
          return (bool) $this->db->sql_affectedrows();

      }



      public function delete($userid,$product_id){
        $sql = "DELETE {$this->table_prefix}ti_ownership WHERE user_id = $id AND product_id = $product_id";
        $this->db->sql_query($sql);
        return (bool) $this->db->sql_affectedrows();
      }


}
