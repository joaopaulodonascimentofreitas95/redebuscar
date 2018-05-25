<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    private $Data = array();
    private $getUrl;
    private $SeoPach;

    public function __construct() {
        parent::__construct();
        $this->load->model("Front_model", "modelfrontend");
        $this->load->model("Seo_model", "modelseo");

        $this->getUrl = uri_string();
        $setURL = (empty($this->getUrl) ? "index" : $this->getUrl );
        $this->SeoPach = $setURL;
        $this->modelseo->seo($this->SeoPach);


        $this->Data["brands"] = $this->modelfrontend->readBrands(["brand_title !=" => null]);
        $this->Data["menu_categories"] = $this->modelfrontend->readPdtCategories(["cat_title !=" => null, "cat_parent" => null]);
        $this->Data["menu_brands"] = $this->modelfrontend->readPdtBrands(["brand_title !=" => null]);
    }

    public function index() {
        $SEO = $this->getSeo();

        $this->Data["slides"] = $this->modelfrontend->readAllSlides("slide_status = 1 AND slide_start <= NOW() AND (slide_end >= NOW() OR slide_end IS NULL) ORDER BY slide_date DESC");
        $this->Data["services"] = $this->modelfrontend->readServices(["service_title !=" => null]);
        $this->Data["pdt_categories"] = $this->modelfrontend->readPdtCategories(["cat_title !=" => null, "cat_parent !=" => null]);

        $this->load->view("frontend/inc/header", $SEO);
        $this->load->view("frontend/inc/css/css");
        $this->load->view("frontend/inc/navbar", $this->Data);
        $this->load->view("frontend/home");
        $this->load->view("frontend/inc/brand_address");
        $this->load->view("frontend/inc/contact");
        $this->load->view("frontend/inc/footer");
        $this->load->view("frontend/inc/js/js");
    }
    
    
    public function servicos() {
        $SEO = $this->getSeo();
        $this->Data["services"] = $this->modelfrontend->readServices(["service_title !=" => null]);
        
        $this->load->view("frontend/inc/header", $SEO);
        $this->load->view("frontend/inc/css/css");
        $this->load->view("frontend/inc/navbar", $this->Data);
        $this->load->view("frontend/services");
        $this->load->view("frontend/inc/brand_address");
        $this->load->view("frontend/inc/contact");
        $this->load->view("frontend/inc/footer");
        $this->load->view("frontend/inc/js/js");
    }

    public function page($page_name) {
        $this->Data["page"] = $this->modelfrontend->readPages(["page_name" => $page_name, "page_status" => 1]);
        if (empty($this->Data["page"])):
            redirect("404");
        endif;
        $SEO = $this->getSeo();
        $this->load->view("frontend/inc/header", $SEO);
        $this->load->view("frontend/inc/css/css");
        $this->load->view("frontend/inc/navbar", $this->Data);
        $this->load->view("frontend/page");
        $this->load->view("frontend/inc/brand_address");
        $this->load->view("frontend/inc/contact");
        $this->load->view("frontend/inc/footer");
        $this->load->view("frontend/inc/js/js");
    }

    public function marca($brand_name) {

        $this->Data["pdtbrands"] = $this->modelfrontend->readPdtBrands(["brand_title !=" => null]);
        $this->Data["pdtcategories"] = $this->modelfrontend->readPdtCategories(["cat_title !=" => null]);
        $this->Data["pdtbrand"] = $this->modelfrontend->readPdtBrands(["brand_name" => $brand_name])[0];
        if (empty($this->Data["pdtbrand"])):
            redirect("404");
        endif;
        $SEO = $this->getSeo();


        $Where = "pdt_brand = {$this->Data["pdtbrand"]["brand_id"]} AND (pdt_inventory >= 1 OR pdt_inventory IS NULL) AND (pdt_status = 1) ORDER BY pdt_title ASC";
        $this->Data["products"] = $this->modelfrontend->readPdtByBrands($Where);

        $this->load->view("frontend/inc/header", $SEO);
        $this->load->view("frontend/inc/css/css");
        $this->load->view("frontend/inc/navbar", $this->Data);
        $this->load->view("frontend/brand");
        $this->load->view("frontend/inc/brand_address");
        $this->load->view("frontend/inc/contact");
        $this->load->view("frontend/inc/footer");
        $this->load->view("frontend/inc/js/js");
    }

    public function produtos($cat_name) {

        $this->Data["pdtcategories"] = $this->modelfrontend->readPdtCategories(["cat_title !=" => null]);
        $this->Data["pdtbrands"] = $this->modelfrontend->readPdtBrands(["brand_title !=" => null]);
        $this->Data["pdtcategory"] = $this->modelfrontend->readPdtCategories(["cat_name" => $cat_name])[0];

        if (empty($this->Data["pdtcategory"])):
            redirect("404");
        endif;
        $SEO = $this->getSeo();

        if ($this->Data["pdtcategory"]["cat_parent"]):
            $readDepartament = $this->modelfrontend->readPdtCategories(["cat_id" => $this->Data["pdtcategory"]["cat_parent"]], "cat_title, cat_name");
            $this->Data["departament"] = "<a title='{$readDepartament[0]['cat_title']} em " . SITE_NAME . "' href='" . site_url("produtos/{$readDepartament[0]['cat_name']}") . "'>{$readDepartament[0]['cat_title']}</a>";
        endif;

        $WHERE = "(pdt_category = {$this->Data["pdtcategory"]["cat_id"]} OR pdt_subcategory = {$this->Data["pdtcategory"]["cat_id"]}) AND (pdt_inventory >= 1 OR pdt_inventory IS NULL) AND (pdt_status = 1) ORDER BY pdt_title ASC";
        $this->Data["products"] = $this->modelfrontend->readPdtByCategories($WHERE);

        $this->load->view("frontend/inc/header", $SEO);
        $this->load->view("frontend/inc/css/css");
        $this->load->view("frontend/inc/navbar", $this->Data);
        $this->load->view("frontend/products");
        $this->load->view("frontend/inc/brand_address");
        $this->load->view("frontend/inc/contact");
        $this->load->view("frontend/inc/footer");
        $this->load->view("frontend/inc/js/js");
    }

    public function produto($pdt_name) {
        $readPdt = $this->modelfrontend->readProduct($pdt_name, 1)[0];
        if (empty($readPdt)):
            redirect("404");
        else:
            $SEO = $this->getSeo();
            $this->Data["pdtcategories"] = $this->modelfrontend->readPdtCategories(["cat_title !=" => null]);        
            //  Atualiza Número de Views do Produto
            $PdtViewUpdate = ['pdt_views' => $readPdt["pdt_views"] + 1, 'pdt_lastview' => date('Y-m-d H:i:s')];
            $this->modelfrontend->ExeUpdate(DB_PDT, $PdtViewUpdate, ["pdt_id" => $readPdt["pdt_id"]]);


            $this->Data["product"] = $readPdt;
            $this->load->view("frontend/inc/header", $SEO);
            $this->load->view("frontend/inc/css/css");
            $this->load->view("frontend/inc/navbar", $this->Data);
            $this->load->view("frontend/product");
            $this->load->view("frontend/inc/brand_address");
            $this->load->view("frontend/inc/contact");
            $this->load->view("frontend/inc/footer");
            $this->load->view("frontend/inc/js/js");
        endif;
    }
    

    /*
     * Responsável por retornar array com metadados seo
     */
    private function getSeo() {
        $metadata = [
            "schema" => $this->modelseo->getSchema(),
            "author" => AGENCY_CONTACT . " <" . AGENCY_EMAIL . " - " . AGENCY_NAME . ">",
            "title" => $this->modelseo->getTitle(),
            "description" => $this->modelseo->getDescription(),
            "robots" => "index, follow",
            "base" => site_url(),
            "canonical" => site_url($this->getUrl),
            "image" => $this->modelseo->getImage(),
            "url" => site_url($this->getUrl),
        ];
        return $metadata;
    }

}
