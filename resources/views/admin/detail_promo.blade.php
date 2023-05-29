@extends('layout.main_admin')
@section('konten')
    @if (session()->has('aksi'))
        <div class="flash-data" data-title="Berhasil" data-aksi="{{ session('aksi') }}" data-halaman="Detail Promo">
        </div>
    @elseif(session()->has('gagal'))
        <div class="flash-data" data-title="Gagal" data-aksi="{{ session('gagal') }}" data-halaman="Promo">
        </div>
    @endif
    <div class="row mb-2">
        <div class="col-6 col-md-6 col-lg-6">
            <h3 class="text-dark">Detail Promo</h3>
        </div>
        <div class="col-6 col-md-6 col-lg-6 text-right text-decoration-none">
            <a href="{{ route('checkoutPromo', $promo->id_promo) }}" class="text-white button-tambah">Selesai</a>
        </div>
    </div>
    <section class="section">
        <div class="card" style="background-color: #FCFCFE;">
            <div class="card-body">
                <div class="section-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8 mb-4">
                                            <div class="form-group">
                                                <form action="{{ route('viewDetailPromo', $promo->id_promo) }}"
                                                    method="GET">
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
                                                    <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-4">

                                                        <div class="justify-content-center text-danger"><b>Stok Produk Habis
                                                                !!</b></div>
                                                    </div>
                                                @else
                                                    <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-4">
                                                        <a class="text-decoration-none"
                                                            href="{{ route('tambahDetailPromo', ['idpromo' => $promo->id_promo, 'idproduk' => $row->id_produk]) }}">
                                                            <div class="card card-produk">
                                                                <img src="{{ asset('storage/' . "$row->thumbnail") }}"
                                                                    class="card-img-top produk" alt="..." />
                                                                <div class="card-body">
                                                                    <p class="card-title text-dark">{{ $row->nama_produk }}
                                                                    </p>
                                                                    <p class="card-text text-dark">{{ $row->merk }}</p>
                                                                    <h6 class="text-dark">
                                                                        Rp {{ number_format($row->harga, 0, ',', '.') }}
                                                                    </h6>
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
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    Produk
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="display" width="100%" data-page-length="10"
                                            data-order="[[ 0, &quot;asc&quot; ]]">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Produk</th>
                                                    <th>merk</th>
                                                    <th>ukuran</th>
                                                    <th>Harga</th>
                                                    <th>Gambar</th>
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
        </div>
    </section>
@endsection

@section('yajra-default')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dataDetailPromo', $promo->id_promo) }}',
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
                    data: 'merk',
                    name: 'merk'
                }, {
                    data: 'ukuran',
                    name: 'ukuran'
                }, {
                    data: 'harga',
                    name: 'harga'
                }, {
                    data: 'gambar',
                    name: 'gambar'
                }, {
                    data: 'aksi',
                    name: 'aksi'
                }]
            });
        });
    </script>
@endsection
