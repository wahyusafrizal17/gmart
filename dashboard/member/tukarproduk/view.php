<?php require_once('tukarproduk/page1.php'); ?>

<div class="box box-default color-palette-box">
  <div class="box-header with-border">
    <div class="pull-left">
      <h3 class="box-title"><i class="fa fa-tag"></i> DAFTAR PRODUK</h3>
    </div>
    <div class="pull-right">
        <?php if ($_SESSION['MM_Level'] != 4) { ?>
      <a href="report/penjualan.php?tgl1=<?= $tglsekarang; ?>&tgl2=<?= $tglsekarang; ?>&kasir=-1" target="_blank" class="btn btn-xs btn-warning"><span class="fa fa-star"></span> Buat Laporan Hari ini</a>
      <a href="print/produk.php" target="_blank" class="btn btn-xs btn-success"><span class="fa fa-print"></span> Print Stok Barang Menipis</a> <a href="?page=tukarproduk/insert" class="btn btn-xs btn-primary"><span class="fa fa-plus-circle"></span> Add Product</a>
      <?php } ?>
    </div>
  </div>
  <div class="box-body">

    <div class="row">
      <form method="get">
        <div class="col-md-10">
          <input type="text" name="cari" class="form-control" placeholder="Cari Kode Produk / Nama Produk / Kategori">
        </div>

        <div class="col-md-2">
          <button type="submit" class="btn btn-primary btn-block"><span class="fa fa-search"></span> Search</button>
          <input type="hidden" name="page" value="tukarproduk/view">
          <a href="camera.php" class="btn btn-primary btn-block"><span class="fa fa-barcode"></span> Scan Barcode</a>
        </div>

      </form>
    </div>
    <br />
    <div class="row">

      <div class="col-md-12">
        <div class="table-responsive">
          <?php if ($totalRows_Produk > 0) { ?>
            <table width="100%" class="table table-striped">
              <tr>
                <th>
                  <div><strong>NAMA PRODUK</strong></div>
                </th>
                <th>
                  <div><strong>DETAIL</strong></div>
                </th>
                <th>
                  <div><strong>OPSI</strong></div>
                </th>
                <th>&nbsp;</th>

              </tr>
              <?php $no = 1;
              do { ?>
                <tr>
                  
                  <td class="text-uppercase"><strong><?php echo $row_Produk['namaproduk']; ?> ( <?php echo $row_Produk['kodeproduk']; ?> )</strong><br />
                  <td>
                    Stok : <?php echo $row_Produk['stok']; ?> <?php echo $row_Produk['satuan']; ?><br />
                    <?php if ($level == 2) { ?>
                      
                    <?php } ?>
                    HARGA : <?php echo number_format($row_Produk['point']); ?> Point</td>
                  </td>
                  <td>
                    <?php if ($_SESSION['MM_Level'] != 4) { ?>
                    <a href="?page=tukarproduk/update&id=<?= $row_Produk['id']; ?>" class="btn btn-warning btn-block"><span class="fa fa-edit"></span> </a>
                    <a href="?page=tukarproduk/delete&id=<?= $row_Produk['id']; ?>"onClick="return confirm('YAKIN MAU HAPUS ITEM INI?')" class="btn btn-danger  btn-block"><span class="fa fa-trash"></span> </a>
<?php } ?>
                  </td>

                  <!-- <form id="form1" name="form1" method="get" target="_blank" action="print/barcodeget.php">
                      <div class="input-group margin">
                        <input type="text" name="qty" placeholder="" class="form-control" required>
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-info btn-flat">Print</button>
                        </span>
                      </div>
                      <input type="hidden" name="barcode" value="<?= $row_Produk['kodeproduk']; ?>">

                    </form> -->

                  <td><?php if ($row_Produk['minProduk'] >= $row_Produk['stok']) { ?>
                      <div class="callout callout-info blink">
                        <h4>Informasi</h4>
                        <p><?php echo $row_Produk['alertproduk']; ?></p>
                      </div>
                    <?php } ?>
                  </td>

                </tr>
              <?php
                $no++;
              } while ($row_Produk = mysql_fetch_assoc($rs_Produk)); ?>
            </table>
          <?php } else {
            danger('Oops', 'Produk tersebut tidak dapat kami temukan :(');
          }
          ?>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.box-body -->
</div>

<?php require_once('produk/Page2.php'); ?>