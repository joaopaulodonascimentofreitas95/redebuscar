<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Slides_model extends CI_Model {

    private $Table;

    public function __construct() {
        parent::__construct();
        $this->Table = "ws_slides";
    }

    #####   BRANDS

    public function createSlides(array $data) {
        $this->db->insert($this->Table, $data);
        return $this->db->insert_id();
    }

    public function readSlides(array $data, $select = null, array $order_by = null) {
        if (!empty($select)):
            $this->db->select("{$select}");
        endif;

        $this->db->from($this->Table);
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

    public function updateSlides(array $where, array $data) {
        $this->db->where($where);
        return $this->db->update($this->Table, $data);
    }

    public function deleteSlides($slide_id) {
        $this->db->where("md5(slide_id)", $slide_id);
        return $this->db->delete($this->Table);
    }

    public function readAllSlides($limit, $start, array $where = null) {
        $this->db->limit($limit, $start);
        $this->db->select("*")->from($this->Table);

        if (!empty($where)):
            foreach ($where as $key => $value):
                $this->db->where($key, $value);
            endforeach;
        endif;

        $query = $this->db->get();

        if ($query->num_rows() > 0):
            foreach ($query->result_array() as $row):                
                $data[] = $row;
            endforeach;

            return $data;
        endif;

        return false;
    }
}
