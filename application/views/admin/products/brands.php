<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Fabricantes</li>
</ol>

<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <span class="col-sm-10 btn text-left"><i class="fa fa-table"></i> Categorias e Subcategorias de produtos</span>
            <span class="col-sm-2 text-right"><a href="<?= site_url("admin/products/brand"); ?>" title="" class="btn btn-outline-primary">Adicionar Fabricante</a></span>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="panel panel-default">
                <?= checkFlash(); ?>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th class="text-center">Produtos</th>
                                <th class="text-center">-</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            echo '<div class="list-group">';
                            if (empty($allBrands)):
                                echo '<div class="alert alert-info" role="alert">Nenhuma Marca/Fabricante foi cadastrado ainda!</div>';
                            else:
                                foreach ($allBrands as $Brand):
                                    ?>
                                    <tr>
                                        <td><?= str_pad($Brand->brand_id, 4, 0, STR_PAD_LEFT); ?></td>
                                        <td>
                                            <?php if (!empty($Brand->brand_cover)): ?>
                                                <img class="img-thumbnail" style="max-width: 30px;" src="<?= base_url("assets/uploads/{$Brand->brand_cover}") ?>" class="rounded img-thumbnail" alt="<?= $Brand->brand_title; ?>">                                   
                                            <?php endif; ?>
                                            <?= $Brand->brand_title; ?>
                                        </td>
                                        <td class="text-center"><?= $Brand->pdts; ?> Encontrado(s)</td>
                                        <td class="text-center">
                                            <a href="<?= site_url("admin/products/brand/" . md5($Brand->brand_id)); ?>" title="Editar <?= $Brand->brand_title; ?>"><span class="fa fa-edit"></span> Editar</a> | 
                                            <a href="<?= site_url("admin/products/brand_delete/" . md5($Brand->brand_id)); ?>" title="Excluir <?= $Brand->brand_title; ?>" class="text-danger">
                                                <span class="fa fa-remove"></span> Excluir
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            echo '</div>';
                            ?>

                        </tbody>
                    </table>

                    <?= $links; ?>
                </div>
                <!-- /.table-responsive -->

            </div>
        </div>
    </div>
</div>