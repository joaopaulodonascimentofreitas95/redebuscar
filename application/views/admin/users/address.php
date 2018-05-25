<?php
//var_dump($FormData);
extract($FormData);
?>



<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Cadastrar/Editar Usuários</li>
</ol>
<!-- Example DataTables Card-->

<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header d-flex col-12">
                <div class="col">
                    <span class="btn"><i class="fa fa-table"></i> Usuários</span>
                </div>
                <div class="col-1 offset-1">
                    <a href="<?= site_url("admin/user/" . md5($user_id)); ?>" title="Ver Perfil deste Usuários" class="btn btn-outline-primary btn-hover">Perfil</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <?= form_open_multipart(site_url("admin/addrmanager/" . md5($addr_id))); ?>
                    <div class="form-group col-12">
                        <?= checkFlash(); ?>
                    </div>

                    <div class="form-group col-12">
                        <label for="addr_name">Nome do Endereço:</label>
                        <input name="addr_name" type="text" class="form-control" id="addr_name" value="<?= (!empty($addr_name) ? $addr_name : null); ?>" placeholder="Nome do Endereço" required="required">
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="form-group col-3">
                                <label for="addr_zipcode">CEP:</label>
                                <input name="addr_zipcode" type="text" class="form-control" id="addr_zipcode" value="<?= (!empty($addr_zipcode) ? $addr_zipcode : null); ?>" placeholder="CEP" required="required">
                            </div>
                            <div class="form-group col-7">
                                <label for="addr_street">Rua:</label>
                                <input name="addr_street" type="text" class="form-control" id="user_document" value="<?= (!empty($addr_street) ? $addr_street : null); ?>" placeholder="Rua" required="required">
                            </div>
                            <div class="form-group col-2">
                                <label for="addr_number">Número:</label>
                                <input name="addr_number" type="number" class="form-control" id="user_document" value="<?= (!empty($addr_number) ? $addr_number : null); ?>" placeholder="Número" required="required">
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <label for="addr_complement">Complemento:</label>
                        <input name="addr_complement" type="text" class="form-control" id="addr_complment" value="<?= (!empty($addr_complement) ? $addr_complement : null); ?>" placeholder="Complemento" required="required">
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="form-group col-3">
                                <label for="addr_district">Bairro:</label>
                                <input name="addr_district" type="text" class="form-control" id="addr_district" value="<?= (!empty($addr_district) ? $addr_district : null); ?>" placeholder="Bairro" required="required">
                            </div>
                            <div class="form-group col-4">
                                <label for="addr_city">Cidade:</label>
                                <input name="addr_city" type="text" class="form-control" id="addr_city" value="<?= (!empty($addr_city) ? $addr_city : null); ?>" placeholder="Cidade" required="required">
                            </div>

                            <div class="form-group col-1">
                                <label for="addr_state">Estado(UF):</label>
                                <input name="addr_state" type="text" class="form-control" id="addr_district" value="<?= (!empty($addr_state) ? $addr_state : null); ?>" placeholder="Estado(UF)" required="required">
                            </div>

                            <div class="form-group col-4">
                                <label for="addr_country">Pais:</label>
                                <input name="addr_country" type="text" class="form-control" id="addr_country" value="<?= (!empty($addr_country) ? $addr_country : null); ?>" placeholder="Pais" required="required">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-sm-12">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>
