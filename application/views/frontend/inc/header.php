<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">        
        <title><?= $title; ?></title>    

        <meta name="description" content="<?= $description; ?>">
        <meta name="author" content="<?= $author; ?>">
        <meta name="robots" content="index, follow"/>

        <link rel="base" href="<?= $base; ?>"/>
        <link rel="canonical" href="<?= $canonical; ?>"/>

        <meta itemprop="name" content="<?= $title; ?>"/>
        <meta itemprop="description" content="<?= $description; ?>"/>
        <meta itemprop="image" content="<?= $image; ?>"/>
        <meta itemprop="url" content="<?= $url; ?>"/>

        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?= $title; ?>" />
        <meta property="og:description" content="<?= $description; ?>" />
        <meta property="og:image" content="<?= $image; ?>" />
        <meta property="og:url" content="<?= $url; ?>" />
        <meta property="og:site_name" content="<?= SITE_NAME; ?>" />
        <meta property="og:locale" content="pt_BR" />

        <meta property="twitter:card" content="summary_large_image" />       
        <meta property="twitter:domain" content="<?= $url; ?>" />
        <meta property="twitter:title" content="<?= $title; ?>" />
        <meta property="twitter:description" content="<?= $description; ?>" />
        <meta property="twitter:image" content="<?= $image; ?>" />
        <meta property="twitter:url" content="<?= $base; ?>" />           

        <link rel="shortcut icon" href="<?= base_url("images/favicon.png"); ?>"/>
        <script src="<?=base_url("vendor/jquery/jquery.js");?>"></script>