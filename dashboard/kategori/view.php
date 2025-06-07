<?php
//require_once('izin.php');
//mysql_select_db($database_koneksi, $koneksi);
$query_Kategori = "SELECT namakategori, COUNT(kategori) AS QTY, kategori.*, vw_login.Nama as Nama FROM kategori 
LEFT JOIN produk ON kategori = idkategori
LEFT JOIN vw_login ON addbykategori = ID 
GROUP BY idkategori ORDER BY namakategori ASC";
$Kategori = mysql_query($query_Kategori, $koneksi) or die(errorQuery(mysql_error()));
$row_Kategori = mysql_fetch_assoc($Kategori);
$totalRows_Kategori = mysql_num_rows($Kategori);
?>


<?php if (isset($_GET['sukses'])) { 
   		sukses('Data kategori berhasil tersimpan');
} ?>

<?php
	titleTampil('DAFTAR KATEGORI','kategori');
	addNew('kategori/insert','cog');
	echo "<br /><br />";
?> 
<?php if ($totalRows_Kategori > 0) { ?>

<?php $no = 0; do { ?>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h4><strong><a href="?page=kategori/produk&amp;kategori=<?php echo $row_Kategori['idkategori']; ?>" style="color:#FFFFFF" target="_blank"><?php echo $row_Kategori['namakategori']; ?></a> ( <?php echo $row_Kategori['QTY']; ?> )</strong></h4>

              <p>
			  <?php if (!empty($row_Kategori['ketkategori']))
              echo $row_Kategori['ketkategori'] . ", "; ?>
              oleh : <?php echo $row_Kategori['Nama']; ?>
              </p>
            </div>
            <div class="icon">
              <i class="fa fa-cube"></i>
            </div>
            <?php $fungsi($row_Kategori['idkategori'],'kategori','kategori'); ?> <a href="?page=produk/insert&cat=<?php echo $row_Kategori['idkategori']; ?>" class="btn btn-sm btn-success"><span class="fa fa-plus-circle"></span> Add Product</a>
          </div>
        </div>
   
<?php $no++;
	} while ($row_Kategori = mysql_fetch_assoc($Kategori)); 
?>
<?php }else{
	danger('Oops!', 'Data belum ada');
} ?>