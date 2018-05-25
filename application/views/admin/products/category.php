<?php
extract($FormData);
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="<?= site_url("admin/products/categories"); ?>">Categorias</a>
    </li>
    <li class="breadcrumb-item active">Adicionar/Editar Categorias</li>
</ol>

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <span class="col-sm-8 btn text-left"><i class="fa fa-table"></i> Categorias e Subcategorias de produtos</span>
            <span class="col-sm-4 text-right">
                <a class="btn btn-outline-primary" href="<?= site_url("admin/products/categories"); ?>" title=""">Ver Categorias</a>
                <a href="<?= site_url("admin/products/category"); ?>" title="" class="btn btn-outline-primary">Adicionar Categoria</a>
            </span>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <div class="panel panel-default">
                <div class="row d-flex col-12">
                    <div class="col-6">
                        <?= checkFlash(); ?>
                        <?= form_open_multipart(site_url("admin/products/categorymanager/" . md5($cat_id))); ?>
                        <div class="col">
                            <div class="form-group">
                                <label for="cat_cover">Imagem (Capa)</label>
                                <input name="cat_cover" type="file" class="form-control-file" id="cat_cover">
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="cat_title">Nome:</label>
                                <input name="cat_title" type="text" class="form-control" id="cat_title" value="<?= (!empty($cat_title) ? $cat_title : null); ?>" placeholder="Nome" required="required">
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="cat_parent">Setor:</label>    

                                <select name="cat_parent" class="form-control form-control" id="cat_parent">
                                    <option value="">Esse é um setor</option>
                                    <?php
                                    if (!empty($sectors)):
                                        foreach ($sectors as $sector):
                                            if ($Nivel <= $this->session->userdata('userlogin')['user_level']):
                                                echo "<option class='{$sector['cat_sizes']}'";
                                                if ($sector['cat_id'] == $cat_parent):
                                                    echo " selected='selected'";
                                                endif;
                                                echo " value='{$sector['cat_id']}'>&raquo;{$sector['cat_title']}</option>";
                                            endif;
                                        endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="cat_sizes">Tamanhos sepados por vírgula:</label>
                                <input name="cat_sizes" type="text" class="form-control" id="cat_sizes" value="<?= (!empty($cat_sizes) ? $cat_sizes : null); ?>" placeholder="Ex: P,M,G,GG" required="required">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <?= form_close(); ?>
                    </div>
                    <div class="col">
                        <div class="d-flex h-100 border text-center">
                            <div style="margin:auto;">
                                <?php
                                $image_cover = (!empty($cat_cover) ? base_url("assets/uploads/{$cat_cover}") : null);
                                if (!empty($image_cover)):
                                    echo "<img src='{$image_cover}' alt='{$cat_title}' title='{$cat_title}' class=''>";
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