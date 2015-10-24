<?php
namespace wardormeur\theinventory\mapper;

class gen_model{


    public function __construct(
      \phpbb\config\config $config,
      \phpbb\db\driver\driver_interface $db,
      \wardormeur\theinventory\mapper\property $prop_mapper,
      $table_prefix
    ){

      $this->config = $config;
      $this->db = $db;
  		$this->table_prefix = $table_prefix;
      $this->prop_mapper = $prop_mapper;
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

      //Take care of components
      foreach($productz as &$product){
        //TODO : support more filtering for recovery
        $comp_filters['parent_id'] = $product['local_id'];
        $rows = $this->prop_mapper->select($comp_filters);
        foreach($rows as $property){
          if($property['parent_id'] == $product['local_id'])
            $product['properties'][] = $property;
        }
      }

      return $productz;
    }

    public function insert($model){
      //local_id is auto et product-Id is remote, we dont know either of them atm.
      $fields = $model::get_fields(false);
      $to_insert = $model->get_values($fields);
      $sql = "INSERT INTO {$this->table_prefix}ti_product {$this->db->sql_build_array('INSERT', $to_insert)}";
      $this->db->sql_query($sql);

      //Take care of components
      foreach($model->get_dynamic_values() as $property){
        $this->prop_mapper->insert($property);
      }
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
      $sql = "UPDATE {$this->table_prefix}ti_product SET {$this->db->sql_build_array('UPDATE', $to_update)} WHERE local_id={$model->get_local_id()}";

      //Take care of components
      //array_diff_key ?
      $modelz = $this->select(['local_id'=>$model->get_local_id()]);
      $prev_model = $modelz[0];
      $existings_keys =   array_map(function($e){
          return $e['local_id'];
        },
        $prev_model['properties'] //TODO:fix design, i shouldn't hardcode this here : mvoe properties handling to the service?
      );

      $fieldz = $model->get_dynamic_values($model->get_d_fields());
      foreach($fieldz as $fields){
        $deleted_keys = array_diff($existings_keys,  array_map(function($e){
            return $e->get_local_id();
          },
          $fields
        ));
        var_dump($deleted_keys);
        foreach($fields as $property){
          $local_id = $property->get_local_id();
          if($local_id != null){
              $this->prop_mapper->update($property);
          }else{ //new prop
            $this->prop_mapper->insert($property);
          }
        }
        foreach ($deleted_keys as $deletedProp) {
          $this->prop_mapper->delete($deletedProp);
        }
      }

      $this->db->sql_query($sql);
      return (bool) $this->db->sql_affectedrows();

    }


}
