<?php  
require_once('izin.php');
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE kassa SET `user_kassa`=%s, `pwd_kassa`=PASSWORD(%s),`nama_kassa`=%s,`alamat_kassa`=%s,`telp_kassa`=%s,`status_kassa`=%s,`updated_kassa`=%s WHERE `id_kassa`=%s",
                       GetSQLValueString($_POST['user_kassa'], "text"),
					   GetSQLValueString($_POST['pwd_kassa'], "text"),
					   GetSQLValueString($_POST['nama_kassa'], "text"),
					   GetSQLValueString($_POST['alamat_kassa'], "text"),
					   GetSQLValueString($_POST['telp_kassa'], "text"),
					   GetSQLValueString($_POST['status_kassa'], "text"),
					   GetSQLValueString(time(), "int"),
					   GetSQLValueString($_POST['idkassa'], "int"));

  $Result1 = mysqli_query($koneksi, $updateSQL) or die(errorQuery(mysqli_error($koneksi)));
  
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_update (`url`, `oleh`) VALUES (%s, %s)",
  GetSQLValueString($actual_link, "text"),
  GetSQLValueString($ID, "int"));
  $ResultSQL = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error($koneksi)));	
  //26 desember close
  
  if ($Result1) {
  	refresh('?page=kassa/view&sukses');
  }
}

$colname_Updatekassa  = "-1";
if (isset($_GET['id_kassa'])) {
  $colname_Updatekassa  = $_GET['id_kassa'];
}
$query_Updatekassa = sprintf("SELECT * FROM kassa WHERE id_kassa = %s", GetSQLValueString($colname_Updatekassa, "int"));
$Updatekassa = mysqli_query($koneksi, $query_Updatekassa) or die(errorQuery(mysqli_error($koneksi)));
$row_Updatekassa = mysqli_fetch_assoc($Updatekassa);
$totalRows_Updatekassa = mysqli_num_rows($Updatekassa);
	
?> 

<?php
	titleUpdate('UPDATE DATA kassa','kassa'); 
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%">
    <tr valign="baseline">
      <td><div align="left"><strong>Username</strong></div>
          <input name="user_kassa" type="text" class="form-control" id="user_kassa" value="<?php echo htmlentities($row_Updatekassa['user_kassa'], ENT_COMPAT, 'utf-8'); ?>" size="32"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Reset Password</strong></div>
      <input type="text" name="pwd_kassa" value="<?php echo htmlentities($row_Updatekassa['pwd_kassa'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Nama Lengkap</strong></div>
      <input type="text" name="nama_kassa" value="<?php echo htmlentities($row_Updatekassa['nama_kassa'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Alamat</strong></div>
      <textarea name="alamat_kassa" cols="50" rows="5" class="form-control"><?php echo htmlentities($row_Updatekassa['alamat_kassa'], ENT_COMPAT, 'utf-8'); ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>No. telpon</strong></div>
      <input type="text" name="telp_kassa" value="<?php echo htmlentities($row_Updatekassa['telp_kassa'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Status </strong></div>
        <select name="status_kassa" class="form-control">
          <option value="Y" <?php if (!(strcmp("Y", htmlentities($row_Updatekassa['status_kassa'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Aktif</option>
          <option value="N" <?php if (!(strcmp("N", htmlentities($row_Updatekassa['status_kassa'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Tidak Aktif</option>
        </select>      </td>
    </tr>
    <tr valign="baseline">
      <td height="50" valign="bottom"><?php btnSubmit('edit','Edit Data');?>
        <?php kembali('?page=kassa/view'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="idkassa" value="<?php echo $row_Updatekassa['id_kassa']; ?>" />
</form> 