<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $judul }}</title>
    {{-- Datatable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>
    {{-- Fontawesome Libraries --}}
    <link href="{{ asset('assets/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    {{-- Icon Bootstrap 4 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    {{-- Notif Toast Js --}}
    <script src="{{ asset('assets/js/iziToast.min.js') }}"></script>

    {{-- css modal --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap4-modal-fullscreen.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    {{-- shortcut icon --}}
    <!-- <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logotbt.png') }}"> -->
    {{-- Notif Toast Css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
    {{-- chart js --}}
    <script src="{{ asset('assets/js/chart/Chart.min.js') }}"></script>
    {{-- Trix --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    {{-- Ckeditor 5 --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    <style>
        .coret{
            text-decoration: line-through;
        }
        button.trix-button--icon-attach{
            display: none;
        }
    </style>
    <!-- slecet2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body style="background-color: #F8D3D2;">

    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg bg-white"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"
                                    style="color: #B10133;"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">


                    <li class="dropdown"><a href="/admin/logout" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <div class="d-sm-none d-lg-inline-block text-dark">Hi, Admin
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <form action="{{ route('logoutAdmin') }}" method="POST">
                                @csrf
                                <button class="dropdown-item has-icon text-danger">
                                    <i class="fas fa-sign-out-alt"> Keluar</i>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar" style="background-color: #B10133;">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html" class="text-white">Admin</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header" style="color: #E8A9BB;">Menu</li>

                        <li class="{{ $judul == 'Dashboard' ? 'active' : '' }}"><a class="nav-link"
                                href="/admin/dashboard"><i class="bi bi-house-fill"
                                    style="font-size: 23px;"></i><span>Dashboard</span></a>
                        </li>

                        <li
                            class="dropdown {{ $judul == 'Produk' || $judul == 'Ukuran'  || $judul == 'Merk' || $judul == 'Kategori Produk' || $judul == 'Promo' ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown"><i class="bi bi-bag-fill"
                                    style="font-size: 23px;"></i><span>Master</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ $judul == 'Ukuran' ? 'active' : '' }}"><a class="nav-link"
                                        href="{{ route('viewUkuran') }}">Ukuran</a></li>
                                <li class="{{ $judul == 'Merk' ? 'active' : '' }}"><a class="nav-link"
                                        href="{{ route('viewMerk') }}">Merk</a></li>
                                <li class="{{ $judul == 'Produk' ? 'active' : '' }}"><a class="nav-link"
                                        href="{{ route('viewProduk') }}">Produk</a></li>
                                <li class="{{ $judul == 'Kategori Produk' ? 'active' : '' }}"><a class="nav-link"
                                        href="{{ route('viewKategoriProduk') }}">Kategori Produk</a></li>
                                <li class="{{ $judul == 'Promo' ? 'active' : '' }}"><a class="nav-link"
                                        href="/admin/promo">Promo</a></li>
                            </ul>
                        </li>

                        <li
                            class="dropdown {{ $judul == 'Penjualan Online' || $judul == 'Pengembalian Dana' || $judul == 'Penjualan Offline' || $judul == 'Pembelian Ball' ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown"><i class="bi bi-cart-fill"
                                    style="font-size: 23px;"></i><span>Transaksi</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ $judul == 'Pembelian Ball' ? 'active' : '' }}"><a class="nav-link"
                                        href="{{ route('viewPembelianBallAdmin') }}">Pembelian Ball</a></li>
                                <li class="{{ $judul == 'Pengembalian Dana' ? 'active' : '' }}"><a class="nav-link"
                                        href="{{ route('viewPengembalianDanaAdmin') }}">Pengembalian Dana</a></li>
                                <li class="{{ $judul == 'Penjualan Online' ? 'active' : '' }}"><a class="nav-link"
                                        href="/admin/penjualan-online">Penjualan Online</a></li>
                                <li class="{{ $judul == 'Penjualan Offline' ? 'active' : '' }}"><a class="nav-link"
                                        href="/admin/penjualan-offline">Penjualan Offline</a></li>
                            </ul>
                        </li>

                        <li
                            class="dropdown {{ $judul == 'Laporan Penjualan Online' || $judul == 'Laporan Penjualan Offline' ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown"><i class="bi bi-journals"
                                    style="font-size: 23px;"></i><span>Laporan</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ $judul == 'Laporan Penjualan Online' ? 'active' : '' }}"><a
                                        class="nav-link" href="/admin/laporan-penjualan-online">Laporan Penjualan
                                        Online</a></li>
                                <li class="{{ $judul == 'Laporan Penjualan Offline' ? 'active' : '' }}"><a
                                        class="nav-link" href="/admin/laporan-penjualan-offline">Laporan Penjualan
                                        Offline</a></li>
                            </ul>
                        </li>
                    </ul>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <br><br>
                @yield('konten')

            </div>
        </div>
    </div>


    <!-- General JS Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    {{-- Notif --}}
    <script src="{{ asset('assets/js/notif.js') }}"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function imgPreview() {
            const imagePreview = document.querySelector('.img-preview');
            const gambar = document.querySelector('#gambar');
            imagePreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(gambar.files[0]);

            oFReader.onload = function(oFRevent) {
                imagePreview.src = oFRevent.target.result;
            }
        }
    </script>

    <script>
        const tipe = document.getElementById('tipe');
        tipe.addEventListener('change', function() {
            if (tipe.value == 'potongan harga') {
                document.getElementById('jumlah').value = 1;
                document.getElementById('jumlah').setAttribute('readonly', true);
            }else{
                document.getElementById('jumlah').value = '';
                document.getElementById('jumlah').removeAttribute('readonly');

            }
        })
    </script>

    @yield('yajra-default')
    @yield('ckeditor')
</body>

</html>
