<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\User\UserService;
use App\Http\Services\XuatXu\XuatXuService;
use Illuminate\Http\Request;
use App\Models\XuatXu;
use Illuminate\Support\Facades\Auth;

class XuatXuController extends Controller
{
    protected $xuatxu;
    protected $userService;
    
  
    public function __construct(XuatXuService $xuatxu,UserService $userService)
    {
        $this->xuatxu = $xuatxu;
        $this->userService = $userService;
    }

    public function create()
    {   
        if( $this->userService->CoQuyen()){
        return view('admin.xuatxu.add', [
           'title' => 'Thêm xuất xứ'
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
            'description' => 'required',
        ]);

        $this->xuatxu->insert($request);

        return redirect('/admin/xuatxus/list');
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function index()
    {      
        if( $this->userService->CoQuyen()){
        return view('admin.xuatxu.list', [
            'title' => 'Danh Sách Thương Hiệu Mới Nhất',
            'xuatxus' => $this->xuatxu->get()
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
        
    }

    public function show(XuatXu $xuatxu)
    {     
        if( $this->userService->CoQuyen()){
        return view('admin.xuatxu.edit', [
            'title' => 'Chỉnh Sửa xuất xứ: ' . $xuatxu->name,
            'xuatxu' => $xuatxu
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
       
    }

    public function update(Request $request, XuatXu $xuatxu)
    {
        if( $this->userService->CoQuyen()){
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $result = $this->xuatxu->update($request, $xuatxu);
        if ($result) {
            return redirect('/admin/xuatxus/list');
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
        $result = $this->xuatxu->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công!'
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
