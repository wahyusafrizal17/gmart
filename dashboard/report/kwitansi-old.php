<?php
require_once('../require/lap_header.php');
$colname_Penjualan = "-1";
if (isset($_GET['id'])) {
  $colname_Penjualan = $_GET['id'];
}
mysqli_select_db($database_koneksi, $koneksi);
$query_Penjualan = sprintf(
  "SELECT faktur, kode, nama, harga, qty, kembalian, potongan, totalbayar, diskon FROM transaksidetail INNER JOIN faktur ON faktur = kodefaktur WHERE faktur = %s",
  GetSQLValueString($colname_Penjualan, "text")
);
$Penjualan = mysqli_query($query_Penjualan, $koneksi) or die(mysqli_error());
$row_Penjualan = mysqli_fetch_assoc($Penjualan);
$totalRows_Penjualan = mysqli_num_rows($Penjualan);

mysqli_select_db($database_koneksi, $koneksi);
$query_faktur = sprintf(
  "SELECT faktur.idfaktur, faktur.kodefaktur, faktur.kembalian, faktur.potongan, faktur.totalbayar, faktur.nohp, faktur.namapelanggan, vw_login.Nama, faktur.qtyprint FROM faktur 
	LEFT JOIN vw_login ON addbyfaktur = ID
	LEFT JOIN faktur c ON faktur.printby = ID
	WHERE faktur.kodefaktur = %s",
  GetSQLValueString($colname_Penjualan, "text")
);
$faktur = mysqli_query($query_faktur, $koneksi) or die(mysqli_error());
$row_faktur = mysqli_fetch_assoc($faktur);
$totalRows_faktur = mysqli_num_rows($faktur);

//penambahan tanggal 29 September 2020
mysqli_select_db($database_koneksi, $koneksi);
$query_JmlhPrint = sprintf(
  "UPDATE faktur SET qtyprint = qtyprint + 1, printby = %s WHERE kodefaktur = %s",
  GetSQLValueString($ID, "int"),
  GetSQLValueString($colname_Penjualan, "text")
);
$JPrint = mysqli_query($query_JmlhPrint, $koneksi) or die(errorQuery(mysqli_error()));
//----------

mysqli_select_db($database_koneksi, $koneksi);
$query_antrian =  "SELECT (count(idfaktur) + 1) as antrian FROM faktur WHERE faktur.tglfaktur = CURRENT_DATE ";
$antrian = mysqli_query($query_antrian, $koneksi) or die(mysqli_error());
$row_antrian = mysqli_fetch_assoc($antrian);
$totalRows_antrian = mysqli_num_rows($antrian);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Dashboard - <?= $header; ?></title>

  <style>
    * {
      font-family: sans-serif;
    }

    body {
      font-size: 18px;
      margin: 0px;
    }

    table {
      width: 100%;
    }
  </style>
</head>

<body onload="window.print();">
  <div class="text-center"><img src="../../assets/barcode/logo-struk.png" width="180px" />
    <br>
    <?= $text1; //$header 
    ?><br>
    <? //$footer; 
    ?>
  </div>
  =============================
  <div class="row" style="font-size: 16px;">
    <div class="col-xs-6">
      <?php echo $today; ?> <br>F-<?php echo $row_Penjualan['faktur']; ?>

    </div>
    <div class="col-xs-6">
      KASIR : <br><?php echo $row_faktur['Nama']; ?>
      
      
    </div>
  </div>
  =============================<br>
  <?php if (!empty($row_faktur['namapelanggan'])) { ?>
    <div class="row" style="font-size: 16px;">
      <div class="col-xs-6">
       <td colspan="4">MEMBER : <?php echo strtoupper ($row_faktur['namapelanggan']); ?>
      </div>
      
    </div>
    =============================<br>
  <?php } ?>
  <table cellpadding="0" cellspacing="0">
    <tbody>
      <?php
      $total = 0;
      $subtotal = 0;
      $diskon = 0;
      $qty = 0;
      $no = 1;
      do {
        $subtotal = $row_Penjualan['harga'] * $row_Penjualan['qty'];
        $qty += $row_Penjualan['qty'];
        $diskon += $row_Penjualan['diskon'];
      ?>

        <tr>
          <td colspan="4"><?php echo $row_Penjualan['nama']; ?></td>
        </tr>
        <tr>
          <td align="right"><?= $row_Penjualan['qty']; ?> x &nbsp;</td>
          <td><?= number_format($row_Penjualan['harga']); ?></td>
          <td><?php if ($row_Penjualan['diskon'] > 0) { ?>
              - Disc : <?= $row_Penjualan['diskon']; ?><br>
            <?php } ?></td>
          <td align="right"><?php echo number_format($subtotal - $row_Penjualan['diskon']); ?></td>
        </tr>
      <?php
        $total += $subtotal;
        $no++;
      } while ($row_Penjualan = mysqli_fetch_assoc($Penjualan));
      ?>
    </tbody>
  </table>
  =============================<br>
  <table cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td>ITEM </td>
        <td><?php echo $totalRows_Penjualan; ?></td>
        <td>TOTAL</td>
        <td align="right"><?php echo number_format($total  - $diskon); ?></td>
      </tr>
      <tr>
        <td>QTY</td>
        <td><?php echo $qty; ?></td>
        <td>TUNAI</td>
        <td align="right"><?php echo number_format($row_faktur['totalbayar']); ?></td>
      </tr>
      <tr>
        <td></td>
        <td> </td>
        <td>KEMBALI</td>
        <td align="right"><?php echo number_format($row_faktur['kembalian']); ?></td>
      </tr>
    </tbody>
  </table>
  <hr>
  <p align="center"><?= $text2; ?> <br>

    </p>

</body>

</html>