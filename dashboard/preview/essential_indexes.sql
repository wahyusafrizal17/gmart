-- =====================================================
-- INDEX ESENSIAL UNTUK OPTIMASI QUERY PENJUALAN
-- =====================================================
-- File ini berisi index yang paling penting untuk mempercepat query
-- Jalankan file ini di database MySQL untuk menambahkan index

-- =====================================================
-- 1. INDEX PENTING UNTUK TABEL FAKTUR
-- =====================================================

-- Index untuk filter tanggal (sangat penting untuk query BETWEEN)
CREATE INDEX idx_faktur_tglfaktur ON faktur(tglfaktur);

-- Index untuk filter status faktur (sangat sering digunakan)
CREATE INDEX idx_faktur_statusfaktur ON faktur(statusfaktur);

-- Index untuk filter kasir (addbyfaktur)
CREATE INDEX idx_faktur_addbyfaktur ON faktur(addbyfaktur);

-- Index untuk filter jenis bayar
CREATE INDEX idx_faktur_jenisbayar ON faktur(jenisbayar);

-- Index untuk filter periode
CREATE INDEX idx_faktur_periode ON faktur(periode);

-- Composite index untuk kombinasi yang paling sering digunakan
-- Index untuk: statusfaktur + addbyfaktur + tglfaktur + periode
CREATE INDEX idx_faktur_status_kasir_tgl_periode ON faktur(statusfaktur, addbyfaktur, tglfaktur, periode);

-- =====================================================
-- 2. INDEX PENTING UNTUK TABEL TRANSAKSIDETAIL
-- =====================================================

-- Index untuk filter nama produk (untuk JOIN dengan produk)
CREATE INDEX idx_transaksidetail_nama ON transaksidetail(nama);

-- Composite index untuk faktur + nama (sangat penting untuk JOIN)
CREATE INDEX idx_transaksidetail_faktur_nama ON transaksidetail(faktur, nama);

-- =====================================================
-- 3. INDEX PENTING UNTUK TABEL PRODUK
-- =====================================================

-- Index untuk filter nama produk (untuk JOIN dengan transaksidetail)
CREATE INDEX idx_produk_namaproduk ON produk(namaproduk);

-- Composite index untuk kategori + namaproduk
CREATE INDEX idx_produk_kategori_namaproduk ON produk(kategori, namaproduk);

-- =====================================================
-- 4. INDEX PENTING UNTUK TABEL LAINNYA
-- =====================================================

-- Index untuk filter tanggal pengeluaran
CREATE INDEX idx_pengeluaran_tgl ON pengeluaran(tgl);

-- =====================================================
-- PENJELASAN INDEX YANG DITAMBAHKAN
-- =====================================================

/*
INDEX YANG DITAMBAHKAN:

1. TABEL FAKTUR:
   - idx_faktur_tglfaktur: Untuk query BETWEEN tanggal
   - idx_faktur_statusfaktur: Untuk filter status faktur
   - idx_faktur_addbyfaktur: Untuk filter kasir
   - idx_faktur_jenisbayar: Untuk filter jenis bayar
   - idx_faktur_periode: Untuk filter periode
   - idx_faktur_status_kasir_tgl_periode: Composite index untuk kombinasi yang sering digunakan

2. TABEL TRANSAKSIDETAIL:
   - idx_transaksidetail_nama: Untuk JOIN dengan produk
   - idx_transaksidetail_faktur_nama: Composite index untuk faktur + nama (sangat penting)

3. TABEL PRODUK:
   - idx_produk_namaproduk: Untuk JOIN dengan transaksidetail
   - idx_produk_kategori_namaproduk: Composite index untuk kategori + namaproduk

4. TABEL PENGGELUARAN:
   - idx_pengeluaran_tgl: Untuk filter tanggal pengeluaran

QUERY YANG AKAN DIOPTIMASI:

1. Query utama dengan filter kategori:
   SELECT ... FROM faktur 
   WHERE statusfaktur = 'Y' AND addbyfaktur = ? AND (tglfaktur BETWEEN ? AND ?) AND periode = ? 
   AND kodefaktur IN (SELECT DISTINCT faktur FROM transaksidetail td INNER JOIN produk p ON td.nama = p.namaproduk WHERE p.kategori = ?)
   
   Index yang digunakan:
   - idx_faktur_status_kasir_tgl_periode (statusfaktur, addbyfaktur, tglfaktur, periode)
   - idx_transaksidetail_faktur_nama (faktur, nama)
   - idx_produk_kategori_namaproduk (kategori, namaproduk)

2. Query laba dengan JOIN:
   SELECT SUM(...) FROM transaksidetail td
   INNER JOIN faktur f ON td.faktur = f.kodefaktur
   INNER JOIN produk p ON td.nama = p.namaproduk
   WHERE f.statusfaktur = 'Y' AND f.addbyfaktur = ? AND (f.tglfaktur BETWEEN ? AND ?) AND f.periode = ? AND p.kategori = ?
   
   Index yang digunakan:
   - idx_faktur_status_kasir_tgl_periode (statusfaktur, addbyfaktur, tglfaktur, periode)
   - idx_transaksidetail_faktur_nama (faktur, nama)
   - idx_produk_kategori_namaproduk (kategori, namaproduk)
*/

-- =====================================================
-- CARA MENJALANKAN
-- =====================================================

/*
1. Backup database terlebih dahulu
2. Jalankan file ini di MySQL:
   mysql -u username -p database_name < essential_indexes.sql
   
   Atau copy-paste isi file ini ke phpMyAdmin

3. Test performance:
   - Jalankan query yang sama sebelum dan sesudah menambah index
   - Bandingkan waktu eksekusi
   - Gunakan EXPLAIN untuk melihat penggunaan index

4. Monitor:
   - Perhatikan penggunaan disk space
   - Monitor performance INSERT/UPDATE/DELETE
   - Cek apakah index digunakan dengan EXPLAIN
*/

-- =====================================================
-- VERIFIKASI INDEX
-- =====================================================

-- Untuk mengecek index yang sudah ada:
-- SHOW INDEX FROM faktur;
-- SHOW INDEX FROM transaksidetail;
-- SHOW INDEX FROM produk;
-- SHOW INDEX FROM pengeluaran;

-- Untuk testing performance:
-- EXPLAIN SELECT ... FROM faktur WHERE ... (query lengkap)
