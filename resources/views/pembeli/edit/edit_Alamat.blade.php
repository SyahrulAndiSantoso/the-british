@extends('layout.main_pembeli')
@section('konten')
    <br><br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="col-12  px-4 py-5 login">
                    <form action="{{ route('editAlamat') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_alamat" value="{{ $data->id_alamat }}">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                            <input type="text" name="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror"
                                value="{{ old('keterangan', $data->keterangan) }}" placeholder="Rumah,Kos,Dll"
                                id="exampleInputEmail1" aria-describedby="emailHelp">
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
                                @foreach ($provinsi as $row)
                                    @if ($row->name == $data->provinsi)
                                        <option value="{{ $row->id }}" selected>{{ $row->name }}</option>
                                    @else
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endif
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
                                <option select value="">Pilih Kabupaten</option>
                                @foreach ($kabupaten as $row)
                                    @if ($row->name == $data->kabupaten)
                                        <option value="{{ $row->id }}" selected>{{ $row->name }}</option>
                                    @else
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endif
                                @endforeach
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
                                <option select value="">Pilih Kecamatan</option>
                                @foreach ($kecamatan as $row)
                                    @if ($row->name == $data->kecamatan)
                                        <option value="{{ $row->id }}" selected>{{ $row->name }}</option>
                                    @else
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('kecamatan')
                                <div class="text-danger form-text">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Kelurahan / Desa</label>
                            <select class="form-select @error('kelurahan') is-invalid @enderror" id="kelurahan"
                                name="kelurahan" aria-label="Default select example">
                                <option select value="">Pilih Kelurahan / Desa</option>
                                @foreach ($kelurahan as $row)
                                    @if ($row->name == $data->kelurahan)
                                        <option value="{{ $row->id }}" selected>{{ $row->name }}</option>
                                    @else
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endif
                                @endforeach
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
                                placeholder="Perumahan Citra Abadi Blok Rt,Rw" name="alamat_detail">{{ old('alamat_detail', $data->alamat_detail) }}</textarea>
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
@endsection
