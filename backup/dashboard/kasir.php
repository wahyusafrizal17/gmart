<?php 
require_once('../logout.php');
require_once('../restrict.php'); 
require_once('../Connections/koneksi.php'); 
require_once('require/header.php');

//////mysqli_select_db($database_koneksi);
$query_rs_profile = "SELECT * FROM kassa WHERE id_kassa = '".$ID."'";
$rs_profile = mysqli_query($koneksi, $query_rs_profile) or die(errorQuery(mysqli_error()));
$row_rs_profile = mysqli_fetch_assoc($rs_profile);
$totalRows_rs_profile = mysqli_num_rows($rs_profile); 

?>

<body class="skin-purple-light hold-transition sidebar-collapse sidebar-mini">
                 <div class="preloader">
                  <div class="loading">
                    <img src="poi.gif" width="80">
                    <p>Please Wait ...</p>
                  </div>
                </div>  

<div class="wrapper">

  <header class="main-header">
   <?php require_once('require/kasir_navbar.php'); ?>
  </header>
  <?php require_once('require/kasir_sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
     
       <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
              
             
            <!-- /.box-header -->
            <div class="box-body">
               <?php if (isset($_GET['success'])) { 
			   		sukses('Selamat! Anda berhasil login');
			    } ?>
              <?php
              if(isset($_GET["page"]) && $_GET["page"] != "home"){
                  if(file_exists(htmlentities($_GET["page"]).".php")){
                            include(htmlentities($_GET["page"]).".php");
                      }else{
                            include("404.php");
                      }
                }else{
                    include("scan/add.php");
              } 
              ?>
               
             
             
           
           </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
 
  
<?php require_once('require/kasir_footer.php'); ?>