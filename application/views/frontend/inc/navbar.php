</head>
<body>

<!-- Navigation -->
<header class="navbar fixed-top navbar-expand-lg navbar-dark bg-light fixed-top">
    <div class="container">
        <div class="navbar-brand">
            <a href="<?= site_url(); ?>">
                <h1 class="d-none"><?= SITE_NAME; ?> - <?= SITE_SUBNAME; ?></h1>
                <img class="logomarca" src="<?= base_url("assets/images/logomarca.png") ?>"/>
            </a>
            <div class="navbar-brand-phones">
                <span><?= SITE_ADDR_PHONE_A; ?></span>
                <span><?= SITE_ADDR_PHONE_B; ?></span>
            </div>
        </div>

        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <nav class="collapse navbar-collapse" id="navbarResponsive">
            <h2 class="d-none">Aqui, a peça mais importante é ter você como cliente!</h2>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url(); ?>">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url("quem-somos"); ?>">Sobre</a>
                </li>

                <li class="nav-item dropdown">
                    <a title="Produtos - BusCar Autopeças" class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Produtos</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                        <a class="dropdown-item" title="Ar Condicionaro - BusCar Autopeças" href="#">Ar Condicionado</a>
                        <a class="dropdown-item" title="Linha Leve - BusCar Autopeças" href="#">Linha Leve</a>
                        <a class="dropdown-item" title="Linha Pesada - BusCar Autopeças" href="#">Linha Pesada</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarLinhaLeve" data-toggle="dropdown" aria-haspopup="false" aria-expanded="true">Linha Leve</a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarLinhaLeve">
                        <li><a class="dropdown-item" href="#">Fiat</a></li>
                        <li><a class="dropdown-item" href="#">Toyota</a></li>
                        <li><a class="dropdown-item" href="#">Citroem</a></li>
                        <li><a class="dropdown-item" href="#">Fiat</a></li>
                        <li><a class="dropdown-item" href="#">Toyota</a></li>
                        <li><a class="dropdown-item" href="#">Citroen</a></li>
                        <li><a class="dropdown-item" href="#">Ford</a></li>
                        <li><a class="dropdown-item" href="#">Nissan</a></li>
                        <li><a class="dropdown-item" href="#">Hyundai</a></li>
                        <li><a class="dropdown-item" href="#">Honda</a></li>
                        <li><a class="dropdown-item" href="#">Wolksvagen</a></li>
                        <li><a class="dropdown-item" href="#">Peugeot</a></li>
                        <li><a class="dropdown-item" href="#">Renault</a></li>
                        <li><a class="dropdown-item" href="#">Mitsubishi</a></li>
                        <li><a class="dropdown-item" href="#">Kia</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarLinhaPesada" data-toggle="dropdown" aria-haspopup="false" aria-expanded="true">Linha Pesada</a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarLinhaPesada">
                        <li><a class="dropdown-item" href="#">Denso</a></li>
                        <li><a class="dropdown-item" href="#">Euroar</a></li>
                        <li><a class="dropdown-item" href="#">Irizar</a></li>
                        <li><a class="dropdown-item" href="#">Spheros</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#contact">Contato</a>
                </li>
            </ul>
        </nav>
    </div>
</header>