<?php

namespace App\Providers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Order;
use App\Models\Withdrawal;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $general = gs();
        $viewShare['general'] = $general;
        // $viewShare['language'] = Language::all();
        $viewShare['emptyMessage'] = 'Data not found';
        view()->share($viewShare);


        view()->composer('admin.include.sidebar', function ($view) {
            $view->with([
                'seller'           => User::where('account_type', Status::SELLER)->count(),
                'dealer'           => User::where('account_type', Status::DEALER)->count(),
                'ram'           => User::where('account_type', Status::RAM)->count(),
                'order'           => Order::all()->count(),
                'bannedUsersCount'           => User::banned()->count(),
                'emailUnverifiedUsersCount' => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'   => User::mobileUnverified()->count(),
                'kycUnverifiedUsersCount'   => User::kycUnverified()->count(),
                'kycPendingUsersCount'   => User::kycPending()->count(),
                'pendingDepositsCount'    => Deposit::pending()->count(),
                'pendingWithdrawCount'    => Withdrawal::pending()->count(),
                'pendingTicketCount'     => SupportTicket::whereIN('status', [Status::TICKET_OPEN, Status::TICKET_REPLY])->count(),
            ]);
        });
        view()->composer('admin.dashboard', function ($view) {
            $view->with([
                'seller'           => User::where('account_type', Status::SELLER)->count(),
                'dealer'           => User::where('account_type', Status::DEALER)->count(),
                'ram'           => User::where('account_type', Status::RAM)->count(),
                'order'           => Order::all()->count(),
            ]);
        });

        view()->composer('admin.include.topbar', function ($view) {
            $view->with([
                'adminNotifications' => AdminNotification::where('is_read', Status::NO)->with('user')->orderBy('id', 'desc')->take(10)->get(),
                'adminNotificationCount' => AdminNotification::where('is_read', Status::NO)->count(),
            ]);
        });


        Paginator::useBootstrapFour();
    }
}
