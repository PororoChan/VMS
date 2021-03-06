<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Kodinger">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login Page</title>
    <link rel="icon" href="<?= base_url('public/folder.ico') ?>" type="image/x-icon" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/style.css'); ?>">
    <link rel=" stylesheet" href="<?= base_url('public/assets/css/components.css'); ?>">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex align-items-stretch">
                <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                    <div class="p-5 m-3 mt-5">
                        <h4 class="text-dark font-weight-normal">Welcome to</h4>
                        <span class="font-weight-bold text-dark" style="font-size: 20px;">VMS PT Autochem Industry</span>
                        <form id="login-form" method="POST">
                            <div class="form-group mt-3 pt-5">
                                <div id="pesan">
                                </div>
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
                            <div class="form-group text-right pt-4">
                                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4" id="btn_login">
                                    Login
                                </button>
                            </div>
                        </form>
                        <div class="text-center mt-5 pt-5 text-small">
                            Copyright &copy; PT Autochem Industry
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100" style="background-size: cover; background-repeat: no-repeat; image-rendering: pixelated; background-position: center;" data-background="<?= base_url('public/assets/img/unsplash/login-bg.jpeg') ?>">
                    <div class="absolute-bottom-left index-2">
                        <div class="text-light p-5 pb-2">
                            <div class="mb-0 pb-0">
                                <h1 class="mb-2 display-4 text-white font-weight-bold">Visit Monitoring System</h1>
                                <h5 class="font-weight-normal text-white text-muted-transparent">PT AUTOCHEM INDUSTRY</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="<?= base_url('public/assets/js/stisla.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/scripts.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/custom.js') ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#login-form').on('submit', function(ev) {
                ev.preventDefault();
                var user = $("#user").val().trim();
                var pass = $("#pass").val().trim();
                var csrfName = "<?= csrf_token() ?>"; // CSRF Token name
                var csrfHash = $('#txt_csrfname').val(); // CSRF hash

                if (user != "" && pass != "") {
                    $("#btn_login").html("<i class='fas fa-spinner fa-pulse text-light'></i>")
                    $.ajax({
                        url: "<?= base_url('cekLogin') ?>",
                        type: "POST",
                        data: {
                            user: user,
                            pass: pass,
                            // [csrfName]: csrfHash
                        },
                        dataType: 'json',
                        success: function(response) {
                            var msg = "Login Berhasil"
                            if (response.success == 1) {
                                $("#pesan").removeClass('alert alert-danger');
                                $("#pesan").addClass('alert alert-success');
                                setTimeout(() => {
                                    window.location = "<?= base_url('branch') ?>";
                                }, 500);
                            } else if (response.success == 0) {
                                $("#pesan").addClass('alert alert-danger');
                                var msg = "Username atau Password Salah";
                            }
                            $("#user").val("");
                            $("#pass").val("");
                            $('#txt_csrfname').val(response.token);
                            $("#pesan").html(msg);
                            $("#btn_login").text("Login")
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>