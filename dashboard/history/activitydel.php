<?php 
require_once('izin.php');

// Build deletion activity list (replaces missing history/activitydel1.php)
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
            "SELECT d.url, v.Nama, d.datetime FROM activity_delete d 
            LEFT JOIN vw_login v ON d.oleh = v.ID 
            WHERE d.url LIKE %s OR v.Nama LIKE %s 
            ORDER BY d.id DESC",
            GetSQLValueString("%" . $colname . "%", "text"),
            GetSQLValueString("%" . $colname . "%", "text")
        );
    }else{
        $query_Produk = "SELECT d.url, v.Nama, d.datetime FROM activity_delete d LEFT JOIN vw_login v ON d.oleh = v.ID ORDER BY d.id DESC";
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
          <h3 class="box-title"><i class="fa fa-tag"></i> LIST HISTORY PENGHAPUSAN DATA</h3>
        </div>
        <div class="box-body">
        
        <div class="row">
                                            <form method="get">
                                                <div class="col-md-10">
                                                  <input type="text" name="cari" class="form-control" placeholder="Masukkan Kata Kunci URL / Nama">
                                                </div>
                                                 
                                                <div class="col-md-2">
                                                  <button type="submit" class="btn btn-primary btn-block"><span class="fa fa-search"></span> Search</button>
                                                  <input type="hidden" name="page" value="history/activitydel">
                                                </div>
                                                
                                             </form>     
                                      </div>
                                      <br />
          <div class="row">
             <div class="col-md-12">
             <div class="table-responsive">
               <table width="100%" class="table table-striped">
                 <tr>
                   
                   <th><div align="center"><strong>URL</strong></div></th>
                   <th><div align="center"><strong>NAMA</strong></div></th>
                   <th><div align="center"><strong>#</strong></div></th>
                 </tr>
                 <?php $no = 1; do { ?>
                 <tr>
                   
                   <td><?php echo $row_Produk['url']; ?></td>
                   <td><?php echo $row_Produk['Nama']; ?></td>
                   <td><?php echo $row_Produk['datetime']; ?></td>
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

 
 
