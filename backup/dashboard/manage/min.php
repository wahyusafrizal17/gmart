<?php  
//require_once('izin.php');
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE produk SET  `minProduk`=%s,`alertproduk`=%s WHERE `idproduk`=%s",
                       GetSQLValueString($koneksi, $_POST['qty'], "int"),
					   GetSQLValueString($koneksi, $_POST['ket'], "text"),
					   GetSQLValueString($koneksi, $_POST['produkID'], "int"));

  //mysqli_select_db($database_koneksi);
  $Result1 = mysqli_query($koneksi, $updateSQL) or die(errorQuery(mysqli_error()));
  
  //26 Desember open
  $activitySQL = sprintf("INSERT INTO activity_update (`url`, `oleh`) VALUES (%s, %s)",
  GetSQLValueString($koneksi, $actual_link, "text"),
  GetSQLValueString($koneksi, $ID, "int"));
  //mysqli_select_db($database_koneksi);
  $ResultSQL = mysqli_query($koneksi, $activitySQL) or die(errorQuery(mysqli_error()));	
  //26 desember close
  
  if ($Result1) {
  	refresh('?page=produk/view&sukses');
  }
}
$colname_search = "-1";
if (isset($_POST['search'])) {
  $colname_search = $_POST['search'];
}
//mysqli_select_db($database_koneksi);
$query_search = sprintf("SELECT * FROM produk WHERE kodeproduk = %s OR namaproduk LIKE %s", GetSQLValueString($koneksi, $colname_search, "text"), GetSQLValueString($koneksi, "%" . $colname_search . "%", "text"));
$search = mysqli_query($koneksi, $query_search) or die(mysqli_error());
$row_search = mysqli_fetch_assoc($search);
$totalRows_search = mysqli_num_rows($search);

?>
<div class="row">
    <div class="col-md-4">  
        <div class="callout callout-success">
        <form id="form1" name="form1" method="post" action="">
                  <label>Cari Produk</label>
                    <div class="input-group margin">
                        <input type="text" name="search" placeholder="Masukkan Kode / Nama Produk" class="form-control">
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-info btn-flat">Search</button>
                            </span>
                    </div>             
        </form>
        </div>
    </div> <!-- col -->   
    <div class="col-md-8">  
    	<h1>Notifikasi Minimal Stok Produk</h1>
      <p>Halaman ini bertujuan memberikan <strong>pemberitahuan</strong> pada halaman Produk ketika mencapai angka minimal</p>
  </div>
</div><!-- row -->  
<hr>
<div class="clearfix"></div>
<?php if ($totalRows_search > 0) { ?>
<div class="row">
  <div class="col-md-4">
        <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
          <table width="100%" height="168" class="table table-striped table-condensed">
            <tr valign="baseline">
              <td width="8%" align="right" valign="top" nowrap="nowrap"><strong>Barcode</strong></td>
              <td width="1%" align="right" nowrap="nowrap">&nbsp;</td>
              <td width="91%"><?php echo $row_search['kodeproduk']; ?></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="top" nowrap="nowrap"><strong>Nama Produk</strong></td>
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><?php echo $row_search['namaproduk']; ?></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="top" nowrap="nowrap"><strong>Stok Terkini</strong></td>
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><?php echo $row_search['stok']; ?></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="top" nowrap="nowrap"><strong>Jumlah</strong></td>
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><input type="number" name="qty" value="" size="32" class="form-control"/></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="top" nowrap="nowrap"><strong>Catatan </strong></td>
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td> <textarea name="ket" id="ket" cols="45" rows="5" class="form-control"></textarea></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="top" nowrap="nowrap">&nbsp;</td>
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><input type="submit" value="Set" class="btn btn-lg btn-warning btn-block"/></td>
            </tr>
          </table>
          <input type="hidden" name="produkID" value="<?php echo $row_search['idproduk']; ?>" />
          <input type="hidden" name="barcode" value="<?php echo $row_search['kodeproduk']; ?>" />
          <input type="hidden" name="namaproduk" value="<?php echo $row_search['namaproduk']; ?>" />
          <input type="hidden" name="MM_update" value="form2" />
        </form> 
  </div>
  
</div>
 <?php }else{ 
				danger('Oops!','Kami tidak menemukan kata kunci tersebut');
			}
 ?>