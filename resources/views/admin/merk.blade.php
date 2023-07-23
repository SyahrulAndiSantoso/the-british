@extends('layout.main_admin')
@section('konten')
    @if (session()->has('aksi'))
        <div class="flash-data" data-title="Berhasil" data-aksi="{{ session('aksi') }}" data-halaman="Merk">
        </div>
    @elseif(session()->has('gagal hapus'))
    <div class="flash-data" data-title="{{ session('gagal hapus') }}" data-aksi=".." data-halaman="Merk">
    </div>
    @endif

    @error('nama_merk')
        <div class="flash-data" data-title="Gagal" data-aksi="Menambahkan" data-halaman="Merk">
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
                    <form action="{{ route('tambahMerk') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Merk</label>
                            <input type="text" class="form-control @error('nama_merk') is-invalid @enderror"
                                value="{{ old('nama_merk') }}" id="nama_merk" name="nama_merk">
                            @error('nama_merk')
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
            <h3 class="text-dark">Daftar Merk</h3>
        </div>
        <div class="col-6 col-md-6 col-lg-6 text-right">
            <a data-toggle="modal" data-target="#modalTambah" style="cursor:pointer;"
                class="text-white button-tambah">Tambah</a>
        </div>
    </div>
    <section class="section">
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
                                                    <th>Nama Merk</th>
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
                ajax: '{{ route('dataMerk') }}',
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'nama_merk',
                    name: 'nama_merk'
                }, {
                    data: 'aksi',
                    name: 'aksi'
                }]
            });
        });
</script>
@endsection