<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style3.css') }}" />
</head>

<body style="background-color:#F8D3D2;">

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-7 mb-4">
                <div class="col-12">
                    <div class="col-3">
                        <img src="{{ asset('assets/img/logo-toko.jpeg') }}" style="border-radius: 100%;" alt=""
                            width="80%" />
                    </div>
                </div>
            </div>
            <div class="col-lg-7 mb-5">
                <div class="col-12  px-4 py-5 login">
                    <p style="font-size: 1.2em;"><b>Registrasi</b></p>
                    <form action="{{ route('registrasiPembeli') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Nama</label>
                            <input name="nama_user" class="form-control @error('nama_user') is-invalid @enderror"
                                value="{{ old('nama_user') }}" autofocus required>
                            @error('nama_user')
                                <div class="text-danger form-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-white"
                                    style="border-top-left-radius: 10px; border-bottom-left-radius: 10px; background-color: #8C8888;"
                                    id="basic-addon1">+62</span>
                                <input type="number" name="nomor"
                                    class="form-control @error('nomor') is-invalid @enderror"
                                    value="{{ old('nomor') }}" required>
                            </div>
                            @error('nomor')
                                <div class="text-danger form-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tgl Lahir</label>
                            <input type="date" name="tgl_lahir"
                                class="form-control @error('tgl_lahir') is-invalid @enderror" id="exampleInputEmail1"
                                value="{{ old('tgl_lahir') }}" required/>
                            @error('tgl_lahir')
                                <div class="text-danger form-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1"
                                value="{{ old('email') }}" required/>
                            @error('email')
                                <div class="text-danger form-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Username</label>
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror" id="exampleInputEmail1"
                                value="{{ old('username') }}" required/>
                            @error('username')
                                <div class="text-danger form-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" required>
                            @error('password')
                                <div class="text-danger form-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" style="width: 100%;" class="p-2 btn text-white btn-all btn-oval">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
