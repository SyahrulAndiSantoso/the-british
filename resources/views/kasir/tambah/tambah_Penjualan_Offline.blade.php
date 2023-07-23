@extends('layout.main_kasir')
@section('konten')
    @if (session()->has('aksi'))
        <div class="flash-data" data-title="Berhasil" data-aksi="{{ session('aksi') }}" data-halaman="{{ session('halaman') }}">
        </div>
    @endif
    @if (session()->has('title'))
        <div class="flash-data" data-aksi='Checkout' data-halaman='Penjualan Offline' data-title='{{ session('title') }}'>
        </div>
    @endif
    <div class="card" style="background-color: #FCFCFE;">
        <div class="card-body">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                Produk
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-8 mb-3">
                                    <div class="card bg-white shadow p-3 rounded-3 border-0">
                                    <video id="video" autoplay></video>
                                    </div>
                                    </div>
                                    <div class="col-md-8 mb-4">
                                        <div class="form-group">
                                            <form action="{{ route('viewTambahPenjualanOffline') }}" method="GET">
                                                <div class="input-group mb-3">
                                                    <input type="text" id="search" placeholder="kode produk" name="search" value="{{ request('search') }}"
                                                        class="form-control" aria-describedby="button-addon2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-maroon" type="submit"
                                                            id="button-addon2">Cari</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    @isset($produk)
                                    @if ($produk->count() != 0)
                                        @foreach ($produk as $row)
                                            @if ($row->stok == 0)
                                                <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4 mb-4">
                                                    <div class="justify-content-center text-danger"><b><center>Stok Produk Habis
                                                            !!</center></b></div>
                                                </div>
                                            @else
                                                <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3 mb-4">
                                                    <a class="text-decoration-none"
                                                        href="{{ route('tambahPenjualanOffline', $row->id_produk) }}">
                                                        <div class="card card-produk">
                                                            <img src="{{ asset('storage/' . "$row->thumbnail") }}"
                                                                class="card-img-top produk" alt="..." />
                                                            <div class="card-body">
                                                                <p class="card-title text-dark">{{ $row->nama_produk }}</p>
                                                                <h6 class="text-dark">
                                                                    Rp {{ number_format($row->harga, 0, ',', '.') }}</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    @elseif($produk->count() == 0)
                                        <div class="justify-content-center text-danger"><b>Produk Tidak Ditemukan !!</b>
                                        </div>
                                    @else
                                    @endif
                                    @endisset
                                </div>
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
                                Keranjang
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" width="100%" data-page-length="10"
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
        @if (isset($penjualanOffline)&&$penjualanOffline->total>0)
            <div class="card-body">
                <div class="section-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    Chekcout
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('checkoutPenjualanOffline') }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <label for="exampleInputPassword1">Total</label>
                                            <input type="text" value="{{ number_format($penjualanOffline->total, 0, ',', '.') }}" id="total"
                                                name="total" class="form-control" id="exampleInputPassword1"
                                                placeholder="Password" readonly>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="exampleInputPassword1">Bayar</label>
                                            <input type="text" value="{{ number_format($penjualanOffline->total, 0, ',', '.') }}" name="bayar"
                                                class="form-control" id="exampleInputPassword1" placeholder="Password"
                                                readonly>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="exampleInputPassword1">Diterima</label>
                                            <input type="text" id="diterima" name="diterima"
                                                class="form-control @error('diterima') is-invalid @enderror"
                                                id="exampleInputPassword1">
                                            @error('diterima')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="exampleInputPassword1">Kembalian</label>
                                            <input type="text" name="kembalian" id="kembalian" class="form-control"
                                                id="exampleInputPassword1" readonly>
                                        </div>
                                        <button type="submit" class="btn btn-maroon">Simpan Penjualan Offline</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection

@section('yajra-default')
    <script>
          // Memulai pemindaian barcode
    //   function startScanning() {
    //     onScan.attachTo(document, {
    //       video: "#video",
    //       scanButtonKeyCode: false, // tombol Enter
    //       onScan: function(barcode) {
    //         alert(barcode);
    //       }
    //     });
    //   }

navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
      .then(function(stream) {
        var video = document.getElementById('video');
        // Memainkan stream kamera belakang ke elemen video
        video.srcObject = stream;

            // Menginisialisasi Quagga.js untuk pemindaian barcode QR
        Quagga.init({
          inputStream: {
            name: "Live",
            type: "LiveStream",
            target: video
          },
          decoder: {
            readers: ["code_128_reader"]
          }
        }, function(err) {
          if (err) {
            alert(err);
            return;
          }
          Quagga.start();

          Quagga.onDetected(function(result) {
            var code = result.codeResult.code;
            let url =`{{ url('/kasir/penjualan-offline/store?search=${code}') }}`;
            window.location.href=url;

            // Berhenti pemindaian setelah berhasil mendeteksi barcode QR
            Quagga.stop();
          });
        });

      })
      .catch(function(error) {
        alert("Heh Error: " + error);
      });

        document.addEventListener("DOMContentLoaded", function(){
             // Mengakses kamera belakang
    //  function startCamera() {
    //     Quagga.init({
    //       inputStream: {
    //         name: "Live",
    //         type: "LiveStream",
    //         target: video,
    //         constraints: {
    //           facingMode: "environment" // Menggunakan kamera belakang
    //         }
    //       },
    //       decoder: {
    //         readers: ["qrcode_reader"] // Menentukan jenis barcode yang akan dipindai, misalnya EAN
    //       }
    //     }, function(err) {
    //       if (err) {
    //         alert("Gagal mengakses kamera:", err);
    //         return;
    //       }
    //       Quagga.start();
    //     });

    //     Quagga.onDetected(function(result) {
    //       alert(result.codeResult.code);
    //     });
    //   }

       // Memulai aplikasi
    //    startCamera();

        })

    //     scanner.addListener('scan', function(e){
    //         console.log(e);
    //         let url =`{{ url('/kasir/penjualan-offline/store?search=${e}') }}`;
    //         window.location.href=url;
    //     })


        $(document).ready(function() {

           

    //   // Mengakses kamera belakang
    //   function startCamera() {
    //     Instascan.Camera.getCameras()
    //       .then(function(cameras) {
    //         if (cameras.length > 0) {
    //           const selectedCamera = cameras.find(camera => camera.name.toLowerCase().includes('back'));
    //           const scanner = new Instascan.Scanner({ video: video });
    //           scanner.start(selectedCamera);
    //           scanner.addListener('scan', function(barcode) {
    //            alert(barcode);
    //           });
    //         } else {
    //           alert("Tidak ada kamera yang tersedia.");
    //         }
    //       })
    //       .catch(function(error) {
    //         alert("Gagal mengakses kamera:", error);
    //       });
    //   }


    


         // Memulai pemindaian barcode
    //      function startScanning() {
    //     onScan.attachTo(document, {
    //       video: "#video",
    //       scanButtonKeyCode: false, // Tidak perlu menekan tombol untuk memproses barcode
    //       onScan: function(barcode) {
    //         alert(barcode);
    //       }
    //     });
    //   }

      

            $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dataTambahPenjualanOfflineKasir') }}',
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
                    data: 'nama_merk',
                    name: 'nama_merk'
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
                    data: 'aksi',
                    name: 'aksi'
                }]
            });
        });
    </script>
@endsection

@section('jsCheckout')
    <script>
        const diterima = document.querySelector('form #diterima');
        const total = document.querySelector('form #total');
        const kembalian = document.querySelector('form #kembalian');
        diterima.addEventListener('keyup', function() {
            let inputElement = diterima.value;
            inputElement = inputElement.replace(/\D/g, '');
            diterima.value = new Intl.NumberFormat('en-US').format(inputElement);
            
            let dataDiterima = diterima.value;
            let dataTotal = total.value;
            dataDiterima =dataDiterima.replace(/[,|.]/g, '');
            dataTotal = dataTotal.replace(/[,|.]/g, '');
            
            kembalian.value = new Intl.NumberFormat('en-US').format(dataDiterima - dataTotal);
        })
    </script>
@endsection
