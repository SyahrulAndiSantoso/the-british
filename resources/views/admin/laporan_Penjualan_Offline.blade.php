@extends('layout.main_admin')
@section('konten')
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <h4 class="text-dark">Daftar Penjualan Offline</h4>
        </div>
    </div>
    <div class="card" style="background-color: #FCFCFE;">
        <div class="card-body">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('cekLaporanPenjualanOfflineAdmin') }}" method="post">
                                    <div class="row mb-4">
                                        @csrf
                                        <div class="col-12 col-md-6 col-lg-6 mb-3">
                                            <label class="form-label">Dari Tanggal</label>
                                            <input type="date" name="tgl_awal" value="{{ old('tgl_awal') }}" class="form-control @error('tgl_awal') is-invalid @enderror">
                                            @error('tgl_awal')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 mb-3">
                                            <label class="form-label">Sampai Tanggal</label>
                                            <input type="date" name="tgl_akhir" value="{{ old('tgl_akhir') }}" class="form-control @error('tgl_akhir') is-invalid @enderror">
                                            @error('tgl_akhir')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-12 mb-3">
                                            <label class="form-label">Filter</label>
                                            <select class="form-control" name="filter" id="exampleFormControlSelect1">
                                                <option selected value="">Pilih Filter</option>
                                                @foreach ($kategori as $data)
                                                    <option value="{{ $data->id_kategori_produk }}">
                                                        {{ $data->nama_kategori_produk }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <button type="submit" class="btn btn-maroon">Submit</button>
                                        </div>
                                    </div>
                                </form>
                                @isset($hasil)
                                    <div class="alert alert-primary text-center" role="alert">
                                        TOTAL KESELURUHAN : <b>Rp{{ number_format($total->total_keseluruhan, 0, ',', '.') }}</b>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example" class="display" width="100%" data-page-length="10"
                                            data-order="[[ 0, &quot;asc&quot; ]]">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                @foreach ($hasil as $data)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $data->tgl }}</td>
                                                        <td>Rp{{ number_format($data->total, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endisset
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
                searching: false,
                paging: true,
                info: false,
            });
        });
    </script>
@endsection
