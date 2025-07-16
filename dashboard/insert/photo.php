<?php  
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  $gambar = uploadPhoto($ID,'images_photo'); 	
  if(empty($gambar)) {
  	return false;
  }	
  //MEMASUKKAN GAMBAR
  $insertSQL = sprintf("INSERT INTO tb_photo (pemilik_photo, images_photo, cb_photo, tanggal_photo) VALUES (%s, %s,%s, %s)",
                       GetSQLValueString($ID, "int"),
					   GetSQLValueString($gambar, "text"),
					   GetSQLValueString($ID, "int"),
                       GetSQLValueString($tglsekarang, "date"));

					   
  //mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(errorQuery(mysql_error()));	
  
  //MENGUBAH PHOTO PROFILE
  $updateSQL = sprintf("UPDATE tb_admin SET photo_admin=%s WHERE id_admin=%s",
                       GetSQLValueString($gambar, "text"),
                       GetSQLValueString($ID, "int"));			   

  //mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(errorQuery(mysql_error()));
  
  sukses('Photo berhasil ditambahkan!');
}

//MENAMPILKAN JUMLAH GAMBAR PER ID 
//mysql_select_db($database_koneksi, $koneksi);
$query_rs_jumlah = "SELECT * FROM tb_photo WHERE pemilik_photo = ".$ID."";
$rs_jumlah = mysql_query($query_rs_jumlah, $koneksi) or die(errorQuery(mysql_error()));
$totalRows_rs_jumlah = mysql_num_rows($rs_jumlah);

for ($a = 1; $a <= $totalRows_rs_jumlah; $a++) {
	if ((isset($_POST["MM_update".$a])) && ($_POST["MM_update".$a] == "form".$a)) {
	  $updateSQL = sprintf("UPDATE tb_admin SET photo_admin=%s WHERE id_admin=%s",
						   GetSQLValueString($_POST['photo'.$a], "text"),
						   GetSQLValueString($_POST['id_admin'.$a], "int"));
	
	  //mysql_select_db($database_koneksi, $koneksi);
	  $Result1 = mysql_query($updateSQL, $koneksi) or die(errorQuery(mysql_error()));
	  
	  pesanlink('Photo berhasil diubah','?page=insert/photo');
	} 
}

//MENAMPILKAN JUMLAH GAMBAR PER ID 
//mysql_select_db($database_koneksi, $koneksi);
$query_rs_photos = "SELECT * FROM tb_photo WHERE pemilik_photo = ".$ID."";
$rs_photos = mysql_query($query_rs_photos, $koneksi) or die(errorQuery(mysql_error()));
$row_rs_photos = mysql_fetch_assoc($rs_photos);
$totalRows_rs_photos = mysql_num_rows($rs_photos);
?> 


<p><strong>Upload Photo</strong></p>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="272" height="88">
    <tr valign="baseline">
      <td><input name="images_photo" type="file" size="32" required /></td>
    </tr>
    <tr valign="baseline">
      <td><input type="submit" value="Simpan Photo" class="btn btn-success btn-block" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>

<?php if ($totalRows_rs_photos > 0) { // Show if recordset not empty ?>
  <p>Pilih Dari Gallery</p>
  
  <div class="timeline-body">
   
  <?php $no = 1; do { ?>  
  <div class="col-md-3">
  <form action="<?php echo $editFormAction; ?>" method="post" name="form<?= $no ?>">
  <div class="box box-default">
	  <div class="box-body">  
           <?php if (empty($row_rs_photos['images_photo']) || !file_exists("photos/".$row_rs_photos['images_photo'])) { ?>
                           <img src="photos/default.png" width="200" height="180" class="margin">
		   <?php }else{ ?>
                      	   <img src="photos/<?php echo $row_rs_photos['images_photo']; ?>" width="200" height="180" class="margin">
           <?php } ?>
           <input type="hidden" name="photo<?= $no; ?>" value="<?php echo $row_rs_photos['images_photo']; ?>" />
          
          <input type="submit" value="Jadikan Photo Profil" class="btn btn-success btn-xs btn-block" />
          <a onclick="return confirm('Yakin ingin menghapus photo ini? ');" href="?page=delete/hapus&id_photo=<?= $row_rs_photos['id_photo']; ?>&img=<?= $row_rs_photos['images_photo']; ?>" class="btn btn-danger btn-xs btn-block"><i class="fa fa-trash"></i> Hapus Photo</a>
          <input type="hidden" name="MM_update<?= $no; ?>" value="form<?= $no; ?>" />
          <input type="hidden" name="id_admin<?= $no; ?>" value="<?php echo $ID; ?>" />
		</div>
	</div>
    </form>
  </div>
    
 <?php 
  $no++;
  } while($row_rs_photos = mysql_fetch_assoc($rs_photos)); 
 ?>  
  	 
  
  
  </div>

  
  <?php }else{ // Show if recordset empty
  	danger('Oops','Belum ada gambar');
  } ?> 