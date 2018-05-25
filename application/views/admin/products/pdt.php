<?php
extract($FormData)
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="<?= site_url("admin/products"); ?>">Produtos</a>
    </li>
    <li class="breadcrumb-item active">Adicionar/Editar Produto</li>
</ol>

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <span class="col-sm-8 btn text-left"><i class="fa fa-table"></i> Gerenciar: <?= (!empty($pdt_title) ? $pdt_title : null); ?></span>
            <span class="col-sm-4 text-right">
                <a class="btn btn-outline-primary" href="<?= site_url("admin/products"); ?>" title=""">Ver Produtos</a>
                <a href="<?= site_url("admin/products/pdt"); ?>" title="" class="btn btn-outline-primary">Adicionar Produto</a>
            </span>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <div class="panel panel-default">
                <?= checkFlash(); ?>
                <?= form_open_multipart(site_url("admin/products/pdtmanager/" . md5($pdt_id))); ?>
                <div class="row col-12">
                    <div class="col-8">
                        <div class="col">
                            <div class="form-group">
                                <label for="pdt_cover">Imagem (Capa)</label>
                                <input name="pdt_cover" type="file" class="form-control-file" id="pdt_cover">
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="pdt_title">Produto</label>
                                <input name="pdt_title" type="text" placeholder="Nome do produto" value="<?= (!empty($pdt_title) ? $pdt_title : null); ?>" class="form-control" id="pdt_title">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pdt_subtitle">Produto</label>
                                <textarea id="pdt_subtitle" class="form-control" name="pdt_subtitle" placeholder="Breve descrição"><?= (!empty($pdt_subtitle) ? $pdt_subtitle : null); ?></textarea>
                            </div>
                        </div>

                        <!--LINK ALTERNATIVO-->

                        <div class="col">
                            <div class="form-group">
                                <label for="pdt_code">Código</label>
                                <input id="pdt_code" class="form-control" type="text" name="pdt_code" value="<?= ($pdt_code ? $pdt_code : str_pad($pdt_id, 4, 0, STR_PAD_LEFT)); ?>"/>                       
                            </div>
                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="pdt_brand">Marca/Fabricante</label>
                                        <?php
                                        $readBrands = $this->modelproducts->ExeRead(DB_PDT_BRANDS, null, null, ["brand_title" => "ASC"]);
                                        if (empty($readBrands)):
                                            echo "<div class='alert alert-info fa fa-warning'>  Cadastre algumas marcas ou fabricantes antes de começar!</div>";
                                        else:
                                                echo "<select name='pdt_brand' class='form-control' id='pdt_brand' required>";
                                                echo "<option value=''>Selecione um Fabricante</option>";
                                                foreach ($readBrands as $Brand):
                                                    echo "<option";
                                                    if ($pdt_brand == $Brand['brand_id']):
                                                        echo " selected='selected'";
                                                    endif;
                                                    echo " value='{$Brand['brand_id']}'>{$Brand['brand_title']}</option>";
                                                endforeach;
//
                                                echo "</select>";
                                        endif;
                                        ?>



                                    </div>
                                </div>


                                <div class="col">
                                    <div class="form-group">
                                        <label for="cat_parent">Categoria:</label>   
                                        <?php
                                        $CatParent = $this->modelproducts->ExeRead(DB_PDT_CATS, ["cat_parent" => null], "*", ["cat_title" => "ASC"]);
                                        if (empty($CatParent)):
                                            echo "<div class='alert alert-info fa fa-warning'>  Cadastre algumas categorias de produtos antes de começar!</div>";
                                        else:
                                            echo "<select name='pdt_subcategory' class='form-control' id='cat_parent'>";
                                            echo "<option value=''>Selecione uma categoria</option>";
                                            foreach ($CatParent as $cat):
                                                echo "<option disabled='disabled' value='{$cat["cat_id"]}'>{$cat["cat_title"]}</option>";
                                                $CatSub = $this->modelproducts->ExeRead(DB_PDT_CATS, ["cat_parent" => $cat["cat_id"]], "*", ["cat_title" => "ASC"]);
                                                if (empty($CatSub)):
                                                    echo "<option disabled='disabled' value=''>&raquo;&raquo; Cadastre uma categoria nessa sessão</option>";
                                                else:
                                                    foreach ($CatSub as $SubCat):
                                                        echo "<option";
                                                        if ($pdt_subcategory == $SubCat['cat_id']):
                                                            echo " selected='selected'";
                                                        endif;
                                                        echo " value='{$SubCat['cat_id']}'>&raquo;&raquo; {$SubCat['cat_title']}</option>";
                                                    endforeach;
                                                endif;
                                            endforeach;
                                            echo "</select>";
                                        endif;
                                        ?>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="pdt_content">Descrição completa</label>
                                <textarea id="pdt_content" class="form-control" name="pdt_content" placeholder="Descrição completa"><?= (!empty($pdt_content) ? $pdt_content : null); ?></textarea>
                            </div>
                        </div>


                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="pdt_price">Preço R$(1.000,00)</label>
                                        <input id="pdt_price" class="form-control" type="text" name="pdt_price" value="<?= $pdt_price ? number_format($pdt_price, '2', ',', '.') : "0,00"; ?>"/>                            
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="pdt_inventory">Estoque</label>
                                        <input id="pdt_inventory" class="form-control" type="number" name="pdt_inventory" placeholder="Quantidade em Estoque" value="<?= (!empty($pdt_inventory) ? number_format($pdt_inventory, '2', ',', '.') : "0,00"); ?>"/>                                    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="col">DIMENSÕES DO PRODUTO: <hr></h4>
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="pdt_dimension_heigth">Altura em Centímetros</label>
                                        <input id="pdt_dimension_heigth" class="form-control" type="number" placeholder="Altura em centímetros" name="pdt_dimension_heigth" value="<?= (!empty($pdt_dimension_heigth) ? $pdt_dimension_heigth : null); ?>"/>                            
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="pdt_dimension_width">Largura em Centímetros</label>
                                        <input id="pdt_dimension_width" class="form-control" type="number" name="pdt_dimension_width" placeholder="Largura em centímetros" value="<?= (!empty($pdt_dimension_width) ? $pdt_dimension_width : null); ?>"/>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="pdt_dimension_heigth">Profundidade em Centímetros</label>
                                        <input id="pdt_dimension_depth" class="form-control" type="number" placeholder="Profundidade em centímetros" name="pdt_dimension_depth" value="<?= (!empty($pdt_dimension_depth) ? $pdt_dimension_depth : null); ?>"/>                            
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label for="pdt_dimension_width">Peso em Gramas</label>
                                        <input id="pdt_dimension_weight" class="form-control" type="number" name="pdt_dimension_weight" placeholder="Peso em Gramas" value="<?= (!empty($pdt_dimension_weight) ? $pdt_dimension_weight : null); ?>"/>                                    
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-4">
                        <div class="col">
                            <div class="card">
                                <?php
                                $pdt_cover = (!empty($pdt_cover) ? base_url("assets/uploads/{$pdt_cover}") : null);
                                if (!empty($pdt_cover)):
                                    echo "<img src='{$pdt_cover}' alt='{$pdt_title}' title='{$pdt_title}' class='img-fluid img-thumbnail'>";
                                else:
                                    echo "<div class='card-body'><p class='card-text'>Imagem (Capa)</p></div>";
                                endif;
                                ?>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pdt_offer_price">Promoção: R$(860,00)</label>
                                <input id="pdt_offer_price" class="form-control" type="text" name="pdt_offer_price" value="<?= (!empty($pdt_offer_price) ? number_format($pdt_offer_price, '2', ',', '.') : "0,00"); ?>"/>                            
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pdt_offer_start">Inicio da Promoção:</label>
                                <input id="pdt_offer_start" class="form-control formTime" type="text" name="pdt_offer_start" value="<?= (!empty($pdt_offer_start) ? date("d/m/Y H:i", strtotime($pdt_offer_start)) : null); ?>"/>                            
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pdt_offer_end">Final da Promoção:</label>
                                <input id="pdt_offer_end" class="form-control formTime" type="text" name="pdt_offer_end" value="<?= (!empty($pdt_offer_end) ? date("d/m/Y H:i", strtotime($pdt_offer_end)) : null); ?>"/>                            
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pdt_hotlink">Hotsite (opicional):</label>
                                <input id="pdt_hotlink" class="form-control" type="url" name="pdt_hotlink" value="<?= (!empty($pdt_hotlink) ? $pdt_hotlink : null); ?>"/>                            
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Ativar Exibição deste produto?</label> 
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-control radio">
                                            <input type="radio" name="pdt_status" id="optionsRadios1" value="0" <?= ((!empty($pdt_status) && ($pdt_status == '0')) ? "checked='checked'" : null); ?>>  Não
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-control radio">
                                            <input type="radio" name="pdt_status" id="optionsRadios2" value="1" <?= ((!empty($pdt_status) && ($pdt_status == '1')) ? "checked='checked'" : null); ?>>  Sim
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <button class="w-100 btn btn-primary">SALVAR ALTERAÇÕES</button>
                        </div>
                    </div>
                </div>
                <?= form_close(); ?>

            </div>
        </div>
    </div>
</div>
</div>

