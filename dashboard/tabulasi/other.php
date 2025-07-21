<?php
$tgl1 = "-1";
$tgl2 = "-1";
$colname = "-1";
if (isset($_GET['kasir']) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
  $colname = $_GET['kasir'];
  $tgl1 = $_GET['tgl1'];
  $tgl2 = $_GET['tgl2'];
  if ($colname != "0") {
    $query_Terlaris = sprintf(
      "SELECT kode, nama, COUNT(kode) as Transaksi, SUM(harga * qty) as Harga, SUM(qty) as Jumlah, transaksidetail.admintd AS kasir FROM `transaksidetail` WHERE periode = %s AND transaksidetail.admintd = %s AND tanggal BETWEEN %s AND %s GROUP BY nama, tanggal ORDER BY Jumlah DESC",
      GetSQLValueString($ta, "text"),
      GetSQLValueString($colname, "text"),
      GetSQLValueString($tgl1, "date"),
      GetSQLValueString($tgl2, "date")
    );
  } else {
    $query_Terlaris = sprintf(
      "SELECT kode, nama, COUNT(kode) as Transaksi, SUM(harga * qty) as Harga, SUM(qty) as Jumlah, transaksidetail.admintd AS kasir FROM `transaksidetail` WHERE periode = %s AND tanggal BETWEEN %s AND %s GROUP BY nama, tanggal ORDER BY Jumlah DESC",
      GetSQLValueString($ta, "text"),
      GetSQLValueString($tgl1, "date"),
      GetSQLValueString($tgl2, "date")
    );
  }
} else {
  $query_Terlaris = sprintf(
    "SELECT kode, nama, COUNT(kode) as Transaksi, SUM(harga * qty) as Harga, SUM(qty) as Jumlah, transaksidetail.admintd AS kasir FROM `transaksidetail` WHERE periode = %s GROUP BY nama ORDER BY Jumlah DESC",
    GetSQLValueString($ta, "text")
  );
}
$Terlaris = mysqli_query($koneksi, $query_Terlaris) or die(mysqli_error($koneksi));
$row_Terlaris = mysqli_fetch_assoc($Terlaris);
$totalRows_Terlaris = mysqli_num_rows($Terlaris);

//DATA KASIR
$query_Kassa = sprintf(
  "SELECT DISTINCT(transaksidetail.admintd) AS kasir FROM `transaksidetail` WHERE periode = %s ORDER BY kasir ASC",
  GetSQLValueString($ta, "text")
);
$Kassa = mysqli_query($koneksi, $query_Kassa) or die(mysqli_error($koneksi));
$row_Kassa = mysqli_fetch_assoc($Kassa);
?>
<style type="text/css">
  <!--
  .style1 {
    color: #FFFFFF
  }
  -->
</style>
<div class="col-md-12">
  <?php
  title('success', 'DAFTAR PRODUK TERJUAL', 'Berikut ini adalah produk yang terjual');
  ?>
  <a href="?page=tabulasi/produk" class="btn btn-lg btn-warning btn-block"> Kembali</a>

  <div class="row">

    <form class="form-horizontal" name="periode" action="" method="get">
      <div class="box-body">
        <div class="col-md-2">
          <div class="form-group">
            <label for="tgl1" class="control-label">Tanggal Awal</label>
            <input type="text" name="tgl1" value="<?php if (isset($_GET['tgl1'])) {
                                                    echo $_GET['tgl1'];
                                                  } else {
                                                    echo  $tglsekarang;
                                                  } ?>" class="form-control" id="datepicker2" />
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="tgl2" class="control-label">Tanggal Akhir</label>
            <input type="text" name="tgl2" value="<?php if (isset($_GET['tgl2'])) {
                                                    echo $_GET['tgl2'];
                                                  } else {
                                                    echo $tglsekarang;
                                                  } ?>" class="form-control" id="datepicker3" />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="tgl2" class="control-label">Pilih Kasir</label>
            <select name="kasir" id="" class="form-control">
              <option value="0">-- Pilih Kasir --</option>
              <?php do {  ?>
                <option value="<?php echo isset($row_Kassa['kasir']) ? $row_Kassa['kasir'] : ''; ?>"><?php echo isset($row_Kassa['kasir']) ? $row_Kassa['kasir'] : ''; ?></option>
              <?php } while ($row_Kassa = mysqli_fetch_assoc($Kassa)); ?>
            </select>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <label for="kategori" class="control-label"> &nbsp;</label>
            <button type="submit" class="btn btn-block btn-info pull-right">Filter</button>
          </div>
        </div>
      </div>

      <!-- /.box-footer -->
      <input type="hidden" name="page" value="tabulasi/other" />
    </form>
  </div>
  <table width="100%" class="table table-striped">
    <thead>
      <tr bgcolor="#006699">
        <th>
          <div align="center"><span class="style1">NO</span></div>
        </th>
        <th>
          <div align="center"><span class="style1">PRODUK</span></div>
        </th>
        <th>
          <div align="center"><span class="style1">TRANSAKSI</span></div>
        </th>
        <th>
          <div align="center"><span class="style1">QTY</span></div>
        </th>
        <th>
          <div align="center"><span class="style1">TOTAL</span></div>
        </th>
        <th>
          <div align="center"><span class="style1">KASIR</span></div>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1;
      do { ?>
        <tr>
          <td>
            <div align="center"><?= $no++; ?></div>
          </td>
          <td class="text-uppercase"><?php echo isset($row_Terlaris['nama']) ? $row_Terlaris['nama'] : ''; ?> ( <?php echo isset($row_Terlaris['kode']) ? $row_Terlaris['kode'] : ''; ?> )</td>
          <td><?php echo isset($row_Terlaris['Transaksi']) ? $row_Terlaris['Transaksi'] : 0; ?> Transaksi</td>
          <td><?php echo isset($row_Terlaris['Jumlah']) ? $row_Terlaris['Jumlah'] : 0; ?> Item</td>
          <td>Rp. <?php echo isset($row_Terlaris['Harga']) ? $row_Terlaris['Harga'] : 0; ?></td>
          <td><?php echo isset($row_Terlaris['kasir']) ? $row_Terlaris['kasir'] : ''; ?></td>
        </tr>
      <?php } while ($row_Terlaris = mysqli_fetch_assoc($Terlaris)); ?>
    </tbody>
  </table>
  <hr>


</div>