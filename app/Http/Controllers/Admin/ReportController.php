<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Constants\Status;

class ReportController extends Controller
{
    public function index()
    {
        $pageTitle = "Seller List";
        $report = User::where('account_type', Status::SELLER)->searchable(['mobile'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.report.index', compact('pageTitle', 'report'));
    }

    public function sellerReport($id)
    {
        $pageTitle = "Seller order Details";
        $currentDayPrice = User::find($id)
            ->orders()
            ->whereDate('created_at', today())
            ->sum('price');

        $currentDayOrders = User::find($id)
            ->orders()
            ->whereDate('created_at', today())
            ->count();

        // Total price and total orders for the current month
        $currentMonthPrice = User::find($id)
            ->orders()
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('price');

        $currentMonthOrders = User::find($id)
            ->orders()
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        // Total price and total orders for the current year
        $currentYearPrice = User::find($id)
            ->orders()
            ->whereYear('created_at', now()->year)
            ->sum('price');

        $currentYearOrders = User::find($id)
            ->orders()
            ->whereYear('created_at', now()->year)
            ->count();

        // Pass the variables to the view
        return view('admin.report.view', compact(
            'currentDayPrice',
            'currentDayOrders',
            'currentMonthPrice',
            'currentMonthOrders',
            'currentYearPrice',
            'currentYearOrders'
        ));
    }
}
