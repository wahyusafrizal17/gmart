<?php
//PENCARIAN
$colname_rs_search = "-1";
if (isset($_GET['faktur'])) {
  $colname_rs_search = $_GET['faktur'];
}
//mysqli_select_db($database_koneksi, $koneksi);
$query_rs_search = sprintf("SELECT faktur FROM transaksitemp WHERE faktur = %s", GetSQLValueString($colname_rs_search, "text"));
$rs_search = mysqli_query($query_rs_search, $koneksi) or die(errorQuery(mysqli_error()));
$row_rs_search = mysqli_fetch_assoc($rs_search);
$totalRows_rs_search = mysqli_num_rows($rs_search);

?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar collapsed">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <?php if (empty($row_rs_profile['photo_admin']) || !file_exists("photos/" . $row_rs_profile['photo_admin'])) { ?>
          <img src="photos/default.png" class="img-circle" width="100%" alt="User Image">
        <?php } else { ?>
          <img src="photos/<?= $row_rs_profile['photo_admin']; ?>" class="img-circle" alt="User Image">
        <?php } ?>

      </div>
      <div class="pull-left info">
        <p><?= $nama; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="hidden" name="page" value="scan/return">
        <input type="text" name="faktur" class="form-control" placeholder="Masukkan Keyword">

        <span class="input-group-btn">
          <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>


      <li class="treeview">
        <a href="#">
          <i class="fa fa-table"></i>
          <span>TRANSAKSI</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="?page=scan/return">
              <i class="fa fa-arrow-left"></i> RETURN (PENJUALAN)
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-th"></i>
          <span>BARCODE</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="?page=barcode/create">
              <i class="fa fa-plus-circle"></i> PRINT BARCODE
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-cog"></i>
          <span>TABULASI DATA</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="?page=tabulasi/penjualan">
              <i class="fa fa-user"></i> PENJUALAN
              <span class="pull-right-container">
                <small class="label pull-right bg-green">New</small>
              </span>
            </a>
          </li>
          <li>
            <a href="?page=tabulasi/produk">
              <i class="fa fa-user"></i> PRODUK
              <span class="pull-right-container">
                <small class="label pull-right bg-green">New</small>
              </span>
            </a>
          </li>
        </ul>
      </li>
      
      <li>
        <a href="<?= $logoutAction; ?>">
          <i class="fa fa-sign-out"></i> <span>KELUAR</span>

        </a>
      </li>


    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

<!-- =============================================== -->