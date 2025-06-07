<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
<?php require_once('tabulasi/laris1.php'); ?>
<div class="col-md-6"> 
<?php
	title('success','DAFTAR PRODUK TERLARIS','Berikut ini adalah produk terlaris');
?>
<?php if ($totalRows_Terlaris > 0) { ?>
                                      <div class="row">
                                            <form method="get">
                                                <div class="col-lg-8">
                                                  <input type="text" name="carilaris" class="form-control" placeholder="Cari Kode Produk / Nama Produk">
                                                </div>
                                                 
                                                <div class="col-lg-4">
                                                  <button type="submit" class="btn btn-primary btn-block"><span class="fa fa-search"></span> Search</button>
                                                  <input type="hidden" name="page" value="tabulasi/produk">
                                                </div>
                                                
                                             </form>     
                                      </div>  
                                      <br/>
<table width="100%" class="table table-striped">
<thead>
  <tr bgcolor="#006699">
    <th><div align="center"><span class="style1">NO</span></div></th>
    <th><div align="center"><span class="style1">PRODUK</span></div></th>
    <th><div align="center"><span class="style1">TRANSAKSI</span></div></th>
    <th><div align="center"><span class="style1">QTY</span></div></th>
  </tr>
  </thead>
  <tbody>
  <?php $no = 1; do { ?>
    <tr>
      <td><div align="center"><?= $no++; ?></div></td>
      <td  class="text-uppercase"><?php echo $row_Terlaris['nama']; ?> ( <?php echo $row_Terlaris['kode']; ?> )</td>
      <td><?php echo $row_Terlaris['JumlahProduk']; ?> Transaksi</td>
      <td><?php echo $row_Terlaris['Jumlah']; ?> Item</td>
    </tr>
    <?php } while ($row_Terlaris = mysql_fetch_assoc($Terlaris)); ?>
    </tbody>
</table>
<?php }else{
	danger('Oops','Belum ada produk yang terjual');
}
?> 
<?php require_once('tabulasi/laris2.php'); ?>
<hr>
<a href="?page=tabulasi/other" class="btn btn-lg btn-warning btn-block"> Lihat Transaksi Produk Lainnya</a>

</div>
<?php require_once('tabulasi/taklaris1.php'); ?>
<div class="col-md-6">
<?php
	title('danger','DAFTAR PRODUK BELUM TERJUAL','Berikut ini adalah produk yang belum pernah terjual sama sekali');
?>
<?php if ($totalRows_TakTerlaris > 0) { ?>
  <div class="row">
                                            <form method="get">
                                                <div class="col-lg-8">
                                                  <input type="text" name="cari" class="form-control" placeholder="Cari Kode Produk / Nama Produk">
                                                </div>
                                                 
                                                <div class="col-lg-4">
                                                  <button type="submit" class="btn btn-primary btn-block"><span class="fa fa-search"></span> Search</button>
                                                  <input type="hidden" name="page" value="tabulasi/produk">
                                                </div>
                                                
                                             </form>     
                                      </div>  
                                      <br/>
<table width="100%" class="table table-striped">
<thead>
  <tr bgcolor="#990000">
    <th><div align="center"><span class="style1">NO</span></div></th>
    <th><div align="center"><span class="style1">PRODUK</span></div></th>
    <th><div align="center"><span class="style1">HD</span></div></th>
    <th><div align="center"><span class="style1">HJ</span></div></th>
  </tr>
  </thead>
  <tbody>
  <?php $no = 1; do { ?>
    <tr>
      <td><div align="center"><?= $no++; ?></div></td>
      <td class="text-uppercase"><a href="?page=produk/update&id_produk=<?php echo $row_TakTerlaris['idproduk']; ?>"><?php echo $row_TakTerlaris['namaproduk']; ?></a> ( <?php echo $row_TakTerlaris['kodeproduk']; ?> )</td>
      <td>Rp. <?php echo $row_TakTerlaris['hargadasar']; ?></td>
      <td>Rp. <?php echo $row_TakTerlaris['hargajual']; ?></td>
    </tr>
    <?php } while ($row_TakTerlaris = mysql_fetch_assoc($TakTerlaris)); ?>
    </tbody>
</table> 
<?php }else{
	title('success','Congrats!!','Semua produk sudah pernah terjual');
}
?>
</div>
<?php require_once('tabulasi/taklaris2.php'); ?>