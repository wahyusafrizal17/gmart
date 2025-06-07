<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_Cat  = "-1";
if (isset($_GET['cat'])) {
  $colname_Cat  = $_GET['cat'];
}
//mysqli_select_db($database_koneksi);
$query_Cat = sprintf("SELECT * FROM kategori WHERE idkategori = %s", GetSQLValueString($koneksi, $colname_Cat, "int"));
$Cat = mysqli_query($koneksi, $query_Cat) or die(errorQuery(mysqli_error()));
$row_Cat = mysqli_fetch_assoc($Cat);
$totalRows_Cat = mysqli_num_rows($Cat);

if ($totalRows_Cat > 0) {

  if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

    if (str_replace(".", "", $_POST['hargajual']) > str_replace(".", "", $_POST['hargadasar'])) {

      //CEK KODE BARANG 
      //mysqli_select_db($database_koneksi);
      $sql = sprintf(
        "SELECT kodeproduk FROM produk WHERE kodeproduk = %s",
        GetSQLValueString($koneksi, $_POST['kodeproduk'], "text")
      );
      $cek = mysqli_query($koneksi, $sql) or die(mysqli_error());
      $totalRows_cek = mysqli_num_rows($cek);

      if ($totalRows_cek == 0) {
        $insertSQL = sprintf(
          "INSERT INTO `produk`(`kodeproduk`,`namaproduk`, `kategori`, `deskproduk`, `hargadasar`, `hargajual`, `satuan`, `stok`,`addedproduk`, `addbyproduk`) 
				  VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
          GetSQLValueString($koneksi, $_POST['kodeproduk'], "text"),
          GetSQLValueString($koneksi, $_POST['namaproduk'], "text"),
          GetSQLValueString($koneksi, $row_Cat['idkategori'], "int"),
          GetSQLValueString($koneksi, $_POST['deskproduk'], "text"),
          GetSQLValueString($koneksi, str_replace(".", "", $_POST['hargadasar']), "double"),
          GetSQLValueString($koneksi, str_replace(".", "", $_POST['hargajual']), "double"),
          GetSQLValueString($koneksi, $_POST['satuan'], "text"),
          GetSQLValueString($koneksi, $_POST['stok'], "int"),
          GetSQLValueString($koneksi, time(), "int"),
          GetSQLValueString($koneksi, $ID, "int")
        );

        //mysqli_select_db($database_koneksi);
        $Result1 = mysqli_query($koneksi, $insertSQL) or die(errorQuery(mysqli_error()));


        if ($Result1) {
          //refresh('?page=produk/view&sukses');
          pesanlink('Data berhasil disimpan', '?page=produk/insert&cat='.$colname_Cat);
        }
      } else {
        danger('Oops!', 'Kode produk tersebut sudah digunakan');
      } //cek
    } else {
      danger('Oops!', 'Harga Dasar Lebih besar dari Harga Jual');
    }
  }


?>
  <?php if (isset($_GET['sukses'])) {
    sukses('Data produk berhasil tersimpan');
  } ?>
  <?php
  titleSimpan('ENTRY DATA PRODUK', 'produk');
  ?>
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">

    <table width="100%" class="table table-striped">
      <tr valign="baseline">
        <td>
          <div class="row">
            <div class="col-md-9">
              <div class="callout callout-info">
                <h4>Kategori :
                  <?= $row_Cat['namakategori']; ?>
                </h4>
                <p>Produk yang akan Anda masukkan adalah kategori
                  <?= $row_Cat['namakategori']; ?>
                </p>
              </div>
            </div>
            <div class="col-md-3">
              <div align="left"><strong>Code Produk*</strong></div>
              <input type="text" name="kodeproduk" <?php
                                                    //mysqli_select_db($database_koneksi);
                                                    $cari = "SELECT MAX(kodeproduk) AS kode FROM produk";
                                                    $rs_cari = mysqli_query($koneksi, $cari) or die(mysqli_error());
                                                    $row_rs_cari = mysqli_fetch_assoc($rs_cari);
                                                    $totalRows_rs_cari = mysqli_num_rows($rs_cari);

                                                    if ($row_rs_cari['kode'] == 0) {
                                                      echo $tampilkan = 100001;
                                                    } else {
                                                      echo $tampilkan = $row_rs_cari['kode'] + 1;
                                                    }
                                                    ?> value="<?php echo $tampilkan; 
                                                              ?>" size="32" class="form-control" id="kodeproduk" required  />
            </div>
          </div> <!-- col -->
          </div><!-- row -->
        </td>
      </tr>
      <tr valign="baseline">
        <td>
          <div align="left"><strong>Nama Produk*</strong></div>
          <input type="text" name="namaproduk" value="" size="32" class="form-control" id="namaproduk" required autofocus/>
        </td>
      </tr>
      <tr valign="baseline">
        <td>
          <div align="left"><strong>Harga Dasar*</strong></div>
          <input type="text" name="hargadasar" value="" size="32" class="form-control" id="tanpa-rupiah" required />
        </td>
      </tr>
      <tr valign="baseline">
        <td>
          <div align="left"><strong>Harga Jual*</strong></div>
          <input type="text" name="hargajual" value="" size="32" class="form-control" id="tanpa-rupiah2" required />
        </td>
      </tr>
      <tr valign="baseline">
        <td>
          <div align="left"><strong>Satuan*</strong></div>
          <input type="text" name="satuan" value="PCS" size="32" class="form-control" required />
        </td>
      </tr>
      <tr valign="baseline">
        <td>
          <div align="left"><strong>Stok Awal*</strong></div>
          <input type="number" name="stok" value="" size="32" class="form-control" required />
        </td>
      </tr>
      <tr valign="baseline">
        <td>
          <div align="left"><strong>Detail Produk</strong></div>
          <textarea name="deskproduk" cols="50" rows="5" class="form-control"></textarea>
        </td>
      </tr>
      <tr valign="baseline">
        <td><?php btnSubmit('save', 'Simpan'); ?> <?php kembali('?page=produk/view'); ?></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>

<?php } else { //cat 
  back();
  echo "<br><br>";
  warning('Data kategori itu tidak tersedia');
} ?>