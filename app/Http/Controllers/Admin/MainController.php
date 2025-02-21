<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\DonHang; // Import your Order model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MainController extends Controller
{   
    public function index(){
        $user = Auth::user();

        $newUsersToday = User::whereDate('created_at', Carbon::today())->count();
        $orderedOrders = DonHang::where('TTDonHang', 'Đơn hàng đã đặt')
                                ->whereMonth('updated_at', Carbon::now()->month)
                                ->whereYear('updated_at', Carbon::now()->year)
                                ->count();
        $pendingOrders = DonHang::where('TTDonHang', '!=', 'Đã giao hàng xong')
                                ->whereMonth('updated_at', Carbon::now()->month)
                                ->whereYear('updated_at', Carbon::now()->year)
                                ->count();
        $cancelOrdersToday = DonHang::where('TTDonHang', 'Đơn hàng đã huỷ')->whereDate('updated_at', Carbon::today())->count();
        $completedOrdersToday = DonHang::where('TTDonHang', 'Đã giao hàng xong')->whereDate('updated_at', Carbon::today())->count();
        $data = [
            'newUsersToday' => $newUsersToday,
            'pendingOrders' => $pendingOrders,
            'orderedOrders' => $orderedOrders,
            'cancelOrdersToday' => $cancelOrdersToday,
            'completedOrdersToday' => $completedOrdersToday,
        ];

        // Kiểm tra nếu người dùng tồn tại và có role_id = 1
        if (($user->role_id == 1)|($user->role_id == 2)){
            return view('admin.home',[
                'title'=>'Trang quản trị Admin'
        ], $data);}
        else{
            return view('403',[
                'title'=>'Không tìm thấy trang'    
            ]);}

    }
}

