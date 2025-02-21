<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\MaGiamGia\MaGiamGiaService;
use App\Http\Services\User\UserService;
use App\Models\MaGiamGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaGiamGiaController extends Controller
{
    protected $magiamgiaService;
    protected $userService;
    
    
    public function __construct(MaGiamGiaService $magiamgiaService,UserService $userService)
    {
        $this->magiamgiaService = $magiamgiaService;
        $this->userService = $userService;
    }

    public function create()
    {   if( $this->userService->isAdmin()){
        return view('admin.magiamgia.add', [
           'title' => 'Thêm mã giảm giá mới'
        ]);
        }
        else{
            return redirect()->route('admin')->with('error','Bạn không có quyền để thực hiện chức năng này');
        }
    }

    public function store(Request $request)
    {
        if( $this->userService->isAdmin()){
        $this->validate($request, [
            'Code' => 'required',
        ]);

        $this->magiamgiaService->insert($request);

        return redirect('/admin/magiamgias/list');
        }
        else{
            return redirect()->route('admin')->with('error','Bạn không có quyền để thực hiện chức năng này');
        }
    }

    public function index()
    {      
        if( $this->userService->isAdmin()){
        return view('admin.magiamgia.list', [
            'title' => 'Danh Sách Mã Giảm Giá Mới Nhất',
            'magiamgias' => $this->magiamgiaService->get()
        ]);
        }
        else{
            return redirect()->route('admin')->with('error','Bạn không có quyền để thực hiện chức năng này');
        }
            
    }
    public function lichsu()
    {      
        if( $this->userService->isAdmin()){
        return view('admin.magiamgia.lichsu', [
            'title' => 'Danh Sách Dùng Mã Giảm Giá',
            'lichsus' => $this->magiamgiaService->getlichsu()
        ]);
    }
    else{
        return redirect()->route('admin')->with('error','Bạn không có quyền để thực hiện chức năng này');
    }
        
    }
    public function show(MaGiamGia $magiamgia)
    {     
        if( $this->userService->isAdmin()){
        return view('admin.magiamgia.edit', [
            'title' => 'Chỉnh Sửa thuonghieu: ' . $magiamgia->name,
            'magiamgia' => $magiamgia
        ]);
    }
    else{
        return redirect()->route('admin')->with('error','Bạn không có quyền để thực hiện chức năng này');
    }
       
    }

    public function update(Request $request, MaGiamGia $magiamgia)
    {
        if( $this->userService->isAdmin()){
        $this->validate($request, [
            'Code' => 'required',
        ]);

        $result = $this->magiamgiaService->update($request, $magiamgia);
        if ($result) {
            return redirect('/admin/magiamgias/list');
        }

        return redirect()->back();
        }
        else{
            return redirect()->route('admin')->with('error','Bạn không có quyền để thực hiện chức năng này');
        }
    }

    public function destroy(Request $request)
    {
        if( $this->userService->isAdmin()){
        $result = $this->magiamgiaService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công mã giảm giá'
            ]);
        }

        return response()->json([ 'error' => true ]);
        }
        else{
            return redirect()->route('admin')->with('error','Bạn không có quyền để thực hiện chức năng này');
        }
    }

    public function destroylichsu(Request $request)
    {
        if( $this->userService->isAdmin()){
        $result = $this->magiamgiaService->destroylichsu($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công!'
            ]);
        }

        return response()->json([ 'error' => true ]);
        }
        else{
            return redirect()->route('admin')->with('error','Bạn không có quyền để thực hiện chức năng này');
        }
    }
}
