<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function adminProfile()
    {
        $pageTitle = "setting";
        $admin = Admin::where('id', auth()->guard('admin')->id)->get();
        dd($admin);
    }


    public function index()
    {
        $pageTitle = "Create Account";
        return view('admin.user_account.index', compact('pageTitle'));
    }

    public function createCode(Request $request)
    {
        $validatedData = $request->validate([
            'mobile' => 'required|unique:users|digits:11',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'ref_by' => 'nullable|string',
            'account_type' => 'required|integer',
        ]);
        $referBy = $request->ref_by;

        if ($referBy) {
            $referUser = User::where('id', $referBy)->first();
        } else {
            $referUser = null;
        }

        $exist = User::where('mobile', $request->mobile)->first();
        if ($exist) {
            $notify[] = ['error', 'The mobile number already exists'];
            return back()->withNotify($notify)->withInput();
        }

        $create = new User();

        $create->mobile = $request->mobile;
        $create->account_type = $request->account_type;
        $create->username = $request->username;
        $create->ref_by = $referUser->id ?? 0;
        $create->password = Hash::make($request['password']);

        $create->save();

        $notify[] = ['success', 'User Created Successful!'];
        return back()->withNotify($notify);
    }

    public function fetchUserData(Request $request)
    {
        $searchTerm = $request->input('q');
        $data = User::where('mobile', 'like', '%' . $searchTerm . '%')->limit(5)->get();
        return response()->json($data);
    }

    public function pageProduct()
    {
        $pageTitle = "Add Product";
        return view('admin.product.index', compact('pageTitle'));
    }

    public function listProduct()
    {
        $pageTitle = "List Product";
        $product = Product::searchable(['name', 'price'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.product.list', compact('pageTitle', 'product'));
    }
    public function editProduct($id)
    {
        $pageTitle = "Edit Product";
        $product = Product::findOrFail($id);
        return view('admin.product.edit', compact('pageTitle', 'product'));
    }

    public function updateProduct(Request $request)
    {
        $update = Product::find($request->id);

        $update->name = $request->name;
        $update->price = $request->price;
        $update->save();
        $notify[] = ['success', 'Product Updated Successful!'];

        return back()->withNotify($notify);
    }

    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $notify[] = ['error', 'Fill up Input Field Please!'];
            return back()->withNotify($notify);
        }

        $product = new Product();

        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();

        $notify[] = ['success', 'Product added Successful!'];

        return back()->withNotify($notify);
    }
}
