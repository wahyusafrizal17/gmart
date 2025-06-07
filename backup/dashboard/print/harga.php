<?php require_once('../../Connections/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
  function GetSQLValueString($koneksi, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
  {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

    $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

    switch ($theType) {
      case "text":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "long":
      case "int":
        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
        break;
      case "double":
        $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
        break;
      case "date":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "defined":
        $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        break;
    }
    return $theValue;
  }
}

$colname_barcode = "-1";
if (isset($_GET['barcode'])) {
  $colname_barcode = $_GET['barcode'];
}
//mysqli_select_db($database_koneksi);
$query_barcode = sprintf("SELECT barcode.*, namaproduk, hargajual, kategori FROM barcode LEFT JOIN produk ON kodeproduk = barcode WHERE barcode = %s", GetSQLValueString($koneksi, $colname_barcode, "text"));
$barcode = mysqli_query($koneksi, $query_barcode) or die(mysqli_error());
$row_barcode = mysqli_fetch_assoc($barcode);
$totalRows_barcode = mysqli_num_rows($barcode);

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
      width: 200px;
      height: 120px;
      padding: 0px;
      margin-right: 5px;
      margin-bottom: 20px;
      border: 3px solid black;
      word-wrap: break-word;
    }
  </style>
  <style type="text/css">
    .style3 {
      font-family: "Courier New", Courier, monospace;
      font-size: 12px;

    }
  </style>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body>
  <h3>BARCODE PRODUK : <?= $row_barcode['namaproduk']; ?></h3>
  <?php do { ?>
    <?php for ($i = 1; $i <= $qty; $i++) { ?>
      <div class="barcode">
        <div align="center">
          <?php if (!isset($_GET['label'])) {
            echo $row_barcode['namaproduk'];
          } ?>
          <?php if (!isset($_GET['harga'])) { ?>
            <span style="font-size: 30pt;"><?php echo number_format($row_barcode['hargajual']); ?></span>
          <?php } ?>
          <br>
          - <?php echo $row_barcode['barcode']; ?> -
        </div>
      </div>
    <?php } ?>
  <?php } while ($row_barcode = mysqli_fetch_assoc($barcode)); ?>

  <script type="text/javascript">
    window.onload = function() {
      window.print();
    }
  </script>
</body>

</html>