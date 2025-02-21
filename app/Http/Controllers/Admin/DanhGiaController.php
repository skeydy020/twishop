<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\DanhGia\DanhGiaService;
use App\Http\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DanhGiaController extends Controller
{
    protected $danhgia;
    protected $userService;


    public function __construct(DanhGiaService $danhgia, UserService $userService)
    {
        $this->danhgia = $danhgia;
        $this->userService = $userService;
    }
    public function index()
    {      
        if($this->userService->CoQuyen()){
        return view('admin.danhgia.list', [
            'title' => 'Quản lý đánh giá',
            'danhgias' => $this->danhgia->get()
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function search(Request $request)
    {    
        if($this->userService->CoQuyen()){
            return view('admin.danhgia.list', [
                'title' => 'Danh Sách Sản Phẩm',
                'danhgias' => $this->danhgia->getSearch($request)
            ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    // public function destroy(Request $request)
    // {
    //     $result = $this->danhgia->destroy($request);
    //     if ($result) {
    //         return response()->json([
    //             'error' => false,
    //             'message' => 'Xóa thành công đánh giá'
    //         ]);
    //     }

    //     return response()->json([ 'error' => true ]);
    // }
}