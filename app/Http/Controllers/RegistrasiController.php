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
            "nama_user" => "required",
            "email" => "required|email:dns|unique:users",
            "username" => "required|unique:users",
            "password" => "required",
            "nomor" => "required",
            "tgl_lahir" => "required"
        ]);
        $validatedData['password'] = bcrypt($request->password);
        $validatedData['role'] ='pembeli';
        User::create($validatedData);
        return redirect()->route('viewLoginPembeli')->with('title','Berhasil');
    }
}
