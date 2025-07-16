<?php  
require_once('../require/lap_header.php'); 
$colname_DetailFaktur = "-1";
if (isset($_GET['id'])) {
  $colname_DetailFaktur = $_GET['id'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_DetailFaktur = sprintf("SELECT faktur, tanggal, kode, transaksidetail.nama, harga, qty, diskon, addby, stt, periode, vw_login.Nama as kassa FROM transaksidetail 
LEFT JOIN vw_login ON addby = vw_login.ID WHERE faktur = %s", GetSQLValueString($colname_DetailFaktur, "text"));
$DetailFaktur = mysql_query($query_DetailFaktur, $koneksi) or die(mysql_error());
$row_DetailFaktur = mysql_fetch_assoc($DetailFaktur);
$totalRows_DetailFaktur = mysql_num_rows($DetailFaktur);

mysql_select_db($database_koneksi, $koneksi);
	$query_faktur = sprintf("SELECT faktur.*, vw_login.Nama FROM faktur 
	LEFT JOIN vw_login ON addbyfaktur = ID
	LEFT JOIN faktur c ON faktur.printby = ID
	WHERE faktur.kodefaktur = %s", 
	GetSQLValueString($colname_DetailFaktur, "text"));
$faktur = mysql_query($query_faktur, $koneksi) or die(mysql_error());
$row_faktur = mysql_fetch_assoc($faktur);
$totalRows_faktur = mysql_num_rows($faktur);

//penambahan tanggal 29 September 2020
mysql_select_db($database_koneksi, $koneksi);
$query_JmlhPrint = sprintf("UPDATE faktur SET qtyprint = qtyprint + 1, printby = %s WHERE kodefaktur = %s", 
GetSQLValueString($ID, "int"),
GetSQLValueString($colname_DetailFaktur, "text"));
$JPrint = mysql_query($query_JmlhPrint, $koneksi) or die(errorQuery(mysql_error()));
//----------
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {font-size: 10px}
-->
</style>

 
<table width="100%" height="127" cellpadding="0" cellspacing="0" class="">
  <tr>
    <th colspan="5" bgcolor="#006666"><div class="text-center style1"  style="font-size:25px">KWITANSI PEMBELIAN</div></th>
  </tr>
  <tr>
    <th colspan="2" bgcolor="#006666"><div align="center">
      <?= $title;?>
    </div></th>
    <th colspan="3" rowspan="3" bgcolor="#006666"><span class="text-center style1" style="font-size:50px">F : <?php echo $row_faktur['kodefaktur']; ?></span></th>
  </tr>
  <tr>
    <th colspan="2" bgcolor="#006666"> 
      <div align="right" class="style1">
        <div align="left">TANGGAL 
          <?php Tanggal($row_faktur['tglfaktur']); ?>
        </div>
      </div></th>
  </tr>
  <tr>
    <th colspan="2" bgcolor="#006666"><div align="right" class="style1">
      <div align="left">KASSA : <?php echo $row_faktur['Nama']; ?></div>
    </div></th>
  </tr>
  <tr class="table-bordered">
    <th width="3%" bgcolor="#003366"><span class="style1">NO</span></th>
    <th width="34%" bgcolor="#003366"><span class="style1">PRODUK</span></th>
    <th width="30%" bgcolor="#003366"><div align="center"><span class="style1">QTY</span></div></th>
    <th width="20%" bgcolor="#003366"><span class="style1">SUB TOTAL</span></th>
    <th width="13%" bgcolor="#003366"><span class="style1">POTONGAN</span></th>
  </tr>
  <?php 
  $total = 0;
  $no = 1;
  $disk = 0;
  do { 
  $sub = $row_DetailFaktur['harga'] * $row_DetailFaktur['qty']; 
  $total += $sub;
  $disk += $row_DetailFaktur['diskon'];
  ?>
    <tr class="table-striped">
      <td><?= $no;?></td>
      <td class="text-uppercase"><?php echo $row_DetailFaktur['kode']; ?>- <?php echo $row_DetailFaktur['nama']; ?></td>
      <td><div align="left"><?php echo $row_DetailFaktur['qty']; ?> @ Rp. <?php echo $row_DetailFaktur['harga']; ?></div></td>
      <td><div align="right">Rp. <?php echo $sub; ?></div></td>
      <td><div align="right">Rp. <?php echo $row_DetailFaktur['diskon']; ?></div></td>
    </tr>
    <?php 
	$no++;
	} while ($row_DetailFaktur = mysql_fetch_assoc($DetailFaktur)); ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong> TOTAL</strong></td>
      <td><div align="right">Rp. <?php echo $total; ?></div></td>
      <td><div align="right">Rp. <?php echo $disk; ?></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td bgcolor="#003366"><span class="style1"><strong>GRAND TOTAL</strong></span></td>
      <td><div align="right">Rp.  <?php echo $total - $disk; ?> </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td bgcolor="#003366"><span class="style1"><strong>UANG BAYAR (TUNAI)</strong></span></td>
      <td><div align="right">Rp.  <?php echo $row_faktur['totalbayar']; ?> </div></td>
    </tr>
    <tr >
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td bgcolor="#003366" class="table-bordered"><span class="style1"><strong>UANG KEMBALIAN</strong></span></td>
      <td class="table-bordered"><div align="right">Rp. <?php echo $row_faktur['kembalian']; ?></div></td>
    </tr>
    <tr >
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td bgcolor="#003366" class="table-bordered"><span class="style1"><strong>HEMAT</strong></span></td>
      <td class="table-bordered"><div align="right">Rp. <?php echo $disk; ?></div></td>
    </tr>
</table>
 
<p align="left" class="style16 style2">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan. <br>
 
Cetakan ke : <?php echo $row_faktur['qtyprint']; ?> by : <?php echo $row_faktur['Nama']; ?></p>
<div class="clearfix"></div>