<?php  

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tb_ta SET `kode_ta`=%s, `nama_ta`=%s, `ket_ta`=%s WHERE id_ta=%s",
                       GetSQLValueString($_POST['kode_ta'], "text"),
                       GetSQLValueString($_POST['nama_ta'], "text"),
                       GetSQLValueString($_POST['ket_ta'], "text"),
                       GetSQLValueString($_POST['id_ta'], "int"));

  $Result1 = mysqli_query($koneksi, $updateSQL) or die(errorQuery(mysqli_error($koneksi)));
}

$query_rs_ta = "SELECT * FROM tb_ta WHERE id_ta = 1";
$rs_ta = mysqli_query($koneksi, $query_rs_ta) or die(errorQuery(mysqli_error($koneksi)));
$row_rs_ta = mysqli_fetch_assoc($rs_ta);
$totalRows_rs_ta = mysqli_num_rows($rs_ta);
?>

<?php
	titleUpdate('CHANGE PERIODE','Periode');
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" height="207" class="table table-striped">
    <tr valign="baseline">
      <td><div align="left"><strong>Periode</strong></div>
      <input type="text" name="kode_ta" value="<?php echo htmlentities($row_rs_ta['kode_ta'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm" required/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Judul</strong></div>
      <input type="text" name="nama_ta" value="<?php echo htmlentities($row_rs_ta['nama_ta'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm" required/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Keterangan</strong></div>
      <input type="text" name="ket_ta" value="<?php echo htmlentities($row_rs_ta['ket_ta'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm" required/></td>
    </tr>
    <tr valign="baseline">
      <td height="66"><?php btnSubmit('cog','Simpan Perubahan'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_ta" value="<?php echo $row_rs_ta['id_ta']; ?>" />
</form> 