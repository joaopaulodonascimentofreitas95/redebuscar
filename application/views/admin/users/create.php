<?php
//var_dump($FormData);
extract($FormData);
?>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="<?= site_url("admin/users");?>">Usuários</a>
    </li>
    <li class="breadcrumb-item active">Cadastrar/Editar Usuários</li>
</ol>
<!-- Example DataTables Card-->

<div class="row">
    <div class="col-9">
        <div class="card mb-3">
            <div class="card-header">
                <div class="col-12">
                    <div class="row">
                        <span class="btn"><i class="fa fa-table"></i> Usuários</span>
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills">
                            <li class="mr-3">
                                <a href="#home" data-toggle="tab" aria-expanded="false" class="btn border active">Perfil</a>
                            </li>
                            <li>
                                <a href="#address" data-toggle="tab" aria-expanded="true" class="btn border">Endereço</a>
                            </li>                        
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">                    
                    <div class="tab-content">
                        <!--TAB FORM-->
                        <div class="tab-pane fade active show" id="home">
                            <div class="col-12">
                                <?= form_open_multipart(site_url("admin/usermanager/" . md5($user_id)), ["class" => ""]); ?>
                                <?= checkFlash(); ?>

                                <div class="form-group">
                                    <label for="user_thumb">Foto (Avatar)</label>
                                    <input name="user_thumb" type="file" class="form-control-file" id="user_thumb">
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="user_name">Primeiro Nome:</label>
                                            <input name="user_name" type="text" class="form-control" id="user_name" value="<?= (!empty($user_name) ? $user_name : null); ?>" placeholder="Primeiro Nome" required="required">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="user_lastname">Sobrenome:</label>
                                            <input name="user_lastname" type="text" class="form-control" id="user_lastname" value="<?= (!empty($user_lastname) ? $user_lastname : null); ?>" placeholder="Sobrenome" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="user_document">CPF:</label>
                                            <input name="user_document" type="text" class="form-control" id="user_document" value="<?= (!empty($user_document) ? $user_document : null); ?>" placeholder="000.000.000-00" required="required">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="user_telephone">Telefone:</label>
                                            <input name="user_telephone" type="text" class="form-control" id="user_telephone" value="<?= (!empty($user_telephone) ? $user_telephone : null); ?>" placeholder="(00) 00000-0000">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="user_cell">Celular:</label>
                                            <input name="user_cell" type="text" class="form-control" id="user_cell" value="<?= (!empty($user_cell) ? $user_cell : null); ?>"placeholder="(00) 00000-0000">
                                        </div>
                                    </div>                
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="user_email">Email:</label>
                                            <input name="user_email" type="email" class="form-control" id="user_email" value="<?= (!empty($user_email) ? $user_email : null); ?>"placeholder="Email" required="required">                
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="user_password">Senha:</label>
                                            <input name="user_password" type="password" class="form-control" id="user_password" placeholder="Password">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="user_level">Nível de Usuário:</label>    

                                            <select name="user_level" class="form-control form-control" id="user_level">
                                                <option>Selecione o nível de acesso</option>
                                                <?php
                                                $NivelDeAcesso = getLevel();
                                                foreach ($NivelDeAcesso as $Nivel => $Desc):
                                                    if ($Nivel <= $this->session->userdata('userlogin')['user_level']):
                                                        echo "<option";
                                                        if (!empty($user_level) && ($user_level == $Nivel)):
                                                            echo " selected='selected'";
                                                        endif;
                                                        echo " value='{$Nivel}'>{$Nivel} {$Desc}</option>";
                                                    endif;
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="user_genre">Genero de Usuário: <?= $user_genre; ?></label>
                                            <select name="user_genre" class="form-control" id="user_genre" required>
                                                <option selected disabled value="">Selecione o Gênero do Usuário:</option>
                                                <option value="1" <?= (!empty($user_genre) && ($user_genre == 1) ? 'selected="selected"' : ''); ?>>Masculino</option>
                                                <option value="2" <?= (!empty($user_genre) && ($user_genre == 2) ? 'selected="selected"' : ''); ?>>Feminino</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Salvar</button>
                                <?= form_close(); ?>
                            </div>
                        </div>
                        <!--TAB ADDRESS-->
                        <div class="tab-pane fade" id="address">
                            <?php
                            if (!empty($address)):

                                foreach ($address as $addr):
                                    extract($addr);
                                    $addr_complement = ($addr_complement ? " - {$addr_complement}" : null);
                                    $Primary = ($addr_key ? ' - Principal' : null);
                                    echo "<div class='container_address border rounded col-12'>
                    <h3 class='icon-location'>{$addr_name}{$Primary}</h3>"
                                    . "<address>"
                                    . "<p>{$addr_street}, {$addr_number}{$addr_complement}</p>"
                                    . "<p>B. {$addr_district}, {$addr_city}/{$addr_state}, {$addr_country}</p>"
                                    . "<p>CEP: {$addr_zipcode}</p>"
                                    . "</address>"
                                    . "<p class='col-12'>"
                                    . "<a href='" . site_url("admin/address/" . md5($addr_id)) . "'>Editar</a> "
                                    . "<a href='" . site_url("admin/addrremove/" . md5($user_id) . "/" . md5($addr_id)) . "'>Excluir</a>"
                                    . "</p>"
                                    . "</div>";
                                endforeach;
                            else:
                                echo '<div class="alert alert-info">
                                Nenhum endereço cadastrado! <a href="' . site_url("admin/useraddress/" . md5($user_id)) . '" class="alert-link">Deseja cadastrar agora?</a>.
                            </div>';
                            endif;
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="col-3">
        <div class="card mb-3">
            <div class="card-header"><i class="fa fa-image"></i> Foto de Perfil</div>
            <div class="card-body" style="padding: 3px;">
                <?php
                $image_thumb = (!empty($user_thumb) ? base_url("assets/uploads/{$user_thumb}") : null);
                if (!empty($image_thumb)):
                    echo "<img src='{$image_thumb}'alt='{$user_name} {$user_lastname}' title='{$user_name} {$user_lastname}' class='img-fluid rounded'>";
                else:
                    echo "<div class='card-body'><p class='card-text'>Foto (Avatar)</p></div>";
                endif;
                ?>
            </div>
        </div>
    </div>