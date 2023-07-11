<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;

class productsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::all();
        if($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'stock'=>'required|integer',
        ]);

        $data = new Product();
        $data->name = $request->name;
        $data->price = $request->price;
        $data->stock = $request->stock;
        $data->save();
    
        if($data) {
            return ApiFormatter::createApi(200, 'success upload data products', $data);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Product::find($id);
        if (!$data) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return ApiFormatter::createApi(200, 'Success Found Detail Products', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'stock'=>'required|integer',
        ]);

        $data = Product::findOrFail($id);
        $data->update($request->all());

        if($data) {
            return ApiFormatter::createApi(200, 'success update data products', $data);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Product::find($id);

        if (!$data) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $data->delete();

        return ApiFormatter::createApi(200, 'Success Deleted Product', $data);
    }
}
