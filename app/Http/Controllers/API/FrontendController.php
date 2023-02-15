<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Size;

class FrontendController extends Controller
{
    public function allsize()
    {
        $size = Size::where('status', '0')->get();
        return response()->json([
            'status' => 200,
            'size' => $size,
        ]);
    }
    public function category()
    {
        $category = Category::where('status', '0')->get();
        return response()->json([
            'status' => 200,
            'category' => $category
        ]);
    }
    public function searchByName($name)
    {
        $product = Product::where('name', 'like', '%' . $name . '%')->where('status', '0')->paginate(10);
        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'No Product Available'
            ]);
        }
    }
    public function idproduct($id)
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
    public function categogyproduct($id)
    {
        $product = Product::where('category_id', $id)->where('status', '0')->get();
        if ($product) {
            return response()->json([
                'status' => 200,
                'product_data' => [
                    'product' => $product
                ]
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'No Product Available'
            ]);
        }
    }
    public function product($name)
    {
        $category = Category::where('name', $name)->where('status', '0')->first();
        if ($category) {
            $product = Product::where('category_id', $category->id)->where('status', '0')->get();
            if ($product) {
                return response()->json([
                    'status' => 200,
                    'product_data' => [
                        'product' => $product,
                        'category' => $category,
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'No Product Available'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Category Found'
            ]);
        }
    }
    public function viewproduct($category_slug, $product_slug)
    {
        $category = Category::where('slug', $category_slug)->where('status', '0')->first();
        if ($category) {
            $product = Product::where('category_id', $category->id)
                ->where('slug', $product_slug)
                ->where('status', '0')
                ->first();
            if ($product) {
                return response()->json([
                    'status' => 200,
                    'product' => $product,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'No Product Available'
                ]);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Category Found'
            ]);
        }
    }
}
