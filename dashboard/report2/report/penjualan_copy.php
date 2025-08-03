<?php require_once('../require/lap_header.php');
$jenisbayar = "-1";
$colname = "-1";
$tgl1 = "-1";
$tgl2 = "-1";
if (isset($_GET['jenisbayar']) && ($_GET['jenisbayar'] != "") && isset($_GET['kasir']) && ($_GET['kasir'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
  $jenisbayar = $_GET['jenisbayar'];
  $colname = $_GET['kasir'];
  $tgl1 = $_GET['tgl1'];
  $tgl2 = $_GET['tgl2'];
  //mysqli_select_db($database_koneksi, $koneksi);
  $query_Penjualan = sprintf(
    "SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`,`namapelanggan` FROM faktur
		WHERE statusfaktur = 'Y' AND jenisbayar = %s AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s GROUP BY kodefaktur ORDER BY idfaktur DESC",
    GetSQLValueString($jenisbayar, "text"),
    GetSQLValueString($colname, "text"),
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text")
  );

  $rs_Penjualan = mysqli_query($query_Penjualan, $koneksi) or die(errorQuery(mysqli_error()));
  $row_Penjualan = mysqli_fetch_assoc($rs_Penjualan);
  $totalRows_Penjualan  = mysqli_num_rows($rs_Penjualan);
} elseif (isset($_GET['kasir']) && ($_GET['kasir'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {

  $colname = $_GET['kasir'];
  $tgl1 = $_GET['tgl1'];
  $tgl2 = $_GET['tgl2'];
  //mysqli_select_db($database_koneksi, $koneksi);
  $query_Penjualan = sprintf(
    "SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`,`namapelanggan` FROM faktur
		WHERE statusfaktur = 'Y' AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s GROUP BY kodefaktur ORDER BY idfaktur DESC",
    GetSQLValueString($colname, "text"),
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text")
  );

  $rs_Penjualan = mysqli_query($query_Penjualan, $koneksi) or die(errorQuery(mysqli_error()));
  $row_Penjualan = mysqli_fetch_assoc($rs_Penjualan);
  $totalRows_Penjualan  = mysqli_num_rows($rs_Penjualan);
}
?>
<style type="text/css">
  .tableku tr,
  .tableku td {
    border: 2px solid #000;
    padding-left: 5px;
    padding-right: 5px;
  }

  .tableku th {
    color: #fff;
    text-align: center;
  }
</style>

<?php if ($totalRows_Penjualan > 0) { ?>
  <?php if (isset($_GET['tgl1']) && isset($_GET['tgl2']) && isset($_GET['kasir'])) { ?>
    <h3>LAPORAN PENJUALAN BERDASARKAN TANGGAL DAN KASIR</h3>
    <p>Berikut ini adalah data penjualan berdasarkan tanggal
      <?= $_GET['tgl1']; ?> s/d tanggal <?= $_GET['tgl2']; ?> dan kasir :
      <?= $_GET['kasir']; ?> ditemukan sebanyak <?= $totalRows_Penjualan; ?> transaksi</p>
  <?php } ?>
  <table width="100%" class="tableku" border="2">
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

    </tr>
    <?php
    $total = 0;
    $potongan = 0;
    $no = 1;
    $totallaba = 0;
    do {
      $total += $row_Penjualan['totalbelanja'];
      $potongan += $row_Penjualan['potongan'];

      //query hitung laba
      $query_laba = sprintf("SELECT faktur, tanggal, hargadasar, harga, diskon, qty, (hargadasar * qty) as hd, (harga * qty) as hj, ((harga * qty) - (hargadasar * qty)) as laba, ((harga * qty) - diskon) as sisadiskon FROM `transaksidetail` WHERE faktur = %s GROUP BY faktur",  GetSQLValueString($row_Penjualan['kodefaktur'], "text"));

      $laba = mysqli_query($query_laba, $koneksi) or die(mysqli_error());
      $row_laba = mysqli_fetch_assoc($laba);
      //----------------------
    ?>
      <tr>
        <td>
          <div align="center"><?= $no; ?></div>
        </td>
        <td>
          <?php echo $fakt = $row_Penjualan['kodefaktur']; ?>
          <br /><?php echo $row_Penjualan['adminfaktur']; ?>
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
          <div align="right">Rp. <?php
                                  $tlaba = $row_laba['laba'] - $row_Penjualan['potongan'];
                                  echo number_format($tlaba); ?></div>
        </td>

      </tr>
    <?php
      $totallaba += $tlaba;
      $no++;
    } while ($row_Penjualan = mysqli_fetch_assoc($rs_Penjualan)); ?>
    <tr>
      <td colspan="3" align="right">TOTAL KESELURUHAN</td>
      <td>
        <div align="right">Rp.
          <?= number_format($total); ?>
        </div>
      </td>
      <td>
        <div align="right">Rp.
          <?= number_format($potongan); ?></div>
      </td>
      <td>
        <div align="right">Rp.
          <?= number_format($totallaba); ?></div>
      </td>

    </tr>

  </table>
  <p>
    <br>
    <br>
    <br>
  </p>
  <?php require('ttd.php'); ?>
<?php } else {
  danger('Oops!', 'Transaksi tidak ditemukan');
} ?>