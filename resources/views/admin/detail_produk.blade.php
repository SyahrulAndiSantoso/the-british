@extends('layout.main_admin')
@section('konten')
    @if (session()->has('aksi'))
        <div class="flash-data" data-title="Berhasil" data-aksi="{{ session('aksi') }}" data-halaman="Detail Produk">
        </div>
    @elseif(session()->has('gagal'))
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Produk">
        </div>
    @endif

    <div class="row mb-2">
        <div class="col-6 col-md-6 col-lg-6">
            <h3 class="text-dark">Detail Produk</h3>
        </div>
        @if ($id == $idLast && session()->has('status'))
            <div class="col-6 col-md-6 col-lg-6 text-right text-decoration-none">
                <a href="{{ route('checkout') }}" class="text-white button-tambah">Selesai</a>
            </div>
        @endif
    </div>
    <section class="section">
        <div class="card" style="background-color: #FCFCFE;">
            <div class="card-body">
                <div class="section-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    Tambah Gambar
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('tambahDetailProduk') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" id="produk_id" name="produk_id"
                                            value="{{ $id }}">
                                        <div class="mb-3">
                                            <label class="form-label">Gambar</label>
                                            <img class="img-preview img-fluid mb-3 col-sm-5">
                                            <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                                id="gambar" name="gambar" onchange="imgPreview()">
                                            @error('gambar')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-maroon">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="section-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    Detail Produk
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="display" width="100%" data-page-length="10"
                                            data-order="[[ 0, &quot;asc&quot; ]]">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Gambar</th>
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
    </section>
@endsection

@section('yajra-default')
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dataDetailProduk', $id) }}',
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
                    data: 'gambar',
                    name: 'gambar'
                }, {
                    data: 'aksi',
                    name: 'aksi'
                }]
            });
        });
    </script>
@endsection
