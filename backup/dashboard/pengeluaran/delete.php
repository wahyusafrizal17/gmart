<?php
if ((isset($_GET['id'])) && ($_GET['id'] != "")) {

    $deleteSQL = sprintf(
        "DELETE FROM pengeluaran WHERE id=%s",
        GetSQLValueString($koneksi, $_GET['id'], "int")
    );

    //mysql_select_db($database_koneksi, $koneksi);
    $Result1 = mysqli_query($koneksi, $deleteSQL) or die(errorQuery(mysqli_error($koneksi)));

    //26 Desember open
    $activitySQL = sprintf(
        "INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
        GetSQLValueString($koneksi, $actual_link, "text"),
        GetSQLValueString($koneksi, $ID, "int")
    );

    $Result2 = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error($koneksi)));

    pesanlink('Data berhasil dihapus!', '?page=pengeluaran/view');
}
