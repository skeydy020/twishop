<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\User\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create()
    {   if( $this->userService->isAdmin()){
        return view('admin.user.add', [
           'title' => 'Thêm người dùng mới'
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
        ]);

        $this->userService->insert($request);

        return redirect('/admin/users/list');
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function index()
    {    
        if( $this->userService->isAdmin()){
        return view('admin.user.list', [
            'title' => 'Danh Sách Người Dùng',
            'users' => $this->userService->get()
        ]);
        
    }
        else{
            return redirect()->route('admin')->with('error','Bạn không có quyền để thực hiện chức năng này');
        }
        
    }

    public function show(User $user)
    {     
        if( $this->userService->isAdmin()){
        
        return view('admin.user.edit', [
            'title' => 'Chỉnh Sửa Danh Mục: ' ,
            'user' => $user
        ]);
        }
        else{
            return redirect()->route('admin')->with('error','Bạn không có quyền để thực hiện chức năng này');
        }
       
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $result = $this->userService->update($request, $user);
        if ($result) {
            return redirect('/admin/users/list');
        }

        return redirect()->back();
    }
    public function showquyen(User $user)
    {     
        if( $this->userService->isAdmin()){
        return view('admin.user.editquyen', [
            'title' => 'Chỉnh Sửa Quyền: ' ,
            'quyens' => $this->userService->getRole(),
            'user' => $user
        ]);
        }
        else{
            return redirect()->route('admin')->with('error','Bạn không có quyền để thực hiện chức năng này');
        }
        
    }

    public function updatequyen(Request $request, User $user)
    {
        if( $this->userService->isAdmin()){
        $result = $this->userService->update($request, $user);
        if ($result) {
            return redirect('/admin/users/list');
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

        $result = $this->userService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công người dùng!'
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
