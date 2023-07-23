@extends('layout.main_pembeli')
@section('konten')
    <br><br>
    <div class="container">
        @if ($produk && $produk->count() != 0)
            <div class="row justify-content-center">
                @foreach ($produk as $dataProduk)
               
                        <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-4">
                            <a class="text-decoration-none"
                                href="{{ route('detail-produk', encrypt($dataProduk->id_produk)) }}">
                                <div class="card card-produk" style="box-sizing: border-box;">
                                    @if ($dataProduk->tipe && $dataProduk->status == 1)
                                        <span
                                            class="px-2 py-2 text-white card-promo-potongan">{{ $dataProduk->deskripsi }}</span>
                                    @endif
                                    <img src="{{ asset('storage/' . "$dataProduk->thumbnail") }}" class="card-img-top produk"
                                        alt="..." />
                                    <div class="card-body">
                                        <h5 class="card-title text-dark" style="font-size: 1.2em;">
                                            <b>{{ $dataProduk->nama_produk }}</b>
                                        </h5>
                                        @if ($dataProduk->tipe == 'potongan harga' && $dataProduk->status == 1)
                                            <div class="d-flex justify-content-between">
                                                <p class="harga-awal text-decoration-line-through">
                                                    Rp {{ number_format($dataProduk->harga, 0, ',', '.') }}
                                                </p>
                                                <?php $dataProduk->harga = $dataProduk->harga - ($dataProduk->harga * $dataProduk->diskon) / 100; ?>
                                                <h5 class="teks-merah">

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
        @else
            <br><br><br><br><br><br><br>
            <br>
            <br>
            <div class="container">
                <div class="row text-secondary text-center">
                    <h4>Tidak Ada</h4>
                </div>
            </div>
            <br><br><br><br><br><br>
        @endif
    </div>
@endsection
