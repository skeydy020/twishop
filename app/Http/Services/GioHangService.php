<?php


namespace App\Http\Services;


use App\Jobs\SendMail;
use App\Models\Cart;
use App\Models\ChiTietDonHang;
use App\Models\DonHang;
use App\Models\MaGiamGia;
use App\Models\NguoiDung_MaGiamGia;
use App\Models\PTThanhToan;
use App\Models\SanPham;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

use function PHPUnit\Framework\isNull;

class GioHangService
{
    public function create($request)
    {
        $SoLuong = (int)$request->input('SoLuong');
        $sanpham_id = (int)$request->input('sanpham_id');

        if ($SoLuong <= 0 || $sanpham_id <= 0) {
            Session::flash('error', 'Số lượng hoặc Sản phẩm không chính xác');
            return false;
        }

        $GioHang = Session::get('GioHang');
        if (is_null($GioHang)) {
            Session::put('GioHang', [
                $sanpham_id => $SoLuong
            ]);
            return true;
        }

        $exists = Arr::exists($GioHang, $sanpham_id);
        if ($exists) {
            $GioHang[$sanpham_id] = $GioHang[$sanpham_id] + $SoLuong;
            Session::put('GioHang', $GioHang);
            return true;
        }

        $GioHang[$sanpham_id] = $SoLuong;
        Session::put('GioHang', $GioHang);

        return true;
    }
    public function homecreate($id)
    {
        $SoLuong = 1;
        $sanpham_id = $id;

        if ($sanpham_id <= 0) {
            Session::flash('error', 'Sản phẩm không chính xác');
            return false;
        }

        $GioHang = Session::get('GioHang');
        if (is_null($GioHang)) {
            Session::put('GioHang', [
                $sanpham_id => $SoLuong
            ]);
            return true;
        }

        $exists = Arr::exists($GioHang, $sanpham_id);
        if ($exists) {
            $GioHang[$sanpham_id] = $GioHang[$sanpham_id] + $SoLuong;
            Session::put('GioHang', $GioHang);
            return true;
        }

        $GioHang[$sanpham_id] = $SoLuong;
        Session::put('GioHang', $GioHang);

        return true;
    }

    public function getSanPham()
    {
        $GioHang = Session::get('GioHang');
        if (is_null($GioHang)) return [];

        $sanpham_id = array_keys($GioHang);
        return SanPham::select('id', 'name', 'Gia', 'GiamGia', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $sanpham_id)
            ->get();
    }
    public function getPhuongThuc()
    {
        return PTThanhToan:: orderByDesc('id')->get();
    }
    public function update($request)
    {
        Session::put('GioHang', $request->input('SoLuong'));

        return true;
    }

    public function remove($id)
    {
        $GioHang = Session::get('GioHang');
        unset($GioHang[$id]);

        Session::put('GioHang', $GioHang);
        return true;
    }
    
    public function taoDonHang($request)
    {
        try {
            $data = (String)$request->input('CodeApDung');
            $coupon = MaGiamGia::where('Code', $data)->first();
            if ($coupon) {
                if((!is_null($coupon->SLGioiHan))
                    && ( $coupon->SLGioiHan<= $coupon->SLSuDung)){

                
                // Tăng số lần sử dụng lên 1
                Session::flash('error', 'Mã giảm giá đã hết!');
                return false;

                }
                
            
                else{
                    NguoiDung_MaGiamGia::create([
                        'NguoiDung_id' => (int)Auth::id(),
                        'MaGiamGia_id' => (int)$coupon->id
                    ]);
                    $coupon->increment('SLSuDung');
                }
            }
            

            DB::beginTransaction();

            $GioHang = Session::get('GioHang');

            if (is_null($GioHang))
                return false;
            
            $donhang = DonHang::create([
                'user_id' => (int)Auth::id(),
                'pttt_id' => (int)$request->input('pttt_id'),
                'TenKH' => (string)$request->input('TenKH'),
                'DiaChiNhanHang' => (string)$request->input('DiaChiNhanHang'),
                'SDT' => (string)$request->input('SDT'),
                'GhiChu' => (string)$request->input('GhiChu'),
                'PhiShip' => (string)$request->input('PhiShip'),
                'TongTien' => (double)$request->input('TongTien'),
                'TTDonHang' => (string)'Đơn hàng đã đặt'
            ]);
            
            $sanpham_id = array_keys($GioHang);
            
            $giaSanPham = SanPham::select('id', 'Gia', 'GiamGia')
                     ->where('active', 1)
                     ->whereIn('id', $sanpham_id)
                     ->get()
                     ->keyBy('id'); // Tạo mảng với key là id của sản phẩm
          foreach ($sanpham_id as $id) {
            $gia = $giaSanPham[$id];
            $soLuongTrongGioHang = (int)$GioHang[$id];
            
            // Kiểm tra số lượng sản phẩm trong kho
            $sanPham = SanPham::find($id);
            if ($sanPham->SoLuong < $soLuongTrongGioHang) {
                DB::rollBack();
                Session::flash('error', 'Số lượng sản phẩm trong kho không đủ cho sản phẩm :' . $sanPham->name);
                return false;
            }

            // Tạo Chi tiết đơn hàng nếu số lượng hợp lệ
            if ($gia->GiamGia > 0) {
                ChiTietDonHang::create([
                    'donhang_id' => (int) $donhang->id,
                    'sanpham_id' =>  (int)$id,
                    'Gia' => (double)$gia->GiamGia,
                    'SoLuong' => $soLuongTrongGioHang
                ]);
            } else {
                ChiTietDonHang::create([
                    'donhang_id' => (int) $donhang->id,
                    'sanpham_id' =>  (int)$id,
                    'Gia' => (double)$gia->Gia,
                    'SoLuong' => $soLuongTrongGioHang
                ]);
            }
            // Cập nhật số lượng sản phẩm trong kho
            $sanPham->SoLuong -= $soLuongTrongGioHang;
            $sanPham->save();
}

            // $this->infoProductCart($GioHang, $donhang->id);

            DB::commit();
            Session::flash('success', 'Đặt Hàng Thành Công');

            
            $this->send_mail($donhang);

            Session::forget('coupon');
            Session::forget('GioHang');
            

        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', 'Đặt Hàng Lỗi, Vui lòng thử lại sau');
            return false;
        }

        return true;
    }
    public function send_mail($donhang)
    {
        // Lấy thông tin người nhận email từ đơn hàng
        $user = Auth::user();
        $khachhang = $user->name;
        $email = $user->email;

        // Dữ liệu truyền vào email
        $data = [
            "khachhang" => $khachhang,
            "noidung" => "Cảm ơn bạn đã đặt hàng của chúng tôi!",
            "donhang_id" =>$donhang->id,
            "chitietdonhang" => $donhang->ChiTietDonHang()->with(['SanPham' => function ($query) {
                $query->select('id', 'name', 'thumb');
            }])->get(),
            "TongTien" => $donhang->TongTien
        ];

        try {
            // Thực hiện gửi email
            Mail::send('mail.success', $data, function($message) use ($khachhang, $email) {
                $message->to($email)->subject('Xác nhận đơn hàng của bạn');
                $message->from('support@TwiShop.com', 'Đồ chơi TwiShop');
            });
            Session::flash('mail_status', 'Email xác nhận đã được gửi thành công!');
        } catch (\Exception $e) {
            // Xử lý lỗi nếu gửi email thất bại
            Log::error('Lỗi khi gửi email xác nhận đơn hàng: ' . $e->getMessage());
            Session::flash('mail_status', 'Không thể gửi email xác nhận đơn hàng. Vui lòng kiểm tra lại địa chỉ email.');
        }
    }

    protected function infoProductCart($GioHang, $donhang_id)
    {
        $sanpham_id = array_keys($GioHang);
        $sanphams = SanPham::select('id', 'name', 'Gia', 'GiamGia', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $sanpham_id)
            ->get();

        $data = [];
        foreach ($sanphams as $sanpham) {
            $data[] = [
                'donhang_id' => $donhang_id,
                'product_id' => $sanpham->id,
                'pty'   => $GioHang[$sanpham->id],
                'price' => $sanpham->price_sale != 0 ? $sanpham->price_sale : $sanpham->price
            ];
        }

        return DonHang::insert($data);
    }

    public function getDonHang()
    {
        return DonHang::orderByDesc('id')->paginate(15);
    }

    public function getProductForCart($customer)
    {
        return $customer->carts()->with(['product' => function ($query) {
            $query->select('id', 'name', 'thumb');
        }])->get();
    }
}
