<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class RegistrasiController extends Controller
{
    public function index(){
        $judul = 'Registrasi';
        return view('pembeli.registrasi', compact('judul'));
    }

    public function proses_Store(Request $request){
        $validatedData = $request->validate([
            "nama_user" => "required|min:3",
            "email" => "required|email:dns|unique:users|min:6",
            "username" => "required|unique:users|min:3",
            "password" => "required|min:5",
            "nomor" => "required|min:11",
            "tgl_lahir" => "required"
        ]);
        $validatedData['password'] = bcrypt($request->password);
        $validatedData['role'] ='pembeli';
        User::create($validatedData);
        return redirect()->route('viewLoginPembeli')->with('title','Berhasil');
    }
}
