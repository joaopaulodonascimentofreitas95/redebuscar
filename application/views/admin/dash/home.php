<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Meu Dashboard</li>
</ol>

<!-- Example DataTables Card-->
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table"></i> Usuários</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <?= checkFlash(); ?>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Visualizações</th>                        
                        <th>Ações</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Visializações</th>                        
                        <th>Ações</th>
                    </tr>
                </tfoot>
                <tbody>

                    <?php
                    foreach ($products as $pdt):
                        extract($pdt);

                        $thumb = null;
                        $image_thumb = (!empty($pdt_cover) ? base_url("assets/uploads/{$pdt_cover}") : null);
                        if (!empty($image_thumb)):
                            $thumb = "<span class='float-left' style='margin-right:20px;'><img src='{$image_thumb}'alt='{$pdt_title}' title='{$pdt_title}' style='max-width:26px;' class='rounded-circle img-thumbnail'></span>";                            
                        endif;
                        ?>

                        <tr>
                            <td><?= $pdt_id; ?></td>
                            <td><a target="_blank" href="<?= site_url("produto/{$pdt_name}"); ?>"><?= $thumb; ?> <?= $pdt_title; ?></a></td>
                            <td><?= $pdt_views; ?> visualizações</td>
                            <td>
                                <a href="<?= site_url("admin/user/" . md5($pdt_id)); ?>"><span class="fa fa-edit"></span> Editar</a>
                                <a href="<?= site_url("admin/userremove/" . md5($pdt_id)); ?>"><span class="fa fa-remove"></span> Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>    
                </tbody>

            </table>
        </div>
    </div>
</div>
    