<?php
    session_start();  
    if(!isset($_SESSION['member_id'])){
        header("Location: login.php");
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION);
        header("Location: login.php");
    }
    $user_type = $_SESSION['user_type'];
?>
<?php include('include/header_sidebar.php');?>
    <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
        <?php
            if (isset($_SESSION['message'])) {
                echo '<div id="alert" class="alert alert-'.$_SESSION["msg_type"].'">'.$_SESSION["message"].'</div>';
                unset($_SESSION['message']);
            }
        ?>
        <div id="alert2" class="alert alert-danger alert-dismissable fade show">
                <button id="closeAlert" class="close" >×</button>
                <div id="alertMessage"></div>
        </div>
        <div class="page-content fade-in-up">
            <div class="row justify-content-center">
                <div class="col-md-6">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Change Password</div>
                        <div class="ibox-tools">
                            <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form class="form-horizontal" id="form_change_pass" method="POST" action="functions/update.php?action=change_password">
                            <input type="hidden" id="member_id" name="member_id" value="<?php echo $_SESSION['member_id']?>">
                            <div class="form-group">
                                <label class="col-form-label">Old Password</label>
                                <div class="input-group-icon right">
                                    <div id="btnOldPass" class="input-icon"><i id="iconOldPass" class="fa fa-eye"></i></div>
                                    <input class="form-control" type="password" id="old_pass" name="old_pass" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">New Password</label>
                                <div class="input-group-icon right">
                                    <div id="btnNewPass" class="input-icon"><i id="iconNewPass" class="fa fa-eye"></i></div>
                                    <input class="form-control" minlength="6" type="password" id="new_pass" name="new_pass" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Confirm Password</label>
                                <div class="input-group-icon right">
                                    <div id="btnConfirmPass" class="input-icon"><i id="iconConfirmPass" class="fa fa-eye"></i></div>
                                    <input class="form-control" minlength="6" type="password" id="confirm_pass" name="confirm_pass" required>
                                </div>
                            </div>
                            <div class="form-group row">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button class="btn btn-info col-sm-12" id="submitBtn" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
<?php include('include/footer.php');?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#alert2').hide();

        $('#submitBtn').click(function(e) {
            var new_pass = $('#new_pass').val();
            var confirm_pass = $('#confirm_pass').val();
            if (new_pass.indexOf(' ')>=0 || confirm_pass.indexOf(' ')>=0) {
                $('#alert2').show();
                $('#alertMessage').html("<strong>Oops!</strong> Space is not accepted.");
                e.preventDefault();
            }
        });

        $('#new_pass').focus(function(){
            $('#alert2').hide();
        });

        $('#confirm_pass').focus(function(){
            $('#alert2').hide();
        });

        $('#btnOldPass').click(function() {
            if($('#old_pass').attr('type') == 'password'){
                $('#old_pass').attr('type', 'text');
                $("#iconOldPass").attr('class', 'fa fa-eye-slash');

            } else {
                $('#old_pass').attr('type', 'password');
                $("#iconOldPass").attr('class', 'fa fa-eye');
            };
        });

        $('#btnNewPass').click(function() {
            if($('#new_pass').attr('type') == 'password'){
                $('#new_pass').attr('type', 'text');
                $("#iconNewPass").attr('class', 'fa fa-eye-slash');

            } else {
                $('#new_pass').attr('type', 'password');
                $("#iconNewPass").attr('class', 'fa fa-eye');
            };
        });

        $('#btnConfirmPass').click(function() {
            if($('#confirm_pass').attr('type') == 'password'){
                $('#confirm_pass').attr('type', 'text');
                $("#iconConfirmPass").attr('class', 'fa fa-eye-slash');

            } else {
                $('#confirm_pass').attr('type', 'password');
                $("#iconConfirmPass").attr('class', 'fa fa-eye');
            };
        });
        
        setTimeout(function() {
            document.getElementById("alert").style.display = "none";
        }, 5000);

        $('#closeAlert').click(function(e){
            e.preventDefault();
            $('#alert2').hide();
        });

    });
</script>