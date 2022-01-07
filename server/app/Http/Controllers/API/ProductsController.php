<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $products = Products::all();
        return response()->json(['status'=>200, 'products'=>$products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Products();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->quantity = $request->input('quantity');
        $product->price = $request->input('price');
        $product->status = $request->input('status');
        $product->save();

        return response()->json(['status' => 200, 'message' => 'Product successfully added.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus($id)
    {
        $product = Products::find($id);
        $status = $product->status;
        if($status == 'enabled') {
            $product->status = 'disabled';
        }
        else if ($status == 'disabled') {
            $product->status = 'enabled';
        }
        $product->save();
        return response()->json(['status' => 200, 'message'=> 'Status successfully updated.']);
    }
    public function edit(Request $request, $id)
    {
        $product = Products::find($id);
        if($product) {
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->quantity = $request->input('quantity');
            $product->price = $request->input('price');
            $product->save();
            return response()->json(['status' => 200, 'message'=>'Product successfully updated.']);
        } else {
            return response()->json(['status' => 404, 'message'=>'Product not found.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::find($id);
        $product->delete();

        return response()->json(['status' => 200, 'message' => 'Product successfully deleted.']);
    }
}
