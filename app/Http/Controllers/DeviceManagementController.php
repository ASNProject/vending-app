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
            'device' => 'required|string|unique:devices,device',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.limit' => 'required|integer|min:1',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $createdItems = [];
    
        foreach ($request->items as $data) {
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
    
        return new Resource(true, 'Device item limits stored successfully', $response);
    }
}
