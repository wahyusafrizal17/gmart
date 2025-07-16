<?php
require_once('Connections/koneksi.php');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  //cek table master
  //mysql_select_db($database_koneksi, $koneksi);
  $rs_sql = sprintf(
    "SELECT id_master FROM tb_master WHERE id_master = %s",
    GetSQLValueString($_POST['key'], "int")
  );

  $sql = mysqli_query($koneksi, $rs_sql) or die(errorQuery(mysqli_error($koneksi)));
  $cek = mysqli_num_rows($sql);
  // Hash the new password using PHP's password_hash()
  $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
  //jika ada maka edit password master
  if ($cek > 0) {
    $updateSQL = sprintf(
      "UPDATE tb_master SET Password=%s WHERE id_master=%s",
      GetSQLValueString($hashedPassword, "text"),
      GetSQLValueString($_POST['key'], "int")
    );

    //mysql_select_db($database_koneksi, $koneksi);
    $Result1 = mysqli_query($koneksi, $updateSQL) or die(errorQuery(mysqli_error($koneksi)));

    if ($Result1) {
      pesanlink('Password successfully changed', 'login.php');
    }
    //jika tidak ada maka cek tabel admin	  
  }

  //mysql_select_db($database_koneksi, $koneksi);
  $rs_sql = sprintf(
    "SELECT id_admin FROM tb_admin WHERE id_admin = %s",
    GetSQLValueString($_POST['key'], "int")
  );

  $sql = mysqli_query($koneksi, $rs_sql) or die(errorQuery(mysqli_error($koneksi)));
  $cek = mysqli_num_rows($sql);

  //jika ada maka edit password admin		
  if ($cek > 0) {
    $updateSQL = sprintf(
      "UPDATE tb_admin SET Password=%s WHERE id_admin=%s",
      GetSQLValueString($hashedPassword, "text"),
      GetSQLValueString($_POST['key'], "int")
    );

    //mysql_select_db($database_koneksi, $koneksi);
    $Result1 = mysqli_query($koneksi, $updateSQL) or die(errorQuery(mysqli_error($koneksi)));

    if ($Result1) {
      pesanlink('Password successfully changed', 'login.php');
    }
  }

  //jika tidak ada maka cek tabel peserta	  
  //mysql_select_db($database_koneksi, $koneksi);
  $rs_sql = sprintf(
    "SELECT id_kassa FROM kassa WHERE id_kassa = %s",
    GetSQLValueString($_POST['key'], "int")
  );

  $sql = mysqli_query($koneksi, $rs_sql) or die(errorQuery(mysqli_error($koneksi)));
  $cek = mysqli_num_rows($sql);

  //jika ada maka edit password admin		
  if ($cek > 0) {
    $updateSQL = sprintf(
      "UPDATE kassa SET pwd_kassa=%s WHERE id_kassa=%s",
      GetSQLValueString($hashedPassword, "text"),
      GetSQLValueString($_POST['key'], "int")
    );

    //mysql_select_db($database_koneksi, $koneksi);
    $Result1 = mysqli_query($koneksi, $updateSQL) or die(errorQuery(mysqli_error($koneksi)));

    if ($Result1) {
      pesanlink('Password successfully changed', 'login.php');
    }
  } else {
    danger('Oops!', 'Oops! We did not find your account. You will be wrong or forget it later!');
  }
}

$colname_search = "-1";
$colname_Login = "-1";
if (isset($_POST['search'])) {
  $colname_search = $_POST['search'];
  $colname_Login = $_POST['Login'];
}
//mysql_select_db($database_koneksi, $koneksi);
$query_search = sprintf(
  "SELECT `ID`, `Key`, `Login`, `Nama` FROM vw_login WHERE Login = %s AND `Key` = %s ",
  GetSQLValueString($colname_search, "text"),
  GetSQLValueString($colname_Login, "text")
);
$search = mysqli_query($koneksi, $query_search) or die(errorQuery(mysqli_error($koneksi)));
$row_search = mysqli_fetch_assoc($search);
$totalRows_search = mysqli_num_rows($search);

require_once('require/header.php');
?>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="welcome.php"><b>Forgot</b>Password</a>
    </div>
    <!-- /.login-logo -->

    <!-- Horizontal Form -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Enter your Username & Key here</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form id="form1" name="form1" method="post" action="" class="form-horizontal">
        <div class="box-body">
          <div class="form-group">
            <label for="Username" class="col-sm-3 control-label">Username</label>

            <div class="col-sm-9">
              <input type="text" name="search" class="form-control" id="Username" placeholder="Username">
            </div>
          </div>
          <div class="form-group">
            <label for="Key" class="col-sm-3 control-label">Key</label>

            <div class="col-sm-9">
              <input type="text" name="Login" class="form-control" id="Key" placeholder="Password">
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a class="btn btn-default pull-left" href="login.php">Cancel</a>
          <button type="submit" name="button" class="btn btn-info pull-right">Search</button>
        </div>
        <!-- /.box-footer -->
      </form>
    </div>
    <!-- /.box -->


    <?php if ((isset($_POST['search'])) && ($totalRows_search == 0)) { // Show if recordset empty 
    ?>
      <p class="callout callout-danger animated slideInDown">Account not found</p>
    <?php } // Show if recordset empty 
    ?>
    <?php if ($totalRows_search > 0) { // Show if recordset not empty 
    ?>
      <div class="box  animated tada">
        <div class="box-body">
          <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
            <table height="158" align="center">
              <tr valign="baseline">
                <td colspan="2">
                  <div align="center">Please enter your new password.<br>
                    <?= $row_search['Nama']; ?>
                  </div>
                </td>
              </tr>
              <tr valign="baseline">
                <td height="54" colspan="2">
                  <div align="center"><strong>New Password</strong></div>
                  <input type="password" name="password" value="" size="32" class="form-control" required />
                </td>
              </tr>
              <tr valign="baseline">
                <td valign="bottom"><input type="submit" value="Change Passsword" class="btn btn-primary btn-block" /></td>
                <td valign="bottom">
                  <div align="right"><a href="login.php" class="btn btn-warning">Back to Home</a></div>
                </td>
              </tr>
            </table>
            <input type="hidden" name="MM_update" value="form2" />
            <input type="hidden" name="key" value="<?php echo $row_search['ID']; ?>" />
          </form>
        </div>
      </div>
    <?php } // Show if recordset not empty 
    ?>

  </div>

</body>

</html>