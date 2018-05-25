<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Categorias</li>
</ol>

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <span class="col-sm-10 btn text-left"><i class="fa fa-table"></i> Categorias e Subcategorias de produtos</span>
            <span class="col-sm-2 text-right"><a href="<?= site_url("admin/products/category"); ?>" title="" class="btn btn-outline-primary">Adicionar Categoria</a></span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <div class="panel panel-default">
                <?= checkFlash(); ?>

                <?php
                if (!empty($sectors)):
                    foreach ($sectors as $Sector):
                        $Sector['cat_sizes'] = (!empty($Sector['cat_sizes']) ? $Sector['cat_sizes'] : 'default');
                        ?>

                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <span class="col-sm-8 text-uppercase">
                                        <a target="_blank" href="<?=site_url("produtos/{$Sector["cat_name"]}");?>" title="Ver <?= $Sector["cat_title"]; ?> no site!">
                                        <i class="fa fa-check"></i> <?= $Sector["cat_title"]; ?>
                                        </a>
                                    </span>
                                    <span class="col-sm-2">
                                        Tamanhos: <span class="badge badge-primary"><?= $Sector["cat_sizes"]; ?></span>
                                        Produtos: <span class="badge badge-primary"><?= $Sector['cat_pdt']; ?></span>
                                    </span> 
                                    <span class="col-sm-2 text-right">
                                        <a href="<?= site_url("admin/products/category/" . md5($Sector["cat_id"])); ?>" title="Editar <?= $Sector["cat_title"]; ?>"><span class="fa fa-edit"></span> Editar</a>
                                        <a href="<?= site_url("admin/products/cat_delete/" . md5($Sector["cat_id"])); ?>" title="Excluir <?= $Sector["cat_title"]; ?>" class="text-danger"><span class="fa fa-remove"></span> Excluir</a>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                if (!empty($Sector["subcats"])):
                                    echo '<ul class="list-group">';
                                    foreach ($Sector["subcats"] as $Sub):
                                        $Sub['cat_sizes'] = (!empty($Sub['cat_sizes']) ? $Sub['cat_sizes'] : 'default');
                                        ?>
                                        <li class="list-group-item d-flex  justify-content-between align-items-center">                           
                                            <span class="col-sm-1" style="padding: 0;">
                                                <?php if (!empty($Sub["cat_cover"])): ?>
                                                    <img class="img-thumbnail" style="max-width: 100%;" src="<?= base_url("assets/uploads/{$Sub["cat_cover"]}") ?>" class="rounded img-thumbnail" alt="<?= $Sub["cat_title"]; ?>">                                   
                                                <?php endif; ?>
                                            </span>
                                            <span class="col">
                                                <a target="_blank" href="<?=site_url("produtos/{$Sub["cat_name"]}");?>" title="Ver <?= $Sub["cat_title"]; ?> no site!">                                        
                                                <?= $Sub["cat_title"]; ?> 
                                                </a><br> 
                                                <small>&raquo Tamanhos: <?= $Sub['cat_sizes']; ?> | Produtos Cadastrados: <?= $Sub['cat_pdt']; ?></small></span>
                                            <span class="col-sm-2"><a href="<?= site_url("admin/products/category/" . md5($Sub["cat_id"])); ?>" title="Editar <?= $Sub["cat_title"]; ?>"><span class="fa fa-edit"></span> Editar</a> | <a href="<?= site_url("admin/products/cat_delete/" . md5($Sub["cat_id"])); ?>" title="Excluir <?= $Sub["cat_title"]; ?>" class="text-danger"><span class="fa fa-remove"></span> Excluir</a></span>
                                        </li>
                                        <?php
                                    endforeach;
                                    echo '</ul>';
                                else:
                                    echo '<div class="alert alert-info">Ainda não existem subcategorias cadastradas!</div>';
                                endif;
                                ?>
                            </div>
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>

            </div>
        </div>
    </div>

</div>