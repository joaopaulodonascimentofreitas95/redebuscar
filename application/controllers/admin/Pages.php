<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("Pages_model", "modelpages");
    }

    public function index() {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:

            $config['per_page'] = 100;
            $page = ($this->uri->segment(3) ? $this->uri->segment(3) : 0);
            //$data['allSlides'] = $this->modelslides->readAllSlides($config['per_page'], $page, ["slide_status" => 0]);
            $data['pages'] = $this->modelpages->readAllPages($config['per_page'], $page);

            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            $this->load->view("admin/pages/home", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");
        endif;
    }

    public function page($page_id = null) {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:
            $data = [];
            if (!empty($page_id)):
                $Page = $this->modelpages->readPages(["md5(page_id)" => $page_id]);
                if ($Page):
                    $data['FormData'] = array_map('htmlspecialchars', $Page[0]);
                else:
                    customFlash("admin/pages", "alert-info", "<b>OPPSS {$this->session->userdata("userlogin")['user_name']}</b>. você tentou editar uma página que não existe ou que foi removido recentemente!");
                endif;
            else:
                $PageCreate = ['page_date' => date('Y-m-d H:i:s'), 'page_status' => 0];
                $SlideId = $this->modelpages->createPages($PageCreate);
                redirect("admin/pages/page/" . md5($SlideId));
            endif;


            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            //$this->load->view("admin/inc/mainnav");
            $this->load->view("admin/pages/page", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");
        endif;
    }

    public function pagemanager($page_id) {
        if (!checkAdmin()):
            customFlash("admin", "alert-warning", "Sua sessão expirou. Por favor, loque-se novamente!");
        else:
            if (empty($page_id)):
                customFlash("admin/pages", "alert-error", "<b>ERROR AO CADASTRAR/ATUALIZAR DESTAQUE!</b>");
            endif;

            $PostData = $this->input->post();
            $Image = (!empty($_FILES['page_cover']['name']) ? $_FILES['page_cover'] : null);

            $PostData['page_status'] = (!empty($PostData['page_status']) ? '1' : '0');
            $PostData['page_order'] = (!empty($PostData['page_order']) ? $PostData['page_order'] : null);
            $PostData['page_name'] = (!empty($PostData['page_name']) ? checkName($PostData['page_name']) : checkName($PostData['page_title']));

            if (!empty($Image)):
                $name_field = "page_cover";
                $name_folder = "pages";
                $path = realpath(APPPATH . "../assets/uploads/{$name_folder}/");

                if ($Image && !empty($PageCover["page_cover"]) && file_exists("./assets/uploads/{$PageCover["page_cover"]}") && !is_dir("./assets/uploads/{$PageCover["page_cover"]}")):
                    unlink("./assets/uploads/{$PageCover["page_cover"]}");
                endif;

                $config["upload_path"] = $path;
                $config["allowed_types"] = "gif|jpg|png";
                $config["file_name"] = checkName($PostData["page_title"]);
                $config["max_size"] = 2048;
                $config["max_width"] = IMAGE_W;
                $config["max_height"] = IMAGE_H;

                $this->load->library("upload", $config);
                if (!$this->upload->do_upload($name_field)):
                    $error = "<b class='icon-image'>ERRO AO ENVIAR FOTO:</b> Olá {$this->session->userdata('userLogin')['user_name']}, selecione uma imagem JPG ou PNG(no máximo " . IMAGE_W . "px x " . IMAGE_H . "px) para enviar como foto!<br> {$this->upload->display_errors()}";
                    customFlash("admin/pages/page/{$page_id}", "alert-warning", $error);
                else:
                    $filename = $this->upload->data();
                    $PostData["page_cover"] = "{$name_folder}/{$filename["file_name"]}";
                endif;
            endif;


            $updateResult = $this->modelpages->updatePages(["md5(page_id)" => $page_id], $PostData);
            if (!empty($updateResult)):
                customFlash("admin/pages/page/{$page_id}", "alert-success", "<b>Tudo Certo:</b> A página <b>{$PostData["page_title"]}</b> foi atualizada com sucesso!");
            else:
                customFlash("admin/pages/page/{$page_id}", "alert-error", "<b>ERRO AO ATUALIZAR DESTAQUE:</b>");
            endif;

        endif;
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
