<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("Services_model", "modelservices");
    }

    public function index() {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:

            $config['per_page'] = 100;
            $page = ($this->uri->segment(3) ? $this->uri->segment(3) : 0);
            $data['allServices'] = $this->modelservices->readAllServices($config['per_page'], $page);

            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            $this->load->view("admin/services/home", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");
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

    public function service($service_id = null) {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:

            $data = [];
            if (!empty($service_id)):
                $Service = $this->modelservices->readServices(["md5(service_id)" => $service_id]);
                if ($Service):
                    $data['FormData'] = array_map('htmlspecialchars', $Service[0]);
                else:
                    customFlash("admin/services", "alert-info", "<b>OPPSS {$this->session->userdata("userlogin")['user_name']}</b>. você tentou editar um serviço que não existe ou que foi removido recentemente!");
                endif;
            else:
                $ServiceCreate = [
                    "service_name" => checkName("Nome Serviço - " . date('Y-m-d H:i:s')),
                    "service_created" => date('Y-m-d H:i:s')
                ];
                $ServiceId = $this->modelservices->createServices($ServiceCreate);
                redirect("admin/services/service/" . md5($ServiceId));
            endif;


            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            //$this->load->view("admin/inc/mainnav");
            $this->load->view("admin/services/service", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");
        endif;
    }

    public function servicemanager($service_id) {
        if (!checkAdmin()):
            customFlash("admin", "alert-warning", "Sua sessão expirou. Por favor, loque-se novamente!");
        else:
            if (empty($service_id)):
                customFlash("admin/services", "alert-error", "<b>ERROR AO CADASTRAR/ATUALIZAR SERVIÇO!</b>");
            endif;

            $PostData = $this->input->post();
            $ServiceId = $this->modelservices->readServices(["md5(service_id)" => $service_id], "service_id")[0]["service_id"];

            $PostData["service_name"] = checkName($PostData["service_title"]);
            $ServiceIsset = $this->modelservices->readServices(["service_name" => $PostData["service_name"], "service_id !=" => $ServiceId], "service_id");
            if (!empty($ServiceIsset)):
                $PostData["service_name"] = "{$PostData["service_name"]}-{$ServiceId}";
            endif;

            //  UPLOAD
            if (!empty($_FILES['service_cover']['name'])):

                $name_field = "service_cover";
                $name_folder = "services";

                $path = realpath(APPPATH . "../assets/uploads/{$name_folder}/");
                $config["upload_path"] = $path;
                $config["allowed_types"] = "gif|jpg|png";
                $config["file_name"] = "{$ServiceId}-{$PostData["service_name"]}-" . time();
                $config["max_size"] = 2048;
                $config["max_width"] = 1980;
                $config["max_height"] = 1600;
                $UserThumb = $this->modelservices->readServices(["service_id" => $ServiceId], "service_cover")[0]["service_cover"];
                if (!empty($UserThumb)):
                    if (file_exists("{$path}/{$UserThumb}") && !is_dir("{$path}/{$UserThumb}")):
                        unlink("{$path}/{$UserThumb}");
                    endif;
                endif;
                $this->load->library("upload", $config);
                if (!$this->upload->do_upload($name_field)):
                    $error = "<b class='icon-image'>ERRO AO ENVIAR FOTO:</b> Olá {$this->session->userdata('userLogin')['user_name']}, selecione uma imagem JPG ou PNG(no máximo " . IMAGE_BRAND_W . "px x " . IMAGE_BRAND_H . "px) para enviar como foto!<br> {$this->upload->display_errors()}";
                    customFlash("admin/services/service/{$service_id}", "alert-warning", $error);
                else:
                    $filename = $this->upload->data();
                    $PostData["service_cover"] = "{$name_folder}/{$filename["file_name"]}";
                endif;
            endif;

            $updateResult = $this->modelservices->updateServices(["service_id" => $ServiceId], $PostData);
            if (!empty($updateResult)):
                customFlash("admin/services/service/{$service_id}", "alert-success", "<b>Tudo Certo:</b> O Servicço <b>{$PostData["service_title"]}</b> foi atualizado com sucesso!");
            else:
                customFlash("admin/services/service/{$service_id}", "alert-error", "<b>ERRO AO ATUALIZAR SERIÇO:</b>");
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
    public function service_delete($service_id) {
        
        $ReadService = $this->modelservices->readServices(["md5(service_id)" => $service_id]);

        if (empty($ReadService)):
            customFlash("admin/services", "alert-info", "<b>Opssss:</b> Desculpe {$this->session->userdata("userlogin")["user_name"]}, mas você tentou remover um serviço que não existe ou foi removido recentemente!");
        else:
            $serviceRemove = $this->modelservices->readServices(["md5(service_id)" => $service_id], "service_title, service_cover")[0];

            $serviceCover = "./assets/uploads/{$serviceRemove["service_cover"]}";
            if (file_exists($serviceCover) && !is_dir($serviceCover)):
                unlink($serviceCover);
            endif;

            $this->modelservices->deleteServices($service_id);
            customFlash("admin/services", "alert-success", "<b>TUDO CERTO!</b> O Serviço <b>{$serviceRemove["service_title"]}</b> foi removido com sucesso!");
       
        endif;
    }

}
