<?php
extract($product);

$readBrand = $this->modelfrontend->ExeRead(DB_PDT_BRANDS, ["brand_id" => $pdt_brand], "brand_name, brand_title");
$Brand = (!empty($readBrand) ? $readBrand[0] : '');

$readCategory = $this->modelfrontend->ExeRead(DB_PDT_CATS, ["cat_id" => $pdt_subcategory], "cat_name, cat_title");
$Category = (!empty($readCategory) ? $readCategory[0] : '');
?>
<article class="single_page container">    
    <div class="row">
        <div class="col-lg-8 order-2">
            <div class="card mt-4">
                <div class="card-body">
                    <header>
                        <h2 class="card-title"><?= $pdt_title; ?></h2>

                        <div class="price">
                            <h4>
                                <?php
                                $PdtPrice = null;
                                if ($pdt_offer_price && $pdt_offer_start <= date('Y-m-d H:i:s') && $pdt_offer_end >= date('Y-m-d H:i:s')):
                                    $PdtPrice = $pdt_offer_price;
                                    echo "De <strike>R$ " . number_format($pdt_price, '2', ',', '.') . "</strike> por apenas <b>R$ " . number_format($pdt_offer_price, '2', ',', '.') . "</b>";
                                else:
                                    $PdtPrice = $pdt_price;
                                    echo "R$ " . number_format($pdt_price, '2', ',', '.');
                                endif;

                                //By Wallyson Alemão
                                if (ECOMMERCE_PAY_SPLIT):
                                    $MakeSplit = intval($PdtPrice / ECOMMERCE_PAY_SPLIT_MIN);
                                    $NumSplit = (!$MakeSplit ? 1 : ($MakeSplit && $MakeSplit <= ECOMMERCE_PAY_SPLIT_NUM ? $MakeSplit : ECOMMERCE_PAY_SPLIT_NUM));
                                    if ($NumSplit <= ECOMMERCE_PAY_SPLIT_ACN):
                                        $SplitPrice = number_format(($PdtPrice / $NumSplit), '2', ',', '.');
                                    elseif ($NumSplit - ECOMMERCE_PAY_SPLIT_ACN == 1):
                                        $SplitPrice = number_format(($PdtPrice * (pow(1 + (ECOMMERCE_PAY_SPLIT_ACM / 100), $NumSplit - ECOMMERCE_PAY_SPLIT_ACN)) / $NumSplit), '2', ',', '.');
                                    else:
                                        $ParcSj = round($PdtPrice / $NumSplit, 2); // Valor das parcelas sem juros
                                        $ParcRest = (ECOMMERCE_PAY_SPLIT_ACN > 1 ? $NumSplit - ECOMMERCE_PAY_SPLIT_ACN : $NumSplit);
                                        $DiffParc = round(($PdtPrice * getFactor($ParcRest) * $ParcRest) - $PdtPrice, 2);
                                        $SplitPrice = number_format($ParcSj + ($DiffParc / $NumSplit), '2', ',', '.');
                                    endif;
                                    echo "<br> <small>Em até {$NumSplit}x de R$ {$SplitPrice}</small>";
                                endif;
                                ?>
                            </h4>
                        </div>

                        <p class="card-text"><?= $pdt_subtitle; ?></p>

                        <?php if ($Brand): ?>
                            <p>Marca: <a title="Mais produtos da marca <?= $Brand['brand_title']; ?>" href="<?= site_url("marca/{$Brand['brand_name']}"); ?>"><?= $Brand['brand_title']; ?></a></p>
                        <?php endif; ?>
                        <?php if ($Category): ?>
                            <p>Categoria: <a title="Mais produtos em <?= $Category['cat_title']; ?>" href="<?= site_url("produtos/{$Category['cat_name']}"); ?>"><?= $Category['cat_title']; ?></a></p>
                        <?php endif; ?>
                        <p>Estoque: <?= $pdt_inventory ? str_pad($pdt_inventory, 3, 0, STR_PAD_LEFT) . " unidades" : 'Fora de Estoque'; ?></p>


                        <span class="text-warning">★ ★ ★ ★ ☆</span>
                        4.0
                    </header>

                    <hr>
                    <div class="htmlchars">
                        <h5>Mais detalhes sobre <strong><?= $pdt_title; ?></strong></h5>
                        <?= $pdt_content; ?>
                    </div>
                </div>
            </div>
        </div>
        <aside class="col-lg-4 order-1">
            <div class="card mt-4">
                <img class="card-img-top img-fluid" src="<?= base_url("assets/uploads/{$pdt_cover}"); ?>" alt="">
            </div>
            <h3 class="my-4">Veja mais categorias</h3>
            <div class="list-group">
                <?php
                if (!empty($pdtcategories)):
                    foreach ($pdtcategories as $cat):
                        $active = ($cat["cat_name"] == $Category["cat_name"] ? "active" : null);
                        echo "<a href='' class='list-group-item {$active}' title=''><article><h6>{$cat["cat_title"]}</h6></article></a>";
                    endforeach;
                endif;
                ?>
            </div>
        </aside>       
    </div>

</article>