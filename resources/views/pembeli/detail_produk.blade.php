@extends('layout.main_pembeli')
@section('konten')
<br><br>
    @if (session()->has('title'))
        <div class="flash-data" data-aksi='Dimasukkan' data-halaman='keranjang' data-title='{{ session('title') }}'>
        </div>
    @elseif(session()->has('gagal'))
    <div class="flash-data" data-aksi='Produk Sudah Di Keranjang' data-halaman='keranjang' data-title='{{ session('gagal') }}'>
    </div>
    @endif
    <div class="container mb-5 pt-4 pb-4 pt-lg-5 pb-lg-5"
        style="background-color:#FFFFFF; border:1px solid #FEFEFE; border-radius:20px; box-shadow: 0px 4px 10px rgba(3, 46, 71, 0.01);">
        <div class="row justify-content-evenly mb-5">
            <div class="col-lg-7 img-produk">
                <div class="row mb-3">
                    <div class="col-12">
                        @if ($produk->status == 1)
                            <span class="fs-6 px-2 py-2 text-white card-promo-potongan">{{ $produk->deskripsi_promo }}</span>
                        @endif
                        <img src="{{ asset('storage/' . $produk->thumbnail) }}" alt="" class="besar" />
                    </div>
                </div>
                <div class="row">
                    <div class="produk-carousel justify-content-center owl-theme">
                        @foreach ($detailProduk as $data)
                            <div class="item">
                                <img src="{{ asset('storage/' . $data->gambar) }}" alt="" class="kecil" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4 pt-3 pt-lg-5 detail-produk">
                <h5 class="col-12 mb-2 mb-lg-4" style="font-size:2em;"><b>{{ $produk->nama_produk }}</b></h5>
                <div class="col-12 mb-lg-2 d-flex justify-content-between">
                    <p>{{ $produk->merk }}</p>
                    <p>{{ $produk->nama_kategori_produk }}</p>
                </div>

                @if ($produk->tipe == 'potongan harga' && $produk->status == 1)
                    <div class="" style="">
                        <div class="col-12 mb-lg-2 d-flex justify-content-between">
                            <p class="harga-awal text-decoration-line-through">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </p>
                            <p class="teks-merah">
                                <?php $produk->harga = $produk->harga - ($produk->harga * $produk->diskon) / 100; ?>
                                <b>Rp {{ number_format($produk->harga, 0, ',', '.') }}</b>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="col-6 mb-lg-2">
                        <p>Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    </div>
                @endif

                <p class="mb-lg-2">Ukuran</p>
                <p class="mb-lg-4"><span class="pt-2 pb-2 ps-3 pe-3"
                        style="background-color: #EAEFF2; border-radius:10px;">L</span></p>
                <div class="col-12 col-lg-12">
                    <form action="{{ route('tambahKeranjang', encrypt($produk->id_produk)) }}" method="POST">
                        @csrf
                        <button style="width: 100%" class="p-2 btn text-white btn-banner btn-oval">
                            Masukkan Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7 ms-lg-4 deskripsi-produk">
                <h5><b>Deskripsi</b></h5>
                <p class="text-secondary">
                    {!! $produk->deskripsi_produk !!}
                </p>
            </div>
        </div>
    </div>

    @if ($produk->tipe && $produk->status == 1)
        <div class="container">
            <div class="row mb-3 judul-konten">
                <div class="col-lg-12 d-flex justify-content-between">
                    <h5>Produk Diskon</h5>
                    <a class="teks-detail teks-merah text-decoration-none"
                        href="{{ route('viewSemuaProdukPromoPembeli', encrypt($produkPromo[0]->id_promo)) }}">Lihat
                        Detail</a>
                </div>
            </div>
            <div class="row">
                <div class="owl-carousel owl-theme">
                    @foreach ($produkPromo as $dataProdukPromo)
                        <div class="item mb-2">
                            <a class="text-decoration-none"
                                href="{{ route('detail-produk', encrypt($dataProdukPromo->id_produk)) }}">
                                <div class="card card-produk">
                                    @if ($produk->tipe)
                                        <span
                                            class="px-2 py-2 text-white card-promo-potongan">{{ $dataProdukPromo->deskripsi }}</span>
                                    @endif
                                    <img src="{{ asset('storage/' . $dataProdukPromo->thumbnail) }}"
                                        class="card-img-top produk" alt="..." />
                                    <div class="card-body">
                                        <h5 class="card-title text-dark" style="font-size: 1.2em;">
                                            <b>{{ $dataProdukPromo->nama_produk }}</b>
                                        </h5>
                                        @if ($produk->tipe == 'potongan harga')
                                            <div class="d-flex">
                                                <p class="harga-awal text-decoration-line-through me-2">
                                                    Rp {{ number_format($dataProdukPromo->harga, 0, ',', '.') }}
                                                </p>
                                                <h5 class="teks-merah">
                                                    <?php $dataProdukPromo->harga = $dataProdukPromo->harga - ($dataProdukPromo->harga * $dataProdukPromo->diskon) / 100; ?>
                                                    <b>Rp {{ number_format($dataProdukPromo->harga, 0, ',', '.') }}</b>
                                                </h5>
                                            </div>
                                        @else
                                            <div class="d-flex justify-content-between">
                                                <h5 class="text-secondary">Rp
                                                    {{ number_format($dataProdukPromo->harga, 0, ',', '.') }}</h5>
                                                <p style="visibility:hidden;">500000</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="container mb-5">
        <div class="row mb-3 judul-konten">
            <div class="col-lg-12">
                <a href="{{ route('viewSemuaProdukPembeli') }}"
                    class="teks-detail float-end teks-merah text-decoration-none" href="#">Lihat Detail</a>
            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme">
                @foreach ($allProduk as $dataProduk)
                    <div class="item mb-2">
                        <a class="text-decoration-none"
                            href="{{ route('detail-produk', encrypt($dataProduk->id_produk)) }}">
                            <div class="card card-produk">
                                @if ($dataProduk->tipe && $dataProduk->status == 1)
                                    <span
                                        class="px-2 py-2 text-white card-promo-potongan">{{ $dataProduk->deskripsi }}</span>
                                @endif
                                <img src="{{ asset('storage/' . $dataProduk->thumbnail) }}" class="card-img-top produk"
                                    alt="..." />
                                <div class="card-body">
                                    <h5 class="card-title text-dark" style="font-size: 1.2em;">
                                        {{ $dataProduk->nama_produk }}</h5>
                                    @if ($dataProduk->tipe == 'potongan harga' && $dataProduk->status == 1)
                                        <div class="d-flex justify-content-between">
                                            <p class="harga-awal text-decoration-line-through me-2">
                                                Rp {{ number_format($dataProduk->harga, 0, ',', '.') }}
                                            </p>
                                            <h5 class="teks-merah">
                                                <?php $dataProduk->harga = $dataProduk->harga - ($dataProduk->harga * $dataProduk->diskon) / 100; ?>
                                                <b>Rp {{ number_format($dataProduk->harga, 0, ',', '.') }}</b>
                                            </h5>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-between">
                                            <h5 class="text-secondary">Rp
                                                {{ number_format($dataProduk->harga, 0, ',', '.') }}</h5>
                                            <p style="visibility:hidden;">500000</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('jsGambar')
    <script>
        const gambar = document.querySelector('.produk-carousel');
        const gambarBesar = document.querySelector('.besar')
        let eOld = null;
        gambar.addEventListener('click', function(e) {
            if (e.target.className == "kecil") {
                if (eOld != null) {
                    eOld.classList.remove('aktif');
                }
                gambarBesar.src = e.target.src;
                e.target.classList.add('aktif');
                eOld = e.target;
            }
        });
    </script>
@endsection
