<?php $url_base = getenv('APP_URL'); ?>
<?php $configuracao = App\Model\Financeiro\Configuracao::find(1); ?>
<!DOCTYPE html>
<html style="--primary-bg-color: #368ccb; --primary-bg-hover: #368ccb99; --primary-bg-border: #368ccb20; --primary-transparentcolor: #368ccb20; --primary02: rgba(54, 140, 203, 0.2); --primary05: rgba(54, 140, 203, 0.5);" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ $configuracao->nome }} | Entrar</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Favicon -->
    <link rel="icon" href="<?php print $url_base; ?>/img/img/apple-touch-icon.png" type="image/x-icon"/>

    <!-- Icons css -->
    <link href="<?php print $url_base; ?>/assets/css/icons.css" rel="stylesheet">

    <!--  bootstrap css-->
    <link href="<?php print $url_base; ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Right-sidemenu css -->
    <link href="<?php print $url_base; ?>/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

    <!-- P-scroll bar css-->
    <link href="<?php print $url_base; ?>/assets/plugins/perfect-scrollbar/p-scrollbar.css" rel="stylesheet" />

    <!--- Style css --->
    <link href="<?php print $url_base; ?>/assets/css/style.css" rel="stylesheet">

    <!---Skinmodes css-->
    <link href="<?php print $url_base; ?>/assets/css/skin-modes.css" rel="stylesheet" />
    
    <link href="<?php print $url_base; ?>/assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">

</head>

<body class=" ltr error-page1" style="background-color: #ffffff;">

    <!-- Loader -->
    <div id="global-loader">
        <img src="<?php print $url_base; ?>/assets/img/loader.svg" class="loader-img" alt="Loader">
    </div>


    
    <div class="page" >
        <div class="page-single">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-4 justify-content-center">
                        
                        <div class="row justify-content-center" style="margin-bottom: 40px;">
                        <img src="<?php print $url_base; ?>/img/logo.png" class="sign-favicon" alt="logo" style="height: 80px;">
                        </div>
                        
                        <div class="card-sigin" style="padding: 30px !important; background: #c5e3f4;">
                            <!-- Demo content-->
                            
                            
                            
                            <div class="main-card-signin d-md-flex" style="background: #c5e3f4;">
                                <div class="wd-100p">
                                    <div class="">
                                        <div class="main-signup-header">
                                            
                                            <div class="panel panel-primary">
                                                <div class="panel-body tabs-menu-body border-0 p-3">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab5">
                                                            <form action="/financeiro/login" method="post">
                                                                {{ csrf_field() }} 
                                                                <div class="form-group">
                                                                    <label>Usuário</label> <input name="usuario" class="form-control" placeholder="Entre com seu usuário" type="text" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Senha</label> <input name="senha" class="form-control" placeholder="Entre com sua senha" type="password" required>
                                                                </div><button class="btn btn-dark-gradient btn-block">Entrar</button>
                                                            </form>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!-- /.login-box -->

<!-- JQuery min js -->
<script src="<?php print $url_base; ?>/assets/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap js -->
<script src="<?php print $url_base; ?>/assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="<?php print $url_base; ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- Ionicons js -->
<script src="<?php print $url_base; ?>/assets/plugins/ionicons/ionicons.js"></script>

<!-- Moment js -->
<script src="<?php print $url_base; ?>/assets/plugins/moment/moment.js"></script>

<!-- eva-icons js -->
<script src="<?php print $url_base; ?>/assets/js/eva-icons.min.js"></script>

<!-- generate-otp js -->
<script src="<?php print $url_base; ?>/assets/js/generate-otp.js"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="<?php print $url_base; ?>/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<!-- Theme Color js -->
<script src="<?php print $url_base; ?>/assets/js/themecolor.js"></script>

<!-- custom js -->
<script src="<?php print $url_base; ?>/assets/js/custom.js"></script>

<script src="<?php print $url_base; ?>/assets/plugins/sweet-alert/sweetalert.min.js"></script>


<?php
if (Session::has('status.msg')):

    $error_msg = Session::get("status.msg");
    Session::forget('status.msg');
    
    if (isset($error_msg) AND $error_msg != ""):
        echo("<script>swal(\"$error_msg\");</script>");
    endif;
    
endif;    
?>   


</body>
</html>
