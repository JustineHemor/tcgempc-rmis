<?php
session_start();
if (isset($_SESSION['member_id'])) {
  header("Location: index.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>TCGEMPC | Login</title>
    <link rel = "icon" type = "image/png" href = "./assets/img/logo.png">
    <!-- GLOBAL MAINLY STYLES-->
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="./assets/css/main.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link href="./assets/css/pages/auth-light.css" rel="stylesheet" />
</head>

<body style="
    margin: auto;
    background-image: url('./assets/img/Tagaytay.jpg');
    background-repeat: no-repeat!important;
    background-size: cover!important;
    background-attachment: fixed!important;">
    <div class="content " >
        <div class="row justify-content-center my-4">
            <a class="link" href="index.php"><img src="assets/img/logo.png"></a>
        </div>
        <!-- <div class="brand">
            <a class="link" href="index.php"><img src="assets/img/logo.png"></a>
        </div> -->
        <form id="login-form" method="POST" style="border-radius: 7px;">
            <h1 class="login-title">TCGEMPC</h1>
            <h2 class="login-title">Log in</h2>
            <div id="alert" class="alert alert-danger alert-dismissable fade show">
                <button id="closeAlert" class="close" >×</button>
                <div id="alertMessage"></div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-user"></i></div>
                    <input class="form-control" type="text" name="txtusername" id="txtusername" placeholder="Username" autocomplete="off" required>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                    <input class="form-control" type="password" name="txtpassword" id="txtpassword" placeholder="Password" autocomplete="off" required>
                </div>
            </div>
            <div class="form-group d-flex justify-content-between">
                <label class="ui-checkbox ui-checkbox-info">
                    <input type="checkbox" id="showPass">
                    <span class="input-span"></span>Show Password</label>
            </div>
            <div class="form-group">
                <button class="btn btn-info btn-block" name="login_btn" id="login_btn" type="submit">Login</button>
            </div>
        </form>
    </div>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS -->
    <script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS -->
    <script src="./assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
        $(function() {
            $('#alert').hide();

            $('#closeAlert').click(function(e){
                e.preventDefault();
                $('#alert').hide();
            });

            $('#txtusername').focus(function(){
                $('#alert').hide();
            });

            $('#txtpassword').focus(function(){
                $('#alert').hide();
            });

            $('#login-form').validate({
                errorClass: "help-block",
                rules: {
                    username: {
                        required: true,
                        username: true
                    },
                    password: {
                        required: true
                    }
                },
                highlight: function(e) {
                    $(e).closest(".form-group").addClass("has-error")
                },
                unhighlight: function(e) {
                    $(e).closest(".form-group").removeClass("has-error")
                },
            });

            $('#showPass').click(function() {
                if($('#txtpassword').attr('type') == 'password'){
                    $('#txtpassword').attr('type', 'text');
                } else {
                    $('#txtpassword').attr('type', 'password');
                };
            });

            $('#login_btn').click(function(e) {
                e.preventDefault();
                var valid = this.form.checkValidity();
                if (valid) {
                    var username = $('#txtusername').val();
                    var password = $('#txtpassword').val();

                    $.ajax({
                        type: 'POST',
                        url: 'functions/fetch_single.php?action=fetch_single_login',
                        data: {
                            username: username,
                            password: password
                        },
                        success: function(data) {
                            if ($.trim(data) === "Success") {
                                window.location.href = "index.php";
                            } else {
                                $('#alert').show();
                                $('#alertMessage').html("<strong>Oops!</strong> "+ data);
                            }
                        },
                        error: function(data) {
                            $('#alert').show();
                            $('#alertMessage').html("<strong>Oops!</strong> There were errors.");
                        }
                    });

                } else{
                    $('#alert').show();
                    $('#alertMessage').html("<strong>Oops!</strong> Both fields are required!");
                }
            });

        });
    </script>
</body>
</html>