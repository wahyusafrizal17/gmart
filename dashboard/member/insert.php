<?php 
require_once('izin.php'); 
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

 
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO member (`nik`, `nama_member`, `nomor`) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['nik'], "text"),
                       GetSQLValueString($_POST['nama_member'], "text"),
					   GetSQLValueString($_POST['nomor'], "text"));

  mysqli_select_db($database_koneksi, $koneksi);
  $Result1 = mysqli_query($insertSQL, $koneksi) or die(errorQuery(mysqli_error()));
  
  if ($Result1) {
  	refresh('?page=member/view&sukses');
  }
}


?> 
<?php if (isset($_GET['sukses'])) { 
   		sukses('Data member berhasil tersimpan');
} ?>
<?php
	titleSimpan('ENTRY DATA MEMBER','member');
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%"  class="table table-striped">
    <tr valign="baseline">
      <td><div align="left"><strong>NIK</strong></div>
      <input type="text" name="nik" value="" size="32" class="form-control" id="nik" required/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Nama Member</strong></div>
          <input type="text" name="nama_member" value="" size="32" class="form-control" id="nama_kassa2" required/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>No. Telpon</strong></div>
          <input type="text" name="nomor" value="" size="32" class="form-control" id="nama_kassa4" required/></td>
    </tr>
    <tr valign="baseline">
      <td><?php btnSubmit('save','Simpan'); ?> <?php kembali('?page=member/view'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form> 