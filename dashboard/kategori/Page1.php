<?php
$currentPage = $_SERVER["PHP_SELF"];
	 
	$maxRows_Kategori = 10;
	$pageNum_Kategori = 0;
	if (isset($_GET['pageNum_Kategori'])) {
	  $pageNum_Kategori = $_GET['pageNum_Kategori'];
	}
	$startRow_Kategori = $pageNum_Kategori * $maxRows_Kategori;
	
	$colname_kategori = "-1";
	if (isset($_GET['kategori'])) {
		$colname_kategori = $_GET['kategori'];
	}
	$colname = "-1";
	if (isset($_GET['cari'])) {
		 $colname = $_GET['cari'];
		 //mysqli_select_db($database_koneksi, $koneksi);
		$query_Kategori = sprintf("SELECT `idproduk`, `namaproduk`, `kategori`, `deskproduk`, `hargadasar`, `hargajual`, `kodeproduk`, `minProduk`, `satuan`, `stok`, `statusproduk`, `addedproduk`, `updatedproduk`, `addbyproduk`, `alertproduk`, `namakategori`, vw_login.Nama FROM produk  LEFT JOIN kategori ON produk.kategori = kategori.idkategori 
		LEFT JOIN vw_login ON addbyproduk = ID 
		WHERE namaproduk LIKE %s OR namakategori = %s OR kodeproduk = %s AND  kategori = %s
		ORDER BY idproduk DESC", 
		GetSQLValueString("%". $colname ."%", "text"),		
		GetSQLValueString($colname, "text"),
		GetSQLValueString($colname, "text"),
		GetSQLValueString($colname_kategori, "int"));
	}else{
	//mysqli_select_db($database_koneksi, $koneksi);
		$query_Kategori =  sprintf("SELECT `idproduk`, `namaproduk`, `kategori`, `deskproduk`, `hargadasar`, `hargajual`, `kodeproduk`, `minProduk`, `satuan`, `stok`, `statusproduk`, `addedproduk`, `updatedproduk`, `addbyproduk`, `alertproduk`, `namakategori`, vw_login.Nama FROM produk  LEFT JOIN kategori ON produk.kategori = kategori.idkategori 
		LEFT JOIN vw_login ON addbyproduk = ID 
		WHERE kategori = %s ORDER BY idproduk DESC", 
		GetSQLValueString($colname_kategori, "int"));
	}	
	$query_limit_Kategori = sprintf("%s LIMIT %d, %d", $query_Kategori, $startRow_Kategori, $maxRows_Kategori);
	$rs_Kategori = mysqli_query($query_limit_Kategori, $koneksi) or die(mysqli_error());
	$row_Kategori = mysqli_fetch_assoc($rs_Kategori);
	
	if (isset($_GET['totalRows_Kategori'])) {
	  $totalRows_Kategori = $_GET['totalRows_Kategori'];
	} else {
	  $all_Kategori = mysqli_query($query_Kategori, $koneksi);
	  $totalRows_Kategori = mysqli_num_rows($all_Kategori);
	}
	$totalPages_Kategori = ceil($totalRows_Kategori/$maxRows_Kategori)-1;
	
	$queryString_Kategori = "";
	if (!empty($_SERVER['QUERY_STRING'])) {
	  $params = explode("&", $_SERVER['QUERY_STRING']);
	  $newParams = array();
	  foreach ($params as $param) {
		if (stristr($param, "pageNum_Kategori") == false && 
			stristr($param, "totalRows_Kategori") == false) {
		  array_push($newParams, $param);
		}
	  }
	  if (count($newParams) != 0) {
		$queryString_Kategori = "&" . htmlentities(implode("&", $newParams));
	  }
	}
	$queryString_Kategori = sprintf("&totalRows_Kategori=%d%s", $totalRows_Kategori, $queryString_Kategori);
	 
?>