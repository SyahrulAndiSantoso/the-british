@extends('layout.main_kasir')
@section('konten')
    @if (session()->has('aksi'))
        <div class="flash-data" data-title="Berhasil" data-aksi="{{ session('aksi') }}" data-halaman="{{ session('halaman') }}">
        </div>
    @endif
    @if (session()->has('title'))
        <div class="flash-data" data-aksi='Checkout' data-halaman='Penjualan Offline' data-title='{{ session('title') }}'>
        </div>
    @endif
    <div class="card" style="background-color: #FCFCFE;">
        <div class="card-body">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                Produk
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-8 mb-4">
                                        <div class="form-group">
                                            <form action="{{ route('viewTambahPenjualanOffline') }}" method="GET">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="search" value="{{ request('search') }}"
                                                        class="form-control" aria-describedby="button-addon2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-maroon" type="submit"
                                                            id="button-addon2">Cari</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    @if ($produk->count() != 0)
                                        @foreach ($produk as $row)
                                            @if ($row->stok == 'tidak ada')
                                                <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4 mb-4">
                                                    <div class="justify-content-center text-danger"><b>Stok Produk Habis
                                                            !!</b></div>
                                                </div>
                                            @else
                                                <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 mb-4">
                                                    <a class="text-decoration-none"
                                                        href="{{ route('tambahPenjualanOffline', $row->id_produk) }}">
                                                        <div class="card card-produk">
                                                            <img src="{{ asset('storage/' . "$row->thumbnail") }}"
                                                                class="card-img-top produk" alt="..." />
                                                            <div class="card-body">
                                                                <p class="card-title text-dark">{{ $row->nama_produk }}</p>
                                                                <h6 class="text-dark">
                                                                    Rp {{ number_format($row->harga, 0, ',', '.') }}</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    @elseif($produk->count() == 0)
                                        <div class="justify-content-center text-danger"><b>Produk Tidak Ditemukan !!</b>
                                        </div>
                                    @else
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                Keranjang
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" width="100%" data-page-length="10"
                                        data-order="[[ 0, &quot;asc&quot; ]]">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Produk</th>
                                                <th>Gambar</th>
                                                <th>Merk</th>
                                                <th>Ukuran</th>
                                                <th>Harga</th>
                                                <th>Diskon</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($penjualanOffline))
            <div class="card-body">
                <div class="section-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    Chekcout
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('checkoutPenjualanOffline') }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <label for="exampleInputPassword1">Total</label>
                                            <input type="text" value="{{ $penjualanOffline->total }}" id="total"
                                                name="total" class="form-control" id="exampleInputPassword1"
                                                placeholder="Password" readonly>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="exampleInputPassword1">Bayar</label>
                                            <input type="text" value="{{ $penjualanOffline->total }}" name="bayar"
                                                class="form-control" id="exampleInputPassword1" placeholder="Password"
                                                readonly>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="exampleInputPassword1">Diterima</label>
                                            <input type="text" id="diterima" name="diterima"
                                                class="form-control @error('diterima') is-invalid @enderror"
                                                id="exampleInputPassword1">
                                            @error('diterima')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="exampleInputPassword1">Kembalian</label>
                                            <input type="text" name="kembalian" id="kembalian" class="form-control"
                                                id="exampleInputPassword1" readonly>
                                        </div>
                                        <button type="submit" class="btn btn-maroon">Simpan Penjualan Offline</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection

@section('yajra-default')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dataTambahPenjualanOfflineKasir') }}',
                aoColumnDefs: [{
                    'bSortable': false,
                    'aTargets': [0]
                }, {
                    'bSearchable': false,
                    'aTargets': [0]
                }],
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'nama_produk',
                    name: 'nama_produk'
                }, {
                    data: 'gambar',
                    name: 'gambar'
                }, {
                    data: 'merk',
                    name: 'merk'
                }, {
                    data: 'ukuran',
                    name: 'ukuran'
                }, {
                    data: 'harga',
                    name: 'harga'
                }, {
                    data: 'diskon',
                    name: 'diskon'
                }, {
                    data: 'aksi',
                    name: 'aksi'
                }]
            });
        });
    </script>
@endsection

@section('jsCheckout')
    <script>
        const diterima = document.querySelector('form #diterima');
        const total = document.querySelector('form #total');
        const kembalian = document.querySelector('form #kembalian');
        diterima.addEventListener('keyup', function() {
            console.log(diterima.value);
            kembalian.value = diterima.value - total.value;
        })
    </script>
@endsection
