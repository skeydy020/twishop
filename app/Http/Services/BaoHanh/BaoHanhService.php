<?php

namespace App\Http\Services\BaoHanh;

use App\Models\BaoHanh;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BaoHanhService
{   
    public function get($chitietdonhang_id)
    {
        return BaoHanh::where('chitietdonhang_id', $chitietdonhang_id)->first();
    }

    public function getAll()
    {
        return BaoHanh::query()
                    ->whereHas('ChiTietDonHang', function($query)  {
                    })
                    ->whereHas('ChiTietDonHang.SanPham', function($query)  {
                    })
                    ->whereHas('ChiTietDonHang.DonHang', function($query)  {
                        
                    })
                    ->whereHas('ChiTietDonHang.DonHang.NguoiDung', function($query)  {
                    })
                    ->orderByDesc('created_at')
                    ->paginate(8);
    }

    public static function isbaohanh($chitietdonhangid){
        return BaoHanh::where('chitietdonhang_id', $chitietdonhangid)
                ->exists();
    }
    
    public function insert($request)
    {
        try {
            BaoHanh::create($request->input());
            Session::flash('success', 'Gửi yêu thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Gửi yêu thất bại');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }
    public function update($request, $baohanh)
    {
        try {
            $baohanh->fill($request->input());
            $baohanh->save();
            Session::flash('success', 'Cập nhật thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật Lỗi');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }

    public function destroy($request)
    {
        $baohanh = BaoHanh::where('id', $request->input('id'))->first();
        if ($baohanh) {
            $baohanh->delete();
            return true;
        }

        return false;
    }

    // public function update($request, $anh)
    // {
    //     try {
    //         $anh->fill($request->input());
    //         $anh->save();
    //         Session::flash('success', 'Cập nhật ảnh thành công');
    //     } catch (\Exception $err) {
    //         Session::flash('error', 'Cập nhật ảnh Lỗi');
    //         Log::info($err->getMessage());

    //         return false;
    //     }

    //     return true;
    // }

    // public function destroy($request)
    // {
    //     $anh = ThuVienAnh::where('id', $request->input('id'))->first();
    //     if ($anh) {
    //         $path = str_replace('storage', 'public', $anh->thumb);
    //         Storage::delete($path);
    //         $anh->delete();
    //         return true;
    //     }

    //     return false;
    // }
    // public function show($id)
    // {
    //     return ThuVienAnh::where('sanpham_id', $id)
    //         ->where('active', 1)->get();
    // }
   
}
