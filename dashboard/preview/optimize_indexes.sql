-- =====================================================
-- OPTIMASI INDEX UNTUK QUERY PENJUALAN
-- =====================================================
-- File ini berisi index yang diperlukan untuk mempercepat query
-- Jalankan file ini di database MySQL untuk menambahkan index

-- =====================================================
-- 1. INDEX UNTUK TABEL FAKTUR
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

-- Composite index untuk kombinasi yang sering digunakan
-- Index untuk: statusfaktur + addbyfaktur + tglfaktur + periode
CREATE INDEX idx_faktur_status_kasir_tgl_periode ON faktur(statusfaktur, addbyfaktur, tglfaktur, periode);

-- Index untuk: statusfaktur + jenisbayar + addbyfaktur + tglfaktur + periode
CREATE INDEX idx_faktur_status_jenis_kasir_tgl_periode ON faktur(statusfaktur, jenisbayar, addbyfaktur, tglfaktur, periode);

-- Index untuk sorting (idfaktur DESC)
CREATE INDEX idx_faktur_idfaktur_desc ON faktur(idfaktur DESC);

-- =====================================================
-- 2. INDEX UNTUK TABEL TRANSAKSIDETAIL
-- =====================================================

-- Index untuk foreign key faktur (sudah ada, tapi pastikan)
-- CREATE INDEX idx_transaksidetail_faktur ON transaksidetail(faktur);

-- Index untuk filter nama produk (untuk JOIN dengan produk)
CREATE INDEX idx_transaksidetail_nama ON transaksidetail(nama);

-- Index untuk filter tanggal
CREATE INDEX idx_transaksidetail_tanggal ON transaksidetail(tanggal);

-- Index untuk filter periode
CREATE INDEX idx_transaksidetail_periode ON transaksidetail(periode);

-- Composite index untuk faktur + nama (sangat penting untuk JOIN)
CREATE INDEX idx_transaksidetail_faktur_nama ON transaksidetail(faktur, nama);

-- =====================================================
-- 3. INDEX UNTUK TABEL PRODUK
-- =====================================================

-- Index untuk filter kategori (sudah ada, tapi pastikan)
-- CREATE INDEX idx_produk_kategori ON produk(kategori);

-- Index untuk filter nama produk (untuk JOIN dengan transaksidetail)
CREATE INDEX idx_produk_namaproduk ON produk(namaproduk);

-- Composite index untuk kategori + namaproduk
CREATE INDEX idx_produk_kategori_namaproduk ON produk(kategori, namaproduk);

-- =====================================================
-- 4. INDEX UNTUK TABEL KATEGORI
-- =====================================================

-- Index untuk filter idkategori (sudah ada PRIMARY KEY)
-- CREATE INDEX idx_kategori_idkategori ON kategori(idkategori);

-- =====================================================
-- 5. INDEX UNTUK TABEL PENGGELUARAN
-- =====================================================

-- Index untuk filter tanggal
CREATE INDEX idx_pengeluaran_tgl ON pengeluaran(tgl);

-- =====================================================
-- 6. INDEX UNTUK TABEL KASSA
-- =====================================================

-- Index untuk filter id (untuk JOIN dengan faktur.addbyfaktur)
CREATE INDEX idx_kassa_id ON kassa(id);

-- =====================================================
-- 7. INDEX UNTUK TABEL TB_TA
-- =====================================================

-- Index untuk filter kode_ta (untuk JOIN dengan faktur.periode)
CREATE INDEX idx_tb_ta_kode_ta ON tb_ta(kode_ta);

-- =====================================================
-- ANALISIS QUERY YANG AKAN DIOPTIMASI
-- =====================================================

/*
QUERY YANG AKAN DIOPTIMASI:

1. Query utama dengan filter kategori:
   SELECT ... FROM faktur 
   WHERE statusfaktur = 'Y' AND addbyfaktur = ? AND (tglfaktur BETWEEN ? AND ?) AND periode = ? 
   AND kodefaktur IN (SELECT DISTINCT faktur FROM transaksidetail td INNER JOIN produk p ON td.nama = p.namaproduk WHERE p.kategori = ?)
   
   Index yang digunakan:
   - idx_faktur_status_kasir_tgl_periode (statusfaktur, addbyfaktur, tglfaktur, periode)
   - idx_transaksidetail_faktur_nama (faktur, nama)
   - idx_produk_kategori_namaproduk (kategori, namaproduk)

2. Query dengan semua filter:
   SELECT ... FROM faktur 
   WHERE jenisbayar = ? AND addbyfaktur = ? AND (tglfaktur BETWEEN ? AND ?) AND statusfaktur = 'Y' AND periode = ? 
   AND kodefaktur IN (SELECT DISTINCT faktur FROM transaksidetail td INNER JOIN produk p ON td.nama = p.namaproduk WHERE p.kategori = ?)
   
   Index yang digunakan:
   - idx_faktur_status_jenis_kasir_tgl_periode (statusfaktur, jenisbayar, addbyfaktur, tglfaktur, periode)
   - idx_transaksidetail_faktur_nama (faktur, nama)
   - idx_produk_kategori_namaproduk (kategori, namaproduk)

3. Query laba dengan JOIN:
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
-- VERIFIKASI INDEX YANG SUDAH ADA
-- =====================================================

-- Untuk melihat index yang sudah ada, jalankan:
-- SHOW INDEX FROM faktur;
-- SHOW INDEX FROM transaksidetail;
-- SHOW INDEX FROM produk;
-- SHOW INDEX FROM kategori;

-- =====================================================
-- TESTING PERFORMANCE
-- =====================================================

-- Untuk testing performance, jalankan:
-- EXPLAIN SELECT ... FROM faktur WHERE ... (query lengkap)

-- =====================================================
-- CATATAN PENTING
-- =====================================================

/*
1. Index akan mempercepat query SELECT tapi memperlambat INSERT/UPDATE/DELETE
2. Index memakan ruang disk tambahan
3. Index harus di-maintain oleh MySQL
4. Gunakan EXPLAIN untuk melihat apakah index digunakan
5. Monitor performance sebelum dan sesudah menambah index

REKOMENDASI:
- Jalankan index ini pada waktu low traffic
- Test di environment development dulu
- Monitor performance setelah implementasi
- Backup database sebelum menambah index
*/
