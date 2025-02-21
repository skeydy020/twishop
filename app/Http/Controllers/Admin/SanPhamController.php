<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SanPham\SanPhamRequest;
use App\Http\Services\SanPham\SanPhamService;
use App\Http\Services\User\UserService;
use App\Models\SanPham;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SanPhamController extends Controller
{
    protected $SanPhamService;
    protected $userService;
    
    
    public function __construct(SanPhamService $SanPhamService,UserService $userService)
    {
        $this->SanPhamService = $SanPhamService;
        $this->userService = $userService;
    }

    public function index()
    {    
        if( $this->userService->CoQuyen()){
        return view('admin.sanpham.list', [
            'title' => 'Danh Sách Sản Phẩm',
            'sanphams' => $this->SanPhamService->get(),
            'danhgia' => function($sanpham){
                return $this->SanPhamService->getdanhgia($sanpham);
            },
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
        
    }

    public function search(Request $request)
    {    
        if( $this->userService->CoQuyen()){
        return view('admin.sanpham.list', [
            'title' => 'Danh Sách Sản Phẩm',
            'sanphams' => $this->SanPhamService->getSearch($request)
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }
    public function create()
    {    
        if( $this->userService->CoQuyen()){
        return view('admin.sanpham.add', [
            'title' => 'Thêm sản phẩm Mới',
            'menus' => $this->SanPhamService->getMenu(),
            'dotuois' => $this->SanPhamService->getDoTuoi(),
            'xuatxus' => $this->SanPhamService->getXuatXu(),
            'gioitinhs' => $this->SanPhamService->getGioiTinh(),
            'thuonghieus' => $this->SanPhamService->getThuongHieu()
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }


    public function store(SanPhamRequest $request)
    {
        if( $this->userService->CoQuyen()){
        $this->SanPhamService->insert($request);

        return redirect()->back();
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function show(SanPham $sanpham)
    {   
        if( $this->userService->CoQuyen()){
        return view('admin.sanpham.edit', [
            'title' => 'Chỉnh Sửa Sản Phẩm: ' . $sanpham->name,
            'sanpham' => $sanpham,
            'menus' => $this->SanPhamService->getMenu(),
            'dotuois' => $this->SanPhamService->getDoTuoi(),
            'xuatxus' => $this->SanPhamService->getXuatXu(),
            'gioitinhs' => $this->SanPhamService->getGioiTinh(),
            'thuonghieus' => $this->SanPhamService->getThuongHieu()
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }


    public function update(Request $request, SanPham $sanpham)
    {   
        if( $this->userService->CoQuyen()){
        $result = $this->SanPhamService->update($request, $sanpham);
        if ($result) {
            return redirect('/admin/sanphams/list');
        }

        return redirect()->back();
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }


    public function destroy(Request $request)
    {   
        if( $this->userService->isAdmin()){
        $result = $this->SanPhamService->delete($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công sản phẩm'
            ]);
        }

        return response()->json([ 'error' => true ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }
}
