<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AccountController extends Controller
{
    public function addAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'mobile' => 'required|string|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark' => 'Validation Error',
                'status' => 'error',
                'message' => $validator->errors()->all(),
            ], 422);
        }

        $user = new User();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->mobile = $request->mobile;
        $user->account_type = $request->account_type;
        $user->password = Hash::make($request->password);
        $user->save();

        $notify[] = 'Add Successful';

        return response()->json([
            'remark' => 'Add user',
            'status' => 'ok',
            'message' => ['success' => $notify],
        ]);
    }
}
