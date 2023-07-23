@extends('layout.main_pembeli')
@section('konten')
<br><br>
    <div class="container justify-content-center my-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card card-invoice">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <center>
                                            @if ($penjualanOnline->status == 1)
                                                <p class="text-success" style="font-size: 3em;"><b><i
                                                            class="bi bi-check-circle"></i></b></p>
                                                <p style="font-size: 1.2em;"><b>Transaksi Berhasil</b></p>
                                                <p class="text-secondary fw-lighter">Terima kasih atas pesanan anda</p>
                                            @elseif($penjualanOnline->status == 4)
                                                <p class="text-success" style="font-size: 3em;"><b><i
                                                            class="bi bi-x-circle"></i></b></p>
                                                <p style="font-size: 1.2em;"><b>Transaksi Gagal</b></p>
                                                <p class="text-secondary fw-lighter">Maaf, Silahkan Dicoba Lagi</p>
                                            @elseif($penjualanOnline->status == 5)
                                                <p class="text-success" style="font-size: 3em;"><b><i
                                                            class="bi bi-x-circle"></i></b></p>
                                                <p style="font-size: 1.2em;"><b>Transaksi Dibatalkan</b></p>
                                                <p class="text-secondary fw-lighter">Kami Akan Menghubungi Anda</p>
                                            @elseif($penjualanOnline->status == 6)
                                                    <p class="text-success" style="font-size: 3em;"><b><i class="bi bi-cash-stack"></i></b></p>
                                                    <p style="font-size: 1.2em;"><b>Pembayaran Dikonfirmasi</b></p>
                                                    <p class="text-secondary fw-lighter">Paket Akan Kami Kemas</p>
                                            @elseif($penjualanOnline->status == 7)
                                            <p class="text-danger" style="font-size: 3em;"><b><i class="bi bi-cash-stack"></i></b></p>
                                                    <p style="font-size: 1.2em;"><b>Paket Sedang Dikirim</b></p>
                                                    <p class="text-secondary fw-lighter">Mohon Ditunggu Paket Anda</p>
                                            @endif

                                        </center>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <p><b>Tanggal Transaksi</b></p>
                            <p class="text-secondary fw-light">{{ $penjualanOnline->tgl->format('d M Y'); }}</p>
                        </li>
                        <li class="list-group-item">
                            <p><b> Metode Pembayaran</b></p>
                            <p class="text-secondary fw-light">Transfer Bank</p>
                        </li>
                        <li class="list-group-item">
                            <p><b>Virtual Account Number</b></p>
                            <p class="text-secondary fw-light">{{ $penjualanOnline->va_number }}</p>
                        </li>
                        <li class="list-group-item">
                            <p><b> Jasa Pengiriman</b></p>
                            <p class="text-secondary fw-light">JNE {{ $jasaPengiriman->service }}, Estimasi
                                {{ $jasaPengiriman->estimasi }}</p>
                        </li>
                        <li class="list-group-item">
                            <p><b>Detail Transaksi</b></p>

                            @foreach ($detailPenjualanOnline as $row)
                                <div class="col-12 mb-2 mb-lg-12 d-flex justify-content-between keranjang-produk mb-3">
                                    <div class="col-6 col-sm-6 col-lg-5">
                                        <img src="{{ asset('storage/' . $row->thumbnail) }}" alt="" />
                                    </div>
                                    <div class="col-6 col-sm-6 col-lg-6 keranjang">
                                        <h5 class="mb-2 mb-lg-3 mb-sm-2" style="font-size: 1em;">
                                            {{ $row->nama_produk }}
                                        </h5>
                                        <div class="col-12 d-flex mb-lg-3 mb-sm-2 justify-content-between">
                                            @if ($row->diskon > 0)
                                                <h5 class="fw-light text-decoration-line-through text-secondary">
                                                    Rp {{ number_format($row->harga, 0, ',', '.') }}
                                                </h5>
                                                <?php $row->harga = $row->harga - ($row->harga * $row->diskon) / 100; ?>
                                                <h5 class="teks-merah">
                                                    <b> Rp {{ number_format($row->harga, 0, ',', '.') }}</b>
                                                </h5>
                                            @else
                                                <h5>
                                                    Rp {{ number_format($row->harga, 0, ',', '.') }}
                                                </h5>
                                            @endif
                                        </div>

                                        <div class="col-12 mb-lg-3 mb-sm-2 d-flex justify-content-between">
                                            <span class="mb-2">{{ $row->nama_merk }}</span>
                                            <span class="mb-2">Qty 1</span>
                                         
                                        </div>
                                        @if ($row->status == 5)
                                            <h5 class="mb-2 mb-lg-3 mb-sm-2">
                                            produk ini dibatalkan
                                            </h5>
                                            @endif
                                    </div>
                                </div>
                            @endforeach
                        </li>

                        <li class="list-group-item">
                            <div class="col-12 d-flex justify-content-between">
                                <p>Subtotal</p>
                                <p class="teks-merah"><b>Rp
                                        {{ number_format($penjualanOnline->sub_total, 0, ',', '.') }}</b></p>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="col-12 d-flex justify-content-between">
                                <p>Diskon</p>

                                <p class="fw-light text-primary">
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
                                </p>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="col-12 d-flex justify-content-between">
                                <p>Ongkir</p>
                                <p class="teks-merah"><b>Rp
                                        {{ number_format($jasaPengiriman->total_ongkir, 0, ',', '.') }}</b></p>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="col-12 d-flex justify-content-between mb-4">
                                <p>Total</p>
                                <p class="teks-merah" style="font-size: 1.1em;"><b>Rp
                                        {{ number_format($penjualanOnline->total, 0, ',', '.') }}</b></p>
                            </div>
                            <div class="col-12 mb-3">
                                <form action="{{ route('beranda') }}" method="GET">
                                    <button style="width: 100%;" class="p-2 btn text-white btn-all btn-oval">Beranda</button>
                                </form>

                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection
