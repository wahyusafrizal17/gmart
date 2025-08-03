<?php  
require_once('izin.php');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  //JIKA QTY < STOK)
  //if ($_POST['qty'] < $_POST['oldstok']) {
  $insertSQL = sprintf("INSERT INTO stok (status, qty, oldStok, produkID, barcode, namaproduk, ket, added, addby, tastok) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString('T', "text"),
                       GetSQLValueString($_POST['qty'], "int"),
					   GetSQLValueString($_POST['oldstok'], "int"),
                       GetSQLValueString($_POST['produkID'], "int"),
                       GetSQLValueString($_POST['barcode'], "text"),
                       GetSQLValueString($_POST['namaproduk'], "text"),
					   GetSQLValueString($_POST['ket'], "text"),
					   GetSQLValueString(time(), "text"),
					   GetSQLValueString($ID, "text"),
					   GetSQLValueString($ta, "text"));

  mysqli_select_db($database_koneksi, $koneksi);
  $Result1 = mysqli_query($insertSQL, $koneksi) or die(mysqli_error());
  
  $stokSQL = sprintf("UPDATE produk SET stok = stok + %s WHERE idproduk=%s",
                       GetSQLValueString($_POST['qty'], "int"),
					   GetSQLValueString($_POST['produkID'], "int"));
  mysqli_select_db($database_koneksi, $koneksi);
  $StokResult1 = mysqli_query($stokSQL, $koneksi) or die(mysqli_error());
  
  
}

$colname_search = "--1";
if (isset($_GET['search'])) {
  $colname_search = $_GET['search'];
}
mysqli_select_db($database_koneksi, $koneksi);
$query_search = sprintf("SELECT * FROM produk WHERE kodeproduk = %s OR namaproduk LIKE %s", GetSQLValueString($colname_search, "text"), GetSQLValueString("%" . $colname_search . "%", "text"));
$search = mysqli_query($query_search, $koneksi) or die(mysqli_error());
$row_search = mysqli_fetch_assoc($search);
$totalRows_search = mysqli_num_rows($search);


mysqli_select_db($database_koneksi, $koneksi);
$query_history = sprintf("SELECT stok.*, vw_login.Nama FROM stok 
LEFT JOIN vw_login ON addby = ID 
WHERE barcode = %s OR namaproduk LIKE %s ORDER BY id_stok DESC", GetSQLValueString($colname_search, "text"), GetSQLValueString("%" . $colname_search . "%", "text"));
$history = mysqli_query($query_history, $koneksi) or die(mysqli_error());
$row_history = mysqli_fetch_assoc($history);
$totalRows_history = mysqli_num_rows($history);
?>
<div class="row">
    <div class="col-md-3">  
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
    <div class="col-md-9">  
    	<h1>Penambahan Stok</h1>
        <p>Anda berada pada halaman penambahan stok, dimana stok produk akan bertambah setelah di eksekusi</p>
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
          <input type="hidden" name="oldstok" value="<?php echo $row_search['stok']; ?>" />
          
          <input type="hidden" name="namaproduk" value="<?php echo $row_search['namaproduk']; ?>" />
          <input type="hidden" name="MM_insert" value="form2" />
        </form> 
  </div>
    <div class="col-md-8">
    	<?php title('success','History','Daftar Riyawat Penambahan Produk');?>
        <?php if ($totalRows_history > 0) { ?>
        <div class="table-responsive">
    	<table width="100%" class="table table-sm table-striped table-hover" id="example1">
        <thead>
          <tr>
            <th><div align="center">NO.</div></th>
            <th><div align="center">PRODUK</div></th>
            <th><div align="center">QTY</div></th>
            <th><div align="center">KETERANGAN</div></th>
          </tr>
          </thead>
          <tbody>
          <?php $no = 1; do { ?>
          <tr>
            <td align="center" valign="middle"><?php echo $no++; ?></td>
            <td><p style="font-size:20px">(<?php echo $row_history['barcode']; ?>) <?php echo $row_history['namaproduk']; ?></p> 
            #<?php echo $row_history['added']; ?> #<?php echo $row_history['Nama']; ?>            </td>
            <td><?php if ($row_history['status'] == 'T') {
					echo "<div class='btn btn-success'>Penambahan Stok (+".$row_history['qty'].")</div>";
				}else{
					echo "<div class='btn btn-danger'>Pengurangan Stok (-".$row_history['qty'].")</div>";
				} ?>
                <br /></td>
            <td><?php echo $row_history['ket']; ?></td>
          </tr>
          <?php } while ($row_history = mysqli_fetch_assoc($history)); ?>
          </tbody>
        </table>
      </div>
        <?php }else{ 
				danger('Oops!','History belum ada');
			}
		?>
  </div>
</div>
 <?php }else{ 
				danger('Oops!','Kami tidak menemukan kata kunci tersebut');
			}
 ?>