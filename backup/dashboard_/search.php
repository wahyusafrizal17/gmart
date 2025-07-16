<?php if ($totalRows_rs_search > 0) { // Show if recordset not empty ?>
  <p><?php echo $row_rs_search['fullname_kurir']; ?> ( <?php echo $row_rs_search['Login']; ?> )</p>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rs_search == 0) {  
	danger('Oops!','Oops! Hasil tidak ditemukan!');
 } // Show if recordset empty ?>
