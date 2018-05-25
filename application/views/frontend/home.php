<!--SLIDES-->
<article>
    <header>
        <h1 class="d-none">Últimas Novidades <?= SITE_NAME; ?></h1>
    </header>
    
    <div class="single-item" style="background:#000; padding:0px; position:relative">
        <?php
                $slide_count = 0;
                foreach ($slides["slides"] as $slide):
                    extract($slide);
                    $slide_count++;
                    $SlideLink = (strstr($slide_link, 'http') ? $slide_link : site_url("{$slide_link}"));
                    $SlideTarget = (strstr($slide_link, 'http') ? ("target='_blank'") : null);
                ?>            
                    <div><img src="<?= base_url("tim.php?src=assets/uploads/{$slide_image}&w=1600"); ?>" title="<?=$slide_title;?>" alt="<?=$slide_title;?>"/></div>
                    <?php
                    endforeach;
                ?>    
    </div>
    
</article>

<!-- ABOUT Section -->
<div class="container">
    <article class="row my-4" style="padding:50px 0;">
        <div class="col-lg-6">
            <h2>Conheça a <b class="text_red_buscar">BusCar Autopeças</b></h2>
            <p>Com vários anos de estrada dedicados ao ar-condicionado automotivo, a BusCar vem fazendo a diferença no estado do Ceará.</p> 
            <p>Seja linha leve e pesada (ônibus, caminhão, trem, metrô), Vans ou carros de passeio, temos soluções eficientes que se encaixam perfeitamente na sua empresa. </p>
            <p>Isso sem contar no atendimento especializado de quem  é especialista no assunto e possui certificado das melhores marcas do mundo.</p>
            
            
            <div class="text-center">
                <a title="Conheça um pouco mais sobre a BusCar!" href="<?=site_url("quem-somos")?>" class="btn btn-outline-primary">Saiba Mais!</a>
            </div>
        </div>
        
        <div class="col-lg-6 bio_img">
             <div class="empresa_slide">
                <div><img src="<?= base_url("tim.php?src=assets/images/banner_site_mini_01.jpg&w=650&h=450"); ?>" title="BusCar Auto Peças" alt="[BusCar Auto Peças]"/></div>
                <div><img src="<?= base_url("tim.php?src=assets/images/banner_site_mini_02.jpg&w=650&h=450"); ?>" title="BusCar Auto Peças" alt="[BusCar Auto Peças]"/></div>
            </div>
        </div>
            
        </div>
    </article>
    <!-- /.row -->
</div>
<!-- /.container -->

<div class="container-marcas" style="width:100%; background-color:#8D8C93;">
    <div class="container">
    <h1 style="display:none;">As maiores marcas estão na Buscar Autopeças!</h1>
    <img src="<?=base_url("assets/images/marcas-buscar.png");?>" alt="As maiores marcas estão na BusCar Autopeças" title="As maiores marcas estão na BusCar Autopeças"/>
    </div>
</div>


<!-- Page Content -->
<section class="container">
    <header  class="my-4 text-center">
        <h1>Produtos de alta qualidade</h1>
        <p class="tagline">Qualidade e enorme variação de produtos para lhe atender!</p>
    </header>

    <div class="produtos_slide">
            <?php
        if (!empty($pdt_categories)):
            //var_dump($pdt_categories);
            
            $slide_count = 0;
            foreach ($pdt_categories as $pdtcat):
                extract($pdtcat);
                $slide_count++;
                ?>
                <div>
                    <div class="text-center" style="padding:10px;">
                        <a href="#" title="<?=$cat_title;?>">
                            <img style="width:100%;" title="<?=$cat_title;?>" alt="[<?=$cat_title;?>]" src="<?= base_url("tim.php?src=assets/uploads/{$cat_cover}&w=400&h=400"); ?>" alt="<?= $cat_title; ?>" title="<?= $cat_title; ?>">
                        </a>
                        <div class="card-body" style="display:none;">
                            <h4 class="my-0"><a class="text_red_buscar" href="<?=site_url("produtos/{$cat_name}");?>" title="<?=$cat_title;?>"><?= $cat_title; ?></a></h4>
                        </div>
                    </div>
                </div>
        
                <?php
            endforeach;
        endif;
        ?>    
    </div>
    <div style="padding:20px 0;"></div>
</section>
