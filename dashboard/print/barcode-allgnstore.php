<?php require_once('../../Connections/koneksi.php'); ?>
<?php
$query_barcode = "SELECT barcode.*, namaproduk, hargajual, hargadasar, kategori, qtybarcode 
                  FROM barcode 
                  LEFT JOIN produk ON kodeproduk = barcode.barcode";
$barcode = mysqli_query($koneksi, $query_barcode) or die(mysqli_error($koneksi));
$row_barcode = mysqli_fetch_assoc($barcode);
$totalRows_barcode = mysqli_num_rows($barcode);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Barcode Print</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
  @media print {
    body {
      width: 48mm;
      margin: 0;
      margin-left: 10px;
      padding: 0;
      font-family: Arial, sans-serif;
      font-size: 9px;
    }

    .label-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .label {
      width: 50%;
      box-sizing: border-box;
      text-align: center;
      padding: 6px 0;
      margin-bottom: 6px;
      border: 1px dashed #000;
    }

    .price {
      font-weight: bold;
      font-size: 10px;
    }

    .name {
      font-size: 8px;
      font-weight: bold;
      word-wrap: break-word;
      white-space: normal;
      
    }

    .barcode img {
      height: 40px;
      width: auto;
      max-width: 100%;
    }

    .code {
      font-size: 10px;
      letter-spacing: 1px;
    }
  }
</style>
</head>

<body onload="window.print()">
  <div class="label-container">
    <?php if ($row_barcode) { do { ?>
      <?php for ($i = 1; $i <= $row_barcode['qtybarcode']; $i++) { ?>
        <div class="label">
          <div class="name"><?= $row_barcode['namaproduk']; ?></div>
          <div class="barcode">
            <img src="https://barcode.tec-it.com/barcode.ashx?data=<?= $row_barcode['barcode']; ?>" alt="<?= $row_barcode['barcode']; ?>">
          </div>
          <div class="price">Rp.<?= number_format($row_barcode['hargajual']); ?></div>
        </div>
      <?php } ?>
    <?php } while ($row_barcode = mysqli_fetch_assoc($barcode)); } ?>
  </div>
</body>
</html>