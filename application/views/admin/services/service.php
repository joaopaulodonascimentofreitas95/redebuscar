<?php
extract($FormData);
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= site_url("admin"); ?>">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="<?= site_url("admin/services"); ?>">Serviços</a>
    </li>
    <li class="breadcrumb-item active">Gerenciar Serviço</li>
</ol>

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <span class="col-sm-8 btn text-left"><i class="fa fa-table"></i> Gerenciar Serviço</span>
            <span class="col-sm-4 text-right">
                <a href="<?= site_url("admin/services"); ?>" title="" class="btn btn-outline-primary">Ver Serviços</a>
                <a href="<?= site_url("admin/services/service"); ?>" title="" class="btn btn-outline-primary">Adicionar Serviço</a>
            </span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="panel panel-default">                
                <div class="table-responsive">
                    <div class="col-12">                        
                        <div class="row">
                            <div class="col-9">
                                <?= checkFlash(); ?>
                                <?= form_open_multipart(site_url("admin/services/servicemanager/" . md5($service_id))); ?>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="service_cover">Imagem (Capa) <small class="text-info">Max: <?= IMAGE_BRAND_W; ?>px x <?= IMAGE_BRAND_H; ?>px</small></label>
                                            <input name="service_cover" type="file" class="form-control-file" id="service_cover">
                                        </div>
                                    </div>
                                    <div class="col">                                        
                                        <div class="form-group">                                            

                                            <label for="service_icon">Icone</label>
                                            <div>
                                                <select name="service_icon" class="form-control float-left" id="service_icon" style="max-width: 80%;">
                                                    <option value="">Selecione um ícone</option>
                                                    <?php
                                                    foreach (getIcon() as $icon):
                                                        echo "<option value='{$icon}'";
                                                        if ($icon == $service_icon):
                                                            echo "selected='selected'";
                                                        endif;
                                                        echo ">{$icon}</option>";
                                                    endforeach;
                                                    ?>
                                                </select>
                                                <div class="float-right text-center" style="max-width: 20%; width: 20%;">
                                                    <div id="service_icon_show">
                                                        <?=(!empty($service_icon) ? '<i  class="fa-2x fa '.$service_icon.'"></i>' : '<i  class="fa-2x fa fa-glass"></i>')?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="service_title">Nome:</label>
                                            <input name="service_title" type="text" class="form-control" id="service_title" value="<?= (!empty($service_title) ? $service_title : null); ?>" placeholder="Nome do Fabricante" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="service_description">Descrição:</label>
                                            <textarea name="service_description" class="form-control" placeholder="Descrição do Serviço"><?= (!empty($service_description) ? $service_description : null); ?></textarea>
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
                            <div class="col-3">
                                <?php
                                $image_cover = (!empty($service_cover) ? base_url("assets/uploads/{$service_cover}") : null);
                                if (!empty($image_cover)):
                                    echo "<img src='{$image_cover}' alt='{$service_title}' title='{$service_title}' class='img-fluid img-thumbnail'>";
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