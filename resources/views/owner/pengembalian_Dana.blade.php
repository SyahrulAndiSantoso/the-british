@extends('layout.main_owner')
@section('konten')
@if (session()->has('aksi'))
        <div class="flash-data" data-title="Berhasil" data-aksi="{{ session('aksi') }}" data-halaman="Pengembalian Dana">
        </div>
    @endif
<div class="row mb-2">
        <div class="col-6 col-md-6 col-lg-6">
            <h3 class="text-dark">Daftar Pengembalian Dana</h3>
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
                                                <th>Kode Penjualan Online</th>
                                                <th>Bukti Pengembalian Dana</th>
                                                <th>Total Dana</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($pengembalianDana as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->penjualan_online_id }}</td>
                                                <td> <img src="{{ asset('storage/' . "$row->bukti") }}" width="400"/></td>
                                                <td>Rp{{ number_format($row->total_dana, 0, ',', '.') }}</td>
                                                <td>{{ $row->keterangan }}</td>
                                            </tr>
                                        @endforeach
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
            });
        });
    </script>
@endsection