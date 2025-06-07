<?php
$colname_DetailFaktur = "-1";
if (isset($_GET['faktur'])) {
  $colname_DetailFaktur = $_GET['faktur'];
}
//mysqli_select_db($database_koneksi);
$query_DetailFaktur = sprintf("SELECT faktur, tanggal, kode, transaksidetail.nama, harga, qty, diskon, addby, stt, periode, vw_login.Nama as kassa FROM transaksidetail 
LEFT JOIN vw_login ON addby = vw_login.ID WHERE faktur = %s", GetSQLValueString($koneksi, $colname_DetailFaktur, "text"));
$DetailFaktur = mysqli_query($koneksi, $query_DetailFaktur) or die(mysqli_error());
$row_DetailFaktur = mysqli_fetch_assoc($DetailFaktur);
$totalRows_DetailFaktur = mysqli_num_rows($DetailFaktur);

//mysqli_select_db($database_koneksi);
$query_faktur = sprintf(
  "SELECT faktur.*, vw_login.Nama FROM faktur 
	LEFT JOIN vw_login ON addbyfaktur = ID
	LEFT JOIN faktur c ON faktur.printby = ID
	WHERE faktur.kodefaktur = %s",
  GetSQLValueString($koneksi, $colname_DetailFaktur, "text")
);
$faktur = mysqli_query($koneksi, $query_faktur) or die(mysqli_error());
$row_faktur = mysqli_fetch_assoc($faktur);
$totalRows_faktur = mysqli_num_rows($faktur);
?>
 

<?php if ($totalRows_faktur > 0) { ?>
  <div class="col-md-12">
    <div class="alert alert-success">
      <h4><strong>DETAIL FAKTUR : <?php echo $row_faktur['kodefaktur']; ?></strong></h4>
      <p>Tanggal : <?php Tanggal($row_faktur['tglfaktur']); ?> &nbsp;&nbsp;&nbsp; Kassa : <?php echo $row_faktur['Nama']; ?></p>
    </div>
    <p>
      <?php back(); ?>
    <div class="pull-right">
      <a href="report/kwitansi.php?id=<?php echo $row_faktur['kodefaktur']; ?>" target="_blank" class="btn btn-primary btn-sm"><span class="fa fa-print"></span> Print Struk</a>
    </div>
    <div class="clearfix"></div>
    </p>
    <div class="table-responsive">
    <table width="100%" height="127" class="table table-bordered table-striped table-hover">
      <tr>
        <th colspan="2" bgcolor="#006666">
          <div align="right" class="style1">TANGGAL
            <?php Tanggal($row_faktur['tglfaktur']); ?>
          </div>
        </th>
        <th colspan="3" rowspan="2" bgcolor="#006666">
          <div class="text-center style1" style="font-size:50px">F : <?php echo $row_faktur['kodefaktur']; ?></div>
        </th>
      </tr>
      <tr>
        <th colspan="2" bgcolor="#006666">
          <div align="right" class="style1">KASSA : <?php echo $row_faktur['Nama']; ?></div>
        </th>
      </tr>
      <tr>
        <th width="3%" bgcolor="#003366"><span class="style1">NO</span></th>
        <th width="34%" bgcolor="#003366"><span class="style1">PRODUK</span></th>
        <th width="30%" bgcolor="#003366"><span class="style1">QTY</span></th>
        <th width="20%" bgcolor="#003366"><span class="style1">SUB TOTAL</span></th>
        <th width="13%" bgcolor="#003366"><span class="style1">POTONGAN</span></th>
      </tr>
      <?php
      $total = 0;
      $no = 1;
      $disk = 0;
      do {
        $sub = $row_DetailFaktur['harga'] * $row_DetailFaktur['qty'];
        $total += $sub;
        $disk += $row_DetailFaktur['diskon'];
      ?>
        <tr>
          <td><?= $no; ?></td>
          <td class="text-uppercase"><?php echo $row_DetailFaktur['kode']; ?>- <?php echo $row_DetailFaktur['nama']; ?></td>
          <td><?php echo $row_DetailFaktur['qty']; ?> @ Rp. <?php echo number_format($row_DetailFaktur['harga']); ?></td>
          <td>
            <div align="right">Rp. <?php echo number_format($sub); ?></div>
          </td>
          <td>
            <div align="right">Rp. <?php echo number_format($row_DetailFaktur['diskon']); ?></div>
          </td>
        </tr>
      <?php
        $no++;
      } while ($row_DetailFaktur = mysqli_fetch_assoc($DetailFaktur)); ?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong> TOTAL</strong></td>
        <td>
          <div align="right">Rp. <?php echo $total; ?></div>
        </td>
        <td>
          <div align="right">Rp. <?php echo $disk; ?></div>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td bgcolor="#003366"><span class="style1"><strong>GRAND TOTAL</strong></span></td>
        <td>
          <div align="right">Rp. <?php echo $total - $disk; ?> </div>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td bgcolor="#003366"><span class="style1"><strong>UANG BAYAR (TUNAI)</strong></span></td>
        <td>
          <div align="right">Rp. <?php echo $row_faktur['totalbayar']; ?> </div>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td bgcolor="#003366"><span class="style1"><strong>UANG KEMBALIAN</strong></span></td>
        <td>
          <div align="right">Rp. <?php echo $row_faktur['kembalian']; ?></div>
        </td>
      </tr>
    </table>
    </div>
  </div>
<?php } else {
  danger('Oops!', 'Faktur tidak ditemukan. Cek <a href="?page=history/activitydel&cari=' . $_GET['faktur'] . '">di sini</a>');
}
?>
<div class="clearfix"></div>