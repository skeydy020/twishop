<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\DoTuoi\DoTuoiService;
use App\Http\Services\User\UserService;
use Illuminate\Http\Request;
use App\Models\Dot;
use App\Models\DoTuoi;
use Illuminate\Support\Facades\Auth;

class DoTuoiController extends Controller
{
    protected $dotuoi;
    protected $userService;
    
    public function __construct(DoTuoiService $dotuoi,UserService $userService)
    {
        $this->dotuoi = $dotuoi;
        $this->userService = $userService;
    }

    public function create()
    {   
        if( $this->userService->CoQuyen()){
        return view('admin.dotuoi.add', [
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

        $this->dotuoi->insert($request);

        return redirect('/admin/dotuois/list');
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function index()
    {      
        if( $this->userService->CoQuyen()){
        return view('admin.dotuoi.list', [
            'title' => 'Danh Sách Thương Hiệu Mới Nhất',
            'dotuois' => $this->dotuoi->get()
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);} 
        
    }

    public function show(DoTuoi $dotuoi)
    {     
        if( $this->userService->CoQuyen()){
        return view('admin.dotuoi.edit', [
            'title' => 'Chỉnh Sửa độ tuổi: ' ,
            'dotuoi' => $dotuoi
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
       
    }

    public function update(Request $request, DoTuoi $dotuoi)
    {   
        if( $this->userService->CoQuyen()){
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
        ]);

        $result = $this->dotuoi->update($request, $dotuoi);
        if ($result) {
            return redirect('/admin/dotuois/list');
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
        $result = $this->dotuoi->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công dotuoi'
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
