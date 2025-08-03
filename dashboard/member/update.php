<?php  
require_once('izin.php');
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE member SET `nik`=%s,`nama_member`=%s,`nomor`=%s WHERE `id_member`=%s",
             GetSQLValueString($_POST['nik'], "text"),
					   GetSQLValueString($_POST['nama_member'], "text"),
					   GetSQLValueString($_POST['nomor'], "text"),
					   GetSQLValueString($_POST['idmember'], "int"));

  mysqli_select_db($database_koneksi, $koneksi);
  $Result1 = mysqli_query($updateSQL, $koneksi) or die(errorQuery(mysqli_error()));
  
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_update (`url`, `oleh`) VALUES (%s, %s)",
  GetSQLValueString($actual_link, "text"),
  GetSQLValueString($ID, "int"));
  mysqli_select_db($database_koneksi, $koneksi);
  $ResultSQL = mysqli_query($activitySQL, $koneksi) or die(errorQuery(mysqli_error()));	
  //26 desember close
  
  if ($Result1) {
  	refresh('?page=member/view&sukses');
  }
}

$colname_Updatemember  = "-1";
if (isset($_GET['id_member'])) {
  $colname_Updatemember  = $_GET['id_member'];
}
mysqli_select_db($database_koneksi, $koneksi);
$query_Updatemember = sprintf("SELECT * FROM member WHERE id_member = %s", GetSQLValueString($colname_Updatemember, "int"));
$Updatemember = mysqli_query($query_Updatemember, $koneksi) or die(errorQuery(mysqli_error()));
$row_Updatemember = mysqli_fetch_assoc($Updatemember);
$totalRows_Updatemember = mysqli_num_rows($Updatemember);
	
?> 

<?php
	titleUpdate('UPDATE DATA member','member'); 
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%">
    <tr valign="baseline">
      <td><div align="left"><strong>NIK</strong></div>
          <input name="nik" type="text" class="form-control" id="nik" value="<?php echo htmlentities($row_Updatemember['nik'], ENT_COMPAT, 'utf-8'); ?>" size="32"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Nama Member</strong></div>
      <input type="text" name="nama_member" value="<?php echo htmlentities($row_Updatemember['nama_member'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Nomor Telp</strong></div>
      <input type="text" name="nomor" value="<?php echo htmlentities($row_Updatemember['nomor'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control"/></td>
    </tr>
    <tr valign="baseline">
      <td height="50" valign="bottom"><?php btnSubmit('edit','Edit Data');?>
        <?php kembali('?page=member/view'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="idmember" value="<?php echo $row_Updatemember['id_member']; ?>" />
</form> 