<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Produtos</li>
</ol>

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <span class="col-sm-10 btn text-left"><i class="fa fa-table"></i> Listagem de Produtos</span>
            <span class="col-sm-2 text-right"><a href="<?= site_url("admin/products/pdt"); ?>" title="" class="btn btn-outline-primary">Adicionar Produto</a></span>
        </div>
    </div>
    <div class="card-body">
         <div class="table-responsive">
        <?= checkFlash(); ?>
        <?php
        if (!empty($products)):
            foreach ($products as $pdt):
                extract($pdt);
                // $PdtImage = ($pdt_cover && file_exists("../uploads/{$pdt_cover}") && !is_dir("../uploads/{$pdt_cover}") ? "uploads/{$pdt_cover}" : 'admin/_img/no_image.jpg');
                $PdtTitle = ($pdt_title ? checkChars($pdt_title, 45) : 'Edite este produto para coloca-lo a venda!');
                $PdtCode = ($pdt_code ? $pdt_code : 'indefinido');
                $PdtClass = ($pdt_status != 1 ? 'inactive' : (is_numeric($pdt_inventory) && $pdt_inventory <= 0 ? 'outsale' : ''));


                $readBrand = $this->modelproducts->ExeRead(DB_PDT_BRANDS, ["brand_id" => $pdt_brand], "brand_title")[0];
                $Brand = (!empty($readBrand) ? $readBrand["brand_title"] : 'indefinida');

                $readCat = $this->modelproducts->ExeRead(DB_PDT_CATS, ["cat_id" => $pdt_category], "cat_title");
                $Category = (!empty($readCat) ? $readCat[0]["cat_title"] : 'indefinida');

                $readSub = $this->modelproducts->ExeRead(DB_PDT_CATS, ["cat_id" => $pdt_subcategory], "cat_title");
                $SubCategory = (!empty($readSub) ? $readSub[0]["cat_title"] : 'indefinida');

                $PdtSoldVar = null;
                $PdtStockVar = null;

                $readStock = $this->modelproducts->ExeRead(DB_PDT_STOCK, ["pdt_id" => $pdt_id], "stock_code, stock_inventory, stock_sold");
                if (!empty($readStock)):
                    foreach ($readStock as $StockVarKey):
                        if ($StockVarKey['stock_code'] != 'default'):
                            $PdtSoldVar .= " | {$StockVarKey['stock_code']}: {$StockVarKey['stock_sold']}";
                            $PdtStockVar .= " | {$StockVarKey['stock_code']}: {$StockVarKey['stock_inventory']}";
                        endif;
                    endforeach;
                else:
                    //RETRO COMPATIBILIDADE
                    $CreateStock = ['pdt_id' => $pdt_id, 'stock_code' => 'default', 'stock_inventory' => $pdt_inventory, 'stock_sold' => ($pdt_delivered ? $pdt_delivered : 0)];
                    $this->modelproducts->ExeCreate(DB_PDT_STOCK, $CreateStock);
                endif;




                echo "<article class='col-lg-3 col-sm-6 portfolio-item'>";
                echo "<div class='text-center'>";
                echo "<a href='#' title='{$pdt_title}' style='max-height: 50px;'>";
                echo "<img title='{$pdt_title}' alt='[{$pdt_title}]' class='card-img-top img-thumbnail'  src='" . base_url("assets/uploads/{$pdt_cover}") . "' alt=''>";
                echo "</a>";
                echo "<div class='card-body'>";
                echo "<h4 class='my-0'><a href='" . site_url("produtos/{$pdt_name}") . "' title='{$pdt_title}'>{$pdt_title}</a></h4>";
                if ($pdt_offer_price && strtotime($pdt_offer_start) <= time() && strtotime($pdt_offer_end) >= time()):
                    echo "<p class='tagline'><span class='offer'>de <strike class='text-danger'>R$ " . number_format($pdt_price, "2", ",", ".") . "</strike> por</span> R$ " . number_format($pdt_offer_price, "2", ",", ".") . "</p>";
                else:
                    echo "<p class='tagline'><span class='offer'>por apenas</span>R$ " . number_format($pdt_price, "2", ",", ".") . "</p>";
                endif;

                echo "
                    <p class='text-left'>
                    Código: <b>{$PdtCode}</b><br>
                    Vendas: <b>" . str_pad($pdt_delivered, 3, 0, STR_PAD_LEFT) . "</b>{$PdtSoldVar}<br>
                    Estoque: <b>" . (is_numeric($pdt_inventory) ? ($pdt_inventory >= 1 ? str_pad($pdt_inventory, 3, 0, STR_PAD_LEFT) : str_pad($pdt_inventory, 3, 0, STR_PAD_LEFT)) : "+100") . "</b>{$PdtStockVar}<br>
                    Fabricante: <b>{$Brand}</b><br>
                    Em: <b><a target='_blank' href='".site_url("produtos/".checkName($Category))."'>{$Category}</a></b> &raquo; <b><a target='_blank' href='".site_url("produtos/".checkName($SubCategory))."'>{$SubCategory}</a></b></p>
                ";

                echo "</div>";
                echo "<div class='card-footer row'>";
                echo "<span class='col'><a title='Editar {$pdt_title}' href='" . site_url("admin/products/pdt/" . md5($pdt_id)) . "'>Editar</a></span>";
                echo "<span class='col'><a title='Excluir {$pdt_title}'' href='" . site_url("admin/products/remove_pdt/" . md5($pdt_id)) . "'>Deletar</a></span>";
                echo "</div>";
                echo "</div>";
                echo "</article>";
            endforeach;
        endif;
        ?>
    </div>
    </div>
</div>