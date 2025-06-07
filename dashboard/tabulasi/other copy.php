<?php  
mysql_select_db($database_koneksi, $koneksi);
$query_Terlaris = sprintf("SELECT kode, nama, COUNT(kode) as Transaksi, SUM(harga * qty) as Harga, SUM(qty) as Jumlah FROM `transaksidetail` WHERE periode = %s GROUP BY nama ORDER BY Jumlah DESC",
 GetSQLValueString($ta, "text"));
$Terlaris = mysql_query($query_Terlaris, $koneksi) or die(mysql_error());
$row_Terlaris = mysql_fetch_assoc($Terlaris);
$totalRows_Terlaris = mysql_num_rows($Terlaris);
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
<div class="col-md-12"> 
<?php
	title('success','DAFTAR PRODUK TERJUAL','Berikut ini adalah produk yang terjual');
?>
<a href="?page=tabulasi/produk" class="btn btn-lg btn-warning btn-block"> Kembali</a>
<table width="100%" class="table table-striped">
<thead>
  <tr bgcolor="#006699">
    <th><div align="center"><span class="style1">NO</span></div></th>
    <th><div align="center"><span class="style1">PRODUK</span></div></th>
    <th><div align="center"><span class="style1">TRANSAKSI</span></div></th>
    <th><div align="center"><span class="style1">QTY</span></div></th>
        <th><div align="center"><span class="style1">TOTAL</span></div></th>
  </tr>
  </thead>
  <tbody>
  <?php $no = 1; do { ?>
    <tr>
      <td><div align="center"><?= $no++; ?></div></td>
      <td  class="text-uppercase"><?php echo $row_Terlaris['nama']; ?> ( <?php echo $row_Terlaris['kode']; ?> )</td>
      <td><?php echo $row_Terlaris['Transaksi']; ?> Transaksi</td>
      <td><?php echo $row_Terlaris['Jumlah']; ?> Item</td>
      <td>Rp. <?php echo $row_Terlaris['Harga']; ?></td>
    </tr>
    <?php } while ($row_Terlaris = mysql_fetch_assoc($Terlaris)); ?>
    </tbody>
</table> 
<hr>


</div>
 