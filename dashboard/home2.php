<?php require_once('data.php'); ?>



<div class="row">


  <div class="col-lg-3 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>
          <?php if ($row_item['Item'] == NULL) { ?>
            <?php echo 0 ?>
          <?php } else {
            echo $row_item['Item'];
          } ?>
        </h3>

        <p>ITEM TERJUAL</p>
      </div>
      <div class="icon">
        <i class="fa fa-cubes"></i>
      </div>
      <a href="?page=tabulasi/penjualantoday" class="small-box-footer">
        Lihat Detail <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3>

          <?php if ($row_return['Jumlah'] == NULL) {
            echo 0;
          } else {
            echo $row_return['Jumlah'];
          } ?></h3>

        <p>ITEM RETURN</p>
      </div>
      <div class="icon">
        <i class="fa fa-money"></i>
      </div>
      <a href="?page=tabulasi/returntoday" class="small-box-footer">
        Lihat Detail <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3><?php echo $totalPenjualan; ?></h3>

        <p>TRANSAKSI HARI INI</p>
      </div>
      <div class="icon">
        <i class="fa fa-users"></i>
      </div>
      <a href="?page=tabulasi/penjualantoday" class="small-box-footer">
        Lihat Detail <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>Rp. <?php echo number_format($row_pendapatan['TotalHarga']);; ?></h3>

        <p>PENDAPATAN</p>
      </div>
      <div class="icon">
        <i class="fa fa-plus-circle"></i>
      </div>
      <a href="?page=tabulasi/penjualan&tgl1=<?= $tglsekarang; ?>&tgl2=<?= $tglsekarang; ?>" class="small-box-footer">
        Lihat Detail <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>


  <!-- ./col -->
</div>
<!-- /.row -->
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <?php require_once('produk/view.php'); ?>
  </div>
</div>