<?php

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $insertSQL = sprintf(
        "INSERT INTO `pengeluaran`(`tgl`, `judul`, `nominal`,`ket`, `oleh`) VALUES (%s,%s, %s, %s, %s)",
        GetSQLValueString($koneksi, $_POST['tgl'], "text"),
        GetSQLValueString($koneksi, $_POST['judul'], "text"),
        GetSQLValueString($koneksi, str_replace(".", "", $_POST['nominal']), "double"),
        GetSQLValueString($koneksi, $_POST['ket'], "text"),
        GetSQLValueString($koneksi, $nama, "text")
    );


    $Result1 = mysqli_query($koneksi, $insertSQL) or die(errorQuery(mysqli_error($koneksi)));

    if ($Result1) {
        refresh('?page=pengeluaran/view&sukses');
    }
}


?>
<?php if (isset($_GET['sukses'])) {
    sukses('Data kassa berhasil tersimpan');
} ?>
<?php
titleSimpan('PENGELUARAN', 'pengeluaran');
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table width="100%" class="table table-striped">
        <tr valign="baseline">
            <td>
                <div align="left"><strong>Hari ini </strong></div>
                <input type="date" name="tgl" value="<?= $tglsekarang; ?>" size="32" class="form-control" required />
            </td>
        </tr>
        <tr valign="baseline">
            <td>
                <div align="left"><strong>Judul</strong></div>
                <input type="text" name="judul" value="" size="32" class="form-control" required />
            </td>
        </tr>
        <tr valign="baseline">
            <td>
                <div align="left"><strong>Nominal</strong></div>
                <input type="text" min="0" name="nominal" id="tanpa-rupiah" value="" size="32" class="form-control" required />
            </td>
        </tr>
        <tr valign="baseline">
            <td>
                <div align="left"><strong>Keterangan</strong></div>
                <textarea name="ket" cols="50" rows="5" class="form-control" required></textarea>
            </td>
        </tr>
        <tr valign="baseline">
            <td><?php btnSubmit('save', 'Simpan'); ?> <a href="?page=pengeluaran/view" class="btn btn-sm btn-primary"> Lihat Pengeluaran</a></td>
        </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
</form>