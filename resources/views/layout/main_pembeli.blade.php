<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Midtrans --}}
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style3.css') }}" />

    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>{{ $judul }}</title>
</head>

<body style="background-color:#F6F8FD;">
    <nav class="fixed-top navbar navbar-expand-lg navbar-light"
        style="border:1px solid #FEFEFE; border-bottom-left-radius:20px; border-bottom-right-radius:20px; box-shadow: 0px 4px 10px rgba(3, 46, 71, 0.01);">
        <div class="container">
            <a class="navbar-brand" href="{{ route('beranda') }}">The British</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('beranda') }}">Beranda</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($kategori as $row)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('viewSemuaProduk', $row->nama_kategori_produk) }}">{{ $row->nama_kategori_produk }}</a>
                                </li>
                            @endforeach

                        </ul>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('viewProdukPembeli') }}" method="get">
                            <input class="form-control search" name="search" type="text" placeholder="Cari Produk"
                                aria-label="Search" />
                        </form>
                    </li>
                </ul>
                {{-- tanda --}}
                @if (auth()->check())
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-right">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('keranjang') }}"><i
                                    class="bi bi-bag-fill"></i></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->nama_user }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logoutPembeli') }}">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-right">
                        <li class="nav-item mb-2">
                            <a class="nav-link text-danger py-md-2 py-lg-1 px-4 btn btn-oval"
                                style="border: 1px solid #da251c;" href="{{ route('viewLoginPembeli') }}">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-md-2 py-lg-1 px-4 text-white btn btn-oval btn-merah"
                                href="{{ route('viewRegistrasiPembeli') }}">Daftar</a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>
    <br>

    <br>
    @yield('konten')

    <footer class="container-fluid">
        <div class="container px-3 py-5">
            <div class="row text-white d-flex justify-content-between">
                <div class="col-md-4 col-lg-4">
                    <h2>The British</h2>
                </div>
                <div class="col-md-4 col-lg-4">
                    <h5>Alamat</h5>
                    <p>DTC Wonokromo</p>
                    <p>Lt 3 Blok A 99-102, Surabaya</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>

    {{-- Notif Sweetalert --}}
    <script src="{{ asset('assets/sweetalert/sweetalert2.all.min.js') }}"></script>

    {{-- Notif --}}
    <script src="{{ asset('assets/js/notifPembeli.js') }}"></script>

    <!-- Owl Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(".owl-carousel").owlCarousel({
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 2,
                },
                576: {
                    items: 2,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 3,
                },
                1200: {
                    items: 4,
                },
            },
        });
    </script>

    <script>
        $(".produk-carousel").owlCarousel({
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 4,
                },
                576: {
                    items: 4,
                },
                768: {
                    items: 4,
                },
                1000: {
                    items: 4,
                },
                1200: {
                    items: 4,
                },
            },
        });
    </script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
        });
    </script>

    <script>
        $(function() {
            $('#alamat_id').on('change', function() {
                let id_alamat = $('#alamat_id').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('dataPaketLayananJne') }}',
                    data: {
                        idAlamat: id_alamat
                    },
                    cache: false,
                    success: function(msg) {
                        $('#paket').html(msg);
                    },
                    error: function(data) {
                        console.log('Error: ', data);
                    }
                })
            })
        })
    </script>

    <script>
        $(function() {
            $('#provinsi').on('change', function() {
                let id_provinsi = $('#provinsi').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('dataKabupaten') }}',
                    data: {
                        idProvinsi: id_provinsi
                    },
                    cache: false,

                    success: function(msg) {
                        $('#kabupaten').html(msg);
                        $('#kecamatan').html('');
                        $('#kelurahan').html('');
                    },
                    error: function(data) {
                        console.log('Error: ', data);
                    }
                })
            })

            $('#kabupaten').on('change', function() {
                let id_kabupaten = $('#kabupaten').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('dataKecamatan') }}',
                    data: {
                        idKabupaten: id_kabupaten
                    },
                    cache: false,

                    success: function(msg) {
                        $('#kecamatan').html(msg);
                        $('#kelurahan').html('');
                    },
                    error: function(data) {
                        console.log('Error: ', data);
                    }
                })
            })




            $('#kecamatan').on('change', function() {
                let id_kecamatan = $('#kecamatan').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('dataKelurahan') }}',
                    data: {
                        idKecamatan: id_kecamatan
                    },
                    cache: false,

                    success: function(msg) {
                        $('#kelurahan').html(msg);
                    },
                    error: function(data) {
                        console.log('Error: ', data);
                    }
                })
            })
        })
    </script>

    @yield('jsMidtrans')

    @yield('jsGambar')
</body>

</html>
