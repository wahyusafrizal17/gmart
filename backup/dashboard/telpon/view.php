<?php
require_once('izin.php');
//mysql_select_db($database_koneksi, $koneksi);
//SELECT COUNT(nohp) as pembelian, namapelanggan, nohp FROM `faktur` GROUP BY nohp ORDER BY nohp ASC 
$tgl1 = DATE("m");
if (isset($_GET['bulan'])) {
  $tgl1 = $_GET['bulan'];
  $query_Telpon = sprintf("SELECT COUNT(nohp) as pembelian, namapelanggan, nohp, SUM(totalbayar) as totalbayr FROM `faktur` WHERE MONTH(tglfaktur) = %s GROUP BY nohp ORDER BY totalbayr DESC", GetSQLValueString($koneksi, $tgl1, "date"));
} else {
  $query_Telpon = sprintf("SELECT COUNT(nohp) as pembelian, namapelanggan, nohp, SUM(totalbayar) as totalbayr FROM `faktur` WHERE MONTH(tglfaktur) = MONTH(NOW()) GROUP BY nohp ORDER BY totalbayr DESC", GetSQLValueString($koneksi, $tgl1, "date"));
}
$Telpon = mysqli_query($koneksi, $query_Telpon) or die(errorQuery(mysql_error($koneksi)));
$row_Telpon = mysqli_fetch_assoc($Telpon);
$totalRows_Telpon = mysqli_num_rows($Telpon);
?>



<?php
title('info', 'DAFTAR NO. KONTAK PELANGGAN DENGAN JUMLAH PEMBELIAN TERBANYAK DI BULAN ' . $tgl1 . '', 'Berikut ini adalah data pelanggan yang tercatat dari penjualan');

?>

<div class="col-md-8">
  <div class="callout callout-default">
    <form class="form-horizontal" name="periode" action="" method="get">
      <label>Tampilkan data berdasarkan bulan </label>
      <div class="box-body">
        <div class="col-md-4">
          <div class="form-group">
            <label for="tgl1" class="control-label">Pilih bulan ke : </label>
            <select for="" name="bulan" class="form-control">
              <?php for ($i = 1; $i <= 12; $i++) { ?>
                <option value="<?= $i; ?>" <?php if (!(strcmp($i, htmlentities($tgl1, ENT_COMPAT, 'utf-8')))) {
                                              echo "SELECTED";
                                            } ?>>Bulan ke <?= $i; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="kategori" class="control-label"> &nbsp;</label>
            <button type="submit" class="btn btn-block btn-info pull-right">Filter</button>
          </div>
        </div>
      </div>
      <!-- /.box-footer -->
      <input type="hidden" name="page" value="telpon/view" />
    </form>
  </div>
</div>

<div class="col-md-12">
  <?php if ($totalRows_Telpon > 0) { ?>

    <div class="table-responsive">
      <table class="table table-hover" id="example1">
        <thead>
          <tr>
            <th>NO.</th>
            <th>NAMA PELANGGAN</th>
            <th>NO. KONTAK</th>
            <th>JUMLAH PEMBELIAN</th>
            <th>TOTAL BELANJA</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          do { ?>
            <tr>
              <td><?= $no; ?></td>
              <td><?php echo $row_Telpon['namapelanggan']; ?></td>
              <td><?php echo "+62" . $row_Telpon['nohp']; ?></td>
              <td><?php echo $row_Telpon['pembelian']; ?></td>
              <td>Rp. <?php echo number_format($row_Telpon['totalbayr']); ?></td>
            </tr>
          <?php $no++;
          } while ($row_Telpon = mysqli_fetch_assoc($Telpon));
          ?>
        </tbody>
      </table>
    </div>

  <?php } else {
    danger('Oops!', 'Data belum ada');
  } ?>
</div>