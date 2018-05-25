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
                <a href="<?= site_url("admin/slides/slide"); ?>" title="Adicionar Destaque" class="btn btn-outline-primary">Adicionar Destaque</a>
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
                            if (!empty($allSlides)):
                                foreach ($allSlides as $slide):
                                    extract($slide);                           
                                    ?>

                                    <div class="col-4">
                                        <article class="card o-hidden h-100">
                                            <header class="card-header">
                                                <h4 class="my-0">
                                                    <a target='_blank' href="<?= base_url("{$slide_link}"); ?>" title="<?= $slide_title; ?>"><?= $slide_title; ?>
                                                        <span class="float-right indicator <?=(($slide_status == 1) ? "text-success" : (empty($slide_status) ? "text-warning" : "text-primary" ))?> d-none d-lg-block">
                                                            <i class="fa fa-fw fa-circle"></i>
                                                        </span>
                                                    </a>
                                                </h4>
                                            </header>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <?php
                                                    $image = (!empty($slide_image) ? base_url("./assets/uploads/{$slide_image}") : null);
                                                    if (!empty($image)):
                                                        echo "<img src='{$image}' alt='{$slide_title}' title='{$slide_title}' class='img-fluid img-thumbnail'>";
                                                    else:
                                                        echo "<div class='card-body'><p class='card-text'>Imagem (Capa)</p></div>";
                                                    endif;
                                                    ?>
                                                </div>
                                                <p><b class="d-block">De <?= date('d/m/Y H\hi', strtotime($slide_start)) . " - " . ($slide_end ? date('d/m/Y H\hi', strtotime($slide_end)) : 'Sempre'); ?> :</b> 
                                                    <?= $slide_desc; ?></p>                                                         
                                            </div>
                                            <div class="card-footer small clearfix z-1 row">
                                                <div class="col">
                                                    <a  href="<?= site_url("admin/slides/slide/" . md5($slide_id)); ?>" title="Editar Destaque">
                                                        <span class="float-left">Editar</span>
                                                        <span class="float-right"><i class="fa fa-angle-right"></i></span>
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <a  href="<?= site_url("admin/slides/slide_delete/" . md5($slide_id)); ?>" title="Remover Destaque" class="text-danger">
                                                        <span class="float-left">Excluir</span>
                                                        <span class="float-right"><i class="fa fa-angle-right"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </article>
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
