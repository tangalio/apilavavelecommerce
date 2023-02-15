<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductSizeController extends Controller
{
    public function index()
    {
        $product_size = ProductSize::all();
        return response()->json([
            'status' => 200,
            'product_size' => $product_size
        ]);
    }
    public function show($id)
    {
        $product_size = ProductSize::where('product_id', $id)->where('status', '0')->get();
        if ($product_size) {
            return response()->json([
                'status' => 200,
                'product_size' => $product_size
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'No ProductSize Available'
            ]);
        }
    }
    // public function stores(Request $request,$product_id,$size_id)
    // {
    //     $productsize = ProductSize::where('product_id', $product_id)->where('size_id', $size_id)->get('id');
    //     if ($productsize) {
    //         return response()->json([
    //             'status' => 200,
    //             'product_data' => [
    //                 'product_size' => $productsize[0]
    //             ]
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 400,
    //             'message' => 'No ProductSize Available'
    //         ]);
    //     }
    // }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|max:191,',
            'size_id' => 'required|max:191,',
            'quantity' => 'required|max:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $product_size = new ProductSize;
            $product_size->product_id = $request->input('product_id');
            $product_size->size_id = $request->input('size_id');
            $product_size->quantity = $request->input('quantity');
            $product_size->status = $request->input('status') == true ? '1' : '0';
            $product_size->save();

            return response()->json([
                'status' => 200,
                'message' => 'ProductSize Added Successfully',
            ]);
        }
    }
    public function edit($id)
    {
        $product_size = ProductSize::find($id);
        if ($product_size) {
            return response()->json([
                'status' => 200,
                'product_size' => $product_size,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No ProductSize Found',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|max:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $product_size = ProductSize::find($id);
            if ($product_size) {
                $product_size->quantity = $request->input('quantity');
                $product_size->status = $request->input('status') == true ? '1' : '0';
                $product_size->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'ProductSize Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'ProductSize Not Found',
                ]);
            }
        }
    }
    public function destroy($id)
    {
        $product_size = ProductSize::find($id);
        if ($product_size) {
            $product_size->delete();
            return response()->json([
                'status' => 200,
                'message' => 'ProductSize Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No ProductSize ID Found',
            ]);
        }
    }
}
