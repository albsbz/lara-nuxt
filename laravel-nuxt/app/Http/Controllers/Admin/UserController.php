<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request = null)

    {
        $responce = User::with('roles')->get();
        return json_encode($responce);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            // 'name' => 'required|unique:App\Models\Product',
            'name' => 'required',
            'email' => 'required',
            'address' => 'nullable',
            'phone' => 'nullable',
            'roles' => 'required'
        ]);
        Log::debug('roles: ');
        Log::debug($request);
        $user = User::find($request->id);
        if (!isset($user) && !(Auth::user()->id != $request->id)) {
            return response()->json([], 400);
        };
        // $user->update($data);
        if ($user->update($data)) {
            $user->roles()->detach();
            if (isset($request->roles)) {
                foreach ($request->roles as $role) {

                    $user->roles()->attach($role);
                }
            }
            return $this->index();
        } else {
            return response()->json([], 400);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        if (!isset($user)) {
            return response()->json([], 400);
        };
        $user->roles()->detach();
        $user->delete();
        return $this->index();
    }
}
