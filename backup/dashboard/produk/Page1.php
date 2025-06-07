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
		 ////mysqli_select_db($database_koneksi);
		$query_Produk = sprintf("SELECT `idproduk`, `namaproduk`, `kategori`, `deskproduk`, `hargadasar`, `hargajual`, `kodeproduk`, `minProduk`, `satuan`, `stok`, `statusproduk`, `addedproduk`, `updatedproduk`, `addbyproduk`, `alertproduk`, `namakategori`, vw_login.Nama FROM produk  LEFT JOIN kategori ON produk.kategori = kategori.idkategori 
		LEFT JOIN vw_login ON addbyproduk = ID 
		WHERE namaproduk LIKE %s OR namakategori = %s OR kodeproduk = %s
		ORDER BY idproduk DESC", 
		GetSQLValueString($koneksi, "%". $colname ."%", "text"),		
		GetSQLValueString($koneksi, $colname, "text"),
		GetSQLValueString($koneksi, $colname, "text"));
	}else{
	////mysqli_select_db($database_koneksi);
		$query_Produk = "SELECT `idproduk`, `namaproduk`, `kategori`, `deskproduk`, `hargadasar`, `hargajual`, `kodeproduk`, `minProduk`, `satuan`, `stok`, `statusproduk`, `addedproduk`, `updatedproduk`, `addbyproduk`, `alertproduk`, `namakategori`, vw_login.Nama FROM produk  LEFT JOIN kategori ON produk.kategori = kategori.idkategori 
		LEFT JOIN vw_login ON addbyproduk = ID ORDER BY idproduk DESC";
	}	
	$query_limit_Produk = sprintf("%s LIMIT %d, %d", $query_Produk, $startRow_Produk, $maxRows_Produk);
	$rs_Produk = mysqli_query($koneksi, $query_limit_Produk) or die(mysqli_error());
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