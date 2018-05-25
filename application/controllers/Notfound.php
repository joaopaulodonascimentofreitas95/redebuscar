<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notfound extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("Front_model", "modelfrontend");
        $this->load->model("Seo_model", "modelseo");

//  SEO
        $this->getUrl = uri_string();
        $setURL = (empty($this->getUrl) ? "index" : $this->getUrl );
        $this->SeoPach = $setURL;
        $this->modelseo->seo($this->SeoPach);


        $this->Data["brands"] = $this->modelfrontend->readBrands(["brand_title !=" => null]);
        $this->Data["menu_categories"] = $this->modelfrontend->readPdtCategories(["cat_title !=" => null, "cat_parent" => null]);
    }

    public function index() {
        $SEO = $this->getSeo();
        $this->Data["slides"] = $this->modelfrontend->readAllSlides("slide_status = 1 AND slide_start <= NOW() AND (slide_end >= NOW() OR slide_end IS NULL) ORDER BY slide_date DESC");
        $this->Data["services"] = $this->modelfrontend->readServices(["service_title !=" => null]);
        $this->Data["pdt_categories"] = $this->modelfrontend->readPdtCategories(["cat_title !=" => null, "cat_parent !=" => null]);

        $this->load->view("front/inc/header", $SEO);
        $this->load->view("front/inc/css/css");
        $this->load->view("front/inc/navbar", $this->Data);
        $this->load->view("front/404");
        $this->load->view("front/inc/brand_address");
        $this->load->view("front/inc/contact");
        $this->load->view("front/inc/footer");
        $this->load->view("front/inc/js/js");
    }

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
