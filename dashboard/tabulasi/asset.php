<?php
//penambahan tanggal 28 November 2021 11:40 WIB

$query_total = "SELECT SUM(total_produk) as total_produk, SUM(modal) as modal, SUM(laba) as laba FROM `vw_asset`";
$total = mysqli_query($koneksi, $query_total) or die(mysqli_error($koneksi));
$row_total = mysqli_fetch_assoc($total);
$totalRows_total = mysqli_num_rows($total);

$query_potongan = "SELECT SUM(potongan) as potongan FROM `vw_potongan`";
$potongan = mysqli_query($koneksi, $query_potongan) or die(mysqli_error($koneksi));
$row_potongan = mysqli_fetch_assoc($potongan);
$totalRows_potongan = mysqli_num_rows($potongan);
?>

<?php
title('success', 'TOTAL ASSET KESELURUHAN', 'Menampilkan keseluruhan total asset, modal dan laba beserta potongan dari awal sampai hari ini');
?>

<?php if ($totalRows_total > 0) { ?>
    <!-- TOTAL ASSETS -->
    <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>
                    <?php if ($row_total['total_produk'] == NULL) { ?>
                        <?php echo 0 ?>
                    <?php } else {
                        echo $row_total['total_produk'];
                    } ?>
                </h3>

                <p>TOTAL PRODUK</p>
            </div>
            <div class="icon">
                <i class="fa fa-cubes"></i>
            </div>
            <!--
            <a href="?page=tabulasi/penjualantoday" class="small-box-footer">
                Lihat Detail <i class="fa fa-arrow-circle-right"></i>
            </a> -->
        </div>
    </div>

    <!-- TOTAL MODAL -->
    <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>
                    Rp. <?php if ($row_total['modal'] == NULL) { ?>
                        <?php echo 0 ?>
                    <?php } else {
                            echo number_format($row_total['modal']);
                        } ?>
                </h3>

                <p>TOTAL MODAL</p>
            </div>
            <div class="icon">
                <i class="fa fa-cubes"></i>
            </div>
            <!--
            <a href="?page=tabulasi/penjualantoday" class="small-box-footer">
                Lihat Detail <i class="fa fa-arrow-circle-right"></i>
            </a> -->
        </div>
    </div>
    <!-- TOTAL LABA -->
    <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>Rp.
                    <?php if ($row_total['laba'] == NULL) { ?>
                        <?php echo 0 ?>
                    <?php } else {
                        echo number_format($row_total['laba']);
                    } ?>
                </h3>

                <p>TOTAL LABA</p>
            </div>
            <div class="icon">
                <i class="fa fa-cubes"></i>
            </div>
            <!--
            <a href="?page=tabulasi/penjualantoday" class="small-box-footer">
                Lihat Detail <i class="fa fa-arrow-circle-right"></i>
            </a> -->
        </div>
    </div>
    <!-- TOTAL POTONGAN -->
    <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>Rp.
                    <?php if ($row_potongan['potongan'] == NULL) { ?>
                        <?php echo 0 ?>
                    <?php } else {
                        echo number_format($row_potongan['potongan']);
                    } ?>
                </h3>

                <p>TOTAL POTONGAN</p>
            </div>
            <div class="icon">
                <i class="fa fa-cubes"></i>
            </div>
            <!-- 
            <a href="?page=tabulasi/penjualantoday" class="small-box-footer">
                Lihat Detail <i class="fa fa-arrow-circle-right"></i>
            </a> -->
        </div>
    </div>
<?php } else {
    danger('Oops!', 'Tidak ada data yang dapat ditampilkan');
}
?>
<div class="clearfix"></div>