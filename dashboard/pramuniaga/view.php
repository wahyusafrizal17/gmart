<?php
require_once('izin.php');
//mysql_select_db($database_koneksi, $koneksi);
$query_Kassa = "SELECT * FROM pramuniaga ORDER BY id_kassa ASC";
$Kassa = mysql_query($query_Kassa, $koneksi) or die(errorQuery(mysql_error()));
$row_Kassa = mysql_fetch_assoc($Kassa);
$totalRows_Kassa = mysql_num_rows($Kassa);
?>


<?php if (isset($_GET['sukses'])) { 
   		sukses('Data Kassa berhasil tersimpan');
} ?>

<?php
	titleTampil('DAFTAR PRAMUNIAGA','pramuniaga');
	addNew('pramuniaga/insert','user');
	echo "<br /><br />";
?> 
<?php if ($totalRows_Kassa > 0) { ?>

<?php $no = 0; do { ?>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h4><strong><?php echo $row_Kassa['nama_kassa']; ?></strong></h4>

              <p>   
              
              </p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <?php $fungsi($row_Kassa['id_kassa'],'pramuniaga','kassa'); ?>
          </div>
        </div>
   
<?php $no++;
	} while ($row_Kassa = mysql_fetch_assoc($Kassa)); 
?>
<?php }else{
	danger('Oops!', 'Data belum ada');
} ?>