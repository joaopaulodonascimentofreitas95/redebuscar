<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= site_url("admin"); ?>">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Serviço</li>
</ol>

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <span class="col-sm-8 btn text-left"><i class="fa fa-table"></i> Serviços</span>
            <span class="col-sm-4 text-right">
                <a href="<?= site_url("admin/services/service"); ?>" title="Adicionar Serviço" class="btn btn-outline-primary">Adicionar Serviço</a>
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
                    if (!empty($allServices)):
                        foreach ($allServices as $service):
                            ?>

                            <div class="col-4 mb-5">
                                <div class="card o-hidden h-100">
                                    <div class="card-header">
                                        <div class="card-body-icon"><i class="fa fa-fw <?= (!empty($service->service_icon) ? $service->service_icon : null); ?>"></i></div>
                                        <div class="mr-5"><?= $service->service_title; ?></div>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <?php
                                            $image_cover = (!empty($service->service_cover) ? base_url("./assets/uploads/{$service->service_cover}") : null);
                                            if (!empty($image_cover)):
                                                echo "<img src='{$image_cover}' alt='{$service->service_title}' title='{$service->service_title}' class='img-fluid img-thumbnail'>";
                                            else:
                                                echo "<div class='card-body'><p class='card-text'>Imagem (Capa)</p></div>";
                                            endif;
                                            ?>
                                        </div>

                                        <?= $service->service_description; ?>
                                    </div>
                                    <div class="card-footer small clearfix z-1 row">
                                        <div class="col">
                                            <a  href="<?= site_url("admin/services/service/" . md5($service->service_id)); ?>">
                                                <span class="float-left">Editar</span>
                                                <span class="float-right"><i class="fa fa-angle-right"></i></span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a  href="<?= site_url("admin/services/service_delete/" . md5($service->service_id)); ?>" class="text-danger">
                                                <span class="float-left">Excluir</span>
                                                <span class="float-right"><i class="fa fa-angle-right"></i></span>
                                            </a>
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
