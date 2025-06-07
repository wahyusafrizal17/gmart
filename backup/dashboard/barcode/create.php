<?php
require_once('izin.php');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {

  //SEBELUM ITU, DICEK JIKA PRODUK YG SAMA MAKA TAMBAHKAN SAJA
  //mysqli_select_db($database_koneksi);
  $cek =  sprintf(
    "SELECT barcode, qtybarcode FROM barcode WHERE barcode = %s",
    GetSQLValueString($koneksi, $_POST['barcode'], "text")
  );
  $rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error());
  $row_rs_cek = mysqli_fetch_assoc($rs_cek);
  $totalRows_rs_cek = mysqli_num_rows($rs_cek);

  if ($totalRows_rs_cek > 0) {

    $stok = sprintf(
      "UPDATE barcode SET qtybarcode = qtybarcode + %s WHERE barcode = %s",
      GetSQLValueString($koneksi, $_POST['qty'], "text"),
      GetSQLValueString($koneksi, $row_rs_cek['barcode'], "text")
    );

    //mysqli_select_db($database_koneksi);
    $hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error());
  } else {
    $insertSQL = sprintf(
      "INSERT INTO barcode (`barcode`, `qtybarcode`, `added`, `addby`) VALUES (%s, %s, %s, %s)",
      GetSQLValueString($koneksi, $_POST['barcode'], "text"),
      GetSQLValueString($koneksi, $_POST['qty'], "int"),
      GetSQLValueString($koneksi, time(), "text"),
      GetSQLValueString($koneksi, $ID, "text")
    );

    //mysqli_select_db($database_koneksi);
    $Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error());
  }
}

$colname_search = "--1";
if (isset($_POST['search'])) {
  $colname_search = $_POST['search'];
}
//mysqli_select_db($database_koneksi);
$query_search = sprintf("SELECT * FROM produk WHERE kodeproduk = %s OR namaproduk LIKE %s", GetSQLValueString($koneksi, $colname_search, "text"), GetSQLValueString($koneksi, "%" . $colname_search . "%", "text"));
$search = mysqli_query($koneksi, $query_search) or die(mysqli_error());
$row_search = mysqli_fetch_assoc($search);
$totalRows_search = mysqli_num_rows($search);

//mysqli_select_db($database_koneksi);
$query_barcode = "SELECT barcode.*, namaproduk, stok FROM barcode LEFT JOIN produk ON kodeproduk = barcode ORDER BY id_barcode DESC";
$barcode = mysqli_query($koneksi, $query_barcode) or die(mysqli_error());
$row_barcode = mysqli_fetch_assoc($barcode);
$totalRows_barcode = mysqli_num_rows($barcode);

//MENGUBAH NILAI QTY PADA BARCODE
for ($i = 1; $i <= $totalRows_barcode; $i++) {
  if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form" . $i)) {
    $stok = sprintf(
      "UPDATE barcode SET qtybarcode = %s WHERE barcode = %s",
      GetSQLValueString($koneksi, $_POST['qtyupdate' . $i], "int"),
      GetSQLValueString($koneksi, $_POST['kode' . $i], "text")
    );

    //mysqli_select_db($database_koneksi);
    $hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error());
  }
}

//untuk reload update barang	
//mysqli_select_db($database_koneksi);
$query_barcode = "SELECT barcode.*, namaproduk, stok FROM barcode LEFT JOIN produk ON kodeproduk = barcode ORDER BY id_barcode DESC";
$barcode = mysqli_query($koneksi, $query_barcode) or die(mysqli_error());
$row_barcode = mysqli_fetch_assoc($barcode);
$totalRows_barcode = mysqli_num_rows($barcode);

?>
<div class="row">
  <div class="col-md-4">
    <div class="callout callout-success">
      <form id="form1" name="form1" method="post" action="">



        <label>Cari Produk</label>
        <div class="input-group margin">

          <input type="text" name="search" placeholder="Masukkan Kode / Nama Produk" class="form-control">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-info btn-flat">Search</button>
          </span>
        </div>


      </form>
    </div>

    <?php if ($totalRows_search > 0) { ?>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" height="168" class="table table-striped table-condensed">
          <tr valign="baseline">
            <td width="8%" align="right" valign="top" nowrap="nowrap"><strong>Barcode</strong></td>
            <td width="1%" align="right" nowrap="nowrap">&nbsp;</td>
            <td width="91%"><?php echo $row_search['kodeproduk']; ?></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="top" nowrap="nowrap"><strong>Nama Produk</strong></td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><?php echo $row_search['namaproduk']; ?></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="top" nowrap="nowrap"><strong>Stok Terkini</strong></td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><?php echo $row_search['stok']; ?></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="top" nowrap="nowrap"><strong>Jumlah</strong></td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="number" name="qty" value="<?php echo $row_search['stok']; ?>" size="32" class="form-control" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="top" nowrap="nowrap">&nbsp;</td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Add to list" class="btn btn-lg btn-warning btn-block" /></td>
          </tr>
        </table>
        <input type="hidden" name="produkID" value="<?php echo $row_search['idproduk']; ?>" />
        <input type="hidden" name="barcode" value="<?php echo $row_search['kodeproduk']; ?>" />
        <input type="hidden" name="oldstok" value="<?php echo $row_search['stok']; ?>" />

        <input type="hidden" name="namaproduk" value="<?php echo $row_search['namaproduk']; ?>" />
        <input type="hidden" name="MM_insert" value="form2" />
      </form>
    <?php } else {
      danger('Oops!', 'Kami tidak menemukan kata kunci tersebut');
    }
    ?>
  </div> <!-- col -->
  <div class="col-md-8">
    <?php title('success', 'DAFTAR BARCODE', 'Berikut ini adalah list barcode yang akan dicetak'); ?>
    <?php if ($totalRows_barcode > 0) { ?>
      <div class="table-responsive">
        <table width="100%" class="table table-sm table-striped table-hover">
          <thead>
            <tr>
              <th>
                <div align="center">NO.</div>
              </th>
              <th>
                <div align="center">BARCODE.</div>
              </th>
              <th>
                <div align="center">QTY</div>
              </th>
              <th>
                <div align="center">PRINT</div>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            do { ?>
              <tr>
                <td align="center" valign="middle"><?php echo $no; ?></td>
                <td><?php echo $row_barcode['barcode'] . " - " . $row_barcode['namaproduk']; ?></td>
                <td>
                  <form name="form<?= $no; ?>" method="post" action="">
                    <select name="qtyupdate<?= $no; ?>" class="form-control" onchange="this.form.submit()">
                      <?php
                      for ($j = 1; $j <= $row_barcode['qtybarcode']; $j++) {
                        if ($j == $row_barcode['qtybarcode']) {
                          echo "<option selected>$j</option>";
                        } else {
                          echo "<option>$j</option>";
                        }
                      }
                      ?>
                    </select>
                    <input type="hidden" name="MM_update" value="form<?= $no; ?>" />
                    <input type="hidden" name="kode<?= $no; ?>" value="<?= $row_barcode['barcode']; ?>" />
                  </form>
                </td>
                <td><a href="print/barcode.php?barcode=<?= $row_barcode['barcode']; ?>&harga" target="_blank" class="btn btn-sm btn-success"><span class="fa fa-close"></span> Harga</a> <a href="print/barcode.php?barcode=<?= $row_barcode['barcode']; ?>&label" target="_blank" class="btn btn-sm btn-warning"><span class="fa fa-close"></span> Label</a> <a href="print/barcode.php?barcode=<?= $row_barcode['barcode']; ?>" target="_blank" class="btn btn-sm btn-primary"><span class="fa fa-print"></span> Lengkap</a>
                  <a href="print/barcode-codeshop.php?barcode=<?= $row_barcode['barcode']; ?>" target="_blank" class="btn btn-sm btn-default"><span class="fa fa-print"></span> Codeshop 58mm</a>
                  <a href="print/harga.php?barcode=<?= $row_barcode['barcode']; ?>" target="_blank" class="btn btn-sm btn-primary"><span class="fa fa-check"></span> Harga</a>
                  <a href="?page=barcode/delete&id_barcode=<?= $row_barcode['id_barcode']; ?>" class="btn btn-sm btn-danger pull-right"><span class="fa fa-close"></span></a>

                </td>

              </tr>
            <?php
              $no++;
            } while ($row_barcode = mysqli_fetch_assoc($barcode)); ?>
          </tbody>
        </table>
      </div>
      <button class="btn btn-primary btn-block" onclick="window.open('print/barcode-all.php');">Cetak Semua List</button>
    <?php } else {
      danger('Oops!', 'barcode belum ada');
    }
    ?>

  </div>
</div><!-- row -->
<hr>
<div class="clearfix"></div>