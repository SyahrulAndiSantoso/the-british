@extends('layout.main_admin')
@section('konten')
    @if (session()->has('aksi'))
        <div class="flash-data" data-title="Berhasil" data-aksi="{{ session('aksi') }}" data-halaman="Produk">
        </div>
    @elseif(session()->has('gagal hapus'))
    <div class="flash-data" data-title="{{ session('gagal hapus') }}" data-aksi=".." data-halaman="Produk">
    </div>
    @endif

    @error('nama_produk')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Produk">
        </div>
    @enderror

    @error('thumbnail')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Produk">
        </div>
    @enderror

    @error('kategori_produk_id')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Produk">
        </div>
    @enderror

    @error('harga')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Produk">
        </div>
    @enderror

    @error('ukuran')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Produk">
        </div>
    @enderror

    @error('merk')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Produk">
        </div>
    @enderror

    @error('deskripsi')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Produk">
        </div>
    @enderror
    <!-- Modal Tambah -->
    <div class="modal fade modal-fullscreen" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahProduk') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                                value="{{ old('nama_produk') }}" id="nama_produk" name="nama_produk">
                            @error('nama_produk')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Thumbnail</label>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-5">
                                        <img class="img-preview img-fluid mb-3 col-md-8">
                                    </div>
                                </div>
                            </div>
                            
                            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                id="gambar" name="thumbnail" onchange="imgPreview()">
                            @error('thumbnail')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori Produk</label>
                            <select class="form-control @error('kategori_produk_id') is-invalid @enderror"
                                name="kategori_produk_id" id="exampleFormControlSelect1">
                                <option selected value="">Pilih Kategori Produk</option>
                                @foreach ($kategori as $row)
                                    @if ($row->id_kategori_produk == old('kategori_produk_id'))
                                        <option value="{{ $row->id_kategori_produk }}" selected>
                                            {{ $row->nama_kategori_produk }}
                                    @endif
                                    <option value="{{ $row->id_kategori_produk }}">{{ $row->nama_kategori_produk }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_produk_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                value="{{ old('harga') }}" id="harga" name="harga">
                            @error('harga')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ukuran</label>
                            <input type="text" class="form-control @error('ukuran') is-invalid @enderror"
                                value="{{ old('ukuran') }}" id="ukuran" name="ukuran">
                            @error('ukuran')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Merk</label>
                            <input type="text" class="form-control @error('merk') is-invalid @enderror"
                                value="{{ old('merk') }}" id="merk" name="merk">
                            @error('merk')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <input id="x" type="hidden" value="{{ old('deskripsi') }}" name="deskripsi">
                            <trix-editor input="x"></trix-editor>
                            @error('deskripsi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-maroon">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6 col-md-6 col-lg-6">
            <h3 class="text-dark">Daftar Produk</h3>
        </div>
        <div class="col-6 col-md-6 col-lg-6 text-right">
            <a data-toggle="modal" data-target="#modalTambah" style="cursor:pointer;"
                class="text-white button-tambah">Tambah</a>
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
                                    <div class="table-responsive">
                                        <table id="example" class="display" width="100%" data-page-length="10"
                                            data-order="[[ 0, &quot;asc&quot; ]]">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Produk</th>
                                                    <th>Thumbnail</th>
                                                    <th>Stok</th>
                                                    <th>Kategori</th>
                                                    <th>Harga</th>
                                                    <th>Ukuran</th>
                                                    <th>Merk</th>
                                                    <th>Deskripsi</th>
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
                ajax: '{{ route('dataProduk') }}',
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
                    data: 'thumbnail',
                    name: 'thumbnail'
                }, {
                    data: 'stok',
                    name: 'stok'
                }, {
                    data: 'kategori_produk.nama_kategori_produk',
                    name: 'kategori_produk.nama_kategori_produk'
                }, {
                    data: 'harga',
                    name: 'harga'
                }, {
                    data: 'ukuran',
                    name: 'ukuran'
                }, {
                    data: 'merk',
                    name: 'merk'
                }, {
                    data: 'deskripsi',
                    name: 'deskripsi'
                }, {
                    data: 'aksi',
                    name: 'aksi'
                }]
            });
        });
    </script>
@endsection
