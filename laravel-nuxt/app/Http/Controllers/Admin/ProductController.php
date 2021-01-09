<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use function Symfony\Component\String\b;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request = null)

    {
        $responce = Product::with('images', 'category', 'features')->get();
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
            // 'name' => 'required|unique:App\Models\Product',
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'price' => 'required',
            'slug' => 'unique:App\Models\Product,slug',
            'instock' => 'required',
            'images.*' => 'nullable|file|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'features' => 'nullable',
            'featureValues' => 'nullable',
        ]);
        Log::debug($data);
        $product = Product::create($data);
        if (isset($data['images'])) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images');

                $newImage = Image::create(['url' => '/storage/images/' . basename($path)]);
                $product->images()->attach($newImage->id);
            }
        }

        if (isset($data['features'])) {
            foreach ($data['features'] as  $key => $feature) {
                if (isset($data['featureValues'][$key])) {
                    $product->features()->attach($feature, ['value' => $data['featureValues'][$key]]);
                }
            }
        }


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
            // 'name' => 'required|unique:App\Models\Product',
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'price' => 'required',
            'slug' => 'unique:App\Models\Product,slug,' . $request->id,
            'instock' => 'required',
            'newImages.*' => 'nullable|file|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'images' => 'nullable',
            'features' => 'nullable',
            'featureValues' => 'nullable',
            'imagesSequence' => 'nullable',
        ]);
        Log::debug($data);
        $product = Product::find($request->id);
        if (!isset($product)) {
            return response()->json([], 400);
        };
        //images['url', 'file'], imagesSequence['id']
        if ($product->update($data)) {
            if (isset($data['images'])) {
                foreach ($product->images as $image) {
                    if (in_array($image->url, $request->images)) {
                        $order = array_search($image->id, $request->imagesSequence);
                        $image->pivot->order = $order;
                    } else {
                        $image->delete();
                        $path = storage_path('app/public/images/' . basename($image->url));
                        if (file_exists($path)) {
                            unlink($path);
                        }
                    }
                }
                foreach ($request->file('newImages') as $key => $image) {
                    $path = $image->store('public/images');
                    $newImage = Image::create(['url' => '/storage/images/' . basename($path)]);
                    $product->images()->attach($newImage->id,  ['order' => array_keys($request->imagesSequence, null)[$key]]);
                }
            }
            // $product->features()->detach()->delete();
            // if (isset($data['features'])) {

            //     foreach ($data['features'] as  $feature) {
            //         if (isset($data['featureValues'][$feature])) {
            //             $product->features()->attach($feature, ['value' => $data['featureValues'][$feature]]);
            //         }
            //     }
            // }
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
        $product = Product::find($request->id);
        if (!isset($product)) {
            return response()->json([], 400);
        };
        foreach ($product->images as $image) {
            $path = storage_path('app/public/images/' . basename($image->url));
            if (file_exists($path)) {
                unlink($path);
            }
            $product->images()->get()->each(function ($child) {
                $child->delete();
            });
        }

        $product->delete();

        return $this->index();
    }
}
