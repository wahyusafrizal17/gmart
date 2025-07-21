<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

//MENYIMPAN NOMOR FAKTUR ----
if ((isset($_POST["MM_faktur"])) && ($_POST["MM_faktur"] == "form2")) {
	$insertSQL = sprintf(
		"INSERT INTO faktur (tglfaktur, statusfaktur, kodefaktur, addedfaktur, addbyfaktur, adminfaktur, periode) VALUES (%s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($today, "date"),
		GetSQLValueString('N', "text"),
		GetSQLValueString($kodeacak, "text"),
		GetSQLValueString(time(), "int"),
		GetSQLValueString($ID, "int"),
		GetSQLValueString($nama, "text"),
		GetSQLValueString($ta, "text")
	);

	$Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error($koneksi));

	if ($Result1) {
		refresh('?page=scan/add');
	}
}

$query_Faktur = sprintf(
	"SELECT * FROM faktur WHERE tglfaktur = %s AND addbyfaktur = %s AND periode = %s AND statusfaktur = %s ORDER BY idfaktur DESC",
	GetSQLValueString($tglsekarang, "date"),
	GetSQLValueString($ID, "int"),
	GetSQLValueString($ta, "text"),
	GetSQLValueString('N', "text")
);
$Faktur = mysqli_query($koneksi, $query_Faktur) or die(mysqli_error($koneksi));
$row_Faktur = mysqli_fetch_assoc($Faktur);
$totalRows_Faktur = mysqli_num_rows($Faktur);
//MEMBUAT NILAI FAKTUR

$faktur = isset($row_Faktur['kodefaktur']) ? $row_Faktur['kodefaktur'] : '';
if (isset($_GET['faktur'])) {
	$faktur = $_GET['faktur'];
}
//---------------------------
$colname_search = "--1";
$totalRows_search = 0; // Inisialisasi agar tidak undefined

if (isset($_POST['search'])) {
    $colname_search = $_POST['search'];
    require('faktur.php');

    $query_search = sprintf(
        "SELECT * FROM produk WHERE stok > 0 AND (kodeproduk = %s OR namaproduk LIKE %s) LIMIT 10",
        GetSQLValueString($colname_search, "text"),
        GetSQLValueString("%" . $colname_search . "%", "text")
    );
    $search = mysqli_query($koneksi, $query_search) or die(mysqli_error($koneksi));
    $row_search = mysqli_fetch_assoc($search);
    $totalRows_search = mysqli_num_rows($search);

    // Jika hanya 1 produk ditemukan, langsung proses simpan
    if ($totalRows_search == 1) {
        require('faktur.php');

        // Cek apakah produk sudah ada di transaksi temp
        $cek = sprintf(
            "SELECT kode, faktur, qty FROM transaksitemp 
             LEFT JOIN produk ON kode = kodeproduk
             WHERE kode = %s AND faktur = %s",
            GetSQLValueString($row_search['kodeproduk'], "text"),
            GetSQLValueString($faktur, "text")
        );
        $rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error($koneksi));
        $row_rs_cek = mysqli_fetch_assoc($rs_cek);
        $totalRows_rs_cek = mysqli_num_rows($rs_cek);

        if ($totalRows_rs_cek > 0) {
            // Jika sudah ada, tambah qty
            if ($row_rs_cek['qty'] >= $row_search['stok']) {
                danger('Oops!', $row_search['namaproduk'] . " - Stok terbatas!! Maks. " . $row_rs_cek['qty']);
            } else {
                $stok = sprintf(
                    "UPDATE transaksitemp SET qty = qty + 1 WHERE faktur = %s AND kode = %s",
                    GetSQLValueString($faktur, "text"),
                    GetSQLValueString($row_search['kodeproduk'], "text")
                );
                $hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error($koneksi));
            }
        } else {
            // Jika belum ada, insert baru
            $insertSQL = sprintf(
                "INSERT INTO transaksitemp 
                (`faktur`, `tanggal`, `kode`, `nama`, `harga`, `hargadasar`, `diskon`, `qty`, `added`, `addby`, `admintt`, `stt`, `periode`) 
                VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($faktur, "text"),
                GetSQLValueString($today, "date"),
                GetSQLValueString($row_search['kodeproduk'], "text"),
                GetSQLValueString($row_search['namaproduk'], "text"),
                GetSQLValueString($row_search['hargajual'], "double"),
                GetSQLValueString($row_search['hargadasar'], "double"),
                GetSQLValueString(0, "double"),
                GetSQLValueString(1, "int"),
                GetSQLValueString(time(), "int"),
                GetSQLValueString($ID, "int"),
                GetSQLValueString($nama, "text"),
                GetSQLValueString($row_search['statusproduk'], "text"),
                GetSQLValueString($ta, "text")
            );

            $Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error($koneksi));
        }

        // Kosongkan input pencarian setelah berhasil
        unset($_POST['search']);
    }
}

$query_trans = sprintf(
	"SELECT * FROM transaksitemp INNER JOIN produk ON kode = kodeproduk WHERE faktur = %s ORDER BY transaksitemp.id ASC",
	GetSQLValueString($faktur, "text")
);
$trans = mysqli_query($koneksi, $query_trans) or die(mysqli_error($koneksi));
$row_trans = mysqli_fetch_assoc($trans);
$totalRows_trans = mysqli_num_rows($trans);

//MENGUBAH NILAI QTY PADA TEMPTRANSAKSI
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formCombobox")) {

	$cek =  sprintf(
		"SELECT stok FROM produk WHERE kodeproduk = %s",
		GetSQLValueString($_POST['kodeCombo'], "text")
	);
	$rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error($koneksi));
	$row_rs_cek = mysqli_fetch_assoc($rs_cek);
	$totalRows_rs_cek = mysqli_num_rows($rs_cek);

	if ($_POST['qtyupdate'] > $row_rs_cek['stok']) {
		danger('Oops!', "Stok terbatas!! Maks. " . $row_rs_cek['stok'] . ' ');
	} else {
		$stok = sprintf(
			"UPDATE transaksitemp SET qty = %s WHERE faktur = %s AND kode = %s",
			GetSQLValueString($_POST['qtyupdate'], "int"),
			GetSQLValueString($faktur, "text"),
			GetSQLValueString($_POST['kodeCombo'], "text")
		);

		$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error($koneksi));
	}



	//untuk reload update barang	
	$query_trans = sprintf(
		"SELECT * FROM transaksitemp INNER JOIN produk ON kode = kodeproduk WHERE faktur = %s ORDER BY transaksitemp.id ASC",
		GetSQLValueString($faktur, "text")
	);
	$trans = mysqli_query($koneksi, $query_trans) or die(mysqli_error($koneksi));
	$row_trans = mysqli_fetch_assoc($trans);
	$totalRows_trans = mysqli_num_rows($trans);
}

//-----------------

if ($totalRows_search > 1) {
	for ($i = 1; $i <= $totalRows_search; $i++) {
		if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formx" . $i)) {
			//SEBELUM ITU, DICEK JIKA PRODUK YG SAMA MAKA TAMBAHKAN STOK SAJA
			$cek =  sprintf(
				"SELECT kode, faktur, qty FROM transaksitemp 
				LEFT JOIN produk ON kode = kodeproduk
				WHERE kode = %s AND faktur = %s",
				GetSQLValueString($_POST['kodeproduk'], "text"),
				GetSQLValueString($faktur, "text")
			);
			$rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error($koneksi));
			$row_rs_cek = mysqli_fetch_assoc($rs_cek);
			$totalRows_rs_cek = mysqli_num_rows($rs_cek);

			if ($totalRows_rs_cek > 0) {
				//update / tambah qty produk
				if ($row_rs_cek['qty'] >= $_POST['stok']) {
					danger('Oops!', '' . $_POST['namaproduk'] . " - Stok terbatas!! Maks. " . $row_rs_cek['qty'] . ' ');
				} else {
					$stok = sprintf(
						"UPDATE transaksitemp SET qty = qty + 1 WHERE faktur = %s AND kode = %s",
						GetSQLValueString($faktur, "text"),
						GetSQLValueString($_POST['kodeproduk'], "text")
					);

					$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error($koneksi));
				}
			} else {
				$insertSQL = sprintf(
					"INSERT INTO transaksitemp (`faktur`, `tanggal`, `kode`, `nama`, `harga`, `hargadasar`, `diskon`,`qty`, `added`, `addby`, `admintt`, `stt`, `periode`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					GetSQLValueString($faktur, "text"),
					GetSQLValueString($today, "date"),
					GetSQLValueString($row_search['kodeproduk'], "text"),
					GetSQLValueString($row_search['namaproduk'], "text"),
					GetSQLValueString($row_search['hargajual'], "double"),
					GetSQLValueString($row_search['hargadasar'], "double"),
					GetSQLValueString(0, "double"),
					GetSQLValueString(1, "int"),
					GetSQLValueString(time(), "int"),
					GetSQLValueString($ID, "int"),
					GetSQLValueString($nama, "text"),
					GetSQLValueString($row_search['statusproduk'], "text"),
					GetSQLValueString($ta, "text")
				);

				$Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error($koneksi));
			} //tutup Cek Produk yg sudah ada  */
		}
		//untuk reload update barang
		$query_trans = sprintf(
			"SELECT * FROM transaksitemp INNER JOIN produk ON kode = kodeproduk WHERE faktur = %s ORDER BY transaksitemp.id ASC",
			GetSQLValueString($faktur, "text")
		);
		$trans = mysqli_query($koneksi, $query_trans) or die(mysqli_error($koneksi));
		$row_trans = mysqli_fetch_assoc($trans);
		$totalRows_trans = mysqli_num_rows($trans);
	}
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formCari")) {
	//SEBELUM ITU, DICEK JIKA PRODUK YG SAMA MAKA TAMBAHKAN STOK SAJA
	$cek =  sprintf(
		"SELECT kode, faktur, qty FROM transaksitemp 
				LEFT JOIN produk ON kode = kodeproduk
				WHERE kode = %s AND faktur = %s",
		GetSQLValueString($_POST['kodeproduk'], "text"),
		GetSQLValueString($faktur, "text")
	);
	$rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error($koneksi));
	$row_rs_cek = mysqli_fetch_assoc($rs_cek);
	$totalRows_rs_cek = mysqli_num_rows($rs_cek);

	if ($totalRows_rs_cek > 0) {
		//update / tambah qty produk
		if ($row_rs_cek['qty'] >= $_POST['stok']) {
			danger('Oops!', '' . $_POST['namaproduk'] . " - Stok terbatas!! Maks. " . $row_rs_cek['qty'] . ' ');
		} else {
			$stok = sprintf(
				"UPDATE transaksitemp SET qty = qty + 1 WHERE faktur = %s AND kode = %s",
				GetSQLValueString($faktur, "text"),
				GetSQLValueString($_POST['kodeproduk'], "text")
			);

			$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error($koneksi));
		}
	} else {
		//cek point
		if ($_POST['stok'] > 0) {
			$insertSQL = sprintf(
				"INSERT INTO transaksitemp (`faktur`, `tanggal`, `kode`, `nama`, `harga`, `hargadasar`, `diskon`,`qty`, `added`, `addby`, `admintt`, `stt`, `periode`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				GetSQLValueString($faktur, "text"),
				GetSQLValueString($today, "date"),
				GetSQLValueString($_POST['kodeproduk'], "text"),
				GetSQLValueString($_POST['namaproduk'], "text"),
				GetSQLValueString($_POST['hargajual'], "double"),
				GetSQLValueString($_POST['hargadasar'], "double"),
				GetSQLValueString(0, "double"),
				GetSQLValueString(1, "int"),
				GetSQLValueString(time(), "int"),
				GetSQLValueString($ID, "int"),
				GetSQLValueString($nama, "text"),
				GetSQLValueString($_POST['statusproduk'], "text"),
				GetSQLValueString($ta, "text")
			);

			$Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error($koneksi));
		}else{
			danger('Oops!', '' . $row_search['namaproduk'] . '- Stok tidak tersedia!!');
		}
	} //tutup Cek Produk yg sudah ada  */

	//untuk reload update barang
	$query_trans = sprintf(
		"SELECT * FROM transaksitemp INNER JOIN produk ON kode = kodeproduk WHERE faktur = %s ORDER BY transaksitemp.id ASC",
		GetSQLValueString($faktur, "text")
	);
	$trans = mysqli_query($koneksi, $query_trans) or die(mysqli_error($koneksi));
	$row_trans = mysqli_fetch_assoc($trans);
	$totalRows_trans = mysqli_num_rows($trans);
}



//--------------- UBAH STATUS Y PADA FAKTUR --------------
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formSelesai")) {
	$Start = mysqli_query($koneksi, "START TRANSACTION") or die(errorQuery(mysqli_error($koneksi)));
	$v_bayar = str_replace('.', '', $_POST['bayar']);
	$v_balek = str_replace('.', '', $_POST['balek']);
	if ($v_bayar >= $_POST["textfield3"]) {
		$query_temp = sprintf(
			"SELECT * FROM transaksitemp WHERE faktur = %s ORDER BY id ASC",
			GetSQLValueString($faktur, "text")
		);
		$temp = mysqli_query($koneksi, $query_temp) or die(mysqli_error($koneksi));
		$row_temp = mysqli_fetch_assoc($temp);
		$totalRows_temp = mysqli_num_rows($temp);

		do {
			$tempSQL = sprintf(
				"INSERT INTO transaksidetail (`faktur`, `tanggal`, `kode`, `nama`, `harga`, `hargadasar`, `diskon`, `qty`, `added`, `addby`, `admintd`, `stt`, `periode`) VALUES (%s,%s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				GetSQLValueString($row_temp['faktur'], "text"),
				GetSQLValueString($row_temp['tanggal'], "date"),
				GetSQLValueString($row_temp['kode'], "text"),
				GetSQLValueString($row_temp['nama'], "text"),
				GetSQLValueString($row_temp['harga'], "double"),
				GetSQLValueString($row_temp['hargadasar'], "double"),
				GetSQLValueString($row_temp['diskon'], "double"),
				GetSQLValueString($row_temp['qty'], "int"),
				GetSQLValueString($row_temp['added'], "int"),
				GetSQLValueString($row_temp['addby'], "int"),
				GetSQLValueString($row_temp['admintt'], "text"),
				GetSQLValueString($row_temp['stt'], "text"),
				GetSQLValueString($row_temp['periode'], "text")
			);

			$stok = sprintf(
				"UPDATE produk SET stok = stok - %s WHERE kodeproduk = %s",
				GetSQLValueString($row_temp['qty'], "int"),
				GetSQLValueString($row_temp['kode'], "text")
			);
			//edit stok										 
			$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error($koneksi));

			$deleteSQL = sprintf(
				"DELETE FROM transaksitemp WHERE id=%s",
				GetSQLValueString($row_temp['id'], "text")
			);

			//simpan
			$Resulttemp = mysqli_query($koneksi, $tempSQL) or die(mysqli_error($koneksi));

			//delete
			$del = mysqli_query($koneksi, $deleteSQL) or die(mysqli_error($koneksi));
		} while ($row_temp = mysqli_fetch_assoc($temp));



		$updateSQL = sprintf(
			"UPDATE faktur SET jenisbayar=%s, statusfaktur=%s, kembalian=%s, potongan=%s, totalbayar=%s, nohp=%s, namapelanggan=%s WHERE kodefaktur = %s",
			GetSQLValueString($_POST['jenisbayar'], "text"),
			GetSQLValueString('Y', "text"),
			GetSQLValueString($v_balek, "double"),
			GetSQLValueString($_POST['diskon'], "double"),
			GetSQLValueString($v_bayar, "double"),
			GetSQLValueString($_POST['nohp'], "double"),
			GetSQLValueString($_POST['namapelanggan'], "text"),
			GetSQLValueString($faktur, "text")
		);

		if ($_POST['namapelanggan'] != null) {
			$query_cek = sprintf("SELECT * FROM member WHERE nama_member=%s",
			GetSQLValueString($_POST['namapelanggan'], "text")
			 );
			$cek = mysqli_query($koneksi, $query_cek) or die(mysqli_error($koneksi));
			$row_cek = mysqli_fetch_assoc($cek);

			// $point = ($_POST['bayar'] - $_POST['balek']) / 10000;
			$selisih = $v_bayar - $v_balek;
			if ($selisih >= 0) {
    			$point = floor($selisih / 10000);
			} else {
    			$point = 0;
			}
			$point_akhir = $row_cek['point'] + $point;
			$updateMember = sprintf(
				"UPDATE member SET point=%s WHERE nama_member = %s",
				GetSQLValueString($point_akhir, "double"),
				GetSQLValueString($_POST['namapelanggan'], "text")
			);
			mysqli_query($koneksi, $updateMember) or die(mysqli_error($koneksi));
		}

		$Result1 = mysqli_query($koneksi, $updateSQL) or die(mysqli_error($koneksi));

		if ($Result1) {
			$Commit = mysqli_query($koneksi, "COMMIT") or die(errorQuery(mysqli_error($koneksi)));
			require('faktur.php');
			echo "<script>
		window.open('report/kwitansi.php?id=$faktur', '', 'width=600,height=600');
		document.location.href='?page=scan/add';
	</script>";
		}
	} else {
		echo "<script>
		alert('Oops!, Pembayaran masih minus brow!');
	</script>";
	}
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formDiskon")) {
	$stok = sprintf(
		"UPDATE transaksitemp SET diskon = %s WHERE faktur = %s AND kode = %s",
		GetSQLValueString($_POST['diskon'], "text"),
		GetSQLValueString($_POST['faktur'], "text"),
		GetSQLValueString($_POST['kodeproduk'], "text")
	);

	$hasilstok = mysqli_query($koneksi, $stok) or die(mysqli_error($koneksi));

	//untuk reload update barang
	$query_trans = sprintf(
		"SELECT * FROM transaksitemp INNER JOIN produk ON kode = kodeproduk WHERE faktur = %s ORDER BY transaksitemp.id ASC",
		GetSQLValueString($faktur, "text")
	);
	$trans = mysqli_query($koneksi, $query_trans) or die(mysqli_error($koneksi));
	$row_trans = mysqli_fetch_assoc($trans);
	$totalRows_trans = mysqli_num_rows($trans);
}
?>


<style>
@keyframes fadeInScale {
  from {
    opacity: 0;
    transform: scale(0.9);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>
<div class="row">
	<div class="col-md-8 col-xs-12">
		<label for="" class="small">SCAN BARCODE DISINI</label>
		<form id="form1" name="form1" method="post" action="" autocomplete="off">
			
			<div class="input-group">

				<input type="text" name="search" placeholder="Masukkan Kode / Nama Produk" class="form-control" autofocus required>

				<span class="input-group-btn">
					<button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> Search</button>
					<a href="javascript:void(0)"  class="btn btn-primary btn-flat" onclick="openCamera()"><i class="fa fa-barcode"></i> Scan</a>
				</span>
			</div>
		</form>
	</div>
	<div class="col-md-2">
		<a href="?page=tabulasi/penjualan" class="btn btn-warning btn-sm btn-block"><span class="fa fa-ticket"></span> Faktur Sebelumnya</a></span> <a href="" class="btn btn-info btn-sm btn-block" data-toggle="modal" data-target="#exampleModal"><span class="fa fa-ticket"></span> Add Product</a></span>

	</div>
	<div class="col-md-2">
		<div class="small-box bg-red text-center">

			<label class="small">NO. FAKTUR</label>
			<p style="font-size: 30px;"><?= $faktur; ?></p>

		</div>
	</div>
</div>
<div class="row">
	<!-- Pencarian produk jika lebih dari 1 -->
	<div class="col-md-8">
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
							Rp. <?php echo number_format($row_search['hargajual']); ?> ( <?php echo $row_search['stok']; ?> <?php echo $row_search['satuan']; ?> )</td>
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
			<p class="text-danger padding-10mm">Perhatian! Pastikan bahwa stok barang tidak kosong</p>
		<?php	} ?>
	</div> <!-- col -->

	<div class="clearfix"></div>
	<div class="col-md-8 col-xs-12">

		<?php if ($totalRows_trans > 0) { ?>
			<div id="overflowTest">
				<table width="100%" class="table table-sm table-condensed">
					<thead>
						<tr bgcolor="#006699">
							<th width="2%">
								<div align="center"><span class="style1">NO.</span></div>
							</th>
							<th width="43%">
								<div align="center"><span class="style1">PRODUK</span></div>
							</th>
							<th width="10%">
								<div align="center"><span class="style1">ITEM</span></div>
							</th>
							<th width="23%">
								<div align="center"><span class="style1">PRICE</span></div>
							</th>
							<th width="23%">
								<div align="center"><span class="style1">SUBTOTAL</span></div>
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
										<span class="btn-block"><?php echo $row_trans['kode']; ?> - <?php echo $row_trans['nama']; ?> <span class="text-danger small">
												<?php if ($row_trans['diskon'] > 0) { ?>
													( Disc : Rp. <?= number_format($row_trans['diskon'], 0, ",", "."); ?> )
												<?php } ?>
											</span>
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
										<span class="btn-block"><?= $row_trans['qty']; ?> </span>
									</a>
								</td>
								<td align="right">Rp. <?= number_format($row_trans['harga'], 0, ",", "."); ?></td>
								<td align="right">Rp. <?php $subtotal = ($row_trans['harga'] * $row_trans['qty']) - $row_trans['diskon'];
														echo number_format($subtotal, 0, ",", "."); ?></td>
							</tr>
						<?php
							$item += $row_trans['qty'];
							$harga += $sub;
							$diskon += $row_trans['diskon'];
							$no++;
							$idmodal++;
						} while ($row_trans = mysqli_fetch_assoc($trans)); ?>
						<?php global $item; ?>
						<?php global $harga; ?>
						<?php global $diskon; ?>
						<?php global $grand;
						$grand = $harga - $diskon; ?>
						<tr>
						<td colspan="3"></td>
						<td align="right"><strong>DISKON</strong></td>
						<td align="right">Rp. <?= number_format($diskon); ?>

						</td>
					</tr>
					
						


					</tbody>
				</table>

				<?php if (!empty($faktur)) { ?>
					<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
						<button class="btn btn-lg btn-info btn-block"><span class="fa fa-plus-circle"></span> Buat Transaksi Baru</button>
						<input type="hidden" name="MM_faktur" value="form2" />
					</form>
				<?php } ?>
			</div>
		<?php } else {
			danger('Belum ada Item', 'Silahkan Cari dan Masukkan data Barang');
		} ?>


	</div>

	<div class="row">
		<div class="col-md-4 col-xs-12">
		<?php if ($totalRows_trans > 0) { ?>

			<p style="font-size: 50px; background-color:darkcyan; padding-right:15px; color:white;" class="text-right">Rp. <?= number_format($grand); ?></p>
		<?php } ?>
		<?php if ($totalRows_trans > 0) { ?>
		<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">Selesai Pembayaran</button>
		<?php } ?>
								

		</div>
	</div>
	<?php if ($totalRows_trans > 0) { ?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <p style="font-size: 50px; background-color:darkcyan; padding-right:15px; color:white;" class="text-right">Rp. <?= number_format($grand); ?></p>
	  <form method="post" name="formSelesai" action="<?php echo $editFormAction; ?>" autocomplete="off">
	  <div class="table-responsive">
	  <table class="table no-border">
								<tr>
									<td width="40%"><strong>UANG BAYAR</strong></td> 
									<td>
										<input type="hidden" name="textfield3" id="gt" value="<?= $grand; ?>" />
										<input type="text" name="bayar" id="tunai" placeholder="<?= $grand; ?>" class="form-control input-lg text-right" style="font-size: 45px;" onkeyup="kembalian();" autofocus />
									</td>
								</tr>
								<tr>
									<td><strong>KEMBALIAN</strong></td>
									<td>
										<input name="balek" type="text" class="form-control text-right" style="font-size: 35px;" id="kembali" value="" readonly />
									</td>
								</tr>
								<tr>
									<td><strong>METODE BAYAR</strong></td>
									<td><select name="jenisbayar" class="form-control ">
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
									</td>
								</tr>
								<tr>
									<td><strong>NO. HP </strong><small>(Opsional)</small></td>
									<td><input name="nohp" type="text" class="form-control  text-uppercase" style="font-size: 22px;" />
									</td>
								</tr>
								<tr>
    <td><strong>NIK PELANGGAN</strong> <br><small>(NAMA PELANGGAN)</small></td>
    <td>
    <select class="js-example-basic-single" name="namapelanggan" id="namapelanggan" placeholder="Pilih atau cari pelanggan">
        <option value=""></option>
        <?php
        $cek = "SELECT * FROM member";
        $rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error($koneksi));

        while ($data = mysqli_fetch_assoc($rs_cek)) { ?>
            <option value="<?php echo $data['nama_member'] ?>">
                <?php echo $data['nik'] ?> / 
                <?php echo $data['nomor'] ?>
            </option>
        <?php } ?>
    </select>

    <input type="text" readonly name="cek" class="form-control" id="cek" />
    <input name="diskon" type="hidden" class="form-control text-right" id="textfield2" value="<?= $diskon; ?>" readonly />
</td>

</tr>

	  </table>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
		<input type="hidden" name="MM_update" value="formSelesai" />
										<button type="submit" class="btn btn-lg btn-block btn-success">
											<span class="fa fa-print"></span> <strong>SIMPAN TRANSAKSI <strong></button>
											</form>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<script>
    $(document).ready(function() {
        $('#exampleModal').on('shown.bs.modal', function() {
            $('.js-example-basic-single').select2({
                theme: "bootstrap4",
                width: '100%',
                dropdownParent: $('#exampleModal'), 
                placeholder: "Pilih atau cari pelanggan",
                allowClear: true
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#namapelanggan').on('change', function () {
            var selectedNama = $(this).val(); 
            $('#cek').val(selectedNama);
        });
    });
</script>

	<!-- <?php if ($totalRows_trans > 0) { ?>
		<div class="col-md-4 col-xs-12">
		    <p style="font-size: 50px; background-color:darkcyan; padding-right:15px; color:white;" class="text-right">Rp. <?= number_format($grand); ?></p>
			<form method="post" name="formSelesai" action="<?php echo $editFormAction; ?>" autocomplete="off">
				<div class="small-box bg-purple">
					<div class="inner">
						<div class="table-responsive">
							<table class="table no-border">
								<tr>
									<td width="40%"><strong>UANG BAYAR</strong></td> 
									<td><input type="hidden" name="textfield3" id="gt" value="<?= $grand; ?>" />
										<input type="text" name="bayar" id="tunai" placeholder="<?= $grand; ?>" class="form-control input-lg text-right" style="font-size: 45px;" onkeyup="kembalian();" autofocus />
									</td>
								</tr>
								<tr>
									<td><strong>KEMBALIAN</strong></td>
									<td><input type="hidden" name="textfield3" id="gt" value="<?= $grand; ?>" />
										<input name="balek" type="text" class="form-control    	text-right" style="font-size: 35px;" id="kembali" onkeyup="kembalian();" value="" readonly />
									</td>
								</tr>
								<tr>
									<td><strong>METODE BAYAR</strong></td>
									<td><select name="jenisbayar" class="form-control ">
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
									</td>
								</tr>
								<tr>
									<td><strong>NO. HP </strong><small>(Opsional)</small></td>
									<td><input name="nohp" type="text" class="form-control  text-uppercase" style="font-size: 22px;" />
									</td>
								</tr>
								<tr>
									<td><strong>NAMA PELANGGAN</strong> <br><small>(Opsional)</small></td>
									<td>
									<select name="namapelanggan" id="" class="form-control">
										<option value=""></option>
									<?php 
										$cek = sprintf(
    									"SELECT * FROM member",
    									GetSQLValueString($row_search['kodeproduk'], "text"),
    									GetSQLValueString($faktur, "text")
										);
										$rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error($koneksi));

										while ($data = mysqli_fetch_assoc($rs_cek)) { ?>
    									<option value="<?php echo $data['nama_member'] ?>"><?php echo $data['nama_member'] ?></option>
										<?php } ?>

									</select>
										<input name="diskon" type="hidden" class="form-control  text-right" id="textfield2" value="<?= $diskon; ?>" readonly />
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<input type="hidden" name="MM_update" value="formSelesai" />
										<button type="submit" class="btn btn-lg btn-block btn-success">
											<span class="fa fa-print"></span> <strong>SIMPAN TRANSAKSI <strong></button>
									</td>
								</tr>


							</table>
						</div>
					</div>
				</div>
			</form>

		</div>
	<?php } ?> -->

</div>



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
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<!-- Modal kamera -->
<!-- Modal -->
<div id="scanModal" style="
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1050;
  justify-content: center;
  align-items: center;
  font-family: Arial, sans-serif;
">
  <div style="
    background: #fff;
    border-radius: 0.5rem;
    padding: 1.5rem;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.3);
    position: relative;
    animation: fadeInScale 0.3s ease;
  ">
    <!-- Modal Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #dee2e6; padding-bottom: 0.5rem; margin-bottom: 1rem;">
      <h5 style="margin: 0;">Scan Barcode</h5>
      <button onclick="closeCamera()" style="
        background: none;
        border: none;
        font-size: 1.5rem;
        line-height: 1;
        cursor: pointer;
        color: #aaa;
      ">&times;</button>
    </div>

    <!-- Modal Body -->
    <div style="text-align: center;">
      <div id="reader" style="width: 100%; max-width: 300px; margin: auto;"></div>
    </div>
  </div>
</div>

<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		document.querySelector("input[name='search']").focus();
	});

	function formatRupiah(angka) {
		if (!angka) return '';
		return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}

	function cleanRupiah(str) {
		return str.replace(/\./g, '').replace(/[^\d]/g, '');
	}

	function kembalian() {
		let tunaiInput = document.getElementById('tunai');
		let kembaliInput = document.getElementById('kembali');
		let total = parseInt(document.getElementById('gt').value);

		let tunaiRaw = cleanRupiah(tunaiInput.value);
		let tunai = parseInt(tunaiRaw);

		if (!isNaN(tunai)) {
			tunaiInput.value = formatRupiah(tunai);
			let balek = tunai - total;

			if (balek === 0) {
				kembaliInput.value = '0';
			} else if (balek < 0) {
				kembaliInput.value = '-' + formatRupiah(Math.abs(balek));
			} else {
				kembaliInput.value = formatRupiah(balek);
			}
		} else {
			kembaliInput.value = "0";
		}
	}

	let html5QrcodeScanner;

	function openCamera() {
		document.getElementById('scanModal').style.display = 'flex';

		html5QrcodeScanner = new Html5Qrcode("reader");

		html5QrcodeScanner.start(
			{ facingMode: "environment" },
			{
				fps: 10,
				qrbox: { width: 250, height: 250 }
			},
			onScanSuccess
		).catch(err => {
			console.error("Camera start error", err);
		});
	}

	function closeCamera() {
		document.getElementById('scanModal').style.display = 'none';
		if (html5QrcodeScanner) {
			html5QrcodeScanner.stop().then(() => {
				html5QrcodeScanner.clear();
			}).catch(err => {
				console.error("Stop failed", err);
			});
		}
	}

	function onScanSuccess(decodedText, decodedResult) {
		// Kirim ke ?page=scan/add pakai POST
		const form = document.createElement('form');
		form.method = 'POST';
		form.action = 'welcome.php?page=scan/add';

		const input = document.createElement('input');
		input.type = 'hidden';
		input.name = 'search';
		input.value = decodedText;

		form.appendChild(input);
		document.body.appendChild(form);
		form.submit();
	}
</script>


<?php
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formBarang")) {
	require('faktur.php');

	$Start = mysqli_query($koneksi, "START TRANSACTION") or die(errorQuery(mysqli_error($koneksi)));
	$insertSQL = sprintf(
		"INSERT INTO `produk`(`kodeproduk`,`namaproduk`, `kategori`,`hargadasar`, `hargajual`, `satuan`, `stok`,`addedproduk`, `addbyproduk`) 
				  VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($_POST['kodeproduk'], "text"),
		GetSQLValueString(strtoupper($_POST['namaproduk']), "text"),
		GetSQLValueString(99, "int"),
		GetSQLValueString(str_replace(".", "", $_POST['harga']), "double"),
		GetSQLValueString(str_replace(".", "", $_POST['harga']), "double"),
		GetSQLValueString($_POST['satuan'], "text"),
		GetSQLValueString($_POST['qty'], "int"),
		GetSQLValueString(time(), "int"),
		GetSQLValueString($ID, "int")
	);

	$Result1 = mysqli_query($koneksi, $insertSQL) or die(errorQuery(mysqli_error($koneksi)));

	if ($Result1) {
		$insertSQL = sprintf(
			"INSERT INTO transaksitemp (`faktur`, `tanggal`, `kode`, `nama`, `harga`, `hargadasar`, `diskon`,`qty`, `added`, `addby`, `admintt`, `stt`, `periode`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($faktur, "text"),
			GetSQLValueString($today, "date"),
			GetSQLValueString($_POST['kodeproduk'], "text"),
			GetSQLValueString(strtoupper($_POST['namaproduk']), "text"),
			GetSQLValueString($_POST['harga'], "double"),
			GetSQLValueString($_POST['harga'], "double"),
			GetSQLValueString(0, "double"),
			GetSQLValueString(1, "int"),
			GetSQLValueString(time(), "int"),
			GetSQLValueString($ID, "int"),
			GetSQLValueString($nama, "text"),
			GetSQLValueString('Y', "text"),
			GetSQLValueString($ta, "text")
		);

		$Result1 = mysqli_query($koneksi, $insertSQL) or die(mysqli_error($koneksi));

		if ($Result1) {
			$Commit = mysqli_query($koneksi, "COMMIT") or die(errorQuery(mysqli_error($koneksi)));
			refresh('?page=scan/add');
		}
	}
}
?>