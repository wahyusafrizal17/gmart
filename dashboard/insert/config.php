<?php  

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tb_config SET title=%s, deskripsi=%s, header=%s, footer=%s, text1=%s, text2=%s, text3=%s WHERE id_config=%s",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['deskripsi'], "text"),
                       GetSQLValueString($_POST['header'], "text"),
                       GetSQLValueString($_POST['footer'], "text"),
                       GetSQLValueString($_POST['text1'], "text"),
                       GetSQLValueString($_POST['text2'], "text"),
                       GetSQLValueString($_POST['text3'], "text"),
                       GetSQLValueString($_POST['id_config'], "int"));

  //mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(errorQuery(mysql_error()));
}

//mysql_select_db($database_koneksi, $koneksi);
$query_rs_config = "SELECT * FROM tb_config WHERE id_config = 1";
$rs_config = mysql_query($query_rs_config, $koneksi) or die(errorQuery(mysql_error()));
$row_rs_config = mysql_fetch_assoc($rs_config);
$totalRows_rs_config = mysql_num_rows($rs_config);
?>
<div class="table-responsive">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">

  <table width="100%" height="513">
    <tr valign="baseline">
      <td><div align="left"><strong>Title Web</strong></div>
        <input type="text" name="title" value="<?php echo htmlentities($row_rs_config['title'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Deskripsi Website</strong></div>
        <input type="text" name="deskripsi" value="<?php echo htmlentities($row_rs_config['deskripsi'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Header</strong></div>
        <input type="text" name="header" value="<?php echo htmlentities($row_rs_config['header'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Footer</strong></div>
        <input type="text" name="footer" value="<?php echo htmlentities($row_rs_config['footer'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control input-sm"/></td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Text #1</strong></div>
        <textarea name="text1" cols="50" rows="3" class="form-control input-sm" ><?php echo htmlentities($row_rs_config['text1'], ENT_COMPAT, 'utf-8'); ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Text #2</strong></div>
        <textarea name="text2" cols="50" rows="3" class="form-control input-sm" id="editor1"><?php echo htmlentities($row_rs_config['text2'], ENT_COMPAT, 'utf-8'); ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td><div align="left"><strong>Text #3</strong></div>
        <textarea name="text3" cols="50" rows="3" class="form-control input-sm"><?php echo htmlentities($row_rs_config['text3'], ENT_COMPAT, 'utf-8'); ?></textarea>      </td>
    </tr>
    <tr valign="baseline">
      <td><input type="submit" value="Simpan Perubahan" class="btn btn-warning btn-block" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_config" value="<?php echo $row_rs_config['id_config']; ?>" />
</form> 
</div>