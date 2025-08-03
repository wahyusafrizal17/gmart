<?php require_once('tabulasi/today1.php'); ?>


<div class="box box-default color-palette-box">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> LIST PENJUALAN HARI INI</h3>
  </div>
  <div class="box-body">

    <div class="row">

      <div class="col-md-4">
        <div class="callout callout-success">
          <form id="form1" name="form1" method="get" action="">
            <label>Scan Barcode Here</label>
            <div class="input-group margin">

              <input type="text" name="cari" placeholder="Cari No. Faktur" class="form-control" required>
              <span class="input-group-btn">
                <button type="submit" class="btn btn-info btn-flat">Search</button>
              </span>
            </div>
            <input type="hidden" name="page" value="tabulasi/penjualan" />
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
          <input type="hidden" name="page" value="tabulasi/penjualan" />
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
            <table width="100%" class="table table-striped">
              <tr>
                <th width="3%" bgcolor="#006699">
                  <div align="center" class="text-white">NO.</div>
                </th>
                <th width="14%" bgcolor="#006699">
                  <div align="center" class="text-white">FAKTUR</div>
                </th>
                <th width="14%" bgcolor="#006699">
                  <div align="center" class="text-white">JUMLAH ITEM</div>
                </th>
                <th width="14%" bgcolor="#006699">
                  <div align="center" class="text-white">TOTAL BELANJA</div>
                </th>
                <th width="23%" bgcolor="#006699">
                  <div align="center" class="text-white">TANGGAL</div>
                </th>
                <th width="11%" bgcolor="#006699">
                  <div align="center" class="text-white">KASSA</div>
                </th>
                <th width="21%" bgcolor="#006699">
                  <div align="center" class="text-white">STATUS</div>
                </th>
              </tr>
              <?php
              $total = 0;
              $no = 1;
              do {
                $total += $row_Penjualan['totalbelanja'];
              ?>
                <tr>
                  <td>
                    <div align="center"><?= $no; ?></div>
                  </td>
                  <td>
                    <div align="center"><?php echo $row_Penjualan['kodefaktur']; ?></div>
                  </td>
                  <td>
                    <div align="center"><?php echo $row_Penjualan['JumlahItem']; ?></div>
                  </td>
                  <td>
                    <div align="right">Rp. <?php echo number_format($row_Penjualan['totalbelanja']); ?></div>
                  </td>
                  <td>
                    <div align="center">
                      <?php Tanggal($row_Penjualan['tglfaktur']); ?>
                    </div>
                  </td>
                  <td>
                    <div align="center"><?php echo $row_Penjualan['Nama']; ?></div>
                  </td>
                  <td>
                    <a href="?page=tabulasi/detail&faktur=<?php echo $row_Penjualan['kodefaktur']; ?>" class="btn btn-primary"><span class="fa fa-list"></span> Lihat Detail</a>

                    <?php
                    if ($row_Penjualan['statusfaktur'] == 'Y') {
                      echo "<div class='btn btn-success'><span class='fa fa-check'></span></div>";
                    } else {
                      echo "<div class='btn btn-danger'><span class='fa fa-close'></span></div>";
                    } ?>
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
      danger('Oops!', 'Transaksi tidak ditemukan');
      echo "<br><p><a href='?page=tabulasi/penjualan' class='btn btn-warning'>Back</a></p>";
    } ?>
  </div>
  <!-- /.box-body -->

</div>
<?php require_once('tabulasi/today2.php'); ?>