<?php
require_once('../require/header.php');

// Debug query untuk memeriksa data
$tgl1 = '2025-07-31';
$tgl2 = '2025-08-06';
$kat = 4;

echo "<h3>Debug Query untuk Filter Kategori</h3>";

// 1. Cek data di transaksidetail
echo "<h4>1. Data di transaksidetail dengan faktur '1753971822':</h4>";
$query_debug1 = "SELECT * FROM transaksidetail WHERE faktur = '1753971822'";
$result1 = mysqli_query($koneksi, $query_debug1);
if ($result1) {
    while ($row = mysqli_fetch_assoc($result1)) {
        echo "Faktur: " . $row['faktur'] . ", Nama: " . $row['nama'] . ", Kode: " . $row['kode'] . "<br>";
    }
} else {
    echo "Error: " . mysqli_error($koneksi);
}

// 2. Cek data di produk dengan nama 'VIXAL HARUM SEGAR 360ML'
echo "<h4>2. Data di produk dengan nama 'VIXAL HARUM SEGAR 360ML':</h4>";
$query_debug2 = "SELECT * FROM produk WHERE namaproduk LIKE '%VIXAL HARUM SEGAR 360ML%'";
$result2 = mysqli_query($koneksi, $query_debug2);
if ($result2) {
    while ($row = mysqli_fetch_assoc($result2)) {
        echo "ID: " . $row['idproduk'] . ", Nama: " . $row['namaproduk'] . ", Kategori: " . $row['kategori'] . "<br>";
    }
} else {
    echo "Error: " . mysqli_error($koneksi);
}

// 3. Cek join antara transaksidetail dan produk
echo "<h4>3. Join antara transaksidetail dan produk:</h4>";
$query_debug3 = "SELECT td.faktur, td.nama as td_nama, p.namaproduk as p_nama, p.kategori 
                 FROM transaksidetail td 
                 LEFT JOIN produk p ON td.nama = p.namaproduk 
                 WHERE td.faktur = '1753971822'";
$result3 = mysqli_query($koneksi, $query_debug3);
if ($result3) {
    while ($row = mysqli_fetch_assoc($result3)) {
        echo "Faktur: " . $row['faktur'] . ", TD Nama: " . $row['td_nama'] . ", P Nama: " . $row['p_nama'] . ", Kategori: " . $row['kategori'] . "<br>";
    }
} else {
    echo "Error: " . mysqli_error($koneksi);
}

// 4. Cek data faktur dengan tanggal yang dimaksud
echo "<h4>4. Data faktur dengan tanggal 2025-07-31 sampai 2025-08-06:</h4>";
$query_debug4 = "SELECT kodefaktur, tglfaktur, statusfaktur FROM faktur 
                 WHERE tglfaktur BETWEEN '2025-07-31' AND '2025-08-06' 
                 AND statusfaktur = 'Y' 
                 LIMIT 10";
$result4 = mysqli_query($koneksi, $query_debug4);
if ($result4) {
    while ($row = mysqli_fetch_assoc($result4)) {
        echo "Kode: " . $row['kodefaktur'] . ", Tanggal: " . $row['tglfaktur'] . ", Status: " . $row['statusfaktur'] . "<br>";
    }
} else {
    echo "Error: " . mysqli_error($koneksi);
}

// 5. Test query yang digunakan di page1.php
echo "<h4>5. Test query EXISTS untuk kategori 4:</h4>";
$query_debug5 = "SELECT a.kodefaktur, a.tglfaktur 
                 FROM faktur a 
                 WHERE (a.tglfaktur BETWEEN '2025-07-31' AND '2025-08-06') 
                 AND a.statusfaktur = 'Y' 
                 AND EXISTS (SELECT 1 FROM transaksidetail b 
                           INNER JOIN produk c ON b.nama = c.namaproduk 
                           WHERE b.faktur = a.kodefaktur AND c.kategori = 4)
                 LIMIT 5";
$result5 = mysqli_query($koneksi, $query_debug5);
if ($result5) {
    while ($row = mysqli_fetch_assoc($result5)) {
        echo "Kode: " . $row['kodefaktur'] . ", Tanggal: " . $row['tglfaktur'] . "<br>";
    }
} else {
    echo "Error: " . mysqli_error($koneksi);
}

// 6. Cek apakah ada data dengan kategori 4
echo "<h4>6. Data produk dengan kategori 4:</h4>";
$query_debug6 = "SELECT namaproduk, kategori FROM produk WHERE kategori = 4 LIMIT 5";
$result6 = mysqli_query($koneksi, $query_debug6);
if ($result6) {
    while ($row = mysqli_fetch_assoc($result6)) {
        echo "Nama: " . $row['namaproduk'] . ", Kategori: " . $row['kategori'] . "<br>";
    }
} else {
    echo "Error: " . mysqli_error($koneksi);
}

echo "<hr>";
echo "<h4>Kesimpulan:</h4>";
echo "Jika data tidak muncul, kemungkinan masalahnya adalah:<br>";
echo "1. Nama produk di transaksidetail tidak sama persis dengan namaproduk di tabel produk<br>";
echo "2. Data faktur tidak ada dalam rentang tanggal yang dimaksud<br>";
echo "3. Status faktur bukan 'Y'<br>";
echo "4. Join condition tidak tepat<br>";
?> 