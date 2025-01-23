# Form Login dan register dengan Enkripsi RSA dengan PHP
## Deskripsi
tujuan dari proyek ini adalah untuk membuat form login dan register yang aman dengan menggunakan metode enkripsi RSA menggunakan bahasa PHP. 
untuk data login akan dienkripsi menggunakan kunci private dan akan dideskripsi menggunakan kunci publik oleh pengguna yang akan mendapatkan 
serta kelengkapan validasi input serta sanitasi data.. dan tidak lupa keamanannya untuk mencegah sql injection dan XSS

## Fitur 
- Login dengan enkripsi RSA.
- Registrasi pengguna baru.
- Sistem logout.
- Penyimpanan data di database.
  
## Teknologi yang digunakan
- bahasa pemograman = php
- server lokal = laragon
- library yang digunakan = vendor phpseclib3


## Struktur folder
```
loginRSA/
├── buatrsa.php            # Script untuk membuat kunci RSA 
├── composer.json          # File konfigurasi Composer
├── composer.lock          # File lock Composer
├── database.php           # Koneksi database
├── index.php              # Halaman register
├── keluar.php             # Script untuk logout
├── login.php              # Script untuk login
├── registrasi.php         # Script untuk halaman index
├── style.css              # File CSS untuk styling
├── keys/                  # Folder berisi kunci public dan private
```

## Cara kerja
1. Pembuatan kunci RSA
   - jalankan buatrsa.php untuk melihat kunci rsa
   - kunci berada di dalam keys untuk publik dan private
2. proses login dan register
   - user memasukkan nama email serta password terlebih dahulu kedalam register didalam index.php
   - data dienkripsi menggunakan kunci public dan private
3. validasi dan sanitasi
   - terdapat error jika salah inputan
   - input disanitasi untuk pencegahan sql injection dan XSS

## Pengujian
- register berhasil: memasukkan data dengan benar kedalam form
- login berhasil : ketika pengguna sudah memasukkan data dari halaman registrasi
- login gagal :menampilkan pesan kesalahan untuk kredensial yang salah
- Keamanan Input: Uji dengan input berbahaya untuk memastikan sanitasi bekerja.

## Dokumentasi
- penjelasan berada README ini
- kami menggunakan

## Kontribusi tim
- BACKEND DEV = mohamad farhat, dwiki kurniawan
- Dokumentasi = mohamad farhat
- pengujian = alif makasau, dwiki kurniawan, farrel eagan

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](./LICENSE).
   
