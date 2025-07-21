<?php require_once('Connections/koneksi.php');
require_once('require/header.php'); 
$colname_rs_print = "-1";
if (isset($_GET['id'])) {
  $colname_rs_print = $_GET['id'];
}
//mysql_select_db($database_koneksi, $koneksi);
$query_rs_print = sprintf("SELECT * FROM tb_paket INNER JOIN tb_pengirim ON pengirim_paket = id_pengirim WHERE kode_paket = %s", GetSQLValueString($colname_rs_print, "text"));
$rs_print = mysqli_query($koneksi, $query_rs_print) or die('Query failed: ' . mysqli_error($koneksi));
$row_rs_print = mysqli_fetch_assoc($rs_print);
$totalRows_rs_print = mysqli_num_rows($rs_print);
?>


  <!-- BARCODE FONT -->
  <style>
            @font-face {
                font-family: code39;
                src: url('assets/barcode/Code39Azalea.ttf');
            }
			.barcode{
				  display: inline-block;
				  width: 190px;
				  height: 100px;
				  padding: 1px 5px;
				  margin: 5px 5px;
				  border: 1px solid black;    
			}
			 .table th {
        padding: 8px 8px;
        border:1px solid #000000;
        text-align: center;
			}
		 
			.table td {
				padding: 3px 3px;
				border:1px solid #000000;
			}
			.table td .table td {
				padding: 3px 3px;
				border:0px solid #000000;
			}
        </style>
        <style type="text/css">
<!--
 
.style3 {font-family: "Courier New", Courier, monospace; font-size:12px;}

-->
</style>

<title>Dashboard - <?= $header; ?></title>

<body onLoad="window.print()">
<?php if ($totalRows_rs_print > 0) { ?>
<table width="70%" height="398" class="table">
  <tr>
    <td width="51%" height="44"><img src="log_asset/images/bg-01.jpg" width="192" height="83" /></td>
    <td width="24%">&nbsp;</td>
    <td width="25%"><div align="center">       
    <img src="admin/report/qrcodepk-img/<?= $_GET['id']; ?>.png" width="80" height="85" /> </div></td>
  </tr>
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><h1><?php echo $row_rs_print['kode_paket']; ?></h1></td>
  </tr>
  <tr>
    <td colspan="3"><em>Dengan menandatangani paket ini, maka penerima telah mengkonfirmasi kebenaran informasi resi dan isi paket ini, serta telah memahami dan menyetujui syarat dan ketentuan umum pengiriman NJA Express</em></td>
  </tr>
  <tr>
    <td colspan="3"><p>Penerima : <?php echo $row_rs_print['penerima_paket']; ?>, <strong><?php echo $row_rs_print['telppenerima_paket']; ?><br />
        <?php echo $row_rs_print['tujuan_paket']; ?></strong></p>
    <p>Pengirim : <?php echo $row_rs_print['nama_pengirim']; ?>, <strong><?php echo $row_rs_print['notelp_pengirim']; ?></strong><br />
        <strong><?php echo $row_rs_print['alamat_pengirim']; ?></strong><br />
    </p></td>
  </tr>
  <tr>
    <td colspan="3">Jumlah : <?php echo $row_rs_print['jumlah_paket']; ?>pcs, Paket : <?php echo $row_rs_print['nama_paket']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td rowspan="3" valign="bottom">.............................</td>
  </tr>
  <tr>
    <td>
     <div class="barcode">
      <div align="center"><font face="code39" size="7em" line-height="5px" style="letter-spacing:3px;" >*<?php echo $row_rs_print['kode_paket']; ?>*</font>
          <br />
      </div>
      <div class="style3">
        <div align="center"><strong><?php echo $row_rs_print['kode_paket']; ?> </strong></div>
      </div>
    </div>    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php }else{
	die('data tidak ditemukan');
}
?>

</body>