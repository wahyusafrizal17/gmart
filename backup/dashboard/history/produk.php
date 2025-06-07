<?php

$kodeproduk = "-1";

if (isset($_GET['kode'])) {
  $kodeproduk = $_GET['kode'];
}

////mysqli_select_db($database_koneksi);
$query_Harga = sprintf(
  "SELECT `kodeproduk`, `hargajual`, `hargabaru`, `hargadasar`, if(hargabaru > hargajual, 'Naik','Turun') as Status, if(hargabaru > hargajual, hargabaru - hargajual,hargajual - hargabaru) as Selisih, `namaprodukOld`, `namaprodukBaru`, addby, tercatat FROM harga WHERE kodeproduk = %s ORDER BY idharga DESC",
  GetSQLValueString($koneksi, $kodeproduk, "text")
);
$Harga = mysqli_query($koneksi, $query_Harga) or die(errorQuery(mysqli_error()));
$row_Harga = mysqli_fetch_assoc($Harga);
$totalRows_Harga = mysqli_num_rows($Harga);
?>

<?php
title('success', 'DAFTAR PERUBAHAN PRODUK', 'Berikut ini adalah perubahan produk yang telah terekam');
?>
<?php if ($totalRows_Harga > 0) { ?>
  <table width="100%" class="table table-bordered table-hover table-striped" id="example1">
    <thead>
      <tr bgcolor="#006666">
        <th width="1%">
          <div align="center" class="text-white">NO.</div>
        </th>
        <th width="43%">
          <div align="center" class="text-white">NAMA PRODUK</div>
        </th>
        <th width="12%">
          <div align="center" class="text-white">HARGA JUAL</div>
        </th>
        <th width="15%">
          <div align="center" class="text-white">HARGA BARU</div>
        </th>
        <th width="14%">
          <div align="center" class="text-white">SELISIH</div>
        </th>
        <th width="15%">
          <div align="center" class="text-white">OLEH</div>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1;
      do { ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><?php echo $row_Harga['kodeproduk']; ?>- <?php echo $row_Harga['namaprodukBaru']; ?><br />
            Nama sebelumnya :<br />
            <?php echo $row_Harga['namaprodukOld']; ?></td>
          <td>
            <div align="center" style="font-size:24px;"><?php echo number_format($row_Harga['hargajual']); ?></div>
          </td>
          <td>
            <div align="center" style="font-size:24px;"><?php echo number_format($row_Harga['hargabaru']); ?></div>
          </td>
          <td>
            <?php if ($row_Harga['Status'] == 'Turun') { ?>
              <div class="btn btn-danger btn-block" style="font-size:24px;"><span class="fa fa-arrow-down"></span> <?php echo $row_Harga['Selisih']; ?></div>
            <?php } else { ?>
              <div class="btn btn-success  btn-block" style="font-size:24px;"><span class="fa fa-arrow-up"></span> <?php echo $row_Harga['Selisih']; ?></div>
            <?php } ?>
          </td>
          <td><?php echo $row_Harga['addby']; ?><br />
            <?php echo $row_Harga['tercatat']; ?></td>
        </tr>
      <?php } while ($row_Harga = mysqli_fetch_assoc($Harga)); ?>
    </tbody>
  </table>
<?php } else {
  danger('Oops!', 'Produk tersebut belum memiliki history perubahan');
  back();
}
?>