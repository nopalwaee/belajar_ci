# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> The end of life date for PHP 7.4 was November 28, 2022.
> The end of life date for PHP 8.0 was November 26, 2023.
> If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> The end of life date for PHP 8.1 will be November 25, 2024.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library


# Aplikasi Toko - CodeIgniter 4

Aplikasi Toko ini adalah sistem manajemen transaksi sederhana berbasis web yang dibangun menggunakan framework **CodeIgniter 4**. Aplikasi ini menyediakan fitur manajemen produk, keranjang belanja, checkout transaksi, serta integrasi API internal untuk pengambilan data transaksi.

## 🛠️ Fitur

Berikut adalah daftar fitur yang telah diterapkan dalam proyek ini:

### 🔒 Otentikasi
- Login dengan username dan password
- Validasi role pengguna (Admin, Kasir, dll)

### 📦 Manajemen Produk
- CRUD kategori produk
- CRUD produk
- Penerapan diskon per produk menggunakan session

### 🛒 Keranjang Belanja
- Menambahkan produk ke dalam keranjang menggunakan library `Cart`
- Diskon langsung diterapkan dari data session pada saat memasukkan produk
- Update dan hapus item dari keranjang

### 💰 Transaksi
- Checkout transaksi
- Penyimpanan detail transaksi ke dalam database
- Perhitungan total harga, ongkos kirim, dan total bayar
- Jumlah item dihitung dari data transaksi detail (`jumlah`)
- Status transaksi: Selesai / Belum Selesai

### 🔌 API Internal (RESTful)
- Endpoint `GET /api` untuk mengambil semua data transaksi
- Autentikasi menggunakan API Key dari header
- Mengembalikan informasi lengkap termasuk username, alamat, total harga, ongkir, jumlah item, dan detail produk

### 📊 Dashboard
- Menampilkan daftar transaksi dari API
- Tabel responsif dengan informasi total item, total bayar, status, dan tanggal transaksi

---

## ⚙️ Instalasi

1. **Clone repositori**
   ```bash
   git clone https://github.com/nopalwaee/belajar_ci.git
   cd belajar_ci
 

 ├── app/
│   ├── Controllers/
│   │   ├── ApiController.php      # Endpoint REST API transaksi
│   │   ├── ProductController.php  # CRUD produk & kategori
│   │   └── CartController.php     # Keranjang belanja & checkout
│   ├── Models/
│   │   ├── ProductModel.php
│   │   ├── CategoryModel.php
│   │   ├── TransactionModel.php
│   │   └── TransactionDetailModel.php
│   ├── Views/
│   │   ├── v_dashboard.php        # Dashboard transaksi (fetch API)
│   │   ├── v_product.php
│   │   ├── v_cart.php
│   │   └── ...
├── public/
│   └── index.php
├── writable/
├── .env
├── composer.json
└── README.md
