<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Validator;


class ShopController extends Controller
{
    public function addShop(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shop_name' => 'required|string',
            'shop_address' => 'required|string',
            'seller_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'Validation Error',
                'status' => 'error',
                'message' => $validator->errors()->all(),
            ], 422);
        }

        $shop = new Shop();

        $shop->seller_id = $request->seller_id;
        $shop->shop_name = $request->shop_name;
        $shop->shop_address = $request->shop_address;
        $shop->shop_phone = $request->shop_phone;
        $shop->save();
        $shop->shop_id = getNumber() . $shop->id;
        $shop->save();

        $notify[] = 'Add Successful';

        return response()->json([
            'remark' => 'Add Shop',
            'status' => 'ok',
            'message' => ['success' => $notify],
            'Shop ID' => $shop->shop_id
        ]);
    }

    public function viewShop($sellerId)
    {
        $shops = Shop::where('seller_id',$sellerId)->get();

        return response()->json([
            'shop' => $shops
        ], 200);
    }
    public function shopSearch(Request $request)
    {
        $query = $request->input('query');

        $results = Shop::select('shops.id', 'shops.shop_id', 'shops.shop_phone','shops.shop_address','shops.shop_name')
            ->where('shops.shop_phone', 'like', '%' . $query . '%')
            ->orWhere('shops.shop_id', 'like', '%' . $query . '%')
            ->orWhere('shops.shop_name', 'like', '%' . $query . '%')
            ->limit(10)
            ->get();

        return response()->json(['results' => $results], 200);
    }
}
