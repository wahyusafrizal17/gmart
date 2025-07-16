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
$query_barcode = sprintf("SELECT kodeproduk, namaproduk, hargajual, kategori FROM produk WHERE kodeproduk = %s", GetSQLValueString($colname_barcode, "text"));
$barcode = mysql_query($query_barcode, $koneksi) or die(mysql_error());
$row_barcode = mysql_fetch_assoc($barcode);
$totalRows_barcode = mysql_num_rows($barcode);

$qty = "-1";
if (isset($_GET['qty'])) {
	$qty = $_GET['qty'];
} 

?><!DOCTYPE html>
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
			.barcode{
				  display: inline-block;
				  width: 190px;
				  height: 80px;
				  padding: 5px;
				  margin-right: 5px;
				  margin-bottom: 20px;
				  border: 1px solid black;    
			}
        </style>
        <style type="text/css">
<!--
 
.style3 {font-family: "Courier New", Courier, monospace; font-size:12px;}
-->
</style>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onLoad="window.print()">
 <h3>BARCODE PRODUK : <?= $row_barcode['namaproduk']; ?></h3>
		<?php do { ?>
 			  <?php for($i = 1; $i <= $qty; $i++) { ?>	
              <div class="barcode">
                <div align="center">
                 
                <font face="code39" line-height="5px" style="letter-spacing:5px; font-size:50px" >*<?php echo $row_barcode['kodeproduk']; ?>*</font><br />
                      <div class="style3"><strong><?php echo $row_barcode['kategori']; ?>  - <?php echo $row_barcode['kodeproduk']; ?>  
                      <?php if (!isset($_GET['harga'])) { ?>
                      - <?php echo $row_barcode['hargajual']; ?>
                      <?php } ?>
                      </strong></div> </div>
              </div>
              <?php } ?>
            <?php } while ($row_barcode = mysql_fetch_assoc($barcode)); ?>
     
 
</body>
</html> 