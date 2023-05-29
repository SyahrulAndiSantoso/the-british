<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class LoginController extends Controller
{
    public function view_Login_Pembeli()
    {
        $judul = 'Login';
        return view('pembeli.login', compact('judul'));
    }

    public function view_Login_Admin()
    {
        $judul = 'Masuk Admin';
        return view('admin.login_admin', compact('judul'));
    }

    public function view_Login_Kasir()
    {
        $judul = 'Masuk Kasir';
        return view('kasir.login_kasir', compact('judul'));
    }

    public function view_Login_Owner()
    {
        $judul = 'Masuk Admin';
        return view('owner.login_owner', compact('judul'));
    }

    public function authenticate_admin(Request $request)
    {
        $credential = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

            if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'role' => 'admin'])) {
                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()
                    ->back()
                    ->with('title', 'Gagal');
            }
    }

    public function authenticate_owner(Request $request)
    {
        $credential = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

            if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'role' => 'owner'])) {
                $request->session()->regenerate();
                return redirect()->intended('/owner/dashboard');
            } else {
                return redirect()
                    ->route('login-owner')
                    ->with('title', 'Gagal');
            }
    }

    public function authenticate_kasir(Request $request)
    {
        $credential = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

            if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'role' => 'kasir'])) {
                $request->session()->regenerate();
                return redirect()->intended('/kasir/dashboard');
            } else {
                return redirect()
                    ->back()
                    ->with('title', 'Gagal');
            }
    }

    public function authenticate_Pembeli(Request $request)
    {
        $credential = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'role' => 'pembeli'])) {
            $request->session()->regenerate();
            return redirect()
                ->intended('/beranda');
        } else {
            return redirect()
                ->back()
                ->with('title', 'Gagal');
        }
    }

    public function logout(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Session::flush();
            return redirect()->route('login-admin');
        } elseif (auth()->user()->role === 'kasir') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Session::flush();
            return redirect()->route('login-kasir');
        } elseif (auth()->user()->role === 'owner') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Session::flush();
            return redirect()->route('login-owner');
        }elseif(auth()->user()->role === 'pembeli'){
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Session::flush();
            return redirect()->route('viewLoginPembeli');
        }
    }
}
