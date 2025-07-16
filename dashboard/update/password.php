<?php

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  if ($_POST['new'] != $_POST['konfirmasi']) {
    danger('Oops!', 'Oops! Password tidak sama!');
  } elseif (empty($_POST['new']) || empty($_POST['konfirmasi'])) {
    danger('Oops!', 'Oops! Field tidak boleh kosong!');
  } else {
    $updateSQL = sprintf(
      "UPDATE tb_admin SET Password=PASSWORD(%s)  WHERE id_admin=%s",
      GetSQLValueString($_POST['konfirmasi'], "text"),
      GetSQLValueString($_POST['id_admin'], "int")
    );

    //mysql_select_db($database_koneksi, $koneksi);
    $Result1 = mysql_query($updateSQL, $koneksi) or die(errorQuery(mysql_error()));
    sukses('Sukses!  Data Berhasil disimpan!');
  }
}

//mysql_select_db($database_koneksi, $koneksi);
$query_rs_profile = "SELECT * FROM tb_admin WHERE id_admin = '" . $ID . "'";
$rs_profile = mysql_query($query_rs_profile, $koneksi) or die(errorQuery(mysql_error()));
$row_rs_profile = mysql_fetch_assoc($rs_profile);
$totalRows_rs_profile = mysql_num_rows($rs_profile);
?>

<?php
titleUpdate('CHANGE PASSWORD', 'Password');
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" height="125" class="table table-striped">
    <tr valign="baseline">
      <td>
        <div align="left"><strong>New Password</strong></div>
        <input type="password" name="new" value="" size="32" class="form-control input-sm" required />
      </td>
    </tr>
    <tr valign="baseline">
      <td>
        <div align="left"><strong>Konfirmasi Password</strong></div>
        <input type="password" name="konfirmasi" value="" size="32" class="form-control input-sm" required />
      </td>
    </tr>
    <tr valign="baseline">
      <td><input type="submit" value="Simpan Perubahan" class="btn btn-warning btn-block" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_admin" value="<?php echo $row_rs_profile['id_admin']; ?>" />
</form>