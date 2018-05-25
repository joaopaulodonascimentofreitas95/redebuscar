<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Slides extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("Slides_model", "modelslides");
    }

    public function index() {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:

            $config['per_page'] = 100;
            $page = ($this->uri->segment(3) ? $this->uri->segment(3) : 0);
            //$data['allSlides'] = $this->modelslides->readAllSlides($config['per_page'], $page, ["slide_status" => 0]);
            $data['allSlides'] = $this->modelslides->readAllSlides($config['per_page'], $page);

            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            $this->load->view("admin/slides/home", $data);
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

    public function slide($slide_id = null) {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:
            $data = [];
            if (!empty($slide_id)):
                $Slide = $this->modelslides->readSlides(["md5(slide_id)" => $slide_id]);
                if ($Slide):
                    $data['FormData'] = array_map('htmlspecialchars', $Slide[0]);
                else:
                    customFlash("admin/services", "alert-info", "<b>OPPSS {$this->session->userdata("userlogin")['user_name']}</b>. você tentou editar um serviço que não existe ou que foi removido recentemente!");
                endif;
            else:
                $SlideCreate = ['slide_date' => date('Y-m-d H:i:s'), 'slide_start' => date('Y-m-d H:i:s')];
                $SlideId = $this->modelslides->createSlides($SlideCreate);
                redirect("admin/slides/slide/" . md5($SlideId));
            endif;


            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            //$this->load->view("admin/inc/mainnav");
            $this->load->view("admin/slides/slide", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");
        endif;
    }

    public function slidemanager($slide_id) {
        if (!checkAdmin()):
            customFlash("admin", "alert-warning", "Sua sessão expirou. Por favor, loque-se novamente!");
        else:
            if (empty($slide_id)):
                customFlash("admin/slides", "alert-error", "<b>ERROR AO CADASTRAR/ATUALIZAR DESTAQUE!</b>");
            endif;

            $PostData = $this->input->post();
            $SlideEnd = (!empty($PostData['slide_end']) ? $PostData['slide_end'] : null);
            $Image = (!empty($_FILES['slide_image']['name']) ? $_FILES['slide_image'] : null);
            $SlideImage = $this->modelslides->readSlides(["md5(slide_id)" => $slide_id], "slide_image")[0];
            unset($PostData["slide_end"]);
            if (empty($Image) && (!$SlideImage || !$SlideImage['slide_image'])):
                customFlash("admin/slides/slide/{$slide_id}", "alert-warning", "<b class='icon-warning'>ERRO AO CADASTRAR:</b> Favor envie uma imagem de destaque nas medidas de " . SLIDE_W . "x" . SLIDE_H . "px!");
            else:
                $PostData['slide_date'] = date('Y-m-d H:i:s');
                $PostData['slide_start'] = (!empty($PostData["slide_start"]) ? checkData($PostData['slide_start']) : date('d/m/Y H:i:s'));
                $PostData['slide_end'] = (!empty($SlideEnd) ? checkData($SlideEnd) : null);
                $PostData['slide_status'] = (!empty($PostData['slide_status']) ? $PostData['slide_status'] : '0');

                if (!empty($Image)):
                    $name_field = "slide_image";
                    $name_folder = "slides";
                    $path = realpath(APPPATH . "../assets/uploads/{$name_folder}/");

                    if ($SlideImage && !empty($SlideImage["slide_image"]) && file_exists("./assets/uploads/{$SlideImage["slide_image"]}") && !is_dir("./assets/uploads/{$SlideImage["slide_image"]}")):
                        unlink("./assets/uploads/{$SlideImage["slide_image"]}");
                    endif;

                    $config["upload_path"] = $path;
                    $config["allowed_types"] = "gif|jpg|png";
                    $config["file_name"] = checkName($PostData["slide_title"]);
                    $config["max_size"] = 2048;
                    $config["max_width"] = 1920;
                    $config["max_height"] = 1080;

                    $this->load->library("upload", $config);
                    if (!$this->upload->do_upload($name_field)):
                        $error = "<b class='icon-image'>ERRO AO ENVIAR FOTO:</b> Olá {$this->session->userdata('userLogin')['user_name']}, selecione uma imagem JPG ou PNG(no máximo " . SLIDE_W . "px x " . SLIDE_H . "px) para enviar como foto!<br> {$this->upload->display_errors()}";
                        customFlash("admin/slides/slide/{$slide_id}", "alert-warning", $error);
                    else:
                        $filename = $this->upload->data();
                        $PostData["slide_image"] = "{$name_folder}/{$filename["file_name"]}";
                    endif;
                endif;


                $updateResult = $this->modelslides->updateSlides(["md5(slide_id)" => $slide_id], $PostData);
                if (!empty($updateResult)):
                    customFlash("admin/slides/slide/{$slide_id}", "alert-success", "<b>Tudo Certo:</b> O Destaque <b>{$PostData["slide_title"]}</b> foi atualizado com sucesso!");
                else:
                    customFlash("admin/slides/slide/{$slide_id}", "alert-error", "<b>ERRO AO ATUALIZAR DESTAQUE:</b>");
                endif;
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
    public function slide_delete($slide_id) {

        $ReadSlide = $this->modelslides->readSlides(["md5(slide_id)" => $slide_id]);

        if (empty($ReadSlide)):
            customFlash("admin/slides", "alert-info", "<b>Opssss:</b> Desculpe {$this->session->userdata("userlogin")["user_name"]}, mas você tentou remover um destaque que não existe ou foi removido recentemente!");
        else:
            $slideRemove = $this->modelslides->readSlides(["md5(slide_id)" => $slide_id], "slide_title, slide_image")[0];

            $slideImage = "./assets/uploads/{$slideRemove["slide_image"]}";
            if (file_exists($slideImage) && !is_dir($slideImage)):
                unlink($slideImage);
            endif;

            $this->modelslides->deleteSlides($slide_id);
            customFlash("admin/slides", "alert-success", "<b>TUDO CERTO!</b> O Destaque <b>{$slideRemove["slide_title"]}</b> foi removido com sucesso!");

        endif;
    }

}
