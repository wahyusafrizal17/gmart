<?php  
if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM transaksitemp WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  // Correct parameter order: (mysqli, dbname)
  mysqli_select_db($koneksi, $database_koneksi);
  // Correct parameter order: (mysqli, query)
  $Result1 = mysqli_query($koneksi, $deleteSQL) or die(mysqli_error($koneksi));
  
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
                       GetSQLValueString($actual_link, "text"),
                       GetSQLValueString($ID, "int"));
  mysqli_select_db($koneksi, $database_koneksi);
  $ResultSQL = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error($koneksi))); 
  //26 desember close

  if ($Result1) {
    refresh('?page=scan/add');
  }
}
?>