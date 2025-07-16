<?php
//require_once('izin.php');
require_once('preview/page1.php'); ?>


<div class="box box-default color-palette-box">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> BUAT LAPORAN PENJUALAN BERDASARKAN TANGGAL</h3>
  </div>
  <div class="box-body">

    <div class="row">

      <div class="col-md-12">
        <div class="row">
          <label>Cari berdasarkan tanggal </label>
          <form class="form-horizontal" name="periode" action="" method="get">
            <div class="box-body">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="tgl1" class="control-label">Tanggal Awal</label>
                  <input type="text" name="tgl1" value="<?php if (isset($_GET['tgl1'])) {
                                                          echo $_GET['tgl1'];
                                                        } else {
                                                          echo  $tglsekarang;
                                                        } ?>" class="form-control" id="datepicker2" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="tgl2" class="control-label">Tanggal Akhir</label>
                  <input type="text" name="tgl2" value="<?php if (isset($_GET['tgl2'])) {
                                                          echo $_GET['tgl2'];
                                                        } else {
                                                          echo $tglsekarang;
                                                        } ?>" class="form-control" id="datepicker3" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="tgl2" class="control-label">Pilih Kasir</label>
                  <select name="kasir" id="" class="form-control">
                    <option value="0">-- Pilih Kasir --</option>
                    <?php do {  ?>
                      <option value="<?php echo $row_Kassa['id'] ?>" <?php if (!(strcmp($row_Kassa['id'], htmlentities($colname, ENT_COMPAT, 'utf-8')))) {
                                                                        echo "SELECTED";
                                                                      } ?>><?php echo $row_Kassa['Nama'] ?></option>
                    <?php } while ($row_Kassa = mysql_fetch_assoc($Kassa)); ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="tgl2" class="control-label">Pilih Jenis Bayar</label>
                  <select name="jenisbayar" id="" class="form-control">
                    <option value="0">-- Keseluruhan --</option>
                    <?php do {  ?>
                      <option value="<?php echo $row_Faktur['jenisbayar'] ?>" <?php if (!(strcmp($row_Faktur['jenisbayar'], htmlentities($colname, ENT_COMPAT, 'utf-8')))) {
                                                                                echo "SELECTED";
                                                                              } ?>><?php echo $row_Faktur['jenisbayar'] ?></option>
                    <?php } while ($row_Faktur = mysql_fetch_assoc($Faktur)); ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="kategori" class="control-label"> &nbsp;</label>
                  <button type="submit" class="btn btn-block btn-info pull-right">Filter</button>
                </div>
              </div>
            </div>

            <!-- /.box-footer -->
            <input type="hidden" name="page" value="preview/penjualan" />
          </form>
        </div>
      </div>
    </div>
    <br />
    <br />
    <?php if ($totalRows_Penjualan > 0) { ?>
      <div class="row">
        <div class="col-md-12">
          <?php if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) { ?>
            <?php title('success', 'HASIL PENCARIAN DITEMUKAN', 'Pada tanggal ' . $_GET['tgl1'] . ' s/d tanggal ' . $_GET['tgl2'] . ' ditemukan sebanyak ' . $totalRows_Penjualan . ' transaksi'); ?>
          <?php } ?>

          <p><a href="report/penjualan.php?tgl1=<?= $tgl1; ?>&tgl2=<?= $tgl2; ?>&kasir=<?= $colname; ?>" target="_blank" class="btn btn-primary"><span class="fa fa-print"></span> Cetak Laporan</a> <a href="report/penjualanitem.php?tgl1=<?= $tgl1; ?>&tgl2=<?= $tgl2; ?>&kasir=<?= $colname; ?>" target="_blank" class="btn btn-info"><span class="fa fa-list"></span> Cetak Laporan Detail</a></p>

          <div class="table-responsive">
            <table width="100%" class="table table-striped table-bordered">
              <tr>
                <th width="3%" bgcolor="#006699">
                  <div align="center" class="style1">NO.</div>
                </th>
                <th width="9%" bgcolor="#006699">
                  <div align="center" class="style1">FAKTUR</div>
                </th>
                <th width="19%" bgcolor="#006699">
                  <div align="center" class="style1">TANGGAL / WAKTU</div>
                </th>
                <th width="15%" bgcolor="#006699">
                  <div align="center" class="style1">TOTAL BELANJA</div>
                </th>
                <th width="10%" bgcolor="#006699">
                  <div align="center" class="style1">POTONGAN</div>
                </th>
                <th width="10%" bgcolor="#006699">
                  <div align="center" class="style1">LABA</div>
                </th>
                <th width="16%" bgcolor="#006699">
                  <div align="center" class="style1">KASSA</div>
                </th>
                <th width="23%" bgcolor="#006699">
                  <div align="center" class="style1">STATUS</div>
                </th>
              </tr>
              <?php
              $total = 0;
              $no = 1;
              do {

                //hitung laba

                $query_laba = sprintf("SELECT faktur, tanggal, hargadasar, harga, diskon, qty, (hargadasar * qty) as hd, (harga * qty) as hj, sum((((harga * qty) - (hargadasar * qty)))-diskon) as laba, ((harga * qty) - diskon) as sisadiskon  FROM `transaksidetail` WHERE faktur = %s GROUP BY faktur",  GetSQLValueString($row_Penjualan['kodefaktur'], "text"));

                $laba = mysql_query($query_laba, $koneksi) or die(mysql_error());
                $row_laba = mysql_fetch_assoc($laba);
                //---------
              ?>
                <tr>
                  <td>
                    <div align="center"><?= $no; ?></div>
                  </td>
                  <td>
                    <div align="left"><strong><?php echo $fakt = $row_Penjualan['kodefaktur']; ?></strong>
                      <br />
                    </div>
                  </td>
                  <td><?php echo $row_Penjualan['datetimefaktur']; ?><br>
                    Pelanggan : <?php echo $row_Penjualan['namapelanggan']; ?>
                  </td>
                  <td>
                    <div align="right">Rp. <?php echo number_format($row_Penjualan['totalbelanja']); ?></div>
                  </td>
                  <td>
                    <div align="right">Rp. <?php echo number_format($row_Penjualan['potongan']); ?></div>
                  </td>
                  <td>
                    Rp. <span class="pull-right"><?= number_format($row_laba['laba']); ?></span>
                  </td>
                  <td>
                    <div align="center"><?php echo $row_Penjualan['adminfaktur']; ?></div>
                  </td>
                  <td>
                    <?php if ($row_Penjualan['statusfaktur'] == 'Y') { ?>
                      <a href="?page=tabulasi/detail&faktur=<?php echo $row_Penjualan['kodefaktur']; ?>" class="btn btn-primary"><span class="fa fa-list"></span> Lihat Detail</a>
                    <?php } else { ?>
                      <a href="?page=scan/add&faktur=<?php echo $row_Penjualan['kodefaktur']; ?>" class="btn btn-warning"><span class="fa fa-list"></span> Lanjutkan</a>
                    <?php } ?>
                    <?php
                    if ($row_Penjualan['statusfaktur'] == 'Y') {
                      echo "<div class='btn btn-success pull-right'><span class='fa fa-check'></span></div>";
                    } else {
                      echo "<div class='btn btn-danger pull-right'><span class='fa fa-close'></span></div>";
                    } ?>
                  </td>
                </tr>
              <?php
                $no++;
              } while ($row_Penjualan = mysql_fetch_assoc($rs_Penjualan)); ?>
            </table>
          </div>
        </div>
      </div>
      <!-- /.row -->
    <?php } else {
      danger('Oops!', 'Transaksi tidak ditemukan');
      echo "<br><p><a href='?page=tabulasi/penjualan' class='btn btn-warning'>Back</a></p>";
    } ?>
  </div>
  <!-- /.box-body -->

</div>
<?php require_once('preview/page2.php'); ?>