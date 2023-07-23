@extends('layout.main_admin')
@section('konten')
    @if (session()->has('aksi'))
        <div class="flash-data" data-title="Berhasil" data-aksi="{{ session('aksi') }}" data-halaman="Promo">
        </div>
    @elseif(session()->has('gagal hapus'))
        <div class="flash-data" data-title="{{ session('gagal hapus') }}" data-aksi=".." data-halaman="Promo">
        </div>
    @endif

    @error('nama_promo')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Promo">
        </div>
    @enderror
    @error('tipe')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Promo">
        </div>
    @enderror
    @error('diskon')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Promo">
        </div>
    @enderror
    @error('tgl_mulai')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Promo">
        </div>
    @enderror
    @error('tgl_berakhir')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Promo">
        </div>
    @enderror
    <!-- Modal Tambah -->
    <div class="modal fade modal-fullscreen" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambahPromo') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Promo</label>
                            <input type="text" class="form-control @error('nama_promo') is-invalid @enderror"
                                value="{{ old('nama_promo') }}" id="nama_promo" name="nama_promo">
                            @error('nama_promo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipe</label>
                            <select class="form-control @error('tipe') is-invalid @enderror" name="tipe" id="tipe"
                                value="{{ old('tipe') }}">
                                <option selected value="">Pilih Tipe</option>
                                @if (old('tipe') == 'potongan harga')
                                    <option value="{{ old('tipe') }}" selected>{{ old('tipe') }}</option>
                                    <option value="minimal pembelian">minimal pembelian</option>
                                @elseif(old('tipe') == 'minimal pembelian')
                                    <option value="{{ old('tipe') }}" selected>{{ old('tipe') }}</option>
                                    <option value="potongan harga">potongan harga</option>
                                @else
                                    <option value="potongan harga">potongan harga</option>
                                    <option value="minimal pembelian">minimal pembelian</option>
                                @endif
                            </select>
                            @error('tipe')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Diskon</label>
                            <div class="input-group mb-3">
                            <input type="number" class="form-control @error('diskon') is-invalid @enderror"  value="{{ old('diskon') }}" id="diskon" name="diskon">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                            </div>
                            @error('diskon')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                value="{{ old('jumlah') }}" id="jumlah" name="jumlah">
                            @error('jumlah')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('tgl_mulai') is-invalid @enderror"
                                value="{{ old('tgl_mulai') }}" id="tgl_mulai" name="tgl_mulai">
                            @error('tgl_mulai')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Berakhir</label>
                            <input type="date" class="form-control @error('tgl_berakhir') is-invalid @enderror"
                                value="{{ old('tgl_berakhir') }}" id="tgl_berakhir" name="tgl_berakhir">
                            @error('tgl_berakhir')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-maroon">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-6 col-md-6 col-lg-6">
            <h3 class="text-dark">Daftar Promo</h3>
        </div>
        <div class="col-6 col-md-6 col-lg-6 text-right">
            <a data-toggle="modal" data-target="#modalTambah" style="cursor:pointer;"
                class="text-white button-tambah">Tambah</a>
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
                                                <th>Nama Promo</th>
                                                <th>Diskon</th>
                                                <th>Deskripsi</th>
                                                <th>Tipe</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Berakhir</th>
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
                ajax: '{{ route('dataPromo') }}',
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'nama_promo',
                    name: 'nama_promo'
                }, {
                    data: 'diskon',
                    name: 'diskon'
                }, {
                    data: 'deskripsi',
                    name: 'deskripsi'
                }, {
                    data: 'tipe',
                    name: 'tipe'
                }, {
                    data: 'tgl_mulai',
                    name: 'tgl_mulai'
                }, {
                    data: 'tgl_berakhir',
                    name: 'tgl_berakhir'
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
