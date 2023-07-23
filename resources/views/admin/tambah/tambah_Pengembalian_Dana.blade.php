@extends('layout.main_admin')
@section('konten')
<div class="row mb-2">
        <div class="col-6 col-md-6 col-lg-6">
            <h3 class="text-dark">Form Pengembalian Dana</h3>
        </div>
    </div>
    <div class="card" style="background-color: #FCFCFE;">
        <div class="card-body">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                    <form action="{{ route('tambahPengembalianDanaAdmin') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="penjualan_online_id" value={{ $id }}>
                        <div class="mb-3">
                            <label class="form-label">Bukti Pengembalian Dana</label>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-5">
                                        <img class="img-preview img-fluid mb-3 col-md-8">
                                    </div>
                                </div>
                            </div>
                            
                            <input type="file" class="form-control @error('bukti') is-invalid @enderror"
                                id="gambar" name="bukti" onchange="imgPreview()">
                            @error('bukti')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Dana</label>
                            <input type="text" class="form-control @error('total_dana') is-invalid @enderror"
                                value="{{ old('total_dana') }}" id="total_dana" name="total_dana">
                            @error('total_dana')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" value="{{ old('keterangan') }}" name="keterangan" rows="3"></textarea>
                            @error('keterangan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-maroon">Submit</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('yajra-default')
    <script>
        $(document).ready(function() {
          
        });
        const harga = document.querySelector('form #total_dana');
        harga.addEventListener('keyup',function(){
            let dataHarga = harga.value;
            dataHarga = dataHarga.replace(/\D/g, '');
            harga.value = new Intl.NumberFormat('en-US').format(dataHarga);
        })
    </script>
@endsection