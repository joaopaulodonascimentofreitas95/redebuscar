<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("Products_model", "modelproducts");
    }

    public function index() {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:

            $config['per_page'] = 100;
            $page = ($this->uri->segment(3) ? $this->uri->segment(3) : 0);
            //$Read->ExeRead(DB_PDT, "WHERE 1 = 1 $WhereString $WhereOpt ORDER BY pdt_created DESC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
            $data["products"] = $this->modelproducts->ExeRead(DB_PDT, ["1" => "1"], "*", ["pdt_created" => "DESC"]);
            //Table, array $Where, $Select = null, $Order = null, $Limit = null, $Offset = null)
            //var_dump($Pdts);
            //$data['readPdtCats'] = $this->modeladmin->getAllCats($config['per_page'], $page);

            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            $this->load->view("admin/products/home", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");
        endif;
    }

    public function pdt($pdt_id = null) {
        if (!checkAdmin()):
            customFlash("admin/products", "alert-warning", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:
            $data = array();
            if (!empty($pdt_id)):
                $Pdt = $this->modelproducts->readPdts(["md5(pdt_id)" => $pdt_id]);
                if ($Pdt):
                    $data['FormData'] = array_map('htmlspecialchars', $Pdt[0]);
                else:
                    customFlash("admin/products", "alert-info", "<b>OPPSS {$this->session->userdata("userlogin")['user_name']}</b>. você tentou editar um produto que não existe ou que foi removido recentemente!");
                endif;
            else:
                $LimitPdt = $this->modelproducts->readPdts(["pdt_status" => 1], "count(pdt_id) as total");
                if (E_PDT_LIMIT && $LimitPdt[0]["total"] >= E_PDT_LIMIT):
                    customFlash("admin/products", "alert-info", "<b>LIMITE ATINGIDO</b>, Olá {$this->session->userdata("userlogin")['user_name']}, o limite de produtos para sua loja é <b>" . E_PDT_LIMIT . " pdt(s)</b>. Esse limite foi atingido! <p>Para cadastrar mais produtos em contato via " . AGENCY_EMAIL . " e solicite alteração de plano!</p><p><b>Atenciosamente " . AGENCY_NAME . "!</b></p>");
                else:
                    $PdtCreate = ['pdt_created' => date('Y-m-d H:i:s'), 'pdt_status' => 0, 'pdt_inventory' => 0, 'pdt_delivered' => 0];
                    $PdtId = $this->modelproducts->createPdts($PdtCreate);
                    redirect("admin/products/pdt/" . md5($PdtId));
                endif;
            endif;

            $data['sectors'] = $this->modelproducts->getPdtCategories();
            
            //  Carregamento de Views
            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            $this->load->view("admin/products/pdt", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");

        endif;
    }

    //  Action form:: Salvar informações da categoria no banco de dados
    public function pdtmanager($pdt_id) {
        if (!checkAdmin()):
            customFlash("admin", "alert-warning", "Sua sessão expirou. Por favor, loque-se novamente!");
        else:
            if (empty($pdt_id)):
                customFlash("admin/products", "alert-error", "<b>ERROR AO CADASTRAR/ATUALIZAR PRODUTO!</b>");
            endif;

            $Product = $this->modelproducts->readPdts(["md5(pdt_id)" => $pdt_id])[0];
            $PostData = $this->input->post();

            if (empty($Product)):
                customFlash("admin/products", "alert-error", "<b>ERRO AO ATUALIZAR:</b> Desculpe, {$this->session->userdata("userlogin")['user_name']}, Mas não foi possível consultar o produto. Tente atualizar a página!");
            elseif (!empty($PostData["pdt_offer_start"]) && (!checkData($PostData["pdt_offer_start"]) || !checkData($PostData["pdt_offer_end"]))):
                customFlash("admin/products", "alert-error", "<b>ERRO AO ATUALIZAR:</b> Desculpe, {$this->session->userdata("userlogin")['user_name']}, mas a(s) data(s) de oferta foi informada com erro de calendário. Veja isso!");
            else:

                $PostData['pdt_price'] = str_replace(',', '.', str_replace('.', '', $PostData['pdt_price']));
                $PostData['pdt_offer_price'] = ($PostData['pdt_offer_price'] ? str_replace(',', '.', str_replace('.', '', $PostData['pdt_offer_price'])) : null);
                $PostData['pdt_name'] = (!empty($PostData['pdt_name']) ? Check::checkName($PostData['pdt_name']) : checkName($PostData['pdt_title']));


                //  VALIDATION UPLOAD IMAGE COVER
                //  UPLOAD
                if (!empty($_FILES['pdt_cover']['name'])):

                    $name_field = "pdt_cover";
                    $name_folder = "products";

                    $path = realpath(APPPATH . "../assets/uploads/{$name_folder}/");
                    $config["upload_path"] = $path;
                    $config["allowed_types"] = "gif|jpg|png";
                    $config["file_name"] = "{$Product["pdt_id"]}-{$PostData["pdt_name"]}-" . time();
                    $config["max_size"] = 2048;
                    $config["max_width"] = THUMB_W;
                    $config["max_height"] = THUMB_H;
                    $PdtCover = $this->modelproducts->ExeRead(DB_PDT, ["pdt_id" => $Product["pdt_id"]], "pdt_cover")[0]["pdt_cover"];
                    if (!empty($PdtCover)):
                        if (file_exists("{$path}/{$PdtCover}") && !is_dir("{$path}/{$PdtCover}")):
                            unlink("{$path}/{$PdtCover}");
                        endif;
                    endif;
                    $this->load->library("upload", $config);
                    if (!$this->upload->do_upload($name_field)):
                        $error = "<b class='icon-image'>ERRO AO ENVIAR FOTO:</b> Olá {$this->session->userdata('userLogin')['user_name']}, selecione uma imagem JPG ou PNG(no máximo ".THUMB_W."px x ".THUMB_H."px) para enviar como foto!<br> {$this->upload->display_errors()}";
                        customFlash("admin/products/pdt/{$pdt_id}", "alert-warning", $error);
                    else:
                        $filename = $this->upload->data();
                        $PostData["pdt_cover"] = "{$name_folder}/{$filename["file_name"]}";
                    endif;
                endif;

                //  VALIDATION UPLOAD IMAGE GALLERY

                if (isset($PostData["pdt_subcategory"])):
                    $subcategpry = $this->modelproducts->ExeRead(DB_PDT_CATS, ["cat_id" => $PostData["pdt_subcategory"]], "cat_parent");
                    $PostData["pdt_category"] = (!empty($subcategpry) ? $subcategpry[0]["cat_parent"] : null);
                endif;

                $PdtIsset = $this->modelproducts->readPdts(["pdt_name" => $PostData["pdt_name"], "pdt_id !=" => $Product["pdt_id"]], "pdt_id");
                if (!empty($PdtIsset)):
                    $PostData["pdt_name"] = "{$PostData["pdt_name"]}-{$Product["pdt_id"]}";
                endif;

                $TriggerMsg = null;

                //  Validação de limite de produtos
                $ReadCountPdt = $this->modelproducts->readPdts(["pdt_status" => 1], "count(pdt_id) as total");
                if (E_PDT_LIMIT && $ReadCountPdt()[0]['total'] >= E_PDT_LIMIT && $PostData['pdt_status'] == 1):
                    $TriggerMsg .= "<p><b>IMPORTANTE:</b> O produto não foi colocado a venda pois seu limite de produtos (" . E_PDT_LIMIT . ") está ultrapassado. Entre em contato via " . AGENCY_EMAIL . " para alterar seu plano!</span><p class='icon-checkmark'>O produto {$PostData['pdt_title']} foi atualizado com sucesso!</p>";
                    $PostData['pdt_status'] = '0';
                endif;

                //  Validação de código do produto
                $ReadCodePdt = $this->modelproducts->readPdts(["pdt_code" => $PostData["pdt_code"], "pdt_id !=" => $Product["pdt_id"]], "pdt_id");
                if ($ReadCodePdt):
                    $TriggerMsg = "<p><b>OPPSSS:</b> Já existe um produto cadastrado com o código {$PostData['pdt_code']}, favor altere o código deste produto!</p>";
                    $PostData['pdt_code'] = str_pad($Product["pdt_id"], 7, 0, STR_PAD_LEFT);
                    $PostData['pdt_status'] = '0';
                endif;

                $PostData['pdt_offer_start'] = (!empty($PostData['pdt_offer_start']) && checkData($PostData['pdt_offer_start']) ? checkData($PostData['pdt_offer_start']) : null);
                $PostData['pdt_offer_end'] = (!empty($PostData['pdt_offer_end']) && checkData($PostData['pdt_offer_end']) ? checkData($PostData['pdt_offer_end']) : null);

                $PostData['pdt_status'] = (!empty($PostData['pdt_status']) ? '1' : '0');


                //STOCK TABLE
                if (!empty($PostData['pdt_inventory'])):

                    $DeletePdtStock = $this->modelproducts->ExeDelete(DB_PDT_STOCK, ["pdt_id" => $Product["pdt_id"], "stock_code !=" => 'default']);
                    $ReadPdtStock = $this->modelproducts->ExeRead(DB_PDT_STOCK, ["pdt_id" => $Product["pdt_id"], "stock_code" => 'default']);
                    if (!empty($ReadPdtStock)):
                        $UpdateStock = ['stock_inventory' => $PostData['pdt_inventory']];
                        $this->modelproducts->ExeUpdate(DB_PDT_STOCK, $UpdateStock, ["pdt_id" => $Product["pdt_id"], "stock_code" => 'default']);
                    else:
                        $CreateStock = ['pdt_id' => $Product["pdt_id"], 'stock_code' => 'default', 'stock_inventory' => $PostData['pdt_inventory'], "stock_sold" => 0];
                        $this->modelproducts->ExeCreate(DB_PDT_STOCK, $CreateStock);
                    endif;
                endif;

                //NORMALIZE STOCK AND DELIVERED
                $ReadInventoryStock = $this->modelproducts->ExeRead(DB_PDT_STOCK, ["pdt_id" => $Product["pdt_id"]], "sum(stock_inventory) AS amount, sum(stock_sold) AS vendor");
                $PostData["pdt_inventory"] = (!empty($ReadInventoryStock) ? $ReadInventoryStock[0]["amount"] : 0);
                $PostData["pdt_delivered"] = (!empty($ReadInventoryStock) ? $ReadInventoryStock[0]["vendor"] : 0);
                $Update = $this->modelproducts->ExeUpdate(DB_PDT, $PostData, ["pdt_id" => $Product["pdt_id"]]);
                //$Update->ExeUpdate(DB_PDT, $PostData, "WHERE pdt_id = :id", "id={$PdtId}");
                //$jSON['view'] = BASE . '/produto/' . $PostData['pdt_name'];

                if (!empty($Update)):
                    customFlash("admin/products/pdt/{$pdt_id}", "alert-success", "<span class='icon-checkmark'><b>PRODUTO ATUALIZADO:</b> Olá {$this->session->userdata("userlogin")['user_name']}. O produto {$PostData['pdt_title']} foi atualizado com sucesso!<span>");
                else:
                    customFlash("admin/products/pdt/{$pdt_id}", "alert-info", "<b>OPPSSSS:</b> Desculpe, {$this->session->userdata("userlogin")['user_name']}, Mas não foi possível atualizar informações!");
                endif;

            endif;



            var_dump($PostData);

        endif;
    }

    ########## CATEGORIES ##########
    //  Listar

    public function categories() {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:


            $data['sectors'] = $this->modelproducts->getPdtCategories();

            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            //$this->load->view("admin/inc/mainnav");
            $this->load->view("admin/products/categories", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");
        endif;
    }

    //  Adiciona/Editar
    public function category($cat_id = null) {
        if (!checkAdmin()):
            customFlash("admin", "alert-warning", "Sua sessão expirou. Por favor, loque-se novamente!");
        else:
            $data = [];
            if (!empty($cat_id)):
                $Category = $this->modelproducts->readPdtCategories(["md5(cat_id)" => $cat_id]);
                if ($Category):
                    $data['FormData'] = array_map('htmlspecialchars', $Category[0]);
                else:
                    customFlash("admin/users", "alert-info", "<b>OPPSS {$this->session->userdata("userlogin")['user_name']}</b>. você tentou editar uma categoria que não existe ou que foi removido recentemente!");
                endif;
            else:
                $CatCreate = [
                    "cat_name" => checkName("Nome Categoria - " . date('Y-m-d H:i:s')),
                    "cat_created" => date('Y-m-d H:i:s')
                ];
                $CategoryId = $this->modelproducts->createPdtCategories($CatCreate);
                redirect("admin/products/category/" . md5($CategoryId));
            endif;


            $data["sectors"] = $this->modelproducts->readPdtCategories(["cat_parent" => null, "md5(cat_id) !=" => $cat_id], "cat_id, cat_title, cat_sizes", ["cat_title" => "ASC"]);

            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            //$this->load->view("admin/inc/mainnav");
            $this->load->view("admin/products/category", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");


        endif;
    }

    //  Action form:: Salvar informações da categoria no banco de dados
    public function categorymanager($cat_id) {
        if (!checkAdmin()):
            customFlash("admin", "alert-warning", "Sua sessão expirou. Por favor, loque-se novamente!");
        else:
            if (empty($cat_id)):
                customFlash("admin/products", "alert-error", "<b>ERROR AO CADASTRAR/ATUALIZAR SESSÃO/CATEGORIA!</b>");
            endif;

            $CatId = $this->modelproducts->readPdtCategories(["md5(cat_id)" => $cat_id], "cat_id")[0]["cat_id"];

            $PostData = $this->input->post();
            $PostData['cat_name'] = checkName($PostData['cat_title']);
            $PostData['cat_parent'] = ($PostData['cat_parent'] ? $PostData['cat_parent'] : null);
            $PostData['cat_sizes'] = (!empty($PostData['cat_sizes']) && $PostData['cat_sizes'] != 'default' ? mb_strtoupper($PostData['cat_sizes']) : null);

            //  Verificar se existe alguma categoria com o mesmo cat_name
            $Category = $this->modelproducts->readPdtCategories(["cat_name" => $PostData["cat_name"]], "cat_id");
            if ($Category):
                $PostData['cat_name'] = $PostData['cat_name'] . '-' . $CatId;
            endif;

            //  UPLOAD
            if (!empty($_FILES['cat_cover']['name'])):

                $name_field = "cat_cover";
                $name_folder = "pdtcategories";

                $path = realpath(APPPATH . "../assets/uploads/{$name_folder}/");
                $config["upload_path"] = $path;
                $config["allowed_types"] = "gif|jpg|png";
                $config["file_name"] = "{$CatId}-{$PostData["cat_name"]}-" . time();
                $config["max_size"] = 2048;
                $config["max_width"] = 1980;
                $config["max_height"] = 1200;
                $UserThumb = $this->modelproducts->readPdtCategories(["cat_id" => $CatId], "cat_cover")[0]["cat_cover"];
                if (!empty($UserThumb)):
                    if (file_exists("{$path}/{$UserThumb}") && !is_dir("{$path}/{$UserThumb}")):
                        unlink("{$path}/{$UserThumb}");
                    endif;
                endif;
                $this->load->library("upload", $config);
                if (!$this->upload->do_upload($name_field)):
                    $error = "<b class='icon-image'>ERRO AO ENVIAR FOTO:</b> Olá {$this->session->userdata('userLogin')['user_name']}, selecione uma imagem JPG ou PNG(no máximo 1980px x 1080px) para enviar como foto!<br> {$this->upload->display_errors()}";
                    customFlash("admin/products/category/{$cat_id}", "alert-warning", $error);
                else:
                    $filename = $this->upload->data();
                    $PostData["cat_cover"] = "{$name_folder}/{$filename["file_name"]}";
                endif;
            endif;

            $CatParent = $this->modelproducts->readPdtCategories(["md5(cat_parent)" => $cat_id], "cat_id");
            if ($CatParent && !empty($PostData["cat_parent"])):
                customFlash("admin/products/category/{$cat_id}", "alert-info", "<b>OPPSSS:</b> {$this->session->userdata("userlogin")["user_name"]}, uma categoria PAI (que possui subcategorias) não pode ser atribuida como subcategoria!");
            else:
                $Cat = $this->modelproducts->readPdtCategories(["md5(cat_id)" => $cat_id, "cat_parent" => $PostData["cat_parent"]], "cat_id,cat_parent");
                if (!empty($Cat)):
                    $PdtUpdate["pdt_category"] = $PostData["cat_parent"];
                    //  Atualiza Na tabela produtos                
                    $this->modelproducts->updatePdt(["pdt_category !=" => $PostData["cat_parent"], "md5(pdt_subcategory)" => $cat_id], $PdtUpdate);
                endif;
                $this->modelproducts->updatePdtCategories(["md5(cat_id)" => $cat_id], $PostData);
                customFlash("admin/products/category/{$cat_id}", "alert-success", "<b>Tudo Certo:</b> A categoria <b>{$PostData["cat_title"]}</b> foi atualizada com sucesso!");
            endif;
        endif;
    }

    //  Action form:: Deletar categoria
    public function cat_delete($cat_id) {
        $Cond = [
            "where" => [
                "md5(pdt_category)" => $cat_id,
            ],
            "or_where" => [
                "md5(pdt_subcategory)" => $cat_id
            ]
        ];
        $ReadPdt = $this->modelproducts->readPdt($Cond);

        if (!empty($ReadPdt)):
            customFlash("admin/products/categories", "alert-info", "<b>Opssss:</b> Desculpe {$this->session->userdata("userlogin")["user_name"]}, mas não é possível remover categorias com produtos cadastrados nela!");
        else:
            $ReadCat = $this->modelproducts->readPdtCategories(["md5(cat_parent)" => $cat_id], "cat_id, cat_title");
            if (!empty($ReadCat)):
                customFlash("admin/products/categories", "alert-info", "<b>Oppsss:</b> Desculpe {$this->session->userdata("userlogin")["user_name"]}, mas não é possível remover categorias com subcategorias ligadas a ela!");
            else:
                $categoryRemove = $this->modelproducts->readPdtCategories(["md5(cat_id)" => $cat_id], "cat_title, cat_cover")[0];

                $CatCover = "./assets/uploads/{$categoryRemove["cat_cover"]}";
                if (file_exists($CatCover) && !is_dir($CatCover)):
                    unlink($CatCover);
                endif;

                $this->modelproducts->deletePdtCategories($cat_id);
                customFlash("admin/products/categories", "alert-success", "<b>TUDO CERTO!</b> A categoria <b>{$categoryRemove["cat_title"]}</b> foi removida com sucesso!");
            endif;
        endif;
    }

    ########## BRANDS ##########

    public function brands() {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:

            $config = array();

            $config['full_tag_open'] = '<ul class="pagination gmpg">';
            $config['full_tag_close'] = '</ul>';
            $config['first_link'] = false;
            $config['last_link'] = false;
            $config['first_tag_open'] = '</li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '</li>';
            $config['last_tag_close'] = '</li>';

            $config['next_link'] = '&raquo';
            $config['next_tag_open'] = '</li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '&laquo';
            $config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
            $config['curl_tag_open'] = '<li class="active"><a href="#">';
            $config['curl_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $config['base_url'] = site_url("admin/products/brands");
            $brands = $this->modelproducts->readBrands(["1" => "1"]);

            $config['total_rows'] = $brands->num_rows();
            $config['per_page'] = 100;
            $config['uri_segment'] = 3;

            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3) ? $this->uri->segment(3) : 0);
            $data['allBrands'] = $this->modelproducts->readAllBrands($config['per_page'], $page);
            $data['links'] = $this->pagination->create_links();

            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            //$this->load->view("admin/inc/mainnav");
            $this->load->view("admin/products/brands", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");
        endif;
    }

    public function brand($brand_id = null) {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:

            $data = [];
            if (!empty($brand_id)):
                $Brand = $this->modelproducts->readPdtBrands(["md5(brand_id)" => $brand_id]);
                if ($Brand):
                    $data['FormData'] = array_map('htmlspecialchars', $Brand[0]);
                else:
                    customFlash("admin/brands", "alert-info", "<b>OPPSS {$this->session->userdata("userlogin")['user_name']}</b>. você tentou editar um fabricante que não existe ou que foi removido recentemente!");
                endif;
            else:
                $BrandCreate = [
                    "brand_name" => checkName("Nome Fabricante - " . date('Y-m-d H:i:s')),
                    "brand_created" => date('Y-m-d H:i:s')
                ];
                $BrandId = $this->modelproducts->createPdtBrands($BrandCreate);
                redirect("admin/products/brand/" . md5($BrandId));
            endif;


            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            //$this->load->view("admin/inc/mainnav");
            $this->load->view("admin/products/brand", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");
        endif;
    }

    public function brandmanager($brand_id) {
        if (!checkAdmin()):
            customFlash("admin", "alert-warning", "Sua sessão expirou. Por favor, loque-se novamente!");
        else:
            if (empty($brand_id)):
                customFlash("admin/products", "alert-error", "<b>ERROR AO CADASTRAR/ATUALIZAR SESSÃO/CATEGORIA!</b>");
            endif;

            $PostData = $this->input->post();
            $BrandId = $this->modelproducts->readPdtBrands(["md5(brand_id)" => $brand_id], "brand_id")[0]["brand_id"];

            $PostData["brand_name"] = checkName($PostData["brand_title"]);
            $BrandIsset = $this->modelproducts->readPdtBrands(["brand_name" => $PostData["brand_name"], "brand_id !=" => $BrandId], "brand_id");
            if (!empty($BrandIsset)):
                $PostData["brand_name"] = "{$PostData["brand_name"]}-{$BrandId}";
            endif;

            //  UPLOAD
            if (!empty($_FILES['brand_cover']['name'])):

                $name_field = "brand_cover";
                $name_folder = "pdtbrands";

                $path = realpath(APPPATH . "../assets/uploads/{$name_folder}/");
                $config["upload_path"] = $path;
                $config["allowed_types"] = "gif|jpg|png";
                $config["file_name"] = "{$BrandId}-{$PostData["brand_name"]}-" . time();
                $config["max_size"] = 2048;
                $config["max_width"] = 1980;
                $config["max_height"] = 1600;
                $UserThumb = $this->modelproducts->readPdtBrands(["brand_id" => $BrandId], "brand_cover")[0]["brand_cover"];
                if (!empty($UserThumb)):
                    if (file_exists("{$path}/{$UserThumb}") && !is_dir("{$path}/{$UserThumb}")):
                        unlink("{$path}/{$UserThumb}");
                    endif;
                endif;
                $this->load->library("upload", $config);
                if (!$this->upload->do_upload($name_field)):
                    $error = "<b class='icon-image'>ERRO AO ENVIAR FOTO:</b> Olá {$this->session->userdata('userLogin')['user_name']}, selecione uma imagem JPG ou PNG(no máximo " . IMAGE_BRAND_W . "px x " . IMAGE_BRAND_H . "px) para enviar como foto!<br> {$this->upload->display_errors()}";
                    customFlash("admin/products/brand/{$brand_id}", "alert-warning", $error);
                else:
                    $filename = $this->upload->data();
                    $PostData["brand_cover"] = "{$name_folder}/{$filename["file_name"]}";
                endif;
            endif;

            $updateResult = $this->modelproducts->updatePdtBrands(["brand_id" => $BrandId], $PostData);
            if (!empty($updateResult)):
                customFlash("admin/products/brand/{$brand_id}", "alert-success", "<b>Tudo Certo:</b> O Fabricante <b>{$PostData["brand_title"]}</b> foi atualizado com sucesso!");
            else:
                customFlash("admin/products/brand/{$brand_id}", "alert-error", "<b>ERRO AO ATUALIZAR FABRICANTE:</b>");
            endif;


        endif;



//        $BrandId = $PostData['brand_id'];
//            $PostData['brand_name'] = Check::Name($PostData['brand_title']);
//
//            $Read->FullRead("SELECT brand_id FROM " . DB_PDT_BRANDS . " WHERE brand_name = :nm AND brand_id != :id", "nm={$PostData['brand_name']}&id={$BrandId}");
//            if ($Read->getResult()):
//                $PostData['brand_name'] = "{$PostData['brand_name']}-{$BrandId}";
//            endif;
//
//            unset($PostData['brand_id']);
//            $Update->ExeUpdate(DB_PDT_BRANDS, $PostData, "WHERE brand_id = :id", "id={$BrandId}");
//            $jSON['trigger'] = AjaxErro("<b class='icon-checkmark'>TUDO CERTO: </b> A marca ou fabricante <b>{$PostData['brand_title']}</b> foi atualizada com sucesso!");
//            break;
    }

    //  Action form:: Deletar categoria
    public function brand_delete($brand_id) {
        $Cond = [
            "where" => [
                "md5(pdt_brand)" => $brand_id,
            ]
        ];
        $ReadPdt = $this->modelproducts->readPdt($Cond);

        if (!empty($ReadPdt)):
            customFlash("admin/products/brands", "alert-info", "<b>Opssss:</b> Desculpe {$this->session->userdata("userlogin")["user_name"]}, mas não é possível remover fabricantes com produtos cadastrados nele!");
        else:
            $brandRemove = $this->modelproducts->readPdtBrands(["md5(brand_id)" => $brand_id], "brand_title, brand_cover")[0];

            $BrandCover = "./assets/uploads/{$brandRemove["brand_cover"]}";
            if (file_exists($BrandCover) && !is_dir($BrandCover)):
                unlink($BrandCover);
            endif;

            $this->modelproducts->deletePdtBrands($brand_id);
            customFlash("admin/products/brands", "alert-success", "<b>TUDO CERTO!</b> A Marca/Fabricante <b>{$BrandRemove["brand_title"]}</b> foi removida(o) com sucesso!");

        endif;
    }

}
