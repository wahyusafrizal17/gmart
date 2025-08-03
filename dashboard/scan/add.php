<?php
require_once(dirname(__FILE__) . '/../../Connections/koneksi.php');
require_once('faktur.php');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

// Initialize variables if not set
if (!isset($ID) || empty($ID)) {
	$ID = 2; // Default admin ID
	$nama = 'GHALIH'; // Default admin name
}
if (!isset($ta) || empty($ta)) {
	$ta = '2024'; // Default periode
}
if (!isset($today) || empty($today)) {
	$today = date('Y-m-d');
}

// Process search and add to cart
if (isset($_POST['search']) && !empty($_POST['search'])) {
	$search_term = $_POST['search'];
	
	// Search for product
	$query_search = sprintf(
		"SELECT * FROM produk WHERE stok > 0 AND (kodeproduk = %s OR namaproduk LIKE %s) LIMIT 1",
		GetSQLValueString($search_term, "text"),
		GetSQLValueString("%" . $search_term . "%", "text")
	);
	
	$search = mysqli_query($koneksi, $query_search) or die(mysqli_error($koneksi));
	$totalRows_search = mysqli_num_rows($search);
	
	if ($totalRows_search > 0) {
		$row_search = mysqli_fetch_assoc($search);
		
		// Check if product already in cart
		$cek = sprintf(
			"SELECT kode, faktur, qty FROM transaksitemp WHERE kode = %s AND faktur = %s",
			GetSQLValueString($row_search['kodeproduk'], "text"),
			GetSQLValueString($faktur, "text")
		);
		
		$rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error($koneksi));
		$totalRows_rs_cek = mysqli_num_rows($rs_cek);
		
		if ($totalRows_rs_cek > 0) {
			// Update quantity if already in cart
			$updateSQL = sprintf(
				"UPDATE transaksitemp SET qty = qty + 1 WHERE faktur = %s AND kode = %s",
				GetSQLValueString($faktur, "text"),
				GetSQLValueString($row_search['kodeproduk'], "text")
			);
			mysqli_query($koneksi, $updateSQL) or die(mysqli_error($koneksi));
		} else {
			// Add new item to cart
			$insertSQL = sprintf(
				"INSERT INTO transaksitemp (`faktur`, `tanggal`, `kode`, `nama`, `harga`, `hargadasar`, `diskon`, `qty`, `added`, `addby`, `admintt`, `stt`, `periode`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
			mysqli_query($koneksi, $insertSQL) or die(mysqli_error($koneksi));
		}
		
		// Set success message and reload cart data
		$success_message = "Produk berhasil ditambahkan ke keranjang!";
		
		// Reload cart items after adding product
		$query_trans = sprintf(
			"SELECT * FROM transaksitemp INNER JOIN produk ON kode = kodeproduk WHERE faktur = %s ORDER BY transaksitemp.id ASC",
			GetSQLValueString($faktur, "text")
		);
		$trans = mysqli_query($koneksi, $query_trans) or die(mysqli_error($koneksi));
		$totalRows_trans = mysqli_num_rows($trans);
		
		// Recalculate totals
		$total_harga = 0;
		$total_qty = 0;
		$cart_items = [];
		while ($row = mysqli_fetch_assoc($trans)) {
			$subtotal = ($row['harga'] * $row['qty']) - $row['diskon'];
			$total_harga += $subtotal;
			$total_qty += $row['qty'];
			$cart_items[] = $row;
		}
	}
}

// Get cart items
$query_trans = sprintf(
	"SELECT * FROM transaksitemp INNER JOIN produk ON kode = kodeproduk WHERE faktur = %s ORDER BY transaksitemp.id ASC",
	GetSQLValueString($faktur, "text")
);
$trans = mysqli_query($koneksi, $query_trans) or die(mysqli_error($koneksi));
$totalRows_trans = mysqli_num_rows($trans);

// Calculate totals
$total_harga = 0;
$total_qty = 0;
$cart_items = [];
while ($row = mysqli_fetch_assoc($trans)) {
	$subtotal = ($row['harga'] * $row['qty']) - $row['diskon'];
	$total_harga += $subtotal;
	$total_qty += $row['qty'];
	$cart_items[] = $row;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>POS Scanner - GMart</title>
	
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../../assets/plugins/font-awesome/css/font-awesome.min.css">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../../assets/dist/css/AdminLTE.min.css">
	<!-- Quagga.js -->
	<script src="https://cdn.jsdelivr.net/npm/quagga@0.12.1/dist/quagga.min.js"></script>
	
	<style>
		body {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			min-height: 100vh;
			font-family: 'Source Sans Pro', sans-serif;
		}
		
		.pos-container {
			background: white;
			border-radius: 20px;
			margin: 20px;
			overflow: hidden;
		}
		
		.scanner-section {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			padding: 30px;
			color: white;
			text-align: center;
		}
		
		.scanner-input {
			background: rgba(255,255,255,0.95);
			border: none;
			border-radius: 25px;
			padding: 15px 25px;
			font-size: 18px;
			width: 100%;
			max-width: 400px;
			box-shadow: 0 5px 15px rgba(0,0,0,0.1);
			transition: all 0.3s ease;
		}
		
		.scanner-input:focus {
			transform: scale(1.02);
			box-shadow: 0 8px 25px rgba(0,0,0,0.15);
			outline: none;
		}
		
		.scan-btn {
			background: linear-gradient(135deg, #00d4aa 0%, #00b894 100%);
			border: none;
			border-radius: 25px;
			padding: 15px 30px;
			color: white;
			font-weight: bold;
			font-size: 16px;
			text-transform: uppercase;
			letter-spacing: 1px;
			transition: all 0.3s ease;
			margin: 10px;
		}
		
		.scan-btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 8px 25px rgba(0,0,0,0.2);
			color: white;
		}
		
		.cart-section {
			padding: 30px;
		}
		
		.cart-header {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			padding: 20px;
			border-radius: 15px 15px 0 0;
			margin-bottom: 0;
		}
		
		.cart-table {
			background: white;
			border-radius: 0 0 15px 15px;
			overflow: hidden;
			box-shadow: 0 5px 15px rgba(0,0,0,0.1);
		}
		
		.cart-item {
			padding: 15px;
			border-bottom: 1px solid #eee;
			transition: all 0.3s ease;
		}
		
		.cart-item:hover {
			background: #f8f9fa;
			transform: translateX(5px);
		}
		
		.product-info {
			font-weight: bold;
			color: #2c3e50;
			margin-bottom: 5px;
		}
		
		.product-code {
			color: #7f8c8d;
			font-size: 14px;
		}
		
		.quantity-badge {
			background: linear-gradient(135deg, #00d4aa 0%, #00b894 100%);
			color: white;
			padding: 8px 15px;
			border-radius: 20px;
			font-weight: bold;
		}
		
		.price-info {
			text-align: right;
		}
		
		.subtotal {
			font-weight: bold;
			color: #e74c3c;
			font-size: 18px;
		}
		
		.total-section {
			background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
			color: white;
			padding: 20px;
			border-radius: 15px;
			margin-top: 20px;
			text-align: center;
		}
		
		.total-amount {
			font-size: 32px;
			font-weight: bold;
			margin: 10px 0;
		}
		
		.camera-modal {
			background: rgba(0,0,0,0.8);
		}
		
		.camera-container {
			background: #000;
			border-radius: 15px;
			overflow: hidden;
			position: relative;
			width: 100%;
			height: 400px;
		}
		
		#video {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}
		
		.camera-overlay {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0,0,0,0.2);
			pointer-events: none;
		}
		
		.camera-overlay::before {
			content: '';
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			width: 250px;
			height: 150px;
			border: 3px solid #00ff00;
			border-radius: 10px;
			pointer-events: none;
			box-shadow: 0 0 20px rgba(0,255,0,0.5);
		}
		
		.camera-overlay::after {
			content: 'Posisikan barcode di dalam kotak hijau';
			position: absolute;
			bottom: 20px;
			left: 50%;
			transform: translateX(-50%);
			color: white;
			background: rgba(0,0,0,0.7);
			padding: 8px 16px;
			border-radius: 20px;
			font-size: 14px;
			pointer-events: none;
		}
		
		@keyframes pulse {
			0% { transform: scale(1); }
			50% { transform: scale(1.05); }
			100% { transform: scale(1); }
		}
		
		.pulse {
			animation: pulse 2s infinite;
		}
		
		.modal-content {
			border-radius: 15px;
			overflow: hidden;
		}
		
		.modal-header {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: white;
			border: none;
		}
		
		.btn-action {
			border-radius: 20px;
			padding: 8px 15px;
			font-size: 12px;
			font-weight: bold;
			text-transform: uppercase;
			transition: all 0.3s ease;
		}
		
		.btn-action:hover {
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(0,0,0,0.2);
		}
	</style>
</head>

<body>
	<div class="pos-container">
		<div class="row">
			<!-- Left Column: Scanner & Cart (col-md-8) -->
			<div class="col-md-8">
				<!-- Scanner Section -->
				<div class="panel panel-default" style="margin-bottom: 20px;">
					<div class="panel-heading" style="padding: 10px;">
						<h4 style="margin: 0; font-size: 16px;"><i class="fa fa-barcode"></i> SCANNER POS</h4>
					</div>
					<div class="panel-body" style="padding: 15px;">
						<?php if (isset($success_message)) { ?>
							<div class="alert alert-success" style="margin-bottom: 15px;">
								<i class="fa fa-check-circle"></i> <?php echo $success_message; ?>
							</div>
						<?php } ?>
						
						<form method="post" action="" id="scanForm">
							<div class="form-group">
								<input type="text" name="search" class="form-control" placeholder="Masukkan kode produk..." autofocus value="" style="height: 45px; font-size: 16px;">
							</div>
							<div class="row">
								<div class="col-md-6">
									<button type="submit" class="btn btn-primary btn-block">
										<i class="fa fa-search"></i> Cari Produk
									</button>
								</div>
								<div class="col-md-6">
									<button type="button" class="btn btn-info btn-block" onclick="openCamera()">
										<i class="fa fa-camera"></i> Scan Barcode
									</button>
								</div>
							</div>
						</form>
						
						<div style="margin-top: 15px; padding: 10px; background-color: #f5f5f5; border-radius: 5px; font-size: 12px;">
							<strong>Faktur:</strong> <?php echo $faktur; ?> | 
							<strong>Kasir:</strong> <?php echo $nama; ?> | 
							<strong>Tanggal:</strong> <?php echo date('d/m/Y'); ?>
						</div>
					</div>
				</div>
				
				<!-- Cart Section -->
				<div class="panel panel-default">
					<div class="panel-heading" style="padding: 10px;">
						<h4 style="margin: 0; font-size: 16px;"><i class="fa fa-shopping-cart"></i> KERANJANG BELANJA</h4>
					</div>
					<div class="panel-body" style="padding: 0;">
			
			<?php if ($totalRows_trans > 0) { ?>
				<div class="cart-table">
					<table class="table table-hover" style="margin: 0;">
						<thead>
							<tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
								<th width="5%">
									<div align="center"><strong>#</strong></div>
								</th>
								<th width="45%">
									<div align="center"><strong><i class="fa fa-tag"></i> PRODUK</strong></div>
								</th>
								<th width="10%">
									<div align="center"><strong><i class="fa fa-cubes"></i> QTY</strong></div>
								</th>
								<th width="20%">
									<div align="center"><strong><i class="fa fa-money"></i> HARGA</strong></div>
								</th>
								<th width="20%">
									<div align="center"><strong><i class="fa fa-calculator"></i> SUBTOTAL</strong></div>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 1;
							$idmodal = 1;
							foreach ($cart_items as $item) { ?>
								<tr style="font-size: 16px; transition: all 0.3s ease;" class="cart-item">
									<td>
										<div align="center">
											<span class="badge badge-primary" style="font-size: 14px; padding: 8px 12px; border-radius: 20px;">
												<?php echo $no; ?>
											</span>
										</div>
									</td>
									<td class="text-uppercase">
										<div style="padding: 10px; border-radius: 10px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); margin: 5px 0;">
											<div style="font-weight: bold; color: #2c3e50;">
												<i class="fa fa-barcode" style="color: #3498db;"></i> 
												<?php echo $item['kode']; ?>
											</div>
											<div style="font-size: 14px; color: #7f8c8d; margin-top: 5px;">
												<i class="fa fa-tag" style="color: #e74c3c;"></i> 
												<?php echo $item['nama']; ?>
											</div>
											<?php if ($item['diskon'] > 0) { ?>
												<div style="font-size: 12px; color: #e74c3c; margin-top: 5px;">
													<i class="fa fa-percent"></i> Diskon: Rp. <?= number_format($item['diskon'], 0, ",", "."); ?>
												</div>
											<?php } ?>
										</div>
									</td>
									<td align="center">
										<span class="badge badge-success" style="font-size: 16px; padding: 8px 15px; border-radius: 25px;">
											<i class="fa fa-cubes"></i> <?= $item['qty']; ?>
										</span>
									</td>
									<td align="right">
										<div style="font-weight: bold; color: #27ae60; font-size: 16px;">
											Rp. <?= number_format($item['harga'], 0, ",", "."); ?>
										</div>
									</td>
									<td align="right">
										<div style="font-weight: bold; color: #e74c3c; font-size: 16px; background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%); padding: 8px 12px; border-radius: 10px;">
											<i class="fa fa-calculator"></i> Rp. <?php $subtotal = ($item['harga'] * $item['qty']) - $item['diskon'];
															echo number_format($subtotal, 0, ",", "."); ?>
										</div>
									</td>
								</tr>
							<?php 
								$no++;
								$idmodal++;
							} ?>
						</tbody>
					</table>
				</div>
			<?php } else { ?>
				<div class="alert alert-info text-center" style="margin: 15px;">
					<i class="fa fa-shopping-cart fa-2x" style="color: #5bc0de; margin-bottom: 10px;"></i>
					<h5>Keranjang Kosong</h5>
					<p style="margin: 0; font-size: 12px;">Belum ada produk dalam keranjang</p>
				</div>
			<?php } ?>
					</div>
				</div>
			</div>
			
			<!-- Right Column: Faktur & Payment (col-md-4) -->
			<div class="col-md-4">
				<!-- Faktur Card -->
				<div class="panel panel-primary" style="margin-bottom: 15px;">
					<div class="panel-heading" style="text-align: center; padding: 10px;">
						<h4 style="margin: 0; font-size: 14px;"><i class="fa fa-ticket"></i> INFORMASI TRANSAKSI</h4>
					</div>
					<div class="panel-body" style="padding: 15px;">
						<div style="margin-bottom: 10px;">
							<strong>No. Faktur:</strong><br>
							<span style="font-size: 16px; color: #337ab7;"><?= $faktur; ?></span>
						</div>
						<div style="margin-bottom: 10px;">
							<strong>Kasir:</strong><br>
							<span style="font-size: 14px;"><?= $nama; ?></span>
						</div>
						<div>
							<strong>Tanggal:</strong><br>
							<span style="font-size: 12px;"><?= date('d/m/Y H:i'); ?></span>
						</div>
					</div>
				</div>
				
				<!-- Total Section -->
				<?php if ($totalRows_trans > 0) { ?>
				<div class="panel panel-success" style="margin-bottom: 15px;">
					<div class="panel-heading" style="text-align: center; padding: 10px;">
						<h4 style="margin: 0; font-size: 14px;"><i class="fa fa-calculator"></i> TOTAL TRANSAKSI</h4>
					</div>
					<div class="panel-body" style="padding: 15px;">
						<div style="margin-bottom: 15px;">
							<strong>Total Item:</strong><br>
							<span style="font-size: 20px; color: #5cb85c;"><?php echo $total_qty; ?></span>
						</div>
						
						<div style="margin-bottom: 20px;">
							<strong>Total Harga:</strong><br>
							<span style="font-size: 18px; color: #5cb85c; font-weight: bold;">Rp. <?php echo number_format($total_harga, 0, ',', '.'); ?></span>
						</div>
						
						<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#paymentModal">
							<i class="fa fa-credit-card"></i> Checkout
						</button>
					</div>
				</div>
				<?php } else { ?>
				<div class="panel panel-info" style="margin-bottom: 15px;">
					<div class="panel-heading" style="text-align: center; padding: 10px;">
						<h4 style="margin: 0; font-size: 14px;"><i class="fa fa-shopping-cart"></i> KERANJANG</h4>
					</div>
					<div class="panel-body" style="padding: 15px; text-align: center;">
						<i class="fa fa-shopping-cart fa-2x" style="color: #5bc0de; margin-bottom: 10px;"></i>
						<p style="margin: 0; font-size: 12px;">Keranjang kosong</p>
						<p style="margin: 5px 0 0 0; font-size: 11px; color: #777;">Mulai scan produk</p>
					</div>
				</div>
				<?php } ?>
				
				<!-- Action Buttons -->
				<div class="panel panel-default" style="margin-bottom: 15px;">
					<div class="panel-heading" style="text-align: center; padding: 10px;">
						<h4 style="margin: 0; font-size: 14px;"><i class="fa fa-cogs"></i> MENU</h4>
					</div>
					<div class="panel-body" style="padding: 10px;">
						<a href="?page=tabulasi/penjualan" class="btn btn-warning btn-sm btn-block" style="margin-bottom: 8px;">
							<i class="fa fa-history"></i> Riwayat
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Payment Modal -->
	<?php if ($totalRows_trans > 0) { ?>
	<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Pembayaran</h4>
				</div>
				<div class="modal-body">
					<div style="font-size: 50px; background-color:darkcyan; padding-right:15px; color:white;" class="text-right">
						Rp. <?= number_format($total_harga); ?>
					</div>
					<form method="post" name="formSelesai" action="<?php echo $editFormAction; ?>" autocomplete="off">
						<div class="table-responsive">
							<table class="table no-border">
								<tr>
									<td width="40%"><strong>UANG BAYAR</strong></td> 
									<td>
										<input type="hidden" name="textfield3" id="gt" value="<?= $total_harga; ?>" />
										<input type="text" name="bayar" id="tunai" placeholder="<?= $total_harga; ?>" class="form-control input-lg text-right" style="font-size: 45px;" onkeyup="kembalian();" autofocus />
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
									<td>
										<select name="jenisbayar" class="form-control">
											<option value="CASH">CASH</option>
											<option value="TRANSFER">TRANSFER</option>
											<option value="SHOPEEPAY">SHOPEEPAY</option>
											<option value="MERCHANT">MERCHANT</option>
										</select>
									</td>
								</tr>
								<tr>
									<td><strong>NO. HP </strong><small>(Opsional)</small></td>
									<td>
										<input name="nohp" type="text" class="form-control text-uppercase" style="font-size: 22px;" />
									</td>
								</tr>
								<tr>
									<td><strong>NAMA PELANGGAN</strong> <br><small>(Opsional)</small></td>
									<td>
										<select name="namapelanggan" class="form-control">
											<option value=""></option>
											<?php 
											$cek = "SELECT * FROM member";
											$rs_cek = mysqli_query($koneksi, $cek) or die(mysqli_error($koneksi));
											while ($data = mysqli_fetch_assoc($rs_cek)) { ?>
												<option value="<?php echo $data['nama_member'] ?>"><?php echo $data['nama_member'] ?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
							</table>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="MM_update" value="formSelesai" />
							<button type="submit" class="btn btn-lg btn-block btn-success">
								<span class="fa fa-print"></span> <strong>SIMPAN TRANSAKSI</strong>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	
	<!-- Camera Modal -->
	<div class="modal fade" id="cameraModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
					<h4 class="modal-title">
						<i class="fa fa-camera"></i> Barcode Scanner
					</h4>
					<!-- <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button> -->
				</div>
				<div class="modal-body">
					<div class="camera-container">
						<video id="video" width="100%" height="400" autoplay playsinline muted></video>
						<div class="camera-overlay"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" onclick="stopCamera()" data-dismiss="modal">Stop</button>
					<button type="button" class="btn btn-primary" onclick="startCamera()">Start</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- jQuery -->
	<script src="../../assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
	
	<script>
		let scanning = false;
		
		function openCamera() {
			$('#cameraModal').modal('show');
			setTimeout(() => {
				startCamera();
			}, 500);
		}
		
		function startCamera() {
			if (scanning) return;
			
			console.log("Starting camera...");
			
			// Stop any existing camera
			Quagga.stop();
			
			// Check if video element exists
			const videoElement = document.querySelector('#video');
			if (!videoElement) {
				console.error("Video element not found");
				alert('Video element tidak ditemukan');
				return;
			}
			
			console.log("Video element found:", videoElement);
			
			Quagga.init({
				inputStream: {
					name: "Live",
					type: "LiveStream",
					target: videoElement,
					constraints: {
						width: { min: 640, ideal: 1280, max: 1920 },
						height: { min: 480, ideal: 720, max: 1080 },
						facingMode: "environment",
						aspectRatio: { min: 1, max: 2 }
					},
				},
				decoder: {
					readers: [
						"code_128_reader",
						"ean_reader",
						"ean_8_reader",
						"code_39_reader",
						"code_39_vin_reader",
						"codabar_reader",
						"upc_reader",
						"upc_e_reader",
						"i2of5_reader"
					]
				},
				locate: true,
				frequency: 10
			}, function(err) {
				if (err) {
					console.error("Failed to initialize camera:", err);
					alert('Tidak dapat mengakses kamera. Pastikan browser mendukung WebRTC dan izin kamera diberikan.');
					return;
				}
				
				console.log("Camera initialized successfully");
				scanning = true;
				Quagga.start();
				
				// Check if video is playing
				setTimeout(() => {
					if (videoElement.readyState >= 2) {
						console.log("Video is playing successfully");
					} else {
						console.warn("Video might not be playing");
					}
				}, 1000);
			});
			
			Quagga.onDetected(function(result) {
				if (result && result.codeResult) {
					const code = result.codeResult.code;
					console.log("Barcode detected:", code);
					
					// Update input field
					$('input[name="search"]').val(code);
					
					// Submit form
					$('#scanForm').submit();
					
					// Stop camera
					setTimeout(() => {
						stopCamera();
						$('#cameraModal').modal('hide');
					}, 1000);
				}
			});
			
			// Add error handling for camera stream
			Quagga.onProcessed(function(result) {
				if (result) {
					console.log("Camera stream is working");
				}
			});
		}
		
		function stopCamera() {
			if (scanning) {
				Quagga.stop();
				scanning = false;
			}
		}
		
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
		
		// Auto focus on search input
		$(document).ready(function() {
			$('input[name="search"]').focus();
			
			// Auto submit on Enter key
			$('input[name="search"]').keypress(function(e) {
				if (e.which == 13) {
					$('#scanForm').submit();
				}
			});
			
			// Clear input after successful submission
			$('#scanForm').on('submit', function() {
				setTimeout(function() {
					$('input[name="search"]').val('').focus();
				}, 100);
			});
			

		});
		
		// Camera modal events
		$('#cameraModal').on('hidden.bs.modal', function() {
			stopCamera();
		});
	</script>
</body>
</html>
