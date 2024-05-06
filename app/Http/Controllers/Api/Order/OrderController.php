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


        $dealerId = User::findOrFail($seller->ref_by);

        $orderDetails = [];


        foreach ($request->products as $index => $productId) {
            $product = Product::findOrFail($productId);


            $quantity = $request->quantity[$index];

            // $totalOrderedQuantity = Order::where('product_id', $product->id)->where('status', 0)->sum('quantity');
            // $availableQuantity = $product->quantity - $totalOrderedQuantity;

            // if ($availableQuantity < $quantity) {
            //     return response()->json([
            //         'remark' => 'Order rejected',
            //         'status' => 'false',
            //         'message' => ['error' => 'Low Stock Available for Product: ' . $product->name . ', Quantity Available: ' . $availableQuantity],
            //     ]);
            // }

            $order = new Order();
            $order->shop_id = $shop->id;
            $order->seller_id = $seller->id;
            $order->dealer_id = $seller->ref_by;
            $order->ram_id = $dealerId->ref_by;
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
                    'order_id' => $order->id,
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

    public function viewOrderWithShopForDealer(Request $request, $dealerId)
    {
        $date = $request->date;

        $orders = Order::with(['product', 'shop', 'seller'])
            ->where('dealer_id', $dealerId)
            ->whereDate('created_at', $date)
            ->where('status', 0)
            ->get();

        $groupedOrders = $orders->groupBy('shop_id')->map(function ($shopOrders) {
            $totalPrice = $shopOrders->sum('price');
            $products = $shopOrders->map(function ($order) {
                return [
                    'order_id' => $order->id,
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
                'order_ids' => $shopOrders->pluck('id')->toArray(),
                'products' => $products,
            ];
        });

        $paginatedOrders = new \Illuminate\Pagination\LengthAwarePaginator(
            $groupedOrders->values()->forPage($request->page ?? 1, getPaginate()),
            $groupedOrders->count(),
            getPaginate(),
            $request->page ?? 1
        );

        return response()->json(['shops' => $paginatedOrders], 200);
    }


    public function viewOrderWithSellerForDealer(Request $request, $dealerId)
    {
        $date = $request->date;

        $orders = Order::with(['product', 'shop', 'seller'])
            ->where('dealer_id', $dealerId)
            ->whereDate('created_at', $date)
            ->where('status', 0)
            ->get();

        $groupedOrders = $orders->groupBy('shop_id')->map(function ($shopOrders) {
            return $shopOrders->groupBy('seller_id')->map(function ($sellerOrders) {
                $mergedOrders = [];
                foreach ($sellerOrders as $order) {
                    $key = $order->product_id;
                    if (!isset($mergedOrders[$key])) {
                        $mergedOrders[$key] = [
                            'order_id' => [],
                            'product_id' => $order->product_id,
                            'name' => $order->product->name,
                            'quantity' => 0,
                            'price' => $order->product->price,
                            'total_price' => 0,
                            'created_at' => null,
                            'updated_at' => null,
                        ];
                    }
                    $mergedOrders[$key]['order_id'][] = $order->id;
                    $mergedOrders[$key]['quantity'] += $order->quantity;
                    $mergedOrders[$key]['total_price'] += $order->price;
                    $mergedOrders[$key]['created_at'] = $order->created_at;
                    $mergedOrders[$key]['updated_at'] = $order->updated_at;
                }
                return [
                    'seller_id' => $sellerOrders->first()->seller_id,
                    'seller_name' => $sellerOrders->first()->seller->firstname,
                    'total_price' => $sellerOrders->sum('price'),
                    'products' => array_values($mergedOrders),
                ];
            });
        });

        $paginatedOrders = new \Illuminate\Pagination\LengthAwarePaginator(
            $groupedOrders->collapse()->values()->forPage($request->page ?? 1, getPaginate()),
            $groupedOrders->collapse()->count(),
            getPaginate(),
            $request->page ?? 1
        );

        return response()->json(['orders' => $paginatedOrders], 200);
    }



    public function viewOrderWithDealerForRam(Request $request, $ramId)
    {
        $date = $request->date;

        $orders = Order::with(['product', 'shop', 'dealer'])
            ->where('ram_id', $ramId)
            ->whereDate('created_at', $date)
            ->where('status', 0)
            ->get();

        $groupedOrders = $orders->groupBy('shop_id')->map(function ($shopOrders) {
            $totalPrice = $shopOrders->sum('price');
            $products = $shopOrders->map(function ($order) {
                return [
                    'order_id' => $order->id,
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
                'dealer_name' => $shopOrders->first()->dealer->firstname,
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

        return response()->json(['shops' => $paginatedOrders], 200);
    }

    public function viewOrderWithSellerForRam(Request $request, $ramId)
    {
        $date = $request->date;

        $orders = Order::with(['product', 'shop', 'seller'])
            ->where('ram_id', $ramId)
            ->whereDate('created_at', $date)
            ->where('status', 0)
            ->get();

        $groupedOrders = $orders->groupBy('shop_id')->map(function ($shopOrders) {
            return $shopOrders->groupBy('seller_id')->map(function ($sellerOrders) {
                $totalPrice = $sellerOrders->sum('price');
                $products = $sellerOrders->map(function ($order) {
                    return [
                        'order_id' => $order->id,
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
                    'seller_id' => $sellerOrders->first()->seller_id,
                    'seller_name' => $sellerOrders->first()->seller->firstname,
                    'total_price' => $totalPrice,
                    'products' => $products,
                ];
            });
        });

        $paginatedOrders = new \Illuminate\Pagination\LengthAwarePaginator(
            $groupedOrders->collapse()->values()->forPage($request->page ?? 1, getPaginate()),
            $groupedOrders->collapse()->count(),
            getPaginate(),
            $request->page ?? 1
        );

        return response()->json(['orders' => $paginatedOrders], 200);
    }

    public function orderEdit(Request $request, $id)
    {

        $update = Order::findOrFail($id);
        $update->quantity = $request->quantity;
        $update->price = $request->quantity * $update->product->price;
        $update->save();

        return response()->json(['success' => 'Quantity Updated!']);
    }
}
