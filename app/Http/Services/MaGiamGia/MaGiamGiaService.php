<?php

namespace App\Http\Services\MaGiamGia;

use App\Models\MaGiamGia;
use App\Models\NguoiDung_MaGiamGia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MaGiamGiaService
{
    public function insert($request)
    {
        try {
            #$request->except('_token');
            MaGiamGia::create($request->input());
            Session::flash('success', 'Thêm mới thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm LỖI');
            Log::info($err->getMessage());

            return false;
        }

        return true;
    }

    public function get()
    {
        return MaGiamGia::orderByDesc('updated_at')->paginate(15);
    }
    public function getlichsu()
    {
        return NguoiDung_MaGiamGia::with('NguoiDung','MaGiamGia')->orderByDesc('updated_at')->paginate(15);
    }

    public function getAll()
    {
        return MaGiamGia::orderBy(column: 'name')->get();
    }

    public function update($request, $slider)
    {
        try {
            $slider->fill($request->input());
            $slider->save();
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
        $magiamgia = MaGiamGia::where('id', $request->input('id'))->first();
        if ($magiamgia) {
            $magiamgia->delete();
            return true;
        }

        return false;
    }
    public function destroylichsu($request)
    {
        $magiamgia = NguoiDung_MaGiamGia::where('id', $request->input('id'))->first();
        if ($magiamgia) {
            $magiamgia->delete();
            return true;
        }

        return false;
    }
    public function show()
    {
        return MaGiamGia::where('KichHoat', 1)->get();
    }
}