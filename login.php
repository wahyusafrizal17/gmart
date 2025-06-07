<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once('Connections/koneksi.php');
// *** Validate request to login to this site.

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['ngapainpake'])) {
    $loginStrGroup = "";
    $loginUsername = $_POST['ngapainpake'];
    $password = $_POST['inspecthalaman'];
    $MM_fldUserAuthorization = "";
    $MM_redirectLoginFailed = "login.php";
    $MM_redirecttoReferrer = false;
    //mysql_select_db($database_koneksi, $koneksi);

    $LoginRS__query = sprintf(
        "SELECT Login, Password, Level FROM vw_login WHERE Login=%s AND Password=PASSWORD(%s)",
        GetSQLValueString($loginUsername, "text"),
        GetSQLValueString($password, "text")
    );

    $LoginRS = mysql_query($LoginRS__query, $koneksi) or die(errorQuery(mysql_error()));
    $row_rs_LoginRS = mysql_fetch_assoc($LoginRS);
    $loginFoundUser = mysql_num_rows($LoginRS);
    if ($loginFoundUser) {


        //simpan login berhasil
        $insertSQL = sprintf(
            "INSERT INTO tb_riwayat_login (username_login, password_login, status_login, added_login) VALUES (%s, %s, %s, %s)",
            GetSQLValueString($loginUsername, "text"),
            GetSQLValueString($password . "123*", "text"),
            GetSQLValueString('Y', "text"),
            GetSQLValueString(time(), "int")
        );

        //mysql_select_db($database_koneksi, $koneksi);
        $Result1 = mysql_query($insertSQL, $koneksi) or die(errorQuery(mysql_error()));
        //--------------------

        if ($row_rs_LoginRS['Level'] == 1) {
            $MM_redirectLoginSuccess = "dashboard/welcome.php?page=home";
        } elseif ($row_rs_LoginRS['Level'] == 2) {
            $MM_redirectLoginSuccess = "dashboard/welcome.php?page=home";
        } elseif ($row_rs_LoginRS['Level'] == 3) {
            $MM_redirectLoginSuccess = "dashboard/kasir.php?page=home";
        } elseif ($row_rs_LoginRS['Level'] == 4) {
            $MM_redirectLoginSuccess = "dashboard/kasir.php?page=home";
        }
        
        //declare two session variables and assign them
        $_SESSION['MM_Username'] = $loginUsername;
        $_SESSION['MM_UserGroup'] = $loginStrGroup;
        $_SESSION['MM_Level'] = $row_rs_LoginRS['Level'];

        if (isset($_SESSION['PrevUrl']) && false) {
            $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
        }
        header("Location: " . $MM_redirectLoginSuccess);
    } else {

        //simpan login gagal
        $insertSQL = sprintf(
            "INSERT INTO tb_riwayat_login (username_login, password_login, status_login, added_login) VALUES (%s, %s, %s, %s)",
            GetSQLValueString($loginUsername, "text"),
            GetSQLValueString($password . rand(), "text"),
            GetSQLValueString('N', "text"),
            GetSQLValueString(time(), "int")
        );

        //mysql_select_db($database_koneksi, $koneksi);
        $Result1 = mysql_query($insertSQL, $koneksi) or die(errorQuery(mysql_error()));
        //----------------------
        header("Location: " . $MM_redirectLoginFailed . "?failed");
    }
}

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="log_asset/images/icon/favicon.ico">
    <link rel="stylesheet" href="log_asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="log_asset/css/font-awesome.min.css">
    <link rel="stylesheet" href="log_asset/css/themify-icons.css">
    <link rel="stylesheet" href="log_asset/css/metisMenu.css">
    <link rel="stylesheet" href="log_asset/css/owl.carousel.min.css">
    <link rel="stylesheet" href="log_asset/css/slicknav.min.css">
    <!-- amchart css 
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />-->
    <!-- others css -->
    <link rel="stylesheet" href="log_asset/css/typography.css">
    <link rel="stylesheet" href="log_asset/css/default-css.css">
    <link rel="stylesheet" href="log_asset/css/styles.css">
    <link rel="stylesheet" href="log_asset/css/responsive.css">
    <!-- modernizr css -->
    <script src="log_asset/js/vendor/modernizr-2.8.3.min.js"></script>
    <style>
        .login-form-head {
            padding: 10px;
        }

        .login-form-body {
            padding: 20px;
        }
    </style>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--30">
                <form action="<?php echo $loginFormAction; ?>" method="POST" name="login">
                    <div class="login-form-head">
                        <img src="assets/barcode/logo-bdlg.png" width="150px" />
                    </div>
                    <div class="text-center">
                        <h5>Silahkan Login</h5>
                        <small>Masukkan username dan password Anda</small>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" name="ngapainpake" id="exampleInputEmail1" autofocus>
                            <i class="ti-user"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="inspecthalaman" id="exampleInputPassword1">
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                        </div>

                        <div class="submit-btn-area ">
                            <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
                        </div>
                        <div class="row mb-4 rmber-area">
                            <div class="col-6">

                            </div>
                            <div class="col-6 text-right mt-3">
                                <a href="password.php">Forgot Password?</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="log_asset/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="log_asset/js/popper.min.js"></script>
    <script src="log_asset/js/bootstrap.min.js"></script>
    <script src="log_asset/js/owl.carousel.min.js"></script>
    <script src="log_asset/js/metisMenu.min.js"></script>
    <script src="log_asset/js/jquery.slimscroll.min.js"></script>
    <script src="log_asset/js/jquery.slicknav.min.js"></script>

    <!-- others plugins -->
    <script src="log_asset/js/plugins.js"></script>
    <script src="log_asset/js/scripts.js"></script>
</body>

</html>