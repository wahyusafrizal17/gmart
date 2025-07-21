<?php 
require_once('izin.php');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    
  if (!empty($_POST['pass'])) {
   // Use password_hash for PHP 8 compatibility
   $hashedPassword = password_hash($_POST['pass'], PASSWORD_DEFAULT);
   $updateSQL = sprintf("UPDATE tb_admin SET Login=%s, Password=%s, nama_admin=%s, gender_admin=%s, address_admin=%s, email_admin=%s, hp_admin=%s, key_admin=%s, active_admin=%s WHERE id_admin=%s",
                       GetSQLValueString($_POST['Login'], "text"),
                       GetSQLValueString($hashedPassword, "text"),
                       GetSQLValueString($_POST['nama_admin'], "text"),
                       GetSQLValueString($_POST['gender_admin'], "text"),
                       GetSQLValueString($_POST['address_admin'], "text"),
                       GetSQLValueString($_POST['email_admin'], "text"),
                       GetSQLValueString($_POST['hp_admin'], "text"),
                       GetSQLValueString($_POST['key_admin'], "text"),
                       GetSQLValueString($_POST['active_admin'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"));   
      
  }else{    
  $updateSQL = sprintf("UPDATE tb_admin SET Login=%s, nama_admin=%s, gender_admin=%s, address_admin=%s, email_admin=%s, hp_admin=%s, key_admin=%s, active_admin=%s WHERE id_admin=%s",
                       GetSQLValueString($_POST['Login'], "text"),
                       GetSQLValueString($_POST['nama_admin'], "text"),
                       GetSQLValueString($_POST['gender_admin'], "text"),
                       GetSQLValueString($_POST['address_admin'], "text"),
                       GetSQLValueString($_POST['email_admin'], "text"),
                       GetSQLValueString($_POST['hp_admin'], "text"),
                       GetSQLValueString($_POST['key_admin'], "text"),
                       GetSQLValueString($_POST['active_admin'], "text"),
                       GetSQLValueString($_POST['id_admin'], "int"));
  }
  $Result1 = mysqli_query($koneksi, $updateSQL) or die(errorQuery(mysqli_error($koneksi)));
  
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_update (`url`, `oleh`) VALUES (%s, %s)",
  GetSQLValueString($actual_link, "text"),
  GetSQLValueString($ID, "int"));
  $ResultSQL = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error($koneksi)));  
  //26 desember close
  
  if ($Result1) {
   refresh('?page=admin/view&sukses');
  }
}

$colname_UpdateAdmin = "-1";
if (isset($_GET['id_admin'])) {
  $colname_UpdateAdmin = $_GET['id_admin'];
}
$query_UpdateAdmin = sprintf("SELECT * FROM tb_admin WHERE id_admin = %s", GetSQLValueString($colname_UpdateAdmin, "int"));
$UpdateAdmin = mysqli_query($koneksi, $query_UpdateAdmin) or die(errorQuery(mysqli_error($koneksi)));
$row_UpdateAdmin = mysqli_fetch_assoc($UpdateAdmin);
$totalRows_UpdateAdmin = mysqli_num_rows($UpdateAdmin);
?>

<?php
	titleUpdate('UPDATE DATA JENIS PAKET','Jenis Paket'); 
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" height="541">
    <tr valign="baseline">
      <td><div align="left"><strong>USERNAME</strong></div>
      <input type="text" name="Login" value="<?php echo htmlentities($row_UpdateAdmin['Login'], ENT_COMPAT, 'utf-8'); ?>" class="form-control input-sm" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>GANTI PASSWORD *</strong><small>Kosongkan jika tidak ingin diubah</small></div>
      <input type="password" name="pass" value="" class="form-control input-sm" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>NAMA LENGKAP</strong></div>
      <input type="text" name="nama_admin" value="<?php echo htmlentities($row_UpdateAdmin['nama_admin'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>SAYA ADALAH</strong></div>
        <select name="gender_admin" class="form-control input-sm">
        <option value="L" <?php if (!(strcmp("L", htmlentities($row_UpdateAdmin['gender_admin'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Laki-laki</option>
        <option value="P" <?php if (!(strcmp("P", htmlentities($row_UpdateAdmin['gender_admin'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Perempuan</option>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>ALAMAT LENGKAP</strong></div>
      <textarea name="address_admin" cols="50" rows="5" class="form-control input-sm"><?php echo htmlentities($row_UpdateAdmin['address_admin'], ENT_COMPAT, 'utf-8'); ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>EMAIL AKTIF</strong></div>
      <input type="text" name="email_admin" value="<?php echo htmlentities($row_UpdateAdmin['email_admin'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>NO. TELPON</strong></div>
      <input type="text" name="hp_admin" value="<?php echo htmlentities($row_UpdateAdmin['hp_admin'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>KUNCI PEMULIHAN AKUN</strong></div>
      <input type="text" name="key_admin" value="<?php echo htmlentities($row_UpdateAdmin['key_admin'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>STATUS</strong></div>
        <select name="active_admin" class="form-control input-sm">
        <option value="Y" <?php if (!(strcmp("Y", htmlentities($row_UpdateAdmin['active_admin'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>AKTIF</option>
        <option value="N" <?php if (!(strcmp("N", htmlentities($row_UpdateAdmin['active_admin'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>BLOK</option>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td><?php btnSubmit('edit','Edit Data');?> <?php kembali('?page=admin/view'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_admin" value="<?php echo $row_UpdateAdmin['id_admin']; ?>" />
</form>