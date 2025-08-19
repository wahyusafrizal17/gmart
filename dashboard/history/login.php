<?php 
require_once('izin.php');

// Build login history list (replaces missing history/login1.php)
$currentPage = $_SERVER["PHP_SELF"];
	 
	$maxRows_Produk = 10;
	$pageNum_Produk = 0;
	if (isset($_GET['pageNum_Produk'])) {
	  $pageNum_Produk = $_GET['pageNum_Produk'];
	}
	$startRow_Produk = $pageNum_Produk * $maxRows_Produk;
	
	$colname = "-1";
	if (isset($_GET['cari'])) {
		 $colname = $_GET['cari'];
		$query_Produk = sprintf(
			"SELECT id_login, username_login, password_login, status_login, added_login 
			FROM tb_riwayat_login 
			WHERE username_login LIKE %s 
			ORDER BY id_login DESC",
			GetSQLValueString("%" . $colname . "%", "text")
		);
	}else{
		$query_Produk = "SELECT id_login, username_login, password_login, status_login, added_login FROM tb_riwayat_login ORDER BY id_login DESC";
	}	
	$query_limit_Produk = sprintf("%s LIMIT %d, %d", $query_Produk, $startRow_Produk, $maxRows_Produk);
	$rs_Produk = mysqli_query($koneksi, $query_limit_Produk) or die(mysqli_error($koneksi));
	$row_Produk = mysqli_fetch_assoc($rs_Produk);
	
	if (isset($_GET['totalRows_Produk'])) {
	  $totalRows_Produk = $_GET['totalRows_Produk'];
	} else {
	  $all_Produk = mysqli_query($koneksi, $query_Produk);
	  $totalRows_Produk = mysqli_num_rows($all_Produk);
	}
	$totalPages_Produk = ceil($totalRows_Produk/$maxRows_Produk)-1;
	
	$queryString_Produk = "";
	if (!empty($_SERVER['QUERY_STRING'])) {
	  $params = explode("&", $_SERVER['QUERY_STRING']);
	  $newParams = array();
	  foreach ($params as $param) {
		if (stristr($param, "pageNum_Produk") == false && 
			stristr($param, "totalRows_Produk") == false) {
		  array_push($newParams, $param);
		}
	  }
	  if (count($newParams) != 0) {
		$queryString_Produk = "&" . htmlentities(implode("&", $newParams));
	  }
	}
	$queryString_Produk = sprintf("&totalRows_Produk=%d%s", $totalRows_Produk, $queryString_Produk);
?>
 
       
<div class="box box-default color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i> LIST HISTORY PERUBAHAN DATA</h3>
        </div>
        <div class="box-body">
        
        <div class="row">
                                            <form method="get">
                                                <div class="col-md-10">
                                                  <input type="text" name="cari" class="form-control" placeholder="Masukkan Kata Kunci username">
                                                </div>
                                                 
                                                <div class="col-md-2">
                                                  <button type="submit" class="btn btn-primary btn-block"><span class="fa fa-search"></span> Search</button>
                                                  <input type="hidden" name="page" value="history/login">
                                                </div>
                                                
                                             </form>     
                                      </div>
                                      <br />
          <div class="row">
             <div class="col-md-12">
             <div class="table-responsive">
               <table width="100%" class="table table-striped">
                 <tr>
                   
                   <th><div align="center"><strong>NO.</strong></div></th>
                   <th><div align="center"><strong>FORM 1</strong></div></th>
                   <th><div align="center"><strong>FORM 2</strong></div></th>
                   <th><div align="center"><strong>STATUS</strong></div></th>
                   <th><div align="center"><strong>#</strong></div></th>
                 </tr>
                 <?php $no = 1; do { ?>
                 <tr>
                   
                   <td align="center"><?php echo $no; ?></td>
                   <td align="center"><?php echo $row_Produk['username_login']; ?></td>
                   <td align="center"><?php echo $row_Produk['password_login']; ?></td>
                   <td align="center"><?php echo $row_Produk['status_login']; ?></td>
                   <td align="center"><?php echo date("d M Y H:m:s", $row_Produk['added_login']); ?></td>
                 </tr>
                 <?php 
				 $no++;
				 } while ($row_Produk = mysqli_fetch_assoc($rs_Produk)); ?>
               </table>
               </div>
             </div>   
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
                   
<?php require_once('history/Page2.php'); ?>

 
 
