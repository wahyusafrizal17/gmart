<?php
session_start();
require_once('../Connections/koneksi.php');
if($_GET['faktur']==''){
    $userId = mysql_fetch_array(mysql_query($koneksi,"select ID,Nama from vw_login where Login='".$_SESSION['MM_Username']."'"));

    $insertSQL = sprintf("INSERT INTO faktur (tglfaktur, statusfaktur, kodefaktur, addedfaktur, addbyfaktur, adminfaktur, periode) VALUES (%s, %s, %s, %s, %s, %s, %s)",
    GetSQLValueString($koneksi, $today, "date"),
    GetSQLValueString($koneksi, 'N', "text"),
    GetSQLValueString($koneksi, $kodeacak, "text"),
    GetSQLValueString($koneksi, time(), "int"),
    GetSQLValueString($koneksi, $userId['ID'], "int"),
    GetSQLValueString($koneksi, $userId['Nama'], "text"),
    GetSQLValueString($koneksi, $ta, "text"));

//mysql_select_db($database_koneksi);
$Result1 = mysql_query($koneksi, $insertSQL) or die(mysql_error());


//mysql_select_db($database_koneksi);
$query_Faktur = sprintf("SELECT * FROM faktur WHERE tglfaktur = %s AND addbyfaktur = %s AND periode = %s AND statusfaktur = %s ORDER BY idfaktur DESC", 
    GetSQLValueString($koneksi, $tglsekarang, "date"),
    GetSQLValueString($koneksi, $userId['ID'], "int"),
    GetSQLValueString($koneksi, $ta, "text"),					   
    GetSQLValueString($koneksi, 'N', "text"));
$Faktur = mysql_query($koneksi, $query_Faktur) or die(mysql_error());
$row_Faktur = mysql_fetch_assoc($Faktur);
$totalRows_Faktur = mysql_num_rows($Faktur);
//MEMBUAT NILAI FAKTUR
$faktur = $row_Faktur['kodefaktur'];
header("location:/dashboard/camera2.php?faktur=".$faktur);
}else{
    $faktur = $_GET['faktur'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div style="width: 500px" id="reader"></div>
<script src="node_modules/html5-qrcode/html5-qrcode.min.js"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
    // Handle on success condition with the decoded text or result.
    console.log(`Scan result: ${decodedText}`, decodedResult);
    window.location = "scan_add.php?result="+decodedText+"&faktur="+<?php echo $_GET['faktur'];?>;
}

var html5QrcodeScanner = new Html5QrcodeScanner(
	"reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);
</script>
</body>
</html>