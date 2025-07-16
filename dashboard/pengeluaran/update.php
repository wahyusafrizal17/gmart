<?php
require_once('izin.php');
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $updateSQL = sprintf(
        "UPDATE `pengeluaran` SET `tgl`=%s, `judul`=%s, `nominal`=%s,`ket`=%s, `oleh`=%s WHERE id=%s",
        GetSQLValueString($_POST['tgl'], "text"),
        GetSQLValueString($_POST['judul'], "text"),
        GetSQLValueString(str_replace(".", "", $_POST['nominal']), "double"),
        GetSQLValueString($_POST['ket'], "text"),
        GetSQLValueString($nama, "text"),
        GetSQLValueString($_POST['id'], "int")
    );

    mysql_select_db($database_koneksi, $koneksi);
    $Result1 = mysql_query($updateSQL, $koneksi) or die(errorQuery(mysql_error()));

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
        refresh('?page=pengeluaran/view&sukses');
    }
}

$colname_out  = "-1";
if (isset($_GET['id'])) {
    $colname_out  = $_GET['id'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_out = sprintf("SELECT * FROM pengeluaran WHERE id = %s", GetSQLValueString($colname_out, "int"));
$out = mysql_query($query_out, $koneksi) or die(errorQuery(mysql_error()));
$row_out = mysql_fetch_assoc($out);
$totalRows_out = mysql_num_rows($out);

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
    <input type="hidden" name="id" value="<?= $row_out['id']; ?>" />
</form>