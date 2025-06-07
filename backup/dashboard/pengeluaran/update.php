<?php
require_once('izin.php');
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $updateSQL = sprintf(
        "UPDATE `pengeluaran` SET `tgl`=%s, `judul`=%s, `nominal`=%s,`ket`=%s, `oleh`=%s WHERE id=%s",
        GetSQLValueString($koneksi, $_POST['tgl'], "text"),
        GetSQLValueString($koneksi, $_POST['judul'], "text"),
        GetSQLValueString($koneksi, str_replace(".", "", $_POST['nominal']), "double"),
        GetSQLValueString($koneksi, $_POST['ket'], "text"),
        GetSQLValueString($koneksi, $nama, "text"),
        GetSQLValueString($koneksi, $_POST['id'], "int")
    );

    $Result1 = mysqli_query($koneksi, $updateSQL) or die(errorQuery(mysqli_error($koneksi)));

    //26 Desember open
    $activitySQL = sprintf(
        "INSERT INTO activity_update (`url`, `oleh`) VALUES (%s, %s)",
        GetSQLValueString($koneksi, $actual_link, "text"),
        GetSQLValueString($koneksi, $ID, "int")
    );

    $ResultSQL = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error($koneksi)));
    //26 desember close

    //26 Desember open
    $activitySQL2 = sprintf(
        "INSERT INTO pengeluaran_histori (`judulawal`, `judulbaru`, `nominalawal`, `nominalbaru`, `oleh`, `keterangan`) VALUES (%s, %s, %s, %s, %s, %s)",
        GetSQLValueString($koneksi, $_POST['judulawal'], "text"),
        GetSQLValueString($koneksi, $_POST['judul'], "text"),
        GetSQLValueString($koneksi, $_POST['nominalawal'], "text"),
        GetSQLValueString($koneksi, str_replace(".", "", $_POST['nominal']), "double"),
        GetSQLValueString($koneksi, $nama, "text"),
        GetSQLValueString($koneksi, $_POST['ket'], "text")
    );

    $ResultSQL = mysqli_query($koneksi, $activitySQL2) or die(errorQuery(mysqli_error($koneksi)));
    //26 desember close

    if ($Result1) {
        refresh('?page=pengeluaran/view&sukses');
    }
}

$colname_out  = "-1";
if (isset($_GET['id'])) {
    $colname_out  = $_GET['id'];
}

$query_out = sprintf("SELECT * FROM pengeluaran WHERE id = %s", GetSQLValueString($koneksi, $colname_out, "int"));
$out = mysqli_query($koneksi, $query_out) or die(errorQuery(mysqli_error($koneksi)));
$row_out = mysqli_fetch_assoc($out);
$totalRows_out = mysqli_num_rows($out);

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
                <input type="date" name="tgl" value="<?php echo htmlentities($row_out['tgl'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required />
            </td>
        </tr>
        <tr valign="baseline">
            <td>
                <div align="left"><strong>Judul</strong></div>
                <input type="text" name="judul" value="<?php echo htmlentities($row_out['judul'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required />
            </td>
        </tr>
        <tr valign="baseline">
            <td>
                <div align="left"><strong>Nominal</strong></div>
                <input type="text" min="0" name="nominal" id="tanpa-rupiah" value="<?php echo htmlentities($row_out['nominal'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required />
            </td>
        </tr>
        <tr valign="baseline">
            <td>
                <div align="left"><strong>Keterangan</strong></div>
                <textarea name="ket" cols="50" rows="5" class="form-control" required><?php echo htmlentities($row_out['ket'], ENT_COMPAT, 'utf-8'); ?></textarea>
            </td>
        </tr>
        <tr valign="baseline">
            <td><?php btnSubmit('save', 'Simpan'); ?> <?php kembali('?page=pengeluaran/view'); ?></td>
        </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
    <input type="hidden" name="judulawal" value="<?php echo htmlentities($row_out['judul'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required />
    <input type="hidden" name="nominalawal" value="<?php echo htmlentities($row_out['nominal'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" required />
    <input type="hidden" name="id" value="<?= $row_out['id']; ?>" />
</form>