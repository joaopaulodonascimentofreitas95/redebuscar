<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= site_url("admin"); ?>">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Serviço</li>
</ol>

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <span class="col-sm-8 btn text-left"><i class="fa fa-table"></i> Destaques</span>
            <span class="col-sm-4 text-right">
                <a href="<?= site_url("admin/pages/slide"); ?>" title="Adicionar Destaque" class="btn btn-outline-primary">Adicionar Destaque</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="panel panel-default">
                <?= checkFlash(); ?>
                <div class="table-responsive">
                    <div class="col-12">
                        <div class="row">
                            <?php
                            if (!empty($pages)):
                                foreach ($pages as $page):
                                    extract($page);
                                    $page_status = "<p class='small indicator " . (($page_status == 1) ? "text-success" : "text-primary" ) . " d-none d-lg-block'><i class='fa fa-fw fa-circle'></i> ".($page_status == 1 ? "Publicada" : "Rascunho")."</p>";
                                    ?>

                                    <div class="col-lg-4 col-sm-6 portfolio-item">
                                        <div class="card h-100">
                                            <a href="#"><img class="card-img-top" src="<?= base_url("assets/uploads/{$page_cover}") ?>" alt="[<?= $page_title; ?>]"></a>
                                            <div class="card-body">
                                                <h4 class="card-title">
                                                   <a class="col" target="_blank" href="<?= site_url("empresa/{$page_name}"); ?>"><?=$page_title;?></a>
                                                </h4>
                                                <span><?= $page_status; ?></span>
                                                <p class="card-text"><?= $page_subtitle; ?></p>
                                            </div>
                                            <div class="card-footer text-center">
                                                <div class="row">
                                                    <a class="col" target="_blank" href="<?= site_url("empresa/{$page_name}"); ?>">Ver no site</a>
                                                    <a class="col" href="<?= site_url("admin/pages/page/" . md5($page_id)); ?>">Editar</a>
                                                    <a class="col" href="<?= site_url("admin/pages/delete_page/" . md5($page_id)); ?>">Excluir</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--//Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>-->
