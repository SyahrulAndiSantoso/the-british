@extends('layout.main_owner')
@section('konten')
    <section class="section">
        <div class="card" style="background-color: #FCFCFE;">
            <div class="card-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="text-white fa-solid fa-users" style="font-size: 30px;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Penjualan Offline</h4>
                                </div>
                                <div class="card-body">
                                    {{ $penjualanOffline }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="text-white fa-solid fa-book" style="font-size: 30px;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Penjualan Online</h4>
                                </div>
                                <div class="card-body">
                                   {{ $penjualanOnline }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="text-white fa-solid fa-clipboard-list" style="font-size: 30px;"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Produk</h4>
                                </div>
                                <div class="card-body">
                                   {{ $produk }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
