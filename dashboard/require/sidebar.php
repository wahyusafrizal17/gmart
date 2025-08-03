<?php
//PENCARIAN
$colname_rs_search = "-1";
if (isset($_GET['Search'])) {
  $colname_rs_search = $_GET['Search'];
}
?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar" style="background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel" style="background: rgba(255,255,255,0.1); border-radius: 15px; margin: 15px; padding: 15px;display: none">
      <div class="pull-left image">
        <?php if (empty($row_rs_profile['photo_admin']) || !file_exists("photos/" . $row_rs_profile['photo_admin'])) { ?>
          <img src="photos/default.png" class="img-circle" width="100%" alt="User Image" style="border: 3px solid rgba(255,255,255,0.3);height: 45px;width: 45px;">
        <?php } else { ?>
          <img src="photos/<?= $row_rs_profile['photo_admin']; ?>" class="img-circle" alt="User Image" style="border: 3px solid rgba(255,255,255,0.3);height: 45px;width: 45px;">
        <?php } ?>
      </div>
      <div class="pull-left info" style="color: white;">
        <p style="font-weight: bold; margin: 0;"><?= $nama; ?></p>
        <a href="#" style="color: #2ecc71;"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    
    <!-- search form -->
    <form action="" method="get" class="sidebar-form" style="margin: 15px;border: none;">
      <div class="input-group" style="border-radius: 25px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <input type="hidden" name="page" value="tabulasi/detail">
        <input type="text" name="faktur" class="form-control" placeholder="Cari Faktur..." style="border: none; padding: 12px 15px;">
        <span class="input-group-btn">
          <button type="submit" id="search-btn" class="btn btn-flat" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);color: white;border: none;padding: 7px 15px;">
            <i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>
    
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree" style="margin: 15px;">
      <li class="header" style="color: rgba(255,255,255,0.8);font-weight: bold;text-transform: uppercase;letter-spacing: 1px;padding: 15px 0;border-bottom: 1px solid rgba(255,255,255,0.1);border-top: 1px solid rgba(255,255,255,0.1);background: none;">MAIN NAVIGATION</li>

      <li class="treeview active">
        <a href="#" style="background: rgba(255,255,255,0.1); border-radius: 10px; margin: 5px 0; transition: all 0.3s ease;">
          <i class="fa fa-cog" style="color: #3498db;"></i>
          <span style="color: white; font-weight: bold;">MASTER DATA</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right" style="color: white;"></i>
          </span>
        </a>
        <ul class="treeview-menu" style="background: rgba(0,0,0,0.2); border-radius: 10px; margin: 5px 0;">
          <li>
            <a href="?page=kategori/view" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-table" style="color: #e74c3c;"></i> CATEGORIES
            </a>
          </li>
          <li>
            <a href="?page=produk/view" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-cubes" style="color: #f39c12;"></i> PRODUCTS
            </a>
          </li>
          <li>
            <a href="?page=tukarproduk/view" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-exchange" style="color: #9b59b6;"></i> PRODUCTS EXCHANGE
            </a>
          </li>
          <li>
            <a href="?page=kassa/view" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-user" style="color: #2ecc71;"></i> KASSA
            </a>
          </li>
          <li>
            <a href="?page=pramuniaga/view" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-users" style="color: #1abc9c;"></i> PRAMUNIAGA
            </a>
          </li>
          <li>
            <a href="?page=member/view" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-users" style="color: #e67e22;"></i> MEMBER
            </a>
          </li>
        </ul>
      </li>
      
      <li class="treeview active">
        <a href="#" style="background: rgba(255,255,255,0.1); border-radius: 10px; margin: 5px 0; transition: all 0.3s ease;">
          <i class="fa fa-table" style="color: #e74c3c;"></i>
          <span style="color: white; font-weight: bold;">TRANSAKSI</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right" style="color: white;"></i>
          </span>
        </a>
        <ul class="treeview-menu" style="background: rgba(0,0,0,0.2); border-radius: 10px; margin: 5px 0;">
          <li>
            <a href="?page=scan/add" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease; background: rgba(46, 204, 113, 0.2);">
              <i class="fa fa-shopping-basket" style="color: #2ecc71;"></i> PENJUALAN
            </a>
          </li>
          <li>
            <a href="?page=pengeluaran/view" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-money" style="color: #f39c12;"></i> PENGELUARAN
            </a>
          </li>
          <li>
            <a href="?page=scan/return" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-arrow-left" style="color: #e74c3c;"></i> RETURN (PENJUALAN)
            </a>
          </li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#" style="background: rgba(255,255,255,0.1); border-radius: 10px; margin: 5px 0; transition: all 0.3s ease;">
          <i class="fa fa-rotate-left" style="color: #9b59b6;"></i>
          <span style="color: white; font-weight: bold;">HISTORY</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right" style="color: white;"></i>
          </span>
        </a>
        <ul class="treeview-menu" style="background: rgba(0,0,0,0.2); border-radius: 10px; margin: 5px 0;">
          <li>
            <a href="?page=history/harga" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-money" style="color: #f39c12;"></i> HARGA PRODUK
            </a>
          </li>
          <li>
            <a href="?page=history/stok" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-cubes" style="color: #e74c3c;"></i> STOK PRODUK
            </a>
          </li>
          <li>
            <a href="?page=history/activity" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-edit" style="color: #3498db;"></i> LOG HISTORY UPDATE
            </a>
          </li>
          <li>
            <a href="?page=history/activitydel" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-trash" style="color: #e74c3c;"></i> LOG HISTORY DELETE
            </a>
          </li>
          <li>
            <a href="?page=history/login" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-sign-in" style="color: #2ecc71;"></i> LOGIN SYSTEM
            </a>
          </li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#" style="background: rgba(255,255,255,0.1); border-radius: 10px; margin: 5px 0; transition: all 0.3s ease;">
          <i class="fa fa-th" style="color: #e67e22;"></i>
          <span style="color: white; font-weight: bold;">STOCK MANAGEMENT</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right" style="color: white;"></i>
          </span>
        </a>
        <ul class="treeview-menu" style="background: rgba(0,0,0,0.2); border-radius: 10px; margin: 5px 0;">
          <li>
            <a href="?page=manage/add" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-plus-circle" style="color: #2ecc71;"></i> PENAMBAHAN STOK
            </a>
          </li>
          <li>
            <a href="?page=manage/less" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-minus-circle" style="color: #e74c3c;"></i> PENGURANGAN STOK
            </a>
          </li>
          <li>
            <a href="?page=manage/min" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-warning" style="color: #f39c12;"></i> ALERT MINIMAL
            </a>
          </li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#" style="background: rgba(255,255,255,0.1); border-radius: 10px; margin: 5px 0; transition: all 0.3s ease;">
          <i class="fa fa-barcode" style="color: #9b59b6;"></i>
          <span style="color: white; font-weight: bold;">BARCODE</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right" style="color: white;"></i>
          </span>
        </a>
        <ul class="treeview-menu" style="background: rgba(0,0,0,0.2); border-radius: 10px; margin: 5px 0;">
          <li>
            <a href="?page=barcode/create" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-print" style="color: #3498db;"></i> PRINT BARCODE
            </a>
          </li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#" style="background: rgba(255,255,255,0.1); border-radius: 10px; margin: 5px 0; transition: all 0.3s ease;">
          <i class="fa fa-cog" style="color: #1abc9c;"></i>
          <span style="color: white; font-weight: bold;">TABULASI DATA</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right" style="color: white;"></i>
          </span>
        </a>
        <ul class="treeview-menu" style="background: rgba(0,0,0,0.2); border-radius: 10px; margin: 5px 0;">
          <li>
            <a href="?page=tabulasi/asset" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-building" style="color: #e67e22;"></i> ASSET
              <span class="pull-right-container">
                <small class="label pull-right" style="background: #2ecc71;">New</small>
              </span>
            </a>
          </li>
          <li>
            <a href="?page=tabulasi/penjualan" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-shopping-cart" style="color: #2ecc71;"></i> PENJUALAN
              <span class="pull-right-container">
                <small class="label pull-right" style="background: #2ecc71;">New</small>
              </span>
            </a>
          </li>
          <li>
            <a href="?page=tabulasi/penukaran" style="color: rgba(255,255,255,0.9); padding: 10px 15px; border-radius: 8px; margin: 2px 5px; transition: all 0.3s ease;">
              <i class="fa fa-exchange" style="color: #9b59b6;"></i> PENUKARAN
              <span class="pull-right-container">
                <small class="label pull-right" style="background: #2ecc71;">New</small>
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