<?php
extract($FormData);
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= site_url("admin"); ?>">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="<?= site_url("admin/slides"); ?>">Slides</a>
    </li>
    <li class="breadcrumb-item active">Gerenciar Destaque</li>
</ol>

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <span class="col-sm-8 btn text-left"><i class="fa fa-table"></i> Gerenciar Destaque</span>
            <span class="col-sm-4 text-right">
                <a href="<?= site_url("admin/slides"); ?>" title="" class="btn btn-outline-primary">Ver Destaques</a>
                <a href="<?= site_url("admin/slides/slide"); ?>" title="" class="btn btn-outline-primary">Adicionar Destaque</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="panel panel-default">                
                <div class="table-responsive">
                    <div class="col-12">                        
                        <div class="row">
                            <div class="col-8">                                
                                <?= checkFlash(); ?>
                                <?= form_open_multipart(site_url("admin/slides/slidemanager/" . md5($slide_id))); ?>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="slide_image">Imagem (Capa) <small class="text-info">Max: <?= IMAGE_W; ?>px x <?= IMAGE_H; ?>px</small></label>
                                            <input name="slide_image" type="file" class="form-control-file" id="slide_image">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="slide_title">Título:</label>
                                            <input name="slide_title" type="text" class="form-control" id="slide_title" value="<?= (!empty($slide_title) ? $slide_title : null); ?>" placeholder="Nome do Fabricante" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="slide_desc">Descrição:</label>
                                            <textarea name="slide_desc" class="form-control" placeholder="Descrição do Slide"><?= (!empty($slide_desc) ? $slide_desc : null); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="slide_link">Link:</label>
                                            <input name="slide_link" type="text" class="form-control" id="slide_link" value="<?= (!empty($slide_link) ? $slide_link : null); ?>" placeholder="link" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="slide_start">A partir de <small>(Opicional)</small>:</label>
                                            <input id="slide_start" type="text" class="form-control formTime" name="slide_start" value="<?= (!empty($slide_start) ? date('d/m/Y H:i:s', strtotime($slide_start)) : date('d/m/Y H:i:s')); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="slide_end">Até dia <small>(Opicional)</small>:</label>
                                            <input id="slide_end" type="text" class="form-control formTime" name="slide_end" value="<?= (!empty($slide_end) ? date('d/m/Y H:i:s', strtotime($slide_end)) : null); ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Ativar Exibição de Destaques</label> 
                                            <div class="row">
                                            <div class="col-6">
                                                <label class="radio">
                                                    <input type="radio" name="slide_status" id="optionsRadios1" value="0" <?=((!empty($slide_status) && ($slide_status == '0')) ? "checked='checked'": null);?>>  Não <span class="fa fa-square"></span>
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <label class="radio">
                                                    <input type="radio" name="slide_status" id="optionsRadios2" value="1" <?=((!empty($slide_status) && ($slide_status == '1')) ? "checked='checked'": null);?>>  Sim <span class="fa fa-check"></span>
                                                </label>
                                            </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </div>
                                <?= form_close(); ?>
                            </div>
                            <div class="col-4">
                                <?php
                                $image = (!empty($slide_image) ? base_url("assets/uploads/{$slide_image}") : null);
                                if (!empty($image)):
                                    echo "<img src='{$image}' alt='{$slide_title}' title='{$slide_title}' class='img-fluid img-thumbnail'>";
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