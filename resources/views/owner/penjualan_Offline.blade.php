@extends('layout.main_owner')
@section('konten')
    <div class="row mb-2">
        <div class="col-6 col-md-6 col-lg-6">
            <h3 class="text-dark">Daftar Penjualan Offline</h3>
        </div>
    </div>
    <div class="card" style="background-color: #FCFCFE;">
        <div class="card-body">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" width="100%" data-page-length="10"
                                        data-order="[[ 0, &quot;asc&quot; ]]">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Penjualan Offline</th>
                                                <th>Tanggal</th>
                                                <th>Total</th>
                                                <th>Diterima</th>
                                                <th>Kembalian</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
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
            </div>
        </div>
    </div>
@endsection

@section('yajra-default')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dataPenjualanOfflineOwner') }}',
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'id_penjualan_offline',
                    name: 'id_penjualan_offline'
                }, {
                    data: 'tgl',
                    name: 'tgl'
                }, {
                    data: 'total',
                    name: 'total'
                }, {
                    data: 'diterima',
                    name: 'diterima'
                }, {
                    data: 'kembalian',
                    name: 'kembalian'
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
