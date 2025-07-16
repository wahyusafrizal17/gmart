<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

mysqli_select_db($koneksi, $database_koneksi);
$query_rs_valid = "SELECT * FROM `tb_import` WHERE kodeproduk NOT IN (SELECT produk.kodeproduk FROM produk WHERE produk.kodeproduk = tb_import.kodeproduk)";
$rs_valid = mysqli_query($koneksi, $query_rs_valid) or die(mysqli_error($koneksi));
$row_rs_valid = mysqli_fetch_assoc($rs_valid);
$totalRows_rs_valid = mysqli_num_rows($rs_valid);

mysqli_select_db($koneksi, $database_koneksi);
$query_rs_invalid = "SELECT * FROM `tb_import` WHERE kodeproduk IN (SELECT produk.kodeproduk FROM produk WHERE produk.kodeproduk = tb_import.kodeproduk)";
$rs_invalid = mysqli_query($koneksi, $query_rs_invalid) or die(mysqli_error($koneksi));
$row_rs_invalid = mysqli_fetch_assoc($rs_invalid);
$totalRows_rs_invalid = mysqli_num_rows($rs_invalid);

if ((isset($_POST["MM_import"])) && ($_POST["MM_import"] == "import")) {
    $start = "START TRANSACTION";
    $rs_start = mysqli_query($koneksi, $start) or die(errorQuery(mysqli_error($koneksi)));

    $insertSQL = "INSERT INTO `produk` (`kodeproduk`, `namaproduk`, `hargadasar`, `hargajual`, `satuan`, `stok`, `kategori`, `deskproduk`, `addbyproduk`,`addedproduk`,`minProduk`) VALUES ";

    foreach ($rs_valid as $data) {
        $insertSQL .= '(' . GetSQLValueString($koneksi, $data['kodeproduk'], "text") . ','
            . GetSQLValueString($koneksi, $data['namaproduk'], "text") . ','
            . GetSQLValueString($koneksi, $data['hargamodal'], "text") . ','
            . GetSQLValueString($koneksi, $data['hargajual'], "text") . ','
            . GetSQLValueString($koneksi, $data['satuan'], "text") . ','
            . GetSQLValueString($koneksi, $data['stok'], "int") . ','
            . GetSQLValueString($koneksi, $data['kategori'], "int") . ','
            . GetSQLValueString($koneksi, $data['deskripsi'], "text") . ','
            . GetSQLValueString($koneksi, $data['addby'], "text") . ','
            . GetSQLValueString($koneksi, $data['addat'], "text") . ','
            . GetSQLValueString($koneksi, $data['minstok'], "int") . '),';
    }
    $a = substr_replace($insertSQL, ";", -1);
    $Result1 = mysqli_query($koneksi, $a) or die(errorQuery(mysqli_error($koneksi)));

    if ($Result1) {
        $truncate = "TRUNCATE tb_import";
        $rs_truncate = mysqli_query($koneksi, $truncate) or die(errorQuery(mysqli_error($koneksi)));

        $commit = "COMMIT";
        $rs_commit = mysqli_query($koneksi, $commit) or die(errorQuery(mysqli_error($koneksi)));
        echo "<script>
                alert('Import Data berhasil dilakukan!');
                document.location = '?page=produk/view';
            </script>";
    }
}

?>

<h2>Data Import</h2>
<div class="row">
    <div class="col-md-8 col-sm-12 col-lg-8">
        <div class="row">
            <div class="col-md-6 ">
                <p class="callout callout-success" style="font-size: 18px;">Valid sejumlah : <?= $totalRows_rs_valid; ?> Produk</p>
            </div>
            <div class="col-md-6 ">
                <p class="callout callout-danger" style="font-size: 18px;">Invalid sejumlah : <?= $totalRows_rs_invalid; ?> Produk</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-4">
        <a href="?page=produk/import" class="btn btn-primary btn-block btn-success btn-lg">Click Here to Import Data</a>
    </div>
</div>

<?php if ($totalRows_rs_valid > 0) { ?>
    <div class="row">
        <div class="col-md-12">
            <h2>Data Tersedia <small>Siap untuk diimport</small></h2>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>NO.</th>
                            <th>KODE</th>
                            <th>NAMA PRODUK</th>
                            <th>HARGA JUAL</th>
                            <th>STOK</th>
                            <th>KATEGORI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($rs_valid as $data) { ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $data['kodeproduk']; ?></td>
                                <td><?= $data['namaproduk']; ?></td>
                                <td>Rp. <?= number_format($data['hargamodal']); ?></td>
                                <td><?= $data['stok']; ?></td>
                                <td><?= $data['kategori']; ?></td>
                            </tr>
                        <?php
                            $no++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <form action="<?= $editFormAction; ?>" method="post">
        <button type="submit" class="btn btn-primary btn-success btn-block">Import Sekarang</button>
        <input type="hidden" name="MM_import" value="import">
    </form>
<?php } ?>
<?php if ($totalRows_rs_invalid > 0) { ?>
    <div class="row">
        <div class="col-md-12">
            <h2 class="alert alert-danger">Data Tidak Valid</h2>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>NO.</th>
                            <th>KODE</th>
                            <th>NAMA PRODUK</th>
                            <th>HARGA JUAL</th>
                            <th>STOK</th>
                            <th>KATEGORI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($rs_invalid as $data) { ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $data['kodeproduk']; ?></td>
                                <td><?= $data['namaproduk']; ?></td>
                                <td>Rp. <?= number_format($data['hargamodal']); ?></td>
                                <td><?= $data['stok']; ?></td>
                                <td><?= $data['kategori']; ?></td>
                            </tr>
                        <?php
                            $no++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>