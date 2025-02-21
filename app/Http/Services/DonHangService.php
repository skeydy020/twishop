<?php


namespace App\Http\Services;


use App\Jobs\SendMail;
use App\Models\Cart;
use App\Models\ChiTietDonHang;
use App\Models\DonHang;
use App\Models\PTThanhToan;
use App\Models\SanPham;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DonHangService
{       
    public function taoDonHang($request)
    {
        try {
            DB::beginTransaction();

            $GioHang = Session::get('GioHang');

            if (is_null($GioHang))
                return false;

            $donhang = DonHang::create([
                'user_id' => Auth::id(),
                'pttt_id' => $request->input('pttt_id'),
                'TenKH' => $request->input('TenKH'),
                'DiaChiNhanHang' => $request->input('DiaChiNhanHang'),
                'SDT' => $request->input('SDT'),
                'GhiChu' => $request->input('GhiChu'),
                'TongTien' => $request->input('TongTien')
            ]);
            
            $sanpham_id = array_keys($GioHang);

            foreach ($sanpham_id as $id) {
                $gia = SanPham::select('Gia', 'GiamGia')
                ->where('active', 1)
                ->where('id', $id)
                ->first();
                ChiTietDonHang::create([
                    'donhang_id' => $donhang->id,
                    'sanpham_id' => $id,
                    'Gia' => $gia,
                    'SoLuong' => $GioHang[$id]
                ]);
            }
            // $this->infoProductCart($GioHang, $donhang->id);

            DB::commit();
            Session::flash('success', 'Đặt Hàng Thành Công');

            
         
        } catch (\Exception $err) {
            DB::rollBack();
            Session::flash('error', 'Đặt Hàng Lỗi, Vui lòng thử lại sau');
            return false;
        }

        return true;
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
        return DonHang::with('NguoiDung','PTTT')->
        orderByDesc('id')->paginate(15);
    }
    public function getDonHangnguoidung($id)
    {
        return DonHang::where('user_id',$id)->
        orderByDesc('id')->get();
    }
    public function getProductForCart($donhang)
    {
        return $donhang->ChiTietDonHang()->with(['SanPham' => function ($query) {
            $query->select('id', 'name', 'thumb');
        }])->get();
    }
    public function update($request, $donhang)
{
    try {
        $request->except('_token');
        $ttdonhang = (string)$request->input('TTDonHang');

        if ($ttdonhang === 'Đã giao hàng xong') {
            // Lấy chi tiết các sản phẩm trong đơn hàng
            $chiTietDonHang = ChiTietDonHang::where('donhang_id', $donhang->id)->get();

            foreach ($chiTietDonHang as $chiTiet) {
                $sanPham = SanPham::find($chiTiet->sanpham_id);
                
                if ($sanPham) {
                    // Cập nhật số lượng sản phẩm đã bán
                    $sanPham->DaBan += $chiTiet->SoLuong;
                    $sanPham->save();
                }
            }
        }
        elseif ($ttdonhang === 'Đơn hàng đã huỷ') {
            // Lấy chi tiết các sản phẩm trong đơn hàng
            $chiTietDonHang = ChiTietDonHang::where('donhang_id', $donhang->id)->get();

            foreach ($chiTietDonHang as $chiTiet) {
                $sanPham = SanPham::find($chiTiet->sanpham_id);
                
                if ($sanPham) {
                    // Cập nhật số lượng sản phẩm đã bán
                    $sanPham->SoLuong += $chiTiet->SoLuong;
                    $sanPham->save();
                }
            }
        }

        // Cập nhật trạng thái đơn hàng
        $donhang->update([
            'TTDonHang' => $ttdonhang
        ]);

        Session::flash('success', 'Cập nhật thành công');
    } catch (\Exception $err) {
        Session::flash('error', 'Cập nhật Lỗi');
        Log::info($err->getMessage());

        return false;
    }

    return true;
}
public function huydon($donhang)
{
    try {
        $chiTietDonHang = ChiTietDonHang::where('donhang_id', $donhang->id)->get();

        foreach ($chiTietDonHang as $chiTiet) {
            $sanPham = SanPham::find($chiTiet->sanpham_id);
            
            if ($sanPham) {
                // Cập nhật số lượng sản phẩm đã bán
                $sanPham->SoLuong += $chiTiet->SoLuong;
                $sanPham->save();
            }
        }
        $donhang->update([
            'TTDonHang' => 'Đơn hàng đã huỷ'
        ]);

        Session::flash('success', 'Cập nhật thành công');
    } catch (\Exception $err) {
        Session::flash('error', 'Cập nhật Lỗi');
        Log::info($err->getMessage());

        return false;
    }

    return true;
}

    public function delete($request)
    {
        $donhang = DonHang::where('id', $request->input('id'))->first();
        if ($donhang->TTDonHang === 'Đơn hàng đã huỷ') {
            $donhang->delete();
            return true;
        }
        
        return false;
    }
}
