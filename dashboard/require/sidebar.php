<?php
//PENCARIAN
$colname_rs_search = "-1";
if (isset($_GET['Search'])) {
  $colname_rs_search = $_GET['Search'];
}


?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
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
        <input type="hidden" name="page" value="tabulasi/detail">
        <input type="text" name="faktur" class="form-control" placeholder="Masukkan Faktur">

        <span class="input-group-btn">
          <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION </li>

      <li class="treeview active">
        <a href="#">
          <i class="fa fa-cog"></i>
          <span>MASTER DATA</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
        
          <li>
            <a href="?page=kategori/view">
              <i class="fa fa-table"></i> CATEGORIES
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
          <li>
            <a href="?page=produk/view">
              <i class="fa fa-cubes"></i> PRODUCTS
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
          <li>
            <a href="?page=tukarproduk/view">
              <i class="fa fa-cubes"></i> PRODUCTS EXCHANGE
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
          <li>
            <a href="?page=kassa/view">
              <i class="fa fa-user"></i> KASSA
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
          <li>
            <a href="?page=pramuniaga/view">
              <i class="fa fa-user"></i> PRAMUNIAGA
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
          <li>
            <a href="?page=member/view">
              <i class="fa fa-users"></i> MEMBER
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
        </ul>
      </li>
      <li class="treeview active">
        <a href="#">
          <i class="fa fa-table"></i>
          <span>TRANSAKSI</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="?page=scan/add">
              <i class="fa fa-shopping-basket"></i> PENJUALAN
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
          <li>
            <a href="?page=pengeluaran/view">
              <i class="fa fa-shopping-basket"></i> PENGELUARAN
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
          <!--<li>
                  <a href="?page=pembelian/view">
                    <i class="fa fa-money"></i> PEMBELIAN
                    <span class="pull-right-container">
                      <!--<small class="label pull-right bg-green">New</small>
                    </span>
                  </a>
                </li>-->
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
          <i class="fa fa-rotate-left"></i>
          <span>HISTORY</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="?page=history/harga">
              <i class="fa fa-money"></i> HARGA PRODUK
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
          <li>
            <a href="?page=history/stok">
              <i class="fa fa-cubes"></i> STOK PRODUK
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
          <li>
            <a href="?page=history/activity">
              <i class="fa fa-edit"></i> LOG HISTORY UPDATE
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
          <li>
            <a href="?page=history/activitydel">
              <i class="fa fa-trash"></i> LOG HISTORY DELETE
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
          <li>
            <a href="?page=history/login">
              <i class="fa fa-arrow-left"></i> LOGIN SYSTEM
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
          <span>STOCK MANAGEMENT</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="?page=manage/add">
              <i class="fa fa-plus-circle"></i> PENAMBAHAN STOK
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
          <li>
            <a href="?page=manage/less">
              <i class="fa fa-minus-circle"></i> PENGURANGAN STOK
              <span class="pull-right-container">
                <!--<small class="label pull-right bg-green">New</small> -->
              </span>
            </a>
          </li>
          <li>
            <a href="?page=manage/min">
              <i class="fa fa-warning"></i> ALERT MINIMAL
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
            <a href="?page=tabulasi/asset">
              <i class="fa fa-user"></i> ASSET
              <span class="pull-right-container">
                <small class="label pull-right bg-green">New</small>
              </span>
            </a>
          </li>
          <li>
            <a href="?page=tabulasi/penjualan">
              <i class="fa fa-user"></i> PENJUALAN
              <span class="pull-right-container">
                <small class="label pull-right bg-green">New</small>
              </span>
            </a>
          </li>
          <li>
            <a href="?page=tabulasi/penukaran">
              <i class="fa fa-user"></i> PENUKARAN
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
      <li class="treeview">
        <a href="#">
          <i class="fa fa-cog"></i>
          <span>LAPORAN</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="?page=preview/penjualan">
              <i class="fa fa-user"></i> PENJUALAN
              <span class="pull-right-container">
                <small class="label pull-right bg-red">New</small>
              </span>
            </a>
          </li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-cog"></i>
          <span>CONFIGURASI</span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right"></span>
          </span>
        </a>
        <ul class="treeview-menu">
          <?php do { ?>
            <li>
              <a href="<?php echo $row_rs_menu['link_menu']; ?>">
                <i class="<?php echo $row_rs_menu['icon_menu']; ?>"></i><?php echo $row_rs_menu['text_menu']; ?>
                <span class="pull-right-container">
                  <small class="label pull-right <?php echo $row_rs_menu['color_menu']; ?>"><?php echo $row_rs_menu['label_menu']; ?></small>
                </span>
              </a>
            </li>
          <?php } while ($row_rs_menu = mysqli_fetch_assoc($rs_menu)); ?>
        </ul>
      </li>
      <li>
        <a href="?page=admin/view">
          <i class="fa fa-truck"></i> <span>KELOLA ADMIN</span>
          <!-- <span class="pull-right-container">
              <small class="label pull-right bg-green">New</small>
            </span> -->
        </a>
      </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

<!-- =============================================== -->