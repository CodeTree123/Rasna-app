<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'Validation Error',
                'status' => 'error',
                'message' => $validator->errors()->all(),
            ], 422);
        }

        $product = new Product();

        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();

        $notify[] = 'Add Successful';

        return response()->json([
            'remark' => 'Add Product',
            'status' => 'ok',
            'message' => ['success' => $notify],
        ]);
    }

    public function viewProduct()
    {
        $products = Product::all();

        return response()->json([
            'product' => $products
        ], 200);
    }
    public function productSearch(Request $request)
    {
        $query = $request->input('query');

        $results = Product::where('products.name', 'like', '%' . $query . '%')
            ->limit(10)
            ->get();

        return response()->json(['results' => $results], 200);
    }
}
