<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\TinTuc\TinTucService;
use App\Http\Services\User\UserService;
use Illuminate\Http\Request;
use App\Models\TinTuc;
use Illuminate\Support\Facades\Auth;

class TinTucController extends Controller
{
    protected $tintucService;
    protected $userService;
    
   
    public function __construct(TinTucService $tintucService,UserService $userService)
    {
        $this->tintucService = $tintucService;
        $this->userService = $userService;
    }

    public function create()
    {   
        if( $this->userService->CoQuyen()){
        return view('admin.tintuc.add', [
           'title' => 'Thêm tin mới',
           'danhmuctins' => $this->tintucService->getDMTinTuc()
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
            'danhmuc_id' => 'required',
            'name' => 'required',
            'thumb' => 'required',
            'description' => 'required',
            'content' => 'required',
        ]);

        $this->tintucService->insert($request);

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
        return view('admin.tintuc.list', [
            'title' => 'Danh Sách tin tức ',
            'tintucs' => $this->tintucService->get(),

        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
        
    }

    public function show(TinTuc $tintuc)
    {     
        if( $this->userService->CoQuyen()){
        return view('admin.tintuc.edit', [
            'title' => 'Chỉnh Sửa tin tức: ' . $tintuc->name,
            'tintuc' => $tintuc,
            'danhmuctins' => $this->tintucService->getDMTinTuc()
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
       
    }

    public function update(Request $request, TinTuc $tintuc)
    {
        if( $this->userService->CoQuyen()){
        $this->validate($request, [
            'danhmuc_id' => 'required',
            'name' => 'required',
            'thumb' => 'required',
            'description' => 'required',
            'content' => 'required',
        ]);

        $result = $this->tintucService->update($request, $tintuc);
        if ($result) {
            return redirect('/admin/tintucs/list');
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
        $result = $this->tintucService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công tin tức'
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
