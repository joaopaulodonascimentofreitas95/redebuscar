<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listusers() {
        $this->db->from('ws_users');
        return $this->db->get()->result();
    }

    public function checkAdmin(array $data) {
        $this->db->from('ws_users');
        foreach ($data as $key => $value):
            $this->db->where($key, $value);
        endforeach;
        return $this->db->get()->result_array();
    }

    public function addCategory(array $data) {
        return $this->db->insert("ws_categories", $data);
    }

    public function checkAdminLevel($level) {
        $this->db->from('ws_users');
        $this->db->where("user_level >= {$level}");
        return $this->db->get()->result();
    }

    public function exe_create($table, array $data) {
        var_dump($table, $data);
        return $this->db->insert($table, $data);
    }

    #users

    public function allUsers(array $data) {
        return $this->db->get_where('ws_users', $data);
    }

    public function getAllUsers($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->select("*")
                ->from("ws_users")
                ->get();

        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $data[] = $row;
            endforeach;
            return $data;
        endif;

        return false;
    }

    //  USERS
    public function addUser(array $data) {
        //return $this->db->insert("ws_users", $data); return boolean result
        $this->db->insert("ws_users", $data);
        return $this->db->insert_id();
    }

    public function checkUser(array $data, $select = null) {
        if (!empty($select)):
            $this->db->select("{$select}");
        endif;

        $this->db->from('ws_users');
        foreach ($data as $key => $value):
            $this->db->where($key, $value);
        endforeach;
        return $this->db->get()->result_array();
    }

    public function editUser($user_id, array $data) {
        $where = ["md5(user_id)" => $user_id];
        $this->db->where($where);
        return $this->db->update("ws_users", $data);
    }

    public function getUserAddress(array $data, array $order_by = null) {
       
        $this->db->from('ws_users_address');
        foreach ($data as $key => $value):
            $this->db->where($key, $value);
        endforeach;

        if (!empty($order_by)):
            foreach ($order_by as $key => $value):
                $this->db->order_by($key, $value);
            endforeach;

        endif;
        return $this->db->get()->result_array();
    }
    
    
    //  ADDRESS
    public function addAddress(array $data) {
        $this->db->insert("ws_users_address", $data);
        return $this->db->insert_id();
    }

    public function checkAddress(array $data, $select = null) {
        if (!empty($select)):
            $this->db->select("{$select}");
        endif;

        $this->db->from('ws_users_address');
        foreach ($data as $key => $value):
            $this->db->where($key, $value);
        endforeach;
        return $this->db->get()->result_array();
    }
    
    public function editAddress($addr_id, array $data) {
        $where = ["md5(addr_id)" => $addr_id];
        $this->db->where($where);
        return $this->db->update("ws_users_address", $data);
    }
    
    public function addrRemove($addr_id){
        $this->db->where("addr_id", $addr_id);
        return $this->db->delete("ws_users_address");
    }
    
    
    //    GENERIC CRUD
    public function ExeCreate($Table, array $Data) {
        $this->db->insert($Table, $Data);
        return $this->db->insert_id();
    }

    public function ExeRead($Table, array $Where = null, $Select = null, $Order = null, $Limit = null, $Offset = null) {
        if (!empty($Limit) && empty($Offset)):
            $this->db->limit($Limit);
        endif;

        if (!empty($Limit) && !empty($Offset)):
            $this->db->limit($Limit, $Offset);
        endif;

        if (!empty($Select)):
            $this->db->select($Select);
        endif;

        if (!empty($Order)):
            foreach ($Order as $key => $value):
                $this->db->order_by($key, $value);
            endforeach;
        endif;
        return $this->db->get_where($Table, $Where)->result_array();
    }

    public function ExeUpdate($Table, array $Data, array $Where) {
        $this->db->where($Where);
        return $this->db->update($Table, $Data);
    }

    public function ExeDelete($Table, array $Where) {
        $this->db->where($Where);
        return $this->db->delete($Table);
    }


}
