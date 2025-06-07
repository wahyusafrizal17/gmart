<?php require_once('../../Connections/koneksi.php'); ?>
<?php 
mysql_select_db($database_koneksi, $koneksi);
$query_rs_produk = "SELECT LEFT(namaproduk, 30) as namaproduk, namakategori, kodeproduk, satuan, stok FROM produk 
LEFT JOIN kategori ON produk.kategori = kategori.idkategori 
WHERE stok <= 2";
$rs_produk = mysql_query($query_rs_produk, $koneksi) or die(mysql_error());
$row_rs_produk = mysql_fetch_assoc($rs_produk);
$totalRows_rs_produk = mysql_num_rows($rs_produk);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>List Produk</title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->

</style>
<style>
 
	/* --- */
	@font-face {
                font-family: code39;
                src: url('../../assets/barcode/Code39Azalea.ttf');
            }
			.barcode{
				  display: inline-block;
				  width: 110px;
				  height: 50px;
				  padding: 1px 5px;
				  margin: 5px 5px;
				  border: 1px solid black;    
			}
	 /* --- */
    h1 {
        font-weight: bold;
        font-size: 20pt;
        text-align: center;
    }
 
    table {
        border-collapse: collapse;
    }
 
    .table th {
        border:1px solid #000000;
        text-align: center;
    }
 
    .table td {
        border:1px solid #000000;
    }
	.table td .table td {
        border:0px solid #000000;
    }
    .text-center {
        text-align: center;
    }

.table-collapse {
	border-collapse:collapse;
}
.style2 {
	font-size: xx-small;
	font-weight: bold;
	font-style: italic;
}
.col-md-3 {
	font-size : 7px;
}
.style10 {font-size: 9px; font-family: Geneva, Arial, Helvetica, sans-serif; }
.style13 {font-size: 10px; font-family: Geneva, Arial, Helvetica, sans-serif; }
.style14 {font-size: 10px}
.style15 {font-family: Geneva, Arial, Helvetica, sans-serif}
</style>

</head>

<body onload="window.print()">
<p>LIST PRODUK YANG PERLU DIPESAN</p>
<table class="table table-striped table-bordered" width="100%">
<thead>
  <tr>
    <th bgcolor="#006699"><div align="center" class="style1">NO.</div></th>
    <th bgcolor="#006699"><div align="center" class="style1">NAMA PRODUK</div></th>
    <th bgcolor="#006699"><div align="center" class="style1">KATEGORI</div></th>
    <th bgcolor="#006699"><div align="center" class="style1">STOK</div></th>
    <th bgcolor="#006699"><div align="center" class="style1">SATUAN</div></th>
    </tr>
  </thead>
  <tbody>
  <?php 
  $no = 1;
  do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_rs_produk['kodeproduk']; ?> - <?php echo $row_rs_produk['namaproduk']; ?></td>
      <td><?php echo $row_rs_produk['namakategori']; ?></td>
      <td><div align="center"><?php echo $row_rs_produk['stok']; ?></div></td>
      <td><div align="center"><?php echo $row_rs_produk['satuan']; ?></div></td>
      </tr>
    <?php 
	$no++;
	} while ($row_rs_produk = mysql_fetch_assoc($rs_produk)); ?>
    </tbody>
</table>
