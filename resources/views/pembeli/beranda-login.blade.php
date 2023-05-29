@extends('layout.main_pembeli_login')
@section('konten')
    <div class="container banner mb-lg-5">
        <div class="row d-flex justify-content-between mb-5">
            <div class="col-10 col-sm-7 col-md-7 col-lg-6 col-deskripsi-banner">
                <h1 class="deskripsi-banner">
                    Make Tomorrow Beautiful
                    <span class="markup">Shopping</span>
                </h1>
                <a class="btn text-white btn-banner btn-oval px-5" href="#minimalPembelian">Belanja Sekarang</a>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-5 text-right mt-md-2 mt-lg-2">
                <img src="{{ asset('assets/img/banner.jpg') }}" alt="gambar" class="img-banner" />
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row mb-3 judul-konten">
            <div class="col-lg-12 d-flex justify-content-between">
                <h5>Kategori</h5>
                <a class="teks-detail teks-merah text-decoration-none" href="#">Lihat Detail</a>
            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme">
                <div class="item mb-2">

                    <div class="card text-white">
                        <img src="{{ asset('assets/img/img-beranda.jpg') }}" class="card-img-top kategori" />
                        <div class="card-img-overlay kategori d-flex align-items-center p-0">
                            <h5 class="card-title flex-fill p-3 p-md-3 p-lg-3 text-center">
                                Kemeja
                            </h5>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row mb-3 judul-konten">
            <div class="col-lg-12 d-flex justify-content-between">
                <h5 id="minimalPembelian">Minimal Pembelian</h5>
                <a class="teks-detail teks-merah text-decoration-none" href="#">Lihat Detail</a>
            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme">
                <div class="item mb-2">
                    {{-- <a class="text-decoration-none" href="{{ route('detail-produk') }}"> --}}
                        <div class="card card-produk">
                            <p class="text-center text-white card-promo-minimal px-1 py-1 rounded-3">
                                Beli 2, Diskon 50%
                            </p>
                            <img src="{{ asset('assets/img/banner.jpg') }}" class="card-img-top produk" alt="..." />
                            <div class="card-body">
                                <h5 class="card-title text-dark">Kemeja</h5>
                                <p class="card-text text-dark">Adidas</p>
                                <h5 class="teks-merah">Rp.100.000</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mb-3 judul-konten">
            <div class="col-lg-12 d-flex justify-content-between">
                <h5>Potongan Harga</h5>
                <a class="teks-detail teks-merah text-decoration-none" href="#">Lihat Detail</a>
            </div>
        </div>

        <div class="row">
            <div class="owl-carousel owl-theme">
                <div class="item mb-2">
                    {{-- <a class="text-decoration-none" href="{{ route('detail-produk') }}"> --}}
                        <div class="card card-produk">
                            <span class="px-2 py-2 text-white card-promo-potongan">50%</span>
                            <img src="{{ asset('assets/img/banner.jpg') }}" class="card-img-top produk" alt="..." />
                            <div class="card-body pb-1">
                                <h5 class="card-title text-dark">Kemeja</h5>
                                <p class="card-text text-dark">Adidas</p>
                                <div class="d-flex">
                                    <p class="harga-awal text-decoration-line-through me-2">
                                        Rp.100.000
                                    </p>
                                    <h5 class="teks-merah">Rp.50.000</h5>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
