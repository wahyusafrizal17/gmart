<?php
require_once 'izin.php';
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= '?' . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['MM_insert']) && $_POST['MM_insert'] == 'form1') {
    $insertSQL = sprintf('INSERT INTO tukarproduk (`produk`, `point`) VALUES (%s, %s)', GetSQLValueString($_POST['produk'], 'text'), GetSQLValueString($_POST['point'], 'text'));

    mysqli_select_db($database_koneksi, $koneksi);
    ($Result1 = mysqli_query($insertSQL, $koneksi)) or die(errorQuery(mysqli_error()));

    if ($Result1) {
        refresh('?page=tukarproduk/view&sukses');
    }
}

?>
<?php if (isset($_GET['sukses'])) {
    sukses('Data Tukar Produk berhasil tersimpan');
} ?>
<?php
titleSimpan('ENTRY DATA TUKAR PRODUK', 'produk untuk ditukar');
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table width="100%" class="table table-striped">
        <tr valign="baseline">
            <td>
                <div align="left"><strong>Produk</strong></div>
                <?php
                mysqli_select_db($database_koneksi, $koneksi);
                $cek = sprintf('SELECT * FROM produk');
                ($rs_cek = mysqli_query($cek, $koneksi)) or die(mysqli_error());
                ?>

                <select name="produk" class="form-control" id="produk">
                    <option value="">Pilih Produk</option>
                    <?php while ($data = mysqli_fetch_assoc($rs_cek)) { ?>
                    <option class="text-uppercase" value="<?php echo $data['idproduk']; ?>"><?php echo $data['namaproduk']; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr valign="baseline">
            <td>
                <div align="left"><strong>Point Penukaran</strong></div>
                <input type="text" class="form-control" name="point">
            </td>
        </tr>
        <tr valign="baseline">
            <td><?php btnSubmit('save', 'Simpan'); ?> <?php kembali('?page=tukarproduk/view'); ?></td>
        </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
</form>
<script>
    $(document).ready(function() {
    $('#produk').select2({
        theme: "bootstrap4",
        width: '100%',
    });
});
</script>