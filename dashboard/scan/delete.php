<?php  
if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  // Ambil kode faktur dari item sebelum dihapus
  mysqli_select_db($koneksi, $database_koneksi);
  $q_get_faktur = sprintf("SELECT faktur FROM transaksitemp WHERE id=%s",
                         GetSQLValueString($_GET['id'], "int"));
  $rs_get_faktur = mysqli_query($koneksi, $q_get_faktur) or die(mysqli_error($koneksi));
  $row_get_faktur = mysqli_fetch_assoc($rs_get_faktur);
  $faktur_of_item = $row_get_faktur ? $row_get_faktur['faktur'] : '';

  $deleteSQL = sprintf("DELETE FROM transaksitemp WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  // Correct parameter order: (mysqli, dbname)
  mysqli_select_db($koneksi, $database_koneksi);
  // Correct parameter order: (mysqli, query)
  $Result1 = mysqli_query($koneksi, $deleteSQL) or die(mysqli_error($koneksi));
  
  // Jika sukses hapus item, cek apakah masih ada item pada faktur tsb
  if ($Result1 && !empty($faktur_of_item)) {
    $q_count = sprintf("SELECT COUNT(*) AS c FROM transaksitemp WHERE faktur=%s",
                       GetSQLValueString($faktur_of_item, "text"));
    $rs_count = mysqli_query($koneksi, $q_count) or die(mysqli_error($koneksi));
    $row_count = mysqli_fetch_assoc($rs_count);
    if ((int)$row_count['c'] === 0) {
      // Hapus faktur terbuka (status N) bila keranjang kosong
      $del_faktur = sprintf("DELETE FROM faktur WHERE kodefaktur=%s AND statusfaktur=%s",
                            GetSQLValueString($faktur_of_item, "text"),
                            GetSQLValueString('N', "text"));
      mysqli_query($koneksi, $del_faktur) or die(mysqli_error($koneksi));
    }
  }
  
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