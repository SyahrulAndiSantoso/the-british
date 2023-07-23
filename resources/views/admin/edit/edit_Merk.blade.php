@extends('layout.main_admin')
@section('konten')
<div class="row mb-2">
        <div class="col-6 col-md-6 col-lg-6">
            <h3 class="text-dark">Form Edit Merk</h3>
        </div>
    </div>
    <div class="card" style="background-color: #FCFCFE;">
        <div class="card-body">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form action="{{ route('editMerk') }}" method="POST">
                            @csrf
                            <input type="hidden" id="id_merk" name="id_merk" value="{{ $data->id_merk }}">
                            <div class="mb-3">
                                <label class="form-label">Nama Merk</label>
                                <input type="text" class="form-control @error('nama_merk') is-invalid @enderror"
                                    id="nama_merk" name="nama_merk"
                                    value="{{ old('nama_merk',$data->nama_merk) }}">
                                @error('nama_merk')
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