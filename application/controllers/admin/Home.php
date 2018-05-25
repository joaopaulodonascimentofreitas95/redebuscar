<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model', 'modeladmin');
    }

    #   LOGIN

    public function index() {
        if (checkAdmin()):
            redirect("admin/dashboard");
        else:
            $this->load->view("admin/login/inc/header");
            $this->load->view("admin/login/inc/css");
            $this->load->view("admin/login/header");
            $this->load->view("admin/login/home");
            $this->load->view("admin/login/inc/footer");
        endif;
    }

    #   DASHBOARD
    //  Home dashboard

    public function dashboard() {

        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:

            $data["products"] = $this->modeladmin->ExeRead(DB_PDT, ["pdt_title !=" => null]);

            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            //$this->load->view("admin/inc/mainnav");
            $this->load->view("admin/dash/home", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");
        endif;
    }

    //  Valida Login
    public function checkAdmin() {
        $data = [
            "user_email" => $this->input->post("user_email", true),
            "user_password" => $this->input->post("user_password", true)
        ];

        if (in_array("", $data)):
            customFlash("admin", "alert-info", "Please check required fields and try again!");
        else:

            if (!checkemail($data['user_email']) || !filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)):
                customFlash("admin", "alert-info", "O e-mail informado não tem um formato válido!");
            elseif (strlen($data['user_password']) < 5):
                $this->session->set_flashdata("error", "<div class='alert alert-info' role='alert'>Senha informada  não é compatível!</div>");
                redirect("admin/login");
            else:

                if (empty($this->modeladmin->checkAdminLevel(6))):
                    $Admin = [
                        'user_id' => 1,
                        'user_thumb' => 'images/2016/02/1-adminwork-control.png',
                        'user_name' => 'Admin',
                        'user_lastname' => 'Root',
                        'user_email' => 'admin@admin.com.br',
                        'user_password' => hash('sha512', 'admin'),
                        'user_registration' => date('Y-m-d H:i:s'),
                        'user_level' => 10
                    ];
                    $this->modeladmin->exe_create("ws_users", $Admin);
                endif;

                if (!$this->modeladmin->checkAdmin(["user_email" => $data['user_email']])):
                    customFlash("admin", "alert-info", "Email informado não é cadastrado!");
                else:

                    //CRIPTIGRAFA A SENHA
                    $data['user_password'] = hash('sha512', $data['user_password']);

                    $email_pass = ["user_email" => $data['user_email'], "user_password" => $data['user_password']];
                    $user = $this->modeladmin->checkAdmin($email_pass)[0];
                    if (empty($user)):
                        customFlash("admin", "alert-info", "<b>ERRO:</b> E-mail e senha não conferem!");
                    else:

                        $email_pass_level = ["user_email" => $data["user_email"], "user_password" => $data['user_password'], "user_level >=" => "6"];
                        $user_success = $this->modeladmin->checkAdmin($email_pass_level)[0];


                        if (empty($user_success)):
                            customFlash("admin", "alert-warning", "<b>ERRO:</b> Você não tem permissão para acessar o painel!<div>");
                            redirect("admin/login");
                        else:

                            $session["userlogin"] = $user_success;
                            $AdminSession = $this->session->set_userdata($session);

                            if (!empty($this->session->userdata('userlogin'))):
                                redirect("admin/dashboard");
                            else:
                                session_destroy();
                                customFlash("admin", "alert-warning", "Não foi possível realizar o login!</div>");
                                redirect("admin/login");
                            endif;

                        endif;

                    endif;

                    customFlash("admin", "alert-warning", "<div class='alert alert-error' role='alert'>Não foi possível realizar login. Tente novamente!</div>");
                    redirect("admin/login");
                endif;

            endif;

        endif;
    }

    //  Deslogar
    public function logoauth() {
        $Name = $this->session->userdata("userlogin")['user_name'];

        $this->session->set_userdata("userlogin", "");
        if (empty($this->session->userdata("userlogin"))):
            customFlash("admin", "alert-success", "<b>Tudo certo {$Name}!</b> Volte logo :)");
        endif;
    }

    #   USERS
    //  Listagem de usuários

    public function users() {
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

            $config['base_url'] = site_url("admin/categories");
            $users = $this->modeladmin->allUsers(['1' => '1']);

            $config['total_rows'] = $users->num_rows();
            $config['per_page'] = 100;
            $config['uri_segment'] = 3;

            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3) ? $this->uri->segment(3) : 0);
            $data['allUsers'] = $this->modeladmin->getAllUsers($config['per_page'], $page);
            $data['links'] = $this->pagination->create_links();

            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            //$this->load->view("admin/inc/mainnav");
            $this->load->view("admin/users/home", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");
        endif;
    }

    //  Cadastro e edição de usuários
    public function user($user_id = null) {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:
            if (!empty($user_id)):
                $getResult = $this->modeladmin->checkUser(["md5(user_id)" => $user_id]);
                if ($getResult):
                    $FormData = array_map('htmlspecialchars', $getResult[0]);
                    if (!empty($user_level) > $this->session->userdata("userlogin")['user_level']):
                        customFlash("admin/users", "alert-info", "<b>OPPSS {$this->session->userdata("userlogin")['user_name']}</b>. Por questões de segurança, é restrito o acesso a usuário com nível de acesso maior que o seu!");
                        exit;
                    endif;
                else:
                    customFlash("admin/users", "alert-info", "<b>OPPSS {$this->session->userdata("userlogin")['user_name']}</b>. você tentou editar um usuário que não existe ou que foi removido recentemente!");
                    exit;
                endif;
            else:
                $CreateUserDefault = [
                    "user_registration" => date('Y-m-d H:i:s'),
                    "user_level" => 1
                ];
                $UserId = $this->modeladmin->addUser($CreateUserDefault);
                redirect("admin/user/" . md5($UserId));
            endif;

            $data["FormData"] = (!empty($FormData) ? $FormData : null);


            //$Read->ExeRead(DB_USERS_ADDR, "WHERE user_id = :user ORDER BY addr_key DESC, addr_name ASC", "user={$user_id}");
            $data['address'] = $this->modeladmin->getUserAddress(["md5(user_id)" => $user_id], ['addr_key' => 'DESC', 'addr_name' => 'ASC']);

            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            //$this->load->view("admin/inc/mainnav");
            $this->load->view("admin/users/create", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");
        endif;
    }

    //  Realiza cadastro e edição de usuário
    public function usermanager($user_id) {

        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:
            if (empty($user_id)):
                customFlash("admin/users", "alert-info", "<b>OPPSS</b>Você tentou editar um usuário que não existe ou que foi removido recentemente");
            else:
                $data = $this->input->post();

                $result = $this->modeladmin->checkUser(["user_email" => $data['user_email'], "md5(user_id) !=" => $user_id], "user_id");
                if ($result):
                    customFlash("admin/user/{$user_id}", "alert-info", "<b>OPSS:</b> Olá {$this->session->userdata('userlogin')['user_name']}. O e-mail <b>{$data['user_email']}</b> já está cadastrado na conta de outro usuário!");
                else:
                    $resultb = $this->modeladmin->checkUser(["user_document" => $data['user_document'], "md5(user_id) !=" => $user_id], "user_id");
                    if ($resultb):
                        customFlash("admin/user/{$user_id}", "alert-info", "<b>OPSS:</b> Olá {$this->session->userdata('userlogin')['user_name']}. O CPF <b>{$data['user_document']}</b> ja está cadastrado na conta de outro usuário!");
                    else:
                        //  Verificar formato de CPF
                        if (checkCPF($data['user_document']) != true):
                            customFlash("admin/user/{$user_id}", "alert-info", "<b>OPSS:</b> Olá {$this->session->userdata('userlogin')['user_name']}. O CPF <b>{$data['user_document']}</b> informado não é valido!");
                        endif;

                        //  UPLOAD
                        if (!empty($_FILES['user_thumb']['name'])):
                            $id = $this->modeladmin->checkUser(["md5(user_id)" => $user_id], "user_id")[0]["user_id"];
                            $path = realpath(APPPATH . "../assets/uploads/users/");
                            $config["upload_path"] = $path;
                            $config["allowed_types"] = "gif|jpg|png";
                            $config["file_name"] = $id . "-" . checkName($data["user_name"] . $data["user_lastname"]) . "-" . time();
                            $config["max_size"] = 200;
                            $config["max_width"] = 600;
                            $config["max_height"] = 600;
                            $UserThumb = $this->modeladmin->checkUser(["user_id" => $id], "user_thumb")[0]["user_thumb"];
                            if (!empty($UserThumb)):
                                if (file_exists("{$path}/{$UserThumb}") && !is_dir("{$path}/{$UserThumb}")):
                                    unlink("{$path}/{$UserThumb}");
                                endif;
                            endif;
                            $this->load->library("upload", $config);
                            if (!$this->upload->do_upload("user_thumb")):
                                $error = "<b class='icon-image'>ERRO AO ENVIAR FOTO:</b> Olá {$this->session->userdata('userLogin')['user_name']}, selecione uma imagem JPG ou PNG para enviar como foto!<br> {$this->upload->display_errors()}";
                                customFlash("admin/user/{$user_id}", "alert-warning", $error);
                            else:
                                $filename = $this->upload->data();
                                $data["user_thumb"] = "users/{$filename["file_name"]}";
                            endif;
                        endif;

                        //  PASSWORD
                        if (!empty($data['user_password'])):
                            if (strlen($data['user_password']) >= 5):
                                $data['user_password'] = hash('sha512', $data['user_password']);
                            else:
                                customFlash("admin/user/{$user_id}", "alert-info", "<b>Erro de senha:</b> Olá {$this->session->userdata('userlogin')['user_name']}, a senha deve ter no mínimo 5 caracteres para ser redefinida!");
                            endif;
                        else:
                            unset($data['user_password']);
                        endif;

                        //  LEVEL
                        $ErrMessageCustomFlash = null;
                        if ($user_id == md5($this->session->userdata('userlogin')['user_id'])):
                            if ($data['user_level'] != $this->session->userdata('userlogin')['user_level']):
                                $ErrMessageCustomFlash = [
                                    "<b>PERFIL ATUALIZADO COM SUCESSO:</b> Olá {$this->session->userdata('userlogin')['user_name']}, seus dados foram atualizados com sucesso! <p class='icon-warning'>Seu nível de usuário não foi alterado pois não é permitido atualizar o próprio nível de acesso!</p>",
                                    "alert-success"
                                ];
                            else:
                                $ErrMessageCustomFlash = [
                                    "<b>PERFIL ATUALIZADO COM SUCESSO:</b> Olá {$this->session->userdata('userlogin')['user_name']}, seus dados foram atualizados com sucesso!",
                                    "alert-success"
                                ];
                            endif;
                            $SesseionRenew = true;
                            unset($data['user_level']);
                        elseif ($data['user_level'] > $this->session->userdata('userlogin')['user_level']):
                            $data['user_level'] = $this->session->userdata('userlogin')['user_level'];
                            $ErrMessageCustomFlash = [
                                "<b>TUDO CERTO:</b> Olá {$this->session->userdata('userlogin')['user_name']}. O usuário {$data['user_name']} {$data['user_lastname']} foi atualizado com sucesso!<p class='icon-warning'>Você não pode criar usuários com nível de acesso maior que o seu. Então o nível gravado foi " . getLevel($data['user_level']) . "!</p>",
                                "alert-success"
                            ];
                        else:
                            $ErrMessageCustomFlash = [
                                "<b>TUDO CERTO:</b> Olá {$this->session->userdata('userlogin')['user_name']}. O usuário {$data['user_name']} {$data['user_lastname']} foi atualizado com sucesso!",
                                "alert-success"
                            ];
                        endif;

                        $data['user_datebirth'] = (!empty($data['user_datebirth']) ? checkNascimento($data['user_datebirth']) : null);

                        //ATUALIZA USUÁRIO
                        $update = $this->modeladmin->editUser($user_id, $data);
                        if ($update):
                            if (!empty($SesseionRenew)):
                                $result_user = $this->modeladmin->checkUser(["md5(user_id)" => $user_id])[0];
                                if (!empty($result_user)):
                                    $this->session->set_userdata("userlogin", $result_user);
                                endif;
                            endif;
                            customFlash("admin/user/{$user_id}", $ErrMessageCustomFlash[1], $ErrMessageCustomFlash[0]);
                        else:
                            customFlash("admin/user/{$user_id}", "alert-info", "<p>ERROR AO ATUALIZAR:<p> desculpe mas, não foi possível atualizar informações de usuário!");
                        endif;

                    endif;

                endif;  // End check empty fields in form
            endif;  //  End check Isset user_id url
        endif;  //  End checkAdmin Session
    }

    #   USERS ADDRESS
    //  Cria endereço e redireciona para atualizar dados

    public function useraddress($user_id = null) {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:
            if ($user_id):
                $getResultUser = $this->modeladmin->checkUser(["md5(user_id)" => $user_id])[0];
                if (!empty($getResultUser)):

                    $NewAddress = ['user_id' => $getResultUser['user_id'], 'addr_name' => 'Novo Endereço'];
                    $AddressId = $this->modeladmin->addAddress($NewAddress);

                    if (!empty($AddressId)):
                        redirect("admin/address/" . md5($AddressId));
                    else:
                        customFlash("admin/users", "alert-info", "Não foi possível cadastrar o endereço");
                    endif;
                else:
                    customFlash("admin/users", "alert-info", "<b>OPPSS {$this->session->userdata("userlogin")['user_name']}</b>. você tentou editar um endereço que não existe ou que foi removido recentemente!");
                endif;
            else:
                customFlash("admin/users", "alert-info", "<b>OPPSS {$this->session->userdata("userlogin")['user_name']}</b>. você tentou editar um endereço que não existe ou que foi removido recentemente!");
            endif;
        endif;
    }

    //  Edita informações de endereço
    public function address($addr_id = null) {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:
            $data = [];
            if (!empty($addr_id)):
                $getResult = $this->modeladmin->checkAddress(["md5(addr_id)" => $addr_id])[0];
                if ($getResult):
                    $data['FormData'] = $getResult;
                    $getResultUser = $this->modeladmin->checkUser(["user_id" => $getResult['user_id']])[0];
                else:
                    customFlash("admin/users", "alert-info", "<b>OPPSS {$this->session->userdata("userlogin")['user_name']}</b>. você tentou editar um endereço que não existe ou que foi removido recentemente!");
                    exit;
                endif;
            else:
                customFlash("admin/users", "alert-info", "<b>OPPSS {$this->session->userdata("userlogin")['user_name']}</b>. você tentou editar um endereço que não existe ou que foi removido recentemente!");
            endif;


            $this->load->view("admin/inc/header");
            $this->load->view("admin/inc/css");
            $this->load->view("admin/inc/header_navigation");
            //$this->load->view("admin/inc/mainnav");
            $this->load->view("admin/users/address", $data);
            $this->load->view("admin/inc/footer");
            $this->load->view("admin/inc/js");

        endif;
    }

    //  Remove endereço
    public function addrremove($user_id, $addr_id) {
        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:
            if (empty($user_id) && empty($addr_id)):
                customFlash("admin/users", "alert-info", "<b>OPPPSSS</b> Você tentou excluir um endereço que não existe ou foi removido recentemente!");
            elseif (!empty($user_id) && empty($addr_id)):
                customFlash("admin/user/{$user_id}", "alert-info", "<b>OPPPSSS</b> Você tentou excluir um endereço que não existe ou foi removido recentemente!");
            else:
                $resultAddrRemove = $this->modeladmin->checkAddress(["md5(addr_id)" => $addr_id, "md5(user_id)" => $user_id])[0];
                if (!empty($resultAddrRemove)):
                    $remove = $this->modeladmin->addrRemove($resultAddrRemove["addr_id"]);
                    if (!empty($remove)):
                        customFlash("admin/user/{$user_id}", "alert-success", "<b>Tudo Certo</b><br> O endereço <b>{$resultAddrRemove["addr_name"]}</b> foi excluído com sucesso!");
                    else:
                        customFlash("admin/user/{$user_id}", "alert-error", "<b>ERROR AO DELETAR ENDEREÇO!</b>");
                    endif;
                else:
                    customFlash("admin/user/{$user_id}", "alert-info", "<b>OPPPSSS</b> Você tentou excluir um endereço que não existe ou foi removido recentemente!");
                endif;
            endif;
        endif;
    }

    //  Realiza cadastro e edição de endereço
    public function addrmanager($addr_id) {

        if (!checkAdmin()):
            customFlash("admin", "alert-info", "Sua sessão expirou. Por favor, logue-se novamente!");
        else:
            if (empty($addr_id)):
                customFlash("admin/users", "alert-info", "<b>OPPSS</b>Você tentou editar um usuário que não existe ou que foi removido recentemente");
            else:
                $data = $this->input->post();

                $result = $this->modeladmin->checkAddress(["md5(addr_id)" => $addr_id], "addr_id");
                if (empty($result)):
                    customFlash("admin/address/{$addr_id}", "alert-info", "<p>ERROR AO ATUALIZAR:<p> desculpe mas, não foi possível atualizar endereço de usuário!");
                else:
                    //ATUALIZA ENDEREÇO DE USUÁRIO
                    $update = $this->modeladmin->editAddress($addr_id, $data);
                    customFlash("admin/address/{$addr_id}", "alert-success", "<b>TUDO CERTO:</b><br> Endereço atualizado com sucesso!");
                endif;  // End check empty fields in form
            endif;  //  End check Isset user_id url
        endif;  //  End checkAdmin Session
    }

    #   CATEGORIES
    //  Listagem com paginação de categorias

    public function allCategory() {
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

        $config['base_url'] = site_url("admin/categories");
        $categories = $this->modeladmin->getCategories();

        $config['total_rows'] = $categories->num_rows();
        $config['per_page'] = 100;
        $config['uri_segment'] = 3;

        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3) ? $this->uri->segment(3) : 0);
        $data['allCategories'] = $this->modeladmin->getAllCategories($config['per_page'], $page);
    }

}

// End class Home Controller
