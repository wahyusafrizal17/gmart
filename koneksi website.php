<?php
error_reporting(E_ALL ^ E_DEPRECATED);
//require_once('parser-php-version.php');
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

$hostname_koneksi = "localhost";
$database_koneksi = "gmartmyi_pos";
$username_koneksi = "gmartmyi_gmart";
$password_koneksi = "Akun1111@123";
$koneksi = mysqli_connect($hostname_koneksi, $username_koneksi, $password_koneksi);
mysqli_select_db($database_koneksi, $koneksi);


//TANGGAL
date_default_timezone_set('Asia/Jakarta');
$tanggal = mktime(date("m"), date("d"), date("Y"));
$bulan = date("m");
$hari = date("d");
$tglsekarang = date("Y-m-d", $tanggal);
$today = date("Y-m-d H:i:s");
$pukul = date("H:i:s");
$tahun = date("Y");
$thn = substr($tahun, 2);
$jam = date("H");
$menit = date("i");
$detik = date("s");
$kodeacak = substr(time(), 0);
$setAngka = 10;

//SET NAMA PIMPINAN
$kota = "Solok";
$pimpinan = "Ghalih Mandaveqia";
$jabatan = "OWNER";

//PESAN
function title($class, $judul, $isi)
{
	echo "<div class='animated fadeIn callout callout-" . $class . "'>
	<h4>" . $judul . "</h4>
	" . $isi . "</div>";
}

function titlePreview($judul, $isi)
{
	echo "<div class='animated fadeIn callout callout-info'>
	<h4>" . $judul . "</h4>
	" . $isi . "</div>";
}

function titleTampil($judul, $judul2)
{
	echo "<div class='animated fadeIn callout callout-success'>
	<h4><strong>" . $judul . "</strong></h4>
	Berikut ini adalah daftar " . $judul2 . " yang telah dientry</div>";
}

function titleSimpan($judul, $judul2)
{
	echo "<div class='animated fadeIn callout callout-success'>
	<h4><strong>" . $judul . "</strong></h4>
	Silahkan entry data " . $judul2 . " dengan sebenarnya</div>";
}

function titleUpdate($judul, $judul2)
{
	echo "<div class='animated fadeIn callout callout-info'>
	<h4><strong>" . $judul . "</strong></h4>
	Silahkan update data " . $judul2 . " dengan sebenarnya</div>";
}

function informasi($isi)
{
	echo "<div class='animated flash callout callout-info'>
	<h4>Informasi</h4>
	" . $isi . "</div>";
}

function warning($isi)
{
	echo "<div class='animated flash callout callout-warning'>
	<h4>Warning!</h4>
	" . $isi . "</div>";
}

function danger($judul, $isi)
{
	echo "<div class='animated flash callout callout-danger'>
	<h4><strong>" . $judul . "</strong></h4>
	" . $isi . "</div>";
}


function gagal($isi)
{
	echo "<div class='animated flash callout callout-danger'>
	<h4><strong>Oops!</strong></h4>
	" . $isi . "</div>";
}

function sukses($isi)
{
	echo "<div class='animated flash callout callout-success'>
	<h4><strong>Berhasil!</strong></h4>
	" . $isi . "</div>";
}


function pesanlink($title, $arahkan)
{
	echo "<script>
	alert('" . $title . "');
	document.location = '" . $arahkan . "';
	</script>";
}

function refresh($arahkan)
{
	echo "<script>
	document.location = '" . $arahkan . "';
	</script>";
}

function errorQuery($isi)
{
	back();
	echo "<br>";
	echo "<br>";
	echo "<div class='animated flash callout callout-danger'>
	<h4><span class='fa fa-warning'></span><strong> Kesalahan</strong></h4>
	<strong>Pesan Kesalahan : </strong>" . $isi . "</div>";
}

$fungsi = function ($row, $var1, $var2) {
	echo "<div class='btn-group'>
                  <button type='button' class='btn btn-primary btn-sm'><span class='fa fa-cog'></span></button>
                  <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown'>
                    <span class='caret'></span>
                    <span class='sr-only'>Toggle Dropdown</span>
                  </button>
                  <ul class='dropdown-menu' role='menu'>
                    <li><a href='?page=" . $var1 . "/update&id_" . $var2 . "=" . $row . "' onClick='return confirm(\"Anda yakin ingin mengubah data ini?\");'><span class='fa fa-edit'></span> Update</a></li>
                    <li><a href='?page=" . $var1 . "/delete&id_" . $var2 . "=" . $row . "' onClick='return confirm(\"Anda yakin ingin menghapus data ini?\");'><span class='fa fa-trash'></span> Delete</a></li>
                  </ul>
                </div>";
};

$fungsiUpdate = function ($row, $var1, $var2) {
	echo "<div class='btn-group'>
                  <button type='button' class='btn btn-primary btn-sm'>Action</button>
                  <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown'>
                    <span class='caret'></span>
                    <span class='sr-only'>Toggle Dropdown</span>
                  </button>
                  <ul class='dropdown-menu' role='menu'>
                    <li><a href='?page=" . $var1 . "/update&" . $var2 . "=" . $row . "'><span class='fa fa-edit'></span> Update</a></li>
                  </ul>
                </div>";
};

$fungsiDelete = function ($row, $var1, $var2) {
	echo "<div class='btn-group'>
                  <button type='button' class='btn btn-primary btn-sm'>Action</button>
                  <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown'>
                    <span class='caret'></span>
                    <span class='sr-only'>Toggle Dropdown</span>
                  </button>
                  <ul class='dropdown-menu' role='menu'>
                    <li><a href='?page=" . $var1 . "/delete&" . $var2 . "=" . $row . "'><span class='fa fa-trash'></span> Delete</a></li>
                  </ul>
                </div>";
};

$fungsiDetail = function ($row, $var1, $var2) {
	echo "<div class='btn-group'>
                  <button type='button' class='btn btn-primary btn-sm'>Action</button>
                  <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown'>
                    <span class='caret'></span>
                    <span class='sr-only'>Toggle Dropdown</span>
                  </button>
                  <ul class='dropdown-menu' role='menu'>
                    <li><a href='?page=" . $var1 . "/update&id_" . $var2 . "=" . $row . "'><span class='fa fa-edit'></span> Update</a></li>
                    <li><a href='?page=" . $var1 . "/delete&id_" . $var2 . "=" . $row . "'><span class='fa fa-trash'></span> Delete</a></li>
					<li><a href='?page=" . $var1 . "/detail&id_" . $var2 . "=" . $row . "'><span class='fa fa-list'></span> Detail</a></li>
                  </ul>
                </div>";
};
function back()
{
	echo '<button onclick="window.history.go(-1); return false;" class="btn btn-warning btn-sm"><span class="fa fa-arrow-left"></span> Go Back</button>';
}

function kembali($alamat)
{
	echo '<a href="' . $alamat . '" class="btn btn-warning btn-sm"><span class="fa fa-arrow-left"></span> Kembali</button>';
}

function addNew($page, $icon)
{
	if ($_GET['page'] != $page) {
		echo '<a href="?page=' . $page . '" class="btn btn-sm btn-success"><span class="fa fa-' . $icon . '"></span> Add New</a>';
	}
}

function btnSubmit($icon, $teks)
{
	echo '<button type="submit" class="btn btn-sm btn-success"><span class="fa fa-' . $icon . '"></span> ' . $teks . '</button> &nbsp;';
	echo '<button type="reset" class="btn btn-sm btn-danger"><span class="fa fa-refresh"></span> Reset</button> &nbsp;';
	//back();
}

function Tanggal($var1, $var2 = 0)
{
	if ($var2 > 0) {
		$tgl = date('Y-m-d', strtotime('+' . $var2 . ' days', strtotime($var1)));
	} else {
		$tgl = date("d - F - Y", strtotime($var1));
	}
	echo $tgl;
}

function KodeUrut($var1, $var2)
{
	$no = 1;
	if ($var1 == 0) {
		echo sprintf("%05s", $no);
	} elseif ($var1 > 0) {
		$no = $var2;
		echo sprintf("%05s", $no + 1);
	}
}

function KodeTemp($var1, $var2)
{
	$no = 1;
	if ($var1 == 0) {
		return sprintf("%05s", $no);
	} elseif ($var1 > 0) {
		$no = $var2;
		return sprintf("%05s", $no + 1);
	}
}

//LINK
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//SANITASI
if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
	{
		$theValue = false ? stripslashes($theValue) : $theValue;

		$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : addslashes($theValue);

		switch ($theType) {
			case "text":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "long":
			case "int":
				$theValue = ($theValue != "") ? intval($theValue) : "NULL";
				break;
			case "double":
				$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
				break;
			case "date":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "defined":
				$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				break;
		}
		return $theValue;
	}
}

//MENAMPILKAN DEFAULT WEB
//mysqli_select_db($database_koneksi, $koneksi);
$query_rs_config = "SELECT * FROM tb_config";
$rs_config = mysqli_query($query_rs_config, $koneksi) or die(errorQuery(mysqli_error()));
$row_rs_config = mysqli_fetch_assoc($rs_config);
$totalRows_rs_config = mysqli_num_rows($rs_config);

$title = $row_rs_config['title'];
$deskripsi = $row_rs_config['deskripsi'];
$header = $row_rs_config['header'];
$footer = $row_rs_config['footer'];
$text1 = $row_rs_config['text1'];
$text2 = $row_rs_config['text2'];
$text3 = $row_rs_config['text3'];

//TAHUN PERIODE AKADEMIK
//mysqli_select_db($database_koneksi, $koneksi);
$query_rs_tap = "SELECT * FROM tb_ta WHERE id_ta = 1";
$rs_tap = mysqli_query($query_rs_tap, $koneksi) or die(errorQuery(mysqli_error()));
$row_rs_tap = mysqli_fetch_assoc($rs_tap);
$totalRows_rs_tap = mysqli_num_rows($rs_tap);
$ta = $row_rs_tap['kode_ta'];

//FUNCTION UPLOAD PHOTO
//UPLOAD PHOTO PLUS COMPRESS
function upload($kurir, $name)
{

	$tempdir = "photos/";
	if (!file_exists($tempdir)) mkdir($tempdir, 0755);

	$namaFile = $_FILES[$name]['name'];
	$ukuranFile = $_FILES[$name]['size'];
	$error = $_FILES[$name]['error'];
	$tmpName = $_FILES[$name]['tmp_name'];


	if ($error === 4) {
		danger('Oops!', 'Oops! Gambar masih kosong <button onclick="window.history.go(-1); return false;" class="btn btn-primary btn-sm"><span class="fa fa-arrow-left"></span> Kembali</button>');
		return false;
	}

	//cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'PNG', 'JPEG', 'JPG'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));

	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
		echo "<script>
				alert('File yang diupload bukan gambar!!');
			</script>";
		return false;
	}

	if ($ukuranFile > 9999999999999) {
		echo "<script>
				alert('Ukuran file terlalu besar, minimal < 1 MB');
			</script>";
		//return false;
	}

	//rename file gambar
	$namaFileBaru =	$kurir;
	$namaFileBaru .= uniqid();
	$namaFileBaru .= ".";
	$namaFileBaru .= $ekstensiGambar;



	$info = getimagesize($tmpName);
	if ($info['mime'] == 'image/jpeg')
		$image = imagecreatefromjpeg($tmpName);
	elseif ($info['mime'] == 'image/gif')
		$image = imagecreatefromgif($tmpName);
	elseif ($info['mime'] == 'image/png')
		$image = imagecreatefrompng($tmpName);

	$target_path = $tempdir . basename($namaFileBaru);

	imagejpeg($image, $target_path, 10);

	return $namaFileBaru;
}

//UPLOAD PHOTO PLUS COMPRESS
function uploadPhoto($kurir, $name)
{

	$tempdir = "photos/";
	if (!file_exists($tempdir)) mkdir($tempdir, 0755);

	$namaFile = $_FILES[$name]['name'];
	$ukuranFile = $_FILES[$name]['size'];
	$error = $_FILES[$name]['error'];
	$tmpName = $_FILES[$name]['tmp_name'];


	if ($error === 4) {
		danger('Oops!', 'Oops! Gambar masih kosong <button onclick="window.history.go(-1); return false;" class="btn btn-primary btn-sm"><span class="fa fa-arrow-left"></span> Kembali</button>');
		return false;
	}

	//cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'PNG', 'JPEG', 'JPG'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));

	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
		echo "<script>
				alert('File yang diupload bukan gambar!!');
			</script>";
		return false;
	}

	if ($ukuranFile > 9999999999999) {
		echo "<script>
				alert('Ukuran file terlalu besar, minimal < 1 MB');
			</script>";
		//return false;
	}

	//rename file gambar
	$namaFileBaru =	$kurir;
	$namaFileBaru .= uniqid();
	$namaFileBaru .= ".";
	$namaFileBaru .= $ekstensiGambar;



	$info = getimagesize($tmpName);
	if ($info['mime'] == 'image/jpeg')
		$image = imagecreatefromjpeg($tmpName);
	elseif ($info['mime'] == 'image/gif')
		$image = imagecreatefromgif($tmpName);
	elseif ($info['mime'] == 'image/png')
		$image = imagecreatefrompng($tmpName);

	$target_path = $tempdir . basename($namaFileBaru);

	imagejpeg($image, $target_path, 10);

	return $namaFileBaru;
}

//UPLOAD UNTUK ADMIN

//---------

function photopos($name)
{

	$namaFile = $_FILES[$name]['name'];
	$ukuranFile = $_FILES[$name]['size'];
	$error = $_FILES[$name]['error'];
	$tmpName = $_FILES[$name]['tmp_name'];
	//cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'PNG', 'JPEG', 'JPG'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));

	/* if ( !in_array($ekstensiGambar, $ekstensiGambarValid)) {
		echo "<script>
				alert('File yang diupload bukan gambar!!');
			</script>";
		return false;	
	} */

	if ($ukuranFile > 1000000) {
		echo "<script>
				alert('Ukuran file terlalu besar, minimal < 1 MB');
			</script>";
		//return false;
	}

	//rename file gambar
	if ($error !== 4) {

		$namaFileBaru = uniqid();
		$namaFileBaru .= ".";
		$namaFileBaru .= $ekstensiGambar;

		move_uploaded_file($tmpName, '../photo_pos/' . $namaFileBaru);

		return $namaFileBaru;
	}
}


//FUNCTION UPLOAD PHOTO
function feature_image($name)
{

	$namaFile = $_FILES[$name]['name'];
	$ukuranFile = $_FILES[$name]['size'];
	$error = $_FILES[$name]['error'];
	$tmpName = $_FILES[$name]['tmp_name'];


	if ($error === 4) {
		//pesanlink('Oops! Gambar masih kosong','?page=insert/photo');
		return false;
	}

	//cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'PNG', 'JPEG', 'JPG'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));

	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
		echo "<script>
				alert('File yang diupload bukan gambar!!');
			</script>";
		return false;
	}

	if ($ukuranFile > 1000000) {
		echo "<script>
				alert('Ukuran file terlalu besar, minimal < 1 MB');
			</script>";
		//return false;
	}

	//rename file gambar
	$namaFileBaru = uniqid();
	$namaFileBaru .= ".";
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, '../feature_images/' . $namaFileBaru);

	return $namaFileBaru;
}

//FUNCTION UPLOAD PHOTO
function dokumentasi($name)
{

	$namaFile = $_FILES[$name]['name'];
	$ukuranFile = $_FILES[$name]['size'];
	$error = $_FILES[$name]['error'];
	$tmpName = $_FILES[$name]['tmp_name'];


	if ($error === 4) {
		//pesanlink('Oops! Gambar masih kosong','?page=insert/photo');
		return false;
	}

	//cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'PNG', 'JPEG', 'JPG'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));

	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
		echo "<script>
				alert('File yang diupload bukan gambar!!');
			</script>";
		return false;
	}

	if ($ukuranFile > 1000000) {
		echo "<script>
				alert('Ukuran file terlalu besar, minimal < 1 MB');
			</script>";
		//return false;
	}

	//rename file gambar
	$namaFileBaru = uniqid();
	$namaFileBaru .= ".";
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, '../dokumentasi_image/' . $namaFileBaru);

	return $namaFileBaru;
}

//MEMBUAT FUNGSI TERBILANG
function penyebut($nilai)
{
	$nilai = abs($nilai);
	//		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$huruf = array("", "SATU", "DUA", "TIGA", "EMPAT", "LIMA", "ENAM", "TUJUH", "DELAPAN", "SEBILAN", "SEPULUH", "SEBELAS");
	$temp = "";
	if ($nilai < 12) {
		$temp = " " . $huruf[$nilai];
	} else if ($nilai < 20) {
		$temp = penyebut($nilai - 10) . " BELAS";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai / 10) . " PULUH" . penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai / 100) . " RATUS" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " SERIBU" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai / 1000) . " RIBU" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai / 1000000) . " JUTA" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai / 1000000000) . " MILYAR" . penyebut(fmod($nilai, 1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai / 1000000000000) . " TRILYUN" . penyebut(fmod($nilai, 1000000000000));
	}
	return $temp;
}

function terbilang($nilai)
{
	if ($nilai < 0) {
		$hasil = "MINUS " . trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}
	return $hasil;
}




function bulan($bulanke)
{
	$namaBulan = array("Bulan", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	echo $namaBulan[$bulanke];
}
