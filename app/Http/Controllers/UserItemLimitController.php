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
            return response()->json($validator->errors(), 422);
        }

        $userItemLimit = UserItemLimit::create([
            'uid' => $request->uid,
            'name' => $request->name,
            'role' => $request->role,
            'limit' => $request->limit
        ]);

        return new Resource(true, 'User item limit created successfully', $userItemLimit);
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

        return new Resource(true, 'User item limit updated successfully', $userItemLimit);
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
        return new Resource(true, 'User item limit deleted successfully', null);
    }
}
