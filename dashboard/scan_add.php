<?php
session_start();
$message = "";
require_once('../Connections/koneksi.php');
$colname_search = $_GET['result'];
$faktur = $_GET['faktur'];
$query_search = sprintf(
	"SELECT * FROM produk WHERE stok > 0 AND (kodeproduk = %s OR namaproduk LIKE %s) LIMIT 10",
	GetSQLValueString($koneksi, $colname_search, "text"),
	GetSQLValueString($koneksi, "%" . $colname_search . "%", "text")
);
$search = mysqli_query($koneksi, $query_search) or die(mysqli_error($koneksi));
$row_search = mysqli_fetch_assoc($search);
$totalRows_search = mysqli_num_rows($search);

//JIKA HASIL PENCARIAN 1 PRODUK MAKA LANGSUNG SIMPAN
if ($totalRows_search == 1) {
	//require('faktur2.php');

	//SEBELUM ITU, DICEK JIKA PRODUK YG SAMA MAKA TAMBAHKAN STOK SAJA

	$cek =  sprintf(
		"SELECT kode, faktur, qty FROM transaksitemp WHERE kode = %s AND faktur = %s",
		GetSQLValueString($koneksi, $row_search['kodeproduk'], "text"),
		GetSQLValueString($koneksi, $faktur, "text")
	);
	$rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error($koneksi));
	$row_rs_cek = mysqli_fetch_assoc($rs_cek);
	$totalRows_rs_cek = mysqli_num_rows($rs_cek);

	if ($totalRows_rs_cek > 0) {
		//update / tambah qty produk
		if ($row_rs_cek['qty'] >= $row_search['stok']) {
			$message = $row_search['namaproduk'] . " - Stok terbatas!! Maks. " . $row_rs_cek['qty'] . ' ';
			
		} else {
			$stok = sprintf(
				"UPDATE transaksitemp SET qty = qty + 1 WHERE faktur = %s AND kode = %s",
				GetSQLValueString($koneksi, $faktur, "text"),
				GetSQLValueString($koneksi, $row_search['kodeproduk'], "text")
			);


			$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error($koneksi));
		}
	} else {
		//require('faktur.php');

		$userId = mysqli_fetch_array(mysqli_query($koneksi,"select ID,Nama from vw_login where Login='".$_SESSION['MM_Username']."'"));
		$insertSQL = sprintf(
			"INSERT INTO transaksitemp (`faktur`, `tanggal`, `kode`, `nama`, `harga`, `hargadasar`, `diskon`,`qty`, `added`, `addby`, `admintt`, `stt`, `periode`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($koneksi, $faktur, "text"),
			GetSQLValueString($koneksi, $today, "date"),
			GetSQLValueString($koneksi, $row_search['kodeproduk'], "text"),
			GetSQLValueString($koneksi, $row_search['namaproduk'], "text"),
			GetSQLValueString($koneksi, $row_search['hargajual'], "double"),
			GetSQLValueString($koneksi, $row_search['hargadasar'], "double"),
			GetSQLValueString($koneksi, 0, "double"),
			GetSQLValueString($koneksi, 1, "int"),
			GetSQLValueString($koneksi, time(), "int"),
			//GetSQLValueString($koneksi, $ID, "int"),
			GetSQLValueString($koneksi, $userId['ID'], "int"),
			// GetSQLValueString($koneksi, $nama, "text"),
			GetSQLValueString($koneksi, $userId['Nama'], "text"),
			GetSQLValueString($koneksi, $row_search['statusproduk'], "text"),
			GetSQLValueString($koneksi, $ta, "text")
		);

		// echo $insertSQL;
		// exit;


		$Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error($koneksi));
	} //tutup Cek Produk yg sudah ada	  
} //tutup pencarian produk


$query_trans = sprintf(
	"SELECT * FROM transaksitemp INNER JOIN produk ON kode = kodeproduk WHERE faktur = %s ORDER BY transaksitemp.id ASC",
	GetSQLValueString($koneksi, $faktur, "text")
);
$trans = mysqli_query($koneksi, $query_trans) or die(mysqli_error($koneksi));
$row_trans = mysqli_fetch_assoc($trans);
$totalRows_trans = mysqli_num_rows($trans);

header("location:/dashboard/welcome.php?page=scan/add&message=".$message);


?>