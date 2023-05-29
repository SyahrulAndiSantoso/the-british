@extends('layout.main_pembeli')
@section('konten')
    <br><br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="col-12 px-4 py-5 login">
                    <form action="{{ route('editProfile') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama_user"
                                class="form-control @error('nama_user') is-invalid @enderror" id="exampleInputEmail1"
                                value="{{ old('nama_user', auth()->user()->nama_user) }}" />
                            @error('nama')
                                <div class="text-danger form-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor</label>
                            <input type="number" name="nomor" class="form-control @error('nomor') is-invalid @enderror"
                                id="exampleInputEmail1" value="{{ old('nomor', auth()->user()->nomor) }}" />
                            @error('nomor')
                                <div class="text-danger form-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tgl Lahir</label>
                            <input type="date" name="tgl_lahir"
                                class="form-control @error('tgl_lahir') is-invalid @enderror" id="exampleInputEmail1"
                                value="{{ old('tgl_lahir', auth()->user()->tgl_lahir) }}" />
                            @error('tgl_lahir')
                                <div class="text-danger form-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="exampleInputEmail1" value="{{ old('email', auth()->user()->email) }}" />
                            @error('email')
                                <div class="text-danger form-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror" id="exampleInputEmail1"
                                value="{{ old('username', auth()->user()->username) }}" />
                            @error('username')
                                <div class="text-danger form-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Isi Kolom Ini Jika Ingin Mengganti Password" id="exampleInputPassword1" />
                        </div>
                        <button type="submit" class="btn text-white btn-merah">
                            Submit
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
