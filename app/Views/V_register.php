<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register Page</title>
    <link rel="icon" href="<?= base_url('public/folder.ico') ?>" type="image/x-icon" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/style.css'); ?>">
    <link rel=" stylesheet" href="<?= base_url('public/assets/css/components.css'); ?>">
</head>

<body class="my-register-page">
    <div id="app">
        <section class="section">
            <div class="d-flex flex-wrap align-items-stretch">
                <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                    <div class="p-4 m-3">
                        <img src="<?= base_url('public/assets/img/logodms.png'); ?>" alt="logo" width="50%" class="shadow-light rounded-circle mb-5 mt-2">
                        <h4 class="text-dark font-weight-normal">Welcome to <span class="font-weight-bold">DMS @Hyperdata</span></h4>
                        <p class="text-muted">You can create account first before login.</p>
                        <form id="login-form">
                            <div id="pesan">

                            </div>
                            <div class="form-group">
                                <label for="user">Username</label>
                                <input id="user" type="text" class="form-control" name="user" tabindex="1" required autofocus>
                                <div class="invalid-feedback">
                                    Please fill in your username
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="pass" class="control-label">Password</label>
                                </div>
                                <input id="pass" type="password" class="form-control" name="pass" tabindex="2" required>
                                <div class="invalid-feedback">
                                    please fill in your password
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <button type="button" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4" id="btn_register">
                                    Register
                                </button>
                            </div>

                            <div class="text-center mt-5 text-small">
                                Copyright &copy; @Hyperdata Solusindo Mandiri.
                                <div class="mt-2">
                                    <a href="#">Privacy Policy</a>
                                    <div class="bullet"></div>
                                    <a href="#">Terms of Service</a>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="<?= base_url('public/assets/img/login-bg.png'); ?>">
                    <div class="absolute-bottom-left index-2">
                        <div class="text-light p-5 pb-2">
                            <div class="mb-5 pb-3">
                                <h1 class="mb-2 display-4 font-weight-bold">Document Management System</h1>
                                <h5 class="font-weight-normal text-muted-transparent">PT HYPERDATA SOLUSINDO MANDIRI</h5>
                            </div>

                        </div>
                    </div>
                </div>
        </section>
    </div>

    <script src="<?= base_url('public/assets/js/jquery.3.2.1.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/bootstrap.min.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="<?= base_url('public/assets/js/stisla.js'); ?>"></script>
    <script src="<?= base_url('public/assets/js/scripts.js'); ?>"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $("#btn_register").click(function() {
                var user = $("#user").val();
                var pass = $("#pass").val();

                if (user.length == "") {

                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Username Wajib Diisi !'
                    });

                } else if (pass.length == "") {

                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Password Wajib Diisi !'
                    });

                } else {

                    //ajax
                    $.ajax({

                        url: "<?= base_url('register1') ?>",
                        type: "POST",
                        data: {
                            "user": user,
                            "pass": pass
                        },

                        success: function(response) {

                            if (response == "success") {

                                Swal.fire({
                                    type: 'success',
                                    title: 'Register Berhasil!',
                                    text: 'silahkan login!'
                                });

                                $("#user").val('');
                                $("#pass").val('');

                            } else {

                                Swal.fire({
                                    type: 'error',
                                    title: 'Register Gagal!',
                                    text: 'silahkan coba lagi!'
                                });

                            }

                            console.log(response);

                        },

                        error: function(response) {
                            Swal.fire({
                                type: 'error',
                                title: 'Opps!',
                                text: 'server error!'
                            });
                        }

                    })

                }

            });

        });
    </script>
</body>