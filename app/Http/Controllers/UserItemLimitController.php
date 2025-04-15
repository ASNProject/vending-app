<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserItemLimit;
use App\Http\Resources\Resource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class UserItemLimitController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index()
    {
        $userItemLimits = UserItemLimit::latest()->paginate(10);
        if ($userItemLimits->isEmpty()) {
            return new Resource(false, 'No user item limits found', null);
        }
        return new Resource(true, 'User item limits retrieved successfully', $userItemLimits);
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
            'uid'=> 'required|unique:user_item_limits,uid',
            'name' => 'required|unique:user_item_limits,name',
            'role' => 'required',
            'limit' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            // Cek apakah ada error untuk 'uid'
            if ($errors->has('uid')) {
                return redirect()->route('dashboard.userdata')
                    ->with('error', 'UID sudah terdaftar!');
            }
    
            return redirect()->route('dashboard.userdata')
                ->with('error', 'Terdapat kesalahan dalam pengisian form!');
        }

        $userItemLimit = UserItemLimit::create([
            'uid' => $request->uid,
            'name' => $request->name,
            'role' => $request->role,
            'limit' => $request->limit
        ]);

        return redirect()->route('dashboard.userdata')->with('success', 'Data berhasil di ditambahakan!');
    }
    /**
     * show
     * 
     * @param mixed $id
     * @return void
     */
    public function show($id)
    {
        $userItemLimit = UserItemLimit::find($id);
        if (!$userItemLimit) {
            return new Resource(false, 'User item limit not found', null);
        }
        return new Resource(true, 'User item limit retrieved successfully', $userItemLimit);
    }
    /**
     * update
     * 
     * @param mixed $request
     * @param mixed $id
     * @return void
     */
    public function update(Request $request, $uid)
    {
        $userItemLimit = UserItemLimit::where('uid', $uid)->first();
        if (!$userItemLimit) {
            return new Resource(false, 'User item limit not found', null);
        }

        $userItemLimit->update($request->only(['uid', 'name', 'role', 'limit']));

        return redirect()->route('dashboard.userdata')->with('success', 'Data dari '. $uid .' berhasil di perbarui!');
    }  
    /**
     * destroy
     * 
     * @param mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $userItemLimit = UserItemLimit::find($id);
        if (!$userItemLimit) {
            return new Resource(false, 'User item limit not found', null);
        }

        $userItemLimit->delete();
        return redirect()->route('dashboard.userdata')->with('success', 'Data berhasil di dihapus!');
    }

    public function edit($id)
    {
        $userItemLimit = UserItemLimit::findOrFail($id);
        return view('user-item-limits.edit', compact('userItemLimit'));
    }
    
}
