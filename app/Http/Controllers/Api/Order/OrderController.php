<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function addOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shop_id' => 'required|exists:shops,id',
            'seller_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric|min:1',
            'products.*' => 'required|exists:products,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'remark' => 'Validation Error',
                'status' => 'error',
                'message' => $validator->errors()->all(),
            ], 422);
        }
    
        $shop = Shop::findOrFail($request->shop_id);
        $seller = User::findOrFail($request->seller_id);
    
        $orderDetails = [];
    

        foreach ($request->products as $index => $productId) {
            $product = Product::findOrFail($productId);
    
  
            $quantity = $request->quantity[$index];
    
            $totalOrderedQuantity = Order::where('product_id', $product->id)->where('status', 0)->sum('quantity');
            $availableQuantity = $product->quantity - $totalOrderedQuantity;
    
            if ($availableQuantity < $quantity) {
                return response()->json([
                    'remark' => 'Order rejected',
                    'status' => 'false',
                    'message' => ['error' => 'Low Stock Available for Product: ' . $product->name . ', Quantity Available: ' . $availableQuantity],
                ]);
            }
    
            $order = new Order();
            $order->shop_id = $shop->id;
            $order->seller_id = $seller->id;
            $order->product_id = $product->id;
            $order->quantity = $quantity;
            $order->price = $product->price * $quantity;
            $order->save();
    
            $orderDetails[] = $order;
        }
    
        return response()->json([
            'remark' => 'Order Added',
            'status' => 'ok',
            'message' => ['success' => 'Order successful'],
            'orders' => $orderDetails
        ]);
    }
    
    public function viewOrder(Request $request, $sellerId)
    {
        $date = $request->date;
    
        $orders = Order::with(['product', 'shop'])
            ->where('seller_id', $sellerId)
            ->whereDate('created_at', $date)
            ->where('status', 0)
            ->get();
    
        $groupedOrders = $orders->groupBy('shop_id')->map(function ($shopOrders) {
            $totalPrice = $shopOrders->sum('price');
            $products = $shopOrders->map(function ($order) {
                return [
                    'id' => $order->product_id,
                    'product_id' => $order->product_id,
                    'name' => $order->product->name,
                    'quantity' => $order->quantity,
                    'price' => $order->product->price,
                    'total_price' => $order->price,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                ];
            });
            return [
                'shop_name' => $shopOrders->first()->shop->shop_name,
                'total_price' => $totalPrice,
                'products' => $products,
            ];
        });
    
        $paginatedOrders = new \Illuminate\Pagination\LengthAwarePaginator(
            $groupedOrders->values()->forPage($request->page ?? 1, getPaginate()),
            $groupedOrders->count(),
            getPaginate(),
            $request->page ?? 1
        );
    
        return response()->json(['orders' => $paginatedOrders], 200);
    }
    



}
