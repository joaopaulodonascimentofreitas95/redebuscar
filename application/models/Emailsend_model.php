<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailsend_model extends CI_Model {
	public function __construct(){
		parent::__construct();
		// Carrega a library email
        $this->load->library('email');        
	}


    public  function sendEmailToClient(array $config, string $TemplateEmail, array $dados){
        // CONTENT MESSAGE SEND TO ClIENT
        $ToCliente = "
            <p style='font-size: 1.2em;'>Prezado(a) {$dados['user_name']},</p>
            <p><b>Obrigado por entrar em contato conosco.</b></p>
            <p>Este e-mail é para informar que recebemos sua mensagem, e que estaremos respondendo o mais breve possível.</p>
            <p><em>Atenciosamente " . SITE_NAME . ".</em></p>
        ";

        // Inicializa a library Email, passando os parâmetros de configuração
        $this->email->initialize($config);
        
        // Define remetente e destinatário
        $this->email->from(MAIL_USER, MAIL_SENDER); // Remetente
        $this->email->to($dados['user_email'],$dados['user_name']); // Destinatário
        // Define o assunto do email: $this->email->subject($dados['user_subject']);
        $this->email->subject("Recebemos sua mensagem!");        
        $this->email->message(str_replace("#mail_body#", $ToCliente, $TemplateEmail));
        if($this->email->send()):
            return true;
        else:
            return $this->email->print_debugger();
        endif;
    }

    public function sendEmailToAdmin(array $config, string $TemplateEmail, array $dados){
        //  CONTENT MESSAGE SEND TO ADMIN
        $ToAdmin = "
                <p>" . nl2br($dados['user_message']) . "</p>
                <p style='font-size: 0.9em;'>
                    Enviada por: {$dados['user_name']}<br>
                    Talefone: {$dados['user_phone']}<br>
                    E-mail: {$dados['user_email']}<br>
                    Dia: " . date('d/m/Y H\hi') . "
                </p>
            ";
            	// Inicializa a library Email, passando os parâmetros de configuração
        		$this->email->initialize($config);
                // Define remetente e destinatário
                $this->email->from($dados['user_email'],$dados['user_name']); // Remetente
                $this->email->to(MAIL_USER, MAIL_SENDER); // Destinatário
                // Define o assunto do email
                $this->email->subject("Nova mensagem do site!");                
                $this->email->message(str_replace("#mail_body#", $ToAdmin, $TemplateEmail));
             
                /*
                 * Se foi selecionado o envio de um anexo, insere o arquivo no email 
                 * através do método 'attach' da library 'Email'
                 */
                if(isset($dados['anexo']))
                    $this->email->attach('./assets/images/unici/logo.png');
         
                /*
                 * Se o envio foi feito com sucesso, define a mensagem de sucesso
                 * caso contrário define a mensagem de erro, e carrega a view home
                 */
                if ($this->email->send()) :
                    return true;
                else:
                    return $this->email->print_debugger();
                endif;
    }


}
