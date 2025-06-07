<?php 
require_once('izin.php'); 
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE produk SET `namaproduk`=%s, kategori=%s, `deskproduk`=%s,`hargadasar`=%s,`hargajual`=%s,`satuan`=%s,`statusproduk`=%s,`updatedproduk`=%s WHERE `idproduk`=%s",
                       GetSQLValueString($koneksi, $_POST['namaproduk'], "text"),
					   GetSQLValueString($koneksi, $_POST['kategori'], "text"),
					   GetSQLValueString($koneksi, $_POST['deskproduk'], "text"),
					   GetSQLValueString($koneksi, str_replace(".","",$_POST['hargadasar']), "double"),
					   GetSQLValueString($koneksi, str_replace(".","",$_POST['hargajual']), "double"),
					   GetSQLValueString($koneksi, $_POST['satuan'], "text"),
					   //GetSQLValueString($koneksi, $_POST['stok'], "int"), -> Melalui Add dan Less Stok saja agar terhistory
					   GetSQLValueString($koneksi, $_POST['status'], "text"),     
					   GetSQLValueString($koneksi, time(), "int"),
					   GetSQLValueString($koneksi, $_POST['idproduk'], "int"));

  //mysqli_select_db($database_koneksi);
  $Result1 = mysqli_query($koneksi, $updateSQL) or die(errorQuery(mysqli_error()));
  
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_update (`url`, `oleh`) VALUES (%s, %s)",
  GetSQLValueString($koneksi, $actual_link, "text"),
  GetSQLValueString($koneksi, $ID, "int"));
  //mysqli_select_db($database_koneksi);
  $ResultSQL = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error()));	
  //26 desember close
  
  if ($Result1) {
  	refresh('?page=produk/view&sukses');
  }
}

$colname_UpdateProduk  = "-1";
if (isset($_GET['id_produk'])) {
  $colname_UpdateProduk  = $_GET['id_produk'];
}
//mysqli_select_db($database_koneksi);
$query_UpdateProduk = sprintf("SELECT * FROM produk WHERE idproduk = %s", GetSQLValueString($koneksi, $colname_UpdateProduk, "int"));
$UpdateProduk = mysqli_query($koneksi, $query_UpdateProduk) or die(errorQuery(mysqli_error()));
$row_UpdateProduk = mysqli_fetch_assoc($UpdateProduk);
$totalRows_UpdateProduk = mysqli_num_rows($UpdateProduk);

if ($totalRows_UpdateProduk > 0) {	

////mysqli_select_db($database_koneksi);
$query_Kategori = "SELECT kategori.*, vw_login.Nama FROM kategori LEFT JOIN vw_login ON addbykategori = ID ORDER BY idkategori ASC";
$Kategori = mysqli_query($koneksi, $query_Kategori) or die(errorQuery(mysqli_error()));
$row_Kategori = mysqli_fetch_assoc($Kategori);
$totalRows_Kategori = mysqli_num_rows($Kategori);
?> 

<?php
	titleUpdate('UPDATE DATA KATEGORI','kategori'); 
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">

  <table width="100%"  class="table table-striped">
    <tr valign="baseline">
      <td>
      <div class="row">
          <div class="col-md-6">
            <div class="callout callout-info">
              <label>Pilih Kategori</label>
                 
              <select name="kategori" class="form-control input-sm">
            <?php do {  ?>
            <option value="<?php echo $row_Kategori['idkategori']?>" <?php if (!(strcmp($row_Kategori['idkategori'], htmlentities($row_UpdateProduk['kategori'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_Kategori['namakategori']?></option>
            <?php } while ($row_Kategori = mysqli_fetch_assoc($Kategori)); ?>
          </select>
              </div>
          </div>   
          <div class="col-md-3">
            <div class="callout callout-success">
              <label>Status Produk</label>
                 
              <select name="status" class="form-control input-sm">
            <option value="Y" <?php if (!(strcmp('Y', htmlentities($row_UpdateProduk['statusproduk'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Aktif</option>
            <option value="N" <?php if (!(strcmp('N', htmlentities($row_UpdateProduk['statusproduk'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Tidak Aktif</option>
           </select>
              </div>
          </div>      
          <div class="col-md-3">
          <div align="left"><strong>Code Produk*</strong></div>
          <input type="text" name="kodeproduk" value="<?php echo htmlentities($row_UpdateProduk['kodeproduk'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" id="kodeproduk" disabled/>      
          </div>
          </div> <!-- col -->   
      </div><!-- row -->
      </td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Nama Produk*</strong></div>
          <input type="text" name="namaproduk" value="<?php echo htmlentities($row_UpdateProduk['namaproduk'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control text-uppercase" id="namaproduk" required autofocus/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Harga Dasar*</strong></div>
          <input type="text" name="hargadasar" value="<?php echo htmlentities($row_UpdateProduk['hargadasar'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control"  id="tanpa-rupiah" required/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Harga Jual*</strong></div>
          <input type="text" name="hargajual" value="<?php echo htmlentities($row_UpdateProduk['hargajual'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control"  id="tanpa-rupiah2" required/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Satuan*</strong></div>
          <input type="text" name="satuan" value="<?php echo htmlentities($row_UpdateProduk['satuan'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required/></td>
    </tr>
    
    <tr valign="baseline">
      <td><div align="left"><strong>Detail Produk</strong></div>
      <textarea name="deskproduk" cols="50" rows="5" class="form-control" ><?php echo htmlentities($row_UpdateProduk['deskproduk'], ENT_COMPAT, 'utf-8'); ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td><?php btnSubmit('save','Simpan'); ?> <?php kembali('?page=produk/view'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="idproduk" value="<?php echo $row_UpdateProduk['idproduk']; ?>" />
  <input type="hidden" name="MM_update" value="form1" />
</form> 

<?php }else{ //cat 
	back();
	echo "<br><br>";
	warning('Data produk itu tidak tersedia');
}?>