<article class="single_page">
    <!--<div class="container">-->
    <header class="page-heading">
        <div class="container text-uppercase">
            <h1>Serviços <?= SITE_NAME; ?></h1>
            <p class="tagline">Um conjunto de serviços exclusívos aplicados por profissionais capacidados.</p>
        </div>
    </header>
    <!--BREADCRUMBS-->
    <div class="full-width breadcrumb" style="margin-bottom: 0;">
        <div class="container">
            <ol class="breadcrumb" style="margin-bottom: 0;">
                <li class="breadcrumb-item">
                    <a href="<?= site_url(); ?>"><?= SITE_NAME; ?></a>
                </li>
                <li class="breadcrumb-item active">Serviços</li>
            </ol>
        </div>
    </div>
    <div class="bg_blue_buscar main_services">

        <div class="container">
            <div class="row text-center my-5">
                <?php
//var_dump($services);
                if (!empty($services)):
                    foreach ($services as $service):
                        extract($service);
                        $icon = (!empty($service_icon) ? "<span class='fa-stack fa-2x'><i class='fa fa-circle fa-stack-2x text_red_buscar'></i><i class='fa {$service_icon} fa-stack-1x fa-inverse'></i></span>" : null);
                        echo "<article class='col-sm-4 mb-4'>"                        
                        . "{$icon}"
                        . "<h6 class='service-heading text-white text-uppercase'>{$service_title}</h6>"
                        . "<p class='text-white'>{$service_description}</p>"
                        . "</article>";
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>
</article>