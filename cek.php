<?php require_once('Connections/koneksi.php'); ?>
<?php

//site
//mysql_select_db($database_koneksi, $koneksi);
$query_rs_optionx = "SELECT email_member FROM tb_member WHERE email_member = '$_POST[email]'";
$rs_optionx = mysql_query($query_rs_optionx, $koneksi) or die(errorQuery(mysql_error()));
$jml = mysql_num_rows($rs_optionx);
echo $jml;


?>