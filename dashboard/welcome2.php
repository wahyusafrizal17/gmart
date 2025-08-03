<?php
require_once('../logout.php');
require_once('../restrict.php');
require_once('../Connections/koneksi.php');
require_once('require/header.php');

////mysqli_select_db($database_koneksi, $koneksi);
$query_rs_profile = "SELECT * FROM tb_admin WHERE id_admin = '" . $ID . "'";
$rs_profile = mysqli_query($koneksi, $query_rs_profile) or die(errorQuery(mysqli_error($koneksi)));
$row_rs_profile = mysqli_fetch_assoc($rs_profile);
$totalRows_rs_profile = mysqli_num_rows($rs_profile);

if ($level > 2) {
  pesanlink('Maaf! Ini bukan wilayah Anda.', '../keluar.php');
}

$collaps = "skin-purple-light fixed sidebar-mini sidebar-mini-expand-feature";
if ((isset($_GET['page'])) && ($_GET['page'] == "scan/add")) {
  $collaps = "skin-purple-light fixed sidebar-mini sidebar-mini-expand-feature sidebar-collapse";
}
?>

<body class="<?= $collaps; ?>">
  <div class="wrapper">

    <header class="main-header">
      <?php require_once('require/navbar.php'); ?>
    </header>
    <?php require_once('require/sidebar.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title"><a href="?page=home">DASHBOARD</a></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <?php if (isset($_GET['success'])) {
                  sukses('Selamat! Anda berhasil login');
                } ?>
                <?php
                if (isset($_GET["page"]) && $_GET["page"] != "home") {
                  if (file_exists(htmlentities($_GET["page"]) . ".php")) {
                    include(htmlentities($_GET["page"]) . ".php");
                  } else {
                    include("404.php");
                  }
                } else {
                  include("home.php");
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


    <?php require_once('require/footer.php'); ?>