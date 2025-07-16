<?php  
require_once('izin.php');

if ((isset($_GET['id_photo'])) && ($_GET['id_photo'] != "")) {
  if ($_GET['img'] == $row_rs_profile['photo_admin']) {
  	pesanlink('Oops! Gambar masih dipakai tidak bisa dihapus','?page=insert/photo');
  }else{

  $deleteSQL = sprintf("DELETE FROM tb_photo WHERE id_photo=%s",
                       GetSQLValueString($_GET['id_photo'], "int"));

if (!empty($_GET['img']) || file_exists("photos/".$_GET['img'])) { 
     	unlink("photos/".$_GET['img']);
   } 
   
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_delete (`url`, `oleh`) VALUES (%s, %s)",
                       GetSQLValueString($actual_link, "text"),
                       GetSQLValueString($ID, "int"));
	mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($activitySQL, $koneksi) or die(errorQuery(mysql_error()));	
  //26 desember close
  //mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($deleteSQL, $koneksi) or die(errorQuery(mysql_error()));
  
  pesanlink('Photo berhasil dihapus!','?page=insert/photo');
  }
}



if ((isset($_GET['id_admin'])) && ($_GET['id_admin'] != "")) {
 
  $deleteSQL = sprintf("DELETE FROM tb_admin WHERE id_admin=%s",
                       GetSQLValueString($_GET['id_admin'], "int"));

  //mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($deleteSQL, $koneksi) or die(errorQuery(mysql_error()));
  
  pesanlink('Admin berhasil dihapus!','?page=insert/admin');
 
}
 
?> 