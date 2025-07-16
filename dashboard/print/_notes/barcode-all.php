<?php require_once('../../Connections/koneksi.php'); ?>
<?php

$query_barcode = "SELECT barcode.*, namaproduk, hargajual, kategori, qtybarcode FROM barcode LEFT JOIN produk ON kodeproduk = barcode";
$barcode = mysql_query($query_barcode, $koneksi) or die(mysql_error());
$row_barcode = mysql_fetch_assoc($barcode);
$totalRows_barcode = mysql_num_rows($barcode);

$qty = $row_barcode['qtybarcode'];

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Barcode - <?= $header; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- BARCODE FONT -->
  <style>
    @font-face {
      font-family: code39;
      src: url('../../assets/barcode/Code39Azalea.ttf');
    }

    .barcode {
      display: inline-block;
      width: 250px;
      height: 130px;
      padding: 1px;
      margin-top: 5px;
      margin-right: 10px;
      margin-bottom: 5px;
      
      word-wrap: break-word;
      align-items: center;
    }
  </style>
  <style type="text/css">
    .style3 {
      font-weight: bolder;
      font-family: "Courier New", Courier, monospace;
      font-size: 22px;
      stroke: black;
      line-height: 20px;
      

    }
  </style>
  <style type="text/css">
    .style4 {
      font-weight: bolder;
      font-family: "Courier New", Courier, monospace;
      font-size: 40px;
      stroke: black;
      line-height: 1px;
      
      
    }
  </style>
   <style type="text/css">
    .style5 {
      font-weight: bolder;
      font-family: "Courier New", Courier, monospace;
      font-size: 15px;
      stroke: black;
      line-height: 15px;
      
    }
  </style>

</head>

<body onLoad="window.print()">
  <?php do { ?>
    <?php for ($jumlah = 1; $jumlah <= $row_barcode['qtybarcode']; $jumlah++) { ?>
      <div class="barcode">
        <div align="center">
          <div class="style3"><strong><?php if (!isset($_GET['label'])) { ?><?php echo $row_barcode['namaproduk']; ?><?php } ?></strong></div>
         <br><br><div class="style4"><strong>Rp <?php echo number_format($row_barcode['hargajual']); ?></strong></div>
          <div class="style5"><strong><br><br><font face="code39" size="6em" line-height="5px" style="letter-spacing:3px;">*<?php echo $row_barcode['barcode']; ?>*</font></div>
          <div class="style5"><strong><?php echo $row_barcode['barcode']; ?>
              <?php if (!isset($_GET['harga'])) { ?>
              <?php } ?>
            </strong></div>
        </div>
      </div>
    <?php } ?>

  <?php } while ($row_barcode = mysql_fetch_assoc($barcode)); ?>


</body>

</html>