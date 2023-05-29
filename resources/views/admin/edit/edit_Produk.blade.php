@extends('layout.main_admin')
@section('konten')
    <div class="row mb-2">
        <div class="col-6 col-md-6 col-lg-6">
            <h3 class="text-dark">Form Edit Produk</h3>
        </div>
    </div>
    <div class="card" style="background-color: #FCFCFE;">
        <div class="card-body">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form action="{{ route('editProduk') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id_produk" name="id_produk" value="{{ $data->id_produk }}">
                            <input type="hidden" id="thumbnailLama" name="thumbnailLama" value="{{ $data->thumbnail }}">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                                    id="nama_produk" name="nama_produk"
                                    value="{{ old('nama_produk', $data->nama_produk) }}">
                                @error('nama_produk')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Thumbnail</label>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-5">
                                            @if ($data->thumbnail)
                                                <img src="{{ asset('storage/' . $data->thumbnail) }}"
                                                    class="img-preview img-fluid mb-3 col-md-8 d-block">
                                            @else
                                                <img class="img-preview img-fluid mb-3 col-md-8">
                                            @endif
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
                                <select class="form-control" name="kategori_produk_id" id="exampleFormControlSelect1">
                                    <option value="">Pilih Kategori Produk</option>
                                    @foreach ($kategori as $row)
                                        @if ($data->kategori_produk_id == $row->id_kategori_produk)
                                            <option selected value="{{ $row->id_kategori_produk }}">
                                                {{ $row->nama_kategori_produk }}
                                            </option>
                                        @else
                                            <option value="{{ $row->id_kategori_produk }}">{{ $row->nama }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('kategori_produk_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                    id="harga" name="harga" value="{{ old('harga', $data->harga) }}">
                                @error('harga')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ukuran</label>
                                <input type="text" class="form-control @error('ukuran') is-invalid @enderror"
                                    id="ukuran" name="ukuran" value="{{ old('ukuran', $data->ukuran) }}">
                                @error('ukuran')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Merk</label>
                                <input type="text" class="form-control @error('merk') is-invalid @enderror"
                                    id="merk" name="merk" value="{{ old('merk', $data->merk) }}">
                                @error('merk')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stok</label>
                                <select class="form-control" name="stok" id="exampleFormControlSelect1">
                                    <option value="">Pilih Stok</option>
                                    @if ($data->stok == 'ada')
                                        <option selected value="{{ $data->stok }}">{{ $data->stok }}</option>
                                        <option value="tidak ada">tidak ada
                                        </option>
                                    @else
                                        <option selected value="{{ $data->stok }}">{{ $data->stok }}</option>
                                        <option value="ada">ada
                                        </option>
                                    @endif
                                </select>
                                @error('stok')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <input id="x" type="hidden" class="@error('deskripsi') is-invalid @enderror"
                                    value="{{ old('deskripsi', $data->deskripsi) }}" name="deskripsi">
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
    </div>
@endsection
