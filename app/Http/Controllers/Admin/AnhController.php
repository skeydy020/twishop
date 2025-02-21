<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Anh\AnhService;
use App\Http\Services\User\UserService;
use App\Models\SanPham;
use Illuminate\Http\Request;
use App\Models\ThuVienAnh;
use Illuminate\Support\Facades\Auth;

class AnhController extends Controller
{
    protected $anhService;
    protected $userService;
   
    public function __construct(AnhService $anhService,UserService $userService)
    {
        $this->anhService = $anhService;
        $this->userService = $userService;
    }

    public function create()
    {   
        if( $this->userService->CoQuyen()){
        return view('admin.anh.add', [
           'title' => 'Thêm ảnh mới',
           'sanphams' => $this->anhService->getSanPham()
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
            'sanpham_id' => 'required',
            'thumb' => 'required',
        ]);

        $this->anhService->insert($request);

        return redirect('/admin/anhs/list');
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }
    public function store2(Request $request,SanPham $sanpham)
    {   
        if( $this->userService->CoQuyen()){
        $this->validate($request, [
            'thumb' => 'required',
        ]);

        $this->anhService->insert2($request,$sanpham);

        return redirect()->back();
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function index()
    {      
        if( $this->userService->CoQuyen()){
        return view('admin.anh.list', [
            'title' => 'Danh Sách ảnh ',
            'anhs' => $this->anhService->get()
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
        
    }
    public function sanpham(SanPham $sanpham)
    {      
        if( $this->userService->CoQuyen()){
        return view('admin.anh.list2', [
            'title' => 'Danh Sách ảnh '. $sanpham->name,
            'anhs' => $this->anhService->getanh($sanpham),
            'id' => $sanpham->id
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
        
    }


    public function show(ThuVienAnh $anh)
    {     
        if( $this->userService->CoQuyen()){
        return view('admin.anh.edit', [
            'title' => 'Chỉnh Sửa : ' . $anh->name,
            'anh' => $anh
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
       
    }

    public function update(Request $request, ThuVienAnh $anh)
    {   
        if( $this->userService->CoQuyen()){
        $this->validate($request, [
            'sanpham_id' => 'required',
            'thumb' => 'required',
        ]);

        $result = $this->anhService->update($request, $anh);
        if ($result) {
            return redirect('/admin/anhs/list');
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
        if( $this->userService->CoQuyen()){
        $result = $this->anhService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công ảnh'
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
