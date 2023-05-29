<?php

use App\Http\Controllers\dashboard_Controller;
use App\Http\Controllers\home_Controller;
use App\Http\Controllers\kategori_Produk_Controller;
use App\Http\Controllers\keranjang_Controller;
use App\Http\Controllers\laporan_Penjualan_Offline_Controller;
use App\Http\Controllers\laporan_Penjualan_Online_Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\pembelian_Ball_Controller;
use App\Http\Controllers\penjualan_Offline_Controller;
use App\Http\Controllers\penjualan_Online_Controller;
use App\Http\Controllers\produk_Controller;
use App\Http\Controllers\promo_Controller;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\User_Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Halaman Admin
Route::get('/admin/login', [LoginController::class, 'view_Login_Admin'])->name('login-admin');

Route::post('/admin/login-admin', [LoginController::class, 'authenticate_admin'])->name('authenticateAdmin');

Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logoutAdmin');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/produk', [produk_Controller::class, 'index'])->name('viewProduk');

    Route::get('/dataProduk', [produk_Controller::class, 'data_produk'])->name('dataProduk');

    Route::get('/admin/produk/edit/{produk}', [produk_Controller::class, 'view_Edit'])->name('viewEditProduk');

    Route::post('/admin/produk/edit', [produk_Controller::class, 'proses_Edit'])->name('editProduk');

    Route::post('/admin/produk/store', [produk_Controller::class, 'proses_Store'])->name('tambahProduk');

    Route::get('/admin/produk/hapus/{produk}', [produk_Controller::class, 'hapus'])->name('hapusProduk');

    Route::get('/admin/detail-produk/{produk}', [produk_Controller::class, 'view_Detail_Produk'])->name('viewDetailProduk');

    Route::get('/dataDetailProduk/{produk}', [produk_Controller::class, 'data_Detail_Produk'])->name('dataDetailProduk');

    Route::post('/admin/detail-produk/store', [produk_Controller::class, 'proses_Store_Detail_Produk'])->name('tambahDetailProduk');

    Route::get('/admin/produk/checkout', [produk_Controller::class, 'proses_Checkout'])->name('checkout');

    Route::get('/admin/detail-produk/hapus/{detail_produk}', [produk_Controller::class, 'hapus_Detail_Produk'])->name('hapusDetailProduk');

    Route::get('/admin/kategori-produk', [kategori_Produk_Controller::class, 'index'])->name('viewKategoriProduk');

    Route::get('/dataKategoriProduk', [kategori_Produk_Controller::class, 'data_Kategori_Produk'])->name('dataKategoriProduk');

    Route::get('/admin/kategori-produk/edit/{kategori_produk}', [kategori_Produk_Controller::class, 'view_Edit'])->name('viewEditKategoriProduk');

    Route::post('/admin/kategori-produk/edit', [kategori_Produk_Controller::class, 'proses_Edit'])->name('editKategoriProduk');

    Route::get('/admin/kategori-produk/hapus/{kategori_produk}', [kategori_Produk_Controller::class, 'hapus'])->name('hapusKategoriProduk');

    Route::post('/admin/kategori-produk/store', [kategori_Produk_Controller::class, 'proses_Store'])->name('tambahKategoriProduk');

    Route::get('/admin/promo', [promo_Controller::class, 'index'])->name('viewPromo');

    Route::get('/dataPromo', [promo_Controller::class, 'data_Promo'])->name('dataPromo');

    Route::post('/admin/promo/store', [promo_Controller::class, 'proses_Store_Promo'])->name('tambahPromo');

    Route::get('/admin/promo/hapus/{promo}', [promo_Controller::class, 'proses_Hapus_Promo'])->name('hapusPromo');

    Route::get('/admin/promo/edit/{promo}', [promo_Controller::class, 'view_Edit_Promo'])->name('viewEditPromo');

    Route::post('/admin/promo/edit', [promo_Controller::class, 'proses_Edit_Promo'])->name('editPromo');

    Route::get('/admin/detail-promo/{promo}', [promo_Controller::class, 'view_Detail_Promo'])->name('viewDetailPromo');

    Route::get('/dataDetailPromo/{promo}', [promo_Controller::class, 'data_Detail_Promo'])->name('dataDetailPromo');

    Route::get('/admin/detail-promo/store/{idpromo}/{idproduk}', [promo_Controller::class, 'proses_Store_Detail_Promo'])->name('tambahDetailPromo');

    Route::get('/admin/detail-promo/hapus/{detail_promo}', [promo_Controller::class, 'proses_Hapus_Detail_Promo'])->name('hapusDetailPromo');

    Route::get('/admin/detail-promo/checkout/{promo}', [promo_Controller::class, 'proses_Checkout'])->name('checkoutPromo');

    Route::get('/admin/pembelian-ball', [pembelian_Ball_Controller::class, 'index'])->name('viewPembelianBallAdmin');

    Route::get('/dataPembelianBallAdmin', [pembelian_Ball_Controller::class, 'data_Pembelian_Ball'])->name('dataPembelianBallAdmin');

    Route::post('/admin/pembelian-ball/store', [pembelian_Ball_Controller::class, 'proses_Store'])->name('tambahPembelianBallAdmin');

    Route::get('/admin/penjualan-online', [penjualan_Online_Controller::class, 'index'])->name('viewPenjualanOnline');

    Route::get('/dataPenjualanOnline', [penjualan_Online_Controller::class, 'data_Penjualan_Online'])->name('dataPenjualanOnline');

    Route::get('/admin/detail-penjualan-online/{penjualan_online}', [penjualan_Online_Controller::class, 'view_Detail_Penjualan_Online'])->name('viewDetailPenjualanOnline');

    Route::get('/admin/membatalkan/penjualan-online/{penjualan_online}', [penjualan_Online_Controller::class, 'proses_Membatalkan_Penjualan_Online'])->name('membatalkanPenjualanOnline');

    Route::get('/dataDetailPenjualanOnline/{penjualan_online}', [penjualan_Online_Controller::class, 'data_Detail_Penjualan_Online'])->name('dataDetailPenjualanOnlineAdmin');

    Route::get('/dataAlamatPengiriman/{penjualan_online}', [penjualan_Online_Controller::class, 'data_Alamat_Pengiriman'])->name('dataAlamatPengiriman');

    Route::get('/dataJasaPengiriman/{penjualan_online}', [penjualan_Online_Controller::class, 'data_Jasa_Pengiriman'])->name('dataJasaPengiriman');

    Route::get('/admin/membatalkan/{penjualan_online}', [penjualan_Online_Controller::class, 'proses_Membatalkan_Detail_Penjualan_Online'])->name('membatalkanDetailPenjualanOnline');

    Route::get('/admin/penjualan-offline', [penjualan_Offline_Controller::class, 'index'])->name('viewPenjualanOfflineAdmin');

    Route::get('/dataPenjualanOfflineAdmin', [penjualan_Offline_Controller::class, 'data_Penjualan_Offline'])->name('dataPenjualanOfflineAdmin');

    Route::get('/admin/detail-penjualan-offline/{penjualan_offline}', [penjualan_Offline_Controller::class, 'view_Detail_Penjualan_Offline'])->name('viewDetailPenjualanOfflineAdmin');

    Route::get('/dataDetailPenjualanOfflineAdmin/{penjualan_offline}', [penjualan_Offline_Controller::class, 'data_Detail_Penjualan_Offline'])->name('dataDetailPenjualanOfflineAdmin');

    Route::get('/admin/dashboard', [dashboard_Controller::class, 'index'])->name('viewDashboardAdmin');

    Route::get('/admin/laporan-penjualan-online', [laporan_Penjualan_Online_Controller::class, 'index'])->name('viewLaporanPenjualanOnlineAdmin');

    Route::post('/admin/laporan-penjualan-online', [laporan_Penjualan_Online_Controller::class, 'cek_Laporan_Penjualan_Online'])->name('cekLaporanPenjualanOnlineAdmin');

    Route::get('/admin/laporan-penjualan-offline', [laporan_Penjualan_Offline_Controller::class, 'index'])->name('viewLaporanPenjualanOfflineAdmin');

    Route::post('/admin/laporan-penjualan-offline', [laporan_Penjualan_Offline_Controller::class, 'cek_Laporan_Penjualan_Offline'])->name('cekLaporanPenjualanOfflineAdmin');
});

//Halaman Owner
Route::get('/owner/login', [LoginController::class, 'view_Login_Owner'])->name('login-owner');

Route::post('/owner/login-owner', [LoginController::class, 'authenticate_owner'])->name('authenticateOwner');

Route::post('/owner/logout', [LoginController::class, 'logout'])->name('logoutOwner');

Route::middleware(['owner'])->group(function () {
    Route::get('/owner/dashboard', [dashboard_Controller::class, 'index'])->name('viewDashboardOwner');

    Route::get('/owner/pembelian-ball', [pembelian_Ball_Controller::class, 'index'])->name('viewPembelianBallOwner');

    Route::get('/dataPembelianBallOwner', [pembelian_Ball_Controller::class, 'data_Pembelian_Ball'])->name('dataPembelianBallOwner');

    Route::get('/owner/penjualan-online', function () {
        $judul = 'Penjualan Online';
        return view('owner.penjualan_Online', compact('judul'));
    });

    Route::get('/owner/penjualan-offline', [penjualan_Offline_Controller::class, 'index'])->name('viewPenjualanOfflineOwner');

    Route::get('/dataPenjualanOfflineOwner', [penjualan_Offline_Controller::class, 'data_Penjualan_Offline'])->name('dataPenjualanOfflineOwner');

    Route::get('/owner/detail-penjualan-offline/{penjualan_offline}', [penjualan_Offline_Controller::class, 'view_Detail_Penjualan_Offline'])->name('viewDetailPenjualanOfflineOwner');

    Route::get('/dataDetailPenjualanOfflineOwner/{penjualan_offline}', [penjualan_Offline_Controller::class, 'data_Detail_Penjualan_Offline'])->name('dataDetailPenjualanOfflineOwner');

    Route::get('/owner/penjualan-online', [penjualan_Online_Controller::class, 'index']);

    Route::get('/dataPenjualanOnlineOwner', [penjualan_Online_Controller::class, 'data_Penjualan_Online'])->name('dataPenjualanOnlineOwner');

    Route::get('/owner/detail-penjualan-online/{penjualan_online}', [penjualan_Online_Controller::class, 'view_Detail_Penjualan_Online'])->name('viewDetailPenjualanOnlineOwner');

    Route::get('/dataDetailPenjualanOnlineOwner/{penjualan_online}', [penjualan_Online_Controller::class, 'data_Detail_Penjualan_Online'])->name('dataDetailPenjualanOnlineOwner');

    Route::get('/dataAlamatPengirimanOwner/{penjualan_online}', [penjualan_Online_Controller::class, 'data_Alamat_Pengiriman'])->name('dataAlamatPengirimanOwner');

    Route::get('/dataJasaPengirimanOwner/{penjualan_online}', [penjualan_Online_Controller::class, 'data_Jasa_Pengiriman'])->name('dataJasaPengirimanOwner');

    Route::get('/owner/laporan-penjualan-online', [laporan_Penjualan_Online_Controller::class, 'index'])->name('viewLaporanPenjualanOnlineOwner');

    Route::post('/owner/laporan-penjualan-online', [laporan_Penjualan_Online_Controller::class, 'cek_Laporan_Penjualan_Online'])->name('cekLaporanPenjualanOnlineOwner');

    Route::get('/owner/laporan-penjualan-offline', [laporan_Penjualan_Offline_Controller::class, 'index'])->name('viewLaporanPenjualanOfflineOwner');

    Route::post('/owner/laporan-penjualan-offline', [laporan_Penjualan_Offline_Controller::class, 'cek_Laporan_Penjualan_Offline'])->name('cekLaporanPenjualanOfflineOwner');
});

//kasir
Route::get('/kasir/login', [LoginController::class, 'view_Login_Kasir'])->name('login-kasir');

Route::post('/kasir/login-kasir', [LoginController::class, 'authenticate_kasir'])->name('authenticateKasir');

Route::post('/kasir/logout', [LoginController::class, 'logout'])->name('logoutKasir');

Route::middleware(['kasir'])->group(function () {
    Route::get('/kasir/dashboard', [dashboard_Controller::class, 'index'])->name('viewDashboarKasir');

    Route::get('/kasir/penjualan-offline', [penjualan_Offline_Controller::class, 'index'])->name('viewPenjualanOfflineKasir');

    Route::get('/dataPenjualanOfflineKasir', [penjualan_Offline_Controller::class, 'data_Penjualan_Offline'])->name('dataPenjualanOfflineKasir');

    Route::get('/kasir/penjualan-offline/store', [penjualan_Offline_Controller::class, 'view_Tambah_Penjualan_Offline'])->name('viewTambahPenjualanOffline');

    Route::get('/dataTambahPenjualanOfflineKasir', [penjualan_Offline_Controller::class, 'data_Tambah_Penjualan_Offline'])->name('dataTambahPenjualanOfflineKasir');

    Route::get('/kasir/penjualan-offline/tambah/{produk}', [penjualan_Offline_Controller::class, 'proses_Store_Penjualan_Offline'])->name('tambahPenjualanOffline');

    Route::get('/kasir/penjualan-offline/hapus/{detail_penjualan_offline}', [penjualan_Offline_Controller::class, 'hapus_Detail_Penjualan_Offline'])->name('hapusDetailPenjualanOffline');

    Route::post('/kasir/penjualan-offline/checkout', [penjualan_Offline_Controller::class, 'checkout'])->name('checkoutPenjualanOffline');

    Route::get('/kasir/detail-penjualan-offline/{penjualan_offline}', [penjualan_Offline_Controller::class, 'view_Detail_Penjualan_Offline'])->name('viewDetailPenjualanOffline');

    Route::get('/dataDetailPenjualanOfflineKasir/{penjualan_offline}', [penjualan_Offline_Controller::class, 'data_Detail_Penjualan_Offline'])->name('dataDetailPenjualanOfflineKasir');

    Route::get('/kasir/membatalkan/detail-penjualan-offline/{penjualan_offline}', [penjualan_Offline_Controller::class, 'proses_Membatalkan_Detail_Penjualan_Offline'])->name('membatalkanDetailPenjualanOffline');

    Route::get('/kasir/membatalkan/penjualan-offline/{penjualan_offline}', [penjualan_Offline_Controller::class, 'proses_Membatalkan_Penjualan_Offline'])->name('membatalkanPenjualanOffline');

    Route::get('/kasir/penjualan-offline/cetakKwitansi/{penjualan_offline}', [penjualan_Offline_Controller::class, 'cetak_Kwitansi'])->name('cetakKwitansi');
});

// Pembeli
Route::get('/', [home_Controller::class, 'index'])->name('beranda');

Route::get('/login', [LoginController::class, 'view_Login_Pembeli'])->name('viewLoginPembeli');

Route::post('/login/store', [LoginController::class, 'authenticate_Pembeli'])->name('loginPembeli');

Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('viewRegistrasiPembeli');

Route::post('/registrasi', [RegistrasiController::class, 'proses_Store'])->name('registrasiPembeli');

Route::get('/produk', [produk_Controller::class, 'view_Produk_Pembeli'])->name('viewProdukPembeli');

Route::middleware(['pembeli'])->group(function () {
    Route::get('/keranjang', [keranjang_Controller::class, 'index'])->name('keranjang');
    Route::post('/keranjang/store/{produk}', [keranjang_Controller::class, 'proses_Tambah_Keranjang'])->name('tambahKeranjang');
    Route::get('/keranjang/hapus/{detail_penjualan_online}', [keranjang_Controller::class, 'proses_Hapus_Keranjang'])->name('hapusKeranjang');
    Route::get('/keranjang/checkout', [keranjang_Controller::class, 'checkout'])->name('checkoutKeranjang');
    Route::post('/datakabupaten', [User_Controller::class, 'data_kabupaten'])->name('dataKabupaten');
    Route::post('/datakecamatan', [User_Controller::class, 'data_kecamatan'])->name('dataKecamatan');
    Route::post('/datakelurahan', [User_Controller::class, 'data_kelurahan'])->name('dataKelurahan');
    Route::post('/alamat/store', [User_Controller::class, 'proses_store_alamat'])->name('tambahAlamat');
    Route::get('/alamat/hapus/{alamat}', [User_Controller::class, 'proses_hapus_alamat'])->name('hapusAlamat');
    Route::get('/alamat/edit/{alamat}', [User_Controller::class, 'view_edit_alamat'])->name('viewEditAlamat');

    Route::post('/alamat/edit', [User_Controller::class, 'proses_edit_alamat'])->name('editAlamat');

    Route::get('/profile', [User_Controller::class, 'profile'])->name('profile');

    Route::post('/profile/edit', [User_Controller::class, 'proses_Edit_Profile'])->name('editProfile');

    Route::get('/profile/edit', [User_Controller::class, 'view_Edit_Profile'])->name('viewEditProfile');

    Route::get('/produk/detail-produk/{produk}', [produk_Controller::class, 'view_Detail_Produk_Pembeli'])->name('detail-produk');

    Route::get('/semua-produk', [produk_Controller::class, 'view_Semua_Produk_Pembeli'])->name('viewSemuaProdukPembeli');
    
    Route::get('/semua-produk/{kategori_produk:nama_kategori_produk}', [produk_Controller::class, 'view_Semua_Produk_Kategori'])->name('viewSemuaProduk');
    
    Route::get('/semua-produk-promo/{promo}', [produk_Controller::class, 'view_Semua_Produk_Promo_Pembeli'])->name('viewSemuaProdukPromoPembeli');

    Route::get('/semua-kategori-produk', [kategori_Produk_Controller::class, 'view_Kategori_Produk'])->name('viewKategoriProdukPromoPembeli');

    Route::post('/alamat-pengiriman/store', [penjualan_Online_Controller::class, 'proses_Store_Alamat_Pengiriman'])->name('tambahAlamatPengiriman');

    Route::post('/dataPaketLayananJne', [penjualan_Online_Controller::class, 'data_Paket_Layanan'])->name('dataPaketLayananJne');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logoutPembeli');

    Route::get('/transaksi', [penjualan_Online_Controller::class, 'view_Penjualan_Online_Pembeli'])->name('transaksi');
    
    Route::get('/invoice', [penjualan_Online_Controller::class, 'invoice'])->name('invoicePembeli');
});

Route::get('/produk/detail-produk-promo', function () {
    return view('pembeli.detail-produk-promo');
})->name('detail-produk-promo');
