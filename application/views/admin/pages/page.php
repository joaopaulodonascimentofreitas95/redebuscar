<?php
extract($FormData);
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= site_url("admin"); ?>">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="<?= site_url("admin/páginas"); ?>">Páginas</a>
    </li>
    <li class="breadcrumb-item active">Gerenciar Página</li>
</ol>


<!--MODAL UPLOAD IMAGES TINYMCE-->

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <span class="col-sm-8 btn text-left"><i class="fa fa-file-text"></i> Gerenciar Página</span>
            <span class="col-sm-4 text-right">
                <a href="<?= site_url("admin/pages"); ?>" title="" class="btn btn-outline-primary">Ver Páginas</a>
                <a href="<?= site_url("admin/pages/page"); ?>" title="" class="btn btn-outline-primary">Adicionar Página</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="panel panel-default">                
                <div class="table-responsive">

                    <?= checkFlash(); ?>
                    <?= form_open_multipart(site_url("admin/pages/pagemanager/" . md5($page_id))); ?>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-7">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="page_cover">Imagem (Capa) <small class="text-info">Max: <?= IMAGE_W; ?>px x <?= IMAGE_H; ?>px</small></label>
                                            <input name="page_cover" type="file" class="form-control-file" id="page_cover">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="page_title">Título:</label>
                                            <input name="page_title" type="text" class="form-control" id="page_title" value="<?= (!empty($page_title) ? $page_title : null); ?>" placeholder="Título da Página" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="page_subtitle">Descrição:</label>
                                            <textarea id="page_subtitle" name="page_subtitle" class="form-control" placeholder="Sobre a Página"><?= (!empty($page_subtitle) ? $page_subtitle : null); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="page_content">Descrição:</label>
                                            <textarea name="page_content" class="form-control" placeholder="Conteúdo"><?= (!empty($page_content) ? $page_content : null); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="page_name">Link Alternativo (Opicional):</label>
                                            <input name="page_name" type="text" class="form-control" id="page_name" value="<?= (!empty($page_name) ? $page_name : null); ?>" placeholder="Link Alternativo">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Ativar Exibição de Página</label> 
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="radio">
                                                        <input type="radio" name="page_status" id="optionsRadios1" value="0" <?= ((!empty($page_status) && ($page_status == '0')) ? "checked='checked'" : null); ?>>  Não <span class="fa fa-square"></span>
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="radio">
                                                        <input type="radio" name="page_status" id="optionsRadios2" value="1" <?= ((!empty($page_status) && ($page_status == '1')) ? "checked='checked'" : null); ?>>  Sim <span class="fa fa-check"></span>
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
                            </div>
                            <div class="col-5">
                                <div class="row">
                                    <div class="card">
                                    <?php
                                    $image = (!empty($page_cover) ? base_url("assets/uploads/{$page_cover}") : null);
                                    if (!empty($image)):
                                        echo "<img src='{$image}' alt='{$page_title}' title='{$page_title}' class='img-fluid img-thumbnail'>";
                                    else:
                                        echo "<div class='card-body'><p class='card-text'>Imagem (Capa)</p></div>";
                                    endif;
                                    ?>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


