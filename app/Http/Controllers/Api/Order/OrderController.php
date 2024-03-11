<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function addOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shop_id' => 'required|exists:shops,id',
            'seller_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'Validation Error',
                'status' => 'error',
                'message' => $validator->errors()->all(),
            ], 422);
        }

        $product = Product::findOrFail($request->product_id);
        $seller = User::findOrFail($request->seller_id);
        $shop = Shop::findOrFail($request->shop_id);

        if (!$product || !$seller || !$shop) {
            return response()->json([
                'remark' => 'Order rejected',
                'status' => 'false',
                'message' => ['error' => 'Invalid input occurred'],
            ]);
        } else {
            $totalOrderedQuantity = Order::where('product_id', $product->id)->where('status', 0)->sum('quantity');
            $availableQuantity = $product->quantity - $totalOrderedQuantity;;

            if ($availableQuantity < $request->quantity) {
                return response()->json([
                    'remark' => 'Order rejected',
                    'status' => 'false',
                    'message' => ['error' => 'Low Stock Available Product Quantity ' . $availableQuantity],
                ]);
            }
            $order = new Order();
            $order->shop_id = $shop->id;
            $order->seller_id = $seller->id;
            $order->product_id = $product->id;
            $order->quantity = $request->quantity;
            $order->price = $product->price * $request->quantity;
            $order->save();

            return response()->json([
                'remark' => 'Order Added',
                'status' => 'ok',
                'message' => ['success' => 'Order successful'],
                'order' => $order
            ]);
        }
    }
}
