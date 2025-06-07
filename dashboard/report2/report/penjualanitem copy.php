<?php require_once('../require/lap_header.php');

$colname = "-1";
$tgl1 = "-1";
$tgl2 = "-1";
if (isset($_GET['kasir']) && ($_GET['kasir'] != 0) && isset($_GET['tgl1']) && isset($_GET['tgl2'])) {
  $colname = $_GET['kasir'];
  $tgl1 = $_GET['tgl1'];
  $tgl2 = $_GET['tgl2'];
  //mysql_select_db($database_koneksi, $koneksi);
  $query_Penjualan = sprintf(
    "SELECT `idfaktur`, `tglfaktur`, `kodefaktur`, `addedfaktur`, `addbyfaktur`, `periode`, `datetimefaktur`, `kembalian`, `potongan`, `totalbayar`, (totalbayar - kembalian) AS `totalbelanja`, `statusfaktur`, `qtyprint`, `printby`, `adminfaktur`,`namapelanggan`,`nohp` FROM faktur
		WHERE statusfaktur = 'Y' AND addbyfaktur = %s AND (tglfaktur BETWEEN %s AND %s) AND faktur.periode = %s GROUP BY kodefaktur ORDER BY idfaktur DESC",
    GetSQLValueString($colname, "text"),
    GetSQLValueString($tgl1, "date"),
    GetSQLValueString($tgl2, "date"),
    GetSQLValueString($ta, "text")
  );

  $rs_Penjualan = mysql_query($query_Penjualan, $koneksi) or die(errorQuery(mysql_error()));
  $row_Penjualan = mysql_fetch_assoc($rs_Penjualan);
  $totalRows_Penjualan  = mysql_num_rows($rs_Penjualan);
}
?>


<?php if ($totalRows_Penjualan > 0) { ?>
  <?php if (isset($_GET['tgl1']) && isset($_GET['tgl2']) && isset($_GET['kasir'])) { ?>
    <h3>LAPORAN PENJUALAN BERDASARKAN TANGGAL</h3>
    <p>Berikut ini adalah data penjualan berdasarkan tanggal <?= $_GET['tgl1']; ?> s/d tanggal <?= $_GET['tgl2']; ?> ditemukan sebanyak <?= $totalRows_Penjualan; ?> transaksi.
    <?php } ?>
    <style type="text/css">
      .tableku tr,
      .tableku td {
        border: 2px solid #000;
        padding-left: 5px;
        padding-right: 5px;
      }

      .tableku th {
        color: #fff;
        text-align: center;
      }

      .table-h {
        border-bottom: 2px solid #000;
      }
    </style>

    <table width="100%" class="table-h">
      <tr>
        <th width="3%">
          <div align="center" bgcolor="#003366">NO.</div>
        </th>
        <th width="9%">
          <div align="center" bgcolor="#003366">FAKTUR</div>
        </th>
        <th width="19%">
          <div align="center" bgcolor="#003366">TANGGAL / WAKTU</div>
        </th>
        <th width="15%">
          <div align="center" bgcolor="#003366">TOTAL BELANJA</div>
        </th>
        <th width="15%">
          <div align="center" bgcolor="#003366">POTONGAN</div>
        </th>
        <th width="15%">
          <div align="center" bgcolor="#003366">LABA</div>
        </th>
        <th width="16%">
          <div align="center" bgcolor="#003366">KASSA</div>
        </th>
      </tr>
      <?php
      $totalbelanja = 0;
      $totalpotongan = 0;
      $nomor = 1;
      $totalLaba = 0;
      do {

        $totalbelanja += $row_Penjualan['totalbelanja'];
        $totalpotongan += $row_Penjualan['potongan'];

        //QUERY DETAIL
        mysql_select_db($database_koneksi, $koneksi);
        $query_DetailFaktur = sprintf("SELECT faktur, tanggal, kode, transaksidetail.nama, harga, qty, diskon, addby, stt, periode, vw_login.Nama as kassa FROM transaksidetail 
				LEFT JOIN vw_login ON addby = vw_login.ID WHERE faktur = %s", GetSQLValueString($row_Penjualan['kodefaktur'], "text"));
        $DetailFaktur = mysql_query($query_DetailFaktur, $koneksi) or die(mysql_error());
        $row_DetailFaktur = mysql_fetch_assoc($DetailFaktur);
        $totalRows_DetailFaktur = mysql_num_rows($DetailFaktur);

        //hitung laba
        $query_laba = sprintf("SELECT faktur, tanggal, hargadasar, harga, diskon, qty, (hargadasar * qty) as hd, (harga * qty) as hj, SUM((((harga * qty) - (hargadasar * qty)))-diskon) as laba, ((harga * qty) - diskon) as sisadiskon FROM `transaksidetail` WHERE faktur = %s GROUP BY faktur",  GetSQLValueString($row_Penjualan['kodefaktur'], "text"));

        $laba = mysql_query($query_laba, $koneksi) or die(mysql_error());
        $row_laba = mysql_fetch_assoc($laba);

        $tlaba = $row_laba['laba'];
        $totalLaba += $tlaba;
        //---------
      ?>

        <tr>
          <td>
            <div align="center"><?= $nomor; ?></div>
          </td>
          <td>
            <div align="left"><strong><?php echo $fakt = $row_Penjualan['kodefaktur']; ?></strong>
              <br />
            </div>
          </td>
          <td><?php echo $row_Penjualan['datetimefaktur']; ?> </td>
          <td>
            <div align="right">Rp. <?php echo number_format($row_Penjualan['totalbelanja']); ?></div>
          </td>
          <td>
            <div align="right">Rp. <?php echo number_format($row_Penjualan['potongan']); ?></div>
          </td>
          <td>
            <div align="right">Rp. <?php

                                    echo number_format($tlaba); ?></div>
          </td>
          <td>
            <div align="center"><?php echo $row_Penjualan['adminfaktur']; ?></div>
          </td>
        </tr>

        <tr>
          <td>&nbsp;</td>
          <td align="center" valign="middle">
            <div align="center">
              <?php if ($row_Penjualan['statusfaktur'] == 'Y') { ?>
                <span class="fa fa-check"></span>
              <?php } else { ?>
                <span class="fa fa-close"></span>
              <?php } ?>
            </div>
          </td>
          <td colspan="5">
            <table width="100%" class="tableku">
              <tr>
                <th width="3%" bgcolor="#003366"><span>NO</span></th>
                <th width="34%" bgcolor="#003366"><span>PRODUK</span></th>
                <th width="30%" bgcolor="#003366"><span>QTY</span></th>
                <th width="20%" bgcolor="#003366"><span>SUB TOTAL</span></th>
                <th width="13%" bgcolor="#003366"><span>POTONGAN</span></th>
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
              } while ($row_DetailFaktur = mysql_fetch_assoc($DetailFaktur)); ?>
              <tr>
                <td colspan="2"> <?php $pelanggan = empty($row_Penjualan['namapelanggan']) ? "" : "Pelanggan : " . strtoupper($row_Penjualan['namapelanggan']) . " (0" . $row_Penjualan['nohp'] . ")";
                                  echo $pelanggan; ?></td>
                <td>
                  <div align="right"><strong> TOTAL</strong></div>
                </td>
                <td>
                  <div align="right">Rp. <?php echo number_format($total); ?></div>
                </td>
                <td>
                  <div align="right">Rp. <?php echo number_format($disk); ?></div>
                </td>
              </tr>
            </table>
            <p></p>
          </td>
        </tr>
      <?php
        $nomor++;
      } while ($row_Penjualan = mysql_fetch_assoc($rs_Penjualan)); ?>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td>
          <div align="center"><strong>TOTAL BELANJA</strong></div>
        </td>
        <td>
          <div align="center"><strong>TOTAL LABA</strong></div>
        </td>
        <td>
          <div align="center"><strong>TOTAL POTONGAN</strong></div>
        </td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td>
          <div align="right">Rp.
            <?= number_format($totalbelanja); ?>
          </div>
        </td>
        <td>
          <div align="right">Rp.
            <?= number_format($totalLaba); ?>
          </div>
        </td>
        <td>
          <div align="right">Rp.
            <?= number_format($totalpotongan); ?>
          </div>
        </td>
      </tr>
    </table>
    <p>
      <br>
      <br>
      <br>
    </p>

    <?php require('ttd.php'); ?>
  <?php } else {
  danger('Oops!', 'Transaksi tidak ditemukan');
} ?>