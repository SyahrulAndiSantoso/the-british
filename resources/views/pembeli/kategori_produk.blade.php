@extends('layout.main_pembeli')
@section('konten')
<br><br>
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($kategori as $row)
                <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-4">
                    <a class="text-decoration-none" href="{{ route('viewSemuaProduk', $row->nama_kategori_produk) }}">
                        <div class="card text-white">
                            <img src="{{ asset('assets/img/img-beranda.jpg') }}" class="card-img-top kategori" />
                            <div class="card-img-overlay kategori d-flex align-items-center p-0">
                                <h5 class="card-title flex-fill p-3 p-md-3 p-lg-3 text-center">
                                    {{ $row->nama_kategori_produk }}
                                </h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <br><br><br>
    </div>
@endsection
