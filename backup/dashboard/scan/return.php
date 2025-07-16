<?php  
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_DetailFaktur = "-1";
if (isset($_GET['faktur'])) {
  $colname_DetailFaktur = $_GET['faktur'];
}
//mysqli_select_db($database_koneksi);
$query_DetailFaktur = sprintf("SELECT transaksidetail.id as idtemp, faktur, tanggal, kode, transaksidetail.nama as np, harga, hargadasar, qty, addby, stt, transaksidetail.periode, vw_login.Nama as kassa FROM transaksidetail 
INNER JOIN faktur ON transaksidetail.faktur = faktur.kodefaktur
LEFT JOIN vw_login ON addby = vw_login.ID WHERE faktur = %s", GetSQLValueString($koneksi, $colname_DetailFaktur, "text"));
$DetailFaktur = mysqli_query($koneksi, $query_DetailFaktur) or die(mysqli_error());
$row_DetailFaktur = mysqli_fetch_assoc($DetailFaktur);
$totalRows_DetailFaktur = mysqli_num_rows($DetailFaktur);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	//JIKA PILIHANNYA X MAKA SIMPAN DENGAN NILAI QTY AWAL
  	if ($_POST['qtyreturn'] == 'x') {
		  $insertSQL = sprintf("INSERT INTO returnproduk (asalfaktur, produkreturn, qtyreturn, ketreturn, namareturn, hargadasar, hargajual, addedreturn, addbyreturn, periode, tglreturn) VALUES (%s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s)",
						   GetSQLValueString($koneksi, $_POST['asalfaktur'], "text"),
						   GetSQLValueString($koneksi, $_POST['produkreturn'], "text"),
						   GetSQLValueString($koneksi, $_POST['awal'], "int"),
						   GetSQLValueString($koneksi, $_POST['ketreturn'], "text"),
						   GetSQLValueString($koneksi, $_POST['namareturn'], "text"),
						   GetSQLValueString($koneksi, $_POST['hargadasar'], "double"),
						   GetSQLValueString($koneksi, $_POST['hargajual'], "double"),
						   GetSQLValueString($koneksi, time(), "int"),
						   GetSQLValueString($koneksi, $ID, "int"),
						   GetSQLValueString($koneksi, $ta, "text"),
						   GetSQLValueString($koneksi, $tglsekarang, "date"));
	
	  //mysqli_select_db($database_koneksi);
	  $Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error());

		$stok = sprintf("UPDATE produk SET stok = stok + %s WHERE kodeproduk = %s",
							GetSQLValueString($koneksi, $_POST['awal'], "int"),
							GetSQLValueString($koneksi, $_POST['produkreturn'], "text"));  
												 
		//mysqli_select_db($database_koneksi);
		$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error());
		
		$kurangistok = sprintf("DELETE FROM transaksidetail WHERE id=%s",
								GetSQLValueString($koneksi, $_POST['idtemp'], "int"));  
													 
		//mysqli_select_db($database_koneksi);
		$hasilstok2 = mysqli_query($koneksi, $kurangistok) or die(mysqli_error());
		
			//UNTUK MENAMBAHKAN JUMLAH KEMBALIAN BERDASARKAN HARGA PRODUK YANG DIKEMBALI
		$kembalian = sprintf("UPDATE faktur SET kembalian = kembalian + %s WHERE kodefaktur = %s",
								GetSQLValueString($koneksi, $_POST['awal'] * $_POST['hargajual'], "double"),
								GetSQLValueString($koneksi, $_POST['asalfaktur'], "text"));  
													 
		//mysqli_select_db($database_koneksi);
		$hasilkembalian = mysqli_query($koneksi, $kembalian) or die(mysqli_error());
		
		refresh($actual_link);
	}else{
	//JIKA PILIHANNYA ANGKA MAKA SIMPAN DENGAN NILAI QTY COMBOBOX
	  $insertSQL = sprintf("INSERT INTO returnproduk (asalfaktur, produkreturn, qtyreturn, ketreturn, namareturn, hargadasar, hargajual, addedreturn, addbyreturn, periode, tglreturn) VALUES (%s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s)",
                       GetSQLValueString($koneksi, $_POST['asalfaktur'], "text"),
                       GetSQLValueString($koneksi, $_POST['produkreturn'], "text"),
                       GetSQLValueString($koneksi, $_POST['qtyreturn'], "int"),
                       GetSQLValueString($koneksi, $_POST['ketreturn'], "text"),
					   GetSQLValueString($koneksi, $_POST['namareturn'], "text"),
					   GetSQLValueString($koneksi, $_POST['hargadasar'], "double"),
					   GetSQLValueString($koneksi, $_POST['hargajual'], "double"),
                       GetSQLValueString($koneksi, time(), "int"),
                       GetSQLValueString($koneksi, $ID, "int"),
					   GetSQLValueString($koneksi, $ta, "text"),
					   GetSQLValueString($koneksi, $tglsekarang, "date"));
  //mysqli_select_db($database_koneksi);
  $Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error());
    //UNTUK MENGEMBALIKAN STOK PRODUK
  	$stok = sprintf("UPDATE produk SET stok = stok + %s WHERE kodeproduk = %s",
							GetSQLValueString($koneksi, $_POST['qtyreturn'], "int"),
							GetSQLValueString($koneksi, $_POST['produkreturn'], "text"));  
												 
	//mysqli_select_db($database_koneksi);
	$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error());
	
	//UNTUK MENGURANGI STOK DI TRANSAKSI DETAIL
	$kurangistok = sprintf("UPDATE transaksidetail SET qty = qty - %s WHERE id = %s",
							GetSQLValueString($koneksi, $_POST['qtyreturn'], "int"),
							GetSQLValueString($koneksi, $_POST['idtemp'], "text"));  
												 
	//mysqli_select_db($database_koneksi);
	$hasilstok2 = mysqli_query($koneksi, $kurangistok) or die(mysqli_error());
	
	//UNTUK MENAMBAHKAN JUMLAH KEMBALIAN BERDASARKAN HARGA PRODUK YANG DIKEMBALI
	$kembalian = sprintf("UPDATE faktur SET kembalian = kembalian + %s WHERE kodefaktur = %s",
							GetSQLValueString($koneksi, $_POST['qtyreturn'] * $_POST['hargajual'], "double"),
							GetSQLValueString($koneksi, $_POST['asalfaktur'], "text"));  
												 
	//mysqli_select_db($database_koneksi);
	$hasilkembalian = mysqli_query($koneksi, $kembalian) or die(mysqli_error());
	 
  	refresh($actual_link);
  	 
  }
  
  
}

//MENGUBAH STATUS FAKTUR
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE faktur SET statusfaktur=%s WHERE kodefaktur=%s",
                       GetSQLValueString($koneksi, $_POST['statusfaktur'], "text"),
                       GetSQLValueString($koneksi, $_POST['idfaktur'], "text"));

  //mysqli_select_db($database_koneksi);
  $Result1 = mysqli_query($koneksi, $updateSQL) or die(mysqli_error());
}

//mysqli_select_db($database_koneksi);
$query_Batalfaktur = sprintf("SELECT * FROM faktur WHERE kodefaktur = %s", GetSQLValueString($koneksi, $colname_DetailFaktur, "text"));
$Batalfaktur = mysqli_query($koneksi, $query_Batalfaktur) or die(mysqli_error());
$row_Batalfaktur = mysqli_fetch_assoc($Batalfaktur);
$totalRows_Batalfaktur = mysqli_num_rows($Batalfaktur);
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style3 {color: #FFFFFF; font-style: italic; }
-->
</style>
<div class="row">
	<div class="col-md-4">  
                                                    <div class="callout callout-success">
                                                    <form id="form1" name="form1" method="get" action="">
                                            <label>Scan Barcode Here</label>
                                                                <div class="input-group margin">
                                                                    
                                                                    <input type="text" name="faktur" placeholder="Cari No. Faktur" class="form-control" autofocus required>
                                                                        <span class="input-group-btn">
                                                                          <button type="submit" class="btn btn-info btn-flat">Search</button>
                                                                        </span>
                                                                </div>
                                                                <input type="hidden" name="page" value="scan/return" />
                                                    </form>
                                                    </div>
                                                </div>
</div>                                                
<div class="clearfix"></div>                                                
<div class="row">

<div class="col-md-12">
<?php if ($totalRows_DetailFaktur) { ?>
<div class="alert alert-success">
<h4><strong>DETAIL FAKTUR : <?php echo $row_DetailFaktur['faktur']; ?></strong></h4>
<p>Tanggal : <?php Tanggal($row_DetailFaktur['tanggal']); ?> &nbsp;&nbsp;&nbsp; Kassa : <?php echo $row_DetailFaktur['kassa']; ?></p>
</div>
<p>
<?php back(); ?>
</p>
<table width="100%" height="127" class="table table-striped table-hover">
  <tr>
    <th bgcolor="#006666"><span class="style1">NO</span></th>
    <th bgcolor="#006666"><span class="style1">PRODUK</span></th>
    <th bgcolor="#006666"><span class="style1">QTY</span></th>
    <th bgcolor="#006666"><span class="style1">SUB TOTAL</span></th>
    <th bgcolor="#006666"><div align="center"><span class="style3">Setelah di Return maka Produk terhapus dari list Faktur</span></div></th>
  </tr>
  <?php 
  $total = 0;
  $no = 1;
  do { 
  $sub = $row_DetailFaktur['harga'] * $row_DetailFaktur['qty']; 
  $total += $sub;
  $i = 1;
  if ($row_DetailFaktur['qty'] == 1) {
  	$i = 2;
  }
  ?>
    <tr>
      <td><?= $no;?></td>
      <td><?php echo $row_DetailFaktur['kode']; ?>- <?php echo $row_DetailFaktur['np']; ?></td>
      <td><?php echo $row_DetailFaktur['qty']; ?> @ Rp. <?php echo $row_DetailFaktur['harga']; ?></td>
      <td>Rp. <?php echo $sub?></td>
      <td><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <div class="col-md-3">
      <div class="input-group margin pull-right"> 
	      <select name="qtyreturn" id="qtyreturn" class="form-control">
            	<option value="x">x</option>
				<?php for($i; $i <= $row_DetailFaktur['qty']; $i++) { ?>
            	<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>
            </div>
       </div>     
      <div class="col-md-9">
   		  <div class="input-group margin"> 
            <input type="text" name="ketreturn" placeholder="Isi alasan pengembalian" class="form-control" required>
            <span class="input-group-btn">
            	<button type="submit" class="btn btn-danger btn-flat">Return </button>
                <input type="hidden" name="asalfaktur" value="<?php echo $row_DetailFaktur['faktur']; ?>" id="asalfaktur" />
                <input type="hidden" name="produkreturn" value="<?php echo $row_DetailFaktur['kode']; ?>" id="produkreturn" />
                <input type="hidden" name="awal" value="<?php echo $row_DetailFaktur['qty']; ?>" id="qtyreturn" class="form-control"/>
                <input type="hidden" name="idtemp" value="<?php echo $row_DetailFaktur['idtemp']; ?>" id="idtemp"/>
                <input type="hidden" name="namareturn" value="<?php echo $row_DetailFaktur['np']; ?>" id="idtemp"/>
                <input type="hidden" name="hargadasar" value="<?php echo $row_DetailFaktur['hargadasar']; ?>" id="idtemp"/>
                <input type="hidden" name="hargajual" value="<?php echo $row_DetailFaktur['harga']; ?>" id="idtemp"/>
            </span>            </div>
            <input type="hidden" name="MM_insert" value="form1" />
            </div>
        </form>
      </td>
    </tr>
    <?php 
	$no++;
	} while ($row_DetailFaktur = mysqli_fetch_assoc($DetailFaktur)); ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Rp. <?php echo $total; ?></td>
      <td>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <label>Batalkan faktur ini?</label>
        <select name="statusfaktur" class="form-control" onchange="this.form.submit()">
          <option value="Y" <?php if (!(strcmp("Y", htmlentities($row_Batalfaktur['statusfaktur'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Jangan Batalkan</option>
          <option value="N" <?php if (!(strcmp("N", htmlentities($row_Batalfaktur['statusfaktur'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Batalkan</option>
        </select>
       <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="idfaktur" value="<?php echo $colname_DetailFaktur; ?>" /> 
            </form>
      </td>
    </tr>
</table>
</div>
</div>
<div class="col-md-12">
<?php }else{
	title('danger','Maaf','Kami tidak menemukan faktur tersebut!');
} ?>
</div>

<div class="clearfix"></div>												