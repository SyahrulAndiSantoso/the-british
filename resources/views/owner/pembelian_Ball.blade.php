@extends('layout.main_owner')
@section('konten')
    <div class="row mb-2">
        <div class="col-6 col-md-6 col-lg-6">
            <h3 class="text-dark">Daftar Pembelian Ball</h3>
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
                                                <th>Nama Ball</th>
                                                <th>Tanggal Pembelian</th>
                                                <th>Supplier</th>
                                                <th>Jumlah Pakaian Layak Jual</th>
                                                <th>Jumlah Pakaian Tidak Layak Jual</th>
                                                <th>Total Isi Ball</th>
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
                ajax: '{{ route('dataPembelianBallOwner') }}',
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'nama_ball',
                    name: 'nama_ball'
                }, {
                    data: 'tgl_beli',
                    name: 'tgl_beli'
                },{
                    data: 'supplier',
                    name: 'supplier'
                },{
                    data: 'layak_pakai',
                    name: 'layak_pakai'
                },{
                    data: 'tidak_layak_pakai',
                    name: 'tidak_layak_pakai'
                }, {
                    data: 'total_pakaian',
                    name: 'total_pakaian'
                }]
            });
        });
    </script>
@endsection
