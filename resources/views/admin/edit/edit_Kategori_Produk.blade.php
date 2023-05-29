@extends('layout.main_admin')
@section('konten')
    <div class="row mb-2">
        <div class="col-6 col-md-6 col-lg-6">
            <h3 class="text-dark">Form Edit Kategori Produk</h3>
        </div>
    </div>
    <div class="card" style="background-color: #FCFCFE;">
        <div class="card-body">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form action="{{ route('editKategoriProduk') }}" method="POST">
                            @csrf
                            <input type="hidden" id="id_kategori_produk" name="id_kategori_produk" value="{{ $data->id_kategori_produk }}">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control @error('nama_kategori_produk') is-invalid @enderror"
                                    id="nama_kategori_produk" name="nama_kategori_produk"
                                    value="{{ old('nama_kategori_produk',$data->nama_kategori_produk) }}">
                                @error('nama_kategori_produk')
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
