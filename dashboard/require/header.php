<?php
//SESI LOGIN
$colname_rs_login = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_login = $_SESSION['MM_Username'];
}
//mysql_select_db($database_koneksi, $koneksi);
$query_rs_login = sprintf("SELECT * FROM vw_login WHERE Login = %s", GetSQLValueString($colname_rs_login, "text"));
$rs_login = mysqli_query($koneksi, $query_rs_login) or die(errorQuery(mysqli_error($koneksi)));
$row_rs_login = mysqli_fetch_assoc($rs_login);
$totalRows_rs_login = mysqli_num_rows($rs_login);

$ID = $row_rs_login['ID'];
$login = $row_rs_login['Login'];
$nama = $row_rs_login['Nama'];
$level = $row_rs_login['Level'];
/*
//----------- 26 desember - cabang ---
$cabang = $row_rs_login['Cabank'];
//mysql_select_db($database_koneksi, $koneksi);
$query_rs_cab = "SELECT * FROM tb_cabang WHERE id_cabang = '".$cabang."' LIMIT 1";
$rs_cab = mysql_query($query_rs_cab, $koneksi) or die(errorQuery(mysql_error()));
$row_rs_cab = mysql_fetch_assoc($rs_cab);
$totalRows_rs_cab = mysql_num_rows($rs_cab);

$judulcab = $row_rs_cab['judul_cabang'];
$alamatcab = $row_rs_cab['alamat_cabang'];
$notelpcab = $row_rs_cab['notelp_cabang'];
*/ 
//MENAMPILKAN MENU
//mysql_select_db($database_koneksi, $koneksi);
$query_rs_menu = "SELECT * FROM tb_menu WHERE level_menu LIKE '%".$level."%' ORDER BY nourut_menu ASC";
$rs_menu = mysqli_query($koneksi, $query_rs_menu) or die(errorQuery(mysqli_error($koneksi)));
$row_rs_menu = mysqli_fetch_assoc($rs_menu);
$totalRows_rs_menu = mysqli_num_rows($rs_menu);
?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../assets/bower_components/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../assets/bower_components/Ionicons/css/ionicons.min.css">
    <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">  
  <!-- DataTables -->
  <link rel="stylesheet" href="../assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">   
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../assets/bower_components/morris.js/morris.css">
    
   <link rel="stylesheet" href="../assets/dist/css/animate.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" type="text/css" href="../assets/bower_components/dist/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script src="../assets/js/jquery-2.2.1.min.js"></script>
<script>
$(document).ready(function(){
$(".preloader").fadeOut();
})
</script>
<style type="text/css">
.preloader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background-color: #fff;
}
.preloader .loading {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%,-50%);
  font: 14px arial;
}

.blink {
  animation: blink 1s infinite;
}

@keyframes blink {
  0% {
    opacity: 1;
  }
  50% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
</style>

</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->