<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

//MENYIMPAN NOMOR FAKTUR ----
if ((isset($_POST["MM_faktur"])) && ($_POST["MM_faktur"] == "form2")) {
	$insertSQL = sprintf(
		"INSERT INTO faktur (tglfaktur, statusfaktur, kodefaktur, addedfaktur, addbyfaktur, adminfaktur, periode) VALUES (%s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($koneksi, $today, "date"),
		GetSQLValueString($koneksi, 'N', "text"),
		GetSQLValueString($koneksi, $kodeacak, "text"),
		GetSQLValueString($koneksi, time(), "int"),
		GetSQLValueString($koneksi, $ID, "int"),
		GetSQLValueString($koneksi, $nama, "text"),
		GetSQLValueString($koneksi, $ta, "text")
	);

	//mysqli_select_db($database_koneksi);
	$Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error());

	if ($Result1) {
		refresh('?page=scan/add');
	}
}

//mysqli_select_db($database_koneksi);
$query_Faktur = sprintf(
	"SELECT * FROM faktur WHERE tglfaktur = %s AND addbyfaktur = %s AND periode = %s AND statusfaktur = %s ORDER BY idfaktur DESC",
	GetSQLValueString($koneksi, $tglsekarang, "date"),
	GetSQLValueString($koneksi, $ID, "int"),
	GetSQLValueString($koneksi, $ta, "text"),
	GetSQLValueString($koneksi, 'N', "text")
);
$Faktur = mysqli_query($koneksi, $query_Faktur) or die(mysqli_error());
$row_Faktur = mysqli_fetch_assoc($Faktur);
$totalRows_Faktur = mysqli_num_rows($Faktur);
//MEMBUAT NILAI FAKTUR

$faktur = $row_Faktur['kodefaktur'];
if (isset($_GET['faktur'])) {
	$faktur = $_GET['faktur'];
}
//---------------------------

$colname_search = "--1";
if (isset($_POST['search'])) {
	$colname_search = $_POST['search'];
	require('faktur.php');
}
//mysqli_select_db($database_koneksi);
$query_search = sprintf(
	"SELECT * FROM produk WHERE stok > 0 AND kodeproduk = %s OR namaproduk LIKE %s LIMIT 10",
	GetSQLValueString($koneksi, $colname_search, "text"),
	GetSQLValueString($koneksi, "%" . $colname_search . "%", "text")
);
$search = mysqli_query($koneksi, $query_search) or die(mysqli_error());
$row_search = mysqli_fetch_assoc($search);
$totalRows_search = mysqli_num_rows($search);

//JIKA HASIL PENCARIAN 1 PRODUK MAKA LANGSUNG SIMPAN
if ($totalRows_search == 1) {
	require('faktur.php');

	//SEBELUM ITU, DICEK JIKA PRODUK YG SAMA MAKA TAMBAHKAN STOK SAJA
	//mysqli_select_db($database_koneksi);
	$cek =  sprintf(
		"SELECT kode, faktur, qty FROM transaksitemp WHERE kode = %s AND faktur = %s",
		GetSQLValueString($koneksi, $row_search['kodeproduk'], "text"),
		GetSQLValueString($koneksi, $faktur, "text")
	);
	$rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error());
	$row_rs_cek = mysqli_fetch_assoc($rs_cek);
	$totalRows_rs_cek = mysqli_num_rows($rs_cek);

	if ($totalRows_rs_cek > 0) {
		//update / tambah qty produk
		if ($row_rs_cek['qty'] >= $row_search['stok']) {
			danger('Oops!', '' . $row_search['namaproduk'] . " - Stok terbatas!! Maks. " . $row_rs_cek['qty'] . ' ');
		} else {
			$stok = sprintf(
				"UPDATE transaksitemp SET qty = qty + 1 WHERE faktur = %s AND kode = %s",
				GetSQLValueString($koneksi, $faktur, "text"),
				GetSQLValueString($koneksi, $row_search['kodeproduk'], "text")
			);

			//mysqli_select_db($database_koneksi);
			$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error());
		}
	} else {
		require('faktur.php');

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
			GetSQLValueString($koneksi, $ID, "int"),
			GetSQLValueString($koneksi, $nama, "text"),
			GetSQLValueString($koneksi, $row_search['statusproduk'], "text"),
			GetSQLValueString($koneksi, $ta, "text")
		);

		//mysqli_select_db($database_koneksi);
		$Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error());
	} //tutup Cek Produk yg sudah ada	  
} //tutup pencarian produk

//mysqli_select_db($database_koneksi);
$query_trans = sprintf(
	"SELECT * FROM transaksitemp INNER JOIN produk ON kode = kodeproduk WHERE faktur = %s ORDER BY transaksitemp.id ASC",
	GetSQLValueString($koneksi, $faktur, "text")
);
$trans = mysqli_query($koneksi, $query_trans) or die(mysqli_error());
$row_trans = mysqli_fetch_assoc($trans);
$totalRows_trans = mysqli_num_rows($trans);

//MENGUBAH NILAI QTY PADA TEMPTRANSAKSI
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formCombobox")) {

	//mysqli_select_db($database_koneksi);
	$cek =  sprintf(
		"SELECT stok FROM produk WHERE kodeproduk = %s",
		GetSQLValueString($koneksi, $_POST['kodeCombo'], "text")
	);
	$rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error());
	$row_rs_cek = mysqli_fetch_assoc($rs_cek);
	$totalRows_rs_cek = mysqli_num_rows($rs_cek);

	if ($_POST['qtyupdate'] >= $row_rs_cek['stok']) {
		danger('Oops!', "Stok terbatas!! Maks. " . $row_rs_cek['stok'] . ' ');
	} else {
		$stok = sprintf(
			"UPDATE transaksitemp SET qty = %s WHERE faktur = %s AND kode = %s",
			GetSQLValueString($koneksi, $_POST['qtyupdate'], "int"),
			GetSQLValueString($koneksi, $faktur, "text"),
			GetSQLValueString($koneksi, $_POST['kodeCombo'], "text")
		);

		//mysqli_select_db($database_koneksi);
		$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error());
	}



	//untuk reload update barang	
	//mysqli_select_db($database_koneksi);
	$query_trans = sprintf(
		"SELECT * FROM transaksitemp INNER JOIN produk ON kode = kodeproduk WHERE faktur = %s ORDER BY transaksitemp.id ASC",
		GetSQLValueString($koneksi, $faktur, "text")
	);
	$trans = mysqli_query($koneksi, $query_trans) or die(mysqli_error());
	$row_trans = mysqli_fetch_assoc($trans);
	$totalRows_trans = mysqli_num_rows($trans);
}

//-----------------

if ($totalRows_search > 1) {
	for ($i = 1; $i <= $totalRows_search; $i++) {
		if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formx" . $i)) {
			//SEBELUM ITU, DICEK JIKA PRODUK YG SAMA MAKA TAMBAHKAN STOK SAJA
			//mysqli_select_db($database_koneksi);
			$cek =  sprintf(
				"SELECT kode, faktur, qty FROM transaksitemp WHERE kode = %s AND faktur = %s",
				GetSQLValueString($koneksi, $_POST['kodeproduk'], "text"),
				GetSQLValueString($koneksi, $faktur, "text")
			);
			$rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error());
			$row_rs_cek = mysqli_fetch_assoc($rs_cek);
			$totalRows_rs_cek = mysqli_num_rows($rs_cek);

			if ($totalRows_rs_cek > 0) {
				//update / tambah qty produk
				if ($row_rs_cek['qty'] >= $_POST['stok']) {
					danger('Oops!', '' . $_POST['namaproduk'] . " - Stok terbatas!! Maks. " . $row_rs_cek['qty'] . ' ');
				} else {
					$stok = sprintf(
						"UPDATE transaksitemp SET qty = qty + 1 WHERE faktur = %s AND kode = %s",
						GetSQLValueString($koneksi, $faktur, "text"),
						GetSQLValueString($koneksi, $_POST['kodeproduk'], "text")
					);

					//mysqli_select_db($database_koneksi);
					$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error());
				}
			} else {
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
					GetSQLValueString($koneksi, $ID, "int"),
					GetSQLValueString($koneksi, $nama, "text"),
					GetSQLValueString($koneksi, $row_search['statusproduk'], "text"),
					GetSQLValueString($koneksi, $ta, "text")
				);

				//mysqli_select_db($database_koneksi);
				$Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error());
			} //tutup Cek Produk yg sudah ada  */
		}
		//untuk reload update barang
		//mysqli_select_db($database_koneksi);
		$query_trans = sprintf(
			"SELECT * FROM transaksitemp INNER JOIN produk ON kode = kodeproduk WHERE faktur = %s ORDER BY transaksitemp.id ASC",
			GetSQLValueString($koneksi, $faktur, "text")
		);
		$trans = mysqli_query($koneksi, $query_trans) or die(mysqli_error());
		$row_trans = mysqli_fetch_assoc($trans);
		$totalRows_trans = mysqli_num_rows($trans);
	}
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formCari")) {
	//SEBELUM ITU, DICEK JIKA PRODUK YG SAMA MAKA TAMBAHKAN STOK SAJA
	//mysqli_select_db($database_koneksi);
	$cek =  sprintf(
		"SELECT kode, faktur, qty FROM transaksitemp WHERE kode = %s AND faktur = %s",
		GetSQLValueString($koneksi, $_POST['kodeproduk'], "text"),
		GetSQLValueString($koneksi, $faktur, "text")
	);
	$rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error());
	$row_rs_cek = mysqli_fetch_assoc($rs_cek);
	$totalRows_rs_cek = mysqli_num_rows($rs_cek);

	if ($totalRows_rs_cek > 0) {
		//update / tambah qty produk
		if ($row_rs_cek['qty'] >= $_POST['stok']) {
			danger('Oops!', '' . $_POST['namaproduk'] . " - Stok terbatas!! Maks. " . $row_rs_cek['qty'] . ' ');
		} else {
			$stok = sprintf(
				"UPDATE transaksitemp SET qty = qty + 1 WHERE faktur = %s AND kode = %s",
				GetSQLValueString($koneksi, $faktur, "text"),
				GetSQLValueString($koneksi, $_POST['kodeproduk'], "text")
			);

			//mysqli_select_db($database_koneksi);
			$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error());
		}
	} else {
		$insertSQL = sprintf(
			"INSERT INTO transaksitemp (`faktur`, `tanggal`, `kode`, `nama`, `harga`, `hargadasar`, `diskon`,`qty`, `added`, `addby`, `admintt`, `stt`, `periode`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($koneksi, $faktur, "text"),
			GetSQLValueString($koneksi, $today, "date"),
			GetSQLValueString($koneksi, $_POST['kodeproduk'], "text"),
			GetSQLValueString($koneksi, $_POST['namaproduk'], "text"),
			GetSQLValueString($koneksi, $_POST['hargajual'], "double"),
			GetSQLValueString($koneksi, $_POST['hargadasar'], "double"),
			GetSQLValueString($koneksi, 0, "double"),
			GetSQLValueString($koneksi, 1, "int"),
			GetSQLValueString($koneksi, time(), "int"),
			GetSQLValueString($koneksi, $ID, "int"),
			GetSQLValueString($koneksi, $nama, "text"),
			GetSQLValueString($koneksi, $_POST['statusproduk'], "text"),
			GetSQLValueString($koneksi, $ta, "text")
		);

		//mysqli_select_db($database_koneksi);
		$Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error());
	} //tutup Cek Produk yg sudah ada  */

	//untuk reload update barang
	//mysqli_select_db($database_koneksi);
	$query_trans = sprintf(
		"SELECT * FROM transaksitemp INNER JOIN produk ON kode = kodeproduk WHERE faktur = %s ORDER BY transaksitemp.id ASC",
		GetSQLValueString($koneksi, $faktur, "text")
	);
	$trans = mysqli_query($koneksi, $query_trans) or die(mysqli_error());
	$row_trans = mysqli_fetch_assoc($trans);
	$totalRows_trans = mysqli_num_rows($trans);
}



//--------------- UBAH STATUS Y PADA FAKTUR --------------
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formSelesai")) {

	if ($_POST["bayar"] >= $_POST["textfield3"]) {
		//mysqli_select_db($database_koneksi);
		$query_temp = sprintf(
			"SELECT * FROM transaksitemp WHERE faktur = %s ORDER BY id ASC",
			GetSQLValueString($koneksi, $faktur, "text")
		);
		$temp = mysqli_query($koneksi, $query_temp) or die(mysqli_error());
		$row_temp = mysqli_fetch_assoc($temp);
		$totalRows_temp = mysqli_num_rows($temp);

		do {
			$tempSQL = sprintf(
				"INSERT INTO transaksidetail (`faktur`, `tanggal`, `kode`, `nama`, `harga`, `hargadasar`, `diskon`, `qty`, `added`, `addby`, `admintd`, `stt`, `periode`) VALUES (%s,%s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				GetSQLValueString($koneksi, $row_temp['faktur'], "text"),
				GetSQLValueString($koneksi, $row_temp['tanggal'], "date"),
				GetSQLValueString($koneksi, $row_temp['kode'], "text"),
				GetSQLValueString($koneksi, $row_temp['nama'], "text"),
				GetSQLValueString($koneksi, $row_temp['harga'], "double"),
				GetSQLValueString($koneksi, $row_temp['hargadasar'], "double"),
				GetSQLValueString($koneksi, $row_temp['diskon'], "double"),
				GetSQLValueString($koneksi, $row_temp['qty'], "int"),
				GetSQLValueString($koneksi, $row_temp['added'], "int"),
				GetSQLValueString($koneksi, $row_temp['addby'], "int"),
				GetSQLValueString($koneksi, $row_temp['admintt'], "text"),
				GetSQLValueString($koneksi, $row_temp['stt'], "text"),
				GetSQLValueString($koneksi, $row_temp['periode'], "text")
			);

			$stok = sprintf(
				"UPDATE produk SET stok = stok - %s WHERE kodeproduk = %s",
				GetSQLValueString($koneksi, $row_temp['qty'], "int"),
				GetSQLValueString($koneksi, $row_temp['kode'], "text")
			);
			//edit stok										 
			//mysqli_select_db($database_koneksi);
			$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error());

			$deleteSQL = sprintf(
				"DELETE FROM transaksitemp WHERE id=%s",
				GetSQLValueString($koneksi, $row_temp['id'], "text")
			);

			//simpan
			//mysqli_select_db($database_koneksi);
			$Resulttemp = mysqli_query($koneksi, $tempSQL) or die(mysqli_error());

			//delete
			//mysqli_select_db($database_koneksi);
			$del = mysqli_query($koneksi, $deleteSQL) or die(mysqli_error());
		} while ($row_temp = mysqli_fetch_assoc($temp));



		$updateSQL = sprintf(
			"UPDATE faktur SET jenisbayar=%s, statusfaktur=%s, kembalian=%s, potongan=%s, totalbayar=%s, nohp=%s, namapelanggan=%s WHERE kodefaktur = %s",
			GetSQLValueString($koneksi, $_POST['jenisbayar'], "text"),
			GetSQLValueString($koneksi, 'Y', "text"),
			GetSQLValueString($koneksi, $_POST['balek'], "double"),
			GetSQLValueString($koneksi, $_POST['diskon'], "double"),
			GetSQLValueString($koneksi, $_POST['bayar'], "double"),
			GetSQLValueString($koneksi, $_POST['nohp'], "double"),
			GetSQLValueString($koneksi, $_POST['namapelanggan'], "text"),
			GetSQLValueString($koneksi, $faktur, "text")
		);

		//mysqli_select_db($database_koneksi);
		$Result1 = mysqli_query($koneksi, $updateSQL) or die(mysqli_error());

		if ($Result1) {
			require('faktur.php');
			echo "<script>
		window.open('report/kwitansi.php?id=$faktur', '', 'width=600,height=600');
		document.location.href='?page=scan/add';
	</script>";
		}
	} else {
		echo "<script>
		alert('Oops!, Pembayaran masih minus!');
	</script>";
	}
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formDiskon")) {
	$stok = sprintf(
		"UPDATE transaksitemp SET diskon = %s WHERE faktur = %s AND kode = %s",
		GetSQLValueString($koneksi, $_POST['diskon'], "text"),
		GetSQLValueString($koneksi, $_POST['faktur'], "text"),
		GetSQLValueString($koneksi, $_POST['kodeproduk'], "text")
	);

	//mysqli_select_db($database_koneksi);
	$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error());

	//untuk reload update barang
	//mysqli_select_db($database_koneksi);
	$query_trans = sprintf(
		"SELECT * FROM transaksitemp INNER JOIN produk ON kode = kodeproduk WHERE faktur = %s ORDER BY transaksitemp.id ASC",
		GetSQLValueString($koneksi, $faktur, "text")
	);
	$trans = mysqli_query($koneksi, $query_trans) or die(mysqli_error());
	$row_trans = mysqli_fetch_assoc($trans);
	$totalRows_trans = mysqli_num_rows($trans);
}
?>


<div class="row">

	<div class="col-md-12">
		<form id="form1" name="form1" method="post" action="" autocomplete="off">

			<div class="input-group margin">

				<input type="text" name="search" placeholder="Masukkan Kode / Nama Produk" class="form-control" autofocus required>
				<span class="input-group-btn">
					<button type="submit" class="btn btn-info btn-flat">Search</button>
				</span>
			</div>
		</form>
	</div>


	<div class="clearfix"></div>

	<div class="col-md-12">
		<?php if ($totalRows_search > 1) { ?>
			<table width="100%" class="table table-sm table-condensed table-hover">
				<tr bgcolor="#663399">
					<td>
						<div align="center" class="style1"><strong>NO.</strong></div>
					</td>
					<td>
						<div align="center" class="style1"><strong>PRODUK</strong></div>
					</td>
					<td>
						<div align="center" class="style1"><strong>ACTION</strong></div>
					</td>
				</tr>
				<?php $no = 1;
				do { ?>
					<tr>
						<td>
							<div align="center"><?php echo $no; ?></div>
						</td>
						<td class="text-uppercase"><?php echo $row_search['kodeproduk']; ?> - <?php echo $row_search['namaproduk']; ?><br />
							&#20A9; <?php echo number_format($row_search['hargajual']); ?> ( <?php echo $row_search['stok']; ?> <?php echo $row_search['satuan']; ?> )</td>
						<td>

							<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
								<input type="hidden" name="kodeproduk" value="<?= $row_search['kodeproduk']; ?>" />
								<input type="hidden" name="namaproduk" value="<?= $row_search['namaproduk']; ?>" />
								<input type="hidden" name="hargajual" value="<?= $row_search['hargajual']; ?>" />
								<input type="hidden" name="hargadasar" value="<?= $row_search['hargadasar']; ?>" />
								<input type="hidden" name="stok" value="<?= $row_search['stok']; ?>" />
								<input type="hidden" name="statusproduk" value="<?= $row_search['statusproduk']; ?>" />
								<button type="submit" name="button" class="btn btn-block btn-success"><span class="fa fa-shopping-cart"></span> Add Cart</button>
								<input type="hidden" name="MM_insert" value="formCari" />
							</form>
						</td>
					</tr>
				<?php
					$no++;
				} while ($row_search = mysqli_fetch_assoc($search)); ?>
			</table>
		<?php } else { ?>
			<marquee>Perhatian! Pastikan bahwa stok barang tidak kosong</marquee>
		<?php	} ?>
	</div> <!-- col -->

	<div class="clearfix"></div>
	<div class="col-md-12">

		<h3>NO. FAKTUR : <?= $faktur; ?> <span class="pull-right">

				<a href="?page=tabulasi/penjualan" class="btn btn-primary btn-sm"><span class="fa fa-ticket"></span> Faktur Sebelumnya</a></span>

			<span class="pull-right">&nbsp;

				<a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal"><span class="fa fa-ticket"></span> Add Product</a></span>

		</h3>


		<p></p>
		<?php if ($totalRows_trans > 0) { ?>
			<table width="100%" class="table table-sm table-condensed">
				<thead>
					<tr bgcolor="#006699">
						<th width="2%">
							<div align="center"><span class="style1">NO.</span></div>
						</th>
						<th width="53%">
							<div align="center"><span class="style1">PRODUK</span></div>
						</th>
						<th width="53%">
							<div align="center"><span class="style1">QTY</span></div>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$item = 0;
					$harga = 0;
					$diskon = 0;
					$no = 1;
					$idmodal = 1;
					do { ?>
						<tr style="font-size:22px">
							<td>
								<div align="center"><?php echo $no; ?></div>
							</td>

							<td class="text-uppercase"><a href="#" data-toggle="modal" data-target="#modal-default<?= $idmodal; ?>">
									<span class="btn-block"><?php echo $row_trans['kode']; ?> - <?php echo $row_trans['nama']; ?>
									</span>
								</a>
								<!-- Modal -->
								<div class=" modal fade" id="modal-default<?= $idmodal; ?>">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title">DETAIL : <?php echo $row_trans['kode']; ?> - <?php echo $row_trans['nama']; ?></h4>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="">SETTING QTY</label>

															<?php if ($row_trans['stok'] > 0) { ?>
																<form id="form<?= $no; ?>" name="formCombobox" method="post" action="">

																	<div class="input-group">
																		<input type="number" name="qtyupdate" value="<?php echo htmlentities($row_trans['qty'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Jumlah Beli" class="form-control input-lg" autofocus />
																		<span class="input-group-btn">
																			<button type="submit" class="btn btn-warning btn-lg">UBAH</button>
																		</span>
																	</div>

																	<input type="hidden" name="MM_update" value="formCombobox" />
																	<input type="hidden" name="kodeCombo" value="<?= $row_trans['kode']; ?>" />
																</form>
															<?php } else { ?>
																<a href="?page=manage/addget&search=<?= $row_trans['kode']; ?>" target="_blank" class="form-control input-lg">Klik disini untuk Tambah Stok Darurat!</a>
															<?php } ?>

															<?php $dis = 0 * $row_trans['qty'];
															number_format($dis); ?>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="">SUB TOTAL</label>
															<input type="text" class="form-control input-lg" name="" value="<?php $sub = $row_trans['harga'] * $row_trans['qty'];
																															echo number_format($sub); ?>" readonly>

														</div>
													</div>
												</div>


												<div class="form-group">
													<label for="">BERIKAN POTONGAN HARGA</label>
													<form action="<?php echo $editFormAction; ?>" method="post" name="formDiskon" id="formDiskon">
														<div class="input-group">
															<input type="number" name="diskon" value="<?php echo htmlentities($row_trans['diskon'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Potongan" class="form-control input-lg" autofocus />
															<span class="input-group-btn">
																<button type="submit" class="btn btn-info btn-lg">Apply</button>
															</span>
														</div>
														<input type="hidden" name="MM_update" value="formDiskon" />
														<input type="hidden" name="kodeproduk" value="<?= $row_trans['kode']; ?>" />
														<input type="hidden" name="faktur" value="<?= $row_trans['faktur']; ?>" />
													</form>

												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<a href="?page=scan/delete&id=<?php echo $row_trans['id'] ?>" class="btn btn-danger  btn-flat"><span class="fa fa-close"></span> Hapus</a>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
								<!-- /.modal -->
							</td>
							<td align="center">
								<a href="#" data-toggle="modal" data-target="#modal-default<?= $idmodal; ?>">
									<span class="btn-block"><?= $row_trans['qty']; ?></span>
								</a>
							</td>
						</tr>
					<?php
						$item += $row_trans['qty'];
						$harga += $sub;
						$diskon += $row_trans['diskon'];
						$no++;
						$idmodal++;
					} while ($row_trans = mysqli_fetch_assoc($trans)); ?>
				</tbody>
			</table>
			<button type="button" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#modal-bayar">
				<span class="fa fa-send"></span> <strong>BAYAR SEKARANG</strong>
			</button>
		<?php } else {
			danger('Belum ada Item', 'Silahkan Cari dan Masukkan data Barang');
		} ?>
		<div class="modal fade" id="modal-bayar">
			<div class="modal-dialog">
				<form method="post" name="formSelesai" action="<?php echo $editFormAction; ?>" autocomplete="off">
					<div class="modal-content">

						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">RINCIAN BELANJA</h4>

						</div>
						<div class="modal-body">
							<?php global $item; ?>
							<?php global $harga; ?>
							<?php global $diskon; ?>
							<?php global $grand;
							$grand = $harga - $diskon; ?>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>GRANDTOTAL : </label>
										<input class="form-control input-lg text-right" style="font-size: 35px;" type="text" value="&#20A9; <?= number_format($grand); ?>" readonly />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>POTONGAN</label>
										<input name="diskon" type="text" class="form-control input-lg text-right" style="font-size: 35px;" id="textfield2" value="<?= $diskon; ?>" readonly />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>UANG BAYAR</label>
										<input type="hidden" name="textfield3" id="gt" value="<?= $grand; ?>" />
										<input type="text" name="bayar" id="tunai" class="form-control  input-lg  text-right" style="font-size: 35px;" onkeyup="kembalian();" autofocus />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>KEMBALIAN</label>
										<input name="balek" type="text" class="form-control  input-lg  	text-right" style="font-size: 35px;" id="kembali" onkeyup="kembalian();" value="" readonly />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>METODE PEMBAYARAN</label>
										<select name="jenisbayar" class="form-control input-lg">
											<option value="CASH" <?php if (!(strcmp("CASH", htmlentities($row_Faktur['jenisbayar'], ENT_COMPAT, 'utf-8')))) {
																		echo "SELECTED";
																	} ?>>CASH</option>
											<option value="TRANSFER" <?php if (!(strcmp("TRANSFER", htmlentities($row_Faktur['jenisbayar'], ENT_COMPAT, 'utf-8')))) {
																			echo "SELECTED";
																		} ?>>TRANSFER</option>
											<option value="SHOPEEPAY" <?php if (!(strcmp("SHOPEEPAY", htmlentities($row_Faktur['jenisbayar'], ENT_COMPAT, 'utf-8')))) {
																			echo "SELECTED";
																		} ?>>SHOPEEPAY</option>
											<option value="MERCHANT" <?php if (!(strcmp("MERCHANT", htmlentities($row_Faktur['jenisbayar'], ENT_COMPAT, 'utf-8')))) {
																			echo "SELECTED";
																		} ?>>MERCHANT</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>NO. HP</label> (Opsional)
										<input name="nohp" type="number" class="form-control input-lg text-uppercase" style="font-size: 22px;" />
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>NAMA PELANGGAN</label> (Opsional)
										<input name="namapelanggan" type="text" class="form-control input-lg text-uppercase" style="font-size: 22px;" />
									</div>

								</div>
							</div>



						</div>
						<div class="modal-footer">
							<input type="hidden" name="MM_update" value="formSelesai" />
							<button type="submit" class="btn btn-lg btn-block btn-success">
								<span class="fa fa-print"></span> <strong>SAVE & PRINT <strong></button>
						</div>
					</div>
					<!-- /.modal-content -->
				</form>
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

	</div>
</div><!-- row -->


<hr>
<div class="clearfix"></div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<p class="modal-title text-uppercase" id="exampleModalLabel">Tambahkan Produk Baru</p>
				<small>Fitur ini hanya untuk produk yang belum terdaftar.</small>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo $editFormAction; ?>" method="post" name="formBarang" id="formBarang">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label for="nama">Nama Produk</label>
								<input type="text" name="namaproduk" class="form-control  text-uppercase">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="harga">Harga Jual (Rp.) per Item</label>
								<input type="number" name="harga" class="form-control">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="qty">Qty (Ketersediaan Awal)</label>
								<input type="number" name="qty" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="satuan">Satuan Produk</label>
								<input type="text" name="satuan" class="form-control text-uppercase">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add Cart</button>
				</div>
				<input type="hidden" name="kodeproduk" value="<?= $kodeacak; ?>" />
				<input type="hidden" name="MM_insert" value="formBarang" />
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	function kembalian() {
		var tunai = document.getElementById('tunai').value;
		var total = document.getElementById('gt').value;
		var balek = parseInt(tunai) - parseInt(total);
		if (!isNaN(balek)) {
			document.getElementById('kembali').value = balek;
		}
	}
</script>

<?php if (!empty($faktur)) { ?>
	<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
		<button class="btn btn-lg btn-info btn-block"><span class="fa fa-plus-circle"></span> Buat Transaksi Baru</button>
		<input type="hidden" name="MM_faktur" value="form2" />
	</form>
<?php } ?>

<?php
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formBarang")) {
	require('faktur.php');
	$insertSQL = sprintf(
		"INSERT INTO `produk`(`kodeproduk`,`namaproduk`, `kategori`,`hargadasar`, `hargajual`, `satuan`, `stok`,`addedproduk`, `addbyproduk`) 
				  VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($koneksi, $_POST['kodeproduk'], "text"),
		GetSQLValueString($koneksi, strtoupper($_POST['namaproduk']), "text"),
		GetSQLValueString($koneksi, 99, "int"),
		GetSQLValueString($koneksi, str_replace(".", "", $_POST['harga']), "double"),
		GetSQLValueString($koneksi, str_replace(".", "", $_POST['harga']), "double"),
		GetSQLValueString($koneksi, $_POST['satuan'], "text"),
		GetSQLValueString($koneksi, $_POST['qty'], "int"),
		GetSQLValueString($koneksi, time(), "int"),
		GetSQLValueString($koneksi, $ID, "int")
	);

	//mysqli_select_db($database_koneksi);
	$Result1 = mysqli_query($koneksi, $insertSQL) or die(errorQuery(mysqli_error()));

	if ($Result1) {
		$insertSQL = sprintf(
			"INSERT INTO transaksitemp (`faktur`, `tanggal`, `kode`, `nama`, `harga`, `hargadasar`, `diskon`,`qty`, `added`, `addby`, `admintt`, `stt`, `periode`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($koneksi, $faktur, "text"),
			GetSQLValueString($koneksi, $today, "date"),
			GetSQLValueString($koneksi, $_POST['kodeproduk'], "text"),
			GetSQLValueString($koneksi, strtoupper($_POST['namaproduk']), "text"),
			GetSQLValueString($koneksi, $_POST['harga'], "double"),
			GetSQLValueString($koneksi, $_POST['harga'], "double"),
			GetSQLValueString($koneksi, 0, "double"),
			GetSQLValueString($koneksi, 1, "int"),
			GetSQLValueString($koneksi, time(), "int"),
			GetSQLValueString($koneksi, $ID, "int"),
			GetSQLValueString($koneksi, $nama, "text"),
			GetSQLValueString($koneksi, 'Y', "text"),
			GetSQLValueString($koneksi, $ta, "text")
		);

		//mysqli_select_db($database_koneksi);
		$Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error());

		if ($Result1) {
			refresh('?page=scan/add');
		}
	}
}
?>