<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\GioiTinh\GioiTinhService;
use App\Http\Services\User\UserService;
use Illuminate\Http\Request;
use App\Models\GioiTinh;
use Illuminate\Support\Facades\Auth;

class GioiTinhController extends Controller
{
    protected $gioitinh;
    protected $userService;
    
    
    public function __construct(GioiTinhService $gioitinh,UserService $userService)
    {
        $this->gioitinh = $gioitinh;
        $this->userService = $userService;
    }

    public function create()
    {   
        if( $this->userService->CoQuyen()){
        return view('admin.gioitinh.add', [
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
        ]);

        $this->gioitinh->insert($request);

        return redirect('/admin/gioitinhs/list');
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function index()
    {      
        if( $this->userService->CoQuyen()){
        return view('admin.gioitinh.list', [
            'title' => 'Danh Sách Thương Hiệu Mới Nhất',
            'gioitinhs' => $this->gioitinh->get()
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
        
    }

    public function show(GioiTinh $gioitinh)
    {     
        if( $this->userService->CoQuyen()){
        return view('admin.gioitinh.edit', [
            'title' => 'Chỉnh Sửa gioitinh: ' . $gioitinh->name,
            'gioitinh' => $gioitinh
        ]);
        
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
       
    }

    public function update(Request $request, GioiTinh $gioitinh)
    {   
        if( $this->userService->CoQuyen()){
        $this->validate($request, [
            'name' => 'required',
        ]);

        $result = $this->gioitinh->update($request, $gioitinh);
        if ($result) {
            return redirect('/admin/gioitinhs/list');
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
        $result = $this->gioitinh->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công gioitinh'
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
