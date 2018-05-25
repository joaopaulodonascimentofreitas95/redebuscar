</head>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">

    <!--NAVIGATION-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <a class="navbar-brand" href="<?= site_url(); ?>"><?= ADMIN_NAME; ?></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                    <a class="nav-link" href="<?=site_url("admin/dashboard");?>">
                        <i class="fa fa-fw fa-dashboard"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>
                <!--PAGES-->
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Pages">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapsePages" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-image"></i>
                        <span class="nav-link-text">Páginas</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapsePages">
                        <li><a href="<?= site_url("admin/pages");?>">Páginas</a></li>                        
                        <li><a href="<?= site_url("admin/pages/slide");?>">Nova Página</a></li>                        
                    </ul>
                </li>
                <!--SLIDES-->
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Slides">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseSlides" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-image"></i>
                        <span class="nav-link-text">Slides</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseSlides">
                        <li><a href="<?= site_url("admin/slides");?>">Slides</a></li>                        
                        <li><a href="<?= site_url("admin/slides/slide");?>">Novo Slide</a></li>                        
                    </ul>
                </li>
                
                <!--SERVICES-->
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Serviços">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseServices" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-square"></i>
                        <span class="nav-link-text">Serviços</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseServices">
                        <li><a href="<?= site_url("admin/services");?>">Serviços</a></li>                        
                        <li><a href="<?= site_url("admin/services/service");?>">Novo Serviço</a></li>                        
                    </ul>
                </li>
                
                <!--PRODUCTS-->
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Produtos">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseProducts" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-square"></i>
                        <span class="nav-link-text">Produtos</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseProducts">
                        <li><a href="<?= site_url("admin/products");?>">Ver Produtos</a></li>                        
                        <li><a href="<?= site_url("admin/products/categories");?>">Categorias</a></li>                        
                        <li><a href="<?= site_url("admin/products/brands");?>">Fabricantes</a></li>                        
                        <li><a href="<?= site_url("admin/products/pdt");?>">Novo Produto</a></li>                        
                    </ul>
                </li>
                
                 <!--USERS-->
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Usuários">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-user-circle"></i>
                        <span class="nav-link-text">Usuários</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseComponents">
                        <li>
                            <a href="<?= site_url("admin/users");?>">Ver Usuários</a>
                        </li>
                        <li>
                            <a href="<?= site_url("admin/user");?>">Novo Usuário</a>
                        </li>
                    </ul>
                </li>

            </ul>

            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item">
                    <a class="nav-link text-center" id="sidenavToggler">
                        <i class="fa fa-fw fa-angle-left"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">             
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-fw fa-sign-out"></i>Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="container-fluid">

