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
        $shop->save();
        $shop->shop_id = getNumber() . $shop->id;
        $shop->save();

        $notify[] = 'Add Successful';

        return response()->json([
            'remark' => 'Add Shop',
            'status' => 'ok',
            'message' => ['success' => $notify],
        ]);
    }

    public function viewShop()
    {
        $shops = Shop::paginate(getPaginate());

        $notify[] = 'Shop List';
        return response()->json([
            'product' => $shops,
            'remark' => 'View Shop',
            'status' => 'ok',
            'message' => ['success' => $notify],
        ], 200);
    }
}
