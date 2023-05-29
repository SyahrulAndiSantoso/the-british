<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Detail_Penjualan_Online;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Kategori_Produk;
use App\Models\Ongkir;
use App\Models\Penjualan_Online;
use App\Models\User;
use App\Models\Village;

class User_Controller extends Controller
{
    public function profile()
    {
        $judul = 'Profile';
        $alamat = Alamat::where('user_id', auth()->user()->id_user)->get();
        $provinsi = Province::all();
        $kategori = Kategori_Produk::select('nama_kategori_produk')->get();

        $penjualanOnline = Penjualan_Online::select('penjualan__onlines.id_penjualan_online', 'penjualan__onlines.total', 'penjualan__onlines.sub_total', 'penjualan__onlines.tgl', 'penjualan__onlines.va_number', 'penjualan__onlines.status', 'ongkirs.service', 'ongkirs.estimasi', 'ongkirs.total_ongkir')
            ->join('ongkirs', 'penjualan__onlines.id_penjualan_online', '=', 'ongkirs.penjualan_online_id')
            ->where([
                'penjualan__onlines.user_id' => auth()->user()->id_user,
            ])
            ->where('penjualan__onlines.status', '!=', 2)
            ->latest('penjualan__onlines.id_penjualan_online')
            ->get();
            
            $detailPenjualanOnline = Detail_Penjualan_Online::select('penjualan__onlines.id_penjualan_online', 'detail__penjualan__onlines.diskon', 'detail__penjualan__onlines.status', 'produks.nama_produk', 'produks.thumbnail', 'produks.harga', 'produks.merk')
            ->join('produks', 'detail__penjualan__onlines.produk_id', '=', 'produks.id_produk')
            ->join('penjualan__onlines', 'detail__penjualan__onlines.penjualan_online_id', '=', 'penjualan__onlines.id_penjualan_online')
            ->where('penjualan__onlines.user_id', auth()->user()->id_user)
            ->where('penjualan__onlines.status', '!=', 2)
            ->latest('penjualan__onlines.id_penjualan_online')
            ->get();
      

        $diskon = detail_penjualan_online::select('detail__penjualan__onlines.diskon', 'penjualan__onlines.id_penjualan_online')
            ->join('penjualan__onlines', 'detail__penjualan__onlines.penjualan_online_id', '=', 'penjualan__onlines.id_penjualan_online')
            ->where([
                'detail__penjualan__onlines.status' => 1,
                'penjualan__onlines.user_id' => auth()->user()->id_user,
            ])
            ->where('penjualan__onlines.status', '!=', 2)
            ->where('detail__penjualan__onlines.diskon', '>', 0)
            ->groupBy('detail__penjualan__onlines.diskon')
            ->latest('penjualan__onlines.id_penjualan_online')
            ->get();

        $judul = 'Invoice Transaksi';

        return view('pembeli.profile', compact('judul', 'alamat', 'provinsi', 'kategori', 'penjualanOnline', 'detailPenjualanOnline', 'diskon'));
    }

    public function data_kabupaten(Request $request, Alamat $alamat)
    {
        $id_provinsi = $request->idProvinsi;
        $kabupaten = Regency::where('province_id', $id_provinsi)->get();
        echo '<option select value="">Pilih Kabupaten</option>';
        foreach ($kabupaten as $data) {
            echo "<option value='$data->id'>$data->name</option>";
        }
    }

    public function data_kecamatan(Request $request)
    {
        $id_kabupaten = $request->idKabupaten;
        $kecamatan = District::where('regency_id', $id_kabupaten)->get();
        echo '<option select value="">Pilih Kecamatan</option>';
        foreach ($kecamatan as $data) {
            echo "<option value='$data->id'>$data->name</option>";
        }
    }

    public function data_kelurahan(Request $request)
    {
        $id_kecamatan = $request->idKecamatan;
        $kelurahan = Village::where('district_id', $id_kecamatan)->get();
        echo '<option select value="">Pilih Kelurahan</option>';
        foreach ($kelurahan as $data) {
            echo "<option value='$data->id'>$data->name</option>";
        }
    }

    public function proses_store_alamat(Request $request)
    {
        $validatedData = $request->validate([
            'keterangan' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'alamat_detail' => 'required',
        ]);
        $dataProvinsi = Province::where('id', $request->provinsi)->first();
        $dataKabupaten = Regency::where('id', $request->kabupaten)->first();
        $dataKecamatan = District::where('id', $request->kecamatan)->first();
        $dataKelurahan = Village::where('id', $request->kelurahan)->first();
        $validatedData['provinsi'] = $dataProvinsi->name;
        $validatedData['kabupaten'] = $dataKabupaten->name;
        $validatedData['kecamatan'] = $dataKecamatan->name;
        $validatedData['kelurahan'] = $dataKelurahan->name;
        $validatedData['user_id'] = auth()->user()->id_user;
        Alamat::create($validatedData);
        return redirect()
            ->route('profile')
            ->with([
                'aksi' => 'Menambahkan',
                'halaman' => 'Alamat',
            ]);
    }

    public function proses_hapus_alamat(Alamat $alamat)
    {
        $data = Alamat::find($alamat->id_alamat);
        $data->delete($alamat->id_alamat);
        return redirect()
            ->route('profile')
            ->with([
                'aksi' => 'Menghapus',
                'halaman' => 'Alamat',
            ]);
    }

    public function view_edit_alamat(Alamat $alamat)
    {
        $data = Alamat::where('id_alamat', $alamat->id_alamat)->first();
        $provinsi = Province::all();
        $dataProvinsi = Province::where('name', $alamat->provinsi)->first();
        $kabupaten = Regency::where('province_id', $dataProvinsi->id)->get();
        $dataKabupaten = Regency::where('name', $alamat->kabupaten)->first();
        $kecamatan = District::where('regency_id', $dataKabupaten->id)->get();
        $dataKecamatan = District::where([
            'regency_id' => $dataKabupaten->id,
            'name' => $alamat->kecamatan,
        ])->first();
        $kelurahan = Village::where('district_id', $dataKecamatan->id)->get();
        $judul = 'Edit Alamat';
        $kategori = Kategori_Produk::select('nama_kategori_produk')->get();
        return view('pembeli.edit.edit_Alamat', compact('data', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'judul', 'kategori'));
    }

    public function proses_edit_alamat(Request $request)
    {
        $data = Alamat::where('id_alamat', $request->id_alamat)->first();
        $validatedData = $request->validate([
            'keterangan' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'alamat_detail' => 'required',
        ]);
        $dataProvinsi = Province::where('id', $request->provinsi)->first();
        $dataKabupaten = Regency::where('id', $request->kabupaten)->first();
        $dataKecamatan = District::where('id', $request->kecamatan)->first();
        $dataKelurahan = Village::where('id', $request->kelurahan)->first();
        $validatedData['provinsi'] = $dataProvinsi->name;
        $validatedData['kabupaten'] = $dataKabupaten->name;
        $validatedData['kecamatan'] = $dataKecamatan->name;
        $validatedData['kelurahan'] = $dataKelurahan->name;
        $validatedData['user_id'] = auth()->user()->id_user;
        $data->update($validatedData);
        return redirect()
            ->route('profile')
            ->with([
                'aksi' => 'Mengupdate',
                'halaman' => 'Alamat',
            ]);
    }

    public function proses_Edit_Profile(Request $request)
    {
        $data = User::find(auth()->user()->id_user);
        $rules = [
            'nama_user' => 'required',
            'nomor' => 'required',
            'tgl_lahir' => 'required',
        ];
        $rules['role'] = 'pembeli';

        if ($request->email != auth()->user()->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }
        if ($request->username != auth()->user()->username) {
            $rules['username'] = 'required|unique:users';
        }
        $validatedData = $request->validate($rules);
        if ($request->password) {
            $validatedData['password'] = bcrypt($request->password);
        }
        $data->update($validatedData);
        return redirect()
            ->route('profile')
            ->with([
                'aksi' => 'Mengupdate',
                'halaman' => 'Profile',
            ]);
    }

    public function view_Edit_Profile()
    {
        $judul = 'Edit Profile';
        $kategori = Kategori_Produk::select('nama_kategori_produk')->get();
        return view('pembeli.edit.edit_Profile', compact('judul', 'kategori'));
    }
}
