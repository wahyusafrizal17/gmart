<?php require_once('page1.php'); ?>
<style type="text/css">
    .style1 {
        color: #FFFFFF
    }
</style>

<div class="box box-default color-palette-box">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> LIST PENGELUARAN</h3>
        <div class="pull-right">
            <a href="?page=pengeluaran/add">Add New</a>
        </div>
    </div>
    <div class="box-body">

        <div class="row">

            <div class="col-md-4">
                <div class="callout callout-success">
                    <form id="form1" name="form1" method="get" action="">
                        <label>Cari Judul</label>
                        <div class="input-group margin">

                            <input type="text" name="cari" placeholder="Cari Judul" class="form-control" required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info btn-flat">Search</button>
                            </span>
                        </div>
                        <input type="hidden" name="page" value="pengeluaran/view" />
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <label>Cari berdasarkan tanggal </label>
                <form class="form-horizontal" name="periode" action="" method="get">
                    <div class="box-body">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tgl1" class="control-label">Tanggal Awal</label>
                                <input type="text" name="tgl1" value="<?= $tglsekarang; ?>" class="form-control" id="datepicker2" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tgl2" class="control-label">Tanggal Akhir</label>
                                <input type="text" name="tgl2" value="<?= $tglsekarang; ?>" class="form-control" id="datepicker3" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kategori" class="control-label"> &nbsp;</label>
                                <button type="submit" class="btn btn-block btn-info pull-right">Filter</button>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-footer -->
                    <input type="hidden" name="page" value="pengeluaran/view" />
                </form>
            </div>
        </div>
        <br />
        <?php if ($totalRows_Penjualan > 0) { ?>
            <div class="row">
                <div class="col-md-12">
                    <?php if (isset($_GET['tgl1']) && isset($_GET['tgl2'])) { ?>
                        <?php title('success', 'HASIL PENCARIAN DITEMUKAN', 'Pada tanggal ' . $_GET['tgl1'] . ' s/d tanggal ' . $_GET['tgl2'] . ' ditemukan sebanyak ' . $totalRows_Penjualan . ' transaksi'); ?>
                    <?php } ?>
                    <div class="table-responsive">
                        <div class="pull-right">
                            Total keseluruhan : Rp. <?= number_format($row_Total['jumlah']); ?>
                        </div>
                        <table width="100%" class="table table-striped table-bordered">
                            <tr>
                                <th width="3%" bgcolor="#006699">
                                    <div align="center" class="style1">NO.</div>
                                </th>
                                <th width="10%" bgcolor="#006699">
                                    <div align="center" class="style1">TANGGAL</div>
                                </th>
                                <th width="19%" bgcolor="#006699">
                                    <div align="center" class="style1">JUDUL</div>
                                </th>
                                <th width="15%" bgcolor="#006699">
                                    <div align="center" class="style1">NOMINAL</div>
                                </th>
                                <th width="15%" bgcolor="#006699">
                                    <div align="center" class="style1">KETERANGAN</div>
                                </th>
                                <th width="16%" bgcolor="#006699">
                                    <div align="center" class="style1">KASSA</div>
                                </th>
                                <th width="10%" bgcolor="#006699">
                                    <div align="center" class="style1">AKSI</div>
                                </th>
                            </tr>
                            <?php
                            $total = 0;
                            $no = 1;
                            do {

                            ?>
                                <tr>
                                    <td>
                                        <div align="center"><?= $no; ?></div>
                                    </td>


                                    <td>
                                        <div align="right"><?php echo Tanggal($row_Penjualan['tgl']); ?><br><?php echo $row_Penjualan['createdat']; ?></div>
                                    </td>
                                    <td>
                                        <div align="left"><strong><?php echo  $row_Penjualan['judul']; ?></strong>
                                            <br />
                                        </div>
                                    </td>
                                    <td>
                                        <div align="right">Rp. <?php echo number_format($row_Penjualan['nominal']); ?></div>
                                    </td>
                                    <td>
                                        <div align="right"><?php echo $row_Penjualan['ket']; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $row_Penjualan['oleh']; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><a href="?page=pengeluaran/update&id=<?= $row_Penjualan['id']; ?>">Edit</a>
                                            <!-- | <a href="?page=pengeluaran/delete&id=<?= $row_Penjualan['id']; ?>" onclick="return confirm('Anda yakin ingin menghapus transaksi <?php echo  $row_Penjualan['judul']; ?> ini? ')">Hapus</a> </div> -->
                                    </td>
                                </tr>
                            <?php
                                $no++;
                            } while ($row_Penjualan = mysqli_fetch_assoc($rs_Penjualan)); ?>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        <?php } else {
            danger('Oops!', 'Transaksi tidak ditemukan.');
            echo "<br><p><a href='?page=pengeluaran/view' class='btn btn-warning'>Back</a></p>";
        } ?>
    </div>
    <!-- /.box-body -->

</div>
<?php require_once('page2.php'); ?>