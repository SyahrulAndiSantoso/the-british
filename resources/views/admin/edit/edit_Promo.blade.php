@extends('layout.main_admin')
@section('konten')
    <div class="row mb-2">
        <div class="col-6 col-md-6 col-lg-6">
            <h3 class="text-dark">Edit Promo</h3>
        </div>
    </div>
    <div class="card" style="background-color: #FCFCFE;">
        <div class="card-body">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form action="{{ route('editPromo') }}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" value="{{ $promo->id_promo }}" id="id_promo"
                                name="id_promo">
                            <div class="mb-3">
                                <label class="form-label">Nama Promo</label>
                                <input type="text" class="form-control @error('nama_promo') is-invalid @enderror"
                                    value="{{ old('nama_promo', $promo->nama_promo) }}" id="nama_promo" placeholder="beli 2 diskon 10%,diskon 10%" name="nama_promo">
                                @error('nama_promo')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tipe</label>
                                <select class="form-control @error('tipe') is-invalid @enderror" name="tipe"
                                    id="exampleFormControlSelect1" value="{{ old('tipe', $promo->tipe) }}">
                                    <option selected value="">Pilih Tipe</option>
                                    @if (old('tipe', $promo->tipe) == 'potongan harga')
                                        <option value="{{ old('tipe', $promo->tipe) }}" selected>{{ old('tipe', $promo->tipe) }}</option>
                                        <option value="minimal pembelian">minimal pembelian</option>
                                    @elseif(old('tipe', $promo->tipe) == 'minimal pembelian')
                                        <option value="{{ old('tipe', $promo->tipe) }}" selected>{{ old('tipe', $promo->tipe) }}</option>
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
                                 <input type="number" class="form-control @error('diskon') is-invalid @enderror"  value="{{ old('diskon', $promo->diskon) }}" id="diskon" name="diskon">
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
                                @if($promo->tipe == 'potongan harga')
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                    value="{{ old('jumlah', $promo->jumlah) }}" id="jumlah" name="jumlah" readonly>
                                @else
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                    value="{{ old('jumlah', $promo->jumlah) }}" id="jumlah" name="jumlah">
                                @endif
                                
                                @error('jumlah')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control @error('tgl_mulai') is-invalid @enderror"
                                    value="{{ old('tgl_mulai', $promo->tgl_mulai->format('Y-m-d')) }}" id="tgl_mulai" name="tgl_mulai">
                                @error('tgl_mulai')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Berakhir</label>
                                <input type="date" class="form-control @error('tgl_berakhir') is-invalid @enderror"
                                    value="{{ old('tgl_berakhir', $promo->tgl_berakhir->format('Y-m-d')) }}" id="tgl_berakhir"
                                    name="tgl_berakhir">
                                @error('tgl_berakhir')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status"
                                    id="exampleFormControlSelect1" value="{{ old('status', $promo->status) }}">
                                    <option selected value="">Pilih Status</option>
                                    @if(old('status', $promo->status) == 1)
                                        <option value="{{ old('status', $promo->status) }}" selected>Aktif</option>
                                        <option value="2">Tidak Aktif</option>
                                    @elseif(old('status', $promo->status) == 2)
                                        <option value="{{ old('tipe', $promo->status) }}" selected>Tidak Aktif</option>
                                        <option value="1">Aktif</option>
                                    @else
                                        <option value="1">Aktif</option>
                                        <option value="2">Tidak Aktif</option>
                                    @endif
                                </select>
                                @error('status')
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