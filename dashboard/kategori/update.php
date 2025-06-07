<?php  
//require_once('izin.php');
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE kategori SET `namakategori`=%s,`ketkategori`=%s,`updatedkategori`=%s  WHERE `idkategori`=%s",
                       GetSQLValueString($_POST['namakategori'], "text"),
					   GetSQLValueString($_POST['ketkategori'], "text"),
					   GetSQLValueString(time(), "int"),
					   GetSQLValueString($_POST['idkategori'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(errorQuery(mysql_error()));
  
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_update (`url`, `oleh`) VALUES (%s, %s)",
  GetSQLValueString($actual_link, "text"),
  GetSQLValueString($ID, "int"));
  mysql_select_db($database_koneksi, $koneksi);
  $ResultSQL = mysql_query($activitySQL, $koneksi) or die(errorQuery(mysql_error()));	
  //26 desember close
  
  if ($Result1) {
  	refresh('?page=kategori/view&sukses');
  }
}

$colname_UpdateKategori  = "-1";
if (isset($_GET['id_kategori'])) {
  $colname_UpdateKategori  = $_GET['id_kategori'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_UpdateKategori = sprintf("SELECT * FROM kategori WHERE idkategori = %s", GetSQLValueString($colname_UpdateKategori, "int"));
$UpdateKategori = mysql_query($query_UpdateKategori, $koneksi) or die(errorQuery(mysql_error()));
$row_UpdateKategori = mysql_fetch_assoc($UpdateKategori);
$totalRows_UpdateKategori = mysql_num_rows($UpdateKategori);
	
?> 

<?php
	titleUpdate('UPDATE DATA KATEGORI','kategori'); 
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" height="246">
    <tr valign="baseline">
      <td><div align="left"><strong>NAMA KATEGORI</strong></div>
      <input type="text" name="namakategori" value="<?php echo htmlentities($row_UpdateKategori['namakategori'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>KETERANGAN</strong></div>
      <textarea name="ketkategori" cols="50" rows="5" class="form-control input-sm"><?php echo htmlentities($row_UpdateKategori['ketkategori'], ENT_COMPAT, 'utf-8'); ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td><?php btnSubmit('edit','Edit Data');?> <?php kembali('?page=kategori/view'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="idkategori" value="<?php echo $row_UpdateKategori['idkategori']; ?>" />
</form> 