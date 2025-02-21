<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\DanhMucTin\DanhMucTinService;
use App\Http\Services\User\UserService;
use Illuminate\Http\Request;
use App\Models\Dot;
use App\Models\DanhMucTinTuc;
use Illuminate\Support\Facades\Auth;

class DanhMucTinController extends Controller
{
    protected $danhMucTinService;
    protected $userService;
    
    
    public function __construct(DanhMucTinService $danhMucTinService,UserService $userService)
    {
        $this->danhMucTinService = $danhMucTinService;
        $this->userService = $userService;
    }

    public function create()
    {   
        if( $this->userService->CoQuyen()){
        return view('admin.danhmuctintuc.add', [
           'title' => 'Thêm danh mục tin tức mới'
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function store(Request $request)
    {
        if( $this->userService->CoQuyen()){
        $this->validate($request, [
            'name' => 'required',
        ]);

        $this->danhMucTinService->insert($request);

        return redirect('/admin/danhmuctins/list');
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function index()
    {      
        if( $this->userService->CoQuyen()){
        return view('admin.danhmuctintuc.list', [
            'title' => 'Danh Sách Danh Mục Mới Nhất',
            'danhmuctins' => $this->danhMucTinService->get()
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
        
    }

    public function show(DanhMucTinTuc $danhmuctin)
    {     
        if( $this->userService->CoQuyen()){
        return view('admin.danhmuctintuc.edit', [
            'title' => 'Chỉnh Sửa Danh Mục: ' ,
            'danhmuctin' => $danhmuctin
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
       
    }

    public function update(Request $request, DanhMucTinTuc $danhmuctin)
    {
        if( $this->userService->CoQuyen()){
        $this->validate($request, [
            'name' => 'required',
        ]);

        $result = $this->danhMucTinService->update($request, $danhmuctin);
        if ($result) {
            return redirect('/admin/danhmuctins/list');
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
        $result = $this->danhMucTinService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công danh mục tin'
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
