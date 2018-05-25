<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Usuários</li>
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
                        <th>Sobrenome</th>
                        <th>Email</th>
                        <th>Nível</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </tfoot>
                <tbody>

                    <?php
                    foreach ($allUsers as $User):

                        $thumb = null;
                        $image_thumb = (!empty($User->user_thumb) ? base_url("assets/uploads/{$User->user_thumb}") : null);
                        if (!empty($image_thumb)):
                            //$thumb = "<span class='float-left' style='margin-right:20px;'><img src='{$image_thumb}'alt='{$User->user_name} {$User->user_lastname}' title='{$User->user_name} {$User->user_lastname}' style='max-width:26px;' class='rounded-circle img-thumbnail'></span>";
                            $thumb = "";
                        endif;
                        ?>

                        <tr>
                            <td><?= $User->user_id; ?></td>
                            <td><a href="<?= site_url("admin/user/" . md5($User->user_id)); ?>"><?= $thumb; ?> <?= $User->user_name; ?></a></td>
                            <td><?= $User->user_lastname; ?></td>
                            <td><?= $User->user_email; ?></td>
                            <td><?= getLevel($User->user_level); ?></td>
                            <td>
                                <a href="<?= site_url("admin/user/" . md5($User->user_id)); ?>"><span class="fa fa-edit"></span> Editar</a>
                                <a href="<?= site_url("admin/userremove/" . md5($User->user_id)); ?>"><span class="fa fa-remove"></span> Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>    
                </tbody>

            </table>
            <?= $links; ?>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>

