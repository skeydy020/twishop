<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Thuonghieu\ThuonghieuService;
use App\Http\Services\User\UserService;
use Illuminate\Http\Request;
use App\Models\ThuongHieu;
use Illuminate\Support\Facades\Auth;

class ThuonghieuController extends Controller
{
    protected $thuonghieu;
    protected $userService;
    
    public function __construct(ThuonghieuService $thuonghieu,UserService $userService)
    {
        $this->thuonghieu = $thuonghieu;
        $this->userService = $userService;
    }

    public function create()
    {   
        if( $this->userService->CoQuyen()){
        return view('admin.thuonghieu.add', [
           'title' => 'Thêm thương hiệu mới'
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
            'thumb' => 'required',
        ]);

        $this->thuonghieu->insert($request);

        return redirect('/admin/thuonghieus/list');
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function index()
    {      
        if( $this->userService->CoQuyen()){
        return view('admin.thuonghieu.list', [
            'title' => 'Danh Sách Thương Hiệu Mới Nhất',
            'thuonghieus' => $this->thuonghieu->get()
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
        
    }

    public function show(Thuonghieu $thuonghieu)
    {     
        if( $this->userService->CoQuyen()){
        return view('admin.thuonghieu.edit', [
            'title' => 'Chỉnh Sửa thuonghieu: ' . $thuonghieu->name,
            'thuonghieu' => $thuonghieu
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
       
    }

    public function update(Request $request, Thuonghieu $thuonghieu)
    {   
        if( $this->userService->CoQuyen()){
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
        ]);

        $result = $this->thuonghieu->update($request, $thuonghieu);
        if ($result) {
            return redirect('/admin/thuonghieus/list');
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
        $result = $this->thuonghieu->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công thuonghieu'
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
