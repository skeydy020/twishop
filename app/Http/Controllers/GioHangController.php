<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonHang\DonHangRequest;
use Illuminate\Http\Request;
use App\Http\Services\GioHangService;
use App\Models\MaGiamGia;
use App\Models\NguoiDung_MaGiamGia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GioHangController extends Controller
{
    protected $GioHangService;

    public function __construct(GioHangService $GioHangService)
    {
        $this->GioHangService = $GioHangService;
    }

    public function index(Request $request)
    {
        $result = $this->GioHangService->create($request);
        if ($result === false) {
            return redirect()->back();
        }

        return redirect('/carts');
    }

    public function show()
    {
        $sanphams = $this->GioHangService->getSanPham();
        $thanhtoans = $this->GioHangService->getPhuongThuc();
        return view('giohang.list', [
            'title' => 'Giỏ Hàng ',
            'sanphams' => $sanphams,
            'sanphamgiohangs' => $sanphams,
            'thanhtoans' => $thanhtoans,
            'GioHang' => Session::get('GioHang')
        ]);
    }

    public function update(Request $request)
    {
        $this->GioHangService->update($request);

        return redirect('/carts');
    }

    public function remove($id = 0)
    {
        $this->GioHangService->remove($id);

        return redirect('/carts');
    }

    public function addCart(DonHangRequest $request)
    {      
       
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để thực hiện chức năng này');
        }
        $result = $this->GioHangService->taoDonHang($request);
        if ($result === false) {
            return redirect()->back();
        }
        return redirect()->back();
    }
    public function addCartHome($id = 0)
    {   
        $result = $this->GioHangService->homecreate($id);
        if ($result === false) {
            return redirect()->back();
        }
        return redirect()->back()->with('message', 'Thêm vào giỏ hàng thành công');
    }
    public function check_coupon(Request $request){
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để thực hiện chức năng này');
        }
        $tien = (String)$request->input('TongTien');
        

        $data = (String)$request->input('Code');
        $coupon = MaGiamGia::where('Code', $data)->first();
        $user = Auth::id();
        if($coupon ){
            $currentDate = now();
            if ($currentDate < $coupon->NgayBatDau) {
                return redirect()->back()->with('error', 'Mã giảm giá chưa bắt đầu hiệu lực!');
            } elseif ($currentDate > $coupon->NgayKetThuc) {
                return redirect()->back()->with('error', 'Mã giảm giá đã hết hạn!');
            }
            $ktra = NguoiDung_MaGiamGia::where('NguoiDung_id', $user) ->where('MaGiamGia_id', $coupon->id)->first();
            if ($ktra) {
                return back()->withErrors(['message' => 'Bạn đã sử dụng mã giảm giá này rồi!']);
            }
            echo $user;echo "cc"; echo $coupon->id;
            if($tien < $coupon->GiaTriToiThieu)  {
                 return redirect()->back()->with('error', 'Đơn Hàng Cần Lớn Hơn '.$coupon->GiaTriToiThieu.'đ Mới Được Giảm Giá!');
                }
            $coupon_session = Session::get('coupon');
            if($coupon_session == true){
                $is_available = 0;
                if($is_available == 0){
                    $cou[] = array(
                        'Code' => $coupon->Code,
                        'Loai' => $coupon->LoaiGiamGia,
                        'ToiDa' => $coupon->GiamGiaToiDa,
                        'GiaTriGiamGia' => $coupon->GiaTriGiamGia,
                    );
                    Session::put('coupon', $cou);
                }
            }else{
                $cou[] = array(
                    'Code' => $coupon->Code,
                    'Loai' => $coupon->LoaiGiamGia,
                    'ToiDa' => $coupon->GiamGiaToiDa,
                    'GiaTriGiamGia' => $coupon->GiaTriGiamGia,

                );
                Session::put('coupon', $cou);
            }
            Session::save();
            return redirect()->back()->with('message', 'Thêm mã giảm giá thành công');
        }else{
            return redirect()->back()->with('error', 'Mã giảm giá không đúng');
        }
    }
    public function xoamagiamgia()
    {
        $coupon = Session::get('coupon');
        if ($coupon) {

            Session::forget('coupon');
            return redirect()->back()->with('message', 'Xoá mã giảm giá thành công');
            
        }

        return redirect()->back()->with('error', 'Không có mã giảm giá');
    }
}
