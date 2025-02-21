<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Slider\SliderService;
use App\Http\Services\User\UserService;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    protected $slider;
    protected $userService;
    
    
    public function __construct(SliderService $slider,UserService $userService)
    {
        $this->slider = $slider;
        $this->userService = $userService;
    }

    public function create()
    {   
        if( $this->userService->isAdmin()){
        return view('admin.slider.add', [
           'title' => 'Thêm SLider mới'
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
            'name' => 'required',
            'thumb' => 'required',
            'url'   => 'required'
        ]);

        $this->slider->insert($request);

        return redirect()->back();
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function index()
    {      
        if( $this->userService->isAdmin()){
        return view('admin.slider.list', [
            'title' => 'Danh Sách Slider Mới Nhất',
            'sliders' => $this->slider->get()
        ]);
    }
    else{
        return redirect()->route('admin')->with('error','Bạn không có quyền để thực hiện chức năng này');
    }
        
    }

    public function show(Slider $slider)
    {     
        if( $this->userService->isAdmin()){
        return view('admin.slider.edit', [
            'title' => 'Chỉnh Sửa Slider: ' . $slider->name,
            'slider' => $slider
        ]);
        
    }
    else{
        return redirect()->route('admin')->with('error','Bạn không có quyền để thực hiện chức năng này');
    }
    }

    public function update(Request $request, Slider $slider)
    {
        if( $this->userService->isAdmin()){
        $this->validate($request, [
            'name' => 'required',
            'thumb' => 'required',
            'url'   => 'required'
        ]);

        $result = $this->slider->update($request, $slider);
        if ($result) {
            return redirect('/admin/sliders/list');
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
        $result = $this->slider->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công Slider'
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
