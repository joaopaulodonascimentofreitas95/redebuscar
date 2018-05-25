<?php

/**
 * User: joaopaulo
 * Date: 11/12/17
 * Time: 16:13
 */
class Seo_model extends CI_Model {

    private $Pach;
    private $File;
    private $Link;
    private $Key;
    private $Schema;
    private $Title;
    private $Description;
    private $Image;
    private $Data;

    public function __construct() {
        parent::__construct();
    }

    public function seo($Pach) {
        $this->Pach = explode('/', strip_tags(trim($Pach)));
        $this->File = (!empty($this->Pach[0]) ? $this->Pach[0] : null);
        $this->Link = (!empty($this->Pach[1]) ? $this->Pach[1] : null);
        $this->Key = (!empty($this->Pach[2]) ? $this->Pach[2] : null);

        $this->setPach();
    }

    public function getSchema() {
        return $this->Schema;
    }

    public function getTitle() {
        return $this->Title;
    }

    public function getDescription() {
        return $this->Description;
    }

    public function getImage() {
        return $this->Image;
    }

    public function getData() {
        return $this->Data;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    private function setPach() {
        $Pages = array();
        $this->db->select("page_name");
        $this->db->from(DB_PAGES);
        $PageRead = $this->db->get()->result_array();
        if ($PageRead):
            foreach ($PageRead as $SinglePage):
                $Pages[] = $SinglePage['page_name'];
            endforeach;
        endif;

        if (in_array($this->File, $Pages)):
            //PÁGINAS 
            $this->db->select("page_title, page_subtitle, page_cover");
            $PageResult = $this->db->get_where(DB_PAGES, ["page_name" => $this->File])->result_array();
            if ($PageResult):
                $Page = $PageResult[0];
                $this->Schema = 'WebSite';
                $this->Title = $Page['page_title'] . " - " . SITE_NAME;
                $this->Description = $Page['page_subtitle'];
                $this->Image = (!empty($Page['page_cover']) ? base_url("assets/uploads/{$Page['page_cover']}") : base_url('assets/images/default.jpg'));
            else:
                $this->set404();
            endif;
        elseif ($this->File == 'index'):
            //INDEX
            $this->Schema = 'WebSite';
            $this->Title = SITE_NAME . " - " . SITE_SUBNAME;
            $this->Description = SITE_DESC;
            $this->Image = base_url("assets/images/default.jpg");
        elseif ($this->File == 'contato'):
            //CONTATO
            $this->Schema = 'WebSite';
            $this->Title = 'Fale com à ' . SITE_NAME . " - " . SITE_SUBNAME;
            $this->Description = SITE_DESC;
            $this->Image = base_url("assets/frontend/images/default.jpg");
        elseif ($this->File == 'servicos'):
            //CONTATO
            $this->Schema = 'WebSite';
            $this->Title = 'Serviços Especializados ' . SITE_NAME . " - " . SITE_SUBNAME;
            $this->Description = SITE_DESC;
            $this->Image = base_url("assets/images/default.jpg");
        elseif ($this->File == 'pesquisa'):
            //PESQUISA
            $this->Schema = 'WebSite';
            $this->Title = "Pesquisa por {$this->Link} em " . SITE_NAME;
            $this->Description = SITE_DESC;
            $this->Image = base_url('assets/images/default.jpg');

        elseif ($this->File == 'produto'):
            //PRODUTO
            $this->db->select("pdt_title, pdt_subtitle, pdt_cover");
            $this->db->from(DB_PDT);
            $this->db->where("pdt_name", $this->Link);
            $ReadPdt = $this->db->get()->result()[0];

            if ($ReadPdt):
                $Pdt = (array) $ReadPdt;
                $this->Schema = 'Product';
                $this->Title = $Pdt['pdt_title'] . " - " . SITE_NAME;
                $this->Description = $Pdt['pdt_subtitle'];
                $this->Image = base_url("assets/uploads/{$Pdt['pdt_cover']}");
            else:
                $this->set404();
            endif;
        elseif ($this->File == 'produtos'):
            //PRODUTOS
            $this->db->select("cat_title");
            $getResult = $this->db->get_where(DB_PDT_CATS, ["cat_name" => $this->Link])->result_array();
            if ($getResult):
                $Category = $getResult[0];
                $this->Schema = 'WebSite';
                $this->Title = $Category['cat_title'] . " - " . SITE_NAME;
                $this->Description = SITE_DESC;
                $this->Image = base_url('assets/images/default.jpg');
            else:
                $this->set404();
            endif;
        elseif ($this->File == 'marca'):
            //MARCAS
            $this->db->select("brand_title");
            $getResult = $this->db->get_where(DB_PDT_BRANDS, ["brand_name" => $this->Link])->result_array();
            if ($getResult):
                $Brand = $getResult[0];
                $this->Schema = 'WebSite';
                $this->Title = $Brand['brand_title'] . " - " . SITE_NAME;
                $this->Description = SITE_DESC;
                $this->Image = base_url('assets/images/default.jpg');
            else:
                $this->set404();
            endif;
        elseif ($this->File == 'empresa'):
            //EMPRESAS
            $this->db->select("page_title, page_name, page_subtitle, page_cover");
            $this->db->from(DB_PAGES);
            $this->db->where("page_name", $this->Link);
            $ReadPage = $this->db->get()->result()[0];

            if ($ReadPage):
                $Page = (array) $ReadPage;
                $this->Schema = 'WebSite';
                $this->Title = $Page['page_title'] . " - " . SITE_NAME;
                $this->Description = $Page["page_subtitle"];
                $this->Image = base_url("assets/uploads/{$Page["page_cover"]}");
            else:
                $this->set404();
            endif;
        else:
            //404
            $this->set404();
        endif;
    }

    private function set404() {
        $this->Schema = 'WebSite';
        $this->Title = "Oppsss, nada encontrado! - " . SITE_NAME;
        $this->Description = SITE_DESC;
        $this->Image = base_url('assets/images/default.jpg');
    }

}
