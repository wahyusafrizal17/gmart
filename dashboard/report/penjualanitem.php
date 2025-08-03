<?php require_once('../require/lap_header.php');
$jenisbayar = "-1";
$colname = "-1";
if (isset($_GET['kasir'])) {
  $colname = $_GET['kasir'];
}
$tgl1 = "-1";
$tgl2 = "-1";
$kat = "-1";
if (isset($_GET['jenisbayar']) && ($_GET['jenisbayar'] != "") && isset($_GET['kasir']) && ($_GET['kasir'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2']) && isset($_GET['kategori']) && ($_GET['kategori'] != 0)) {
  $jenisbayar = $_GET['jenisbayar'];
  if ($jenisbayar == "0") {
    $colname = $_GET['kasir'];
    $tgl1 = $_GET['tgl1'];
    $tgl2 = $_GET['tgl2'];
    $kat = $_GET['kategori'];
    //mysqli_select_db($database_koneksi, $koneksi);
    $query_Penjualan = sprintf(
      "SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga*b.qty) AS totalbelanja, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan, a.nohp FROM faktur a,transaksidetail b,produk c
		WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND  a.addbyfaktur = %s AND  a.periode = %s AND a.kodefaktur=b.faktur AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
      GetSQLValueString($tgl1, "date"),
      GetSQLValueString($tgl2, "date"),
      GetSQLValueString($colname, "text"),
      GetSQLValueString($ta, "text"),
      GetSQLValueString($kat, 'text')
    );

    $query_total = sprintf(
      "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
      GetSQLValueString($tgl1, "date"),
      GetSQLValueString($tgl2, "date")
    );

    //total pendapatan
    $query_Pendapatan = sprintf(
      "SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga) AS pendapatan, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan FROM faktur a,transaksidetail b,produk c
		WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND a.addbyfaktur=%s AND  a.periode = %s AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
      GetSQLValueString($tgl1, "date"),
      GetSQLValueString($tgl2, "date"),
      GetSQLValueString($colname, "text"),
      GetSQLValueString($ta, "text"),
      GetSQLValueString($kat, 'text')
    );
  } else {
    $colname = $_GET['kasir'];
    $tgl1 = $_GET['tgl1'];
    $tgl2 = $_GET['tgl2'];
    $kat = $_GET['kategori'];
    //mysqli_select_db($database_koneksi, $koneksi);
    $query_Penjualan = sprintf(
      "SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga*b.qty) AS totalbelanja, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan,a.nohp FROM faktur a,transaksidetail b,produk c
		WHERE a.jenisbayar= %s  AND  a.addbyfaktur = %s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND  a.periode = %s AND a.kodefaktur=b.faktur AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
      GetSQLValueString($jenisbayar, "text"),
      GetSQLValueString($colname, "text"),
      GetSQLValueString($tgl1, "date"),
      GetSQLValueString($tgl2, "date"),
      GetSQLValueString($ta, "text"),
      GetSQLValueString($kat, 'text')
    );

    $query_total = sprintf(
      "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
      GetSQLValueString($tgl1, "date"),
      GetSQLValueString($tgl2, "date")
    );

    //total pendapatan
    $query_Pendapatan =
      sprintf(
        "SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga) AS pendapatan, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan FROM faktur a,transaksidetail b,produk c
		WHERE a.jenisbayar=%s AND a.addbyfaktur=%s AND (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y'  AND  a.periode = %s AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
        GetSQLValueString($jenisbayar, "text"),
        GetSQLValueString($colname, "text"),
        GetSQLValueString($tgl1, "date"),
        GetSQLValueString($tgl2, "date"),
        GetSQLValueString($ta, "text"),
        GetSQLValueString($kat, 'text')
      );
  }

  //echo "<script>alert('ini tanggal kasir jenis bayar');</script>";
} elseif (isset($_GET['kasir']) && ($_GET['kasir'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
  $colname = $_GET['kasir'];
  $tgl1 = $_GET['tgl1'];
  $tgl2 = $_GET['tgl2'];
  //mysqli_select_db($database_koneksi, $koneksi);
  $query_Penjualan = sprintf(
    "SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan`, `nohp` FROM faktur
		WHERE statusfaktur = 'Y' AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s GROUP BY kodefaktur ORDER BY idfaktur DESC",
    GetSQLValueString($colname, "text"),
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text")
  );
  //echo "<script>alert('ini tanggal kasir');</script>";

  $query_total = sprintf(
    "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );

  //total pendapatan
  $query_Pendapatan = sprintf(
    "SELECT SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE statusfaktur = 'Y' AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s GROUP BY kodefaktur ORDER BY idfaktur DESC",
    GetSQLValueString($colname, "text"),
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text")
  );
} elseif (isset($_GET['kategori']) && ($_GET['kategori'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
  $kat = $_GET['kategori'];
  $tgl1 = $_GET['tgl1'];
  $tgl2 = $_GET['tgl2'];
  //mysqli_select_db($database_koneksi, $koneksi);

  $query_Penjualan = sprintf(
    "SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga*b.qty) AS totalbelanja, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan, a.nohp FROM faktur a,transaksidetail b,produk c
		WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND  a.periode = %s AND a.kodefaktur=b.faktur AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text"),
    GetSQLValueString($kat, "text")
  );

  $query_total = sprintf(
    "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );

  //total pendapatan
  $query_Pendapatan = sprintf(
    "SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga) AS pendapatan, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan FROM faktur a,transaksidetail b,produk c
		WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND  a.periode = %s AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text"),
    GetSQLValueString($kat, "text")
  );
} elseif (isset($_GET['kategori']) && ($_GET['kategori'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
  $kat = $_GET['kategori'];
  $tgl1 = $_GET['tgl1'];
  $tgl2 = $_GET['tgl2'];
  //mysqli_select_db($database_koneksi, $koneksi);

  $query_Penjualan = sprintf(
    "SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga*b.qty) AS totalbelanja, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan FROM faktur a,transaksidetail b,produk c
		WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND  a.periode = %s AND a.kodefaktur=b.faktur AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text"),
    GetSQLValueString($kat, "text")
  );

  $query_total = sprintf(
    "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );

  //total pendapatan
  $query_Pendapatan = sprintf(
    "SELECT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, SUM(b.harga) AS pendapatan, a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan FROM faktur a,transaksidetail b,produk c
		WHERE (a.tglfaktur BETWEEN %s AND %s) AND a.statusfaktur = 'Y' AND  a.periode = %s AND b.nama=c.namaproduk AND c.kategori= %s GROUP BY a.kodefaktur ORDER BY a.idfaktur DESC",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text"),
    GetSQLValueString($kat, "text")
  );
} elseif (isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
  $tgl1 = $_GET['tgl1'];
  $tgl2 = $_GET['tgl2'];
  //mysqli_select_db($database_koneksi, $koneksi);
  $query_Penjualan = sprintf(
    "SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan`, `nohp` FROM faktur
		WHERE periode = %s AND tglfaktur BETWEEN %s AND %s  ORDER BY idfaktur DESC",
    GetSQLValueString($ta, "text"),
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );

  //echo "<script>alert('ini tanggal');</script>";
  $query_total = sprintf(
    "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );
  //echo "<script>alert('ini tanggal');</script>";
  //total pendapatan
  $query_Pendapatan = sprintf(
    "SELECT  SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE periode = %s AND tglfaktur BETWEEN %s AND %s  ORDER BY idfaktur DESC",
    GetSQLValueString($ta, "text"),
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );
} else {
  //mysqli_select_db($database_koneksi, $koneksi);
  $query_Penjualan = sprintf(
    "SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan`, `nohp` FROM faktur
		WHERE periode = %s ORDER BY idfaktur DESC",
    GetSQLValueString($ta, "text")
  );

  $query_total = sprintf(
    "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s  ORDER BY id DESC",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );

  $query_Pendapatan = sprintf(
    "SELECT SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE tglfaktur BETWEEN %s AND %s ORDER BY idfaktur DESC",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );
}


// Modernized to mysqli_*
$rs_Penjualan = mysqli_query($koneksi, $query_Penjualan) or die(errorQuery(mysqli_error($koneksi)));
$row_Penjualan = mysqli_fetch_assoc($rs_Penjualan);
$totalRows_Penjualan  = mysqli_num_rows($rs_Penjualan);

$rs_total = mysqli_query($koneksi, $query_total) or die(mysqli_error($koneksi));
$row_Total = mysqli_fetch_assoc($rs_total);

$rs_pendapatan = mysqli_query($koneksi, $query_Pendapatan) or die(mysqli_error($koneksi));
$row_Pendapatan = mysqli_fetch_assoc($rs_pendapatan);

//menampilkan data kasir
$query_Kasir = sprintf("SELECT Nama FROM vw_login WHERE ID=%s", GetSQLValueString($colname, "text"));
$rs_Kasir = mysqli_query($koneksi, $query_Kasir) or die(errorQuery(mysqli_error($koneksi)));
$row_Kasir = mysqli_fetch_assoc($rs_Kasir);
$totalRows_Kasir  = mysqli_num_rows($rs_Kasir);

if ($totalRows_Kasir > 0) {
  $kasir = " dan kasir An. " . $row_Kasir['Nama'] . " ";
} else {
  $kasir = " ";
}
?>

<?php if ($totalRows_Penjualan > 0) { ?>
  <?php if (isset($_GET['tgl1']) && isset($_GET['tgl2']) && isset($_GET['kasir'])) { ?>
    <h3>LAPORAN PENJUALAN</h3>
    <p>Berikut ini adalah data penjualan berdasarkan tanggal <?= $_GET['tgl1']; ?> s/d tanggal <?= $_GET['tgl2']; ?> <?= $kasir; ?> ditemukan sebanyak <?= $totalRows_Penjualan; ?> transaksi.
    <?php } ?>
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

      .table-h {
        border-bottom: 2px solid #000;
      }
    </style>



    <table width="100%" class="table-h">
      <tr>
        <th width="3%">
          <div align="center" bgcolor="#003366">NO.</div>
        </th>
        <th width="9%">
          <div align="center" bgcolor="#003366">FAKTUR</div>
        </th>
        <th width="19%">
          <div align="center" bgcolor="#003366">TANGGAL / WAKTU</div>
        </th>
        <th width="15%">
          <div align="center" bgcolor="#003366">TOTAL BELANJA</div>
        </th>
        <th width="15%">
          <div align="center" bgcolor="#003366">POTONGAN</div>
        </th>
        <th width="15%">
          <div align="center" bgcolor="#003366">LABA</div>
        </th>
        <th width="16%">
          <div align="center" bgcolor="#003366">KASSA</div>
        </th>
      </tr>
      <?php
      $totalbelanja = 0;
      $totalpotongan = 0;
      $nomor = 1;
      $totalLaba = 0;

      do {

        $totalbelanja += $row_Penjualan['totalbelanja'];
        $totalpotongan += $row_Penjualan['potongan'];

        //QUERY DETAIL
        $kat = $_GET['kategori'];
        if ($kat == "0") {
          $query_DetailFaktur = sprintf("SELECT faktur, tanggal, kode, td.nama, harga, qty, diskon, addby, stt, periode, vw_login.Nama as kassa, k.namakategori, (td.harga-td.hargadasar) as margin FROM transaksidetail td
				LEFT JOIN vw_login ON addby = vw_login.ID 
				LEFT JOIN produk p ON p.kodeproduk = td.kode
        LEFT JOIN kategori k ON k.idkategori = p.kategori
				WHERE faktur = %s", GetSQLValueString($row_Penjualan['kodefaktur'], "text"));
        } else {
          $query_DetailFaktur = sprintf("SELECT faktur, tanggal, kode, td.nama, harga, qty, diskon, addby, stt, periode, vw_login.Nama as kassa, k.namakategori, (td.harga-td.hargadasar) as margin FROM transaksidetail td
          LEFT JOIN vw_login ON addby = vw_login.ID 
          LEFT JOIN produk p ON p.kodeproduk = td.kode
          LEFT JOIN kategori k ON k.idkategori = p.kategori
          WHERE faktur = %s AND p.kategori= %s", GetSQLValueString($row_Penjualan['kodefaktur'], "text"), GetSQLValueString($kat, "text"));
        }
        $DetailFaktur = mysqli_query($koneksi, $query_DetailFaktur) or die(mysqli_error($koneksi));
        $row_DetailFaktur = mysqli_fetch_assoc($DetailFaktur);
        $totalRows_DetailFaktur = mysqli_num_rows($DetailFaktur);
        //hitung laba
        if ($kat != 0) {
          $query_laba = sprintf("SELECT a.faktur, a.tanggal, a.hargadasar, a.harga, a.diskon, a.qty, (a.hargadasar * a.qty) as hd, (a.harga * a.qty) as hj, sum((((a.harga * a.qty) - (a.hargadasar * a.qty)))-a.diskon) as laba, ((a.harga * a.qty) - a.diskon) as sisadiskon  FROM transaksidetail a,produk b WHERE a.faktur = %s AND a.nama=b.namaproduk AND b.kategori= %s  GROUP BY a.faktur",  GetSQLValueString($row_Penjualan['kodefaktur'], "text"), GetSQLValueString($kat, "text"));
        } else {
          $query_laba = sprintf("SELECT faktur, tanggal, hargadasar, harga, diskon, qty, (hargadasar * qty) as hd, (harga * qty) as hj, sum((((harga * qty) - (hargadasar * qty)))-diskon) as laba, ((harga * qty) - diskon) as sisadiskon  FROM transaksidetail WHERE faktur = %s GROUP BY faktur",  GetSQLValueString($row_Penjualan['kodefaktur'], "text"));
        }
        $laba = mysqli_query($koneksi, $query_laba) or die(mysqli_error($koneksi));
        $row_laba = mysqli_fetch_assoc($laba);

        $tlaba = $row_laba['laba'] ?? 0;

        $totalLaba += $tlaba;
        //---------
      ?>

        <tr>
          <td>
            <div align="center"><?= $nomor; ?></div>
          </td>
          <td>
            <div align="left"><strong><?php echo $fakt = $row_Penjualan['kodefaktur']; ?></strong>
              <br />
            </div>
          </td>
          <td><?php echo $row_Penjualan['datetimefaktur']; ?> </td>
          <td>
            <div align="right">Rp. <?php echo number_format($row_Penjualan['totalbelanja']); ?></div>
          </td>
          <td>
            <div align="right">Rp. <?php echo number_format($row_Penjualan['potongan']); ?></div>
          </td>
          <td>
            <div align="right">Rp. <?php

                                    echo number_format($tlaba); ?></div>
          </td>
          <td>
            <div align="center"><?php echo $row_Penjualan['adminfaktur']; ?></div>
          </td>
        </tr>

        <tr>
          <td>&nbsp;</td>
          <td align="center" valign="middle">
            <div align="center">
              <?php if ($row_Penjualan['statusfaktur'] == 'Y') { ?>
                <span class="fa fa-check"></span>
              <?php } else { ?>
                <span class="fa fa-close"></span>
              <?php } ?>
            </div>
          </td>
          <td colspan="5">
            <table width="100%" class="tableku">
              <tr>
                <th width="3%" bgcolor="#003366"><span>NO</span></th>
                <th width="34%" bgcolor="#003366"><span>PRODUK</span></th>
                <th width="30%" bgcolor="#003366"><span>QTY</span></th>
                <th width="20%" bgcolor="#003366"><span>SUB TOTAL</span></th>
                <th width="13%" bgcolor="#003366"><span>LABA</span></th>
              </tr>
              <?php
              $total = 0;
              $no = 1;
              $disk = 0;
              $totalmargin = 0;

              do {
                $sub = $row_DetailFaktur['harga'] * $row_DetailFaktur['qty'];
                $total += $sub;
                // $disk += $row_DetailFaktur['diskon'];
                $totalmargin += $row_DetailFaktur['margin'];
              ?>
                <tr>
                  <td><?= $no; ?></td>
                  <td class="text-uppercase"><?php echo $row_DetailFaktur['kode']; ?>- <?php echo $row_DetailFaktur['nama']; ?><br><small><?php echo $row_DetailFaktur['namakategori']; ?></small></td>
                  <td><?php echo $row_DetailFaktur['qty']; ?> @ Rp. <?php echo number_format($row_DetailFaktur['harga']); ?></td>
                  <td>
                    <div align="right">Rp. <?php echo number_format($sub); ?></div>
                  </td>
                  <td>
                    <div align="right">Rp. <?php echo number_format($row_DetailFaktur['margin'] * $row_DetailFaktur['qty']); ?></div>
                  </td>
                </tr>
              <?php
                $no++;
              } while ($row_DetailFaktur = mysqli_fetch_assoc($DetailFaktur)); ?>
              <tr>
                <td colspan="2"> <?php $pelanggan = empty($row_Penjualan['namapelanggan']) ? "" : "Pelanggan : " . strtoupper($row_Penjualan['namapelanggan']) . " (0" . $row_Penjualan['nohp'] . ")";
                                  echo $pelanggan; ?></td>
                <td>
                  <div align="right"><strong> TOTAL</strong></div>
                </td>
                <td>
                  <div align="right">Rp. <?php echo number_format($total); ?></div>
                </td>
                <td>
                  <div align="right">Rp. <?php echo number_format($tlaba); ?></div>
                </td>
              </tr>
            </table>
            <p></p>
          </td>
        </tr>
      <?php
        $nomor++;
      } while ($row_Penjualan = mysqli_fetch_assoc($rs_Penjualan)); ?>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td>
          <div align="center"><strong>TOTAL BELANJA</strong></div>
        </td>
        <td>
          <div align="center"><strong>LABA</strong></div>
        </td>
        <td>
          <div align="center"><strong>TOTAL POTONGAN</strong></div>
        </td>
        <td>
          <div align="center"><strong>PENGELUARAN</strong></div>
        </td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td>
          <div align="right">Rp.
            <?= number_format($totalbelanja); ?>
          </div>
        </td>
        <td>
          <div align="right">Rp.
            <?= number_format($totalLaba); ?>
          </div>
        </td>
        <td>
          <div align="right">Rp.
            <?= number_format($totalpotongan); ?>
          </div>
        </td>
        <td>
          <div align="right">Rp.
            <?= (isset($row_Total) && isset($row_Total['jumlah'])) ? number_format($row_Total['jumlah']) : '0'; ?>
          </div>
        </td>
      </tr>
      <tr>
        <td colspan="5">&nbsp;</td>

        <th>
          <div align="right">TOTAL LABA
          </div>
        </th>
        <td>
          <div align="right"><?= number_format($totalLaba - ((isset($row_Total) && isset($row_Total['jumlah'])) ? $row_Total['jumlah'] : 0)); ?>
          </div>
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