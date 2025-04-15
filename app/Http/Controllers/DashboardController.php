<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\UserItemLimit;
use App\Models\Item;
use App\Models\Vending;

class DashboardController extends Controller
{
    public function home(Request $request)
    {
        $devices = Device::with('item')->simplePaginate(10);
        return view('dashboard.home', compact('devices'));
    }

    public function userdata()
    {
        $userItemLimits = UserItemLimit::simplePaginate(10);
        return view('dashboard.userdata', compact('userItemLimits'));
    }

    public function namaItem()
    {
        $items = Item::simplePaginate(10);
        return view('dashboard.nama-item', compact('items'));
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
