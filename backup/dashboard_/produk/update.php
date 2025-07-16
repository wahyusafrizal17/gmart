<?php
//require_once('izin.php'); 
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

  if (str_replace(".", "", $_POST['hargajual']) > str_replace(".", "", $_POST['hargadasar'])) {

    $updateSQL = sprintf(
      "UPDATE produk SET `namaproduk`=%s, kategori=%s, `deskproduk`=%s,`hargadasar`=%s,`hargajual`=%s,`satuan`=%s,`statusproduk`=%s,`updatedproduk`=%s WHERE `idproduk`=%s",
      GetSQLValueString($_POST['namaproduk'], "text"),
      GetSQLValueString($_POST['kategori'], "text"),
      GetSQLValueString($_POST['deskproduk'], "text"),
      GetSQLValueString(str_replace(".", "", $_POST['hargadasar']), "double"),
      GetSQLValueString(str_replace(".", "", $_POST['hargajual']), "double"),
      GetSQLValueString($_POST['satuan'], "text"),
      //GetSQLValueString($_POST['stok'], "int"), -> Melalui Add dan Less Stok saja agar terhistory
      GetSQLValueString($_POST['status'], "text"),
      GetSQLValueString(time(), "int"),
      GetSQLValueString($_POST['idproduk'], "int")
    );

    mysql_select_db($database_koneksi, $koneksi);
    $Result1 = mysql_query($updateSQL, $koneksi) or die(errorQuery(mysql_error()));

    //MENYIMPAN HISTORY PERUBAHAN PRODUK (NAMA PRODUK DAN HARGA)
    $insertSQL = sprintf(
      "INSERT INTO `harga` (`kodeproduk`,`hargajual`, `hargabaru`, `hargadasar`, `namaprodukOld`,`namaprodukBaru`, `added`,`addby`) 
				  VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
      GetSQLValueString($_POST['kodeproduk'], "text"),
      GetSQLValueString(str_replace(".", "", $_POST['hargajualOld']), "double"),
      GetSQLValueString(str_replace(".", "", $_POST['hargajual']), "double"),
      GetSQLValueString(str_replace(".", "", $_POST['hargadasar']), "double"),
      GetSQLValueString($_POST['namaprodukOld'], "text"),
      GetSQLValueString($_POST['namaproduk'], "text"),
      GetSQLValueString(time(), "int"),
      GetSQLValueString($ID, "int")
    );

    mysql_select_db($database_koneksi, $koneksi);
    $Result1 = mysql_query($insertSQL, $koneksi) or die(errorQuery(mysql_error()));

    //26 Desember open
    $activitySQL = sprintf(
      "INSERT INTO activity_update (`url`, `oleh`) VALUES (%s, %s)",
      GetSQLValueString($actual_link, "text"),
      GetSQLValueString($ID, "int")
    );
    mysql_select_db($database_koneksi, $koneksi);
    $ResultSQL = mysql_query($activitySQL, $koneksi) or die(errorQuery(mysql_error()));
    //26 desember close

    if ($Result1) {
      refresh('?page=produk/view&sukses');
    }
  } else {
    danger('Oops!', 'Harga Dasar Lebih besar dari Harga Jual');
  }
}

$colname_UpdateProduk  = "-1";
if (isset($_GET['id_produk'])) {
  $colname_UpdateProduk  = $_GET['id_produk'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_UpdateProduk = sprintf("SELECT * FROM produk WHERE idproduk = %s", GetSQLValueString($colname_UpdateProduk, "int"));
$UpdateProduk = mysql_query($query_UpdateProduk, $koneksi) or die(errorQuery(mysql_error()));
$row_UpdateProduk = mysql_fetch_assoc($UpdateProduk);
$totalRows_UpdateProduk = mysql_num_rows($UpdateProduk);

if ($totalRows_UpdateProduk > 0) {

  //mysql_select_db($database_koneksi, $koneksi);
  $query_Kategori = "SELECT kategori.*, vw_login.Nama FROM kategori LEFT JOIN vw_login ON addbykategori = ID ORDER BY idkategori ASC";
  $Kategori = mysql_query($query_Kategori, $koneksi) or die(errorQuery(mysql_error()));
  $row_Kategori = mysql_fetch_assoc($Kategori);
  $totalRows_Kategori = mysql_num_rows($Kategori);
?>

  <?php
  titleUpdate('UPDATE DATA KATEGORI', 'kategori');
  ?>
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">

    <table width="100%" class="table table-striped">
      <tr valign="baseline">
        <td>
          <div class="row">
            <div class="col-md-4">
              <div class="callout callout-info">
                <label>Pilih Kategori</label>

                <select name="kategori" class="form-control input-sm">
                  <?php do {  ?>
                    <option value="<?php echo $row_Kategori['idkategori'] ?>" <?php if (!(strcmp($row_Kategori['idkategori'], htmlentities($row_UpdateProduk['kategori'], ENT_COMPAT, 'utf-8')))) {
                                                                                echo "SELECTED";
                                                                              } ?>><?php echo $row_Kategori['namakategori'] ?></option>
                  <?php } while ($row_Kategori = mysql_fetch_assoc($Kategori)); ?>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <h4>Stok Terkini</h4>
              <p style="font-size:40px"><?php echo htmlentities($row_UpdateProduk['stok'], ENT_COMPAT, 'utf-8'); ?></p>
            </div>
            <div class="col-md-3">
              <div class="callout callout-success">
                <label>Status Produk</label>

                <select name="status" class="form-control input-sm">
                  <option value="Y" <?php if (!(strcmp('Y', htmlentities($row_UpdateProduk['statusproduk'], ENT_COMPAT, 'utf-8')))) {
                                      echo "SELECTED";
                                    } ?>>Aktif</option>
                  <option value="N" <?php if (!(strcmp('N', htmlentities($row_UpdateProduk['statusproduk'], ENT_COMPAT, 'utf-8')))) {
                                      echo "SELECTED";
                                    } ?>>Tidak Aktif</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div align="left"><strong>Code Produk*</strong></div>
              <input type="text" name="kodeproduk" value="<?php echo htmlentities($row_UpdateProduk['kodeproduk'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" id="kodeproduk" readonly />
            </div>
          </div> <!-- col -->
          </div><!-- row -->
        </td>
      </tr>
      <tr valign="baseline">
        <td>
          <div align="left"><strong>Nama Produk*</strong></div>
          <input type="text" name="namaproduk" value="<?php echo htmlentities($row_UpdateProduk['namaproduk'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control text-uppercase" id="namaproduk" required autofocus />
        </td>
      </tr>
      <tr valign="baseline">
        <td>
          <div align="left"><strong>Harga Dasar*</strong></div>
          <input type="text" name="hargadasar" value="<?php echo htmlentities($row_UpdateProduk['hargadasar'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" id="tanpa-rupiah" required />
        </td>
      </tr>
      <tr valign="baseline">
        <td>
          <div align="left"><strong>Harga Jual*</strong></div>
          <input type="text" name="hargajual" value="<?php echo htmlentities($row_UpdateProduk['hargajual'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" id="tanpa-rupiah2" required />
        </td>
      </tr>
      <tr valign="baseline">
        <td>
          <div align="left"><strong>Satuan*</strong></div>
          <input type="text" name="satuan" value="<?php echo htmlentities($row_UpdateProduk['satuan'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required />
        </td>
      </tr>

      <tr valign="baseline">
        <td>
          <div align="left"><strong>Detail Produk</strong></div>
          <textarea name="deskproduk" cols="50" rows="5" class="form-control"><?php echo htmlentities($row_UpdateProduk['deskproduk'], ENT_COMPAT, 'utf-8'); ?></textarea>
        </td>
      </tr>
      <tr valign="baseline">
        <td><?php btnSubmit('save', 'Simpan'); ?> <?php kembali('?page=produk/view'); ?></td>
      </tr>
    </table>
    <input type="hidden" name="idproduk" value="<?php echo $row_UpdateProduk['idproduk']; ?>" />
    <input type="hidden" name="hargajualOld" value="<?php echo htmlentities($row_UpdateProduk['hargajual'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required />
    <input type="hidden" name="namaprodukOld" value="<?php echo htmlentities($row_UpdateProduk['namaproduk'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required />
    <input type="hidden" name="MM_update" value="form1" />
  </form>

<?php } else { //cat 
  back();
  echo "<br><br>";
  warning('Data produk itu tidak tersedia');
} ?>