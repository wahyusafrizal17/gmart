<?php require_once('Connections/koneksi.php'); ?>
<?php

//site
////mysqli_select_db($database_koneksi);
$query_rs_optionx = "SELECT email_member FROM tb_member WHERE email_member = '$_POST[email]'";
$rs_optionx = mysqli_query($koneksi, $query_rs_optionx) or die(errorQuery(mysqli_error()));
$jml = mysqli_num_rows($rs_optionx);
echo $jml;


?>