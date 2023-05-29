@extends('layout.main_pembeli')
@section('konten')
    <div class="container mb-5">
        <div class="row justify-content-between">
            <div class="col-lg-6 img-produk">
                <div class="row mb-3">
                    <div class="col-12">
                        <span class="fs-6 px-2 py-2 text-white card-promo-potongan">Beli 2 Diskon 50%</span>
                        <img src="{{ asset('assets/img/banner.jpg') }}" alt="" class="besar" />
                    </div>
                </div>
                <div class="row">
                    <div class="produk-carousel owl-theme">
                        <div class="item">
                            <img src="{{ asset('assets/img/banner.jpg') }}" alt="" class="kecil" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 pt-3 pt-lg-5 detail-produk">
                <h5 class="teks-merah mb-2 mb-lg-4">Gotchi</h5>
                <p class="mb-2 mb-lg-3">Uniqlo</p>
                <div class="col-6 d-flex justify-content-between mb-lg-2">
                    <p class="harga-awal text-decoration-line-through">
                        Rp.100.000
                    </p>
                    <p class="teks-merah">Rp.50.000</p>
                </div>
                <p class="mb-lg-4">Kaos</p>
                <div class="col-12 col-lg-12">
                    <button style="width: 100%" class="btn btn-merah text-white">
                        Masukkan Keranjang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row mb-3 judul-konten">
            <div class="col-lg-12 d-flex justify-content-between">
                <h5>Produk Diskon</h5>
                <a class="teks-detail teks-merah text-decoration-none" href="#">Lihat Detail</a>
            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme">
                <div class="item mb-2">
                    <a class="text-decoration-none" href="{{ route('detail-produk-promo') }}">
                        <div class="card card-produk">
                            <p class="text-center text-white card-promo-minimal px-1 py-1 rounded-3">
                                Beli 2, Diskon 50%
                            </p>
                            <img src="{{ asset('assets/img/banner.jpg') }}" class="card-img-top produk" alt="..." />
                            <div class="card-body">
                                <h5 class="card-title text-dark">Kemeja</h5>
                                <p class="card-text text-dark">Adidas</p>
                                <h5 class="teks-merah text-danger">Rp.100.000</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 pb-4 pb-lg-5 deskripsi-produk">
                <h5><b>Deskripsi</b></h5>
                <p class="text-secondary">
                    Lorem, ipsum dolor sit amet consectetur adipisicing
                    elit. Eos sapiente ab, similique ipsam accusamus rem
                    sint, obcaecati nostrum nulla voluptate quod placeat
                    voluptas tenetur consequuntur ullam, architecto
                    inventore laudantium quasi? Aliquam veritatis iure
                    quaerat quo recusandae molestiae accusamus reprehenderit
                    sunt esse corrupti totam repudiandae ipsam praesentium,
                    vel perspiciatis dolorem eligendi ab suscipit. Modi illo
                    omnis magnam possimus accusamus ducimus facere debitis
                    saepe provident incidunt. Exercitationem quo facilis
                    tempora id, itaque dolorem commodi sed eius blanditiis!
                    Ipsa perferendis cupiditate temporibus odit eius tempore
                    nesciunt! Nulla amet corporis sint dolor! Dicta quis
                    tempore id. Veniam aliquid laborum a beatae, quaerat
                    corporis quibusdam, eius temporibus similique explicabo
                    ut labore ipsam quo atque adipisci illo dignissimos iure
                    error eveniet dolorum amet! Sed cum doloribus porro
                    modi, accusamus blanditiis ullam recusandae corrupti
                    amet reiciendis dolorem alias architecto fugit in
                    expedita hic at exercitationem officia eius aut error
                    nesciunt? Numquam atque inventore autem explicabo
                    provident laudantium, perferendis tempore officia ab
                    placeat magnam dignissimos est maxime omnis dicta. Enim
                    similique, est velit delectus quae tenetur blanditiis
                    iure explicabo hic nemo provi
                </p>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row mb-3 judul-konten">
            <div class="col-lg-12">
                <a class="teks-detail float-end teks-merah text-decoration-none" href="#">Lihat Detail</a>
            </div>
        </div>
        <div class="row">
            <div class="owl-carousel owl-theme">
                <div class="item mb-2">
                    <a class="text-decoration-none" href="{{ route('detail-produk-promo') }}"></a>
                    <div class="card card-produk">
                        <img src="{{ asset('assets/img/banner.jpg') }}" class="card-img-top produk" alt="..." />
                        <div class="card-body">
                            <h5 class="card-title text-dark">Kemeja</h5>
                            <p class="card-text text-dark">Adidas</p>
                            <h5 class="text-dark">Rp.50.000</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mb-3 judul-konten">
            <div class="col-lg-12">
                <a class="teks-detail float-end teks-merah text-decoration-none" href="#">Lihat Detail</a>
            </div>
        </div>

        <div class="row">
            <div class="owl-carousel owl-theme">
                <div class="item mb-2">
                    <a class="text-decoration-none" href="{{ route('detail-produk-promo') }}">
                        <div class="card card-produk">
                            <img src="{{ asset('assets/img/banner.jpg') }}" class="card-img-top produk" alt="..." />
                            <div class="card-body">
                                <h5 class="card-title text-dark">Kemeja</h5>
                                <p class="card-text text-dark">Adidas</p>
                                <h5 class="text-dark">Rp.50.000</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection