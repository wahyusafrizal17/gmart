<?php
$currentPage = $_SERVER["PHP_SELF"];
	 
	$maxRows_Terlaris = 10;
	$pageNum_Terlaris = 0;
	if (isset($_GET['pageNum_Terlaris'])) {
	  $pageNum_Terlaris = $_GET['pageNum_Terlaris'];
	}
	$startRow_Terlaris = $pageNum_Terlaris * $maxRows_Terlaris;
	
	$colname = "-1";
	if (isset($_GET['carilaris'])) {
		 $colname = $_GET['carilaris'];
		 //mysql_select_db($database_koneksi, $koneksi);
		$query_Terlaris = sprintf("SELECT nama, kode, count(nama) as JumlahProduk, sum(qty) as Jumlah FROM `transaksidetail` 
        WHERE nama LIKE %s OR kode = %s AND periode = %s GROUP BY nama ORDER BY JumlahProduk DESC",
        GetSQLValueString("%". $colname ."%", "text"),
        GetSQLValueString($colname, "text"),
        GetSQLValueString($ta, "text"));
	}else{
	//mysql_select_db($database_koneksi, $koneksi);
		$query_Terlaris = sprintf("SELECT nama, kode, count(nama) as JumlahProduk, sum(qty) as Jumlah FROM `transaksidetail` WHERE periode = %s GROUP BY nama ORDER BY JumlahProduk DESC",
        GetSQLValueString($ta, "text"));
	}	
	$query_limit_Terlaris = sprintf("%s LIMIT %d, %d", $query_Terlaris, $startRow_Terlaris, $maxRows_Terlaris);
	$Terlaris = mysqli_query($koneksi, $query_limit_Terlaris) or die(mysqli_error($koneksi));
	$row_Terlaris = mysqli_fetch_assoc($Terlaris);
	
	if (isset($_GET['totalRows_Terlaris'])) {
	  $totalRows_Terlaris = $_GET['totalRows_Terlaris'];
	} else {
	  $all_Terlaris = mysqli_query($koneksi, $query_Terlaris);
	  $totalRows_Terlaris = mysqli_num_rows($all_Terlaris);
	}
	$totalPages_Terlaris = ceil($totalRows_Terlaris/$maxRows_Terlaris)-1;
	
	$queryString_Terlaris = "";
	if (!empty($_SERVER['QUERY_STRING'])) {
	  $params = explode("&", $_SERVER['QUERY_STRING']);
	  $newParams = array();
	  foreach ($params as $param) {
		if (stristr($param, "pageNum_Terlaris") == false && 
			stristr($param, "totalRows_Terlaris") == false) {
		  array_push($newParams, $param);
		}
	  }
	  if (count($newParams) != 0) {
		$queryString_Terlaris = "&" . htmlentities(implode("&", $newParams));
	  }
	}
	$queryString_Terlaris = sprintf("&totalRows_Terlaris=%d%s", $totalRows_Terlaris, $queryString_Terlaris);
	 
?>