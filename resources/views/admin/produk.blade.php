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

    @error('ukuran_id')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Produk">
        </div>
    @enderror

    @error('merk_id')
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
                            <input type="text" class="form-control @error('harga') is-invalid @enderror"
                                value="{{ old('harga') }}" id="harga" name="harga">
                            @error('harga')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ukuran</label>
                                <select class="js-example-basic-single form-control @error('ukuran_id') is-invalid @enderror"
                                name="ukuran_id" id="ukuran_id">
                                <option selected value="">Pilih Ukuran</option>
                                @foreach ($ukuran as $row)
                                    @if ($row->id_ukuran == old('ukuran_id'))
                                        <option value="{{ $row->id_ukuran }}" selected>
                                            {{ $row->ukuran }}
                                    @endif
                                    <option value="{{ $row->id_ukuran }}">{{ $row->ukuran }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ukuran_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Merk</label>
                            <select class="js-example-basic-single form-control @error('merk_id') is-invalid @enderror"
                            name="merk_id" id="merk_id">
                            <option selected value="">Pilih Merk</option>
                                @foreach ($merk as $row)
                                    @if ($row->id_merk == old('merk_id'))
                                        <option value="{{ $row->id_merk }}" selected>
                                            {{ $row->nama_merk }}
                                    @endif
                            <option value="{{ $row->id_merk }}">{{ $row->nama_merk }}
                            </option>
                                @endforeach
                            </select>
                            @error('merk_id')
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
                                                    <th>Kode Produk</th>
                                                    <th>Nama Produk</th>
                                                    <th>Thumbnail</th>
                                                    <th>Stok</th>
                                                    <th>Kategori</th>
                                                    <th>Harga</th>
                                                    <th>Ukuran</th>
                                                    <th>Merk</th>
                                                    <th>Deskripsi</th>
                                                    <th>Barcode</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($produk as $rowProduk)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $rowProduk->id_produk }}</td>
                                                    <td>{{ $rowProduk->nama_produk }}</td>
                                                    <td> <img src="{{ asset('storage/' . "$rowProduk->thumbnail") }}" width="100"/> </td>
                                                    <td>{{ $rowProduk->stok }}</td>
                                                    <td>{{ $rowProduk->nama_kategori_produk }}</td>
                                                    <td>Rp {{ number_format($rowProduk->harga, 0, ',', '.') }}</td>
                                                    <td>{{ $rowProduk->ukuran }}</td>
                                                    <td>{{ $rowProduk->nama_merk }}</td>
                                                    <td>{!! $rowProduk->deskripsi !!}</td>
                                                    <td>{!! DNS1D::getBarcodeHTML($rowProduk->id_produk, 'C128') !!}
                                                      <center>  {{ $rowProduk->id_produk }}</center>
                                                    </td>
                                                    <td>
                                                        <a href="{{route('viewEditProduk', $rowProduk->id_produk)}}" class="btn btn-warning"><i class="bi bi-pencil-square"></i>Edit</a>
                                                        <a href="{{route('hapusProduk', $rowProduk->id_produk)}}" class="btn btn-danger"><i class="bi bi-trash3-fill"></i>Hapus</a>
                                                        <a href="{{route('viewDetailProduk', $rowProduk->id_produk)}}" class="btn btn-primary"><i class="bi bi-eye-fill mr-2"></i>Lihat Detail</a>
                                                    </td>
                                                </tr>
                                            @endforeach
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
            });
        });
        const harga = document.querySelector('form #harga');
        harga.addEventListener('keyup',function(){
            let dataHarga = harga.value;
            dataHarga = dataHarga.replace(/\D/g, '');
            harga.value = new Intl.NumberFormat('en-US').format(dataHarga);
        })
    </script>
@endsection
