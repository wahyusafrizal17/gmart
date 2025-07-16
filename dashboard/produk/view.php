<?php require_once('produk/Page1.php'); ?>

<div class="box box-default color-palette-box">
  <div class="box-header with-border">
    <div class="pull-left">
      <h3 class="box-title"><i class="fa fa-tag"></i> DAFTAR PRODUK</h3>
    </div>
    <div class="pull-right">
        <?php if ($_SESSION['MM_Level'] != 4) { ?>
      <a href="report/penjualan.php?tgl1=<?= $tglsekarang; ?>&tgl2=<?= $tglsekarang; ?>&kasir=-1" target="_blank" class="btn btn-xs btn-warning"><span class="fa fa-star"></span> Buat Laporan Hari ini</a>
      <a href="print/produk.php" target="_blank" class="btn btn-xs btn-success"><span class="fa fa-print"></span> Print Stok Barang Menipis</a> <a href="?page=kategori/view" class="btn btn-xs btn-primary"><span class="fa fa-plus-circle"></span> Add Product</a>
      <?php } ?>
    </div>
  </div>
  <div class="box-body">

    <div class="row">
      <form method="get">
        <div class="col-md-10">
          <input type="text" name="cari" class="form-control" placeholder="Cari Kode Produk / Nama Produk / Kategori" autofocus required>
        </div>

        <div class="col-md-2">
          <button type="submit" class="btn btn-primary btn-block"><span class="fa fa-search"></span> Search</button>
          <input type="hidden" name="page" value="produk/view">
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
                <th width="10%">&nbsp;</th>
                <th>
                  <div align="center"><strong>NAMA PRODUK</strong></div>
                </th>
                <th>
                  <div align="center"><strong>DETAIL</strong></div>
                </th>
                <th>MANAGE STOK</th>
                <th>&nbsp;</th>

              </tr>
              <?php $no = 1;
              do { ?>
                <tr>
                  <td>
                    <?php if ($_SESSION['MM_Level'] != 4) { ?>
                    <a href="?page=produk/update&id_produk=<?= $row_Produk['idproduk']; ?>" class="btn btn-warning btn-block"><span class="fa fa-edit"></span> </a>
                    <a href="?page=produk/delete&id_produk=<?= $row_Produk['idproduk']; ?>"onClick="return confirm('YAKIN MAU HAPUS ITEM INI?')" class="btn btn-danger  btn-block"><span class="fa fa-trash"></span> </a>
<?php } ?>
                  </td>
                  <td class="text-uppercase"><a href="?page=history/produk&kode=<?= $row_Produk['kodeproduk']; ?>" title="<?php echo $row_Produk['deskproduk']; ?>" style="font-size:20px;"><strong><?php echo $row_Produk['namaproduk']; ?> ( <?php echo $row_Produk['kodeproduk']; ?> )</strong></a><br />
                   <div align="left" style="font-size:20px"> Stok : <?php echo $row_Produk['stok']; ?> <?php echo $row_Produk['satuan']; ?><br />
                    <?php if ($level == 2) { ?>
                      
                    <?php } ?>
                    <div align="left" style="font-size:20px">
                    HARGA : Rp. <?php echo number_format($row_Produk['hargajual']); ?></td>
                  <td>
                    <p><span class="text-uppercase">Category : <a href="?page=kategori/produk&kategori=<?php echo $row_Produk['kategori']; ?>" target="_blank"><?php echo $row_Produk['namakategori']; ?></a></span><br />
                      Status : <?php echo $row_Produk['statusproduk']; ?><br />
                      oleh : <?php echo $row_Produk['Nama']; ?> # <?php echo date("d M Y H:m:s", $row_Produk['addedproduk']); ?><br />
                      <?php if ($row_Produk['updatedproduk'] != 0) {; ?>
                        diubah pada : <?php echo date("d M Y H:m:s", $row_Produk['updatedproduk']); ?>
                      <?php } ?>
                    </p>
                    <p>&nbsp;</p>
                  </td>
                  <td>
                    <?php if ($_SESSION['MM_Level'] != 5) { ?>
                    <div align="center" style="font-size:36px">
                      <a href="?page=manage/add&search=<?php echo $row_Produk['kodeproduk']; ?>"><span class="fa fa-plus-circle text-success"></span></a>
                    </div>
                    <?php } ?>
                    <?php if ($_SESSION['MM_Level'] != 4) { ?>
                    <div align="center" style="font-size:36px">
                      <a href="?page=manage/less&search=<?php echo $row_Produk['kodeproduk']; ?>"><span class="fa fa-minus-circle text-danger"></span></a>
                    </div>
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
              } while ($row_Produk = mysqli_fetch_assoc($rs_Produk)); ?>
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