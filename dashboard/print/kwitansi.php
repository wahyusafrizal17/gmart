<?php  
require_once('../require/lap_header.php'); 

$colname_Penjualan = "-1";
if (isset($_GET['faktur'])) {
  $colname_Penjualan = $_GET['faktur'];
}
mysqli_select_db($database_koneksi, $koneksi);
	$query_Penjualan = sprintf("SELECT kode, nama, harga, qty FROM transaksitemp WHERE faktur = %s", 
	GetSQLValueString($colname_Penjualan, "text"));
$Penjualan = mysqli_query($query_Penjualan, $koneksi) or die(mysqli_error());
$row_PenjualanDetail = mysqli_fetch_assoc($Penjualan);
$totalRows_Penjualan = mysqli_num_rows($Penjualan);


?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dashboard - <?= $header; ?></title>
    
    
<style>
 
	/* --- */
	@font-face {
                font-family: code39;
                src: url('../../assets/barcode/Code39Azalea.ttf');
            }
			.barcode{
				  display: inline-block;
				  width: 110px;
				  height: 50px;
				  padding: 1px 5px;
				  margin: 5px 5px;
				  border: 1px solid black;    
			}
	 /* --- */
    h1 {
        font-weight: bold;
        font-size: 20pt;
        text-align: center;
    }
 
    table {
        border-collapse: collapse;
    }
 
    .table th {
        border:1px solid #000000;
        text-align: center;
    }
 
    .table td {
        border:1px solid #000000;
    }
	.table td .table td {
        border:0px solid #000000;
    }
    .text-center {
        text-align: center;
    }

.table-collapse {
	border-collapse:collapse;
}
.style2 {
	font-size: xx-small;
	font-weight: bold;
	font-style: italic;
}
.col-md-3 {
	font-size : 7px;
}
.style10 {font-size: 9px; font-family: Geneva, Arial, Helvetica, sans-serif; }
.style13 {font-size: 10px; font-family: Geneva, Arial, Helvetica, sans-serif; }
.style14 {font-size: 10px}
.style15 {font-family: Geneva, Arial, Helvetica, sans-serif}
</style>

</head>
<body> 
 <p></p>
  <p></p>
  <table width="199" height="131" cellpadding="0" cellspacing="0">
  <tr>
    <td height="44" colspan="3"><div align="center" class="style10"><strong><?= $header?><br>
      <?= $footer; ?><br>  
      </strong></div></td>
    <td height="44"><!--<img src="/kilangpadi/photos/default.png" width="41" height="48">--></td>
  </tr>
  <tr>
        <td width="39%"><span class="style13">F :</strong><?php echo $row_Penjualan['faktur']; ?></span></td>
      <td colspan="3"><div align="center" class="style13"><?php echo $today; ?></div></td>   
    </tr>
 
	<?php 
	  $total = 0;
	  $subtotal = 0;
	  $no = 1; do { 
      $subtotal = $row_Penjualan['harga'] * $row_Penjualan['qty'];
  	?>      
      <tr>
        <td colspan="4"><span class="style13"><?php echo $row_Penjualan['namaproduk']; ?></span></td>
    </tr>
      <tr>
        <td colspan="2"><div align="left" class="style13"> 
        x 
        <?= $row_Penjualan['qty']; ?>
         - Rp.
            <?= $row_Penjualan['harga']; ?>
</div></td>
        <td width="14%"><div align="right" class="style13">  
          <div align="right">Rp. </div>
        </div></td>
        <td width="29%"><div align="right" class="style13">
          <div align="left"><?php echo $subtotal; ?></div>
        </div></td>
    </tr>
	<?php
	$total += $subtotal;
	$no++;
	} while ($row_Penjualan = mysqli_fetch_assoc($Penjualan)); 
	?>      
      <tr>
        <td><div align="right" class="style13">TOTAL BAYAR </div></td>
        <td width="18%"><span class="style14"></span></td>
        <td><div align="right" class="style14"><span class="style15">Rp.</span></div></td>
        <td><div align="left" class="style14"><span class="style15"> <?php echo $total; ?> </span></div></td>
    </tr>
    </table>
  
<br>
<p align="left" class="style2">NB : Harga yang tertera sudah <br>
  kesepapakatan penjual dan pembeli</p>
 
</body>
</html>