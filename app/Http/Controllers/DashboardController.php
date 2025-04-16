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
        $userItemLimits = UserItemLimit::simplePaginate(5);
        return view('dashboard.userdata', compact('userItemLimits'));
    }

    public function items()
    {
        $items = Item::simplePaginate(5);
        return view('dashboard.item', compact('items'));
    }

    public function device()
    {
        $devices = Device::with('item')->simplePaginate(5);
        $allItems = Item::all();
        return view('dashboard.device', compact('devices', 'allItems'));
    }

    public function record()
    {
        $records = Vending::with(['user', 'item'])->simplePaginate(10);
        return view('dashboard.record', compact('records'));
    }
}
