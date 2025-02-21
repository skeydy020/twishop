<?php

namespace App\Http\Controllers;

use App\Http\Services\DonHangService;
use Illuminate\Http\Request;
use App\Http\Services\GioHangService;
use App\Models\DonHang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DonHangController extends Controller
{
   
    protected $donhang;
    public function __construct(DonHangService $donhang)
    {
        $this->donhang = $donhang;
    }

    public function index()
    {
       
        return view('donhang', [
            'title' => 'Đơn Hàng ',
            
            
        ]);
    }
    public function huydon( DonHang $donhang)
    {
        if(($donhang->TTDonHang === 'Đang chờ vận chuyển')|($donhang->TTDonHang === 'Đang chờ vận chuyển')
        |($donhang->TTDonHang === 'Đã giao hàng xong')){
            return redirect()->back()->with('error','Không thể huỷ đơn hàng khi hàng đã được giao!');
        }
        if($donhang->TTDonHang === 'Đơn hàng đã huỷ'){
            return redirect()->back()->with('message','Đơn hàng đã huỷ từ trước!');
        }
        $result = $this->donhang->huydon($donhang);
        if ($result) {
            return redirect()->back()->with('message','Huỷ đơn thành công!');
        }

        return redirect()->back()->with('error','Huỷ đơn thất bại!');
    }
    
    
}
