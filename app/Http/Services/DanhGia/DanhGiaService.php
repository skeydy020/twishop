<?php

namespace App\Http\Services\DanhGia;


use App\Models\DanhGia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DanhGiaService
{

    public function get()
    {
        return DanhGia::with('ChiTietDonHang')
            ->orderByDesc('id')->paginate( 12);
    }

    public function insert($request)
    {
        try {
            DanhGia::create($request->input());
            Session::flash('success', 'Thêm mới thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm LỖI');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }


    public function getSearch($request)
    {   
        $productName = (String)$request->input('product_name');
        $customerName = (String)$request->input('customer_name');
        $numberStar = $request->input('rating');

        $result = DanhGia::query();

        if(!empty(trim($productName))){
            $result = $result
            ->whereHas('ChiTietDonHang.SanPham', function($query) use ($productName) {
                $query->where('name', 'like', '%' . $productName . '%')
                ->orWhere('Code', 'like', '%' . $productName . '%');
            });
        }

        if(!empty(trim($customerName))){
            $result = $result
            ->whereHas('ChiTietDonHang.DonHang', function($query)  {
                
            })
            ->whereHas('ChiTietDonHang.DonHang.NguoiDung', function($query) use ($customerName) {
                $query->where('name', 'like', '%' . $customerName . '%');
            });
        }

        if($numberStar > 0){
            $result = $result->where('Number', $numberStar);
        }

        return $result->orderByDesc('id')->paginate(perPage: 8);


        // if($numberStar <= 0){
        //     return DanhGia::with('ChiTietDonHang')
        //     ->with('ChiTietDonHang.SanPham')
        //     ->whereHas('ChiTietDonHang.SanPham', function($query) use ($search) {
        //         $query->where('name', 'like', '%' . $search . '%')
        //         ->orWhere('Code', 'like', '%' . $search . '%');
        //     })
        //     ->orderByDesc('id')->paginate(perPage: 8);
        // }

        // return DanhGia::with('ChiTietDonHang')
        //     ->where('Number', $numberStar)
        //     ->with('ChiTietDonHang.SanPham')
        //     ->whereHas('ChiTietDonHang.SanPham', function($query) use ($search) {
        //         $query->where('name', 'like', '%' . $search . '%')
        //         ->orWhere('Code', 'like', '%' . $search . '%');
        //     })
        //     ->orderByDesc('id')->paginate(perPage: 8);
    }


    // public function destroy($request)
    // {
    //     $rate = DanhGia::where('id', $request->input('id'))->first();
    //     if ($rate) {
       
    //         $rate->delete();
    //         return true;
    //     }

    //     return false;
    // }
}