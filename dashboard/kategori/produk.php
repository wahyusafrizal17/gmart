<?php require_once('kategori/Page1.php'); ?>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<div align="right"><a href="?page=produk/insert&cat=<?= $colname_kategori; ?>" class="btn btn-primary"><span class="fa fa-plus-circle"></span> Add Product</a> </div>
<br />

         
<?php
	titleTampil('DAFTAR PRODUK','produk per kategori');
?> 
<?php if ($totalRows_Kategori > 0 ) { ?> 
  <div class="row">
                                            <form method="get">
                                                <div class="col-md-10">
                                                  <input type="text" name="cari" class="form-control" placeholder="Cari Kode Produk / Nama Produk / Kategori">
                                                </div>
                                                 
                                                <div class="col-md-2">
                                                  <button type="submit" class="btn btn-primary btn-block"><span class="fa fa-search"></span> Search</button>
                                                  <input type="hidden" name="page" value="kategori/produk">
                                                </div>
                                                
                                             </form>     
                                      </div>
                                      <br />  
<table width="100%" class="table table-striped table-hover table-bordered">
<thead>

  </thead>
  <tbody>
  <?php $no = 1; do { ?>
    <tr>
      <td><div align="center"><?php echo $no++; ?></div></td>
      <td>
      <?php echo $row_Kategori['namaproduk']; ?><br />
      <strong><a href="?page=history/produk&kode=<?php echo $row_Kategori['kodeproduk']; ?>" title="<?php echo $row_Kategori['deskproduk']; ?>"><?php echo $row_Kategori['kodeproduk']; ?></a></strong>
        </td>
      <td><table width="100%">
          <tr>
            <!--<th><div align="center"><strong>Harga Dasar </strong></div></th>-->
            <th><div align="center"><strong> Harga </strong></div></th>
          </tr>
          <tr>
            <!--<td> 
              <div align="center"><?php echo number_format($row_Kategori['hargadasar']); ?></div></td>-->
            <td> 
              <div align="center"><?php echo number_format($row_Kategori['hargajual']); ?></div></td>
          </tr>
        </table>
        </td>
      <td><table width="100%">
        <tr>
          <td><div align="center"><strong>Stok Terkini</strong></div></td>
          <td><div align="center"><strong>Min. Produk</strong></div></td>
        </tr>
        <tr>
          <td><div align="center"><?php echo $row_Kategori['stok']; ?></div></td>
          <td><div align="center"><?php echo $row_Kategori['minProduk']; ?></div></td>
        </tr>
      </table>
        </td>
      <td><?php echo $row_Kategori['alertproduk']; ?></td>
      <td><?php $fungsi($row_Kategori['idproduk'],'produk','produk'); ?></td>
    </tr>
    <?php } while ($row_Kategori = mysql_fetch_assoc($rs_Kategori)); ?>
    </tbody>
</table> 
<?php }else{
	danger('Oops!','Produk dengan kategori tersebut tidak tersedia');
} ?>

<?php require_once('kategori/Page2.php'); ?>