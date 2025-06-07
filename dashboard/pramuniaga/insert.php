<?php 
$level = $_SESSION['MM_Level']; //8
restrict(2,$level);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

 
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pramuniaga (`user_kassa`, `pwd_kassa`, `nama_kassa`, `alamat_kassa`, `telp_kassa`, `added_kassa`,`addby_kassa`) VALUES (%s, PASSWORD(%s), %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['user_kassa'], "text"),
                       GetSQLValueString($_POST['pwd_kassa'], "text"),
					   GetSQLValueString($_POST['nama_kassa'], "text"),
					   GetSQLValueString($_POST['alamat_kassa'], "text"),
					   GetSQLValueString($_POST['telp_kassa'], "text"),
					   GetSQLValueString(time() , "int"),
					   GetSQLValueString($ID, "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(errorQuery(mysql_error()));
  
  if ($Result1) {
  	refresh('?page=pramuniaga/view&sukses');
  }
}


?> 
<?php if (isset($_GET['sukses'])) { 
   		sukses('Data pramuniaga berhasil tersimpan');
} ?>
<?php
	titleSimpan('ENTRY DATA PRAMUNIAGA','pramuniaga');
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%"  class="table table-striped">
    <tr valign="baseline">
      <td><div align="left"><strong>Username</strong></div>
      <input type="text" name="user_kassa" value="" size="32" class="form-control" id="nama_kassa" required/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Password</strong></div>
          <input type="password" name="pwd_kassa" value="" size="32" class="form-control" id="nama_kassa2" required/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Nama Lengkap</strong></div>
          <input type="text" name="nama_kassa" value="" size="32" class="form-control" id="nama_kassa3" required/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>No. Telpon</strong></div>
          <input type="text" name="telp_kassa" value="" size="32" class="form-control" id="nama_kassa4" required/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Alamat</strong></div>
      <textarea name="alamat_kassa" cols="50" rows="5" class="form-control" id="alamat_kassa" required></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td><?php btnSubmit('save','Simpan'); ?> <?php kembali('?page=pramuniaga/view'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form> 