<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Front_model extends CI_Model {

    private $Table;
    private $TableSlides;
    private $TableBrands;
    private $TablePages;

    public function __construct() {
        parent::__construct();
        $this->Table = "ws_services";
        $this->TableSlides = "ws_slides";
        $this->TableBrands = "ws_products_brands";
        $this->TablePdtCategories = "ws_products_categories";
        $this->TablePages = "ws_pages";
    }

    public function readServices(array $data, $select = null, array $order_by = null) {
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

//  READ SLIDES
    public function readSlides($where) {
        return $this->db->get_where($this->TableSlides, $where)->result_array();
    }

    public function readBrands(array $data) {
        return $this->db->get_where($this->TableBrands, $data)->result_array();
    }

    public function readAllServices($limit, $start, array $where = null) {
        $this->db->limit($limit, $start);
        $this->db->select("*")->from($this->Table);

        if (!empty($where)):
            foreach ($where as $key => $value):
                $this->db->where($key, $value);
            endforeach;
        endif;

        $query = $this->db->get();

        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $data[] = $row;
            endforeach;

            return $data;
        endif;

        return false;
    }

    public function readAllSlides($where = null) {
        $this->db->select("*")->from($this->TableSlides);
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $data["slides"][] = (array) $row;
            endforeach;
            $data["num_slides"] = $query->num_rows();
            return $data;
        endif;

        return false;
    }

//  READ CATEGORIES PRODUCTS
    public function readPdtBrands($where = null) {
        return $this->db->get_where(DB_PDT_BRANDS, $where)->result_array();
    }

//  READ PRODUCTS BY
    public function readPdtByBrands($where = null) {
        return $this->db->get_where(DB_PDT, $where)->result_array();
    }

//  READ CATEGORIES PRODUCTS
    public function readPdtCategories($where = null) {
        return $this->db->get_where($this->TablePdtCategories, $where)->result_array();
    }

//  READ PAGES
    public function readPages($where) {
        return $this->db->get_where($this->TablePages, $where)->result_array();
    }

//  READ PRODUCTS BY CATEGORIES
    public function readPdtByCategories($where = null) {
        return $this->db->get_where(DB_PDT, $where)->result_array();
    }

//  READ PRODUCT
    public function readProduct($pdt_name, $pdt_status = null) {
        $where = [
            "pdt_name" => $pdt_name,
        ];
        if (!empty($pdt_status)):
            $where["pdt_status"] = $pdt_status;
        endif;
        return $this->db->get_where(DB_PDT, $where)->result_array();
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
