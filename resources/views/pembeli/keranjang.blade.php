@extends('layout.main_pembeli')
@section('konten')
<br><br>
    @if (session()->has('title'))
        <div class="flash-data" data-aksi='Dikeluarkan' data-halaman='keranjang' data-title='{{ session('title') }}'>
        </div>
    @endif
    <div class="container">
        @if ($detailKeranjang->count())
            <div class="row justify-content-between">
                <div class="col-12 col-sm-12 col-md-7 col-xl-7 col-lg-7">
                    @foreach ($detailKeranjang as $dataDetailKeranjang)
                        <div class="mb-3 col-12 d-flex mb-sm-3 keranjang-produk p-3 p-lg-4">
                            <div class="col-6 col-sm-6 col-md-7 col-xl-7 col-lg-7">
                                <img src="{{ asset('storage/' . $dataDetailKeranjang->thumbnail) }}" alt="" />
                            </div>
                            <div class="col-6 col-sm-6 col-md-5 col-xl-5 col-lg-5 keranjang">
                                <h5 class="mb-2 mb-lg-4 mb-sm-2" style="font-size: 1.2em;">
                                    <b>{{ $dataDetailKeranjang->nama_produk }}</b>
                                </h5>
                                <div class="col-12 mb-lg-4 mb-sm-2 d-flex justify-content-between">
                                    <span class="mb-2">{{ $dataDetailKeranjang->nama_merk }}</span>
                                    <span class="mb-2">Ukuran {{ $dataDetailKeranjang->ukuran }}</span>
                                </div>
                                <div class="col-12 d-flex mb-lg-4 mb-sm-2 justify-content-between">

                                    @if ($dataDetailKeranjang->diskon > 0)
                                        <h5 class="text-decoration-line-through text-secondary">
                                            Rp {{ number_format($dataDetailKeranjang->harga, 0, ',', '.') }}
                                        </h5>
                                        <?php $dataDetailKeranjang->harga = $dataDetailKeranjang->harga - ($dataDetailKeranjang->harga * $dataDetailKeranjang->diskon) / 100; ?>
                                        <h5 class="teks-merah">
                                            <b>Rp {{ number_format($dataDetailKeranjang->harga, 0, ',', '.') }}</b>
                                        </h5>
                                    @else
                                        <h5>
                                            Rp {{ number_format($dataDetailKeranjang->harga, 0, ',', '.') }}
                                        </h5>
                                    @endif

                                </div>
                                <div class="col-12 mb-lg-4 mb-sm-2 d-flex justify-content-between">
                                    <span class="mb-2">Qty 1</span>
                                </div>
                                <br />
                                <a href="{{ route('hapusKeranjang', encrypt($dataDetailKeranjang->id_detail_penjualan_online)) }}"
                                    class="text-decoration-none" style="color:#973535;"><i
                                        class="bi bi-trash-fill me-1"></i>Hapus</a>

                                @if ($dataDetailKeranjang->stok == 0)
                                    <div class="alert alert-danger" role="alert">
                                        Stok Produk Habis !
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mb-3 col-12 col-sm-12 col-lg-4 col-md-4 mb-sm-3">
                    <div class="col-12 ringkasan-harga p-3 mb-3">
                        <h5 class="my-2 my-lg-3">
                            <b>Ringkasan</b>
                        </h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span class="teks-merah"><b>Rp
                                    {{ number_format($keranjang->sub_total, 0, ',', '.') }}</b></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Diskon</span>

                            <span class="text-primary">
                                @if ($diskon->count()!=0)
                                    @foreach ($diskon as $row)
                                        @if ($diskon->count() == $loop->iteration)
                                            {{ $row->diskon }} %
                                        @else
                                            {{ $row->diskon }} %,
                                        @endif
                                    @endforeach
                                @else
                                    Tidak Ada
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-5">
                            <span>Total</span>
                            <span class="teks-merah" style="font-size: 1.1em;"><b>Rp
                                    {{ number_format(intval($dataTotal->total_diskon) + intval($dataTotal->total_bukan_diskon), 0, ',', '.') }}</b></span>
                        </div>
                        <div class="col-12 col-lg-12">
                            <form action="{{ route('checkoutKeranjang') }}" method="GET">
                                <button style="width: 100%" class="p-2 btn text-white btn-all btn-oval">
                                    Checkout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <br><br><br><br><br><br><br>
            <br>
            <div class="container">
                <div class="row text-secondary text-center">
                    <h4>Keranjang Kosong</h4>
                </div>
            </div>
            <br><br><br><br><br><br>
        @endif
    </div>
@endsection
