<?php
namespace wardormeur\theinventory\mapper;

class gen_model{


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
    public function select($filters){
      $sql_filters = null;
      if(sizeof($filters)>0){
        $sql_filters = $this->db->sql_build_array('SELECT', $filters);
      }
      $sql = "SELECT name,local_id,product_id, brand_id, image_path FROM {$this->table_prefix}ti_product ".($sql_filters?'WHERE '.$sql_filters:'');
      $result = $this->db->sql_query($sql);
      $productz = $this->db->sql_fetchrowset($result);
      return $productz;
    }

    public function insert($model){
      //local_id is auto et product-Id is remote, we dont know either of them atm.
      $fields = $model::get_fields(false);
      $to_insert = $model->get_values($fields);
      $sql = "INSERT INTO {$this->table_prefix}ti_product {$this->db->sql_build_array('INSERT', $to_insert)}";
      $this->db->sql_query($sql);
  		return (bool) $this->db->sql_affectedrows();
      //select missing fields ?
    }

    public function delete($id){
      $sql = "DELETE FROM {$this->table_prefix}ti_product WHERE local_id=$id";
      $this->db->sql_query($sql);
      return (bool) $this->db->sql_affectedrows();
    }

    public function update($model){
      //local_id is auto et product-Id is remote, we dont know either of them atm.
      $fields = $model::get_fields(false);
      $to_update = $model->get_values($fields);
      $sql = "UPDATE {$this->table_prefix}ti_product SET {$this->db->sql_build_array('UPDATE', $to_update)} WHERE local_id={$model->get_name()}";
      $this->db->sql_query($sql);
      return (bool) $this->db->sql_affectedrows();

    }


}
