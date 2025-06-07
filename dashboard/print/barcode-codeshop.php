<?php require_once('../../Connections/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
  {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

    $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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
mysql_select_db($database_koneksi, $koneksi);
$query_barcode = sprintf("SELECT barcode.*, namaproduk, hargajual, hargadasar, kategori FROM barcode LEFT JOIN produk ON kodeproduk = barcode WHERE barcode = %s", GetSQLValueString($colname_barcode, "text"));
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
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <style>
    .barcode {
      height: auto;
      margin-bottom: 20px;
    }

    .content {
      max-width: 500px;
      margin: auto;
      background: white;
    }

    .style3 {
      font-family: "Courier New", Courier, monospace;
      font-size: 10px;
    }
  </style>
</head>

<body onLoad="window.print()">
  <div class="content">
    <?php do { ?>
      <?php for ($i = 1; $i <= $qty; $i++) { ?>
        <div class="barcode">
          <div align="center">
            <div class="style2"><strong>Rp.<?php echo number_format($row_barcode['hargajual']); ?></strong></div>
            <div class="style3">
              <strong>
                <?php if (!isset($_GET['label'])) {
                  echo $row_barcode['namaproduk'];
                } ?>
              </strong>
            </div>

            <!-- Barcode image using barcode.tec-it.com -->
            <img 
              src="https://barcode.tec-it.com/barcode.ashx?data=<?= $row_barcode['barcode']; ?>&code=EAN13&dpi=96"
              alt="<?= $row_barcode['barcode']; ?>" 
              style="height:50px;" 
            /><br />

            <div class="style3">
              <strong>
                <?= $row_barcode['kategori']; ?> - <?= $row_barcode['barcode']; ?>
                <?php if (!isset($_GET['harga'])) { ?>
                  - <?= $row_barcode['hargadasar']; ?>0
                <?php } ?>
              </strong>
            </div>
          </div>
        </div>
        <br>
      <?php } ?>
    <?php } while ($row_barcode = mysql_fetch_assoc($barcode)); ?>
  </div>
</body>

</html>
