@extends('layout.main_pembeli')
@section('konten')
    @if (session()->has('title'))
        <div class="flash-data" data-title="{{ session('title') }}" data-aksi="kosong" data-halaman="Beranda">
        </div>
    @endif
    <div class="container-fluid mb-5"
        style="background-color:#FEFEFE; border:1px solid #FEFEFE; box-shadow: 0px 4px 10px rgba(3, 46, 71, 0.01);">
        <div class="container banner mb-lg-5">
            <div class="row d-flex justify-content-between mb-5">
                <div class="col-10 col-sm-7 col-md-7 col-lg-6 col-deskripsi-banner">
                    <h1 class="deskripsi-banner">
                        Make Tomorrow Beautiful
                        <span class="markup">Shopping</span>
                    </h1>
                    <a class="btn text-white btn-banner btn-oval px-5" href="#kategori">Belanja Sekarang</a>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-5 text-right mt-md-2 mt-lg-2">
                    <img src="{{ asset('assets/img/banner.jpg') }}" alt="gambar" class="img-banner" />
                </div>
            </div>
        </div>
    </div>


    <div class="container mb-5" id="kategori">
        <div class="row mb-3 judul-konten">
            <div class="col-lg-12 d-flex justify-content-between">
                <h5>Kategori</h5>
                <a class="teks-detail teks-merah text-decoration-none"
                    href="{{ route('viewKategoriProdukPromoPembeli') }}">Lihat Detail</a>
            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme">
                @foreach ($kategoriProduk as $row)
                    <div class="item mb-2">
                        <a href="{{ route('viewSemuaProduk', $row->nama_kategori_produk) }}">
                            <div class="card text-white">
                                <img src="{{ asset('assets/img/img-beranda.jpg') }}" class="card-img-top kategori" />
                                <div class="card-img-overlay kategori d-flex align-items-center p-0">
                                    <h5 class="card-title flex-fill p-3 p-md-3 p-lg-3 text-center">
                                        {{ $row->nama_kategori_produk }}
                                    </h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <?php $indexRow = 0; ?>
    @foreach ($promo as $dataPromo)
        <div class="container mb-5">
            <div class="row mb-3 judul-konten">
                <div class="col-lg-12 d-flex justify-content-between">
                    <h5 id="minimalPembelian">{{ $dataPromo->nama_promo }}</h5>
                    <a class="teks-detail teks-merah text-decoration-none"
                        href="{{ route('viewSemuaProdukPromoPembeli', encrypt($dataPromo->id_promo)) }}">Lihat Detail</a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="owl-carousel owl-theme">
                    <?php $indexCol = 0; ?>
                    @if ($detailPromo && $detailPromo->count() != 0)
                        @foreach ($detailPromo->skip($indexRow) as $dataDetailPromo)
                            @if ($dataDetailPromo->promo_id == $dataPromo->id_promo)
                                <div class="item mb-2">
                                    <?php $indexCol++; ?>
                                    <?php $indexRow++; ?>
                                    <a class="text-decoration-none"
                                        href="{{ route('detail-produk', encrypt($dataDetailPromo->id_produk)) }}">
                                        <div class="card card-produk">
                                            <span
                                                class="px-2 py-2 text-white card-promo-potongan">{{ $dataDetailPromo->deskripsi }}</span>
                                            <img src="{{ asset('storage/' . $dataDetailPromo->thumbnail) }}"
                                                class="card-img-top produk" alt="..." />
                                            <div class="card-body">
                                                <h5 class="card-title text-dark">{{ $dataDetailPromo->nama_produk }}</h5>
                                                @if ($dataDetailPromo->tipe == 'potongan harga')
                                                    <div class="d-flex justify-content-between">
                                                        <p class="harga-awal text-decoration-line-through me-2">
                                                            Rp {{ number_format($dataDetailPromo->harga, 0, ',', '.') }}
                                                        </p>
                                                        <h5 class="teks-merah">
                                                            <?php $dataDetailPromo->harga = $dataDetailPromo->harga - ($dataDetailPromo->harga * $dataDetailPromo->diskon) / 100; ?>
                                                            <b>Rp
                                                                {{ number_format($dataDetailPromo->harga, 0, ',', '.') }}</b>
                                                        </h5>
                                                    </div>
                                                @else
                                                    <div class="d-flex justify-content-between">
                                                        <h5 class="text-secondary">Rp
                                                            {{ number_format($dataDetailPromo->harga, 0, ',', '.') }}</h5>
                                                        <p style="visibility:hidden;">500000</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @if ($indexCol == 4)
                                    <?php break; ?>
                                @endif
                            @endif
                        @endforeach
                    @else
                        <div class="col-12 text-center">
                            <center class="text-secondary justify-content-center">
                                <h5 class="text-center">Tidak Ada Produk</h5>
                            </center>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @endforeach
@endsection
