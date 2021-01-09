<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductFeature;
use App\Http\Controllers\Controller;

class ProductFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request = null)

    {
        $responce = ProductFeature::all();
        return json_encode($responce);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:App\Models\ProductFeature,name',
        ]);
        ProductFeature::create($data);
        return $this->index();
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
            'name' => 'required|unique:App\Models\ProductFeature,name,' . $request->id
        ]);

        $feature = ProductFeature::find($request->id);
        if (!isset($feature)) {
            return response()->json([], 400);
        };

        if ($feature->update($data)) {
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
        $feature = ProductFeature::find($request->id);
        if (!isset($feature)) {
            return response()->json([], 400);
        };
        $feature->delete();
        return $this->index();
    }
}
