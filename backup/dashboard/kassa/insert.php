<?php
require_once('izin.php');
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  //cek username
  $cekSQL = sprintf(
    "SELECT `Login` FROM tb_admin WHERE `Login` = %s",
    GetSQLValueString($koneksi, $_POST['user_kassa'], "text")
  );
  $Kassa = mysqli_query($koneksi, $cekSQL) or die(errorQuery(mysqli_error($koneksi)));
  $totalRows_Kassa = mysqli_num_rows($Kassa);

  if ($totalRows_Kassa == 0) {
    $insertSQL = sprintf(
      "INSERT INTO kassa (`user_kassa`, `pwd_kassa`, `nama_kassa`, `alamat_kassa`, `telp_kassa`, `added_kassa`,`addby_kassa`) VALUES (%s, PASSWORD(%s), %s, %s, %s, %s, %s)",
      GetSQLValueString($koneksi, $_POST['user_kassa'], "text"),
      GetSQLValueString($koneksi, $_POST['pwd_kassa'], "text"),
      GetSQLValueString($koneksi, $_POST['nama_kassa'], "text"),
      GetSQLValueString($koneksi, $_POST['alamat_kassa'], "text"),
      GetSQLValueString($koneksi, $_POST['telp_kassa'], "text"),
      GetSQLValueString($koneksi, time(), "int"),
      GetSQLValueString($koneksi, $ID, "int")
    );

    //mysqli_select_db($database_koneksi);
    $Result1 = mysqli_query($koneksi, $insertSQL) or die(errorQuery(mysqli_error($koneksi)));

    if ($Result1) {
      refresh('?page=kassa/view&sukses');
    }
  } else {
    danger('Oops!', 'Username telah digunakan!');
  }
}


?>
<?php if (isset($_GET['sukses'])) {
  sukses('Data kassa berhasil tersimpan');
} ?>
<?php
titleSimpan('ENTRY DATA KASIR', 'kasir');
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%" class="table table-striped">
    <tr valign="baseline">
      <td>
        <div align="left"><strong>Username</strong></div>
        <input type="text" name="user_kassa" value="" size="32" class="form-control" id="nama_kassa" required autofocus />
      </td>
    </tr>
    <tr valign="baseline">
      <td>
        <div align="left"><strong>Password</strong></div>
        <input type="password" name="pwd_kassa" value="" size="32" class="form-control" id="nama_kassa2" required />
      </td>
    </tr>
    <tr valign="baseline">
      <td>
        <div align="left"><strong>Nama Lengkap</strong></div>
        <input type="text" name="nama_kassa" value="" size="32" class="form-control" id="nama_kassa3" required />
      </td>
    </tr>
    <tr valign="baseline">
      <td>
        <div align="left"><strong>No. Telpon</strong></div>
        <input type="text" name="telp_kassa" value="" size="32" class="form-control" id="nama_kassa4" required />
      </td>
    </tr>
    <tr valign="baseline">
      <td>
        <div align="left"><strong>Alamat</strong></div>
        <textarea name="alamat_kassa" cols="50" rows="5" class="form-control" id="alamat_kassa" required></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td><?php btnSubmit('save', 'Simpan'); ?> <?php kembali('?page=kassa/view'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>