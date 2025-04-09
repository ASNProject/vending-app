<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home()
    {
        return view('dashboard.home');
    }

    public function pendaftaran()
    {
        return view('dashboard.pendaftaran');
    }

    public function namaItem()
    {
        return view('dashboard.nama-item');
    }

    public function aturItem()
    {
        return view('dashboard.atur-item');
    }

    public function dataPengguna()
    {
        return view('dashboard.data-pengguna');
    }

    public function record()
    {
        return view('dashboard.record');
    }
}
