@extends('layout.main_kasir')
@section('konten')
    <section class="section">
        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Detail Penjualan Offline</h2>
                            </div>
                            <hr>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Detail Produk</div>
                            <div class="table-responsive">
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
                                                <th>Diskon</th>
                                                <th>status</th>
                                                <th>aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-12 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value">Rp.
                                            {{ number_format($penjualanOffline->total, 0, ',', '.') }}</div>
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
                ajax: '{{ route('dataDetailPenjualanOfflineKasir', $id) }}',
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
                    data: 'merk',
                    name: 'merk'
                }, {
                    data: 'ukuran',
                    name: 'ukuran'
                }, {
                    data: 'harga',
                    name: 'harga'
                }, {
                    data: 'diskon',
                    name: 'diskon'
                }, {
                    data: 'status',
                    name: 'status'
                }, {
                    data: 'aksi',
                    name: 'aksi'
                }]
            });
        });
    </script>
@endsection
