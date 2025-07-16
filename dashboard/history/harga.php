<?php  

$maxRows_Harga = 200;
$pageNum_Harga = 0;
if (isset($_GET['pageNum_Harga'])) {
  $pageNum_Harga = $_GET['pageNum_Harga'];
}
$startRow_Harga = $pageNum_Harga * $maxRows_Harga;

mysql_select_db($database_koneksi, $koneksi);
$query_Harga = "SELECT `kodeproduk`, `hargajual`, `hargabaru`, `hargadasar`, if(hargabaru > hargajual, 'Naik','Turun') as Status, if(hargabaru > hargajual, hargabaru - hargajual,hargajual - hargabaru) as Selisih, `namaprodukOld`, `namaprodukBaru`, addby, tercatat, vw_login.Nama FROM harga 
LEFT JOIN vw_login ON addby = ID 
ORDER BY idharga DESC";
$query_limit_Harga = sprintf("%s LIMIT %d, %d", $query_Harga, $startRow_Harga, $maxRows_Harga);
$Harga = mysql_query($query_limit_Harga, $koneksi) or die(mysql_error());
$row_Harga = mysql_fetch_assoc($Harga);

if (isset($_GET['totalRows_Harga'])) {
  $totalRows_Harga = $_GET['totalRows_Harga'];
} else {
  $all_Harga = mysql_query($query_Harga);
  $totalRows_Harga = mysql_num_rows($all_Harga);
}
$totalPages_Harga = ceil($totalRows_Harga/$maxRows_Harga)-1;
?> 
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<?php
	title('success','DAFTAR PERUBAHAN PRODUK','Berikut ini adalah perubahan produk yang telah terekam');
?>
<?php if ($totalRows_Harga > 0) { ?>  
<table width="100%" class="table table-bordered table-hover table-striped" id="example2">
<thead>
  <tr bgcolor="#006666">
    <th width="1%"><div align="center" class="style1">NO.</div></th>
    <th width="43%"><div align="center" class="style1">NAMA PRODUK</div></th>
    <th width="12%"><div align="center" class="style1">HARGA JUAL</div></th>
    <th width="15%"><div align="center" class="style1">HARGA BARU</div></th>
    <th width="14%"><div align="center" class="style1">SELISIH</div></th>
    <th width="15%"><div align="center" class="style1">OLEH</div></th>
  </tr>
  </thead>
  <tbody>
  <?php $no = 1; do { ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $row_Harga['kodeproduk']; ?>- <?php echo $row_Harga['namaprodukBaru']; ?><br />
        Nama sebelumnya :<br /> 
        <?php echo $row_Harga['namaprodukOld']; ?></td>
      <td><div align="center" style="font-size:24px;"><?php echo number_format($row_Harga['hargajual']); ?></div></td>
      <td><div align="center" style="font-size:24px;"><?php echo number_format($row_Harga['hargabaru']); ?></div></td>
      <td>
      <?php if ($row_Harga['Status'] == 'Turun') { ?>
	  	<div class="btn btn-danger btn-block" style="font-size:24px;"><span class="fa fa-arrow-down"></span> <?php echo $row_Harga['Selisih']; ?></div>
      <?php }else{ ?>
        <div class="btn btn-success  btn-block" style="font-size:24px;"><span class="fa fa-arrow-up"></span> <?php echo $row_Harga['Selisih']; ?></div>
      <?php } ?>      </td>
      <td><?php echo $row_Harga['Nama']; ?><br />
      <?php echo $row_Harga['tercatat']; ?></td>
    </tr>
    <?php } while ($row_Harga = mysql_fetch_assoc($Harga)); ?>
    </tbody>
</table> 
<?php }else{
		danger('Oops!','Kode produk tersebut tidak dapat kami temukan');
		back();
	}
?>