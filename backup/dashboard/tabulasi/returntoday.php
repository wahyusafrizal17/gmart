<?php  
//mysqli_select_db($database_koneksi);
$query_Return = "SELECT returnproduk.*, vw_login.Nama FROM returnproduk 
LEFT JOIN vw_login ON addbyreturn = vw_login.ID 
WHERE tglreturn = CURDATE() ORDER BY id_return DESC";
$Return = mysqli_query($koneksi, $query_Return) or die(mysqli_error());
$row_Return = mysqli_fetch_assoc($Return);
$totalRows_Return = mysqli_num_rows($Return);
?> 
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
 <?php
	  	title('success','DAFTAR RETURN PRODUK PER HARI INI','Berikut ini adalah data pengembalian produk per hari ini');
	  ?>
<?php if ($totalRows_Return > 0) { ?>      
<table width="100%" class="table table-striped" id="example1">
<thead>
  <tr align="center" bgcolor="#006666">
    <th><span class="style1">NO</span></th>
    <th><span class="style1">FAKTUR</span></th>
    <th><span class="style1">PRODUK</span></th>
    <th><span class="style1">QTY</span></th>
    <th><span class="style1">KETERANGAN</span></th>
  </tr>
  </thead>
  <tbody>
  <?php $no = 1; do { ?>
    <tr>
      <td><div align="center"><?php echo $no++; ?></div></td>
      <td><a href="?page=tabulasi/penjualan&cari=<?php echo $row_Return['asalfaktur']; ?>"><?php echo $row_Return['asalfaktur']; ?></a><br />
        #<?php echo $row_Return['addedreturn']; ?> #<?php echo $row_Return['Nama']; ?></td>
      <td><?php echo $row_Return['produkreturn']; ?><br />
      <?php echo $row_Return['namareturn']; ?></td>
      <td><?php echo $row_Return['qtyreturn']; ?><br />
      HD : Rp. <?php echo $row_Return['hargadasar']; ?> | HJ : Rp. <?php echo $row_Return['hargajual']; ?></td>
      <td><?php echo $row_Return['ketreturn']; ?></td>
    </tr>
    <?php } while ($row_Return = mysqli_fetch_assoc($Return)); ?>
    </tbody>
</table> 
<?php }else{
	back();
	echo "<br><br>";
	danger('Yeay...','Belum ada produk yang direturn hari ini'); 
}
?>