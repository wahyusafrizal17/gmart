<?php
//require_once('izin.php');
////mysqli_select_db($database_koneksi);
$query_Kategori = "SELECT namakategori, COUNT(kategori) AS QTY, kategori.*, vw_login.Nama as Nama FROM kategori 
LEFT JOIN produk ON kategori = idkategori
LEFT JOIN vw_login ON addbykategori = ID 
GROUP BY idkategori ORDER BY namakategori ASC";
$Kategori = mysqli_query($koneksi, $query_Kategori) or die(errorQuery(mysqli_error($koneksi)));
$row_Kategori = mysqli_fetch_assoc($Kategori);
$totalRows_Kategori = mysqli_num_rows($Kategori);
?>


<?php if (isset($_GET['sukses'])) {
  sukses('Data kategori berhasil tersimpan');
} ?>

<?php
titleTampil('DAFTAR KATEGORI', 'kategori');
addNew('kategori/insert', 'cog');
?>
&nbsp;<a href="?page=produk/import" class="btn btn-primary btn-sm"><span class="fa fa-download"></span> Import Produk</a>
<?php
echo "<br /><br />";
?>
<?php if ($totalRows_Kategori > 0) { ?>
  <div class="row">
    <?php $no = 0;
    do { ?>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <p><strong><a href="?page=kategori/produk&amp;kategori=<?php echo $row_Kategori['idkategori']; ?>" style="color:#FFFFFF" target="_blank"><?php echo $row_Kategori['namakategori']; ?></a> ( <?php echo $row_Kategori['QTY']; ?> )</strong></p>

            <small>
              <?php if (!empty($row_Kategori['ketkategori']))
                echo $row_Kategori['ketkategori'] . ", "; ?>
              <br>
              oleh : <?php echo $row_Kategori['Nama']; ?>
            </small>
          </div>
          <div class="row">
            <div class="col-lg-6 col-xs-12"><?php $fungsi($row_Kategori['idkategori'], 'kategori', 'kategori'); ?></div>
            <div class="col-lg-6 col-xs-12 "><a href="?page=produk/insert&cat=<?php echo $row_Kategori['idkategori']; ?>" class="btn btn-sm btn-success btn-block pull-right"><span class="fa fa-plus-circle"></span> Add </a></div>
          </div>

        </div>
      </div>

    <?php $no++;
    } while ($row_Kategori = mysqli_fetch_assoc($Kategori));
    ?>
  </div>
<?php } else {
  danger('Oops!', 'Data belum ada');
} ?>