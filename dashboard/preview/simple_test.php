<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include header jika diperlukan
if (file_exists('../require/header.php')) {
    require_once('../require/header.php');
}

echo "<h2>Test Query Kategori</h2>";

// Parameter test
$tgl1 = '2025-07-31';
$tgl2 = '2025-08-06';
$kat = 4;

echo "<p>Parameter: tgl1=$tgl1, tgl2=$tgl2, kategori=$kat</p>";

// Test 1: Cek koneksi database
echo "<h3>1. Test Koneksi Database</h3>";
if (isset($koneksi)) {
    echo "✓ Koneksi database tersedia<br>";
} else {
    echo "✗ Koneksi database tidak tersedia<br>";
    exit;
}

// Test 2: Cek data faktur
echo "<h3>2. Test Data Faktur</h3>";
$query_faktur = "SELECT COUNT(*) as total FROM faktur WHERE tglfaktur BETWEEN '$tgl1' AND '$tgl2' AND statusfaktur = 'Y'";
$result = mysqli_query($koneksi, $query_faktur);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo "Total faktur dalam rentang tanggal: " . $row['total'] . "<br>";
} else {
    echo "Error query faktur: " . mysqli_error($koneksi) . "<br>";
}

// Test 3: Cek data produk dengan kategori 4
echo "<h3>3. Test Data Produk Kategori 4</h3>";
$query_produk = "SELECT COUNT(*) as total FROM produk WHERE kategori = $kat";
$result = mysqli_query($koneksi, $query_produk);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo "Total produk kategori $kat: " . $row['total'] . "<br>";
} else {
    echo "Error query produk: " . mysqli_error($koneksi) . "<br>";
}

// Test 4: Cek join sederhana
echo "<h3>4. Test Join Sederhana</h3>";
$query_join = "SELECT COUNT(*) as total 
               FROM transaksidetail td 
               INNER JOIN produk p ON td.nama = p.namaproduk 
               WHERE p.kategori = $kat";
$result = mysqli_query($koneksi, $query_join);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo "Total transaksi dengan produk kategori $kat: " . $row['total'] . "<br>";
} else {
    echo "Error query join: " . mysqli_error($koneksi) . "<br>";
}

// Test 5: Query yang lebih sederhana
echo "<h3>5. Test Query Sederhana</h3>";
$query_simple = "SELECT a.kodefaktur, a.tglfaktur 
                 FROM faktur a 
                 WHERE (a.tglfaktur BETWEEN '$tgl1' AND '$tgl2') 
                 AND a.statusfaktur = 'Y' 
                 AND EXISTS (SELECT 1 FROM transaksidetail b 
                           INNER JOIN produk c ON b.nama = c.namaproduk 
                           WHERE b.faktur = a.kodefaktur AND c.kategori = $kat)
                 LIMIT 5";
$result = mysqli_query($koneksi, $query_simple);
if ($result) {
    $count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $count++;
        echo "Faktur $count: " . $row['kodefaktur'] . " - " . $row['tglfaktur'] . "<br>";
    }
    if ($count == 0) {
        echo "Tidak ada data yang ditemukan<br>";
    }
} else {
    echo "Error query sederhana: " . mysqli_error($koneksi) . "<br>";
}

// Test 6: Cek data spesifik faktur 1753971822
echo "<h3>6. Test Data Faktur 1753971822</h3>";
$query_specific = "SELECT td.faktur, td.nama, p.namaproduk, p.kategori 
                   FROM transaksidetail td 
                   LEFT JOIN produk p ON td.nama = p.namaproduk 
                   WHERE td.faktur = '1753971822'";
$result = mysqli_query($koneksi, $query_specific);
if ($result) {
    $count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $count++;
        echo "Data $count: Faktur=" . $row['faktur'] . ", TD Nama='" . $row['nama'] . "', P Nama='" . $row['namaproduk'] . "', Kategori=" . $row['kategori'] . "<br>";
    }
    if ($count == 0) {
        echo "Tidak ada data untuk faktur 1753971822<br>";
    }
} else {
    echo "Error query spesifik: " . mysqli_error($koneksi) . "<br>";
}

echo "<hr>";
echo "<h3>Kesimpulan</h3>";
echo "Jika website ngeblank, kemungkinan penyebabnya:<br>";
echo "1. Error dalam query yang kompleks<br>";
echo "2. Memory limit terlampaui<br>";
echo "3. Timeout karena query terlalu lama<br>";
echo "4. Syntax error dalam query<br>";
?> 