@extends('layout.main_owner')
@section('konten')
    <section class="section">
        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Detail Penjualan Online</h2>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-title">Alamat Pengiriman</div>
                                    <div class="table-responsive">
                                        <table id="example1" class="display" width="100%" data-page-length="10"
                                            data-order="[[ 0, &quot;asc&quot; ]]">
                                            <thead>
                                                <tr>
                                                    <th>Provinsi</th>
                                                    <th>Kabupaten</th>
                                                    <th>Kecamatan</th>
                                                    <th>Kelurahan</th>
                                                    <th>Alamat Detail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section-title">Jasa Pengiriman</div>
                                    <div class="table-responsive">
                                        <table id="example3" class="display" width="100%" data-page-length="10"
                                            data-order="[[ 0, &quot;asc&quot; ]]">
                                            <thead>
                                                <tr>
                                                    <th>kurir</th>
                                                    <th>Paket Layanan</th>
                                                    <th>Estimasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Detail Produk</div>
                            <div class="table-responsive">
                                <table id="example2" class="display" width="100%" data-page-length="10"
                                    data-order="[[ 0, &quot;asc&quot; ]]">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Gambar</th>
                                            <th>Merk</th>
                                            <th>Ukuran</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Diskon</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-12 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">{{ number_format($penjualanOnline->sub_total, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Ongkir</div>
                                        <div class="invoice-detail-value">{{ number_format($ongkir->total_ongkir, 0, ',', '.') }}</div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">{{ number_format($penjualanOnline->total, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('yajra-default')
    <script>
        $(document).ready(function() {
            $('#example2').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dataDetailPenjualanOnlineOwner', $id) }}',
                aoColumnDefs: [{
                    'bSortable': false,
                    'aTargets': [0]
                }, {
                    'bSearchable': false,
                    'aTargets': [0]
                }],
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'nama_produk',
                    name: 'nama_produk'
                }, {
                    data: 'gambar',
                    name: 'gambar'
                }, {
                    data: 'nama_merk',
                    name: 'nama_merk'
                }, {
                    data: 'ukuran',
                    name: 'ukuran'
                }, {
                    data: 'harga',
                    name: 'harga'
                }, {
                    data: 'qty',
                    name: 'qty'
                }, {
                    data: 'diskon',
                    name: 'diskon'
                }, {
                    data: 'status',
                    name: 'status'
                }]
            });
        });

        $(document).ready(function() {
            $('#example1').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dataAlamatPengirimanOwner', $id) }}',
                searching: false, paging: false, info: false,
                columns: [{
                    data: 'provinsi',
                    name: 'provinsi'
                }, {
                    data: 'kabupaten',
                    name: 'kabupaten'
                }, {
                    data: 'kecamatan',
                    name: 'kecamatan'
                }, {
                    data: 'kelurahan',
                    name: 'kelurahan'
                }, {
                    data: 'alamat_detail',
                    name: 'alamat_detail'
                }]
            });
        });

        $(document).ready(function() {
            $('#example3').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dataJasaPengirimanOwner', $id) }}',
                searching: false, paging: false, info: false,
                columns: [{
                    data: 'kurir',
                    name: 'kurir'
                }, {
                    data: 'service',
                    name: 'service'
                }, {
                    data: 'estimasi',
                    name: 'estimasi'
                }]
            });
        });
    </script>
@endsection