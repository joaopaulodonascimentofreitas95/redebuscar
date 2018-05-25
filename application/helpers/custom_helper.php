<?php

# [0001] Function Helper Create and redirect set_flashdata

function customFlash($url, $class, $message) {
    $ci = & get_instance();
    $ci->load->helper('url');
    $ci->load->library('session');
    $ci->session->set_flashdata('class', $class);
    $ci->session->set_flashdata('error', $message);
    redirect($url);
}

# [0002] Funcion Helper checker and show alerts

function checkFlash() {
    $ci = & get_instance();
    $ci->load->library('session');
    if ($ci->session->flashdata('class')):
        $data['class'] = $ci->session->flashdata('class');
        $data['error'] = $ci->session->flashdata('error');
        $ci->load->view('errors/flashdata', $data);
    endif;
}

# [0003] Function Helper checkadmin is logged

function checkAdmin() {
    $ci = & get_instance();
    $ci->load->library('session');
    if (!empty($ci->session->userdata('userlogin'))):
        return true;
    else:
        return false;
    endif;
}

# [0004] Function Helper checkadmin is logged

function adminId() {
    $ci = & get_instance();
    $ci->load->library('session');
    if (!empty($ci->session->userdata('userlogin')['user_id'])):
        return $ci->session->userdata('userlogin')['user_id'];
    else:
        return false;
    endif;
}

# [0000] Funcion Helper description from levels

function getLevel($Level = null) {
    $UserLevel = [
        1 => 'Cliente (user)',
        2 => 'Assinante (user)',
        6 => 'Colaborador (adm)',
        7 => 'Suporte Geral (adm)',
        8 => 'Gerente Geral (adm)',
        9 => 'Administrador (adm)',
        10 => 'Super Admin (adm)'
    ];

    if (!empty($Level)):
        return $UserLevel[$Level];
    else:
        return $UserLevel;
    endif;
}

function getIcon($icon) {
    $Icons = [
        "fa-glass",
        "fa-music",
        "fa-search",
        "fa-envelope-o",
        "fa-heart",
        "fa-star",
        "fa-star-o",
        "fa-user",
        "fa-film",
        "fa-th-large",
        "fa-th",
        "fa-th-list",
        "fa-check",
        "fa-remove",
        "fa-close",
        "fa-times",
        "fa-search-plus",
        "fa-search-minus",
        "fa-power-off",
        "fa-signal",
        "fa-gear",
        "fa-cog",
        "fa-trash-o",
        "fa-home",
        "fa-file-o",
        "fa-clock-o",
        "fa-road",
        "fa-download",
        "fa-arrow-circle-o-down",
        "fa-arrow-circle-o-up",
        "fa-inbox",
        "fa-play-circle-o",
        "fa-rotate-right",
        "fa-repeat",
        "fa-refresh",
        "fa-list-alt",
        "fa-lock",
        "fa-flag",
        "fa-headphones",
        "fa-volume-off",
        "fa-volume-down",
        "fa-volume-up",
        "fa-qrcode",
        "fa-barcode",
        "fa-tag",
        "fa-tags",
        "fa-book",
        "fa-bookmark",
        "fa-print",
        "fa-camera",
        "fa-font",
    ];
    if (!empty($icon)):
        return $Icons[$icon];
    else:
        return $Icons;
    endif;
}
