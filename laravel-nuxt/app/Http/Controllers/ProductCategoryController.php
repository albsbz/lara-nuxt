<?php

namespace App\Http\Controllers;

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
        $responce = ProductCategory::with('parent')->get();
        return json_encode($responce);
    }
}
