<?php
if ((isset($_GET['id'])) && ($_GET['id'] != "")) {

    $deleteSQL = sprintf(
        "DELETE FROM pengeluaran WHERE id=%s",
        GetSQLValueString($_GET['id'], "int")
    );

    //mysqli_select_db($database_koneksi, $koneksi);
    $Result1 = mysqli_query($deleteSQL, $koneksi) or die(errorQuery(mysqli_error()));

    //26 Desember open
    $activitySQL = sprintf(
        "INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
        GetSQLValueString($actual_link, "text"),
        GetSQLValueString($ID, "int")
    );
    mysqli_select_db($database_koneksi, $koneksi);
    $Result2 = mysqli_query($activitySQL, $koneksi) or die(errorQuery(mysqli_error()));

    pesanlink('Data berhasil dihapus!', '?page=pengeluaran/view');
}
