<?php
//require_once('izin.php');
require_once('page1.php'); ?>

<style>
  .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow b{
    top: 0% !important;
  }
</style>

<div class="box box-default color-palette-box">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> BUAT LAPORAN PENJUALAN BERDASARKAN TANGGAL</h3>
  </div>
  <div class="box-body">
    <style>
      .summary-sticky { position: absolute; left: 10px; top: 145px; right: 0; z-index: 10; }
      /* Jarak dari atas (di bawah area filter) bisa disesuaikan */
      .penjualan-table-wrapper { margin-top: 100px; }
      .box-body { position: relative; }
    </style>

    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <!-- <label>Cari berdasarkan tanggal </label> -->
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
                      <option value="<?php echo isset($row_Kassa['id']) ? $row_Kassa['id'] : ''; ?>" <?php if (isset($row_Kassa['id']) && !(strcmp($row_Kassa['id'], htmlentities($colname, ENT_COMPAT, 'utf-8')))) {
                                                                                                        echo "SELECTED";
                                                                                                      } ?>><?php echo isset($row_Kassa['Nama']) ? $row_Kassa['Nama'] : ''; ?></option>
                    <?php } while ($row_Kassa = mysqli_fetch_assoc($Kassa)); ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="tgl2" class="control-label">Pilih Jenis Bayar</label>
                  <select name="jenisbayar" id="" class="form-control">
                    <option value="0">-- Keseluruhan --</option>
                    <?php do {  ?>
                      <option value="<?php echo isset($row_Faktur['jenisbayar']) ? $row_Faktur['jenisbayar'] : ''; ?>" <?php if (isset($row_Faktur['jenisbayar']) && !(strcmp($row_Faktur['jenisbayar'], htmlentities($jenisbayar, ENT_COMPAT, 'utf-8')))) {
                                                                                                                          echo "SELECTED";
                                                                                                                        } ?>><?php echo isset($row_Faktur['jenisbayar']) ? $row_Faktur['jenisbayar'] : ''; ?></option>
                    <?php } while ($row_Faktur = mysqli_fetch_assoc($Faktur)); ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="tgl2" class="control-label">Pilih Kategori</label>
                  <select name="kategori" id="" class="js-example-basic-single form-control" style="height: 34px;">
                    <option value="0">-- Keseluruhan --</option>
                    <?php 
                    // Reset pointer kategori ke awal
                    mysqli_data_seek($kategori, 0);
                    // Refetch first row after resetting pointer to avoid duplicating the first item
                    $row_kategori = mysqli_fetch_assoc($kategori);
                    do {  
                      $selected = "";
                      // Cek apakah kategori ini yang dipilih
                      if (isset($_GET['kategori']) && $_GET['kategori'] != "0" && $_GET['kategori'] == $row_kategori['idkategori']) {
                        $selected = "SELECTED";
                      }
                    ?>
                      <option value="<?php echo isset($row_kategori['idkategori']) ? $row_kategori['idkategori'] : ''; ?>" <?php echo $selected; ?>><?php echo isset($row_kategori['namakategori']) ? $row_kategori['namakategori'] : ''; ?></option>
                    <?php } while ($row_kategori = mysqli_fetch_assoc($kategori)); ?>
                  </select>
                  <script>
                    $(document).ready(function() {
                      // Add CSS for consistent height
                      $('<style>')
                        .prop('type', 'text/css')
                        .html(`
                          .select2-container--bootstrap4 .select2-selection--single {
                            height: 34px !important;
                            line-height: 32px !important;
                          }
                          .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
                            line-height: 32px !important;
                            padding-left: 12px !important;
                            padding-right: 20px !important;
                          }
                          .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
                            height: 32px !important;
                          }
                          .form-control {
                            height: 34px !important;
                          }
                        `)
                        .appendTo('head');
                      
                      $('.js-example-basic-single').select2({
                        theme: "bootstrap4",
                        width: '100%',
                        placeholder: "Pilih atau cari kategori",
                        allowClear: true,
                        dropdownParent: $('body')
                      });
                      
                      // Set nilai awal untuk select2 jika ada parameter kategori
                      <?php if (isset($_GET['kategori']) && $_GET['kategori'] != "0") { ?>
                        $('.js-example-basic-single').val('<?php echo $_GET['kategori']; ?>').trigger('change');
                      <?php } ?>
                      
                      // Ensure consistent height after initialization
                      setTimeout(function() {
                        $('.select2-container--bootstrap4 .select2-selection--single').css('height', '34px');
                      }, 100);
                    });
                  </script>
                </div>
              </div>
              <div class="col-md-12 text-right">
                <div class="form-group">
                  <!-- <label for="kategori" class="control-label"> &nbsp;</label> -->
                  <button type="submit" class="btn btn-block btn-info pull-right" style="width: 15%;">Filter</button>
                </div>
              </div>
            </div>

            <!-- /.box-footer -->
            <input type="hidden" name="page" value="preview/penjualan" />
          </form>
        </div>
      </div>
    </div>
    <?php if ($totalRows_Penjualan > 0) { ?>

      <div class="row">

        <div class="col-md-12">


          <?php 
          // Tampilkan alert hasil pencarian selalu, gunakan $tgl1 & $tgl2 default dari page1.php
          title('success', 'HASIL PENCARIAN DITEMUKAN', 'Pada tanggal ' . $tgl1 . ' s/d tanggal ' . $tgl2 . ' ditemukan sebanyak ' . $totalRows_Penjualan . ' transaksi'); 
          ?>

          <p><a href="report/penjualan.php?jenisbayar=<?= $jenisbayar ?>&tgl1=<?= $tgl1; ?>&tgl2=<?= $tgl2; ?>&kasir=<?= $colname; ?>&kategori=<?= $kat ?>" target="_blank" class="btn btn-primary"><span class="fa fa-print"></span> Cetak Laporan</a> <a href="report/penjualanitem.php?jenisbayar=<?= $jenisbayar ?>&tgl1=<?= $tgl1; ?>&tgl2=<?= $tgl2; ?>&kasir=<?= $colname; ?>&kategori=<?= $kat ?>" target="_blank" class="btn btn-info"><span class="fa fa-list"></span> Cetak Laporan Detail</a> <a href="report/penjualanitem.php?jenisbayar=<?= $jenisbayar ?>&tgl1=<?= $tgl1; ?>&tgl2=<?= $tgl2; ?>&kasir=<?= $colname; ?>&kategori=<?= $kat ?>&show_by_category=1" target="_blank" class="btn btn-success"><span class="fa fa-chart-bar"></span> Laporan Per Kategori</a>


          </p>

          <div class="table-responsive penjualan-table-wrapper">

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
            $no = $startRow_Penjualan + 1; // Mulai nomor dari posisi pagination
            $seenFaktur = array();
            $sumRowBelanja = 0;
            $sumRowPotongan = 0;
            $sumRowLaba = 0;
            do {

              // Skip if faktur already rendered
              if (isset($seenFaktur[$row_Penjualan['kodefaktur']])) {
                continue;
              }
              $seenFaktur[$row_Penjualan['kodefaktur']] = true;
 
              //hitung laba
              if ($kat != 0) {
                $query_laba = sprintf("SELECT SUM(((a.harga * a.qty) - (a.hargadasar * a.qty)) - a.diskon) as laba FROM transaksidetail a,produk b WHERE a.faktur = %s AND a.nama=b.namaproduk AND b.kategori= %s",  GetSQLValueString($row_Penjualan['kodefaktur'], "text"), GetSQLValueString($kat, "text"));
              } else {
                $query_laba = sprintf("SELECT SUM(((harga * qty) - (hargadasar * qty)) - diskon) as laba FROM transaksidetail WHERE faktur = %s",  GetSQLValueString($row_Penjualan['kodefaktur'], "text"));
              }
              $laba = mysqli_query($koneksi, $query_laba) or die(mysqli_error($koneksi));
              $row_laba = mysqli_fetch_assoc($laba);

              // Hitung TOTAL BELANJA dari detail (ikuti filter kategori bila ada)
              if ($kat != 0) {
                $query_subtotal = sprintf(
                  "SELECT SUM(td.harga * td.qty) AS subtotal FROM transaksidetail td INNER JOIN produk p ON td.nama = p.namaproduk WHERE td.faktur = %s AND p.kategori = %s",
                  GetSQLValueString($row_Penjualan['kodefaktur'], "text"),
                  GetSQLValueString($kat, "text")
                );
              } else {
                $query_subtotal = sprintf(
                  "SELECT SUM(harga * qty) AS subtotal FROM transaksidetail WHERE faktur = %s",
                  GetSQLValueString($row_Penjualan['kodefaktur'], "text")
                );
              }
              $rs_subtotal = mysqli_query($koneksi, $query_subtotal) or die(mysqli_error($koneksi));
              $row_subtotal = mysqli_fetch_assoc($rs_subtotal);
              $calculated_total = isset($row_subtotal['subtotal']) ? (float)$row_subtotal['subtotal'] : 0;
              //---------
              $sumRowBelanja += $calculated_total;
              $sumRowPotongan += (float)($row_Penjualan['potongan'] ?? 0);
              $sumRowLaba += (float)($row_laba['laba'] ?? 0);
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
                  <div align="right">Rp. <?php echo number_format($calculated_total); ?></div>
                </td>
                <td>
                  <div align="right">Rp. <?php echo number_format($row_Penjualan['potongan']); ?></div>
                </td>
                <td>
                  Rp. <span class="pull-right"><?= number_format($row_laba['laba'] ?? 0); ?></span>
                </td>
                <td>
                  <div align="center"><?php echo $row_Penjualan['adminfaktur']; ?></div>
                </td>
                <td>
                  <?php if ($row_Penjualan['statusfaktur'] == 'Y') { ?>
                    <a href="?page=tabulasi/detail&faktur=<?php echo $row_Penjualan['kodefaktur']; ?>&kategori=<?= $kat ?>" class="btn btn-primary"><span class="fa fa-list"></span> Lihat Detail</a>
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
            } while ($row_Penjualan = mysqli_fetch_assoc($rs_Penjualan)); ?>
          </table>

          <?php
            // Grand totals (tanpa pagination): hitung berdasarkan semua faktur di $query_Penjualan
            $grandBelanja = 0; $grandLaba = 0; $grandPotongan = 0;
            if (isset($query_Penjualan) && !empty($query_Penjualan)) {
              $rsAll = mysqli_query($koneksi, $query_Penjualan) or die(mysqli_error($koneksi));
              $codes = [];
              while ($ra = mysqli_fetch_assoc($rsAll)) {
                if (!empty($ra['kodefaktur'])) {
                  $codes[] = "'" . mysqli_real_escape_string($koneksi, $ra['kodefaktur']) . "'";
                }
              }
              if (count($codes) > 0) {
                $inCodes = implode(',', $codes);
                if ($kat != 0) {
                  $qBelanjaAll = "SELECT SUM(td.harga*td.qty) AS totalbelanja FROM transaksidetail td INNER JOIN produk p ON td.nama=p.namaproduk WHERE p.kategori=" . GetSQLValueString($kat, 'text') . " AND td.faktur IN ($inCodes)";
                  $qLabaAll = "SELECT SUM(((td.harga*td.qty)-(td.hargadasar*td.qty))-td.diskon) AS laba FROM transaksidetail td INNER JOIN produk p ON td.nama=p.namaproduk WHERE p.kategori=" . GetSQLValueString($kat, 'text') . " AND td.faktur IN ($inCodes)";
                } else {
                  $qBelanjaAll = "SELECT SUM(harga*qty) AS totalbelanja FROM transaksidetail WHERE faktur IN ($inCodes)";
                  $qLabaAll = "SELECT SUM(((harga*qty)-(hargadasar*qty))-diskon) AS laba FROM transaksidetail WHERE faktur IN ($inCodes)";
                }
                $rBelAll = mysqli_query($koneksi, $qBelanjaAll) or die(mysqli_error($koneksi));
                $rowBelAll = mysqli_fetch_assoc($rBelAll);
                $grandBelanja = (float)($rowBelAll['totalbelanja'] ?? 0);

                $rLabAll = mysqli_query($koneksi, $qLabaAll) or die(mysqli_error($koneksi));
                $rowLabAll = mysqli_fetch_assoc($rLabAll);
                $grandLaba = (float)($rowLabAll['laba'] ?? 0);

                $qPotAll = "SELECT SUM(potongan) AS totalpotongan FROM faktur WHERE kodefaktur IN ($inCodes)";
                $rPotAll = mysqli_query($koneksi, $qPotAll) or die(mysqli_error($koneksi));
                $rowPotAll = mysqli_fetch_assoc($rPotAll);
                $grandPotongan = (float)($rowPotAll['totalpotongan'] ?? 0);
              }
            }
          ?>

          <div class="summary-sticky">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>TOTAL BELANJA</th>
                    <th>LABA</th>
                    <th>TOTAL POTONGAN</th>
                    <th>PENGELUARAN</th>
                  </tr>
                </thead>
                <tr>
                  <td>Rp. <?= number_format($grandBelanja > 0 ? $grandBelanja : $sumRowBelanja); ?></td>
                  <td>Rp. <?= number_format($grandLaba > 0 ? $grandLaba : $sumRowLaba); ?></td>
                  <td>Rp. <?= number_format($grandPotongan > 0 ? $grandPotongan : $sumRowPotongan); ?></td>
                  <td>Rp. <?= number_format(($row_Total && isset($row_Total['jumlah'])) ? $row_Total['jumlah'] : 0); ?></td>
                </tr>
              </table>
            </div>
          </div>
 
          <!-- Pagination Controls -->
          <?php if ($totalPages_Penjualan > 0) { ?>
          <div class="text-center">
            <ul class="pagination">
              <?php if ($pageNum_Penjualan > 0) { ?>
                <li><a href="<?= $currentPage ?>?pageNum_Penjualan=0<?= $queryString_Penjualan ?>&tgl1=<?= $tgl1 ?>&tgl2=<?= $tgl2 ?>&kasir=<?= $colname ?>&jenisbayar=<?= $jenisbayar ?>&kategori=<?= $kat ?>">&laquo; Pertama</a></li>
                <li><a href="<?= $currentPage ?>?pageNum_Penjualan=<?= $pageNum_Penjualan - 1 ?><?= $queryString_Penjualan ?>&tgl1=<?= $tgl1 ?>&tgl2=<?= $tgl2 ?>&kasir=<?= $colname ?>&jenisbayar=<?= $jenisbayar ?>&kategori=<?= $kat ?>">&lsaquo; Sebelumnya</a></li>
              <?php } ?>
              
              <?php
              // Tampilkan maksimal 5 halaman di sekitar halaman saat ini
              $start_page = max(0, $pageNum_Penjualan - 2);
              $end_page = min($totalPages_Penjualan, $pageNum_Penjualan + 2);
              
              for ($i = $start_page; $i <= $end_page; $i++) {
                if ($i == $pageNum_Penjualan) {
                  echo "<li class='active'><a href='#'>" . ($i + 1) . "</a></li>";
                } else {
                  echo "<li><a href='" . $currentPage . "?pageNum_Penjualan=" . $i . $queryString_Penjualan . "&tgl1=" . $tgl1 . "&tgl2=" . $tgl2 . "&kasir=" . $colname . "&jenisbayar=" . $jenisbayar . "&kategori=" . $kat . "'>" . ($i + 1) . "</a></li>";
                }
              }
              ?>
              
              <?php if ($pageNum_Penjualan < $totalPages_Penjualan) { ?>
                <li><a href="<?= $currentPage ?>?pageNum_Penjualan=<?= $pageNum_Penjualan + 1 ?><?= $queryString_Penjualan ?>&tgl1=<?= $tgl1 ?>&tgl2=<?= $tgl2 ?>&kasir=<?= $colname ?>&jenisbayar=<?= $jenisbayar ?>&kategori=<?= $kat ?>">Selanjutnya &rsaquo;</a></li>
                <li><a href="<?= $currentPage ?>?pageNum_Penjualan=<?= $totalPages_Penjualan ?><?= $queryString_Penjualan ?>&tgl1=<?= $tgl1 ?>&tgl2=<?= $tgl2 ?>&kasir=<?= $colname ?>&jenisbayar=<?= $jenisbayar ?>&kategori=<?= $kat ?>">Terakhir &raquo;</a></li>
              <?php } ?>
            </ul>
          </div>
          <?php } ?>
          
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