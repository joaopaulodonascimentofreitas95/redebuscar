<?php
extract($pdtcategory);
?>
<section class="single_page">
    <!--<div class="container">-->
    <header class="page-heading">
        <div class="container text-uppercase">
            <h1>
                <?= SITE_NAME; ?> <?= (!empty($departament) ? "&raquo; $departament" : null); ?> &raquo; <?= $cat_title; ?>
            </h1>
        </div>
    </header>
    <!--BREADCRUMBS-->
    <div class="full-width breadcrumb" style="margin-bottom: 0;">
        <div class="container">
            <ol class="breadcrumb" style="margin-bottom: 0;">
                <li class="breadcrumb-item mr-2"><a href="<?= site_url(); ?>"><?= SITE_NAME; ?></a></li>
                <?= (!empty($departament) ? "<li class='breadcrumb-item'>$departament</li>" : null); ?>
                <li class="breadcrumb-item active ml-2"><?= $cat_title; ?></li>
            </ol>
        </div>
    </div>
    <div class="main_services">        
        <div class="container">
            <div class="row text-center">
                <div class="col-md-9">
                    <div class="row">
                        <?php
                        if (!empty($products)):
                            foreach ($products as $pdt):
                                extract($pdt);
                                echo "<article class='col-lg-4 col-sm-8 portfolio-item'>";
                                echo "<div class='text-center'>";
                                echo "<a href='#' title='{$pdt_title}' style='max-height: 50px;'>";
                                echo "<img title='{$pdt_title}' alt='[{$pdt_title}]' class='card-img-top img-thumbnail'  src='" . base_url("assets/uploads/{$pdt_cover}") . "' alt=''>";
                                echo "</a>";
                                echo "<div class='card-body'>";
                                echo "<h2 class='my-0'><a href='" . site_url("produto/{$pdt_name}") . "' title='{$pdt_title}'>{$pdt_title}</a></h2>";
                                echo "</div>";
                                echo "</div>";
                                echo "</article>";
                            endforeach;
                        else:
                            echo "<p class='alert alert-info fa fa-warning col text-left'> Nenhum produto cadastrado na Categoria <b>$cat_title</b></p>";
                        endif;
                        ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- Categories Widget -->
                    <aside>
                        <section class="card">
                            <h5 class="card-header">Categorias</h5>
                            <div class="card-body">
                                <div class="row">

                                    <?php
                                    if (!empty($pdtcategories)):
                                        echo "<ul class='list-unstyled mb-0 list_categories'>";
                                        foreach ($pdtcategories as $category):
                                            if (empty($category["cat_parent"])):
                                                echo "<li class='text-left'>"
                                                . "<article>"
                                                . "<a title='{$category["cat_title"]}' href='" . site_url("produtos/{$category["cat_name"]}") . "'>"
                                                . "<h6>&raquo; {$category["cat_title"]}</h6>"
                                                . "</a>"
                                                . "</article>"
                                                . "</li>";
                                            else:
                                                echo "<li class='text-left'>"
                                                . "<article>"
                                                . "<a title='{$category["cat_title"]}' href='" . site_url("produtos/{$category["cat_name"]}") . "'>"
                                                . "<h6>&raquo;&raquo; {$category["cat_title"]}</h6>"
                                                . "</a>"
                                                . "</article>"
                                                . "</li>";
                                            endif;
                                        endforeach;
                                        echo "</ul>";
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </section>
                        <section class="card">
                            <h5 class="card-header">Fabricantes</h5>
                            <div class="card-body">
                                <div class="row">

                                    <?php
                                    if (!empty($pdtbrands)):
                                        echo "<ul class='list-unstyled mb-0 list_categories'>";
                                        foreach ($pdtbrands as $brand):

                                            echo "<li class='text-left'>"
                                            . "<article>"
                                            . "<a title='{$brand["brand_title"]}' href='" . site_url("marca/{$brand["brand_name"]}") . "'>"
                                            . "<h6>&raquo;&raquo; {$brand["brand_title"]}</h6>"
                                            . "</a>"
                                            . "</article>"
                                            . "</li>";

                                        endforeach;
                                        echo "</ul>";
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </section>
                    </aside>
                </div>

            </div>
        </div>
    </div>
</section>



<?php
//die("....");
//extract($Read->getResult()[0]);
//
//$departament = null;
//if ($cat_parent):
//$Read->FullRead("SELECT cat_title, cat_name FROM " . DB_PDT_CATS . " WHERE cat_id = :id", "id={$cat_parent}");
//$departament = " / <a title='{$Read->getResult()[0]['cat_title']} em " . SITE_NAME . "' href='" . BASE . "/produtos/{$Read->getResult()[0]['cat_name']}'>{$Read->getResult()[0]['cat_title']}</a>";
//endif;
?>
<!--<div class="container">
    <section class="content">
        <div class="single_list">
            <h1 class="breadcrumbs">
                <a title="<?= SITE_NAME; ?>" href="<?= BASE; ?>"><?= SITE_NAME; ?></a>
<?= $departament; ?> / 
<?= $cat_title; ?>
            </h1>
<?php
//                $Page = (!empty($URL[2]) && filter_var($URL[2], FILTER_VALIDATE_INT) ? $URL[2] : 1);
//                $Pager = new Pager(BASE . "/produtos/{$URL[1]}/", "<<", ">>", 3);
//                $Pager->ExePager($Page, 9);
//                $Read->ExeRead(DB_PDT, "WHERE (pdt_category = :cat OR pdt_subcategory = :cat) AND (pdt_inventory >= 1 OR pdt_inventory IS NULL) AND pdt_status = 1 ORDER BY pdt_title ASC LIMIT :limit OFFSET :offset", "cat={$cat_id}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
//                if ($Read->getResult()):
//                    foreach ($Read->getResult() as $LastPDT):
//                        extract($LastPDT);
//                        $PdtBox = 'box3';
//                        require 'inc/product.php';
//                    endforeach;
//
//                    $Pager->ExePaginator(DB_PDT, "WHERE (pdt_category = :cat OR pdt_subcategory = :cat) AND (pdt_inventory >= 1 OR pdt_inventory IS NULL) AND pdt_status = 1", "cat={$cat_id}");
//                    echo $Pager->getPaginator();
//
//                else:
//                    $Pager->ReturnPage();
//                    Erro("Não existem produtos cadastrados em {$cat_title}. Mas temos outras opções! :)", E_USER_NOTICE);
//                endif;
?>
        </div>-->

<?php // require 'inc/sidebar.php';    ?>

<!--        <div class="clear"></div>
    </section>-->
<!--</div>-->