<?php require_once('data.php'); ?>



<div class="row">
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <p style="font-size: 25px;">
          <?php if ($row_item['Item'] == NULL) { ?>
            <?php echo 0 ?>
          <?php } else {
            echo $row_item['Item'];
          } ?>
        </p>

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
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <p style="font-size: 25px;">

          Rp. <?php if ($row_pengeluaran['Jumlah'] == NULL) {
                echo 0;
              } else {
                echo number_format($row_pengeluaran['Jumlah'], 0, ",", ".");
              } ?></p>

        <p>PENGELUARAN HARI INI</p>
      </div>
      <div class="icon">
        <i class="fa fa-money"></i>
      </div>
      <a href="?page=pengeluaran/view" class="small-box-footer">
        Lihat Detail <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <p style="font-size: 25px;"><?php echo $totalPenjualan; ?></p>

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
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <p style="font-size: 25px;">Rp. <?php echo number_format($row_pendapatan['TotalHarga']);; ?></p>

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