<?php
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
		 //mysql_select_db($database_koneksi, $koneksi);
		$query_Produk = sprintf("SELECT url, datetime, vw_login.Nama FROM activity_update
		LEFT JOIN vw_login ON oleh = vw_login.ID 
		WHERE url LIKE %s OR vw_login.Nama LIKE %s
		ORDER BY vw_login.ID DESC", 
		GetSQLValueString("%". $colname ."%", "text"),		
		GetSQLValueString("%". $colname ."%", "text"));
	}else{
	//mysql_select_db($database_koneksi, $koneksi);
		$query_Produk = "SELECT url, datetime, vw_login.Nama FROM activity_update
		LEFT JOIN vw_login ON oleh = vw_login.ID ";
	}	
	$query_limit_Produk = sprintf("%s LIMIT %d, %d", $query_Produk, $startRow_Produk, $maxRows_Produk);
	$rs_Produk = mysql_query($query_limit_Produk, $koneksi) or die(mysql_error());
	$row_Produk = mysql_fetch_assoc($rs_Produk);
	
	if (isset($_GET['totalRows_Produk'])) {
	  $totalRows_Produk = $_GET['totalRows_Produk'];
	} else {
	  $all_Produk = mysql_query($query_Produk, $koneksi);
	  $totalRows_Produk = mysql_num_rows($all_Produk);
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