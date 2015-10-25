<?php
namespace wardormeur\theinventory\mapper;

class parent_model{


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
      $authorised = ['name','brand_id','local_id'];

      $sql_to_filter = [];
      if(sizeof($filters)>0){
        foreach($filters as $filter=>$value){
          if( in_array($filter,$authorised)){
            $sql_to_filter[$filter] = $value;
          }
        }
        $sql_filters = $this->db->sql_build_array('SELECT', $sql_to_filter);
      }
      $sql = "SELECT name, brand_id, local_id, description, image_path, url FROM {$this->table_prefix}ti_brand ".($sql_filters?'WHERE '.$sql_filters:'');
      $result = $this->db->sql_query($sql);
      $brandz = $this->db->sql_fetchrowset($result);
      return $brandz;
    }

    public function insert( $model){
      //local_id is auto et product-Id is remote, we dont know either of them atm.
      $fields = $model::get_fields(false);
      $to_insert = $model->get_values($fields);
      $sql = "INSERT INTO {$this->table_prefix}ti_brand {$this->db->sql_build_array('INSERT', $to_insert)}";
      $this->db->sql_query($sql);
      return (bool) $this->db->sql_affectedrows();

      //select missing fields ?
    }

    public function update( $model){
      //local_id is auto et product-Id is remote, we dont know either of them atm.
      $fields = $model::get_fields(false);
      $to_update = $model->get_values($fields);
			$sql = "UPDATE {$this->table_prefix}ti_brand  SET {$this->db->sql_build_array('UPDATE', $to_update)}  WHERE local_id={$model->get_local_id()}";
			$this->db->sql_query($sql);
      return (bool) $this->db->sql_affectedrows();
    }

    public function delete($id){
      $sql = "DELETE FROM {$this->table_prefix}ti_brand WHERE local_id=$id";
      $this->db->sql_query($sql);
      return (bool) $this->db->sql_affectedrows();
    }


}
