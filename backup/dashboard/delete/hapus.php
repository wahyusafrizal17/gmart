<?php  
require_once('izin.php');

if ((isset($_GET['id_photo'])) && ($_GET['id_photo'] != "")) {
  if ($_GET['img'] == $row_rs_profile['photo_admin']) {
  	pesanlink('Oops! Gambar masih dipakai tidak bisa dihapus','?page=insert/photo');
  }else{

  $deleteSQL = sprintf("DELETE FROM tb_photo WHERE id_photo=%s",
                       GetSQLValueString($koneksi, $_GET['id_photo'], "int"));

if (!empty($_GET['img']) || file_exists("photos/".$_GET['img'])) { 
     	unlink("photos/".$_GET['img']);
   } 
   
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
                       GetSQLValueString($koneksi, $actual_link, "text"),
                       GetSQLValueString($koneksi, $ID, "int"));
	//mysqli_select_db($database_koneksi);
  $Result1 = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error()));	
  //26 desember close
  ////mysqli_select_db($database_koneksi);
  $Result1 = mysqli_query($koneksi, $deleteSQL) or die(errorQuery(mysqli_error()));
  
  pesanlink('Photo berhasil dihapus!','?page=insert/photo');
  }
}



if ((isset($_GET['id_admin'])) && ($_GET['id_admin'] != "")) {
 
  $deleteSQL = sprintf("DELETE FROM tb_admin WHERE id_admin=%s",
                       GetSQLValueString($koneksi, $_GET['id_admin'], "int"));

  ////mysqli_select_db($database_koneksi);
  $Result1 = mysqli_query($koneksi, $deleteSQL) or die(errorQuery(mysqli_error()));
  
  pesanlink('Admin berhasil dihapus!','?page=insert/admin');
 
}
 
?> 