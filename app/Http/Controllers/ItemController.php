<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Resources\Resource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index(){
        $items = Item::latest()->paginate(10);
        if ($items->isEmpty()) {
            return new Resource(false, 'No items found', null);
        }
        return new Resource(true, 'Items retrieved successfully', $items);
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
            'name' => 'required|unique:items,name',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            // Cek apakah ada error untuk 'uid'
            if ($errors->has('uid')) {
                return redirect()->route('dashboard.item')
                    ->with('error', 'UID sudah terdaftar!');
            }
    
            return redirect()->route('dashboard.nama-item')
                ->with('error', 'Terdapat kesalahan dalam pengisian form!');
        }

        $item = Item::create([
            'name' => $request->name
        ]);

        return redirect()->route('dashboard.item')->with('success', 'Data berhasil di ditambahakan!');
    }

    public function storeApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:items,name',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            // Cek apakah ada error untuk 'uid'
            if ($errors->has('uid')) {
                return redirect()->route('dashboard.item')
                    ->with('error', 'UID sudah terdaftar!');
            }
    
            return redirect()->route('dashboard.nama-item')
                ->with('error', 'Terdapat kesalahan dalam pengisian form!');
        }

        $item = Item::create([
            'name' => $request->name
        ]);

        return new Resource(true, 'Item created successfully', $item);
    }
    /**
     * show
     * 
     * @param mixed $id
     * @return void
     */
    public function show($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return new Resource(false, 'Item not found', null);
        }
        return new Resource(true, 'Item retrieved successfully', $item);
    }
    /**
     * update
     * 
     * @param mixed $request
     * @param mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        if (!$item) {
            return new Resource(false, 'Item not found', null);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            // Cek apakah ada error untuk 'uid'
            if ($errors->has('uid')) {
                return redirect()->route('dashboard.item')
                    ->with('error', 'UID sudah terdaftar!');
            }
    
            return redirect()->route('dashboard.item')
                ->with('error', 'Terdapat kesalahan dalam pengisian form!');
        }

        $item->update([
            'name' => $request->name
        ]);

        return redirect()->route('dashboard.item')->with('success', 'Data berhasil di ditambahakan!');
    }
    /**
     * destroy
     * 
     * @param mixed $id
     * @return void
     */
    public function destroy($id)    
    {
        $item = Item::find($id);
        if (!$item) {
            return new Resource(false, 'Item not found', null);
        }

        $item->delete();

        return redirect()->route('dashboard.item')->with('success', 'Data berhasil dihapus!');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('item.edit', compact('item'));
    }
}
