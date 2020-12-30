<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request = null)

    {
        if (isset($request->perpage)) {
            $responce = ProductCategory::with('parent')->paginate($request->perpage);
        } else {
            $responce = ProductCategory::with('parent')->get();
        }
        return json_encode($responce);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required',
            'description' => 'required',
            'slug' => 'required|unique:App\Models\ProductCategory',
            'parent_id' => 'required'

        ]);
        ProductCategory::create($data);

        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'name' => 'required',
            'description' => 'required',
            // 'slug' => 'required|unique:App\Models\ProductCategory',
            'slug' => 'required',
            'parent_id' => 'required'

        ]);

        $category = ProductCategory::find($request->id);
        if (!isset($category)) {
            return response()->json([], 400);
        };
        // $category->update($data);
        $category->name = $data['name'];
        $category->parent_id = $data['parent_id'];
        $category->description = $data["description"];
        $category->slug = $data['slug'];

        if ($category->save()) {
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

        $category = ProductCategory::find($request->id);
        if (!isset($category)) {
            return response()->json([], 400);
        };
        $category->delete();
        return $this->index();
    }
}
