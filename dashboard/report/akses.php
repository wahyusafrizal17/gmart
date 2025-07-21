<?php 
require_once('../../logout.php');
require_once('../../restrict.php'); 
require_once('../../Connections/koneksi.php'); 

//SESI LOGIN
$colname_rs_login = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_login = $_SESSION['MM_Username'];
}
$query_rs_login = sprintf("SELECT * FROM vw_login WHERE Login = %s", GetSQLValueString($colname_rs_login, "text"));
$rs_login = mysqli_query($koneksi, $query_rs_login) or die(errorQuery(mysqli_error($koneksi)));
$row_rs_login = mysqli_fetch_assoc($rs_login);
$totalRows_rs_login = mysqli_num_rows($rs_login);

$ID = $row_rs_login['ID'];
$login = $row_rs_login['Login'];
$nama = $row_rs_login['Nama'];
$level = $row_rs_login['Level'];

/*
//----------- 26 desember - cabang ---
$cabang = $row_rs_login['Cabank'];
//$query_rs_cab = "SELECT * FROM tb_cabang WHERE id_cabang = '".$cabang."' LIMIT 1";
//$rs_cab = mysqli_query($koneksi, $query_rs_cab) or die(errorQuery(mysqli_error($koneksi)));
//$row_rs_cab = mysqli_fetch_assoc($rs_cab);
//$totalRows_rs_cab = mysqli_num_rows($rs_cab);

//$judulcab = $row_rs_cab['judul_cabang'];
//$alamatcab = $row_rs_cab['alamat_cabang'];
//$notelpcab = $row_rs_cab['notelp_cabang'];
*/

$query_rs_profile = "SELECT * FROM tb_admin WHERE id_admin = '".$ID."'";
$rs_profile = mysqli_query($koneksi, $query_rs_profile) or die(errorQuery(mysqli_error($koneksi)));
$row_rs_profile = mysqli_fetch_assoc($rs_profile);
$totalRows_rs_profile = mysqli_num_rows($rs_profile); 

?>