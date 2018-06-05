<style>
    .phone{color:#F50000; font-weight:bold;}
</style>
<section class="contact" id="contact" style="background-color:#25375C;">
    <div class="container">
        <div class="row">
            <header class="section_header col-lg-12 text-center">
                <h1 class="section-heading text-uppercase">Fale com à <?=SITE_NAME;?></h1>
                <p class="section-subheading text-muted">Dúvidas, Críticas ou Sugestões? Estamos aguardando seu contato!</p>
                <h3 class="phone">85.3046.1100 / 85.9.9199.5058</h3>
            </header>
        </div>


        <?php

            $dataInput = array(
                "name" => array(
                    "class" => "form-control",
                    "id" => "user_name",
                    "name" => "user_name",
                    "placeholder" => "Seu nome *",
//                    "required" => "required",
                    "value" => set_value('user_name')
                ),
                "email" => array(
                    "class" => "form-control",
                    "id" => "user_email",
                    "name"=>"user_email",
                    "placeholder" => "Seu e-mail *",
//                    "required" => "required"
                ),
                "phone" => array(
                    "class" => "form-control",
                    "id" => "user_phone",
                    "name" => "user_phone",
                    "placeholder" => "Seu telefone *",
//                    "required" => "required",
                    "type" => "tel"
                ),
                "message" => array(
                    "class" => "form-control",
                    "id" => "user_message",
                    "name" => "user_message",
                    "placeholder" => "Seu mensage *",
//                    "required" => "required",
                )
            );
        ?>


        <div class="row">
            <div class="col-lg-12">
                <div class="wc_contact_error jwc_contact_error"></div>
            <?php
                $data_form_open = array("name" => "sentMessage");
                echo form_open(null, $data_form_open);

                echo '<div class="row">';
                    echo '<div class="col-md-6">';
                        echo '<div class="form-group">';
                            echo form_input($dataInput["name"]);
                            echo '<p class="help-block text-danger"></p>';
                        echo '</div>';
                        echo '<div class="form-group">';
                            echo form_input($dataInput["email"]);
                        echo '</div>';
                        echo '<div class="form-group">';
                            echo form_input($dataInput["phone"]);
                        echo '</div>';
                        echo '<div class="form-group">';
                            echo form_textarea($dataInput["message"]);
                        echo '</div>';
                        echo '<div class="col-lg-12 text-center">';
                            echo '<div id="success"></div>';
                            echo '<button id="sendMessageButton" class="btn btn-primary text-uppercase" type="submit">Enviar Mensagem';
                            echo '<img class="img_load" src="'.base_url('assets/images/load.svg').'" alt="Aguarde, enviando contato!" title="Aguarde, enviando contato!"/>';
                            echo '</button>';
                        echo '</div>';
                    echo '</div>';

                    echo '<div class="col-md-6">';
                        echo '<img style="max-height:600px;" src="'.base_url('assets/images/banner-site-tele-entrega.png').'" alt="BusCar Auto Peças" title="BusCar Auto Peças"/>';
                    echo '</div>';
                echo '</div>';
                echo form_close();
            ?>
            </div>
        </div>

    </div>
</section>

<script>
        $(function(){

            $("form[name='sentMessage']").submit(function() {
                console.log("Clicou em enviar!");
                var WcForm = $(this);

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '<?=base_url('ajax/sendcontact');?>',
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend(){
                        console.log("Iniciando o envio");
                        WcForm.find('.img_load').fadeIn(200);
                    },
                    success(data){
                        WcForm.find('.img_load').fadeOut(200);

                        if (data.wc_contact_error) {
                            $('.jwc_contact_error').html(data.wc_contact_error).fadeIn();
                        }else {
                            $('.jwc_contact_error').fadeOut();
                        }

                        if (data.wc_send_mail) {
                            $('.jwc_contact_error').html(data.wc_send_mail).fadeIn();
                            WcForm.trigger('reset');
                        } else {
                            $('.jwc_contact_error').fadeOut();
                        }


                    }
                });

                return false;
            });



        });
</script>