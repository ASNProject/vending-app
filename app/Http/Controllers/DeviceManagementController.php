<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Item;
use App\Http\Resources\Resource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;


class DeviceManagementController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index(Request $request)
    {
        if ($request->has('device')) {
            $deviceName = $request->device;
            $devices = Device::where('device', $deviceName)->with('item')->get();
    
            if ($devices->isEmpty()) {
                return new Resource(false, 'No items found for device: ' . $deviceName, null);
            }
    
            $items = $devices->map(function ($device) {
                return [
                    'item' => $device->item,
                    'limit' => $device->limit,
                ];
            });
    
            return new Resource(true, 'Device item limits retrieved successfully', [
                'device' => $deviceName,
                'items' => $items,
            ]);
        }
    
        $grouped = Device::with('item')
            ->get()
            ->groupBy('device')
            ->map(function ($group, $deviceName) {
                return [
                    'device' => $deviceName,
                    'items' => $group->map(function ($device) {
                        return [
                            'item' => $device->item,
                            'limit' => $device->limit,
                        ];
                    })->values()
                ];
            })->values();
    
        $perPage = $request->get('per_page', 10);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginated = new LengthAwarePaginator(
            $grouped->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $grouped->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    
        return new Resource(true, 'Device item limits retrieved successfully', $paginated);
    }
    
    

    /**
     * store
     * 
     * @param mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device' => 'required|string',
            'items' => 'required|array',
            'items.*.item_id' => 'required|integer',
            'items.*.limit' => 'required|integer|min:1',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('dashboard.device')
                ->with('error', 'Terdapat kesalahan dalam pengisian form!');
        }
    
        $createdItems = [];
        $duplicates = [];
    
        foreach ($request->items as $data) {
            $existing = Device::where('device', $request->device)
                ->where('item_id', $data['item_id'])
                ->first();
    
            if ($existing) {
                $duplicates[] = $data['item_id'];
                continue; 
            }
    
            $created = Device::create([
                'device' => $request->device,
                'item_id' => $data['item_id'],
                'limit' => $data['limit'],
            ]);
    
            $createdItems[] = [
                'item' => Item::find($created->item_id),
                'limit' => $created->limit,
            ];
        }
    
        $response = [
            'device' => $request->device,
            'items' => $createdItems,
        ];
    
        if (!empty($duplicates)) {
            return redirect()->route('dashboard.device')
            ->with('error', 'Data sudah terdaftar!');
        }
    
        return redirect()->route('dashboard.device')->with('success', 'Data berhasil ditambahakan!');
    }
    /**
     * show
     * 
     * @param mixed $id
     * @return void
     */
    public function show($deviceName)
    {
        $devices = Device::where('device', $deviceName)->with('item')->get();
        if (!$devices) {
            return new Resource(false, 'Device not found', null);
        }
    
        return new Resource(true, 'Device retrieved successfully', $devices);
    }
    /**
     * update
     * 
     * @param mixed $request
     * @param mixed $id
     * @return void
     */
    public function update(Request $request, $device)
    {
        $deviceItem = Device::where('device', $device)
            ->where('item_id', $request->item_id)
            ->first();
    
        if (!$deviceItem) {
            return new Resource(false, 'Device item not found', null);
        }
    
        $deviceItem->update($request->only(['limit']));
    
        return redirect()->route('dashboard.device')->with('success', 'Data berhasil di perbarui!');
    }
    /**
     * destroy
     * 
     * @param mixed $id
     * @return void
     */
    // public function destroy($device, $itemId)
    // {
    //     $deviceItem = Device::where('device', $device)
    //         ->where('item_id', $itemId)
    //         ->first();
    
    //     if (!$deviceItem) {
    //         return new Resource(false, 'Device item not found', null);
    //     }
    
    //     $deviceItem->delete();
    
    //     return redirect()->route('dashboard.device')->with('success', 'Data berhasil dihapus!');
    // }

    public function destroy($id)
{
    $deviceItem = Device::find($id);

    if (!$deviceItem) {
        return redirect()->route('dashboard.device')->with('success', 'Data tidak ada!');
    }

    $deviceItem->delete();

    return redirect()->route('dashboard.device')->with('success', 'Data berhasil dihapus!');
}

    public function edit($id)
    {
        $userItemLimit = Device::findOrFail($id);
        return view('device.edit', compact('userItemLimit'));
    }
}
