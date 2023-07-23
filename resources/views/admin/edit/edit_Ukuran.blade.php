@extends('layout.main_admin')
@section('konten')
<div class="row mb-2">
        <div class="col-6 col-md-6 col-lg-6">
            <h3 class="text-dark">Form Edit Ukuran</h3>
        </div>
    </div>
    <div class="card" style="background-color: #FCFCFE;">
        <div class="card-body">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form action="{{ route('editUkuran') }}" method="POST">
                            @csrf
                            <input type="hidden" id="id_ukuran" name="id_ukuran" value="{{ $data->id_ukuran }}">
                            <div class="mb-3">
                                <label class="form-label">Ukuran</label>
                                <input type="text" class="form-control @error('ukuran') is-invalid @enderror"
                                    id="ukuran" name="ukuran"
                                    value="{{ old('ukuran',$data->ukuran) }}">
                                @error('ukuran')
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