@extends('layout.main_pembeli')
@section('konten')
<br><br>
    @if (session()->has('aksi'))
        <div class="flash-data" data-title="Berhasil" data-aksi="{{ session('aksi') }}" data-halaman="alamat pengiriman">
        </div>
    @endif
    @error('alamat_id')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="alamat pengiriman">
        </div>
    @enderror
    @error('paket')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="alamat pengiriman">
        </div>
    @enderror
    {{-- Modal Alamat --}}
    <div class="modal fade" id="alamatPengiriman" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container">
                        <h5 class="modal-title judul-keranjang" id="exampleModalLabel">
                            Alamat Pengiriman
                        </h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahAlamatPengiriman') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Alamat</label>
                            <select class="form-select @error('alamat_id') is-invalid @enderror" id="alamat_id"
                                name="alamat_id" aria-label="Default select example">
                                <option selected value="">Pilih Alamat</option>
                                @foreach ($alamat as $row)
                                    <option select value="{{ $row->id_alamat }}">{{ $row->keterangan }}</option>
                                @endforeach
                            </select>
                            @error('alamat_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Paket Layanan Jne</label>
                            <select class="form-select @error('paket') is-invalid @enderror" id="paket" name="paket"
                                aria-label="Default select example">
                            </select>
                            @error('paket')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn text-white btn-merah rounded-5 px-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-between">
            <div class="mb-3 col-12 col-sm-12 col-lg-4 col-md-4 mb-sm-3 order-md-2 order-2">
                <div class="col-12 ringkasan-harga p-3 mb-3">
                    <h5 class="my-2 my-lg-3">
                        <b>Alamat Pengiriman</b>
                    </h5>
                    @if (isset($penjualanOnline->provinsi))
                        <div class="d-flex justify-content-between mb-2">
                            <span>Provinsi</span>
                            <span style="color: #8C8888;">{{ $penjualanOnline->provinsi }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Kabupaten</span>
                            <span style="color: #8C8888;">{{ $penjualanOnline->kabupaten }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Kecamatan</span>
                            <span style="color: #8C8888;">{{ $penjualanOnline->kecamatan }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Kelurahan</span>
                            <span style="color: #8C8888;">{{ $penjualanOnline->kelurahan }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-5">
                            <span>Alamat Detail</span>
                            <span style="color: #8C8888;">{{ $penjualanOnline->alamat_detail }}</span>
                        </div>
                    @else
                        <div class="d-flex justify-content-between mb-4">
                            <span style="color: #8C8888;">Belum Ditambahkan</span>
                        </div>
                    @endif
                    <h5 class="mb-2 mb-lg-3">
                        <b>Ringkasan</b>
                    </h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Sub Total</span>
                        <span class="teks-merah"><b>Rp
                                {{ number_format($penjualanOnline->sub_total, 0, ',', '.') }}</b></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Diskon</span>
                        <span class="text-primary">
                            @if ($diskon)
                                @foreach ($diskon as $row)
                                    @if ($diskon->count() == $loop->iteration)
                                        {{ $row->diskon }} %
                                    @else
                                        {{ $row->diskon }} %,
                                    @endif
                                @endforeach
                            @else
                                0
                            @endif
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkir</span>
                        <span class="teks-merah">
                            <b>
                                @if (isset($ongkir))
                                    Rp {{ number_format($ongkir->total_ongkir, 0, ',', '.') }}
                                @else
                                    {{ number_format(0, 0, ',', '.') }}
                                @endif
                            </b>
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-5">
                        <span>Total</span>
                        <span class="teks-merah" style="font-size: 1.1em;"><b>Rp
                                {{ number_format($penjualanOnline->total, 0, ',', '.') }}</b></span>
                    </div>
                    <div class="col-12 col-lg-12 mb-2">
                        <button style="width: 100%;" class="p-2 btn btn-alamat-pengiriman btn-oval" data-bs-toggle="modal"
                            data-bs-target="#alamatPengiriman">Alamat Pengiriman</button>
                    </div>
                    <div class="col-12 col-lg-12">
                        <button style="width: 100%;" class="p-2 btn text-white btn-all btn-oval" id="pay-button">Metode
                            Pembayaran</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-7 col-lg-7">
                @foreach ($detailPenjualanOnline as $dataDetailPenjualanOnline)
                    <div class="mb-3 col-12 d-flex mb-sm-3 keranjang-produk p-3 p-lg-4">
                        <div class="col-6 col-sm-6 col-md-7 col-lg-7">
                            <img src="{{ asset('storage/' . $dataDetailPenjualanOnline->thumbnail) }}" alt="" />
                        </div>
                        <div class="col-6 col-sm-6 col-md-5 col-lg-5 keranjang">
                            <h5 class="mb-2 mb-lg-4 mb-sm-2" style="font-size: 1.2em;">
                                <b>{{ $dataDetailPenjualanOnline->nama_produk }}</b>
                            </h5>
                            <div class="col-12 d-flex mb-lg-4 mb-sm-2 justify-content-between">
                                <span class="mb-2">{{ $dataDetailPenjualanOnline->merk }}</span>
                                <span class="mb-2">Ukuran {{ $dataDetailPenjualanOnline->ukuran }}</span>
                            </div>
                            <div class="col-12 d-flex mb-lg-4 mb-sm-2 justify-content-between">

                                @if ($dataDetailPenjualanOnline->diskon > 0)
                                    <h5 class="text-decoration-line-through text-secondary">
                                        Rp {{ number_format($dataDetailPenjualanOnline->harga, 0, ',', '.') }}
                                    </h5>
                                    <?php $dataDetailPenjualanOnline->harga = $dataDetailPenjualanOnline->harga - ($dataDetailPenjualanOnline->harga * $dataDetailPenjualanOnline->diskon) / 100; ?>
                                    <h5 class="teks-merah">
                                        <b>Rp {{ number_format($dataDetailPenjualanOnline->harga, 0, ',', '.') }}</b>
                                    </h5>
                                @else
                                    <h5>
                                        Rp {{ number_format($dataDetailPenjualanOnline->harga, 0, ',', '.') }}
                                    </h5>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection

@section('jsMidtrans')
    <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            if ('{{ $snapToken }}') {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        /* You may add your own implementation here */
                        window.location.href = '/invoice'
                    },
                    onPending: function(result) {
                        /* You may add your own implementation here */
                        // window.location.href = '/invoice'
                    },
                    onError: function(result) {
                        /* You may add your own implementation here */
                        // alert("payment failed!");
                        // console.log(result);
                    },
                    onClose: function() {
                        /* You may add your own implementation here */
                        // alert('you closed the popup without finishing the payment');
                    }
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Pilih alamat pengiriman terlebih dahulu'
                })
            }

        });
    </script>
@endsection
