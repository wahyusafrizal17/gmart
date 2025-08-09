<?php require_once('../require/lap_header.php');

// Include koneksi.php terlebih dahulu
if (file_exists('../../Connections/koneksi.php')) {
    require_once('../../Connections/koneksi.php');
} elseif (file_exists('../Connections/koneksi.php')) {
    require_once('../Connections/koneksi.php');
} elseif (file_exists('Connections/koneksi.php')) {
    require_once('Connections/koneksi.php');
}

$jenisbayar = "-1";
$colname = "-1";
if (isset($_GET['kasir'])) {
  $colname = $_GET['kasir'];
}
$tgl1 = "-1";
$tgl2 = "-1";
$kat = "-1";

// Tambahkan parameter untuk menampilkan per kategori
$show_by_category = isset($_GET['show_by_category']) ? $_GET['show_by_category'] : false;

// Query yang dioptimasi berdasarkan filter yang dipilih
if (isset($_GET['jenisbayar']) && ($_GET['jenisbayar'] != "") && isset($_GET['kasir']) && ($_GET['kasir'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2']) && isset($_GET['kategori']) && ($_GET['kategori'] != 0)) {
  $jenisbayar = $_GET['jenisbayar'];
  if ($jenisbayar == "0") {
    $colname = $_GET['kasir'];
    $tgl1 = $_GET['tgl1'];
    $tgl2 = $_GET['tgl2'];
    $kat = $_GET['kategori'];
    
    // Query yang dioptimasi - menggunakan GROUP BY kodefaktur untuk mencegah duplikasi
    $query_Penjualan = sprintf(
      "SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan`, `nohp` 
       FROM faktur f
       WHERE f.statusfaktur = 'Y' AND f.addbyfaktur = %s AND (f.tglfaktur BETWEEN %s AND %s) AND f.periode = %s 
       AND f.kodefaktur IN (SELECT DISTINCT faktur FROM transaksidetail td INNER JOIN produk p ON td.nama = p.namaproduk WHERE p.kategori = %s)
       GROUP BY f.kodefaktur
       ORDER BY f.idfaktur DESC",
      GetSQLValueString($colname, "text"),
      GetSQLValueString($tgl1, "date"),
      GetSQLValueString($tgl2, "date"),
      GetSQLValueString($ta, "text"),
      GetSQLValueString($kat, 'text')
    );

    $query_total = sprintf(
      "SELECT SUM(nominal) as jumlah FROM pengeluaran
       WHERE tgl BETWEEN %s AND %s",
      GetSQLValueString($tgl1, "date"),
      GetSQLValueString($tgl2, "date")
    );

    //total pendapatan - query yang dioptimasi
    $query_Pendapatan = sprintf(
      "SELECT SUM(totalbayar - kembalian) AS `pendapatan` 
       FROM faktur 
       WHERE statusfaktur = 'Y' AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND periode = %s 
       AND kodefaktur IN (SELECT DISTINCT faktur FROM transaksidetail td INNER JOIN produk p ON td.nama = p.namaproduk WHERE p.kategori = %s)",
      GetSQLValueString($colname, "text"),
      GetSQLValueString($tgl1, "date"),
      GetSQLValueString($tgl2, "date"),
      GetSQLValueString($ta, "text"),
      GetSQLValueString($kat, 'text')
    );
  } else {
    $colname = $_GET['kasir'];
    $tgl1 = $_GET['tgl1'];
    $tgl2 = $_GET['tgl2'];
    $kat = $_GET['kategori'];
    $jenisbayar = $_GET['jenisbayar'];
    
    // Query yang dioptimasi
    $query_Penjualan = sprintf(
      "SELECT DISTINCT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan`, `nohp` 
       FROM faktur 
       WHERE jenisbayar = %s AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND statusfaktur = 'Y' AND periode = %s 
       AND kodefaktur IN (SELECT DISTINCT faktur FROM transaksidetail td INNER JOIN produk p ON td.nama = p.namaproduk WHERE p.kategori = %s)
       ORDER BY idfaktur DESC",
      GetSQLValueString($jenisbayar, "text"),
      GetSQLValueString($colname, "text"),
      GetSQLValueString($tgl1, "date"),
      GetSQLValueString($tgl2, "date"),
      GetSQLValueString($ta, "text"),
      GetSQLValueString($kat, 'text')
    );

    $query_total = sprintf(
      "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s",
      GetSQLValueString($tgl1, "date"),
      GetSQLValueString($tgl2, "date")
    );

    //total pendapatan - query yang dioptimasi
    $query_Pendapatan = sprintf(
      "SELECT SUM(totalbayar - kembalian) AS `pendapatan` 
       FROM faktur 
       WHERE jenisbayar = %s AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND statusfaktur = 'Y' AND periode = %s 
       AND kodefaktur IN (SELECT DISTINCT faktur FROM transaksidetail td INNER JOIN produk p ON td.nama = p.namaproduk WHERE p.kategori = %s)",
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
    "SELECT DISTINCT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan`, `nohp` FROM faktur
		WHERE statusfaktur = 'Y' AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s ORDER BY idfaktur DESC",
    GetSQLValueString($colname, "text"),
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text")
  );
  //echo "<script>alert('ini tanggal kasir');</script>";

  $query_total = sprintf(
    "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );

  //total pendapatan
  $query_Pendapatan = sprintf(
    "SELECT SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE statusfaktur = 'Y' AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s ORDER BY idfaktur DESC",
    GetSQLValueString($colname, "text"),
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text")
  );
} elseif (isset($_GET['kategori']) && ($_GET['kategori'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
  $kat = $_GET['kategori'];
  $tgl1 = $_GET['tgl1'];
  $tgl2 = $_GET['tgl2'];

  // Query yang dioptimasi untuk filter kategori
  $query_Penjualan = sprintf(
    "SELECT DISTINCT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan`, `nohp` 
     FROM faktur 
     WHERE statusfaktur = 'Y' AND (tglfaktur BETWEEN %s AND %s) AND periode = %s 
     AND kodefaktur IN (SELECT DISTINCT faktur FROM transaksidetail td INNER JOIN produk p ON td.nama = p.namaproduk WHERE p.kategori = %s)
     ORDER BY idfaktur DESC",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text"),
    GetSQLValueString($kat, "text")
  );

  $query_total = sprintf(
    "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );

  //total pendapatan - query yang dioptimasi
  $query_Pendapatan = sprintf(
    "SELECT SUM(totalbayar - kembalian) AS `pendapatan` 
     FROM faktur 
     WHERE statusfaktur = 'Y' AND (tglfaktur BETWEEN %s AND %s) AND periode = %s 
     AND kodefaktur IN (SELECT DISTINCT faktur FROM transaksidetail td INNER JOIN produk p ON td.nama = p.namaproduk WHERE p.kategori = %s)",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text"),
    GetSQLValueString($kat, "text")
  );
} elseif (isset($_GET['kategori']) && ($_GET['kategori'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
  $kat = $_GET['kategori'];
  $tgl1 = $_GET['tgl1'];
  $tgl2 = $_GET['tgl2'];

  // Query yang dioptimasi untuk filter kategori
  $query_Penjualan = sprintf(
    "SELECT DISTINCT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan`, `nohp` 
     FROM faktur 
     WHERE statusfaktur = 'Y' AND (tglfaktur BETWEEN %s AND %s) AND periode = %s 
     AND kodefaktur IN (SELECT DISTINCT faktur FROM transaksidetail td INNER JOIN produk p ON td.nama = p.namaproduk WHERE p.kategori = %s)
     ORDER BY idfaktur DESC",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text"),
    GetSQLValueString($kat, "text")
  );

  $query_total = sprintf(
    "SELECT SUM(nominal) as jumlah FROM pengeluaran
     WHERE tgl BETWEEN %s AND %s",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );

  //total pendapatan - query yang dioptimasi
  $query_Pendapatan = sprintf(
    "SELECT SUM(totalbayar - kembalian) AS `pendapatan` 
     FROM faktur 
     WHERE statusfaktur = 'Y' AND (tglfaktur BETWEEN %s AND %s) AND periode = %s 
     AND kodefaktur IN (SELECT DISTINCT faktur FROM transaksidetail td INNER JOIN produk p ON td.nama = p.namaproduk WHERE p.kategori = %s)",
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
    "SELECT DISTINCT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan`, `nohp` FROM faktur
		WHERE periode = %s AND tglfaktur BETWEEN %s AND %s  
		ORDER BY idfaktur DESC",
    GetSQLValueString($ta, "text"),
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );

  //echo "<script>alert('ini tanggal');</script>";
  $query_total = sprintf(
    "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );
  //echo "<script>alert('ini tanggal');</script>";
  //total pendapatan
  $query_Pendapatan = sprintf(
    "SELECT  SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE periode = %s AND tglfaktur BETWEEN %s AND %s",
    GetSQLValueString($ta, "text"),
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );
} else {
  //mysqli_select_db($database_koneksi, $koneksi);
  $query_Penjualan = sprintf(
    "SELECT DISTINCT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`, `namapelanggan`, `nohp` FROM faktur
		WHERE periode = %s ORDER BY idfaktur DESC",
    GetSQLValueString($ta, "text")
  );

  $query_total = sprintf(
    "SELECT SUM(nominal) as jumlah FROM pengeluaran
		WHERE tgl BETWEEN %s AND %s",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );

  $query_Pendapatan = sprintf(
    "SELECT SUM(totalbayar - kembalian) AS `pendapatan` FROM faktur
		WHERE tglfaktur BETWEEN %s AND %s",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );
}


// Eksekusi query
$rs_Penjualan = mysqli_query($koneksi, $query_Penjualan) or die(mysqli_error($koneksi));
$row_Penjualan = mysqli_fetch_assoc($rs_Penjualan);
$totalRows_Penjualan  = mysqli_num_rows($rs_Penjualan);

$rs_total = mysqli_query($koneksi, $query_total) or die(mysqli_error($koneksi));
$row_Total = mysqli_fetch_assoc($rs_total);

$rs_pendapatan = mysqli_query($koneksi, $query_Pendapatan) or die(mysqli_error($koneksi));
$row_Pendapatan = mysqli_fetch_assoc($rs_pendapatan);

// Query untuk laba yang dioptimasi
if (isset($kat) && $kat != "-1" && $kat != "0") {
  $query_Laba = sprintf(
    "SELECT SUM(((td.harga * td.qty) - (td.hargadasar * td.qty)) - td.diskon) AS laba 
     FROM transaksidetail td
     INNER JOIN faktur f ON td.faktur = f.kodefaktur
     INNER JOIN produk p ON td.nama = p.namaproduk
     WHERE f.statusfaktur = 'Y' AND (f.tglfaktur BETWEEN %s AND %s) AND f.periode = %s AND p.kategori = %s",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text"),
    GetSQLValueString($kat, "text")
  );
} else {
  $query_Laba = sprintf(
    "SELECT SUM(((harga * qty) - (hargadasar * qty)) - diskon) AS laba 
     FROM transaksidetail
     INNER JOIN faktur ON transaksidetail.faktur = faktur.kodefaktur
     WHERE tglfaktur BETWEEN %s AND %s",
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date")
  );
}



// Reset pointer untuk loop
mysqli_data_seek($rs_Penjualan, 0);

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

// Query untuk data per kategori
if ($show_by_category) {
  $query_CategoryData = sprintf(
    "SELECT 
      k.idkategori,
      k.namakategori,
      COUNT(DISTINCT f.kodefaktur) as total_faktur,
      COALESCE(SUM(f.totalbayar - f.kembalian), 0) as total_pendapatan,
      COALESCE(SUM(((td.harga * td.qty) - (td.hargadasar * td.qty)) - td.diskon), 0) as total_laba
    FROM kategori k
    INNER JOIN produk p ON k.idkategori = p.kategori
    INNER JOIN transaksidetail td ON p.namaproduk = td.nama
    INNER JOIN faktur f ON td.faktur = f.kodefaktur
    WHERE f.statusfaktur = 'Y' 
      AND f.addbyfaktur = %s 
      AND (f.tglfaktur BETWEEN %s AND %s) 
      AND f.periode = %s
    GROUP BY k.idkategori, k.namakategori
    HAVING total_pendapatan > 0
    ORDER BY total_pendapatan DESC",
    GetSQLValueString($colname, "text"),
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text")
  );
  $CategoryData = mysqli_query($koneksi, $query_CategoryData) or die(mysqli_error($koneksi));
}
?>

<?php if ($totalRows_Penjualan > 0) { ?>
  <?php if (isset($_GET['tgl1']) && isset($_GET['tgl2']) && isset($_GET['kasir'])) { ?>
    <h3>LAPORAN PENJUALAN</h3>
    <p>Berikut ini adalah data penjualan berdasarkan tanggal <?= $_GET['tgl1']; ?> s/d tanggal <?= $_GET['tgl2']; ?> <?= $kasir; ?> ditemukan sebanyak <?= $totalRows_Penjualan; ?> transaksi.
    <?php } ?>
    
    <!-- Tampilan Data Per Kategori -->
    <?php if ($show_by_category && isset($CategoryData)) { ?>
      <h4>📊 LAPORAN PENJUALAN PER KATEGORI</h4>
      <table width="100%" class="tableku">
        <tr>
          <th width="30%" bgcolor="#003366"><span>KATEGORI</span></th>
          <th width="20%" bgcolor="#003366"><span>TOTAL FAKTUR</span></th>
          <th width="25%" bgcolor="#003366"><span>TOTAL PENDAPATAN</span></th>
          <th width="25%" bgcolor="#003366"><span>TOTAL LABA</span></th>
        </tr>
        <?php 
        $total_pendapatan_kategori = 0;
        $total_laba_kategori = 0;
        $total_faktur_kategori = 0;
        
        while ($row_CategoryData = mysqli_fetch_assoc($CategoryData)) { 
          $total_pendapatan_kategori += $row_CategoryData['total_pendapatan'];
          $total_laba_kategori += $row_CategoryData['total_laba'];
          $total_faktur_kategori += $row_CategoryData['total_faktur'];
        ?>
          <tr>
            <td><?= $row_CategoryData['namakategori']; ?></td>
            <td align="center"><?= $row_CategoryData['total_faktur']; ?></td>
            <td align="right">Rp. <?= number_format($row_CategoryData['total_pendapatan']); ?></td>
            <td align="right">Rp. <?= number_format($row_CategoryData['total_laba']); ?></td>
          </tr>
        <?php } ?>
        <tr style="background-color: #f0f0f0; font-weight: bold;">
          <td><strong>TOTAL</strong></td>
          <td align="center"><strong><?= $total_faktur_kategori; ?></strong></td>
          <td align="right"><strong>Rp. <?= number_format($total_pendapatan_kategori); ?></strong></td>
          <td align="right"><strong>Rp. <?= number_format($total_laba_kategori); ?></strong></td>
        </tr>
      </table>
      <br><br>
    <?php } ?>
    
    <h4>📋 LAPORAN PENJUALAN DETAIL</h4>
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
      $seenFaktur = array();

      do {

        // Skip if faktur already rendered
        if (isset($seenFaktur[$row_Penjualan['kodefaktur']])) {
          continue;
        }
        $seenFaktur[$row_Penjualan['kodefaktur']] = true;

        $totalpotongan += $row_Penjualan['potongan'];

        //QUERY DETAIL - Tampilkan SEMUA item dalam faktur, bukan hanya yang sesuai kategori
        $kat = $_GET['kategori'];
        if ($kat == "0") {
          $query_DetailFaktur = sprintf("SELECT faktur, tanggal, kode, td.nama, harga, qty, diskon, addby, stt, periode, vw_login.Nama as kassa, k.namakategori, (td.harga-td.hargadasar) as margin FROM transaksidetail td\n\t\t\t\t\t\tLEFT JOIN vw_login ON addby = vw_login.ID \n\t\t\t\t\t\tLEFT JOIN produk p ON td.nama = p.namaproduk\n        LEFT JOIN kategori k ON k.idkategori = p.kategori\n\t\t\t\t\t\tWHERE faktur = %s", GetSQLValueString($row_Penjualan['kodefaktur'], "text"));
        } else {
          // Untuk kategori tertentu, tampilkan hanya item sesuai kategori
          $query_DetailFaktur = sprintf("SELECT faktur, tanggal, kode, td.nama, harga, qty, diskon, addby, stt, periode, vw_login.Nama as kassa, k.namakategori, (td.harga-td.hargadasar) as margin FROM transaksidetail td\n          LEFT JOIN vw_login ON addby = vw_login.ID \n          LEFT JOIN produk p ON td.nama = p.namaproduk\n          LEFT JOIN kategori k ON k.idkategori = p.kategori\n          WHERE faktur = %s AND p.kategori = %s", GetSQLValueString($row_Penjualan['kodefaktur'], "text"), GetSQLValueString($kat, "text"));
        }
        $DetailFaktur = mysqli_query($koneksi, $query_DetailFaktur) or die(mysqli_error($koneksi));
        $row_DetailFaktur = mysqli_fetch_assoc($DetailFaktur);
        $totalRows_DetailFaktur = mysqli_num_rows($DetailFaktur);
        
        // Hitung total dari detail items untuk verifikasi
        $calculated_total = 0;
        if ($row_DetailFaktur) {
          do {
            $calculated_total += $row_DetailFaktur['harga'] * $row_DetailFaktur['qty'];
          } while ($row_DetailFaktur = mysqli_fetch_assoc($DetailFaktur));
          // Reset pointer untuk loop berikutnya
          mysqli_data_seek($DetailFaktur, 0);
          $row_DetailFaktur = mysqli_fetch_assoc($DetailFaktur);
        }

        // Akumulasi TOTAL BELANJA dari subtotal detail (bukan dari tabel faktur)
        $totalbelanja += $calculated_total;

        //hitung laba
        if ($kat != 0) {
          $query_laba = sprintf("SELECT SUM(((a.harga * a.qty) - (a.hargadasar * a.qty)) - a.diskon) as laba FROM transaksidetail a,produk b WHERE a.faktur = %s AND a.nama=b.namaproduk AND b.kategori= %s",  GetSQLValueString($row_Penjualan['kodefaktur'], "text"), GetSQLValueString($kat, "text"));
        } else {
          $query_laba = sprintf("SELECT SUM(((harga * qty) - (hargadasar * qty)) - diskon) as laba FROM transaksidetail WHERE faktur = %s",  GetSQLValueString($row_Penjualan['kodefaktur'], "text"));
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
            <div align="right">Rp. <?php echo number_format($calculated_total); ?></div>
            <!-- <?php if ($calculated_total != $row_Penjualan['totalbelanja']) { ?>
              <small style="color: red;">(Detail: Rp. <?php echo number_format($calculated_total); ?>)</small>
            <?php } ?> -->
          </td>
          <td>
            <div align="right">Rp. <?php echo number_format($row_Penjualan['potongan']); ?></div>
          </td>
          <td>
            <div align="right">Rp. <?php echo number_format($tlaba); ?></div>
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

              if ($row_DetailFaktur) {
                do {
                  $sub = $row_DetailFaktur['harga'] * $row_DetailFaktur['qty'];
                  $total += $sub;
                  // $disk += $row_DetailFaktur['diskon'];
                  $totalmargin += ($row_DetailFaktur['margin'] * $row_DetailFaktur['qty']) - $row_DetailFaktur['diskon'];
                ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td class="text-uppercase"><?php echo $row_DetailFaktur['kode']; ?>- <?php echo $row_DetailFaktur['nama']; ?><br><small><?php echo $row_DetailFaktur['namakategori']; ?></small></td>
                    <td><?php echo $row_DetailFaktur['qty']; ?> @ Rp. <?php echo number_format($row_DetailFaktur['harga']); ?></td>
                    <td>
                      <div align="right">Rp. <?php echo number_format($sub); ?></div>
                    </td>
                    <td>
                      <div align="right">Rp. <?php echo number_format(($row_DetailFaktur['margin'] * $row_DetailFaktur['qty']) - $row_DetailFaktur['diskon']); ?></div>
                    </td>
                  </tr>
                <?php
                  $no++;
                } while ($row_DetailFaktur = mysqli_fetch_assoc($DetailFaktur));
              }
              ?>
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
                  <div align="right">Rp. <?php echo number_format($totalmargin); ?></div>
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
          <div align="right">TOTAL LABA BERSIH
          </div>
        </th>
        <td>
          <div align="right"><?= number_format($totalLaba); ?>
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
} ?>