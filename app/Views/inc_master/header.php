<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Admin Page &mdash; Stisla</title>
    <link rel="icon" href="<?= base_url('public/folder.ico') ?>" type="image/x-icon" />
    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url('public/assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/select2.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('public/assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/dropify/dropify.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/components.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/datatable/buttons.dataTables.min.css') ?>">

    <!-- Script -->
    <script src="<?= base_url('public/assets/js/jquery.3.2.1.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/stisla.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/select2.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/datatable/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/datatable/datatables.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/datatable/dataTables.buttons.min.js') ?>"></script>

    <!-- Template JS File -->
    <script src="<?= base_url('public/assets/js/scripts.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/modal.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/custom.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/notify.js') ?>"></script>
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg" style="background-color: #2E8B57;
opacity: 0.8;
/*background-image:  linear-gradient(#FFFFFF 2.2px, transparent 2.2px), linear-gradient(to right, #FFFFFF 2.2px, #2E8B57 2.2px);*/
background-size: 44px 44px;"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    </ul>

                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg nav-link-user">
                            <img alt="image" src="<?= base_url('public/assets/img/avatar/avatar-2.png') ?>" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">
                                Hi, <?= session()->get('nama') ?>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>