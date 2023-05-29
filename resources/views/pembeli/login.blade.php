<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style3.css') }}" />
</head>

<body style="background-color:#F8D3D2;">

    @if (session()->has('title') && session('title') == 'Berhasil')
        <div class="flash-data" data-aksi='Registrasi' data-halaman='Pembeli' data-title='{{ session('title') }}'>
        </div>
    @elseif(session()->has('title') == 'Gagal')
        <div class="flash-data" data-aksi='Login' data-halaman='Pembeli' data-title='{{ session('title') }}'>
        </div>
    @endif
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
                    <p style="font-size: 1.2em;"><b>Masuk</b></p>
                    <form action="{{ route('loginPembeli') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Username</label>
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror">
                            @error('username')
                                <div class="text-danger form-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="text-danger form-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" style="width: 100%;"
                                class="p-2 btn text-white btn-all btn-oval">Masuk</button>
                        </div>
                    </form>
                    <div>
                        <form action="{{ route('viewRegistrasiPembeli') }}" method="GET">

                            <button type="submit" style="width: 100%;"
                                class="p-2 btn btn-alamat-pengiriman btn-oval">Daftar</button>
                        </form>
                    </div>
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
