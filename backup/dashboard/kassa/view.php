<?php
require_once('izin.php');
////mysqli_select_db($database_koneksi);
$query_Kassa = "SELECT kassa.*, vw_login.Nama FROM kassa LEFT JOIN vw_login ON addby_kassa = ID ORDER BY id_kassa ASC";
$Kassa = mysqli_query($koneksi, $query_Kassa) or die(errorQuery(mysqli_error()));
$row_Kassa = mysqli_fetch_assoc($Kassa);
$totalRows_Kassa = mysqli_num_rows($Kassa);
?>


<?php if (isset($_GET['sukses'])) {
  sukses('Data Kassa berhasil tersimpan');
} ?>

<?php
titleTampil('DAFTAR KASIR', 'kasir');
addNew('kassa/insert', 'user');
echo "<br /><br />";
?>
<div class="row">
  <?php if ($totalRows_Kassa > 0) { ?>

    <?php $no = 0;
    do { ?>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h4><strong><?php echo $row_Kassa['nama_kassa']; ?></strong></h4>

            <p>
              oleh : <?php echo $row_Kassa['Nama']; ?>
            </p>
          </div>
          <div class="icon">
            <i class="fa fa-user"></i>
          </div>
          <?php $fungsi($row_Kassa['id_kassa'], 'kassa', 'kassa'); ?>
        </div>
      </div>

    <?php $no++;
    } while ($row_Kassa = mysqli_fetch_assoc($Kassa));
    ?>
  <?php } else {
    danger('Oops!', 'Data belum ada');
  } ?>
</div>