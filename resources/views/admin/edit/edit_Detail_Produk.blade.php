@extends('layout.main_admin')
@section('konten')
<div class="row mb-2">
    <div class="col-6 col-md-6 col-lg-6">
        <h3 class="text-dark">Form Edit Detail Produk</h3>
    </div>
</div>
<div class="card" style="background-color: #FCFCFE;">
    <div class="card-body">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <form action="{{ route('EditDetailProduk') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" id="id_detail_produk" name="id_detail_produk"
                    value="{{ $data->id_detail_produk }}">
                    <input type="hidden" class="form-control" id="produk_id" name="produk_id"
                    value="{{ $data->produk_id }}">
                    <input type="hidden" class="form-control" id="gambarLama" name="gambarLama"
                        value="{{ $data->gambar }}">
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        @if ($data->gambar)
                        <img src="{{ asset('storage/'. $data->gambar) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block">
                        @else
                        <img class="img-preview img-fluid mb-3 col-sm-5">
                        @endif
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                            id="gambar" name="gambar" onchange="imgPreview()">
                        @error('gambar')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
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