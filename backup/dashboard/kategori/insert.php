<?php  
//require_once('izin.php');
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

 
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO kategori (`namakategori`, `ketkategori`, `addedkategori`, `addbykategori`) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($koneksi, $_POST['namakategori'], "text"),
                       GetSQLValueString($koneksi, $_POST['ketkategori'], "text"),
					   GetSQLValueString($koneksi, time() , "int"),
					   GetSQLValueString($koneksi, $ID, "int"));

  //mysqli_select_db($database_koneksi);
  $Result1 = mysqli_query($koneksi, $insertSQL) or die(errorQuery(mysqli_error($koneksi)));
  
  if ($Result1) {
  	refresh('?page=kategori/view&sukses');
  }
}


?> 
<?php if (isset($_GET['sukses'])) { 
   		sukses('Data kategori berhasil tersimpan');
} ?>
<?php
	titleSimpan('ENTRY DATA KATEGORI','kategori');
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%"  class="table table-striped">
    <tr valign="baseline">
      <td><div align="left"><strong>Nama Kategori</strong></div>
      <input type="text" name="namakategori" value="" size="32" class="form-control" /></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Keterangan</strong></div>
      <textarea name="ketkategori" cols="50" rows="5" class="form-control" ></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td><?php btnSubmit('save','Simpan'); ?> <?php kembali('?page=kategori/view'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form> 