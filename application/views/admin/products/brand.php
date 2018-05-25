<?php
extract($FormData);
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= site_url("admin");?>">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="<?=site_url("admin/products/brands");?>">Fabricantes</a>
    </li>
    <li class="breadcrumb-item active">Fabricantes</li>
</ol>

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <span class="col-sm-8 btn text-left"><i class="fa fa-table"></i> Gerenciar Marca/Fabricante</span>
            <span class="col-sm-4 text-right">
                <a href="<?= site_url("admin/products/brands"); ?>" title="" class="btn btn-outline-primary">Ver Fabricante</a>
                <a href="<?= site_url("admin/products/brand"); ?>" title="" class="btn btn-outline-primary">Adicionar Fabricante</a>
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
                            <div class="col-9">
                                <?= form_open_multipart(site_url("admin/products/brandmanager/" . md5($brand_id))); ?>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="brand_cover">Imagem (Capa) <small class="text-info">Max: <?= IMAGE_BRAND_W; ?>px x <?= IMAGE_BRAND_H; ?>px</small></label>
                                        <input name="brand_cover" type="file" class="form-control-file" id="brand_cover">
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="brand_title">Marca/Fabricante:</label>
                                        <input name="brand_title" type="text" class="form-control" id="brand_title" value="<?= (!empty($brand_title) ? $brand_title : null); ?>" placeholder="Nome do Fabricante" required="required">
                                    </div>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                            <div class="col-3">
                                <?php
                                $image_cover = (!empty($brand_cover) ? base_url("assets/uploads/{$brand_cover}") : null);
                                if (!empty($image_cover)):
                                    echo "<img src='{$image_cover}' alt='{$brand_title}' title='{$brand_title}' class='img-fluid img-thumbnail'>";
                                else:
                                    echo "<div class='card-body'><p class='card-text'>Imagem (Capa)</p></div>";
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>