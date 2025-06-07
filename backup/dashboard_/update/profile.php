<?php if ($level > 2) {
  pesanlink('Maaf! Ini bukan wilayah Anda.', '../keluar.php');
} ?>
<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  if (empty($_POST['Password'])) {
    $updateSQL = sprintf(
      "UPDATE tb_admin SET nama_admin=%s, gender_admin=%s, address_admin=%s, email_admin=%s, hp_admin=%s, key_admin=%s WHERE id_admin=%s",
      GetSQLValueString($_POST['nama_admin'], "text"),
      GetSQLValueString($_POST['gender_admin'], "text"),
      GetSQLValueString($_POST['address_admin'], "text"),
      GetSQLValueString($_POST['email_admin'], "text"),
      GetSQLValueString($_POST['hp_admin'], "text"),
      GetSQLValueString($_POST['key_admin'], "text"),
      GetSQLValueString($_POST['id_admin'], "int")
    );

    //mysql_select_db($database_koneksi, $koneksi);
    $Result1 = mysql_query($updateSQL, $koneksi) or die(errorQuery(mysql_error()));

    //26 Desember open
    $activitySQL = sprintf(
      "INSERT INTO activity_update (`url`, `oleh`) VALUES (%s, %s)",
      GetSQLValueString($actual_link, "text"),
      GetSQLValueString($ID, "int")
    );
    mysql_select_db($database_koneksi, $koneksi);
    $ResultSQL = mysql_query($activitySQL, $koneksi) or die(errorQuery(mysql_error()));
    //26 desember close

    sukses('Sukses! Data berhasil diupdate tanpa ganti password');
  } else {
    $updateSQL = sprintf(
      "UPDATE tb_admin SET Password=PASSWORD(%s), nama_admin=%s, gender_admin=%s, address_admin=%s, email_admin=%s, hp_admin=%s, key_admin=%s WHERE id_admin=%s",
      GetSQLValueString($_POST['Password'], "text"),
      GetSQLValueString($_POST['nama_admin'], "text"),
      GetSQLValueString($_POST['gender_admin'], "text"),
      GetSQLValueString($_POST['address_admin'], "text"),
      GetSQLValueString($_POST['email_admin'], "text"),
      GetSQLValueString($_POST['hp_admin'], "text"),
      GetSQLValueString($_POST['key_admin'], "text"),
      GetSQLValueString($_POST['id_admin'], "int")
    );

    //26 Desember open
    $activitySQL = sprintf(
      "INSERT INTO activity_update (`url`, `oleh`) VALUES (%s, %s)",
      GetSQLValueString($actual_link, "text"),
      GetSQLValueString($ID, "int")
    );
    mysql_select_db($database_koneksi, $koneksi);
    $ResultSQL = mysql_query($activitySQL, $koneksi) or die(errorQuery(mysql_error()));
    //26 desember close

    //mysql_select_db($database_koneksi, $koneksi);
    $Result1 = mysql_query($updateSQL, $koneksi) or die(errorQuery(mysql_error()));

    sukses('Sukses! Data berhasil diupdate beserta password');
  }
}

//mysql_select_db($database_koneksi, $koneksi);
$query_rs_profile = "SELECT * FROM tb_admin WHERE id_admin = '" . $ID . "'";
$rs_profile = mysql_query($query_rs_profile, $koneksi) or die(errorQuery(mysql_error()));
$row_rs_profile = mysql_fetch_assoc($rs_profile);
$totalRows_rs_profile = mysql_num_rows($rs_profile);
?>
<?php
titleUpdate('CHANGE PROFILE', 'Profile');
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" height="416" class="table table-striped">
    <tr valign="baseline">
      <td>
        <div align="left"><strong>Change Password *</strong></div>
        <input type="password" name="Password" value="" size="32" class="form-control input-sm" />
      </td>
    </tr>
    <tr valign="baseline">
      <td height="21">
        <h5>*) <em>Kosongkan jika tidak ingin ganti sandi</em></h5>
      </td>
    </tr>
    <tr valign="baseline">
      <td>
        <div align="left"><strong>Nama Lengkap</strong></div>
        <input type="text" name="nama_admin" value="<?php echo htmlentities($row_rs_profile['nama_admin'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm" required />
      </td>
    </tr>
    <tr valign="baseline">
      <td valign="baseline">
        <div align="left"><strong>Gender</strong></div>
        <table>
          <tr>
            <td><input type="radio" name="gender_admin" value="L" <?php if (!(strcmp(htmlentities($row_rs_profile['gender_admin'], ENT_COMPAT, 'utf-8'), "L"))) {
                                                                    echo "CHECKED";
                                                                  } ?> />
              Laki-laki</td>
          </tr>
          <tr>
            <td><input type="radio" name="gender_admin" value="P" <?php if (!(strcmp(htmlentities($row_rs_profile['gender_admin'], ENT_COMPAT, 'utf-8'), "P"))) {
                                                                    echo "CHECKED";
                                                                  } ?> />
              Perempuan</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr valign="baseline">
      <td>
        <div align="left"><strong>Address</strong></div>
        <input type="text" name="address_admin" value="<?php echo htmlentities($row_rs_profile['address_admin'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm" required />
      </td>
    </tr>
    <tr valign="baseline">
      <td>
        <div align="left"><strong>Email</strong></div>
        <input type="email" name="email_admin" value="<?php echo htmlentities($row_rs_profile['email_admin'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm" required />
      </td>
    </tr>
    <tr valign="baseline">
      <td>
        <div align="left"><strong>No. Kontak</strong></div>
        <input type="text" name="hp_admin" value="<?php echo htmlentities($row_rs_profile['hp_admin'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm" required />
      </td>
    </tr>
    <tr valign="baseline">
      <td>
        <div align="left"><strong>Key Lupa Password</strong></div>
        <input type="text" name="key_admin" value="<?php echo htmlentities($row_rs_profile['key_admin'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm" required />
      </td>
    </tr>
    <tr valign="baseline">
      <td height="38"><?php btnSubmit('cog', 'Simpan Perubahan'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_admin" value="<?php echo $row_rs_profile['id_admin']; ?>" />
</form>