<?php  
require_once('izin.php');
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tukarproduk SET `produk`=%s,`point`=%s WHERE `id`=%s",
					   GetSQLValueString($_POST['produk'], "text"),
					   GetSQLValueString($_POST['point'], "text"),
					   GetSQLValueString($_POST['id'], "int"));

  $Result1 = mysqli_query($koneksi, $updateSQL) or die(errorQuery(mysqli_error($koneksi)));
  
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_update (`url`, `oleh`) VALUES (%s, %s)",
  GetSQLValueString($actual_link, "text"),
  GetSQLValueString($ID, "int"));
  $ResultSQL = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error($koneksi)));	
  //26 desember close
  
  if ($Result1) {
  	refresh('?page=tukarproduk/view&sukses');
  }
}

$colname_tukarproduk  = "-1";
if (isset($_GET['id'])) {
  $colname_tukarproduk  = $_GET['id'];
}
$query_tukarproduk = sprintf("SELECT * FROM tukarproduk WHERE id = %s", GetSQLValueString($colname_tukarproduk, "int"));
$tukarproduk = mysqli_query($koneksi, $query_tukarproduk) or die(errorQuery(mysqli_error($koneksi)));
$row_tukarproduk = mysqli_fetch_assoc($tukarproduk);
$totalRows_tukarproduk = mysqli_num_rows($tukarproduk);
	
?> 

<?php
	titleUpdate('UPDATE DATA Tukar Produk','produk yang ditukar'); 
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="100%">
    <tr valign="baseline">
      <td><div align="left"><strong>Produk</strong></div>
                <?php
                $cek = sprintf('SELECT * FROM produk');
                ($rs_cek = mysqli_query($koneksi, $cek)) or die(mysqli_error($koneksi));
                ?>
          <select name="produk" class="form-control" id="">
                <option value="">Pilih Produk</option>
                    <?php while ($data = mysqli_fetch_assoc($rs_cek)) { ?>
                    <option class="text-uppercase" value="<?php echo $data['idproduk']; ?>" <?php if (!(strcmp($data['idproduk'], htmlentities($row_tukarproduk['produk'], ENT_COMPAT, 'utf-8')))) {
                                                                                echo "SELECTED";
                                                                              } ?>><?php echo $data['namaproduk']; ?></option>
                    <?php } ?>
          </select>
        </td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Point Penukaran</strong></div>
      <input type="text" name="point" value="<?php echo htmlentities($row_tukarproduk['point'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control"/></td>
    </tr>
    <tr valign="baseline">
      <td height="50" valign="bottom"><?php btnSubmit('edit','Edit Data');?>
        <?php kembali('?page=tukarproduk/view'); ?></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_tukarproduk['id']; ?>" />
</form> 