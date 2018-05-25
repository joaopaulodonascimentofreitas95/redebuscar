<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

    private $TablePdt;
    private $TableCategories;
    private $TableBrands;

    public function __construct() {
        parent::__construct();
        $this->TablePdt = "ws_products";
        $this->TableCategories = "ws_products_categories";
        $this->TableBrands = "ws_products_brands";
    }

    #####   DEFAULT

    public function checkPdtCategory(array $data, $select = null) {
        if (!empty($select)):
            $this->db->select("{$select}");
        endif;

        $this->db->from($this->TableCategories);
        foreach ($data as $key => $value):
            $this->db->where($key, $value);
        endforeach;
        return $this->db->get()->result_array();
    }

    #####   PRODUCTS
    //  Products
    //  Create

    public function createPdts(array $data) {
        $this->db->insert($this->TablePdt, $data);
        return $this->db->insert_id();
    }

    //  Read

    public function readPdt(array $data, $select = null, array $order_by = null) {
        if (!empty($select)):
            $this->db->select("{$select}");
        endif;
        $this->db->from($this->TablePdt);

        foreach ($data as $where => $params):
            if ($where == "where"):
                foreach ($params as $a => $b):
                    $this->db->where($a, $b);
                endforeach;
            endif;

            if ($where == "orwhere"):
                foreach ($params as $a => $b):
                    $this->db->or_where($a, $b);
                endforeach;
            endif;
        endforeach;

        if (!empty($order_by)):
            foreach ($order_by as $key => $value):
                $this->db->order_by($key, $value);
            endforeach;
        endif;
        return $this->db->get()->result_array();
    }

    public function readPdts(array $data, $select = null, array $order_by = null) {
        if (!empty($select)):
            $this->db->select("{$select}");
        endif;

        $this->db->from($this->TablePdt);
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

    //  Update
    public function updatePdt(array $where, array $data) {
        $this->db->where($where);
        return $this->db->update($this->TablePdt, $data);
    }

    //  Delete
    #####   CATEGORIES
    //  Categories Products
    public function createPdtCategories(array $data) {
        $this->db->insert($this->TableCategories, $data);
        return $this->db->insert_id();
    }

    public function readPdtCategories(array $data, $select = null, array $order_by = null) {
        if (!empty($select)):
            $this->db->select("{$select}");
        endif;

        $this->db->from($this->TableCategories);
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

    public function updatePdtCategories(array $where, array $data) {
        $this->db->where($where);
        return $this->db->update($this->TableCategories, $data);
    }

    public function deletePdtCategories($cat_id) {
        $this->db->where("md5(cat_id)", $cat_id);
        return $this->db->delete($this->TableCategories);
    }

    public function allCats(array $data) {
        return $this->db->get_where($this->TableCategories, $data);
    }

    public function getAllCats($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->select("*")
                ->from($this->TableCategories)
                ->get();

        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $data[] = $row;
            endforeach;
            return $data;
        endif;

        return false;
    }

    /**
     * 
     * @return ARRAY categories with subcategories
     */
    public function getPdtCategories() {
        $this->db->from($this->TableCategories);
        $this->db->where("cat_parent", null);
        $Cats = $this->db->get()->result_array();

        $ReturnCats = array();
        $Subcats = array();
        if (!empty($Cats)):
            foreach ($Cats as $Cat):
                $Cat["cat_pdt"] = $this->countPdt($Cat["cat_id"]);
                $Cat["subcats"] = $this->readPdtSubcategories($Cat["cat_id"]);
                $ReturnCats[] = $Cat;
            endforeach;
        endif;
        return $ReturnCats;
    }

    private function readPdtSubcategories($cat_id) {
        $this->db->from($this->TableCategories);
        $this->db->where("cat_parent", $cat_id);
        $Cats = $this->db->get()->result_array();

        $ReturnCats = array();
        $Subcats = array();
        if (!empty($Cats)):
            foreach ($Cats as $Cat):
                $Cat["cat_pdt"] = $this->countPdt($Cat["cat_id"]);
                $ReturnCats[] = $Cat;
            endforeach;
        endif;

        return $ReturnCats;
    }

    private function countPdt($cat_id) {
        $query = $this->db->select("count(pdt_id) as total")
                        ->from($this->TablePdt)
                        ->where("pdt_category", $cat_id)
                        ->get()->result()[0];
        $quantity = (!empty($query->total) ? $query->total : 0);
        return $quantity;
    }

    #####   BRANDS

    public function createPdtBrands(array $data) {
        $this->db->insert($this->TableBrands, $data);
        return $this->db->insert_id();
    }

    public function readPdtBrands(array $data, $select = null, array $order_by = null) {
        if (!empty($select)):
            $this->db->select("{$select}");
        endif;

        $this->db->from($this->TableBrands);
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

    public function updatePdtBrands(array $where, array $data) {
        $this->db->where($where);
        return $this->db->update($this->TableBrands, $data);
    }

    public function deletePdtBrands($brand_id) {
        $this->db->where("md5(brand_id)", $brand_id);
        return $this->db->delete($this->TableBrands);
    }

    public function readBrands(array $data) {
        return $this->db->get_where($this->TableBrands, $data);
    }

    public function readAllBrands($limit, $start, array $where = null) {
        $this->db->limit($limit, $start);
        $this->db->select("*")->from($this->TableBrands);

        if (!empty($where)):
            foreach ($where as $key => $value):
                $this->db->where($key, $value);
            endforeach;
        endif;

        $query = $this->db->get();

        if ($query->num_rows() > 0):
            foreach ($query->result() as $row):
                $qtd = $this->db->select("count(pdt_id) as total")->from($this->TablePdt)->where("pdt_brand", $row->brand_id)->get()->result()[0];
                $row->pdts = (!empty($qtd->total) ? $qtd->total : 0);
                $data[] = $row;
            endforeach;

            return $data;
        endif;

        return false;
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
