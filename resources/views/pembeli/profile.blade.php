@extends('layout.main_pembeli')
@section('konten')
    <br><br>
    @if (session()->has('aksi'))
        <div class="flash-data" data-title="Berhasil" data-aksi="{{ session('aksi') }}" data-halaman="{{ session('halaman') }}">
        </div>
    @elseif (session()->has('gagalhapus'))
    <div class="flash-data" data-title="{{ session('gagalhapus') }}" data-aksi=".." data-halaman="alamat">
    </div>
    <p>{{ session('gagalhapus') }}</p>
    @endif

    @error('keterangan')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="alamat">
        </div>
    @enderror
    @error('provinsi')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="alamat">
        </div>
    @enderror
    @error('kabupaten')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="alamat">
        </div>
    @enderror
    @error('kecamatan')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="alamat">
        </div>
    @enderror
    @error('kelurahan')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="alamat">
        </div>
    @enderror
    @error('alamat_detail')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="alamat">
        </div>
    @enderror
    {{-- Modal Alamat --}}
    <div class="modal fade" id="alamat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container">
                        <h5 class="modal-title judul-keranjang" id="exampleModalLabel">
                            Alamat
                        </h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahAlamat') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                            <input type="text" name="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror"
                                value="{{ old('keterangan') }}" placeholder="Rumah,Kos,Dll" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                            @error('keterangan')
                                <div class="text-danger form-text">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Provinsi</label>
                            <select class="form-select @error('provinsi') is-invalid @enderror" id="provinsi"
                                name="provinsi" aria-label="Default select example">
                                <option select value="">Pilih Provinsi</option>
                                @foreach ($provinsi as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                            @error('provinsi')
                                <div class="text-danger form-text">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Kabupaten</label>
                            <select class="form-select @error('kabupaten') is-invalid @enderror" id="kabupaten"
                                name="kabupaten" aria-label="Default select example">
                            </select>
                            @error('kabupaten')
                                <div class="text-danger form-text">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Kecamatan</label>
                            <select class="form-select @error('kecamatan') is-invalid @enderror" id="kecamatan"
                                name="kecamatan" aria-label="Default select example">
                            </select>
                            @error('kecamatan')
                                <div class="text-danger form-text">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Kelurahan</label>
                            <select class="form-select @error('kelurahan') is-invalid @enderror" id="kelurahan"
                                name="kelurahan" aria-label="Default select example">
                            </select>
                            @error('kelurahan')
                                <div class="text-danger form-text">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Alamat Detail</label>
                            <textarea class="form-control @error('alamat_detail') is-invalid @enderror"
                                placeholder="Perumahan Citra Abadi Blok Rt,Rw" name="alamat_detail">{{ old('alamat_detail') }}</textarea>
                            @error('alamat_detail')
                                <div class="text-danger form-text">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn text-white btn-merah rounded-5 px-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-4 detail-profile">
        <div class="row mb-3">
            <div class="col-lg-12 d-flex justify-content-between">
                <h5>Profile</h5>
                <a class="btn text-white btn-merah rounded-5 px-3" href="{{ route('viewEditProfile') }}">Edit</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="col-12 py-5 px-4 d-lg-flex d-md-flex login">
                    <p>{{ auth()->user()->nama_user }}</p>
                    <p class="px-lg-4 px-md-3">{{ auth()->user()->email }}</p>
                    <p>{{ auth()->user()->username }}</p>
                    <p class="px-lg-4 px-md-3">62{{ auth()->user()->nomor }}</p>
                    <p>{{ auth()->user()->tgl_lahir->format('d M Y')}}</p>
                </div>

            </div>
        </div>
    </div>

    <div class="container mb-4 card-alamat">
        <div class="row mb-2">
            <div class="col-lg-12 d-flex justify-content-between">
                <h5>Alamat</h5>
                <a class="btn text-white btn-merah rounded-5 px-3" data-bs-toggle="modal"
                    data-bs-target="#alamat">Tambah</a>
            </div>
        </div>
        <div class="row">
            @foreach ($alamat as $row)
                <div class="col-6 col-lg-4 col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $row->keterangan }}</h5>
                            <p><b>Provinsi</b></p>
                            <p>{{ $row->provinsi }}</p>
                            <p><b>Kabupaten</b></p>
                            <p>{{ $row->kabupaten }}</p>
                            <p><b>Kecamatan</b></p>
                            <p>{{ $row->kecamatan }}</p>
                            <p><b>Kelurahan</b></p>
                            <p>{{ $row->kelurahan }}</p>
                            <p><b>Detail Alamat</b></p>
                            <p>{{ $row->alamat_detail }}</p>
                            <div class="">
                                <a href="{{ route('viewEditAlamat', $row->id_alamat) }}" class="me-2">Edit</a>
                                <a href="{{ route('hapusAlamat', $row->id_alamat) }}">Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container justify-content-center mb-4">
        <div class="row mb-3">
            <div class="col-lg-12 d-flex justify-content-between">
                <h5>History Pembelian</h5>
            </div>
        </div>
        <div class="row">
            <?php $indexDiskon = 0; ?>
            <?php $indexPenjualanOnline = 0; ?>
            @foreach ($penjualanOnline as $rowPenjualanOnline)
                <div class="col-lg-12 mb-5">
                    <div class="card card-invoice">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-12">
                                            <center>
                                                @if ($rowPenjualanOnline->status == 1)
                                                    <p class="text-success" style="font-size: 3em;"><b><i
                                                                class="bi bi-check-circle"></i></b></p>
                                                    <p style="font-size: 1.2em;"><b>Transaksi Berhasil</b></p>
                                                    <p class="text-secondary fw-lighter">Terima kasih atas pesanan anda</p>
                                                @elseif($rowPenjualanOnline->status == 4)
                                                    <p class="text-danger" style="font-size: 3em;"><b><i
                                                                class="bi bi-x-circle"></i></b></p>
                                                    <p style="font-size: 1.2em;"><b>Transaksi Gagal</b></p>
                                                    <p class="text-secondary fw-lighter">Maaf, Silahkan Dicoba Lagi</p>
                                                @elseif($rowPenjualanOnline->status == 3)
                                                <p class="text-info" style="font-size: 3em;"><b><i class="bi bi-clock-history"></i></b></p>
                                                    <p style="font-size: 1.2em;"><b>Transaksi Pending</b></p>
                                                    <p class="text-secondary fw-lighter">Maaf, Silahkan Melakukan Pembayaran</p>
                                                @elseif($rowPenjualanOnline->status == 5)
                                                    <p class="text-danger" style="font-size: 3em;"><b><i
                                                                class="bi bi-x-circle"></i></b></p>
                                                    <p style="font-size: 1.2em;"><b>Transaksi Dibatalkan</b></p>
                                                    <p class="text-secondary fw-lighter">Kami Akan Menghubungi Anda</p>
                                                    @elseif($rowPenjualanOnline->status == 6)
                                                    <p class="text-success" style="font-size: 3em;"><b><i class="bi bi-cash-stack"></i></b></p>
                                                    <p style="font-size: 1.2em;"><b>Pembayaran Dikonfirmasi</b></p>
                                                    <p class="text-secondary fw-lighter">Produk Akan Kami Kemas</p>
                                                    @elseif($rowPenjualanOnline->status == 7)
                                                    <p class="text-dark" style="font-size: 3em;"><b><i class="bi bi-truck"></i></b></p>
                                                    <p style="font-size: 1.2em;"><b>Paket Sedang Dikirim</b></p>
                                                    <p class="text-secondary fw-lighter">Mohon Ditunggu Paket Anda</p>
                                            @endif
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @if ($rowPenjualanOnline->status == 7)
                            <li class="list-group-item d-flex justify-content-between">
                                <p><b>Apakah Paket Sudah Diterima</b></p>
                                <a id="acc" href="{{ route('accPaketPembeli',$rowPenjualanOnline->id_penjualan_online) }}" class="btn text-white btn-merah rounded-5 px-3" data-id="{{ $rowPenjualanOnline->id_penjualan_online }}">Sudah</a>
                            </li>
                            @endif
                            <li class="list-group-item">
                                <p><b>Tanggal Transaksi</b></p>
                                <p class="text-secondary fw-light">{{ $rowPenjualanOnline->tgl->format('d M Y'); }}</p>
                            </li>
                            <li class="list-group-item">
                                <p><b> Metode Pembayaran</b></p>
                                <p class="text-secondary fw-light">Transfer Bank</p>
                            </li>
                            <li class="list-group-item">
                                <p><b>Virtual Account Number</b></p>
                                <p class="text-secondary fw-light">{{ $rowPenjualanOnline->va_number }}</p>
                            </li>
                            <li class="list-group-item">
                                <p><b> Jasa Pengiriman</b></p>
                                <p class="text-secondary fw-light">JNE {{ $rowPenjualanOnline->service }}, Estimasi
                                    {{ $rowPenjualanOnline->estimasi }}</p>
                            </li>
                            <li class="list-group-item">
                                <p><b>Detail Transaksi</b></p>

                                @foreach ($detailPenjualanOnline->skip($indexPenjualanOnline) as $row)
                                    @if ($row->id_penjualan_online == $rowPenjualanOnline->id_penjualan_online)
                                        <?php $indexPenjualanOnline++; ?>
                                        <div
                                            class="col-12 mb-2 mb-lg-12 d-flex justify-content-between keranjang-produk mb-3">
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
                                                    <div class="mb-2 mb-lg-3 mb-sm-2 alert alert-danger" role="alert">
                                                    produk ini dibatalkan
                                                    </div>
                                                    @endif
                                            </div>
                                        </div>
                                    @else
                                        <?php break; ?>
                                    @endif
                                @endforeach
                            </li>

                            <li class="list-group-item">
                                <div class="col-12 d-flex justify-content-between">
                                    <p>Subtotal</p>
                                    <p class="teks-merah"><b>Rp
                                            {{ number_format($rowPenjualanOnline->sub_total, 0, ',', '.') }}</b></p>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="col-12 d-flex justify-content-between">
                                    <p>Diskon</p>

                                    <p class="fw-light text-primary">
                                        <?php $status=null; ?>
                                        @if ($diskon->count()!=0)
                                        <?php $status='tidak ada'; ?>
                                            @foreach ($diskon->skip($indexDiskon) as $row)
                                                @if ($row->id_penjualan_online == $rowPenjualanOnline->id_penjualan_online)
                                                    <?php $indexDiskon++; ?>
                                                    {{ $row->diskon . '% ' }}
                                                    <?php $status='ada'; ?>
                                                @else
                                                    <?php break; ?>
                                                @endif
                                            @endforeach
                                        @else
                                            Tidak Ada
                                        @endif

                                        @if($status == 'tidak ada')
                                            Tidak Ada
                                        @endif
                                    </p>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="col-12 d-flex justify-content-between">
                                    <p>Ongkir</p>
                                    <p class="teks-merah"><b>Rp
                                            {{ number_format($rowPenjualanOnline->total_ongkir, 0, ',', '.') }}</b></p>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="col-12 d-flex justify-content-between mb-4">
                                    <p>Total</p>
                                    <p class="teks-merah" style="font-size: 1.1em;"><b>Rp
                                            {{ number_format($rowPenjualanOnline->total, 0, ',', '.') }}</b></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <br>
@endsection

@section('jsDataDaerahIndonesia')

<script>
        $(function() {
            $('#provinsi').on('change', function() {
                let id_provinsi = $('#provinsi').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('dataKabupaten') }}',
                    data: {
                        idProvinsi: id_provinsi
                    },
                    cache: false,

                    success: function(msg) {
                        $('#kabupaten').html(msg);
                        $('#kecamatan').html('');
                        $('#kelurahan').html('');
                    },
                    error: function(data) {
                        console.log('Error: ', data);
                    }
                })
            })

            

            $('#kabupaten').on('change', function() {
                let id_kabupaten = $('#kabupaten').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('dataKecamatan') }}',
                    data: {
                        idKabupaten: id_kabupaten
                    },
                    cache: false,

                    success: function(msg) {
                        $('#kecamatan').html(msg);
                        $('#kelurahan').html('');
                    },
                    error: function(data) {
                        console.log('Error: ', data);
                    }
                })
            })




            $('#kecamatan').on('change', function() {
                let id_kecamatan = $('#kecamatan').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('dataKelurahan') }}',
                    data: {
                        idKecamatan: id_kecamatan
                    },
                    cache: false,

                    success: function(msg) {
                        $('#kelurahan').html(msg);
                    },
                    error: function(data) {
                        console.log('Error: ', data);
                    }
                })
            })
        })
    </script>

@endsection
