
<!--BRANDS-->
<div class="py-5 bg-light">
    <div class="container">
        <section>
            <header class="d-none">        
                <h1 >Grandes marcas para te ajudar.</h1>
            </header>
            <div class="marcas_slide">
                <?php
                if (!empty($brands)):
                    foreach ($brands as $brand):
                        extract($brand);
                        echo ""
                        . "<article style='padding:0px 10px;'>"
                        . "<a href='#' title='{$brand_title} " . SITE_NAME . "'>"
                        . "<h2 class='d-none'>{$brand_title}</h2>"
                        . "<img src='" . base_url("tim.php?src=assets/uploads/{$brand_cover}&w=100&h=100") . "' title='" . SITE_NAME . "' alt='[" . SITE_NAME . "]'>"
                        . "</a>"
                        . "</article>";
                    endforeach;
                endif;
                ?>
            </div>
        </section>
        <hr>

        <section>
            <header style="padding-bottom:20px;" class="text-center">
                <h2 class="text_red_buscar" style="font-weight: bold;font-size: 1.2em;">Encontre a loja mais próxima</h2>
            </header>
            <div class="row">
                <article class="address_box col-md-4">
                    <div class="text-center" style="display:block; width:100%;">
                        <img style="max-width:200px;" src="<?=base_url("assets/images/buscar.png");?>" alt="Buscar Autopeças" title="Buscar Autopeças">
                    </div>
                    
                    <h2 class="my-4 text-uppercase text_blue_buscar"><i class="fa fa-map-marker text_red_buscar"></i> <?=BUS_A_NAME;?></h2>
                    <address>
                        <b>Endereço:</b> <?=BUS_A_ADDR;?><br>
                        <b>Bairro:</b> <?=BUS_A_DISTRICT;?><br>
                        <b>Telefone:</b> <?=BUS_A_PHONE_A;?>/<?=BUS_A_PHONE_B;?><br>
                        <b>Email:</b> <?=BUS_A_EMAIL;?></address>
                </article>
                <article class="address_box col-md-4">
                    <div class="text-center" style="display:block; width:100%;">
                         <img style="max-width:200px;"src="<?=base_url("assets/images/du-ar.png");?>" alt="<?=BUS_B_NAME;?>" title="<?=BUS_B_NAME;?>"/>
                    </div>
                    <h2 class="my-4 text-uppercase text_blue_buscar"><i class="fa fa-map-marker text_red_buscar"></i> <?=BUS_B_NAME;?></h2>
                    <address>
                       <b>Endereço:</b> <?=BUS_B_ADDR;?><br>
                        <b>Bairro:</b> <?=BUS_B_DISTRICT;?><br>
                        <b>Telefone:</b> <?=BUS_B_PHONE_A;?>/<?=BUS_B_PHONE_B;?><br>
                        <b>Email:</b> <?=BUS_B_EMAIL;?></address>
                </article>
                <article class=" address_box col-md-4">
                    <div class="text-center" style="display:block; width:100%;">
                    <img style="max-width:200px;" src="<?=base_url("assets/images/center-ar.png");?>" alt="<?=BUS_C_NAME;?>" title="<?=BUS_C_NAME;?>"/>
                    </div>
                    <h2 class="my-4 text-uppercase text_blue_buscar"><i class="fa fa-map-marker text_red_buscar"></i> <?=BUS_C_NAME;?></h2>
                    <address>
                       <b>Endereço:</b> <?=BUS_C_ADDR;?><br>
                        <b>Bairro:</b> <?=BUS_C_DISTRICT;?><br>
                        <b>Telefone:</b> <?=BUS_C_PHONE_A;?><br>
                        <b>Email:</b> <?=BUS_C_EMAIL;?></address>                          
                </article>
            </div>
        </section>

    </div>
</div>
<!-- /.container -->