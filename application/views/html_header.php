<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
    data-style="light">
    
    <head>
        <meta charset="utf-8" />
        <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>Painel Interativo COVID-19: Casos e Mortes ao Redor do Mundo</title>

        <meta name="description" content="" />

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href=<?php echo base_url('/assets/img/favicon/favicon.ico') ?> />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

        <link href=<?php echo base_url('/assets/vendor/fonts/boxicons.css') ?> rel="stylesheet">

        <!-- Core CSS -->
        <link class="template-customizer-core-css" href=<?php echo base_url('/assets/vendor/css/core.css') ?> rel="stylesheet">
        <link class="template-customizer-theme-css" href=<?php echo base_url('/assets/vendor/css/theme-default.css') ?> rel="stylesheet">
        <link href=<?php echo base_url('/assets/css/demo.css') ?> rel="stylesheet">

        <!-- Vendors CSS -->
        <link href=<?php echo base_url('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?> rel="stylesheet">
        <link href=<?php echo base_url('/assets/vendor/libs/apex-charts/apex-charts.css') ?> rel="stylesheet">

        <!-- Page CSS -->

        <!-- Helpers -->
        <script src=<?php echo base_url('/assets/vendor/js/helpers.js') ?>></script>
        <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src=<?php echo base_url('/assets/js/config.js') ?>></script>
    </head>
    <body>
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Examples -->
            <div class="row mb-12 g-6" style="display: flex; justify-content: center; flex-wrap: wrap;">
                <div class="col-md-6 col-lg-4">
                    <a href='<?php echo site_url("/dashboard/monitoramento"); ?>'>
                        <div class="card h-100" >
                            <div class="card-body" style="align-content: center; text-align:center;">
                                <h5 class="card-title">Dashboard de Monitoramento</h5>
                                <p class="card-text">
                                    Informações sobre o impacto do COVID-19 nos países Brasil, Canadá e Australia.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href='<?php echo site_url("/dashboard/comparativo"); ?>'>
                        <div class="card h-100" >
                            <div class="card-body" style="align-content: center; text-align:center;">
                                <h5 class="card-title">Comparar impacto do COVID-19 entre países</h5>
                                <p class="card-text">
                                    Selecione dois países quaisquer e descubra a taxa de mortes de COVID-19 entre eles.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
